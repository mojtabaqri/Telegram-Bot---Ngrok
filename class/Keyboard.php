<?php


class Keyboard
{

    public static function UserKeyboard($id){
        if (Admin::checkAdmin($id))
        {
            $replyMarkup = array(
                'keyboard' => array(
                    array("درخواست توییت جدید",'ثبت توییت')
                ),
                'resize_keyboard'=>True,
            );
        }
        else{
            $replyMarkup = array(
                'keyboard' => array(
                    array("درخواست توییت جدید")
                ),
                'resize_keyboard'=>True,
            );
        }
        return $encodedMarkup = json_encode($replyMarkup);

    }

    public static function HashtagKeyboard(){
        $replyMarkup = array(
            'keyboard' => array(
                array_filter(array_column(Hashtag::getHashtags(), 'hashtag'))
            ),
            'resize_keyboard'=>True,
        );
        return $encodedMarkup = json_encode($replyMarkup);

    }








}