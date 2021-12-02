<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "db_c1";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
   die('Tidak bisa terkoneksi ke database');
}
$idNakes             = "";
$namaNakes           = "";
$jabatan             = "";
$sukses              = "";
$error               = "";

if (isset($_GET['op'])) {
   $op = $_GET['op'];
} else {
   $op = "";
}
if($op == 'delete'){
   $idNakes       = $_GET['idNakes'];
   $sql1          = "delete from nakes where idNakes = '$idNakes'";
   $q1            = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses    = "Berhasil hapus data";
       $idNakes   = "";
   }else{
       $error  = "Gagal melakukan delete data";
   }
}
if ($op == 'edit') {
   $idNakes             = $_GET['idNakes'];
   $sql1                = "select * from nakes where idNakes = '$idNakes'";
   $q1                  = mysqli_query($koneksi, $sql1);
   $r1                  = mysqli_fetch_array($q1);
   $idNakes             = $r1['idNakes'];
   $namaNakes           = $r1['namaNakes'];
   $jabatan             = $r1['jabatan'];

   if ($idNakes == '') {
       $error = "Data tidak ditemukan";
   }
}

if (isset($_POST['simpan'])) { //Creater
   $idNakes          = $_POST['idNakes'];
   $namaNakes        = $_POST['namaNakes'];
   $jabatan          = $_POST['jabatan'];

   if ($idNakes && $namaNakes && $jabatan) {
      if ($op == 'edit') { //Update
         $sql1    = "update nakes set idNakes = '$idNakes', namaNakes = '$namaNakes', jabatan ='$jabatan' where idNakes = '$idNakes' ";
         $q1      = mysqli_query($koneksi, $sql1);
         if ($q1) {
            $sukses = "Data berhasil diupdate";
         } else {
            $error  = "Data gagal diupdate";
         }
      } else { //untuk insert
         $sql1   = "insert into nakes (idNakes,namaNakes,jabatan) values ('$idNakes','$namaNakes','$jabatan')";
         $q1     = mysqli_query($koneksi, $sql1);
         if ($q1) {
             $sukses     = "Berhasil memasukkan data baru";
         } else {
             $error      = "Gagal memasukkan data";
         }
     }
 } else {
     $error = "Silakan masukkan semua data";
 }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>FORM TENAGA KESEHATAN</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <style>
      .mx-auto {
         width: 800px
      }

      .card {
         margin-top: 30px;
      }
   </style>
</head>

<body>
   <div class="mx-auto">
   <a href=homescreen.php><button type="button" class="btn btn-primary">Home</button></a>
      <!-- Untuk Memasukan Data -->
      <div class="card">
         <div class="card-header text-white bg-info">
            Identitas Diri
         </div>
         <div class="card-body">
            <?php
            if ($error) {
            ?>
               <div class="alert alert-danger" role="alert">
                  <?php echo $error ?>
               </div>
            <?php
            }
            ?>
            <?php
            if ($sukses) {
            ?>
               <div class="alert alert-success" role="alert">
                  <?php echo $sukses ?>
               </div>
            <?php
            }
            ?>
            <form action="" method="POST">
               <div class="mb-3 row">
                  <label for="idNakes" class="col-sm-2 col-form-label">ID</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="idNakes" name="idNakes" value="<?php echo $idNakes ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="namaNakes" class="col-sm-2 col-form-label">NAMA</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="namaNakes" name="namaNakes" value="<?php echo $namaNakes ?>">
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="jabatan" class="col-sm-2 col-form-label">JABATAN</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $jabatan ?>">
                  </div>
               </div>
               <div class="col-12">
                  <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" 
               </div>
            </form>
         </div>
      </div>

      <!-- Untuk Mengeluarkan Data -->
      <div class="card">
         <div class="card-header text-white bg-info">
            Data Nakes
         </div>
         <div class="card-body">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">ID</th>
                     <th scope="col">NAMA</th>
                     <th scope="col">JABATAN</th>
                     <th scope="col">Aksi</th>
                  </tr>
               <tbody>
                  <?php
                  $sql2 = "select * from nakes";
                  $sq2  = mysqli_query($koneksi, $sql2);
                  while ($r2 = mysqli_fetch_array($sq2)) {
                     $idNakes       = $r2['idNakes'];
                     $namaNakes     = $r2['namaNakes'];
                     $jabatan       = $r2['jabatan'];

                  ?>
                     <tr>
                        <td scopr="row"><?php echo $idNakes ?></td>
                        <td scopr="row"><?php echo $namaNakes ?></td>
                        <td scopr="row"><?php echo $jabatan ?></td>
                        <td scope="row">
                           <a href="nakes.php?op=edit&idNakes=<?php echo $idNakes ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                           <a href="nakes.php?op=delete&idNakes=<?php echo $idNakes?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>
                        </td>
                     </tr>
                  <?php
                  }

                  ?>
               </tbody>
               </thead>
            </table>

         </div>
      </div>
   </div>
</body>

</html>