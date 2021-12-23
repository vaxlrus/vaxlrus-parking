<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Parking;

$zeroParking = new Parking(0);
$minusParking = new Parking(-20);
?>