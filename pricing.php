<?php
include"koneksi.php";
function get_pricing($id=0) {
    global $koneksi;
    $query="SELECT * FROM pricing";
    $data=array();
    $result=$koneksi->query($query);
    while($row=mysqli_fetch_object($result))
    {
       $data[]=$row;
    }
    $response=array(
                   'status' => 1,
                   'message' =>'Get pricing Successfully.',
                   'data' => $data
                );
    header('Content-Type: application/json');
    echo json_encode($response);
}
//REST API unutukk menyimpan data mahasiswa kemudian mengirimkan mengirimkan status berupa array data JSON ke client
function insert_pricing(){
    global $koneksi;
    parse_str(file_get_contents("php://input"),$data);
    $judul=mysqli_real_escape_string($koneksi,$data["judul"]);
    $harga=mysqli_real_escape_string($koneksi,$data["harga"]);
    $reward_satu=mysqli_real_escape_string($koneksi,$data["reward_satu"]);
    $reward_dua=mysqli_real_escape_string($koneksi,$data["reward_dua"]);
    $reward_tiga=mysqli_real_escape_string($koneksi,$data["reward_tiga"]);
    $reward_empat=mysqli_real_escape_string($koneksi,$data["reward_empat"]);
    $reward_lima=mysqli_real_escape_string($koneksi,$data["reward_lima"]);
    $reward_enam=mysqli_real_escape_string($koneksi,$data["reward_enam"]);
    
   
    $insert=mysqli_query($koneksi,"INSERT INTO pricing (judul,harga,reward_satu) VALUES ('$judul','$harga','$reward_satu','$reward_dua','$reward_tiga','$reward_empat','$reward_lima','$reward_enam')");
    
    if($insert){
        $response=array('status' => 1,'status_message' =>'pricing berhasil ditambah.');
    }else{
        $response=array('status' => 0,'status_message' =>'pricing gagal ditambah.');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function update_pricing(){
 global $koneksi;
 parse_str(file_get_contents("php://input"),$data);
 $id=mysqli_real_escape_string($koneksi,$data["id"]);

 $judul=mysqli_real_escape_string($koneksi,$data["judul"]);
 $harga=mysqli_real_escape_string($koneksi,$data["harga"]);
 $reward_satu=mysqli_real_escape_string($koneksi,$data["reward_satu"]);
 $reward_dua=mysqli_real_escape_string($koneksi,$data["reward_dua"]);
 $reward_tiga=mysqli_real_escape_string($koneksi,$data["reward_tiga"]);
 $reward_empat=mysqli_real_escape_string($koneksi,$data["reward_empat"]);
 $reward_lima=mysqli_real_escape_string($koneksi,$data["reward_lima"]);
 $reward_enam=mysqli_real_escape_string($koneksi,$data["reward_enam"]);
 
 $update=mysqli_query($koneksi,"UPDATE pricing SET judul='$judul', harga='$harga', reward_satu='$reward_satu', reward_dua='$reward_dua' , reward_tiga='$reward_tiga' , reward_empat='$reward_empat' , reward_lima='$reward_ lima' , reward_enam='$reward_enam' WHERE id='$id'");
 
 if($update){
 $response=array('status' => 1, 'status_message' =>'Pricing berhasil diupdate.');
 
 }else{
 $response=array('status' => 0, 'status_message' =>'Pricing gagal diupdate.');
}
 
header('Content-Type: application/json');
echo json_encode($response);

}

 
$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method) {
case 'GET':
if(!empty($_GET['id'])) {

get_pricing(mysqli_real_escape_string($koneksi,$_GET['id']));
}
else {
get_pricing();
}
break;
case 'POST':
insert_pricing();
break;

case 'PUT':
update_pricing();
break;
    
default:
header("HTTP/1.0 405 Method Not Allowed");
break;
    
}
?>