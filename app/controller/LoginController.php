<?php

require_once __DIR__.'/../../base.php';

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
    
            if ($data['status'] === 'success') {
                header('Location: ' . BASE_URL . 'login');
                exit;
            } else {
                $error = $data['message'];
            }
        }
    }

    // Login Page
    require_once __DIR__.'/../views/auth/register.view.php';
}