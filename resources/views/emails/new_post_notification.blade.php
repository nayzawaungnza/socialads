@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <title>New Post Publishing!</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px;">

    <!-- Logo -->
    <div style="margin-bottom: 20px;">
        <img src="https://www.socialadsdigital.com/assets/frontend/images/Social_Ads_Logo.png" 
             alt="Company Logo" style="max-width: 150px;">
    </div>

    <h2>Hello {{ $name ?? 'Subscriber' }},</h2>
    <p>Thank you for subscribing to our newsletter! 🎉</p>

    <!-- Post Title & Content -->
    <h2>{{ optional($post)->title }}</h2>
    <p>{{ Str::limit(optional($post)->content, 100) }}</p>

    <!-- Read More Button -->
    <p>
        <a href="{{ url('/blogs/' . optional($post)->slug) }}" 
           style="display:inline-block; padding:5px 15px; background-color:#e600ff; color:white; 
                 border-color:#e600ff; text-decoration:none; border-radius:5px;">
            Read More
        </a>
    </p>

    <p>Visit our website for more updates:</p>
    <p>
        <a href="{{ $website ?? '#' }}" 
           style="display:inline-block; padding:10px 20px; background-color:#e600ff; border-color:#e600ff; 
                  color:white; text-decoration:none; border-radius:5px;">
            Go to Website
        </a>
    </p>

    <br>
    <p>Best regards,</p>
    <p><strong>Social Ads Digital Marketing Team</strong></p>
</body>
</html>
