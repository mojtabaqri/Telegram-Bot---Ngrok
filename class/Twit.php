<?php
use SleekDB\SleekDB;


class Twit
{


    private static function checkUserRequestTwit($id,$hashtag)
    {

      $database = SleekDB::store('userTwit', $_ENV['dataDir']);
        try {
           if(!$database->where('chat_id', '=', $id)->where('hashtag','=',$hashtag)->fetch())
           return False;
               return True;

        } catch (Exception $e) {
        }


    }


    public static function userRequestTwit($id,$hashtag)
    {

       if(self::checkUserRequestTwit($id,$hashtag))
        return 'شما قبلا یک توییت با این هشتگ دریافت کرده اید! هر توییت برای یک نفر می باشد !' ;
        $database = SleekDB::store('userTwit', $_ENV['dataDir']);
        try {
            $data=[
                'chat_id'=>$id,
                'hashtag'=>$hashtag
            ];
           $database->insert($data);
           return self::getTwit($hashtag);
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
            $database->where('hashtag','=',$hashtag)->where('invoke','=',false)->limit(1);
            $database->update(['invoke'=>true]);
            return $database->fetch();
        } catch (Exception $e) {

        }
    }





}