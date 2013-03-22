<div class="post-wrapper">

<?php

if ( have_posts() ) : while ( have_posts() ) : the_post();

?>

	<div id="post" class="post-<?php the_ID(); ?>">
        <?php if(is_category()){ ?>
        <div class="row-fluid">
            <div class="span2">
                <?php
                }
                if ( has_post_thumbnail() ) {
                    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
                    print '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" rel="lightbox" >';
                    the_post_thumbnail('thumbnail');
                    print '</a>';
                }
                if(is_category()){
                ?>
            </div>
            <div class="span10">
                <?php } ?>
                <?php if(is_single() || is_category()){ ?>
    		        <h6><?php the_time("d F, Y"); ?></h6>
	    	    <?php } ?>
                <h2 class="post_title">
                    <?php if(!is_single() && !is_page()){ ?>
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php if ( function_exists('the_title_attribute')) the_title_attribute(); else the_title(); ?>"><?php the_title(); ?></a>
                    <?php }else{ ?>
                        <?php the_title(); ?>
                    <?php } ?>
                </h2>
                <?php
                if(!is_category()){
        			print "<h4 class=\"post_category\">";
	        		the_category();
		        	print "</h4>";
		        }
                if(!is_category()){
                    the_content('<a href="'.post_permalink().'" class="category_more_button"><i class="icon-chevron-right"></i></a>');
                }
                if(is_category()){
		        ?>
            </div>
        </div>
        <?php } ?>
	</div> <!-- post -->
    <p class="clearfix"></p>

<?php
	endwhile;
endif;
?>
</div> <!-- post-wrapper -->
<?php

//Reset Query
wp_reset_query();

?>