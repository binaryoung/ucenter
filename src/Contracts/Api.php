<?php namespace Binaryoung\Ucenter\Contracts;

interface Api
{
   
    public  function test();

    public  function deleteuser();

    public  function renameuser();

    public  function updatepw();

    public  function gettag();

    public  function synlogin();

    public  function synlogout();

    public  function updatebadwords();

    public  function updatehosts();

    public  function updateapps();

    public  function updateclient();

    public  function updatecredit();

    public  function getcreditsettings();

    public  function updatecreditsettings();

    public  function getcredit();
}
