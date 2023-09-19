<?php
    function redirect($pageLink): void
    {
        header("Location: /$pageLink");
        exit;
    }

    function dump(array $data) : void 
    {
        echo '<pre>'.print_r($data, true).'</pre>';
    }