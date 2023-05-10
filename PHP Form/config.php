<?php
    //Used to throw mysqli_sql_exceptions for database errors 
    // instead of a normal PHP warning
   // mysqli_report(MYSQLI_REPORT_STRICT);
    
    /* Database credentials. Assuming you are running MySQL
    server with default setting (user 'root' with no password) 
    or use appuser
    */
   // define('DB_SERVER', 'localhost');
   // define('DB_USERNAME', 'appuser'); 
   // define('DB_PASSWORD', 'password');
   // define('DB_NAME', 'demo');
     
    /* Attempt to connect to MySQL database */
   // try{
    //    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
   //     }
  //  catch(mysqli_sql_exception $e){
    //    throw $e;
    //    }
    <?php

    // Replace the following with your database credentials
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'appuser');
    define('DB_PASSWORD', 'password');
    define('DB_NAME', 'new3');
    
    // Attempt to connect to the database
    try {
        $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    } catch(mysqli_sql_exception $e) {
        throw $e;
    }
    
    ?>
    
?>