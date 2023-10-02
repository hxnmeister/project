<?php
    require_once __DIR__."/helper.php";
    require_once "./classes/Message.php";
    require_once "./classes/OldInputs.php";

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

    function getSlidersDirs()
    {
        $directories = array_diff(scandir('./sliders'), ['.','..']);

        if(!empty($directories))
        {
            echo "<option value=\"\" selected>Choose slider</option>";
            foreach ($directories as $directory)
            {
                echo "<option value=\"$directory\">$directory</option>";
            }
        }
        else
        {
            echo "<option value=\"\" selected>No available sliders!</option>";
        }
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
            Message::set('All fields must be filled', 'danger');
            OldInputs::set($_POST);
        }
        elseif($passw !== $reppassw) 
        {
            Message::set('The passwords do not match, try again!', 'danger');
            OldInputs::set($_POST);
        }
        else
        {
            $fileName = 'authData.txt';
            $fileData = file_exists($fileName) ? json_decode(file_get_contents($fileName)) : [];
            
            foreach($fileData as $item)
            {
                if($email === $item->email)
                {
                    Message::set("Such user \"$email\" already registered!", 'danger');
                    OldInputs::set($_POST);

                    redirect('registration');
                }
            }

            $fileData[] = compact('email', 'passw');
            $file = fopen($fileName, 'w');
                
            fwrite($file, json_encode($fileData));
            fclose($file);

            Message::set('You have successfully registered!');
        }

        redirect('registration');
    }

    function checkAuth()
    {
        $email = strip_tags(trim($_POST['email'])) ?? '';
        $passw = strip_tags(trim($_POST['password'])) ?? '';

        if(empty($email) || empty($passw))
        {
            Message::set('All fields must be filled', 'danger');
            OldInputs::set($_POST);
        }
        else
        {
            $fileName = 'authData.txt';
            $fileData = file_exists($fileName) ? json_decode(file_get_contents($fileName)) : [];

            foreach ($fileData as $item) 
            {
                if($email === $item->email && $passw === $item->passw)
                {
                    $_SESSION['user'] = $email;

                    Message::set('You have successfully logged in!');
                    redirect('home');
                }
            }

            Message::set("Such user \"$email\" not found!", 'danger');
        }

        redirect('auth');
    }

    function getImages(string $createDirName, array $allowed, array $images, string $dirToSave) : bool
    {
        if(!empty($createDirName))
        {
            extract($images);

            if(!in_array(0, $error))
            {
                foreach($error as $errorCode)
                {
                    if($errorCode === 4)
                    {
                        Message::set('File is required!', 'danger');
                    }
                    else
                    {
                        Message::set('File not uploaded!', 'danger');
                    }
                }
    
                OldInputs::set($_POST);
                return false;
            }
            
            foreach($type as $typeName)
            {
                if(!in_array($typeName, $allowed))
                {
                    OldInputs::set($_POST);
                    Message::set("Type $typeName is not allowed!", 'danger');
    
                    return false;
                }
            }

            if(!is_dir("$dirToSave/$createDirName"))
            {
                mkdir("$dirToSave/$createDirName");
            }

            for($i = 0; $i < sizeof($name); $i++)
            {
                $fileName = uniqid().'.'.end(explode('.', $name[$i]));
                move_uploaded_file($tmp_name[$i], "$dirToSave/$createDirName/$fileName");
            }
        }
        else
        {
            Message::set('Directory name is required!', 'danger');
            return false;
        }

        return true;
    }

    function uploadFewImages()
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg', 'image/avif'];
        $dirName = strip_tags(trim($_POST['dir-name'])) ?? '';
            
        if(getImages($dirName, $allowedTypes, $_FILES['files'], './uploadedImages/'))
        {
            Message::set('File successfully loaded!');
        }

        redirect('custom-dir-upload');
    }

    function createSlider() 
    {
        $directoryName = strip_tags(trim($_POST['dir-name'])) ?? '';

        if(!empty($directoryName))
        {
            if(!is_dir('./sliders/'.$directoryName))
            {
                mkdir('./sliders/'.$directoryName);
                mkdir('./sliders/'.$directoryName.'/small');
    
                Message::set("Slider \"$directoryName\" successfully created!");
            }
            else
            {
                OldInputs::set($_POST);
                Message::set('Such slider is already excisting!', 'danger');
            }
        }
        else
        {
            Message::set('Slider Name Cannot Be Empty!', 'danger');
        }

        redirect('manage-sliders');
    }

    function removeDir($path) 
    {
        if (is_file($path)) 
        {
            unlink($path);
        } 
        else 
        {
            foreach(glob($path.'/*') as $item)
            {
                removeDir($item);
            }

            rmdir($path);
        }
    }

    function deleteSlider()
    {
        $selectedDir = $_POST['selected-delete-slider'] ?? '';
        
        if(!empty($selectedDir))
        {
            $directoryPath = "./sliders/$selectedDir";

            if(is_dir($directoryPath))
            {
                foreach(glob("$directoryPath/*") as $item)
                {
                    removeDir($item);
                }
    
                rmdir($directoryPath) ? Message::set('Slider successfully deleted!') : Message::set('Unable to delete slider!', 'danger');
            }
            else
            {
                OldInputs::set($_POST);
                Message::set('There is no such slider!', 'danger');
            }
        }

        redirect('manage-sliders');
    }

    function loadImageToSlider()
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg', 'image/avif'];
        $dirName = strip_tags(trim($_POST['selected-load-slider'])) ?? '';

        if(!empty($dirName))
        {
            if(getImages($dirName, $allowedTypes, $_FILES['files'], './sliders/'))
            {
                foreach(glob("./sliders/$dirName/*.{jpeg,png,gif,webp,jpg,avif}", GLOB_BRACE) as $image)
                {
                    $imageName = basename($image);
                    $commonImagePath = "./sliders/$dirName/$imageName";
                    $smallImagePath = "./sliders/$dirName/small/$imageName";
    
                    if(!file_exists($smallImagePath))
                    {
                        extract(pathinfo($commonImagePath));
    
                        $newWidth = 150;
                        $newHeight = 150;
                        $extension = strtolower($extension) === 'jpg' ? 'jpeg' : strtolower($extension);
                        $functionCreate = 'imagecreatefrom'.$extension;
                        $srcImage = $functionCreate($commonImagePath);
                        $newImage = imagecreatetruecolor($newWidth, $newHeight);
                        list($src_width, $src_height) = getimagesize($commonImagePath);
    
                        imagecopyresized($newImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $src_width, $src_height);
    
                        if($extension === 'jpg')
                        {
                            ('image'.$extension)($newImage, "./sliders/$dirName/small/$imageName", 100);
                        }
                        else
                        {
                            ('image'.$extension)($newImage, "./sliders/$dirName/small/$imageName");
                        }
                    }
                }
                Message::set("Image successfully loaded to slider \"$dirName\"!");
            }
        }

        redirect('manage-sliders');
    }

    function uploadImage()
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg', 'image/avif'];
        
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

        resizeImage('./uploadedImages/'.$fName, 150, true);
        resizeImage('./uploadedImages/'.$fName, 300);

        redirect('uploads');
    }

    function resizeImage(string $savePath, int $size = 200, bool $crop = false) : void
    {
        extract(pathinfo($savePath));

        $extension = strtolower($extension) === 'jpg' ? 'jpeg' : strtolower($extension);
        $functionCreate = 'imagecreatefrom'.$extension;
        $src = $functionCreate($savePath);
        list($src_width, $src_height) = getimagesize($savePath);

        if($crop)
        {
            //Жорстка обрізка
            
            $dest = imagecreatetruecolor($size, $size);

            if($src_width > $src_height)
            {
                imagecopyresized($dest, $src, 0, 0, $src_width / 2 - $src_height / 2, 0, $size, $size, $src_height, $src_height);
            }
            elseif($src_width < $src_height)
            {
                imagecopyresized($dest, $src, 0, 0, 0, $src_height / 2 - $src_width / 2,  $size, $size, $src_width, $src_width);
            }
        }
        else
        {
            //Пропорційне зменшення

            $dest_width = $size;
            $dest_height = $size * $src_height / $src_width;

            $dest = imagecreatetruecolor($dest_width, $dest_height);
            imagecopyresized($dest, $src, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
        }

        $saveDir = $crop ? 'small' : 'medium';

        if($extension === 'jpg')
        {
            ('image'.$extension)($dest, "$dirname/$saveDir/$basename", 100);
        }
        else
        {
            ('image'.$extension)($dest, "$dirname/$saveDir/$basename");
        }
    }

    function sendReview()
    {
        $reviewFileName = 'reviews.txt';
        $name = strip_tags(trim($_POST['name'])) ?? '';
        $review = strip_tags(trim($_POST['review'])) ?? '';
        $time = time();

        if(empty($name) || empty($review))
        {
            Message::set('All fields are required!', 'danger');
            redirect('reviews');
        }

        $reviews = file_exists($reviewFileName) ? json_decode(file_get_contents($reviewFileName)) : [];
        $reviews[] = compact('name', 'review', 'time');

        $file = fopen($reviewFileName, 'w'); //w - write, r - read, a - append, (w+,r+,a+ - позволяет выполнять обе функции)
        fwrite($file, json_encode($reviews));
        fclose($file);

        redirect('reviews');
    }

    function showReviews()
    {
        $reviewFileName = 'reviews.txt';
        $reviews = file_exists($reviewFileName) ? array_reverse(json_decode(file_get_contents($reviewFileName))) : [];
        $reviewsCount = count($reviews);

        if($reviewsCount === 0)
        {
            echo '<h1>No Reviews =<</h1>';
        }
        else
        {
            $limitPerPage = 3;
            //$pagesAmount = ceil($reviewsCount / $limitPerPage);
            $reviews = array_chunk($reviews, $limitPerPage);
            $currentPage = $_GET['p'] ?? 1;

            foreach($reviews[$currentPage - 1] as $review)
            {
                echo 
                "<div class=\"mt-3 border p-3\">
                    <strong>(".date('d.m.Y H:i', $review->time).") $review->name</strong>
                    <div>$review->review</div>
                </div>";
            }

            echo "<nav>";
                echo "<ul class=\"pagination\">";
                    for($i = 1; $i <= count($reviews); $i++)
                    {
                        echo "<li class=\"page-item ". ($currentPage == $i ? "active" : '') ."\"><a href=\"/reviews?p=$i\" class=\"page-link\">$i</a></li>";
                    }
                echo "</ul>";
            echo "</nav>";
        }
    }