<?php
   class DBManager extends GetSet
   {
      protected $mysql = array('host'=>'',
                               'user'=>'', 
                               'pass'=>'',
                               'base'=>'',
                               'port'=>'');

      protected $postgres = array('host'=>'',
                                  'user'=>'', 
                                  'pass'=>'',
                                  'base'=>'',
                                  'port'=>'');

      protected $db_engine = 'mysql'; // mysql, postrges
	
      function connect()
      {

         switch($this->db_engine)
         {
            case 'mysql':
               try
               {
                  $db = new PDO('mysql:host='.$this->mysql['host'].';
                                 dbname='.$this->mysql['base'].';
                                 encoding=utf8', 
                                 $this->mysql['user'], 
                                 $this->mysql['pass'] );
                  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               }
               catch(PDOException $e)
               {
                  throw new Exception('DB connection error.');
               }
               break;
            case 'postgres':
               try
               {
                  $db = new PDO();
                  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               }
               catch(PDOException $e)
               {
                  throw new Exception('DB connection error.');
               }
               break;
           default:
               throw new Exception('No DB selected.'); 
         }
         return $db;

      }
   }
