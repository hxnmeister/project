<?php
    require_once __DIR__.'/helper.php';
    require_once '../classes/Message.php';

    session_start();
    unset($_SESSION['user']);

    Message::set('You have successfully logged out of your account!');

    redirect('auth');