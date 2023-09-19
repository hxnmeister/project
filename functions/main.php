<?php
    require_once __DIR__."/helper.php";
    require_once __DIR__."/Message.php";
    require_once __DIR__."/OldInputs.php";

    session_start();

    // ini_set('upload_max_filesize', '500M');
    // ini_set('error_reporting', E_ALL); // Включаємо вивід помилок з php
    // echo phpinfo();

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
            Message::set('All fields are required!', 'danger');
            OldInputs::set($_POST);
        }
        else
        {
            mail($email, "Mail Site!", "$name, $email, $message");
            Message::set('Thank you!');
        }

        redirect('contacts');
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

            //Куки как временное решение для хранение пароля, можно заменить на хранение в файле или в БД
            setcookie($email, $passw, time() + 60);
            
            header('Location: /registration');
            exit;
        }
    }

    function checkAuth()
    {
        $email = strip_tags(trim($_POST['email'])) ?? '';
        $passw = strip_tags(trim($_POST['password'])) ?? '';

        if(empty($email) || empty($passw))
        {
            echo 'Fill all fields!';
        }
        else
        {
            //Пароль который был получен из куки
            $c_passw = $_COOKIE[$email] ?? '';

            if(empty($c_passw))
            {
                echo 'There is no such user!';
            }
            elseif($c_passw !== $passw)
            {
                echo 'Check your input and try again!';
            }
            else
            {
                echo 'You have successfully logged in!';

                header('Location: /auth');
                exit;
            }
        }
    }

    function uploadImage()
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg', 'image/avif'];

        dump($_FILES['file']);

        extract($_FILES['file']); //$name, $full_path, $type, $tmp_name, $error, $size

        if($error === 4)
        {
            Message::set('File is required!', 'danger');
            redirect("uploads");
        }
        elseif($error !== 0)
        {
            Message::set('File is not uploaded!', 'danger');
            redirect('uploads');
        }

        if(in_array($type, $allowedTypes))
        {
            $fName = uniqid().'__'.session_id().'.'.end(explode('.', $name));
            move_uploaded_file($tmp_name, './uploadedImages/'.$fName);
        
            Message::set('File is successfully uploaded!');
        }
        else
        {
            Message::set('Such type not allowed!', 'danger');
        }

        redirect('uploads');
    }