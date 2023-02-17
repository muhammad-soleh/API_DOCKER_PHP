<?php
include('./controller.php');

if (checkToken()) {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        addData();
    } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
        getData();
    } else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
        editData();
    } else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
        deleteData();
    } else {
        $json = ["status" => 0, "Error" => "Request tidak dikenali"];
    }
}
