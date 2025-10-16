<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Support\Facades\Log;

class RepairPaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Usage: php artisan payments:repair {txnid} {--courses=}
     */
    protected $signature = 'payments:repair {txnid} {--courses=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repair a payment by creating missing PaymentItem and Enrollment records for a txnid. Optionally provide comma-separated course IDs.';

    public function handle()
    {
        $txnid = $this->argument('txnid');
        $coursesOpt = $this->option('courses');

        $this->info("Looking up payment with txnid: {$txnid}");

        $payment = Payment::where('txnid', $txnid)->first();

        if (!$payment) {
            $this->error('Payment not found.');
            return 1;
        }

        $courseIds = [];

        if ($coursesOpt) {
            $parts = preg_split('/[,|;\s]+/', $coursesOpt);
            $courseIds = array_map('intval', array_filter($parts));
        } else {
            // try to read from payment items or fallback to stored value or logs
            $this->info('No courses provided. Attempting to infer from payment items or other fields.');
            if ($payment->items()->exists()) {
                $courseIds = $payment->items()->pluck('course_id')->toArray();
            } else {
                $this->info('No items attached to payment. Attempting to extract course IDs from logs.');

                $logPath = storage_path('logs/laravel.log');
                if (file_exists($logPath)) {
                    $contents = file_get_contents($logPath);

                    // Find occurrences of the txnid and look for value_c in the same JSON payload
                    $pattern = '/' . preg_quote($txnid, '/') . '[^\n\r]{0,800}/s';
                    if (preg_match_all($pattern, $contents, $matches)) {
                        foreach ($matches[0] as $match) {
                            // try JSON-style "value_c":"[1,2]"
                            if (preg_match('/"value_c"\s*:\s*"([^"]+)"/', $match, $m2)) {
                                $valueC = html_entity_decode($m2[1]);
                                $valueC = urldecode($valueC);
                                $valueC = trim($valueC);
                                // parse JSON array
                                if (str_starts_with($valueC, '[') && str_ends_with($valueC, ']')) {
                                    $decoded = json_decode($valueC, true);
                                    if (is_array($decoded)) {
                                        $courseIds = array_map('intval', $decoded);
                                        break;
                                    }
                                } else {
                                    $parts = preg_split('/[,|;\s]+/', $valueC);
                                    $courseIds = array_map('intval', array_filter($parts));
                                    if (!empty($courseIds))
                                        break;
                                }
                            }

                            // try urlencoded body style value_c=%5B1%5D
                            if (preg_match('/value_c=([^&\s]+)/', $match, $m3)) {
                                $decoded = urldecode($m3[1]);
                                $decoded = trim($decoded);
                                if (str_starts_with($decoded, '[') && str_ends_with($decoded, ']')) {
                                    $arr = json_decode($decoded, true);
                                    if (is_array($arr)) {
                                        $courseIds = array_map('intval', $arr);
                                        break;
                                    }
                                } else {
                                    $parts = preg_split('/[,|;\s]+/', $decoded);
                                    $courseIds = array_map('intval', array_filter($parts));
                                    if (!empty($courseIds))
                                        break;
                                }
                            }
                        }
                    }
                } else {
                    $this->warn('Log file not found at ' . $logPath);
                }

                if (empty($courseIds)) {
                    $this->info('Could not infer course IDs from logs. Please provide --courses=1,2,3 to repair.');
                    return 1;
                }
            }
        }

        $createdItems = 0;
        $createdEnrollments = 0;

        foreach ($courseIds as $courseId) {
            $course = Course::find($courseId);
            if (!$course) {
                $this->warn("Course not found: {$courseId}. Skipping.");
                continue;
            }

            // Create PaymentItem if not exists
            $item = PaymentItem::firstOrCreate([
                'payment_id' => $payment->id,
                'course_id' => $course->id,
            ], [
                'price' => $course->price,
            ]);

            if ($item && $item->wasRecentlyCreated) {
                $createdItems++;
            }

            $enrollment = Enrollment::firstOrCreate([
                'student_id' => $payment->student_id,
                'course_id' => $course->id,
            ]);

            if ($enrollment && $enrollment->wasRecentlyCreated) {
                $createdEnrollments++;
            }
        }

        $this->info("Repair completed. Created items: {$createdItems}, enrollments: {$createdEnrollments}");
        Log::info('payments:repair executed', ['txnid' => $txnid, 'created_items' => $createdItems, 'created_enrollments' => $createdEnrollments]);

        return 0;
    }
}
