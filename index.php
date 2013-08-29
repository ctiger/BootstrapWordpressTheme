<?php get_header(); ?>

    <div class="row content">
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
</div> <!--container-->
</div> <!--wrap-->
<?php get_footer(); ?>