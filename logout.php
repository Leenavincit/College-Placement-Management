<?php
session_start();
session_destroy();

// redirect to main portal page
header("Location: index.php"); 
exit();
?>