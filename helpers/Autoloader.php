<?php

class Autoloader{
    
    public static function autoload($className){
        $file = __DIR__."/../controllers/".$className .'.php';

        if(file_exists($file)){
            include $file;
        }else{
            $file = __DIR__."/../models/".$className .'.php';
            include $file;
        }
    }

}

spl_autoload_register('Autoloader::autoload');