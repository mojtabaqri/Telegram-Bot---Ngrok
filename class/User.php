<?php

use SleekDB\SleekDB;

class User
{
    private $user;
    public function __construct($user)
    {
     $this->user=$user;
    }

    public function getUser()
    {
        return $this->user;
    }
    public static function CheckUser($user){//check if user exist
        $database=SleekDB::store('users',$_ENV['dataDir']);
        try {
            if($record = $database->where( 'id', '=',$user['id'] )->fetch())
                return True;
        } catch (Exception $e) {
            return 'مشکلی در سیستم پیش آمده است در حال بررسی آن هستیم !';

        }
    }
    public static function save($user)
    {
        $database=SleekDB::store('users',$_ENV['dataDir']);
        try {
            $database->insert($user);
            return 'خوش آمدید !';
        } catch (Exception $e) {
            return 'مشکلی در سیستم پیش آمده است در حال بررسی آن هستیم !';
        }

    }


}