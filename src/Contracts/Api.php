<?php namespace Binaryoung\Ucenter\Contracts;

interface Api
{
   
    public static function test();

    public static function deleteuser();

    public static function renameuser();

    public static function updatepw();

    public static function gettag();

    public static function synlogin();

    public static function synlogout();

    public static function updatebadwords();

    public static function updatehosts();

    public static function updateapps();

    public static function updateclient();

    public static function updatecredit();

    public static function getcreditsettings();

    public static function updatecreditsettings();

    public static function getcredit();
}
