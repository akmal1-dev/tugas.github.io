<?php
include"koneksi.php";
function get_mahasiswa($id=0) {
    global $koneksi;
      $query="SELECT * FROM mahasiswa";
      $data=array();
      $result=$koneksi->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get List Mahasiswa Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
}

function insert_mahasiswa(){
    global $koneksi;
    parse_str(file_get_contents("php://input"),$data);
    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];
    $result = array();

    if($method=='POST'){
        if(isset($_POST['npm']) AND isset($_POST['nama']) AND isset($_POST['email']) AND isset($_POST['jurusan'])){
            $npm = $_POST['npm'];
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $jurusan = $_POST['jurusan'];

            $foto_tmp = $_FILES['foto']['tmp_name'];
            $nama_foto = $_FILES['foto']['name'];

            move_uploaded_file($foto_tmp, 'image/'.$nama_foto);

            $result['status'] = [
                "code" => 200,
                "description" => '1 Data Insert'
            ];
            
            $insert=mysqli_query($koneksi,"INSERT INTO mahasiswa (npm,nama,email,jurusan,foto) VALUES ('$npm','$nama','$email','$jurusan','$nama_foto')");
            
            $result['results'] = [
                "npm" => $npm,
                "nama" => $nama,
                "email" => $email,
                "jurusan" => $jurusan
            ];
        }else{
            $result['status'] = [
                "code" => 400,
                "description" => 'parameter invalid'
            ];
        }
    }else{
        $result['status'] = [
            "code" => 400,
            "description" => 'Method Not Valid'
        ];
    }

    echo json_encode($result);
}

function update_mahasiswa(){
    global $koneksi;
    header('Content-Type: application/json');

    parse_str(file_get_contents("php://input"),$data);
    $id=mysqli_real_escape_string($koneksi,$data["id"]);

    $method = $_SERVER['REQUEST_METHOD'];
    $result = array();

    if($method=='PUT'){
        if(isset($_PUT['npm']) AND isset($_PUT['nama']) AND isset($_PUT['email']) AND isset($_PUT['jurusan']) AND isset($_PUT['foto'])){
            $npm = $_PUT['npm'];
            $nama = $_PUT['nama'];
            $email = $_PUT['email'];
            $jurusan = $_PUT['jurusan'];

            $foto_tmp = $_FILES['foto']['tmp_name'];
            $nama_foto = $_FILES['foto']['name'];

            move_uploaded_file($foto_tmp, 'image/'.$nama_foto);

            $result['status'] = [
                "code" => 200,
                "description" => '1 Data Update'
            ];
            
            $update=mysqli_query($koneksi,"UPDATE mahaiswa SET npm='$npm', nama='$nama', email='$email', jurusan='$jurusan', foto='$nama_foto' WHERE id='$id'");
            
            $result['results'] = [
                "npm" => $npm,
                "nama" => $nama,
                "email" => $email,
                "jurusan" => $jurusan
                // "foto" => $nama_foto
            ];
        }else{
            $result['status'] = [
                "code" => 400,
                "description" => 'parameter invalid'
            ];
        }
    }else{
        $result['status'] = [
            "code" => 400,
            "description" => 'Method Not Valid'
        ];
    }

    echo json_encode($result);

}

function delete_mahasiswa(){
    global $koneksi;
    parse_str(file_get_contents("php://input"),$data);
    $id=mysqli_real_escape_string($koneksi,$data["id"]);
    $delete=mysqli_query($koneksi,"DELETE FROM mahasiswa WHERE id='$id'");

    if($delete){
    $response=array(
    'status' => 1,
    'status_message' =>'Mahasiswa berhasil dihapus.');

    }else{
    $response=array(
    'status' => 0,
    'status_message' =>'Mahasiswa gagal dihapus.');
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}
    $request_method=$_SERVER["REQUEST_METHOD"];
    switch($request_method) {
        case 'GET':
        if(!empty($_GET['id'])) {
            get_mahasiswa(mysqli_real_escape_string($koneksi,$_GET['id']));
    }
    else {
        get_mahasiswa();
    }
    break;
    case 'POST':
    insert_mahasiswa();
    break;

    case 'PUT':
    update_mahasiswa();
    break;

    case 'DELETE':
    delete_mahasiswa();
    break;

    default:
    header("HTTP/1.0 405 Method Not Allowed");
    break;

    }
?>