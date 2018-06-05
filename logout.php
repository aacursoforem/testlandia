<?php

session_start();
$_SESSION = array();
session_regenerate_id(true);
session_destroy();

header("location:http://localhost:8080/testlandia/index.php");

?>