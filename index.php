<?php get_header(); ?>

    <div class="container content">
        <div class="col-lg-9">
            <?php
                include("loop.php");
            ?>
        </div>
        <div class="col-lg-3 sidebar">
            <?php
                include("sidebar.php");
            ?>
        </div>
    </div>

<?php get_footer(); ?>