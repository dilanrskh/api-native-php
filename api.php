<?php

require_once "koneksi.php";

if(function_exists($_GET['function'])){
    $_GET['function']();
}

// Get Data Users
// URL DESIGN Get Data Users:
// localhost/api-native/api.php?function=getUsers
function getUsers(){

    // Permintaan ke server
    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object($query)){
        $users[] = $data;
    }

    // Menghasilkan response server
    $respon = array(
        'status'    => 1,
        'message'   => 'Success get users',
        'users'     => $users
    );

    // Menampilkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);

}

// Insert Data User
// URL DESIGN Insert Data User:
// localhost/api-native/api.php?function=addUser
function addUser(){
    
    global $koneksi;

    $parameter = array(
        'nama' => '', 
        'alamat' => ''
    );

    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){

        $nama   = $_POST['nama'];
        $alamat = $_POST['alamat'];
        
        $result = mysqli_query($koneksi, "INSERT INTO users VALUES('', '$nama', '$alamat')");

        if($result){
            return message(1, "Insert data $nama success");
        }else{
            return message(0, "Insert data failed");
        }

    }else{
        return message(0, "Parameter Salah");
    }

}

function message($status, $msg){

    $respon = array(
            'status'    => $status,
            'message'   => $msg
    );

    // Menampilkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);
}

// Update Data User
// URL DESIGN Update Data User:
// localhost/api-native/api.php?function=updateUser&id=(id)

function updateUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $parameter = array(
        'nama' => "",
        'alamat' => ""
    );

    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){

        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];

        $result = mysqli_query($koneksi, "UPDATE users SET nama='$nama', alamat='$alamat' WHERE id='$id'");

        if($result){
            return message(1, "update data $nama berhasil");
        }else{
            return message(0, "update data gagal");
        }

    }else{
        return message(0, "parameter salah");
    }

}

// Delete Data User
// URL DESIGN Delete Data User:
// localhost/api-native/api.php?function=deleteUser&id=(id)

function deleteUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    if($result){
        return message(1, "delete data berhasil");
    }else{
        return message(0, "delete data gagal");
    }


}


// Detail Data User per id
// URL DESIGN Delete Data User:
// localhost/api-native/api.php?function=detailuser&id=(id)

function detailUser(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result = $koneksi->query("SELECT * FROM users WHERE id='$id'");

    while($data = mysqli_fetch_object($result)){
        $detailuser[] = $data;
    }

    if($detailuser){
        $respon = array(
            'status' => 1,
            'message' => "Sukses muncul detail ",
            'user' => $detailuser
        );
    }else{
        return message(0, "Datanya ngak ketemu cuy");
    }

      // Menampilkan data dalam bentuk JSON
      header('Content-Type: application/json');
      print json_encode($respon);
  


}
?>