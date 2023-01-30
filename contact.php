<?php
include"koneksi.php";
function get_contact($id=0) {
    global $koneksi;
    $query="SELECT * FROM contact";
    $data=array();
    $result=$koneksi->query($query);
    while($row=mysqli_fetch_object($result))
    {
       $data[]=$row;
    }
    $response=array(
                   'status' => 1,
                   'message' =>'Get contact Successfully.',
                   'data' => $data
                );
    header('Content-Type: application/json');
    echo json_encode($response);
}
function insert_contact(){
    global $koneksi;
    parse_str(file_get_contents("php://input"),$data);
    $alamat=mysqli_real_escape_string($koneksi,$data["alamat"]);
    $email=mysqli_real_escape_string($koneksi,$data["email"]);
    $telepon=mysqli_real_escape_string($koneksi,$data["telepon"]);
    
   
    $insert=mysqli_query($koneksi,"INSERT INTO contact (alamat,email,telepon) VALUES ('$alamat','$email','$telepon')");
    
    if($insert){
        $response=array('status' => 1,'status_message' =>'Contact berhasil ditambah.');
    }else{
        $response=array('status' => 0,'status_message' =>'Contact gagal ditambah.');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function update_contact(){
 global $koneksi;
 parse_str(file_get_contents("php://input"),$data);
 $id=mysqli_real_escape_string($koneksi,$data["id"]);

 $alamat=mysqli_real_escape_string($koneksi,$data["alamat"]);
 $email=mysqli_real_escape_string($koneksi,$data["email"]);
 $telepon=mysqli_real_escape_string($koneksi,$data["telepon"]);
 
 $update=mysqli_query($koneksi,"UPDATE contact SET alamat='$alamat', email='$email', telepon='$telepon' WHERE id='$id'");
 
 if($update){
 $response=array('status' => 1, 'status_message' =>'Contact berhasil diupdate.');
 
 }else{
 $response=array('status' => 0, 'status_message' =>'Contact gagal diupdate.');
}
 
header('Content-Type: application/json');
echo json_encode($response);

}

 
$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method) {
case 'GET':
if(!empty($_GET['id'])) {

get_contact(mysqli_real_escape_string($koneksi,$_GET['id']));
}
else {
get_contact();
}
break;
case 'POST':
insert_contact();
break;

case 'PUT':
update_contact();
break;
    
default:
header("HTTP/1.0 405 Method Not Allowed");
break;
    
}
?>