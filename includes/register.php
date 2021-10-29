<?php
session_start();

include 'functions.php';

if  (isset($_POST) and $_SERVER["REQUEST_METHOD"] == "POST") {
    if (!add_user($_POST['email'], password_hash($_POST['pass'], PASSWORD_DEFAULT )) ) {
        set_flash_message('user_exist', 'Этот эл. адрес уже занят другим пользователем.');
        redirect_to('page_register.php');
        die;
    }

    add_user($_POST['email'], password_hash($_POST['pass'], PASSWORD_DEFAULT ) );
    set_flash_message('register_success', 'Регистрация успешна');


    redirect_to('/pages/page_login.php');
}
