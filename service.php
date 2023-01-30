<?php
include"koneksi.php";
function get_service($id=0) {
    global $koneksi;
    $query="SELECT * FROM service";
    $data=array();
    $result=$koneksi->query($query);
    while($row=mysqli_fetch_object($result))
    {
       $data[]=$row;
    }
    $response=array(
                   'status' => 1,
                   'message' =>'Data Service.',
                   'data' => $data
                );
    header('Content-Type: application/json');
    echo json_encode($response);
}
function insert_service(){
    global $koneksi;
    parse_str(file_get_contents("php://input"),$data);
    $judul=mysqli_real_escape_string($koneksi,$data["judul"]);
    $deskripsi=mysqli_real_escape_string($koneksi,$data["deskripsi"]);
    
   
    $insert=mysqli_query($koneksi,"INSERT INTO service (judul,deskripsi) VALUES ('$judul','$deskripsi')");
    
    if($insert){
        $response=array('status' => 1,'status_message' =>'service berhasil ditambah.');
    }else{
        $response=array('status' => 0,'status_message' =>'service gagal ditambah.');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function update_service(){
 global $koneksi;
 parse_str(file_get_contents("php://input"),$data);
 $id=mysqli_real_escape_string($koneksi,$data["id"]);
 $judul=mysqli_real_escape_string($koneksi,$data["judul"]);
 $deskripsi=mysqli_real_escape_string($koneksi,$data["deskripsi"]);
 
 $update=mysqli_query($koneksi,"UPDATE service SET judul='$judul', deskripsi='$deskripsi' WHERE id='$id'");
 
 if($update){
 $response=array('status' => 1, 'status_message' =>'Serivice berhasil diupdate.');
 
 }else{
 $response=array('status' => 0, 'status_message' =>'Serivice gagal diupdate.');
}
 
header('Content-Type: application/json');
echo json_encode($response);

}
function delete_service(){
    global $koneksi;
    parse_str(file_get_contents("php://input"),$data);
    $id=mysqli_real_escape_string($koneksi,$data["id"]);
    $delete=mysqli_query($koneksi,"DELETE FROM service WHERE id='$id'");

    if($delete){
        $response=array('status' => 1,'status_message' =>'service berhasil dihapus.');

    }else{
        $response=array('status' => 0, 'status_message' =>'service gagal dihapus.');
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} 
$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method) {
case 'GET':
if(!empty($_GET['id'])) {

get_service(mysqli_real_escape_string($koneksi,$_GET['id']));
}
else {
get_service();
}
break;
case 'POST':
insert_service();
break;

case 'PUT':
update_service();
break;
 
case 'DELETE':
delete_service();
break;
    
default:
header("HTTP/1.0 405 Method Not Allowed");
break;
    
}
?>