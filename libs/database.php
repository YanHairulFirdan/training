<?php

$connection = mysqli_connect(
  "localhost", 
  "root", 
  "", 
  "training"
);

if (! $connection) {
  die("Connection failed: " . mysqli_connect_error());
}