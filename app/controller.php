<?php
include('./conn.php');

function addData()
{
    global $connection;
    $input = json_decode(file_get_contents('php://input'));

    $nama_produk = $input->nama_produk;
    $harga_produk = $input->harga_produk;
    $deskripsi_produk = $input->deskripsi_produk;
    $link_produk = $input->link_produk;

    $sql = "INSERT INTO `api_coba`.`produk` (`nama_produk`, `harga_produk`, `link_produk`, `dekripsi_produk`) VALUES ('$nama_produk', '$harga_produk', '$link_produk', '$deskripsi_produk');";

    $kirim_data = mysqli_query($connection, $sql);
    if ($kirim_data) {
        $json = ["status" => 1, "Success" => "Data produk berhasil ditambahkan"];
    } else {
        $json = ["status" => 0, "Error" => "Data tidak berhasil ditambahkan"];
    };
    @mysqli_close($connection);
    header('Content-type: application/json');
    echo json_encode($json);
}

function getData()
{
    global $connection;

    $nama = isset($_GET['nama']) ? mysqli_real_escape_string($connection, $_GET['nama']) :  "";
    if ($nama != "") {
        $sql = "SELECT * FROM `api_coba`.`produk` WHERE nama_produk='{$nama}';";
    } else {
        $sql = "SELECT * FROM `api_coba`.`produk`";
    }


    $get_data_query = mysqli_query($connection, $sql) or die(mysqli_error($connection));
    if (mysqli_num_rows($get_data_query) != 0) {
        $result = array();

        while ($r = mysqli_fetch_array($get_data_query)) {
            extract($r);
            $result[] = array("id" => $id, "nama_produk" => $nama_produk, "harga_produk" => $harga_produk, 'link_produk' => $link_produk, 'deskripsi_produk' => $dekripsi_produk);
        }
        $json = array("status" => 1, "data" => $result);
    } else {
        $json = array("status" => 0, "error" => "To-Do not found!");
    }
    @mysqli_close($connection);
    // Set Content-type to JSON
    header('Content-type: application/json');
    echo json_encode($json);
}

function editData()
{
    global $connection;
    $id = $_GET['id'];
    $sql = mysqli_query($connection, "SELECT * FROM `api_coba`.`produk` WHERE id='{$id}';");
    // print_r($sql);
    if (mysqli_num_rows($sql) == 0) {
        $json = ['status' => 0, 'Error' => "Data tidak ditemukan"];
    } else {
        $input = json_decode(file_get_contents('php://input'));
        $nama_produk = mysqli_real_escape_string($connection, $input->nama_produk);
        $harga_produk = mysqli_real_escape_string($connection, $input->harga_produk);
        $deskripsi_produk = mysqli_real_escape_string($connection, $input->deskripsi_produk);
        $link_produk = mysqli_real_escape_string($connection, $input->link_produk);

        $sql2 = "UPDATE produk SET nama_produk = '$nama_produk', harga_produk = '$harga_produk', dekripsi_produk = '$deskripsi_produk', link_produk = '$link_produk' WHERE id='{$id}'";

        $kirim_data = mysqli_query($connection, $sql2);
        if ($kirim_data) {
            $json = ["status" => 1, "Success" => "Data produk berhasil di ubah"];
        } else {
            $json = ["status" => 0, "Error" => "Data tidak berhasil di ubah"];
        }
    }
    @mysqli_close($connection);
    // Set Content-type to JSON
    header('Content-type: application/json');
    echo json_encode($json);
}


function deleteData()
{
    global $connection;
    $id = $_GET['id'];
    $sql = mysqli_query($connection, "SELECT * FROM `api_coba`.`produk` WHERE id='{$id}';");
    if (mysqli_num_rows($sql) != 0) {
        $sql2 = "DELETE FROM produk WHERE id='{$id}'";
        $kirim_data = mysqli_query($connection, $sql2);
        if ($kirim_data) {
            $json = ["status" => 1, "Success" => "Data produk berhasil dihapus"];
        } else {
            $json = ["status" => 0, "Error" => "Data tidak berhasil dihapus"];
        }
    } else {
        $json = ['status' => 0, 'Error' => 'Data tidak ditemukan'];
    }
    @mysqli_close($connection);
    // Set Content-type to JSON
    header('Content-type: application/json');
    echo json_encode($json);
}

function checkToken()
{
    global $connection;
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $sql = mysqli_query($connection, "SELECT * FROM `api_coba`.`user` WHERE token='{$token}';");
        if (mysqli_num_rows($sql) != 0) {
            return true;
        } else {
            $json = ['status' => 0, 'Error' => 'Token tidak dikenali silahkan login pada /login.php'];
            @mysqli_close($connection);
            header('Content-type: application/json');
            echo json_encode($json);
        }
    }
}


// random string
function generateRandomString($length = 20)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function login()
{
    global $connection;

    $input = json_decode(file_get_contents('php://input'));
    $username = mysqli_real_escape_string($connection, $input->username);
    $password = mysqli_real_escape_string($connection, $input->password);

    $sql = mysqli_query($connection, "SELECT * FROM user");
    $data = mysqli_fetch_array($sql);


    if ($username === $data['username'] && $password === $data['password']) {
        $key = generateRandomString();
        mysqli_query($connection, "UPDATE user SET token='{$key}' WHERE username='{$username}'");
        $json = ['status' => 1, 'Key' => $key];
    } else {
        $json = ['status' => 0, 'Error' => "username atau password salah"];
    }


    @mysqli_close($connection);
    header('Content-type: application/json');
    echo json_encode($json);
}
