<?php
ob_start();
$API_KEY = 'توكن';
#---BY @iyahoo---#
#---Ch @TeamMemo---#
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url); curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{return json_decode($res);}}
#---func---#
function sendmessage($chat_id, $text, $model){
    bot('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>$mode
  ]);
 }
#---@iyahoo---#
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$chat_id = $message->chat->id;
$name = $message->from->first_name;
$from_id = $message->from->id;
$user = $update->message->from->username;
$sudo = 367759364; #ايديك
$gp_get = file_get_contents("memo/groups.txt");
$groups = explode("\n", $gp_get);
#---By Memo---#
$get = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=$chat_id&user_id=".$from_id);
$info = json_decode($get, true);
$you = $info['result']['status'];
#---@iyahoo---#
$ch = file_get_contents("memo/$chat_id/ch.txt");

$lockjoin = file_get_contents("memo/$chat_id/lockjoin.txt");
$setch = file_get_contents("memo/$chat_id/setch.txt");
$add = file_get_contents("memo/$chat_id/add.txt");

#---@iyahoo---#
$join = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@$ch&user_id=".$from_id);
if($message && (strpos($join,'"status":"left"') or strpos($join,'"Bad Request: USER_ID_INVALID"') or strpos($join,'"status":"kicked"'))!== false){
if($add == "memo" ){
if($lockjoin == "memo" ){
bot('sendMessage', [
'chat_id'=>$chat_id,
 'text'=>"عفوا صديقي @$user 
عليك الاشتراك في قناة المجموعه لتتمكن من التكلم هنا 
سأقوم بتكرار هذة الرساله عليك ان لم تشترك في القناة @$ch .",
]);return false;
}}}
#---@iyahoo---#
if($you == "creator" or $you == "administrator"){
if($add == "memo" ){
if($text=="تغير القناة"){
        file_put_contents("memo/$chat_id/setch.txt", "set");
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"ارسل معرف القناة بدون علامة الـ @ .",
            'reply_to_message_id'=>$message->message_id,
        ]);
    }
    if($text !== "تغير القناة" && $text == "$text" and file_exists("memo/$chat_id/setch.txt")){
    file_put_contents("memo/$chat_id/ch.txt","$text");
        bot('sendMessage',[
            'chat_id'=>$chat_id,
            'text'=>"تم تغير القناة الى  @$text .

الان قم برفع البوت ادمن على تلك القناة ",       
'reply_to_message_id'=>$message->message_id,
        ]);
        unlink("memo/$chat_id/setch.txt");
    }
   }
  }
if($you == "creator" or $you == "administrator"){
if($add == "memo" ){
if($lockjoin == "Not" ){ 
if($text == "تفعيل الاشتراك"){
file_put_contents("memo/$chat_id/lockjoin.txt", "memo");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>تم تفعيل الإشتراك .</b>",
    'reply_to_message_id'=>$message->message_id,
'parse_mode'=>"html",
]);
 }
}
if($lockjoin == "memo" ){ 
if($text == "تفعيل الاشتراك"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>تم تفعيل الاشتراك بالفعل .</b>",
    'reply_to_message_id'=>$message->message_id,
'parse_mode'=>"html",
]);
 }
}
}
}
if($you == "creator" and $you == "administrator" or $from_id == $sudo){
if($add == "memo" ){
if($lockjoin == "memo" ){
if($text == "تعطيل الاشتراك"){
file_put_contents("memo/$chat_id/lockjoin.txt", "Not");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>تم تعطيل الاشتراك .</b>",
    'reply_to_message_id'=>$message->message_id,
'parse_mode'=>"html",
]);
}
}
if($lockjoin == "Not" ){
if($text == "تعطيل الاشتراك"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>تم تعطيل الاشتراك مسبقا .</b>",
    'reply_to_message_id'=>$message->message_id,
'parse_mode'=>"html",
   ]);
  }
 }
}
}
#---@iyahoo---#

if($you == "creator" or $you == "administrator"){
if($text == "تفعيل"){
mkdir("memo/$chat_id");
file_put_contents("memo/$chat_id/lockjoin.txt","Not");
file_put_contents("memo/$chat_id/add.txt","memo");
file_put_contents("memo/groups.txt", "$chat_id\n",FILE_APPEND);
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"<b>تم تفعيل المجموعه 
بنجاح .</b>",
'reply_to_message_id'=>$message->message_id,
  'parse_mode'=>'html',
    ]);
   }
   if($text == "تعطيل"){
rmdir("memo/$chat_id");
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"<b> تم تعطيل المجموعه .</b>",
 'reply_to_message_id'=>$message->message_id,
  'parse_mode'=>'html',
    ]);
   }
  }
  $type = $update->message->chat->type;
  if($text=="/start" and $type == "private"){
  
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"<b> مرحبا بك صديقي $name 
انا بوت متخصص في ادارة الاشتراكات داخل المجموعه 

فقط اضفني لمجموعتك و ارسل كلمة (تفعيل)

من ثم ارسل (الاوامر) .
</b>",
  'parse_mode'=>'html',
    ]);
    }
    #--@iyahoo--#
    $memo12 = file_put_contents("memo/memousr.txt");
if($text == "اذاعه" and $from_id == $sudo){
    file_put_contents("memo/memousr.txt","gp");
    bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"ارسل الاذاعه الان .",  'reply_to_message_id'=>$message->message_id
  ]);
  }
if($text !== "اذاعه" && $text == "$text" and file_exists("memo/memousr.txt")){
$c = count($groups)-1;
bot('sendMessage',[
          'chat_id'=>$chat_id,
          'text'=>"تم ارسال الرسالة الى {$c} .",    'reply_to_message_id'=>$message->message_id
          ]);
    for ($i=0; $i < count($groups); $i++) { 
        bot('sendMessage',[
          'chat_id'=>$groups[$i],
          'text'=>"$text",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,

]);
 unlink("memo/memousr.txt");
} 
}
#--@iyahoo--#
if($text == "المجموعات" and $from_id == $sudo){
$c = count($groups)-1;
bot('sendMessage',[
          'chat_id'=>$chat_id,
          'text'=>"$c",
'reply_to_message_id'=>$message->message_id,
]);
}
#--@iyahoo--#
if($text == "الاوامر"){
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"<b> تفعيل 
تعطيل
تفعيل الاشتراك > ليتم تفعيل الاشتراك على الاعضاء 
تعطيل الاشتراك > لتعطيله على الاعضاء 

تغير القناة > ليتم تغير قناة اليشترك بها 

………………………………………………………………
</b> by: @TeamMemo .",
 'reply_to_message_id'=>$message->message_id,
  'parse_mode'=>'html',
    ]);
   }
