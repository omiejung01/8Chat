<?php
// This page typically doesn't need much PHP logic if it's purely a confirmation message.
// Supabase handles the actual email confirmation in the background when the user clicks the link.
// The primary goal of this page is to display a friendly message.

// However, if you want to verify the 'type=signup' in the URL or capture any tokens
// (though typically not needed for a simple confirmation message), you could:
$type = $_GET['type'] ?? null;
// You could also check for an access_token if the user was automatically signed in
// after confirmation, but for just displaying a message, it's often not necessary.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmed!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            color: #28a745; /* Green for success */
            margin-bottom: 20px;
        }
        p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .cta-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .cta-button:hover {
            background-color: #0056b3;
        }
        .small-text {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎉 Email Confirmed Successfully!</h2>
        <p>Great news! Your email address has been successfully verified.</p>
        <p>You can now log in to your account and start using our application.</p>
		<img src="../images/logo.png" alt="Mes8 Logo" width="500" height="500">

        </div>
</body>
</html>