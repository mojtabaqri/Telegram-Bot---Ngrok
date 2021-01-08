<?php

use SleekDB\SleekDB;

class Admin
{
    private $user;
    public function __construct($user)
    {
        $this->user=$user;
    }

    public function isAdmin($user){
        $database=SleekDB::store('admin',$_ENV['dataDir']);
        if($record = $database->where( 'id', '=',$user['id'] )->fetch())
            return True;

        return False;

    }
    public  function addAdmin($user)
    {
        if(Admin::checkAdmin($user)!=True){
            try {
                $database=SleekDB::store('admin',$_ENV['dataDir']);
                $database->insert(['id'=>$user]);
                return 'مدیر با موفقیت افزوده شد !';
            } catch (Exception $e) {
                return 'مدیر اضافه نشد ! '.$e->getMessage();
            }
        }
        return 'این ایدی قبلا به لیست مدیران اضافه شده است!';


    }

    public static function checkAdmin($id){//check if admin exist
        try {
            $database=SleekDB::store('admin',$_ENV['dataDir']);
            if($record = $database->where( 'id', '=',$id )->fetch())
                return True;
            else
                return False;
        }
        catch (Exception $e) {
            return 'خطای سیستمی در چک کردن دسترسی کاربر!';

        }
    }

    public static function resetAdmin(){
        $database=SleekDB::store('admin',$_ENV['dataDir']);
        try {
            $database->delete();
            return 'تمامی مدیران حذف شدند! شما هم اکنون مدیر نیستید!';
        } catch (Exception $e) {
            return 'مشکلی پیش آمده است! مدیری حذف نشد!';
        }

    }




}