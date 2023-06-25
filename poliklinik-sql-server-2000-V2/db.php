<?php

// Koneksi ke SQL server 2000
$server = "DESKTOP-CBP3V6T";
$database = "Eksis_RB";
$username = "admin";
$password = "adm";

$conn = new PDO("odbc:Driver={SQL Server};Server=$server;Database=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
