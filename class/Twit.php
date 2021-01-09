<?php
use SleekDB\SleekDB;


class Twit
{


    private static function checkUserRequestTwit($id,$hashtag)
    {

     return   $database = SleekDB::store('userTwit', $_ENV['dataDir'])->fetch();
        try {

            if ($database->where('chat_id', '=', $id)->where('hashtag','=',$hashtag)->fetch())
                return $database;
        } catch (Exception $e) {
        }


    }


    public static function userRequestTwit($id,$hashtag)
    {

        return self::checkUserRequestTwit($id,$hashtag);
        $database = SleekDB::store('userTwit', $_ENV['dataDir']);
        try {
            $data=[
                'chat_id'=>$id,
                'hashtag'=>$hashtag
            ];
            $database->insert($data);
            //return self::getTwit($hashtag);
        } catch (Exception $e) {

        }




    }

    public static function saveTwit($twit,$hashTag){

        try {
            $database = SleekDB::store('twit', $_ENV['dataDir']);
            $data=[
                'hashtag'=>$hashTag,
                'content'=>$twit,
                'invoke'=>false,
            ];
           return $database->insert($data);
        } catch (Exception $e) {

        }



    }

    private static function getTwit($hashtag)
    {
        try {
            $database = SleekDB::store('twit', $_ENV['dataDir']);
         return $database->where('hashtag','=',$hashtag)->where('invoke','=',false)->fetch();

        } catch (Exception $e) {

        }
    }




}