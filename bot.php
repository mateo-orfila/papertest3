<?php
$API_KEY = '108813923:AAGqGU9EcRDn4t2kDi1GL9HiPKPnUMlgu3U';
define('API_KEY', $API_KEY);

function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
$res = curl_exec($ch);
if (curl_error($ch)) {
    var_dump(curl_error($ch));
} else {
    return json_decode($res);
}
}

$update     = json_decode(file_get_contents('php://input'));
$message    = $update["message"]
$text       = $message->text;
$chat_id    = $message->chat->id;
$from_id    = $message->from->id;
$new_member = $message->new_chat_member->id;
$memberid   = file_get_contents('whitelist.txt'); //put userid in whitelist.txt
$whitelist  = explode("\n", $memberid);

if ($new_member) {
    if (!in_array($chat_id, $whitelist)) {
           bot('kickChatMember',[
          'chat_id'=>$chat_id,
          'user_id'=>$message->new_chat_member->id]);
    }
}
?>