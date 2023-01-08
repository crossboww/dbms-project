<?php
/* */
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','root');

//connecting to database
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
//connection checking connection
if($conn==false){
    dir("connection failed");
}
?>