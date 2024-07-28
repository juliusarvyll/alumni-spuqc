<!DOCTYPE html>
<?php
session_start();
include ('admin/db_connect.php');
ob_start();
$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
foreach ($query as $key => $value) {
  if (!is_numeric($key))
    $_SESSION['system'][$key] = $value;
}
ob_end_flush();

?>
<?php 
include 'header.php';
?>
<style>
  .greentop {
    width: 100%;
    height: 3.75rem;
    background-color: #025F1D;
  }
  body{
    background-color: #EEEEEE !important;
  }
  .navbar {
    width: 100%;
    height: 6.9rem;
    background-color: #ffffff;
    color: #343a40;
    justify-content: space-between;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    transition: height 0.3s ease;
    display: flex;
    align-items: center;
  }

  .navbar .navbar-brand {
    position: absolute;
    top: -30px;
    left: 20px;
    display: flex;
    align-items: center;
  }

  .navbar img {
    position: relative;
    margin-left: 10rem;
    top: .2rem;
    width: 20rem;
    animation: moveImageToLeft 1s ease-out forwards;
  }

  @keyframes moveImageToLeft {
    from {
      margin-left: -50rem;
      top: .2rem;
    }
    to {
      margin-left: 10rem;
      top: .2rem;
    }
  }

  .navbar .nav-link {
    text-decoration: none;
    font-size: 18px;
    color: #343a40;
    transition: all 0.3s ease;
    border-radius: 4px;
    margin: 0 10px;
    height: 100%;
  }

  .navbar-nav-center {
    margin: 0 auto;
    display: flex;
    align-items: center;
  }

  .content {
    padding: 20px;
    margin-top: 60px;
  }

  .svg-icon {
    display: none;
  }

  @media (max-width: 990px) {
    .navbar img {
      margin-left: 1.5rem;
      z-index: 10000;
    }

    .svg-icon {
      display: block;

    }

    .navbar-nav {
      padding-top: 4rem;
      text-align: center;
    }

    .navbar-nav li a {
      padding: 1rem;
    }

    .navbar {
      padding: 2rem 1.5rem;
      height: auto;
    }
  }

  @media (max-width: 576px) {
    .navbar img {
      width: 12rem;
      margin-left: 2rem;
      top: 14px;
    }

    .navbar {
      padding: .8rem;
      height: auto;
    }

    .navbar-nav {
      margin-top: 1.2rem;
    }

    .greentop {
      height: 2rem;
    }

    .navbar .nav-link {
      padding-top: 3rem;
    }
  }

  #viewer_modal .btn-close {
    position: absolute;
    z-index: 999999;
    /*right: -4.5em;*/
    background: unset;
    color: white;
    border: unset;
    font-size: 27px;
    top: 0;
  }

  #viewer_modal .modal-dialog {
    width: 80%;
    max-width: unset;
    height: calc(90%);
    max-height: unset;
  }

  #viewer_modal .modal-content {
    background: black;
    border: unset;
    height: calc(100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #viewer_modal img,
  #viewer_modal video {
    max-height: calc(100%);
    max-width: calc(100%);
  }

  a.jqte_tool_label.unselectable {
    height: auto !important;
    min-width: 4rem !important;
    padding: 5px
  }

  /*
a.jqte_tool_label.unselectable {
    height: 22px !important;
}*/
  .login-btn a {
    background-color: #005b00;
    width: 10rem;
    text-align: center;
    color: #ffffff !important;
    animation: 0.5s;
  }

  .login-btn a:hover {
    background-color: #ffffff;
    color: #005b00 !important;
    box-shadow: inset 0 0 5px rgba(0, 91, 0, 0.5);
    /* Reduced shadow strength */
    border: 1px rgba(0, 0, 0, 0.2) solid;
  }

  .login-btn:before,
  .login-btn:after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    height: 2px;
    width: 0;
    background: #005b00;
    box-shadow:
      -1px -1px 5px 0px #005b00,
      7px 7px 20px 0px #005b00,
      4px 4px 5px 0px #005b00;
    transition: 400ms ease all;
    z-index: -2;
  }

  .login-btn:after {
    right: inherit;
    top: inherit;
    left: 0;
    bottom: 0;
  }

  .login-btn:hover:before,
  .login-btn:hover:after {
    width: 100%;
    transition: 800ms ease all;
  }
</style>

<body id="page-top">
  <!-- Navigation-->
  <div class="greentop"></div>
  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body  ">
    </div>
  </div>
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="./">
        <img src="assets/img/Logo.png" alt="logo">
      </a>
      <button class="navbar-toggler ml-auto" style=" border: none;" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler svg-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50px"
            height="40px">
            <path
              d="M 5 8 A 2.0002 2.0002 0 1 0 5 12 L 45 12 A 2.0002 2.0002 0 1 0 45 8 L 5 8 z M 5 23 A 2.0002 2.0002 0 1 0 5 27 L 45 27 A 2.0002 2.0002 0 1 0 45 23 L 5 23 z M 5 38 A 2.0002 2.0002 0 1 0 5 42 L 45 42 A 2.0002 2.0002 0 1 0 45 38 L 5 38 z" />
          </svg></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Home</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about">About</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=contact">Contact Us</a></li>
          <?php if (isset($_SESSION['login_id'])): ?>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=article">Articles</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=careers">Jobs</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=forum">Forums</a></li>
          <?php endif; ?>
          <?php if (!isset($_SESSION['login_id'])): ?>
            <li class="nav-item"></li>
          <?php else: ?>
            <li class="nav-item">
              <div class="dropdown mr-4">
                <a href="#" class="nav-link js-scroll-trigger" id="account_settings" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_name'] ?> <i
                    class="fa fa-angle-down"></i></a>
                <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
                  <a class="dropdown-item" href="index.php?page=my_account" id="manage_my_account"><i>
                      class="fa fa-cog"></i> Manage Account</a>
                  <a class="dropdown-item" href="admin/ajax.php?action=logout2"><i class="fa fa-power-off"></i> Logout</a>
                </div>
              </div>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container" >
    <div class="row justify-content-center">
      <?php
      // Determine the page to display based on the 'page' URL parameter
      $page = isset($_GET['page']) ? $_GET['page'] : "home";
      $public_pages = ['about', 'contact', 'signup'];

      // Check if the page is public or the user is logged in
      if (in_array($page, $public_pages) || isset($_SESSION['login_id'])) {
        include $page . '.php'; // Include the requested page if it's public or user is logged in
      } else {
        include 'not_member.php'; // Default to home page if the page is not public and user is not logged in
      }
      ?>
    </div>
  </div>
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit'
            onclick="$('#uni_modal form').submit()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="fa fa-arrow-righ t"></span>
          </button>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
        <img src="" alt="">
      </div>
    </div>
  </div>
  <div id="preloader"></div>

  <?php include ('footer.php') ?>
</body>

<script type="text/javascript">
  $(document).ready(function () {
    console.log("jQuery version:", $.fn.jquery);
    $('.login').click(function () {
      uni_modal("Login", 'login.php');
    });
  });
</script>
<?php $conn->close(); ?>

</html>