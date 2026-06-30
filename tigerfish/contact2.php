<?php
require 'header.php';
require 'Sidebar.php';
?>
  

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Contact</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active">Contact</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section contact">

      <div class="row align-items-center">

        <div class="col-xl-8">

          <div class="row">
            <div class="col-lg-6">
              <div class="info-box card">
                <i class="bi bi-geo-alt"></i>
                <h3>ที่ติดต่อ</h3>
                <p>กลุ่มพัฒนาระบบงานสารสนเทศ<br>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card">
                <i class="bi bi-telephone"></i>
                <h3>หมายเลขติดต่อ</h3>
                <p>0 2579 5591<br>0 2940 6275</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card">
                <i class="bi bi-envelope"></i>
                <h3>Email Us</h3>
                <p>ict.dev.dof@gmail.com<br>it@dof.in.th</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card">
                <i class="bi bi-clock"></i>
                <h3>เวลาทำการ</h3>
                <p>จันทร์ - ศุกร์<br>8:30 น. - 16:30 น.</p>
              </div>
            </div>
          </div>

        </div>

        <!--<div class="col-xl-6">
          <div class="card p-4">
            <form action="contact.php" method="post" class="php-email-form">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div>

        </div>-->

      </div>

    </section>

  </main><!-- End #main -->

<?php require 'footer.php'?>

</html>