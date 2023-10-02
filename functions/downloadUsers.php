<?php
    require_once __DIR__.'/helper.php';
    require_once '../classes/Message.php';

    $fileName = 'usersData.csv';
    $file = fopen("../$fileName", 'w');

    foreach(json_decode(file_get_contents('../authData.txt')) as $item)
    {
        fwrite($file, $item->email."\n");
    }
    fclose($file);

    Message::set("File saved as \"$fileName\"!");

    redirect('home');