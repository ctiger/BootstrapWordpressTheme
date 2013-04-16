<?php get_header(); ?>

    <div class="row-fluid content">
        <div class="span8">
            <?php
                include("loop.php");
            ?>
        </div>
        <div class="span4 sidebar">
            <?php
                include("sidebar.php");
            ?>
        </div>
    </div>

<?php get_footer(); ?>