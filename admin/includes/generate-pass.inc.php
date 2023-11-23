<?php

$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$passArray = array();
$charLen = strlen($characters) - 1;

function generatePass() {
    for ($i = 0; $i < 8; $i++) {
        $char = $characters[rand(0, $charLen)];
        $passArray[] += $char;
    }
    
    return implode($passArray);
}
