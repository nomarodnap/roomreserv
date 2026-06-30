<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบจองศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร กรมประมง</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .logo {
      height: 50px;
    }

    /* Header */

  header {
    height: 70px;
    flex-shrink: 0;
  }


    header .logo {
      height: 50px;
    }

    nav a {
      font-weight: 600;
      transition: color 0.3s ease;
    }

    nav a:hover {
      color: #f1c40f;
    }

    header .btn {
      font-weight: 600;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    header .btn:hover {
      background-color: #f1c40f;
      color: #fff;
    }

    /* Flexbox Layout */
body {
  background-image: url('background.jpg');
  background-size: cover;         /* ทำให้ภาพเต็มหน้าจอ */
  background-position: center;    /* จัดให้อยู่กึ่งกลาง */
  background-repeat: no-repeat;   /* ไม่ให้ภาพซ้ำ */
  background-attachment: fixed;   /* ถ้าต้องการให้ภาพอยู่กับที่เวลา scroll */
  min-height: 100vh;              /* ให้ body เต็มความสูงของ viewport */
}


    .folder {
      border: 2px solid #007bff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      background-color: rgba(255, 255, 255, 0.8);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .folder-title {
      font-weight: bold;
      font-size: 1.5rem;
      color: #007bff;
      margin-bottom: 15px;
    }

    .file {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 10px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .file:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .file a {
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }

    .file a:hover {
      text-decoration: underline;
      color: #007bff;
    }

  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }


  .page-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
  }


  main {
    flex: 1;
    padding: 10px 15px;
  }

footer {
  height: 70px;
  flex-shrink: 0;
  font-size: 0.85rem;
  background-color: transparent; /* เปลี่ยนจาก #f8f9fa เป็นโปร่งใส */
  color: white; /* แนะนำให้ใช้สีขาวเพื่อให้อ่านง่ายบนพื้นหลังภาพ */
}

.sub-folder-title {
  font-size: 1.2rem;
  font-weight: bold;
  color: #343a40;
  margin-top: 20px;
  margin-bottom: 10px;
}



  </style>
</head>
<body>
<div class="page-container">

  <!-- Header -->
    <header class="bg-primary text-white py-3">

    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <img src="logo.png" alt="Logo" class="logo me-2">
        <h1 class="fs-4 m-0">ระบบจองศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร กรมประมง</h1>
      </div>
      <div>
        <?php if (isset($_SESSION['user_login'])): ?>
          <?php $user = $_SESSION['user_login']; ?>
          <div class="dropdown">
            <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bx bxs-user"></i> <?php echo htmlspecialchars($user['fname'] . ' ' . $user['lname']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><h6 class="dropdown-header"><?php echo htmlspecialchars($user['fname'] . ' ' . $user['lname']); ?></h6></li>
              <li><span class="dropdown-item-text text-muted"><?php echo htmlspecialchars($user['org']); ?></span></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a href="signup.php" class="btn btn-light btn-sm me-2">ลงทะเบียน</a>
          <a href="login.php" class="btn btn-outline-light btn-sm">เข้าใช้งาน</a>
        <?php endif; ?>
      </div>
    </div>
  </header>


<!-- Main Content -->
<main class="container my-2 py-2">

  <!-- Folder: ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร -->
  <div class="folder">
    <div class="folder-title">ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</div>

    <!-- จองห้อง -->
    <div class="sub-folder">
      <div class="sub-folder-title">🏢 จองห้อง</div>
      <div class="file"><a href="./tigerfish">🌊 ห้องประชุมเสือตอ</a></div>
      <div class="file"><a href="./comp">💻 ห้องฝึกอบรมคอมพิวเตอร์</a></div>
    </div>

    <!-- จองรถ -->
    <div class="sub-folder mt-3">
      <div class="sub-folder-title">🚗 จองรถยนต์ของ ศทส.</div>      
	<div class="file"><a href="./car1">🚐 รถยนต์</a></div>

    </div>

  </div>

</main>


  <!-- Footer -->

<footer class="text-center py-4">
  <div class="container">
    <p class="mb-1">
      by กลุ่มพัฒนาระบบงานสารสนเทศ โทร. 025795591 เบอร์ภายใน: 5129
    </p>
    <p class="mb-0">
      © ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร กรมประมง. 2024 All Rights Reserved
    </p>
  </div>
</footer>

</div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
