<?php
    class Message
    {
        public static function set(string $text, string $type = 'success') : void
        {
            $_SESSION['message'] = [$text, $type];
        }

        public static function show() : void
        {
            if(isset($_SESSION['message']))
            {
                list($text, $type) = $_SESSION['message'];

                echo "<div class='alert alert-{$type}'>$text</div>";

                unset($_SESSION['message']);
            }
        }
    }