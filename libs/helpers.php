<?php

if (! function_exists('dump')) {
    function dump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}

if (! function_exists('dd')) {
    function dd($data)
    {
        dump($data);
        die;
    }
}

if (! function_exists('old')) {
    function old($name)
    {
        return $_POST[$name] ?? '';
    }
}

if (! function_exists('redirect')) {
    function redirect($path)
    {
        header("Location: $path");
    }
}

if (! function_exists('root_path')) {
    function root_path()
    {
        $splittedPath = explode('\\', dirname(__DIR__));

        return array_pop($splittedPath);
    }
}