<?php  
  require './utils/function.php';

  $kamarUser = fetchDataByEmail();
  // var_dump($kamarUser);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="./style/check-in.css">
  <title>Riwayat Check In</title>
</head>

<body>
  <section class="check_in" id="check_in">
    <div class="container_in">
      <nav class="nav_in">
        <div class="nav_container">
          <button>
            <a href="./home.php">Pilih Kamar</a>
          </button>
          <!-- <button>
            <a href="./check-in.php">Check Out</a>
          </button> -->
        </div>
      </nav>
      <div class="deskripsi">
        <h3>Kamar Anda</h3>
        <p>Daftar Kamar Yang Anda Pesan</p>
      </div>
      <div class="card">
        <?php if(!empty($kamarUser)) :?>
          <?php foreach ($kamarUser as $entry) : ?>
            <div class="card_kamar">
              <div class="img_card">
                  <img src="<?= $entry['img_kamar']; ?>" alt="">
              </div>
              <div class="deskripsi_card">
                  <p class="jenis"><?= $entry['jenis_kamar']; ?></p>
                  <p class="price">Rp <?= number_format($entry['subtotal']); ?></p>
                  <p><?= $entry['durasi_menginap']; ?></p>
                  <a href="./utils/checkout.php?id=<?= $entry['id']; ?>">
                    <button id="btn_check_out">Check Out Sekarang</button>
                  </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else :?>
          <p class="no_kamar">Anda Belum Memesan Kamar Satupun</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
</body>
</html>