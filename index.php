<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<style>
    body {
        background-color: #f8f9fa;
        color: #343a40;
        font-family: 'Arial', sans-serif;
    }

    body ul,
    li {
        list-style-type: none;
    }

    .greentop {
        width: 100%;
        height: 3.3rem;
        background-color: #025F1D;
    }

    nav .navbar {
        padding:100rem;
        width: 100%;
        background-color: #ffffff;
        color: #343a40;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        transition: height 0.3s ease-out;
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

    @keyframes slideIn {
        0% {
            margin-left: -50rem;
        }

        100% {
            margin-left: 10rem;
        }
    }

    .navbar img {
        position: relative;
        margin-left: -100px;
        top: .2rem;
        width: 20rem;
        animation: slideIn 2s ease-in-out forwards;
    }

    .navbar .nav-link {
        padding: 10px 20px;
        text-decoration: none;
        font-size: 18px;
        color: #343a40;
        display: inline-block;
        transition: all 0.3s ease;
        border-radius: 4px;
        background-color: #ffffff;
    }

    .navbar-nav {
        padding-left: 10rem;
    }

    .navbar-nav-center {
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .content {
        padding: 20px;
        margin-top: 60px;
    }

    @media (max-width: 990px) {
        .navbar img {
            margin-left: 1.5rem;
        }

        .navbar-nav-center {
            justify-content: center;
        }

        .navbar-nav {
            margin-top: 2rem;
            padding-left: 0;

        }

        .navbar {
            height: 6.3rem;
            justify-content: center;
        }

        @keyframes slideIn {
            0% {
                margin-left: -50rem;
            }

            100% {
                margin-left: 1.5rem;
            }
        }

        .hero-left {
            align-items: center !important;
            text-align: center !important;
        }
    }

    @media (max-width: 576px) {
        .navbar img {
            width: 12rem;
            margin-left: 1rem;
            top: 14px;

        }

        .navbar {
            height: 4rem;

        }

        .navbar-nav {
            margin-top: 1.2rem;
        }

        .greentop {
            height: 3.5rem;
        }

        @keyframes slideIn {
            0% {
                margin-left: -50rem;
                /* Start position off the screen to the left */
            }

            100% {
                margin-left: 1rem;
                /* End position where you want the logo to settle */
            }
        }

        .navbar button {
            color: #36B722;
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


</style>

<body id="page-top">
    <!-- Navigation-->
    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body  ">
        </div>
    </div>
    <div class="greentop"></div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="./">
        <img src="assets/img/Logo.png" alt="logo">
    </a>
    <?php if (isset($_SESSION['login_id'])): ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=alumni_list">Alumni</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=articles">Article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=careers">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=forum">Forums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=contact_us">Contact Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="account_settings" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['login_name'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="account_settings">
                        <a class="dropdown-item" href="index.php?page=my_account" id="manage_my_account">Manage Account</a>
                        <a class="dropdown-item" href="admin/ajax.php?action=logout2">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</nav>
     
   
    <?php 
        $page = isset($_GET['page']) ? $_GET['page'] : "home";
    ?>
    <?php if (isset($_SESSION['login_id'])):
        $allowed_pages = ['home', 'alumni_list', 'articles', 'careers', 'forum', 'about', 'my_account', 'contact_us', 'signup', ''];
        if (in_array($page, $allowed_pages) && file_exists($page . '.php')) {
            include $page . '.php';
        } else {
            include '404.php';
        }
    else:
        if ($page === 'signup') {
            include "signup.php";
        } else {
            include "not_member.php";
        }
    endif; ?>

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

    <?php

    include ('admin/db_connect.php');
    ob_start();
    $query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
    foreach ($query as $key => $value) {
        if (!is_numeric($key))
            $_SESSION['system'][$key] = $value;
    }
    ob_end_flush();
    include ('header.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $name = $_POST['name'];
        $message = $_POST['message'];

        // Prepare and execute SQL query to insert form data into a table
        $sql = "INSERT INTO form_data (name, message) VALUES ('$name', '$message')";
        if ($conn->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

    }
    ?>
    <div id="preloader"></div>


    <?php include ('footer.php') ?>
</body>
<script type="text/javascript">
    $('#login').click(function () {
        uni_modal("Login", 'login.php')
    })
</script>
<script>

</script>