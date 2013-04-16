<?php get_header(); ?>

    <div class="row-fluid content">
        <div class="span8">
            <?php
                include("loop.php");
            ?>
        </div>
        <div class="span4">
            <?php
                include("sidebar.php");
            ?>
        </div>
    </div>
    <hr>

<?php get_footer(); ?>