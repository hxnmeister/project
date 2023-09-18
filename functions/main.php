<?php
    $action = $_POST['action'] ?? null;
    if(!empty($action))
    {
        $action();
    }

    function isPageActive(string $currentPage)
    {
        return ((empty($_GET) && $currentPage === 'home') || array_search($currentPage, $_GET)) ? 'active' : '';
    }

    function sendEmail()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';

        if(empty($name) || empty($email) || empty($message))
        {
            echo 'Fill all fields!';
        }
        else
        {
            mail($email, "Mail Site!", "$name, $email, $message");
            echo 'Thank you!';

            header('Location: /contacts');
            exit;
        }
    }