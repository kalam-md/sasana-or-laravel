<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Secapa AD</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('landing-page/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('landing-page/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('landing-page/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('landing-page/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="#" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">Secapa AD</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#" class="active">Home<br></a></li>
          <li><a href="#tentang">Tentang Kami</a></li>
          <li><a href="#jadwal">Jadwal Lapangan</a></li>
          <li><a href="#kontak">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

        @if (Route::has('login'))
            @auth
                <a class="btn-getstarted" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a class="btn-getstarted" href="{{ route('register') }}">Booking Sekarang!</a>
            @endauth
        @endif

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="{{ asset('landing-page/lapangan.jpg') }}" alt="" data-aos="fade-in">

      <div class="container">
        <h2 data-aos="fade-up" data-aos-delay="100">Ayo Booking,<br>Lapangan di Secapa AD</h2>
        <p data-aos="fade-up" data-aos-delay="200">Berbagai macam lapangan bisa di booking disini, segera tentukan tanggalnya!</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="tentang" class="btn-get-started">Lihat lebih lanjut</a>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="tentang" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="{{ asset('landing-page/lapangan.jpg') }}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Tentang Kami</h3>
            <p class="fst-italic">
              Secapa AD adalah singkatan dari Sekolah Calon Perwira Angkatan Darat. Mengutip laman resminya, lembaga ini didirikan sebagai wadah pembentukan perwira TNI AD di samping Akmil. Namun pada lokasinya terdapat lapangan yang disediakan Secapa AD yang bisa disewa oleh masyarakat umum, seperti:
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>Lapangan Futsal</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Lapangan Badminton</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Lapangan Tenis</span></li>
            </ul>
            <a href="#" class="read-more"><span>Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Courses Section -->
    <section id="jadwal" class="courses section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Jadwal</h2>
        <p>Lapangan Tersedia</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">
            @foreach ($lapangans as $lapangan)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                    <div class="course-item">
                        <div id="carousel-{{ $loop->index }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach (json_decode($lapangan->gambar_lapangan) as $key => $gambar)
                                    <div class="carousel-item  {{ $key === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('/image/' . $gambar) }}" class="d-block" alt="Gambar Lapangan" style="width: 100%; height: 250px">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $loop->index }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $loop->index }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="category">{{ $lapangan->jenis_lapangan }}</p>
                                <p class="price">Rp. {{ number_format($lapangan->harga_lapangan, 0, ',', '.') }}/Jam</p>
                            </div>
                            <h3><a href="course-details.html">{{ $lapangan->nama_lapangan }}</a></h3>
                            <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quos alias temporibus vero! Velit, quas.</p>
                            <small><a href="">Lihat detail jadwal</a></small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
      </div>

    </section>

  </main>

  <footer id="kontak" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Secapa AD</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Jl. Hegarmanah No.152</p>
            <p>Hegarmanah, Kec. Cidadap, Kota Bandung, Jawa Barat 40141</p>
            <p class="mt-3"><strong>No Telp:</strong> <span>(022) 2011462</span></p>
            <p><strong>Email:</strong> <span>secapaad@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-whatsapp"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Rudi Haryanto</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href=“https://themewagon.com>ThemeWagon
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('landing-page/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('landing-page/js/main.js') }}"></script>

</body>

</html>