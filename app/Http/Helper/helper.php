<?php
if (!function_exists('P')) {
   function p($data)
   {
        echo '<pre>';
            print_r($data);
        echo '</pre>';
   }
}

