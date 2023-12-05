<?php
require './utils/function.php';
$kamarHotel = getKamar();
// var_dump($kamarHotel);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="./style/home.css">
  <title>Home App</title>
</head>

<body>
  <section class="section_app" id="home_app">
    <div class="container_app">
      <nav class="nav_app">
        <div class="nav_container">
          <button>
            <a href="http://localhost/Michat2/landing-page/#home">Kembali</a>
          </button>
          <button>
            <a href="./check-in.php">Check In</a>
          </button>
        </div>
      </nav>
      <div class="header">
        <div class="title">
          <h3>PILIHAN KAMAR</h3>
          <p>Kamar Mewah Dengan Harga Terjangkau</p>
        </div>
      </div>
      <div class="card" id="card">
        <?php foreach ($kamarHotel as $kamar) : ?>
          <div class="card_kamar">
            <img src="<?= $kamar['image']; ?>" alt="" />
            <div class="name_kamar">
              <p><?= $kamar['tipe_kamar']; ?></p>
              <div class="star">
                <span class="material-symbols-outlined">star_rate</span>
                <span class="material-symbols-outlined">star_rate</span>
                <span class="material-symbols-outlined">star_rate</span>
                <span class="material-symbols-outlined">star_rate</span>
                <span class="material-symbols-outlined">star_rate</span>
              </div>
            </div>
            <p class="price">Rp.<?= $kamar['price']; ?><span>/Per Night</span></p>
            <button onclick="checkInKamar(`<?= htmlspecialchars(json_encode($kamar), ENT_QUOTES, 'UTF-8'); ?>`)">
              Booking Now
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="pop_up" id="pop_up">
    </div>
  </section>


  <script>
    const card = document.getElementById('card')
    const popUp = document.getElementById('pop_up')

    popUp.classList.remove('pop_up')
    
    // fungsi untuk menghilangkan element detail pesanan
    function checkInSucces() {
      popUp.innerHTML = ''
      popUp.classList.remove('pop_up')
    }

    // fungsi untuk mengambil waktu sekarang
    function getDate() {
      const event = new Date();
      const next24HoursDate = new Date(event.getTime() + 24 * 60 * 60 * 1000);
      const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
      };
      return event.toLocaleDateString("id-ID", options)
    }

    // fungsi untuk mengambil waktu kedepannya
    function getFutureDate(days) {
      const currentDate = new Date();

      // Tambahkan jumlah hari yang diinputkan oleh pengguna
      const futureDate = new Date(currentDate.getTime() + days * 24 * 60 * 60 * 1000);

      const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
      };

      return futureDate.toLocaleDateString("id-ID", options);
    }

    // fungsi untuk menghilangkan element form
    function closeForm() {
      popUp.classList.remove('pop_up')
      popUp.innerHTML = ''
    }

    // fungsi checkIn ketika user klik button booking now
    function checkInKamar(data) {
    // data di parse supaya bisa di akses
      const kamarData = JSON.parse(data);
      const {
        tipe_kamar,
        image,
        price
      } = kamarData

      //  Membuat format mata uang ke mata uang indonesia
      let totalHarga = price
      let formattedPrice = totalHarga.toLocaleString('id-ID');
      popUp.className = 'pop_up'


      //  Menampilakan form pemesanan kamar hotel
      popUp.innerHTML +=
        (`<div class="pop_up">
          <form action="home.php" method="POST" class="form" id="bookingForm">
            <div class="username">
              <label for="">Masukkan Username</label>
              <input type="text" id="username" name="username" required>
            </div>
            <div class="email">
              <label for="">Masukkan Email</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="username">
              <label for="">Berapa Hari Anda Menginap?</label>
              <input type="number" id="total_hari" name="total_hari" placeholder="0" required>
            </div>
            <div class="email">
              <label for="">Jenis Kamar</label>
              <input type="text" id="jenis_kamar" name="jenis_kamar" value=${tipe_kamar} disabled>
            </div>
            <div class="email">
              <label for="">Harga</label>
              <input type="text" id="harga" name="harga" value="${price}/malam" disabled>
            </div>
            <button type="submit">Check In</button>
            <button id="btn_close" onclick='closeForm()'>Close</button>
          </form>
        </div>
      `)
      // + End form

      //  ambil elemen form sesuai id yang sudah diberikan
      const bookingForm = document.getElementById('bookingForm')
      //  ketika form di submit jalankan function dibawah
      bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const usernameValue = document.getElementById('username').value;
        const emailValue = document.getElementById('email').value;
        const totalHariValue = document.getElementById('total_hari').value;

        //  validasi jika total hari kurang dari 1 maka langsung dihentikan disini dan tidak menjalankan code dibawahnya 
        if (totalHariValue < 1) {
          alert('Input Kamar tidak valid')
          return
        }

        // ambil tanggal sekarang dan tanggal selanjutnya sesuai berapa lama user menginap.
        const dateNow = getDate()
        const futureDate = getFutureDate(parseFloat(totalHariValue))
        const subtotal = parseFloat(totalHarga * totalHariValue)
        const formattedSubtotal = subtotal.toLocaleString('id-ID');

        // membuat object yang berisi data yang user inputkan di form diatas yang akan di kirimkan ke server 
        const dataToServer = {
          username: usernameValue,
          email: emailValue,
          jenisKamar: tipe_kamar,
          imgKamar: image,
          durasiMenginap: `${dateNow} - ${futureDate}`,
          subtotal
        }

        // hilangkan element form karena sudah mendapatkan data pemesanan.
        popUp.innerHTML = ''

        // menampilakan detail pemesanan kamar
        popUp.innerHTML = (
          `<div class="card_harga">
          <div class="title">
            <p>Detail Pesanan</p>
          </div>
          <div class="deskripsi">
            <p>Dengan Nama: <span>${usernameValue}</span></p>
            <p>Durasi Menginap: <span>${totalHariValue} Hari</span></p>
            <p>Detail Menginap: <span>${dateNow} - ${futureDate}</span></p>
            <p>Subtotal Biaya Menginap: <span>${formattedSubtotal}</span></p>
          </div>
          <a href="./utils/checkin.php?username=${dataToServer.username}&email=${dataToServer.email}&jenisKamar=${dataToServer.jenisKamar}&imgKamar=${dataToServer.imgKamar}&durasiMenginap=${dataToServer.durasiMenginap}&subtotal=${dataToServer.subtotal}">
              <button onclick="checkInSucces()">Bayar</button>
          </a>
        </div>
        `
        )

      })

    }

  </script>
</body>


</html>