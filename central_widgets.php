<div class="container">
    <div class="center-widget">
        <div class="col-lg-3">
            <?php
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр левый 1')) :
            endif;
            ?>
        </div>
        <div class="col-lg-3">
            <?php
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр левый 2')) :
            endif;
        ?>
        </div>
        <div class="col-lg-3">
            <?php
            if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр правый 1') ) :
            endif;
        ?>
        </div>
        <div class="col-lg-3">
            <?php
            if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр правый 2') ) :
            endif;
            ?>
        </div>
    </div>
</div>