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
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="http://localhost/wp-content/uploads/2013/03/424613-1680x1050.jpg" alt="">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Example headline.</h1>
                            <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <a class="btn btn-large btn-primary" href="#">Sign up today</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="http://localhost/wp-content/uploads/2013/03/194236-1680x1050.jpg" alt="">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Another example headline.</h1>
                            <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <a class="btn btn-large btn-primary" href="#">Learn more</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="http://localhost/wp-content/uploads/2013/03/412207-1680x1050.jpg" alt="">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>One more for good measure.</h1>
                            <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <a class="btn btn-large btn-primary" href="#">Browse gallery</a>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div><!-- /.carousel -->

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
