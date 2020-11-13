<?php


if (! function_exists("varspay"))
{
    function varspay() {

        return app()->make('laravel-varspay');
    }
}