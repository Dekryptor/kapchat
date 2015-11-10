<?php
   require_once('common.php');
   require_once('class.Chat.php');

   $chat = new Chat($db, $cfg_db_engine);
   $json = $chat->show($cfg_range);
   echo $json;
