<!DOCTYPE html>
<html>

<head>
    <title>Contact Form Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            color: #007bff;
        }

        .message-box {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        <div class="content">
            <div class="info-row">
                <span class="label">Name:</span> {{ $name }}
            </div>
            <div class="info-row">
                <span class="label">Email:</span> {{ $email }}
            </div>
            <div class="info-row">
                <span class="label">Subject:</span> {{ $subject }}
            </div>
            <div class="message-box">
                <div class="label">Message:</div>
                <p>{{ $messageContent }}</p>
            </div>
        </div>
    </div>
</body>

</html>