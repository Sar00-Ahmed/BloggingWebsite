<?php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'Temp');
define('DB_PASSWORD', 'Ttempo6&^');
define('DB_NAME', 'blog_system');



//PDO connection
try{
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);   
}
catch(PDOException $e){
    echo "failed to connect to database";
}


?>