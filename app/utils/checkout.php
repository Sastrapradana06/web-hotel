<?php  
  require 'function.php';

  $id = $_GET['id'];
  if(!empty($id)) {
    echo $id;
    $statusCheckOut = deleteRoomById($id);

    if ($statusCheckOut) {
      echo "Data berhasil dihapus.";
      header("Location: ../check-in.php");
    } else {
      echo "Gagal menghapus data: " . $conn->error;
    }
  } else {
    header("location: ../check-in.php");
  }

?>