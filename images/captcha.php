<?php
    header('Content-Type: image/png');

    $img = imagecreatetruecolor(150, 50);

    imagefill($img, 0, 0, 0xdddddd);
    imagepng($img);