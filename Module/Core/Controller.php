<?php

global $url;

abstract class Controller
{

    public function db()
    {
        $db = new PDO('mysql:host=' . env('DB_HOST') . ';charset=utf8;dbname=' . env('DB_NAME'), env('DB_USER'), env('DB_PASS'));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    public function url()
    {
        return env('URL');
    }

    public function siteName()
    {
        return env('APP_NAME');
    }

}