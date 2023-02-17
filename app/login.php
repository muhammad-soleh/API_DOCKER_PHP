<?php
include_once('./controller.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    login();
} else {
    $json = ["status" => 0, "Error" => "Request tidak dikenali"];
}
