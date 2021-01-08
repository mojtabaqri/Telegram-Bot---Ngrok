<?php
require 'Loader.php';
class Message
{
    private $update_id;
    private $message;
    private $chat_id;
    public function __construct($telegram_update)
    {
        $telegram_update=json_decode($telegram_update);
        $this->update_id=$telegram_update->update_id;
        $this->message=$telegram_update->message;
        $this->chat_id=$this->message->chat->id;
        $this->commands($this->message->text);
    }
    private function api($method,$datas=[]){
        $url = "https://api.telegram.org/bot".$_ENV['API_KEY']."/".$method;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
        $res = curl_exec($ch);
        if(curl_error($ch)){
            var_dump(curl_error($ch));
        }else{
            return json_decode($res);
        }
    }
    public function user(){
        $user=$this->message->from;
        return [
          'username'=>$user->username,
          'date'=>$this->message->date,
          'id'=>$user->id,
          'first_name'=>$user->first_name,
          'is_bot'=>$user->is_bot,
        ];
    }
    public function SendMessage($text){
        $replyMarkup = array(
            'keyboard' => array(
                array("درخواست توییت", "پیشنهاد توییت ")
            ),
            'resize_keyboard'=>True,
        );
        $encodedMarkup = json_encode($replyMarkup);
        $this->api('sendMessage',[
            'chat_id'=>$this->chat_id,
            'text'=>$text,
            'reply_markup'=>$encodedMarkup,
            'parse_mode'=>'MarkDown']);
    }
    private function commands($cmd){
        switch ($cmd) {
            case "/start":
                if (User::CheckUser($this->user()))
                    $this->SendMessage($this->user()['first_name'].' عزیز  '.PHP_EOL.' شما قبلا ثبت نام کرده اید نیاز به ثبت نام مجدد نمیباشد ');
                else
                    $this->SendMessage(User::save($this->user()));
                break;

            case "درخواست توییت":
                $this->SendMessage($this->message->message_id);
                break;

        }
    }




}