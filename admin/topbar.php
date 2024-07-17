<style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
            font-family: 'Arial', sans-serif;
        }
        .greentop {
            width: 100%;
            height: 3.75rem;
            background-color: #005b00;
        }
        .navbar {
            width: 100%;
            background-color: #ffffff;
            color: #343a40;
            padding: 1.4rem 1.5rem;
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
            margin: 0 10px;
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
        @media (max-width: 990px) {
            .navbar img {
                margin-left: 1.5rem;
                z-index: 10000;
            }
            .navbar-nav {
                margin-top: 2rem;
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
        }
    </style>
</head>
<body id="page-top">
    <div class="greentop"></div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="./">
            <img src="assets/img/Logo1.png" alt="logo">
        </a>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=gallery">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=courses">Course List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=alumni">Alumni List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=jobs">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=events">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=forums">Forum</a>
                </li>
                <?php if($_SESSION['login_type'] == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=users">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=site_settings">System Settings</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="float-right">
                <div class="dropdown mr-4">
                    <a href="#" class="text-dark dropdown-toggle" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_name'] ?> </a>
                    <div class="dropdown-menu" aria-labelledby="account_settings">
                        <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
                        <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="content">
        <!-- Page Content goes here -->
    </div>

    <script>
        $(document).ready(function() {
            $('#manage_my_account').click(function() {
                uni_modal("Manage Account", "manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
            });
        });
    </script>