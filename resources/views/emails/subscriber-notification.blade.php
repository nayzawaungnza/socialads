<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Subscriber Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 0px;
            background-color: #f9f9f9;
            border:1px solid #120014;
            border-radius: 20px;
        }
        .header {
            background-color: #120014;
            padding: 20px;
            text-align: center;
            border-top-right-radius: 20px;
            border-top-left-radius: 20px;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        h2 {
            color: #e600ff;
        }
       
        .content {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
            background:#120014;
            border-bottom-right-radius: 20px;
            border-bottom-left-radius: 20px;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
            
        }
        th {
            background-color: #f5f5f5;
            width: 30%;
            color: #e600ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/frontend/images/Social_Ads_Logo.png') }}" alt="Social Ads Digital Myanmar Logo">
        </div>
        
        <div class="content">
            <h2>New Subscriber Notification</h2>
            <p>A new subscriber has been added to the system with the following details:</p>
            
            <table>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user->mobile ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
                <tr>
                    <th>Subscribed On</th>
                    <td>{{ $user->created_at->format('F d, Y H:i') }}</td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Social Ads Marketing Myanmar. All rights reserved.</p>
        </div>
    </div>
</body>
</html>