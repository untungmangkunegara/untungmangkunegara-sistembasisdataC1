<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "db_c1";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
   die('Tidak bisa terkoneksi ke database');
}
$idKabupaten    = "";
$idGTIN         = "";
$stok           = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
   $op = $_GET['op'];
} else {
   $op = "";
}
if ($op == 'delete') {
   $idStok     = $_GET['idStok'];
   $sql1       = "delete from stokvaksin where idStok = '$idStok'";
   $q1         = mysqli_query($koneksi, $sql1);
   if ($q1) {
      $sukses = "Berhasil hapus data";
      $idStok        = "";
   } else {
      $error  = "Gagal melakukan delete data";
   }
}
if ($op == 'edit') {
   $idStok           = $_GET['idStok'];
   $sql1             = "select * from stokvaksin where idStok = '$idStok'";
   $q1               = mysqli_query($koneksi, $sql1);
   $r1               = mysqli_fetch_array($q1);
   $idKabupaten      = $r1['idKabupaten'];
   $idGTIN           = $r1['idGTIN'];
   $stok             = $r1['stok'];

   if ($idKabupaten == '') {
      $error = "Data tidak ditemukan";
   }
}

if (isset($_POST['simpan'])) { //Creater
   $idKabupaten       = $_POST['idKabupaten'];
   $idGTIN            = $_POST['idGTIN'];
   $stok              = $_POST['stok'];


   if ($idKabupaten && $idGTIN && $stok) {
      if ($op == 'edit') { //Update
         $sql1    = "update stokvaksin set idKabupaten = '$idKabupaten', idGTIN = '$idGTIN', stok ='$stok' where idStok = '$idStok' ";
         $q1      = mysqli_query($koneksi, $sql1);
         if ($q1) {
            $sukses = "Data berhasil diupdate";
         } else {
            $error  = "Data gagal diupdate";
         }
      } else { //untuk insert
         $sql1   = "insert into stokvaksin (idKabupaten, idGTIN, stok) values ('$idKabupaten','$idGTIN','$stok')";
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
   <title>FORM STOK VAKSIN</title>
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
            Stok Vaksin
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
                  <label for="idKabupaten" class="col-sm-2 col-form-label">ID Kabupaten</label>
                  <div class="col-sm-10">
                     <select name="idKabupaten" id%="idKabupaten" class="form-control" required>
                        <option value="">- Pilih ID Kabupaten -</option>
                        <?php
                        $sql_idKab = mysqli_query($koneksi, "SELECT * FROM kabupaten") or die(mysqli_error($koneksi));
                        while ($idKabupaten = mysqli_fetch_array($sql_idKab)) {
                           echo '<option value ="' . $idKabupaten['idKabupaten'] . '" > ' . $idKabupaten['idKabupaten'] . '</option>';
                        } ?>
                     </select>
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="idGTIN" class="col-sm-2 col-form-label">ID GTIN</label>
                  <div class="col-sm-10">
                     <select name="idGTIN" id%="idGTIN" class="form-control" required>
                        <option value="">- Pilih ID GTIN -</option>
                        <?php
                        $sql_idGTIN = mysqli_query($koneksi, "SELECT * FROM vaksin") or die(mysqli_error($koneksi));
                        while ($idGTIN = mysqli_fetch_array($sql_idGTIN)) {
                           echo '<option value ="' . $idGTIN['idGTIN'] . '" > ' . $idGTIN['idGTIN'] . '</option>';
                        } ?>
                     </select>
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="stok" class="col-sm-2 col-form-label">STOK</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok ?>">
                  </div>
               </div>
               <div class="col-12">
                  <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" </div>
            </form>
         </div>
      </div>

      <!-- Untuk Mengeluarkan Data -->
      <div class="card">
         <div class="card-header text-white bg-info">
            Informasi Stok
         </div>
         <div class="card-body">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">ID Stok</th>
                     <th scope="col">ID Kabupaten</th>
                     <th scope="col">ID GTIN</th>
                     <th scope="col">STOK</th>
                     <th scope="col">Aksi</th>
                  </tr>
               <tbody>
                  <?php
                  $sql2 = "select * from stokvaksin";
                  $sq2  = mysqli_query($koneksi, $sql2);
                  while ($r2 = mysqli_fetch_array($sq2)) {
                     $idStok        = $r2['idStok'];
                     $idKabupaten   = $r2['idKabupaten'];
                     $idGTIN        = $r2['idGTIN'];
                     $stok          = $r2['stok'];
                  ?>
                     <tr>
                        <td scopr="row"><?php echo $idStok ?></td>
                        <td scopr="row"><?php echo $idKabupaten ?></td>
                        <td scopr="row"><?php echo $idGTIN ?></td>
                        <td scopr="row"><?php echo $stok ?></td>
                        <td scope="row">
                           <a href="stokvaksin.php?op=edit&idStok=<?php echo $idStok ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                           <a href="stokvaksin.php?op=delete&idStok=<?php echo $idStok ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>
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