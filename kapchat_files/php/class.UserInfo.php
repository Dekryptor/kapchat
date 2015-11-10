<?php
   class UserInfo extends GetSet{

      private $ip;
      private $browser;

      function __construct(){
         $this->ip = $this->getIP();
         $this->browser = $this->getBrowser();
      }

      private function getIP(){
         $client  = @$_SERVER['HTTP_CLIENT_IP'];
         $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
         $remote  = $_SERVER['REMOTE_ADDR'];

         if(filter_var($client, FILTER_VALIDATE_IP))
         {
            $ip = $client;
         }
         elseif(filter_var($forward, FILTER_VALIDATE_IP))
         {
            $ip = $forward;
         }
         else
         {
            $ip = $remote;
         }

         return $ip;
      }

      private function getBrowser(){
         return $_SERVER['HTTP_USER_AGENT'];
      }

      function getHash($antyspam, $checkBrowser){
         if($antyspam == true && $checkBrowser == true)
            return md5($this->ip.$this->browser);
         else if($antyspam == true)
            return md5($this->ip);
         else
            return false;
      }

   }
