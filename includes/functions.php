<?php
include $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

function db() {
    $pdoOptions = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try {
        return new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, $pdoOptions );

    } catch (PDOException $e) {
        die($e->getMesage());
    }
}

function db_query($sql = '') {
    if (empty($sql)) return false;
    return db()->query($sql);
}


function get_user_by_email($email = '') {
    return db_query("SELECT * FROM users WHERE email = '$email'")->fetch();
}

function add_user($email, $password) {
    if (!get_user_by_email($email)) {
        db_query("INSERT INTO `users` (`id`, `email`, `pass`) VALUES (NULL, '$email', '$password');");
        return db_query("SELECT * FROM users WHERE email = '$email'")->fetch()['id'];
    }
}

function set_flash_message($name, $message) {
    $_SESSION[$name] = $message;
}

function display_flash_message($name) {
    if (isset($_SESSION[$name])) {
        echo $_SESSION[$name];
        unset($_SESSION[$name]);
    }
}

function redirect_to($path) {
    header('Location: ' . $path);
    exit();
}


function login($email, $pass)
{
    $user = get_user_by_email($email);
    if (!$user) {
        return false;
    }

    if (!password_verify($pass, $user['pass'])) {
        set_flash_message('login_error', 'Пароль не верный');
        redirect_to('page_login.php');
        return false;
    }

    set_flash_message('login_success', 'Авторизация успешна');
    $_SESSION['user'] = $email;
    return true;
}