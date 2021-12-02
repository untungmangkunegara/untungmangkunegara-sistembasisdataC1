<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>VIEW DATA</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <style>
      .mx-auto {
         width: 900px
      }

      .card {
         margin-top: 30px;
      }
   </style>
</head>

<body>
   <?php
   $noTiket = $_GET['noTiket'];


   $host    = "localhost";
   $user    = "root";
   $pass    = "";
   $db      = "db_c1";

   $koneksi = mysqli_connect($host, $user, $pass, $db);
   if (!$koneksi) { // cek koneksi
      die('Tidak bisa terkoneksi ke database');
   }

   $sq1        = "SELECT * FROM vaksinasi WHERE noTiket = '$noTiket'";
   $sq2        = "SELECT namaResipien FROM resipien WHERE nik = (SELECT nik FROM vaksinasi WHERE noTiket = '$noTiket')";
   $sq3        = "SELECT tglLahir FROM resipien WHERE nik = (SELECT nik FROM vaksinasi WHERE noTiket = '$noTiket')";
   $sq4        = "SELECT vaksinasi.dosis, vaksinasi.tglPemberian, faskes.namaFaskes, vaksin.nomorBatch, nakes.namaNakes FROM vaksinasi INNER JOIN nakes ON vaksinasi.idNakes = nakes.idNakes INNER JOIN faskes ON vaksinasi.idFaskes = faskes.idFaskes
   INNER JOIN vaksin ON vaksinasi.idGTIN = vaksin.idGTIN
   WHERE noTiket = '$noTiket'";
   $q1         = mysqli_query($koneksi, $sq1);
   $q2         = mysqli_query($koneksi, $sq2);
   $q3         = mysqli_query($koneksi, $sq3);
   $q4         = mysqli_query($koneksi, $sq4);
   $r1         = mysqli_fetch_array($q1);
   $r2         = mysqli_fetch_array($q2);
   $r3         = mysqli_fetch_array($q3);
   $r4         = mysqli_fetch_array($q4);

   $noTiket          = $r1['noTiket'];
   $nik              = $r1['nik'];
   $dosis            = $r1['dosis'];
   $tglPemberian     = $r1['tglPemberian'];
   $tglDosisLanjutan = $r1['tglDosisLanjutan'];
   $namaResipien     = $r2['namaResipien'];
   $tglLahir         = $r3['tglLahir'];
   $namaFaskes       = $r4['namaFaskes'];
   $nomorBatch       = $r4['nomorBatch'];
   $namaNakes        = $r4['namaNakes'];


   ?>
   <div class="mx-auto">
      <a href=vaksinasi.php><button type="button" class="btn btn-primary">Kembali</button></a>
      <!-- Untuk Memasukan Data -->
      <div class="card">
         <div class="card-header text-black bg-info">
            KARTU IMUNISASI COVID-19
         </div>
         <form action="" method="POST">
            <div class="mb-3 row">
               <label for="nik" class="col-sm-2 col-form-label"> NIK</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="nik" name="nik" disabled value="<?php echo $nik ?>">
               </div>
            </div>
            <div class="mb-3 row">
               <label for="namaResipien" class="col-sm-2 col-form-label">NAMA</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="namaResipien" name="namaResipien" disabled value="<?php echo $namaResipien ?>">
               </div>
            </div>
            <div class="mb-3 row">
               <label for="tglLahir" class="col-sm-2 col-form-label">TANGGAL LAHIR</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="tglLahir" name="tglLahir" disabled value="<?php echo $tglLahir ?>">
               </div>
            </div>
            <div class="mb-3 row">
               <label for="dosis" class="col-sm-2 col-form-label">DOSIS</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="dosis" name="dosis" disabled value="<?php echo $dosis ?>">
               </div>
            </div>
            <div class="mb-3 row">
               <label for="tglPemberian" class="col-sm-2 col-form-label">TANGGAL LAHIR</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="tglPemberian" name="tglPemberian" disabled value="<?php echo $tglPemberian ?>">
               </div>
            </div>
            <div class="mb-3 row">
               <label for="namaFaskes" class="col-sm-2 col-form-label">TEMPAT IMUNISASI</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="namaFaskes" name="namaFaskes" disabled value="<?php echo $namaFaskes ?>">
               </div>
            </div>
            <div class="mb-3 row">
               <label for="nomorBatch" class="col-sm-2 col-form-label">NOMOR BATCH</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="nomorBatch" name="nomorBatch" disabled value="<?php echo $nomorBatch ?>">
               </div>
            </div>
            <div class="mb-3 row">
               <label for="namaNakes" class="col-sm-2 col-form-label">PETUGAS</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" id="namaNakes" name="namaNakes" disabled value="<?php echo $namaNakes ?>">
               </div>
            </div>
         </form>
      </div>
   </div>