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
        $name = strip_tags(trim($_POST['name'])) ?? '';
        $email = strip_tags(trim($_POST['email'])) ?? '';
        $message = strip_tags(trim($_POST['message'])) ?? '';

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

    function checkRegistration()
    {
        $email = strip_tags(trim($_POST['email'])) ?? '';
        $passw = strip_tags(trim($_POST['password'])) ?? '';
        $reppassw = strip_tags(trim($_POST['reppassword'])) ?? '';

        if(empty($email) || empty($passw) || empty($reppassw))
        {
            echo 'All fields must be filled';
        }
        elseif($passw !== $reppassw) 
        {
            echo 'The passwords do not match, try again!';
        }
        else
        {
            echo 'You have successfully registered!';

            header('Location: /registration');
            exit;
        }
    }