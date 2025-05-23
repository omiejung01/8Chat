
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        p {
            color: #666;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #28a745; /* Green for success action */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-to-login {
            margin-top: 15px;
            display: block;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .back-to-login:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Set New Password</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($show_form): ?>
            <p>Please enter your new password below.</p>
            <form action="reset_password.php" method="POST">
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required minlength="6" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6" autocomplete="new-password">
                </div>
                <input type="hidden" id="access_token" name="access_token">
                <button type="submit">Reset Password</button>
            </form>
        <?php else: ?>
            <p>You will be redirected to the login page shortly.</p>
        <?php endif; ?>

        <a href="login.php" class="back-to-login">Back to Login</a>
    </div>

    <script>
        // JavaScript to extract the access_token from the URL fragment and populate a hidden field
        // This is necessary because PHP cannot directly read URL fragments (#).
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash) {
                const params = new URLSearchParams(hash.substring(1)); // Remove '#'
                const accessToken = params.get('access_token');
                const tokenType = params.get('token_type');
                const type = params.get('type'); // Should be 'recovery'

                if (accessToken && type === 'recovery') {
                    // Populate the hidden input field so PHP can receive it on form submission
                    document.getElementById('access_token').value = accessToken;

                    // IMPORTANT: Supabase JS client best practice for recovery:
                    // After receiving the token via the URL fragment, you should
                    // ideally set the session immediately and then perhaps call
                    // `updateUser` directly via JS, or at least ensure the session is active.
                    //
                    // Example of setting session with Supabase JS:
                    // const supabase = createClient('YOUR_SUPABASE_URL', 'YOUR_SUPABASE_ANON_KEY');
                    // supabase.auth.setSession({ access_token: accessToken, refresh_token: params.get('refresh_token') })
                    //   .then(({ data, error }) => {
                    //     if (error) {
                    //       console.error('Error setting session:', error.message);
                    //       // Handle error, maybe display a message
                    //     } else {
                    //       console.log('Session set successfully for recovery.');
                    //       // Now the user is "logged in" with the recovery token,
                    //       // you can proceed with form submission to PHP or direct JS update.
                    //     }
                    //   });

                    // For this PHP example, we are relying on PHP receiving the token
                    // through the form submission. If the hidden input is not populated,
                    // PHP will flag it as missing.

                } else if (type === 'recovery' && !accessToken) {
                    // This scenario means they landed here for recovery, but the token is missing/invalid.
                    // This might happen if the URL was malformed or token expired.
                    document.querySelector('.container').innerHTML = `
                        <h2>Password Reset Link Expired or Invalid</h2>
                        <div class="message error">The password reset link is invalid or has expired. Please request a new one.</div>
                        <a href="forgot_password.php" class="back-to-login">Request New Password Reset Link</a>
                        <a href="login.php" class="back-to-login">Back to Login</a>
                    `;
                }
            } else {
                // No hash in URL, meaning they didn't come from a reset email link directly
                document.querySelector('.container').innerHTML = `
                    <h2>Access Denied</h2>
                    <div class="message error">You must use the password reset link sent to your email.</div>
                    <a href="forgot_password.php" class="back-to-login">Forgot Password?</a>
                    <a href="login.php" class="back-to-login">Back to Login</a>
                `;
            }
        });
    </script>
</body>
</html>