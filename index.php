<?php
    // include_once './functions/main.php'; При відсутності файла Warning
    require_once './functions/main.php'; //При відсутності файла Fatal_Error
?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet"/>
            <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" rel="stylesheet" />
            <title>Project</title>
        </head>
        <body>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Navigation</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php if(!isset($_SESSION['user'])):?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo isPageActive('registration')?>" href="/registration">Sign Up</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo isPageActive('auth')?>" href="/auth">Log In</a>
                                </li>
                            <?php endif;?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isPageActive('home')?>"  href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isPageActive('contacts')?>" href="/contacts">Contacts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isPageActive('uploads')?>" href="/uploads">Uploads</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isPageActive('custom-dir-upload')?>" href="/custom-dir-upload">Custom Directory Upload</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isPageActive('manage-sliders')?>" href="/manage-sliders">Manage Sliders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isPageActive('gallery')?>" href="/gallery">Gallery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo isPageActive('reviews')?>" href="/reviews">Reviews</a>
                            </li>
                            
                            <?php if(isset($_SESSION['user'])):?>
                                <li class="nav-item">
                                    <a class="nav-link" href="./functions/logout.php">Logout</a>
                                </li>
                            <?php endif;?>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <div class="container">
                <?php
                    $page = $_GET['page'] ?? 'home';

                    if(file_exists("./pages/$page.php"))
                    {
                        require_once "./pages/$page.php";

                        OldInputs::erase();
                    }
                    else
                    {
                        echo 'PAGE NOT FOUND!';
                    }
                ?>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
            <script src="./script.js"></script>
        </body>
    </html>