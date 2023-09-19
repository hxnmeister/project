<?php
    class OldInputs
    {
        public static function set(array $inputs) : void 
        {
            $_SESSION['old_inputs'] = $inputs;
        }

        public static function get(string $key) : string 
        {
            return $_SESSION['old_inputs'][$key] ?? '';
        }

        public static function erase() : void 
        {
            if(isset($_SESSION['old_inputs'])) 
            {
                unset($_SESSION['old_inputs']);
            }
        }
    }