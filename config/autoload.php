<?php

spl_autoload_register(function($class){
    $paths = array(
        join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'model']),
        join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'model', 'pieces']),
        join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'model', 'players']),
    );
    
    foreach($paths as $path){
        $file = join(DIRECTORY_SEPARATOR, [$path, $class.'.php']) ;
        if(file_exists($file))
            return require_once $file;
    }
}); 