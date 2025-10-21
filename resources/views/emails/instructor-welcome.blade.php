<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EduForge</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f4f4f4;">
    <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div
            style="background: linear-gradient(135deg, #1d318dff 0%, #110a9eff 100%); padding: 40px 30px; text-align: center;">
            <div
                style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 20px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                <span style="font-size: 40px;">🎓</span>
            </div>
            <h1 style="color: white; margin: 0; font-size: 28px;">Welcome to EduForge!</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 16px;">You're now an instructor</p>
        </div>

        <!-- Body -->
        <div style="padding: 40px 30px;">
            <p style="font-size: 16px; margin-bottom: 20px;">
                <strong>Dear {{ $instructorName }},</strong>
            </p>

            <p style="font-size: 15px; line-height: 1.8; color: #555;">
                Congratulations! 🎉 Your application to become an instructor at <strong>EduForge Online Education
                    System</strong> has been approved. We're excited to have you join our community of expert educators!
            </p>

            <!-- Credentials Box -->
            <div
                style="background: #f8f9fa; border-left: 4px solid #04317aff; padding: 25px; border-radius: 8px; margin: 30px 0;">
                <h2 style="color: #04317aff; margin-top: 0; font-size: 18px; margin-bottom: 20px;">
                    🔐 Your Login Credentials
                </h2>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 10px 0; font-weight: bold; color: #333; width: 35%;">Email:</td>
                        <td
                            style="padding: 10px 0; color: #555; font-family: 'Courier New', monospace; background: white; padding: 8px 12px; border-radius: 4px;">
                            {{ $instructorEmail }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; font-weight: bold; color: #333;">Password:</td>
                        <td
                            style="padding: 10px 0; color: #04317aff; font-family: 'Courier New', monospace; font-weight: bold; font-size: 18px; background: white; padding: 8px 12px; border-radius: 4px;">
                            {{ $password }}</td>
                    </tr>
                </table>
            </div>

            <!-- Warning Box -->
            <div
                style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0; color: #856404; font-size: 14px;">
                    <strong>⚠️ Important:</strong> Please change your password after your first login for security
                    purposes.
                </p>
            </div>

            <!-- Login Button -->
            <div style="text-align: center; margin: 35px 0;">
                <a href="{{ $loginUrl }}"
                    style="display: inline-block; background: linear-gradient(135deg, #1d318dff 0%, #110a9eff 100%); color: white; padding: 15px 40px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 12px rgba(29, 49, 141, 0.3);">
                    Login to Your Account
                </a>
            </div>

            <!-- Next Steps -->
            <div
                style="background: white; border: 2px solid #e2e8f0; padding: 20px; border-radius: 8px; margin: 30px 0;">
                <h3 style="color: #04317aff; margin-top: 0; font-size: 16px; margin-bottom: 15px;">
                    📋 Next Steps:
                </h3>
                <ol style="margin: 0; padding-left: 20px; color: #555; line-height: 1.8;">
                    <li>Log in to your instructor panel using the credentials above</li>
                    <li>Complete your profile information</li>
                    <li>Create your first course and start teaching</li>
                    <li>Share your knowledge with thousands of eager learners</li>
                </ol>
            </div>

            <p style="font-size: 15px; line-height: 1.8; color: #555; margin-top: 30px;">
                If you have any questions or need assistance, please don't hesitate to reach out to our support team.
                We're here to help you succeed!
            </p>

            <p style="font-size: 15px; line-height: 1.8; color: #555; margin-top: 20px;">
                Best regards,<br>
                <strong>The EduForge Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #f8f9fa; padding: 25px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="color: #64748b; font-size: 13px; margin: 0 0 10px 0;">
                This email was sent from EduForge Online Education System
            </p>
            <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                © {{ date('Y') }} EduForge. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>