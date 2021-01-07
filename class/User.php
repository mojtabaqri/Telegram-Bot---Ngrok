<?php


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

        return ":D";
    }
    private function save($type,$data=[])
    {
        switch ($type) {
            case "user":
                break;
        }
    }


}