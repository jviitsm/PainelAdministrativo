<?php
session_start();
$_SESSION = [];
header("location: ../../index.php");
session_destroy();

exit();

?>