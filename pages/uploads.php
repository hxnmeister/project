<h1>Uploads</h1>

<?= Message::show()?>

<form action="/uploads" method="post" enctype="multipart/form-data">
    <input class="mt-3" type="file" name="file">
    <button class="btn btn-outline-primary" name="action" value="uploadImage">Load File</button>
</form>

<?php
    // $files = array_diff(scandir('./uploadedImages'), ['.', '..']);

    // foreach($files as $file)
    // {
    //     if(!is_dir("./uploadedImages/$file"))
    //     {
    //         echo "<img src='./uploadedImages/$file' alt=''>";
    //     }
    // }
    //----------------------------------------------------------------

    // $dir = opendir('./uploadedImages');
    
    // while($file = readdir($dir))
    // {
    //     echo $file.'<br>';
    // }

    // closedir($dir);
    //----------------------------------------------------------------
        
    // $files = glob('./uploadedImages/*', GLOB_ONLYDIR);
    // $files = glob('./uploadedImages/*.{jpg,jpeg,png,gif,webp,avif}', GLOB_BRACE);


    $files = array_diff(scandir('./uploadedImages'), ['.', '..']);

    foreach($files as $file)
    {
        if(!is_dir("./uploadedImages/$file"))
        {
            echo "<a href='./uploadedImages/$file'><img src='./uploadedImages/small/$file' alt=''></a>";
        }
    }
