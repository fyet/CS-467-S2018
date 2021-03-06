<!-- *************************************************************************
                                top menu
************************************************************************** -->
<nav class="navbar navbar-dark bg-dark fixed-top" id="topMenu">
  <!-- Start brand/logo element -->
  <a class="navbar-brand" href="admin-home.php">
    <img src="../images/logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    <!-- Start responsive heading -->
    <div class="d-sm-none d-inline">
      Admin <!-- Appears small screens -->
    </div>
    <div class="d-none d-sm-inline">
      AwardHub Administrator <!-- Displayed on larger screens -->
    </div>
    <!-- End responsive heading -->
  </a>
  <!-- End brand/logo element -->
  <!-- Start logout button -->
  <ul class="nav justify-content-end">
    <li class="nav-item d-inline-block mr-3">
      <button type='button'
              class="btn btn-light"
              data-toggle='modal'
              data-target="#passwordModal">
        <?php include('../images/Octicons/key.svg');?>
        <span class="btn-txt">
          &nbsp;change my password
        </span>
      </button>
    </li>
    <li class="nav-item d-inline-block">
      <a class="btn btn-light" href="http://18.188.194.159/award-hub/login-system/killSession.php">
        <?php include('../images/Octicons/sign-out.svg');?>
        <span class="btn-txt">
          &nbsp;logout
        </span>
      </a>
    </li>
  </ul>
  <!-- End logout button -->
</nav>
<!-- End top menu -->
