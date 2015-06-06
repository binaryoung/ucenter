<?php namespace Binaryoung\Ucenter\Contracts;

interface Api
{

    public static function test($get, $post);

    public static function deleteuser($get, $post);

    public static function renameuser($get, $post);

    public static function updatepw($get, $post);

    public static function gettag($get, $post);

    public static function synlogin($get, $post);

    public static function synlogout($get, $post);

    public static function updatebadwords($get, $post);

    public static function updatehosts($get, $post);

    public static function updateapps($get, $post);

    public static function updateclient($get, $post);

    public static function updatecredit($get, $post);

    public static function getcreditsettings($get, $post);

    public static function updatecreditsettings($get, $post);

    public static function getcredit($get, $post);
}
