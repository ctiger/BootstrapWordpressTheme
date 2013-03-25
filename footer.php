<div class="row-fluid footer">
    <div class="span8">
        <?php
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Нижний левый') ) :
        endif;
        //Отобразить Google Analytics.
        echo get_option('omr_tracking_code');
        ?>

    </div>
    <div class="span4">
        <?php
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Нижний правый') ) :
        endif;
        echo stripslashes(get_option('nt_footer_text'));
        ?>
    </div>
</div>

</div>
<?php wp_footer(); ?>
<script>
    !function ($) {
        $(function(){
            // carousel demo
            $('#myCarousel').carousel()
        })
    }(window.jQuery)
</script>
</body>
</html>