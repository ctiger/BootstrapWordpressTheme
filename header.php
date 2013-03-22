<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php wp_title('|',1,'right'); ?> <?php bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
    <link href="<?php bloginfo("template_url"); ?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php bloginfo("template_url"); ?>/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php wp_enqueue_script("jquery"); ?>
    <?php wp_head(); ?>

</head>

<body>

<div class="container">
    <div class="masthead">
        <div class="row-fluid">
            <div class="span8">
                <h3 class="site-name"><a class="brand" href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></h3>
                <h6 class="site-description"><?php bloginfo('description'); ?></h6>
            </div>
            <div class="span4">
                <?php
                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Верхний правый') ) :
                endif;
                ?>
            </div>
        </div>
        <?php
        include("navbar.php");
        ?>
    </div>
    <?php
    if( is_home() || is_front_page() ){
        ?>
        <!-- Carousel
        ================================================== -->
        <?php
        include("carousel.php");
        ?>


        <hr>
        <?php } ?>
        <!-- Example row of columns -->
        <div class="row-fluid center-widget">
            <div class="span3">
                <?php
                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр левый 1') ) :
                endif;
                ?>
            </div>
            <div class="span3">
                <?php
                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр левый 2') ) :
                endif;
                ?>
            </div>
            <div class="span3">
                <?php
                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр правый 1') ) :
                endif;
                ?>
            </div>
            <div class="span3">
                <?php
                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр правый 2') ) :
                endif;
                ?>
            </div>
        </div>
        <hr>
