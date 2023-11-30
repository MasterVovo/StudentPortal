<?php

function generatePass() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $passArray = array();
    $charLen = strlen($characters) - 1;

    for ($i = 0; $i < 8; $i++) {
        $char = $characters[rand(0, $charLen)];
        $passArray[] = $char;
    }
    
    return implode($passArray);
}
