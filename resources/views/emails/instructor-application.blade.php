<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Instructor Application</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div
        style="background: linear-gradient(135deg, #1d318dff 0%, #110a9eff 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 24px;">New Instructor Application</h1>
        <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0;">EduForge Online Education System</p>
    </div>

    <div style="background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px;">
        <p style="font-size: 16px; margin-bottom: 20px;">
            <strong>Dear Admin,</strong>
        </p>

        <p>A new instructor application has been received. Please review the details below:</p>

        <div
            style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #04317aff;">
            <h2 style="color: #04317aff; margin-top: 0; font-size: 18px;">Personal Information</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%;">Name:</td>
                    <td style="padding: 8px 0;">{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Email:</td>
                    <td style="padding: 8px 0;">{{ $data['email'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Phone:</td>
                    <td style="padding: 8px 0;">{{ $data['phone'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Country:</td>
                    <td style="padding: 8px 0;">{{ $data['country'] }}</td>
                </tr>
            </table>
        </div>

        <div
            style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #04317aff;">
            <h2 style="color: #04317aff; margin-top: 0; font-size: 18px;">Professional Information</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%;">Expertise:</td>
                    <td style="padding: 8px 0;">{{ $data['expertise'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Experience:</td>
                    <td style="padding: 8px 0;">{{ $data['experience'] }} years</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; vertical-align: top;">Motivation:</td>
                    <td style="padding: 8px 0;">{{ $data['motivation'] }}</td>
                </tr>
                @if(!empty($data['bio']))
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; vertical-align: top;">Bio:</td>
                        <td style="padding: 8px 0;">{{ $data['bio'] }}</td>
                    </tr>
                @endif
            </table>
        </div>

        @if(!empty($data['linkedin']) || !empty($data['portfolio']))
            <div
                style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #04317aff;">
                <h2 style="color: #04317aff; margin-top: 0; font-size: 18px;">Links</h2>
                <table style="width: 100%; border-collapse: collapse;">
                    @if(!empty($data['linkedin']))
                        <tr>
                            <td style="padding: 8px 0; font-weight: bold; width: 40%;">LinkedIn:</td>
                            <td style="padding: 8px 0;"><a href="{{ $data['linkedin'] }}"
                                    style="color: #04317aff;">{{ $data['linkedin'] }}</a></td>
                        </tr>
                    @endif
                    @if(!empty($data['portfolio']))
                        <tr>
                            <td style="padding: 8px 0; font-weight: bold;">Portfolio:</td>
                            <td style="padding: 8px 0;"><a href="{{ $data['portfolio'] }}"
                                    style="color: #04317aff;">{{ $data['portfolio'] }}</a></td>
                        </tr>
                    @endif
                </table>
            </div>
        @endif

        <div
            style="background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107;">
            <p style="margin: 0; color: #856404;">
                <strong>📎 CV/Resume:</strong> The applicant's CV has been attached to this email.
            </p>
        </div>

        <p style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #e2e8f0; color: #64748b; font-size: 14px;">
            <strong>Next Steps:</strong><br>
            1. Review the application and attached CV<br>
            2. If approved, add the instructor from the Admin Panel<br>
            3. The system will send login credentials to the instructor's email
        </p>

        <div style="text-align: center; margin-top: 30px;">
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                This is an automated email from EduForge Online Education System
            </p>
        </div>
    </div>
</body>

</html>