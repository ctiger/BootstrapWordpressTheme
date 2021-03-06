<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title><?php wp_title('|',1,'right'); ?> <?php bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?php bloginfo("template_url"); ?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
    <?php if(trim(get_option('nt_background')) <> ""){ ?>
    <style>
        body {
            background: url("<?php echo get_option('nt_background'); ?>");
        }
    </style>
    <?php } ?>
    <?php if(get_option('nt_fixed_topmenu')) { ?>
    <style>
        .masthead{
            padding-top: 50px;
        }
    </style>
    <?php } ?>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php wp_enqueue_script("jquery"); ?>
    <?php wp_head(); ?>

</head>

<body>
<div id="wrap">
    <?php
    if(get_option('nt_fixed_topmenu')) {
        include("navbar.php");
    }
    ?>
    <div class="masthead">
        <div class="container">
            <div class="col-lg-8">
                <h3 class="site-name"><a class="brand" href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></h3>
                <h4 class="site-description"><?php bloginfo('description'); ?></h4>
            </div>
            <div class="col-lg-4">
                <?php
                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Верхний правый') ) :
                endif;
                ?>
            </div>
        </div>
    </div>
    <?php
    if(!get_option('nt_fixed_topmenu')) { ?>
        <div class="container">
            <?php include("navbar.php"); ?>
        </div>
    <?php } ?>
    <!-- Carousel ================================================== -->
    <?php
    if(get_option("nt_show_carousel") != "Не показывать"){
        if(get_option("nt_show_carousel") == "Только на главной"){
            if(is_home() || is_front_page()) {
                include("carousel.php");
            }
        }else{
            if(get_option("nt_show_carousel") == "Везде"){
                if(is_single() || is_page()) {
                    include("carousel.php");
                }
            }
        }
    }
    ?>
    <!-- End Carousel ============================================= -->
    <!-- Central Widgets ========================================== -->
    <?php
    if(get_option("nt_show_centralwidgets") != "Не показывать"){
        if(get_option("nt_show_centralwidgets") == "Только на главной"){
            if(is_home() || is_front_page()) {
                include("central_widgets.php");
            }
        }else{
            if(get_option("nt_show_centralwidgets") == "Везде"){
                if(is_single() || is_page()) {
                    include("central_widgets.php");
                }
            }
        }
    }
    ?>
    <!-- End Central Widgets ============================================= -->