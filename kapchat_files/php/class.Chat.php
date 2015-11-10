<?php
class Chat extends GetSet
   {
      protected $db;
      protected $db_engine;
      protected $current_hash = false;
      protected $previous_hash;
      protected $counter;

      function __construct(PDO $db, $db_engine){
         $this->db = $db;
         $this->db_engine = $db_engine;
      }

      private function checkLast(){
         try{
            if($this->current_hash != false)
            {
               $sql['mysql'] = 'SELECT `hash`, `counter` FROM `kapchat` ORDER BY `message_id` DESC LIMIT 1';
               $sql['postgres'] = '';

               $result = $this->db->query($sql[$this->db_engine]);
               $arr = $result->fetch(PDO::FETCH_ASSOC);
               $result->closeCursor();
               $this->previous_hash = $arr['hash'];
               $this->counter = $arr['counter'];
            }
            return true;
         }
         catch(PDOException $e){
            return 'false FILE: '.basename($e->getFile()).
            ' LINE: '.$e->getLine().
            ' MESSAGE: Query error.';
         }
      }

      function add($maxMessages)
      {
         try{
            $this->checkLast();
            if($this->current_hash == false || $this->counter < $maxMessages || $this->current_hash != $this->previous_hash)
            {
               if($this->current_hash != false)
               {
                  if($this->current_hash == $this->previous_hash)
                     $this->counter++;
                  else
                     $this->counter = 1;
               }
               else
                  $this->counter = 0;


               $sql['mysql'] = 'INSERT INTO `kapchat` (`hash`, `counter`, `timestamp`, `nick`, `color`, `message`) VALUES(:hash, :counter, :timestamp, :nick, :color, :message)';
               $sql['postgres'] = '';

               $prep = $this->db->prepare($sql[$this->db_engine]);
               $prep->bindValue(':hash', $this->current_hash, PDO::PARAM_STR);
               $prep->bindValue(':counter', $this->counter, PDO::PARAM_INT);
               $prep->bindValue(':timestamp', time(), PDO::PARAM_INT);
               $prep->bindValue(':nick', htmlspecialchars($_POST['nick']), PDO::PARAM_STR);
               $prep->bindValue(':color', htmlspecialchars($_POST['color']), PDO::PARAM_STR);
               $prep->bindValue(':message', htmlspecialchars($_POST['message']), PDO::PARAM_STR);

               $added = $prep->execute();
               $id = $this->db->lastInsertId('message_id');
               return $added;
            }
            else
               return 'false spam';
         }
         catch(PDOException $e){
            return 'false FILE: '.basename($e->getFile()).
                        ' LINE: '.$e->getLine().
                        ' MESSAGE: Query error.';
         }
      }

      function show($range){
         try{
            $start_time = time() - 60 * 60 * $range;

            if($_POST['lastId'] == 0)
            {
               $sql['mysql'] = 'SELECT `message_id`, `nick`, `color`, `message`, `timestamp` FROM `kapchat` WHERE  `timestamp`>'.$start_time.' ORDER BY `message_id` ASC LIMIT 300';
               $sql['postgres'] = '';
               $result = $this->db->query($sql[$this->db_engine]);
               $arr = $result->fetchAll(PDO::FETCH_ASSOC);
               $result->closeCursor();
               $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
               return $json;
            }
            else
            {
               $sql['mysql'] = 'SELECT `message_id`, `nick`, `color`, `message`, `timestamp` FROM `kapchat` WHERE  `message_id`>:lastId ORDER BY `message_id` ASC LIMIT 300';
               $sql['postgres'] = '';
               $result = $this->db->prepare($sql[$this->db_engine]);
               $result->bindValue(':lastId', $_POST['lastId'], PDO::PARAM_INT);
               $result->execute();
               $arr = $result->fetchAll(PDO::FETCH_ASSOC);
               $result->closeCursor();
               $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
               return $json;
            }
         }
         catch(PDOException $e){
            return 'false FILE: '.basename($e->getFile()).
                        ' LINE: '.$e->getLine().
                        ' MESSAGE: Query error.';
         }
      }
   }

