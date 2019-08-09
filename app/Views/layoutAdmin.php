<?php
$user = \Delight\Auth\Auth::getUsername();
?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$this->e($title)?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/assets_admin/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets_admin/css/font-awesome.min.css">

    <link rel="stylesheet" href="/assets_admin/css/ionicons.min.css">
    <!-- DataTables -->

    <link rel="stylesheet" href="/assets_admin/css/dataTables.bootstrap.min.css">

    <link rel="stylesheet" href="/assets_admin/css/select2.min.css">
    <link rel="stylesheet" href="/assets_admin/css/styletarget.css">


    <!-- Ionicons -->
    <link rel="stylesheet" href="/assets_admin/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets_admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="/assets_admin/css/skin-purple.min.css">


<!--    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
<!--    <script src="/assets_admin/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>-->

    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">


        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>L</b>TE</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>KOTHA</b>PRO</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/assets_admin/img/avatar04.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?=$user?></p>
                    <!-- Status -->
                    <?php
                     if (!$_SESSION['auth_logged_in'] == true): ?>
                        <a href='#'><i class='fa fa-circle text-danger'></i> Offline</a>
                     <?php else:?>
                         <a href='#'><i class='fa fa-circle text-success'></i> Online</a>
                     <?php endif; ?>

<!--                    <a href="#"><i class="fa fa-circle text-success"></i> Offline</a>-->
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Navigation</li>
                <!-- Optionally, you can add icons to the links -->
                <li><a href="/admin"><i class="fa fa-image"></i> <span>All images</span></a></li>
                <li><a href="/admin/category/all"><i class="fa fa-list"></i> <span>Categories</span></a></li>
                <li><a href="/admin/users"><i class="fa fa-group"></i> <span>Users / Authors</span></a></li>
            </ul>
            <!-- /.sidebar-menu -->

            <br>
            <ul class="sidebar-menu" data-widget="tree">
                <li><a href="/admin/logout" style="font-size: large; text-transform: uppercase;"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>

            </ul>
            <!-- /.sidebar-menu -->

        </section>
        <!-- /.sidebar -->
    </aside>

<?=$this->section('content')?>
