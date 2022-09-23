<?php
$name = "";
$phone = "";
$email = "";
$address = "";
$birth_day = "";
$id_front = "";
$id_back = "";

if (isset($_GET["username"])) {
  $profile = get_profile($_GET["username"]);
  require_once "../general/get_profile.php";
}

$name = $profile["FullName"];
$phone = $profile["PhoneNumber"];
$email = $profile["Email"];
$address = $profile["Address"];
$id_front = $profile["IdPhotoFront"];
$id_back = $profile["IdPhotoBack"];
$birth_day = $profile["DateOfBirth"];
