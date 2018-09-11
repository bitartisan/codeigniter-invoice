<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name='robots' content='noindex,nofollow,noarchive' />
	<title>Boară Remus Florian PFA - Invoicing</title>
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $app['assets']; ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $app['assets']; ?>/css/styles.css" />
</head>
<body>

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md fixed-top navbar-light bg-white border-bottom shadow-sm">
        <a class="navbar-brand" href="<?php echo $app['base_url'] ?>">PFA Invoice</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item<?php echo ( $title == 'Home' ? ' active' : '' ); ?>">
                    <a class="nav-link" href="<?php echo $app['base_url'] ?>">Home</a>
                </li>
                <li class="nav-item<?php echo ( $title == 'Client' ? ' active' : '' ); ?>">
                    <a class="nav-link" href="<?php echo $app['base_url'] ?>index.php/client">Clients</a>
                </li>
                <li class="nav-item<?php echo ( $title == 'Contract' ? ' active' : '' ); ?>">
                    <a class="nav-link" href="<?php echo $app['base_url'] ?>index.php/contract">Contracts</a>
                </li>
                <?php
                if ($this->loggedin) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $app['base_url'] ?>index.php/auth/logout">Log-out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">
                            <small><?php echo $app['login_info']; ?></small>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </nav>
</header>

<!-- Begin page content -->
<main id="invoicing" role="main" class="container-fluid">

    <div class="row mx-md-5 alerts-container">
        <div class="col">
            <?php if(has_alert()): ?>
                <?php foreach(has_alert() as $type => $message): ?>
                    <div class="alert <?php echo $type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
    	        <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
