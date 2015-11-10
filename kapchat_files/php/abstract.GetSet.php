<?php
   abstract class GetSet
   {
      function __set($wlasciwosc, $wartosc)
      {
         if(isset($this->$wlasciwosc))
            $this->$wlasciwosc = $wartosc;
         else
            echo '<p class="error">Podana właściwość ('.$wlasciwosc.') nie istnieje, nie można nadać jej konkretnej wartości!</p>';
      }
      function __get($wlasciwosc)
      {
         if(isset($this->$wlasciwosc))
            return $this->$wlasciwosc;
         else
            echo '<p class="error">Podana właściwość ('.$wlasciwosc.') nie istnieje!</p>';
         return false;
      }	
   }