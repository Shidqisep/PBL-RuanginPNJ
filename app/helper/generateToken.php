<?php

function generateCaptchaToken() {
    $pool = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $token = '';
    for ($i = 0; $i < 5; $i++) {
        $token .= $pool[random_int(0, strlen($pool) - 1)];
    }
    $_SESSION['captcha_token'] = $token;
    return $token;
}
