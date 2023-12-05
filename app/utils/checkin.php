<?php
    require 'function.php';
  // var_dump($_GET);
  if (!empty($_GET)) {
    $id = generateRandomString();
    // echo $id;
    $username = $_GET["username"];
    $email = $_GET["email"];
    $jenisKamar = $_GET["jenisKamar"];
    $imgKamar = $_GET["imgKamar"];
    $durasiMenginap = $_GET["durasiMenginap"];
    $subtotal = $_GET["subtotal"];
    
    $conn = connectDb();
    $checkIn = checkInKamar($id, $username, $email, $jenisKamar, $durasiMenginap, $imgKamar, $subtotal);
    
    if ($conn->query($checkIn) === TRUE) {
      createCookie($username, $email);
      echo "Data berhasil disimpan ke database.";
      header("Location: ../check-in.php");
    } else {
      echo "<center>Pesanan Terjadi Error</center>";
    }

    $emailUser = getCookie();

    $conn->close();

    // echo "Data Pesanan: $username, $email, $jenisKamar, $imgKamar, $durasiMenginap, $subtotal";
  } else {
    echo '$_GET is an empty array tes';
  }
