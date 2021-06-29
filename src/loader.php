<?php
// Autoload All Source Class And Helpers
spl_autoload_extensions('.php, .inc');

spl_autoload_register(function($class_name) {
    $parts = explode('\\', $class_name);

    if(in_array('Model', $parts)) {
        include __DIR__ . DIRECTORY_SEPARATOR . "Model/" . end($parts) . '.php';
    }

    if(in_array('Interfaces', $parts)) {
        include __DIR__ . DIRECTORY_SEPARATOR . "Interfaces/" . end($parts) . '.php';
    }

    if(in_array('PHPMailer', $parts)) {
        include __DIR__ . DIRECTORY_SEPARATOR . "PHPMailer/src/" . end($parts) . '.php';
    }
});