<?php

function dd() {
    echo "<pre>";

    foreach (func_get_args() as $var)
    {
        if (is_array($var) || is_object($var))
        {
            print_r($var);
        }
        else
        {
            var_dump($var);
        }
    }

    echo "</pre>";
    die(1);
}
