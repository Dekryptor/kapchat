<?php
   require_once('common.php');
   require_once('class.Chat.php');
   require_once('class.UserInfo.php');

   $user = new UserInfo();
   $hash = $user->getHash($cfg_antyspam, $cfg_check_browser);
   $chat = new Chat($db, $cfg_db_engine, $hash);
   $chat->current_hash = $hash;
   $added = $chat->add($cfg_max_messages);
   echo $added;
