<?php
     define('DB_DSN','mysql:host=localhost;dbname=final_project_webdev2;charset=utf8');
     define('DB_USER','root');
     define('DB_PASS','');     
     
    //  PDO is PHP Data Objects 
    //  mysqli <-- BAD. 
    //  PDO <-- GOOD.
     try {
         // Try creating new PDO connection to MySQL.
         $db = new PDO(DB_DSN, DB_USER, DB_PASS);
         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch (PDOException $e) {
         print "Error: " . $e->getMessage(); 
         die(); 
     }  
 ?>