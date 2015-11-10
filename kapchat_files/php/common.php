<?php
   require_once('abstract.GetSet.php');
   require_once('class.DBManager.php');
   require_once('../server_config.php');
   $connection = new DBManager;
   $connection->mysql = $cfg_mysql;
   $connection->postgres = $cfg_postgres;
   $connection->db_engine = $cfg_db_engine;
   try{
      $db = $connection->connect();
   }
   catch(Exception $e){
      echo 'false FILE: '.basename($e->getFile()).
                ' LINE: '.$e->getLine().
                ' MESSAGE: '.$e->getMessage();
      die();
   }
