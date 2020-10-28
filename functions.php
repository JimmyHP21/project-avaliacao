<?php

use Project\Model\User;

function getUserName() {
    $user = User::getFromSession();
    return $user -> getdesname();
}

function getUserId() {
    $user = User::getFromSession();
    return $user -> getiduser();
}

function getIsSignature() {
    $user = User::getFromSession();
    return $user -> getsignature();
}

function getBalance() {
    $user = User::getFromSession();
    return $user -> getbalance();
}

function formatValue(float $value) {
    return number_format($value, 2 , ",", ".");
}