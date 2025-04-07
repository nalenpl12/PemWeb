<?php
session_start();
session_destroy();
header("Location: FormLogin.html");
exit;
?>
