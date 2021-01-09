<?php

use SleekDB\SleekDB;


class Twit
{
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

    public static function getTwit($hashtag)
    {
        try {
            $database = SleekDB::store('twit', $_ENV['dataDir']);
          return $database->where('hashtag','=','#sample')->where('invoke','=',false)->fetch();
        } catch (Exception $e) {

        }


    }


}