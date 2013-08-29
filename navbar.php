<div class="navbar navbar-default<?php if(get_option('nt_fixed_topmenu')) { print " navbar-fixed-top"; } ?>">
    <div class="navbar-collapse collapse" role="navigation">
        <!--<ul class="nav navbar-nav">-->
            <?php
            wp_nav_menu(
                        array(
                            'menu' => 'topmenu', /* menu name */
                            'menu_class' => 'nav navbar-nav',
                            'theme_location' => 'main_nav', /* where in the theme it's assigned */
                            'container' => 'false', /* container class */
                            'fallback_cb' => 'bones_main_nav_fallback', /* menu fallback */
                            'depth' => '0', /* suppress lower levels for now */
                            'walker' => new description_walker()
                        )
            );
            ?>
        <!--</ul>-->
    </div>
</div>