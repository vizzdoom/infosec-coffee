<?php
include("includes.php");
echo "[i] Database reset procedure in progress... ";

global $conn;
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
$dump = file_get_contents("reset-only-schema.sql");
$conn->multi_query($dump);
echo "[+] Done";

setFlash("<div class='alert alert-warning'>Infosec Coffee data have been reset to initial values.</div>");
header("Location: index.php");