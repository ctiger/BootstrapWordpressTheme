<?php

if ( have_posts() ) : while ( have_posts() ) : the_post();

?>

<div class="post-wrapper">
	<div id="post" class="post-<?php the_ID(); ?>">
        <?php if(is_single()){ ?>
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
        the_post_thumbnail();
		the_content('<a href="'.post_permalink().'#more-1">Читать далее...</a>');

		?>
	</div> <!-- post -->
</div> <!-- post-wrapper -->

<?php
	endwhile;
endif;

?>
<div class="pagenavi">
	<?php //wp_pagenavi(); ?>
</div>
<?php

//Reset Query
wp_reset_query();

?>