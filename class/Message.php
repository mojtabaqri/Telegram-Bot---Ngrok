<?php
class Message
{
    private $update_id;
    private $message;
    private $chat_id;

    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chat_id;
    }
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
    public function SendMessage($text,$reply=null){
        if ($reply==null)
            $reply=Keyboard::UserKeyboard($this->user()['id']);
        $this->api('sendMessage',[
            'chat_id'=>$this->chat_id,
            'text'=>$text,
            'reply_markup'=>$reply,
            'parse_mode'=>'MarkDown']);
    }
    private function commands($cmd){
        if(strpos($cmd,'#')===0){
          $data=Twit::userRequestTwit($this->user()['id'],$cmd);
          if(is_array($data))
              foreach ($data as $item)
                  $this->SendMessage($item['hashtag'].PHP_EOL.$item['content']);
              else
                  $this->SendMessage($data);

          return false;
      }
            switch ($cmd) {
                case "/start":
                    if (User::CheckUser($this->user()))
                        $this->SendMessage($this->user()['first_name'] . ' عزیز  ' . PHP_EOL . ' شما قبلا ثبت نام کرده اید نیاز به ثبت نام مجدد نمیباشد ');
                    else
                        $this->SendMessage(User::save($this->user()));
                    break;

                case "درخواست توییت جدید":
                    $this->SendMessage('هشتگ مورد نظر را انتخاب کنید!', Keyboard::HashtagKeyboard());
                    break;

                case "ثبت توییت":
                    if (Admin::checkAdmin($this->user()['id']))
                        $this->SendMessage('این قسمت در دست تکمیل است!');
                    break;

                default:
                    $this->SendMessage('دستور ناشناخته بود !');
                    break;
            }
        }






}