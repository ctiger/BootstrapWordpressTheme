<div class="row-fluid footer">
    <div class="span8">
        <?php
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Нижний левый') ) :
        endif;
        ?>
    </div>
    <div class="span4">
        <?php
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Нижний правый') ) :
        endif;
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