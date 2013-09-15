<div class="navbar navbar-default<?php if(get_option('nt_fixed_topmenu')) { print " navbar-fixed-top"; } ?>">
    <div class="container">
        <div class="navbar-collapse collapse" role="navigation">
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
            <form class="navbar-form navbar-right" role="search" action="<?php echo home_url('/'); ?>">
                <div class="form-group">
                    <input type="text" name="s" id="searchinput" value="" class="form-control" placeholder="Поиск">
                </div>
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
            </form>
        </div>
    </div>
</div>