<?php

namespace app\classes;

class Prize
{
    static function set($prize)
    {
        $_SESSION['current_prize'] = $prize;
    }

    static function get()
    {
        return $_SESSION['current_prize']??[];
    }

    static function remove()
    {
        unset($_SESSION['current_prize']);
    }

}