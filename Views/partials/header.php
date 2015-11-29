<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conference Scheduler</title>
    <link rel="stylesheet" href="<?=\Framework\Helpers\Helpers::url()?>Styles/style.css" type="text/css">
    <link rel="stylesheet" href="<?=\Framework\Helpers\Helpers::url()?>Styles/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?=\Framework\Helpers\Helpers::url()?>Styles/bootstrap-datetimepicker.min.css" type="text/css">
    <script src="<?=\Framework\Helpers\Helpers::url()?>Libs/jquery-2.1.4.min.js" type="application/javascript"></script>
    <script src="<?=\Framework\Helpers\Helpers::url()?>Libs/bootstrap.min.js"></script>
    <script src="<?=\Framework\Helpers\Helpers::url()?>Libs/moment.min.js"></script>
    <script src="<?=\Framework\Helpers\Helpers::url()?>Libs/bootstrap-datetimepicker.min.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <span class="navbar-brand header-logo">CS</span>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-9" aria-expanded="false">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= \Framework\Helpers\Helpers::url() . 'home'?>"><span class="glyphicon glyphicon-home"></span></a></li>
                        <li><a href="<?= \Framework\Helpers\Helpers::url() . 'conferences/ongoing'?>" class="hvr-underline-reveal">Ongoing</a></li>
                        <li><a href="<?= \Framework\Helpers\Helpers::url() . 'conferences/future'?>" class="hvr-underline-reveal">Future</a></li>
                        <li><a href="<?= \Framework\Helpers\Helpers::url() . 'conferences/past'?>" class="hvr-underline-reveal">Past</a></li>
                        <?php if(\Framework\HttpContext\HttpContext::getInstance()->getIdentity()->isLogged()): ?>
                            <li role="presentation" class="dropdown" id="admin-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    Conferences menu<span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" id="categories-menu">
                                    <li><a href="<?= \Framework\Helpers\Helpers::url() . 'conferences/create'?>" class="hvr-underline-reveal">Add conference</a></li>
                                    <li><a href="<?= \Framework\Helpers\Helpers::url() . 'conferences/my'?>" class="hvr-underline-reveal">My conferences</a></li>
                                    <li><a href="<?= \Framework\Helpers\Helpers::url() . 'conferences/participating'?>" class="hvr-underline-reveal">Participating conferences</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(\Framework\HttpContext\HttpContext::getInstance()->getIdentity()->isAdmin()): ?>
                            <li role="presentation" class="dropdown" id="admin-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    Admin <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" id="categories-menu">
                                    <li><a href="<?= \Framework\Helpers\Helpers::url() . 'admin/users'?>" class="hvr-underline-reveal">Users</a></li>
                                    <li><a href="<?= \Framework\Helpers\Helpers::url() . 'admin/conferences'?>" class="hvr-underline-reveal">Conferences</a></li>
                                    <li><a href="<?= \Framework\Helpers\Helpers::url() . 'admin/venues'?>" class="hvr-underline-reveal">Venues</a></li>
                                    <li><a href="<?= \Framework\Helpers\Helpers::url() . 'admin/halls'?>" class="hvr-underline-reveal">Halls</a></li>
                                    <li><a href="<?= \Framework\Helpers\Helpers::url() . 'admin/api'?>" class="hvr-underline-reveal">Api</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if(\Framework\HttpContext\HttpContext::getInstance()->getIdentity()->isLogged()): ?>
                            <li><a href="<?= \Framework\Helpers\Helpers::url() . 'users/profile'?>" class="hvr-underline-reveal"><span class="glyphicon glyphicon-user"></span></a></li>
                            <li><a href="<?= \Framework\Helpers\Helpers::url() . 'users/password'?>"><span class="glyphicon glyphicon-lock"></span></a></li>
                            <li><a href="<?= \Framework\Helpers\Helpers::url() . 'users/logout'?>" class="hvr-underline-reveal"><span class="glyphicon glyphicon-log-out"></span></a></li>
                        <?php else: ?>
                            <li><a href="<?= \Framework\Helpers\Helpers::url() . 'users/login'?>" class="hvr-underline-reveal"><span class="glyphicon glyphicon-log-in"></span></a></li>
                            <li><a href="<?= \Framework\Helpers\Helpers::url() . 'users/register'?>" class="hvr-underline-reveal"><span class="glyphicon glyphicon-registration-mark"></span></a></li>
                        <?php endif; ?>
                    </ul>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>

<main class="row">