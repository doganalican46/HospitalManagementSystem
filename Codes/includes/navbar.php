<nav style=" position: fixed; top: 0; left: 0; right: 0; z-index: 999; overflow-x: hidden; background-image: url('images/bg2.png');background-repeat: no-repeat; background-attachment: fixed;background-size: 100% 100%;" class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <style>
      .navbar-toggler-icon {
        filter: invert(100%);
      }
    </style>
    <a style="color:white;" class="navbar-brand" href="#">Hospital Management System</a>
    <button style="color: white;" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="  color: white;"></span>
    </button>

    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">



      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">




        <?php if (isset($_SESSION['auth_user'])) : ?>

          <?php if ($_SESSION['auth_role'] == 0) : //patient
          ?>
            <li class="nav-item">
              <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" aria-current="page" href="index.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Dashboard</a>
            </li>
            <li class="nav-item">
              <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="user-appointment.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Appointment</a>
            </li>

            <li class="nav-item">
              <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="user-profile.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Profile</a>
            </li>
            <li>
              <form action="allcode.php" method="post">
                <button style="color: blue;" class="btn btn-warning nav-link" name="logoutbtn" type="submit">Log Out</button>
              </form>
            </li>


      </ul>
      </li>

    <?php elseif ($_SESSION['auth_role'] == 2) : //doctor
    ?>
      <li class="nav-item">
        <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" aria-current="page" href="index.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Dashboard</a>
      </li>
      <li class="nav-item">
        <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="user-appointment.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Appointment</a>
      </li>
      <li class="nav-item">
        <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="user-schedule.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Schedule</a>
      </li>
      <li class="nav-item">
        <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="user-profile.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Profile</a>
      </li>
      <li>
        <form action="allcode.php" method="post">
          <button style="color: blue;" class="btn btn-warning nav-link" name="logoutbtn" type="submit">Log Out</button>
        </form>
      </li>


      </ul>
      </li>

    <?php else :
    ?>
      <li class="nav-item">
        <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" aria-current="page" href="index.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Dashboard</a>
      </li>
      <li class="nav-item">
        <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="user-appointment.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Appointment</a>
      </li>
      <li class="nav-item">
        <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="user-schedule.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Schedule</a>
      </li>
      <li class="nav-item">
        <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="user-profile.php" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Profile</a>
      </li>
      <li>
        <form action="allcode.php" method="post">
          <button style="color: blue;" class="btn btn-warning nav-link" name="logoutbtn" type="submit">Log Out</button>
        </form>
      </li>


      </ul>
      </li>
    <?php endif; ?>



  <?php else : ?>

    <li class="nav-item">
      <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="login.php">Log In</a>
    </li>
    <li class="nav-item">
      <a style="color:white; font-size: 16px; transition: font-size 0.3s ease;" class="nav-link" href="register.php">Register</a>
    </li>

  <?php endif; ?>
  </ul>

    </div>
  </div>
</nav>