</div> <!--wrap -->
<div id="footer">
    <div class="container">
        <div class="col-lg-9">
            <?php
            if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Нижний левый') ) :
            endif;
            //Отобразить Google Analytics.
            echo get_option('omr_tracking_code');
            ?>
        </div>
        <div class="col-lg-3">
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
            $('#myCarousel').carousel({<?php if(trim(get_option('nt_interval_carousel')) <> "") echo 'interval: '.get_option("nt_interval_carousel")?>})
        })
    }(window.jQuery)
</script>
</body>
</html>