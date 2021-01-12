<?php

namespace app\classes;

class User
{
    static function getAuthUserId()
    {
        return $_SESSION['user']['id']??0;
    }

    static function getAuthUserName()
    {
        return $_SESSION['user']['name']??'';
    }

    static function getAuthUserScore()
    {
        return $_SESSION['user']['score']??0;
    }

    static function setAuthUserScore($score)
    {
        $_SESSION['user']['score'] = $score;
    }

    static function setAuthUser($user)
    {
        $_SESSION['user'] = $user;
    }

    static function logoutUser()
    {
        unset($_SESSION['user']);
    }

    static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    static function genHashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

}