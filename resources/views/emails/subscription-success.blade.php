<!DOCTYPE html>
<html>
<head>
    <title>Thank You for Subscribing!</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px;">

    <!-- Logo -->
    <div style="margin-bottom: 20px;">
        <img src="https://www.socialadsdigital.com/assets/frontend/images/Social_Ads_Logo.png" alt="Company Logo" style="max-width: 150px;">
    </div>

    <h2>Hello {{ $name }},</h2>
    <p>Thank you for subscribing to our newsletter! 🎉</p>
    <p>You'll now receive the latest updates directly to <strong>{{ $email }}</strong>.</p>

    <p>Visit our website for more updates:</p>
    <p>
        <a href="{{ $website }}" style="display:inline-block; padding:10px 20px; background-color:#e600ff; border-color:#e600ff; color:white; text-decoration:none; border-radius:5px;">
            Go to Website
        </a>
    </p>

    <br>
    <p>Best regards,</p>
    <p>Social Ads Digital Marketing Team</p>
</body>
</html>
