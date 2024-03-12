<?php
// Include Database Configuration
include 'koneksi.php';

// Read Data from Web
$detStat = $_GET['detStat'];
// $detStat = 9;

$detStat = intval($detStat);

$changeDetStat = mysqli_query($koneksi, "UPDATE mownydb.mownystatus set status='$detStat' where id='1' ");

// echo "From Gemini ".$detStat;
echo $detStat;