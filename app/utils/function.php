<?php 
  function createCookie($username, $email) {
    $name_username = "usernameUser";
    $name_email = "emailUser";
    $username_value = $username;
    $email_value = $email;
    $expire_time = time() + 3600;
    setcookie($name_email, $email_value, $expire_time, "/");
    setcookie($name_username, $username_value, $expire_time, "/");
  }

  function getCookie() {
    if (isset($_COOKIE['emailUser'])) {
      // Mengambil nilai cookie
      $emailCookie = $_COOKIE['emailUser'];
  
      return $emailCookie;
    } else {
      // echo "Cookie emailUser tidak ditemukan.";
    }
  }

  function connectDb() {
    $servername = "localhost";
    $usernameDb = "root";
    $password = "";
    $dbname = "michat_hotel";

    $conn = new mysqli($servername, $usernameDb, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    return $conn;
  }

  function getKamar() {
    $conn = connectDb();

    $query = "SELECT * FROM kamar_hotel";
    $result = mysqli_query($conn,$query);
    $data = array();

    while ($row = $result->fetch_assoc()) {
      $data[] = $row;;
    }
    return $data;
  }

  function checkInKamar($id, $username, $email, $jenisKamar, $durasiMenginap, $imgKamar, $subtotal) {
    
    $query = "INSERT INTO check_in (id, username, email, jenis_kamar, durasi_menginap, img_kamar, subtotal) 
    VALUES ('$id', '$username', '$email', '$jenisKamar', '$durasiMenginap', '$imgKamar', '$subtotal')";

    return $query;
  }

  function fetchDataByEmail() {
    $emailUser = getCookie();
    $conn = connectDb();

    // $email = $conn->real_escape_string($email);

    $query = "SELECT id, username, email, jenis_kamar, durasi_menginap, img_kamar, subtotal 
              FROM check_in 
              WHERE email = '$emailUser'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    } else {
        return array(); // Return empty array if no data found
    }
  }

  function deleteRoomById($id) {
    $conn = connectDb();
    $query = "DELETE FROM check_in  WHERE id = '$id'";

    $result = $conn->query($query);
    if (!$result) {
      die("Query DELETE error: " . mysqli_error($conn));
    }
    return $query;
  }

  function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i <= 10; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
  }
?>