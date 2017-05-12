<!DOCTYPE HTML>
<head>
    <title>Minuscule .:. Admin</title>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300|Raleway:300' rel='stylesheet' type='text/css'>
    <link type="text/css" rel="stylesheet" href="<?= site_url('assets/css/vendor.bundle.min.css'); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?= site_url('assets/css/main.css'); ?>"/>
    <script src="<?= site_url('assets/js/vendor.bundle.min.js'); ?>"></script>
    <script src="<?= site_url('assets/js/minuscule.js'); ?>"></script>
    <script>siteUrl = "<?= site_url(); ?>";</script>
</head>
<body>
<main>
    <div id="wrapper">
        <?php if ($this->tumblr && $this->user): ?>
            <div class="top-menu animated fadeInDown">
                <div class="right-align padd-right">
                    <a href="<?= site_url('login/logout'); ?>" class="logout">Logout</a>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->tumblr && $this->user && !$hide_menu): ?>
            <div id="main-menu" class="small">
                <ul class="menu">
                    <li>
                        <a href="<?= site_url('dashboard'); ?>">
                            <span class="label">
                            Dashboard
                            </span>
                            <span class="icon">
                                <i class="material-icons">dashboard</i>
                            </span>

                        </a>
                    </li>
                    <?php if ($this->user->role == 3): ?>
                        <li>
                            <a href="<?= site_url('manage'); ?>">
                                <span class="label">
                                    Advertisements
                                </span>
                                <span class="icon">
                                    <i class="material-icons">picture_in_picture</i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('blog/all'); ?>">
                                <span class="label">
                                    Blogs
                                </span>
                                <span class="icon">
                                    <i class="material-icons">chrome_reader_mode</i>
                                </span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?= site_url('dashboard/network-stats'); ?>">
                            <span class="label">
                                Network Stats
                            </span>
                            <span class="icon">
                                <i class="material-icons">trending_up</i>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('blog/setup'); ?>">
                                <span class="label">
                                    Blog Setup
                                </span>
                            <span class="icon">
                                    <i class="material-icons">build</i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                        <span class="label">
                            <?= $this->user->first_name . " " . $this->user->last_name; ?>
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <div id="container" class="<?= $this->tumblr && $this->user && !$hide_menu ? "" : "no-menu"; ?>">

