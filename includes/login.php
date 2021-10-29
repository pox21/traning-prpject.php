<?php
session_start();

include 'functions.php';


if (isset($_POST) and $_SERVER["REQUEST_METHOD"] == "POST") {
    $user = get_user_by_email($_POST['email']);

    if (!$user) {
        set_flash_message('login_error', 'Такой пользователь не найден');
        redirect_to('/pages/page_login.php');
        exit();
    }

    login($_POST['email'], $_POST['pass']);
    redirect_to('/pages/users.php');

}


