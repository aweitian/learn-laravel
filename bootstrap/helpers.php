<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/24
 * Time: 13:43
 */

use Illuminate\Support\Facades\Route;

function test_helper()
{
    return 'OK';
}

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}