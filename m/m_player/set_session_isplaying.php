<?php
session_start();
$_SESSION["IsPlaying"] = "N";
session_write_close();
echo "OK";
?>
