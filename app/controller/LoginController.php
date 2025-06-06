<?php

require_once __DIR__.'/../../base.php';
require_once __DIR__.'/../database/Model/User.php';

// 获取路由地址，这里是login和logout
$path = getCurrentRoutePath();

// 处理登出
switch($path){
    case 'logout':
        setcookie('access_token', '', time() - 864000, '/');
        setcookie('username', '', time() - 864000, '/');
        setcookie('loggedin', '', time() - 864000, '/');
        session_unset();
        flash_msg("Logout successfully!", 'info');
        header('Location: '. BASE_URL);
        exit;
    case 'login':
        loginProcess();
        break;
    case 'register':
        registerProcess();
        break;
    case 'forgot_password':
        forgotPass($pdo);
        break;
    case 'reset_password':
        resetPass();
        break;
}

function loginProcess(){
    // // 如果已经登录了就返回主页或者重定向
    if ($_COOKIE['loggedin'] ?? false) {
        empty($_GET['redirect']) ? header("Location: " . rtrim(BASE_URL, '/')) : header("Location: " .urldecode($_GET['redirect']));
        exit;
    }

    // 开始登录流程
    if (is_post()) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Initialize cURL session
        $ch = curl_init();

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, API_URL . 'login.php');

        // Enable the option to return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set the POST fields
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'email' => $email,
            'password' => $password
        ]));

        // Include cookies in the request
        curl_setopt($ch, CURLOPT_COOKIE, http_build_query($_COOKIE, '', '; '));

        // Execute the cURL request
        $response = curl_exec($ch);

        // Close the cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        if (isset($data) && isset($data['status']) && $data['status'] === 'success') {
            if($data['user_data']['active'] === 1){
                setcookie('loggedin', true, time() + 864000, '/');
                setcookie('email', $email, time() + 864000, '/');
                setcookie('access_token', $data['access_token'], time() + 864000, '/');
        
                // save user data
                $_SESSION['user'] = [
                    'id' => $data['user_data']['id'],
                    'email' => $data['user_data']['email'],
                    'username' => $data['user_data']['name'],
                    'avatar' => $data['user_data']['avatar'],
                    'role' => $data['user_data']['role'],
                ];

                flash_msg("Login successfully!");
                empty($_GET['redirect']) ? header("Location: " . BASE_URL) : header("Location: " . $_GET['redirect']);
                exit;
            }
            else{
                $error = 'Your account has been blocked!';
            }
        } else {
            $error = isset($data['message']) ? $data['message'] : 'Unknown error';
        }
    }

    // Login Page
    require_once __DIR__.'/../views/auth/login.view.php';
}

function registerProcess(){
    if (is_post()) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm-password'];
    
        if ($password !== $confirm_password) {
            $error = 'Password and confirm password do not match';
        } else {
    
            // Initialize cURL session
            $ch = curl_init();
    
            // Set the URL
            curl_setopt($ch, CURLOPT_URL, API_URL . 'register.php');
    
            // Enable the option to return the response as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            // Set the POST fields
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]));
    
            // Include cookies in the request
            curl_setopt($ch, CURLOPT_COOKIE, http_build_query($_COOKIE, '', '; '));
    
            // Execute the cURL request
            $response = curl_exec($ch);
    
            // Close the cURL session
            curl_close($ch);
    
            // Decode the JSON response
            $data = json_decode($response, true);
    
            if (isset($data) && isset($data['status']) && $data['status'] === 'success') {
                header('Location: ' . BASE_URL . 'login');
                exit;
            } else {
            }
        }
    }

    // Login Page
    require_once __DIR__.'/../views/auth/register.view.php';
}

function forgotPass(PDO $pdo){
    if (is_post()) {
        $email = $_POST['email'];
    
        // Check if email exists in database
        $user = new User($pdo); 
        $user = $user->findByEmail($email);
    
        if ($user) {
            // Generate 6-digit verification code
            $code = sprintf("%06d", random_int(0, 999999));  // 生成6位数验证码
            $expires_at = date('Y-m-d H:i:s', time() + 300);  // 5分钟有效期
    
            // Store the code in the database
            $dbConfig = DatabaseConfig::getDatabaseConfig();
            $db = new Database($dbConfig);
            $conn = $db->getConnection();
            $query = "INSERT INTO password_resets (email, code, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE code = ?, expires_at = ?";
            $stmt = $conn->prepare($query);
            $success = $stmt->execute([$email, $code, $expires_at, $code, $expires_at]);

            // Send email with verification code
            $m = get_mail();
            $m->addAddress($email);
            $m->Subject = 'Password Reset Code';
            $m->Body = "Hi there!\n\nYou requested to reset your password. Please use the following code to reset it:\n\n$code\n\nThis code will expire in 5 minutes.";
    
            if ($m->send()) {
                flash_msg("A password reset code has been sent to your email.");
                // 跳转到 reset_password 页面，携带 email 参数
                header("Location: " . BASE_URL . "reset_password?email=$email");
                exit;
            } else {
                flash_msg("Error sending email. Please try again.", 'error');
            }
            
        } else {
            flash_msg("Email not found.", 'error');
        }
    
        header("Location: ".BASE_URL.'forgot_password');  // Redirect back to the forgot password page
        exit;
    }

    require_once __DIR__.'/../views/auth/forgotPass.view.php';
}

function resetPass(){
    // Check if token exists in the query string
    if (!isset($_GET['email']) || empty($_GET['email'])) {
        flash_msg("Invalid reset link.", 'error');
        header("Location: ".BASE_URL.'forgot_password');
        exit;
    }

    $email = $_GET['email'];

    if (is_post()) {
        $input_code = $_POST['code'];
        $new_password = $_POST['password'];

        // Verify the code exists and is not expired
        $dbConfig = DatabaseConfig::getDatabaseConfig();
        $db = new Database($dbConfig);
        $conn = $db->getConnection();
        $query = "SELECT * FROM password_resets WHERE email = ? AND code = ? AND expires_at > NOW()";
        $stmt = $conn->prepare($query);
        $stmt->execute([$email, $input_code]);
        $reset_request = $stmt->fetch();

        if (!$reset_request) {
            flash_msg("Invalid or expired code.", 'error');
            header("Location: ".BASE_URL.'reset_password?email='.$email);
            exit;
        }

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Update the user's password in the users table
        $update_query = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->execute([$hashed_password, $email]);

        // Delete the token after it's used
        $delete_query = "DELETE FROM password_resets WHERE email = ? AND code = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->execute([$email, $input_code]);

        flash_msg("Your password has been successfully reset. You can now log in with your new password.");
        header("Location: ".BASE_URL.'login');
        exit;
    }
    
    require_once __DIR__.'/../views/auth/resetPass.view.php';
}