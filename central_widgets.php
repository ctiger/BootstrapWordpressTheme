<!-- Example row of columns -->
<div class="row-fluid center-widget">
    <div class="span6">
        <?php
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр левый 1')) :
        endif;
        ?>
    </div>
    <div class="span6">
        <?php
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр левый 2')) :
        endif;
        ?>
    </div>
    <!--<div class="span3">
    <?php
/*    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр правый 1') ) :
    endif;
    */?>
</div>
<div class="span3">
    <?php
/*    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Центр правый 2') ) :
    endif;
    */?>
</div>-->
</div>