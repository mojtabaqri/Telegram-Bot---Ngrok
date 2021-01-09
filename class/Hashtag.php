<?php


use SleekDB\SleekDB;

class Hashtag
{

    public static function distinct($hashTags){//check if hashtag exist
        $database=SleekDB::store('hashtags',$_ENV['dataDir']);
        try {
            if($record = $database->where( 'hashtag', '=',$hashTags)->fetch())
                return True;
        } catch (Exception $e) {
            return 'مشکلی در سیستم پیش آمده است در حال بررسی آن هستیم !';

        }
    }

    public  function saveHashtag($hashtag)
    {
        if ($this->distinct($hashtag))
            return 'هشتگ تکراری است ! شما نمیتوانید یک هشتگ را چند بار به سیستم اضافه کنید!';
        try {
            $database = SleekDB::store('hashtags', $_ENV['dataDir']);
            $data=[
                'hashtag'=>$hashtag,
            ];
             $database->insert($data);
             return 'با موفقیت ذخیره شد!';
        } catch (Exception $e) {

        }
    }

    public static function getHashtags()
    {
        try {
            $database = SleekDB::store('hashtags', $_ENV['dataDir']);
            return $database->limit(10)->fetch();
        } catch (Exception $e) {

        }
    }
}