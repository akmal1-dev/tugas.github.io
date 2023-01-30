<?php
include"koneksi.php";
function get_about($id=0) {
    global $koneksi;
    $query="SELECT * FROM about";
    $data=array();
    $result=$koneksi->query($query);
    while($row=mysqli_fetch_object($result))
    {
       $data[]=$row;
    }
    $response=array(
                   'status' => 1,
                   'message' =>'Get List About Successfully.',
                   'data' => $data
                );
    header('Content-Type: application/json');
    echo json_encode($response);
}
function insert_about(){
    global $koneksi;
    parse_str(file_get_contents("php://input"),$data);
    $about_kiri=mysqli_real_escape_string($koneksi,$data["about_kiri"]);
    $about_kanan=mysqli_real_escape_string($koneksi,$data["about_kanan"]);
    
   
    $insert=mysqli_query($koneksi,"INSERT INTO about (about_kiri,about_kanan) VALUES ('$about_kiri','$about_kanan')");
    
    if($insert){
        $response=array('status' => 1,'status_message' =>'About berhasil ditambah.');
    }else{
        $response=array('status' => 0,'status_message' =>'About gagal ditambah.');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function update_about(){
 global $koneksi;
 parse_str(file_get_contents("php://input"),$data);
 $id=mysqli_real_escape_string($koneksi,$data["id"]);
 
 $about_kiri=mysqli_real_escape_string($koneksi,$data["about_kiri"]);
 $about_kanan=mysqli_real_escape_string($koneksi,$data["about_kanan"]);
 
 $update=mysqli_query($koneksi,"UPDATE about SET about_kiri='$about_kiri', about_kanan='$about_kanan' WHERE id='$id'");
 
 if($update){
 $response=array('status' => 1, 'status_message' =>'About berhasil diupdate.');
 
 }else{
 $response=array('status' => 0, 'status_message' =>'About gagal diupdate.');
}
 
header('Content-Type: application/json');
echo json_encode($response);

}
function delete_about(){
    global $koneksi;
    parse_str(file_get_contents("php://input"),$data);
    $id=mysqli_real_escape_string($koneksi,$data["id"]);
    $delete=mysqli_query($koneksi,"DELETE FROM about WHERE id='$id'");

    if($delete){
        $response=array('status' => 1,'status_message' =>'About berhasil dihapus.');

    }else{
        $response=array('status' => 0, 'status_message' =>'About gagal dihapus.');
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} 
//Seleksi jenis method yang dipilih
$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method) {
case 'GET':
if(!empty($_GET['id'])) {

get_about(mysqli_real_escape_string($koneksi,$_GET['id']));
}
else {
get_about();
}
break;
case 'POST':
insert_about();
break;

case 'PUT':
update_about();
break;
 
case 'DELETE':
delete_about();
break;
    
default:
header("HTTP/1.0 405 Method Not Allowed");
break;
    
}
?>