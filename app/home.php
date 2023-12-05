

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
      <div class="card" id="card"></div>
    </div>
    <div class="pop_up" id="pop_up">
      <!-- <form action="" class="form">
        <div class="username">
          <label for="">Masukkan Username</label>
          <input type="text" id="username" name="username">
        </div>
        <div class="email">
          <label for="">Masukkan Email</label>
          <input type="email" id="email" name="email">
        </div>
        <div class="username">
          <label for="">Berapa Hari Anda Menginap?</label>
          <input type="number" id="total_hari" name="total_hari" placeholder="1/2">
        </div>
        <div class="email">
          <label for="">Jenis Kamar</label>
          <input type="text" id="jenis_kamar" name="jenis_kamar" value="Presidential Suite" disabled>
        </div>
        <div class="email">
          <label for="">Harga</label>
          <input type="text" id="harga" name="harga" value="5.000.000/malam" disabled>
        </div>
        <button>Bayar Kamar</button>
        <button id="btn_close">Close</button>
      </form> -->
      <!-- <div class="card_harga">
        <div class="title">
          <p>Detail Pesanan</p>
        </div>
        <div class="deskripsi">
          <p>Durasi Menginap: <span>1 Hari</span></p>
          <p>Detail Menginap: <span>16 November - 17 November</span></p>
          <p>Subtotal Biaya Menginap: <span>1 Hari</span></p>
        </div>
        <button>
          <a href="">Oke</a>
        </button>
      </div> -->
    </div>
  </section>


  <script>
    const card = document.getElementById('card')
    const popUp = document.getElementById('pop_up')
    const arrKamar = [{
        img: './img/supaer_vip2.jfif',
        tipekamar: 'Presidential Suite',
        price: 5000000
      },
      {
        img: './img/Honeymoon Suite.jfif',
        tipekamar: 'Honeymoon Suite',
        price: 3000000
      },
      {
        img: './img/Penthouse.jfif',
        tipekamar: 'Penthouse',
        price: 4000000
      },
      {
        img: './img/Deluxe Room.jfif',
        tipekamar: 'Deluxe Room',
        price: 3000000
      },
      {
        img: './img/Standard Room.jfif',
        tipekamar: 'Standard Room',
        price: 1000000
      },
      {
        img: './img/Suite Room.jfif',
        tipekamar: 'Suite Room',
        price: 1000000
      },
    ]
    popUp.classList.remove('pop_up')

    function checkInSucces() {
      popUp.innerHTML = ''
      popUp.classList.remove('pop_up')
    }

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

    function closeForm() {
      popUp.classList.remove('pop_up')
      popUp.innerHTML = ''
    }


    const checkIn = (jenisKamar, price) => {
      console.log(jenisKamar, price);
      let totalHarga = price
      let formattedPrice = totalHarga.toLocaleString('id-ID');
      popUp.className = 'pop_up'

      // + form
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
              <input type="text" id="jenis_kamar" name="jenis_kamar" value=${jenisKamar} disabled>
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

      const bookingForm = document.getElementById('bookingForm')
      bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const usernameValue = document.getElementById('username').value;
        const emailValue = document.getElementById('email').value;
        const totalHariValue = document.getElementById('total_hari').value;
        const jenisKamar = document.getElementById('jenis_kamar').value

        if (totalHariValue < 1) {
          alert('Input Kamar tidak valid')
          return
        }

        const filterKamar = arrKamar.filter((item) => {
          return item.tipekamar.includes(jenisKamar)
        })
        const imgKamar = filterKamar[0].img

        const dateNow = getDate()
        const futureDate = getFutureDate(parseFloat(totalHariValue))


        const subtotal = parseFloat(totalHarga * totalHariValue)
        const formattedSubtotal = subtotal.toLocaleString('id-ID');

        const dataToServer = {
          username: usernameValue,
          email: emailValue,
          jenisKamar,
          imgKamar,
          durasiMenginap: `${dateNow} - ${futureDate}`,
          subtotal
        }
        popUp.innerHTML = ''

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

    card.innerHTML = arrKamar.map((item) => {
      const formattedPrice = item.price.toLocaleString('id-ID');
      const {
        tipekamar,
        price
      } = item
      // console.log(tipekamar);

      return `
        <div class="card_kamar">
          <img src="${item.img}" alt=""/>
          <div class="name_kamar">
            <p>${item.tipekamar}</p>
            <div class="star">
              <span class="material-symbols-outlined">star_rate</span>
              <span class="material-symbols-outlined">star_rate</span>
              <span class="material-symbols-outlined">star_rate</span>
              <span class="material-symbols-outlined">star_rate</span>
              <span class="material-symbols-outlined">star_rate</span>
            </div>
          </div>
          <p class="price">Rp ${formattedPrice}<span>/Per Night</span></p>
          <button onclick="checkIn('${tipekamar}', ${price})">
            Booking Now
          </button>
        </div>
      `
    });
  </script>
</body>


</html>