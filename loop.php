<?php

if( have_posts() ) : while ( have_posts() ) : the_post();
if( get_option("nt_postbreadcrumbs")){
    if(is_single() || is_page() && !is_front_page()){
        breadcrumbs();
    }
}
if( is_category() ){ ?>
    <div class="post-<?php the_ID(); ?>" id="post">
        <div class="col-lg-2">
            <?php
            }
            if( has_post_thumbnail() ) {
                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
                print '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" rel="lightbox" >';
                the_post_thumbnail('thumbnail');
                print '</a>';
            }
            if(is_category()){
            ?>
        </div>
        <div class="col-lg-10">
            <?php } ?>
            <?php if(is_single() || is_category()){ ?>
    		    <h6 class="post_date"><?php the_time("d F, Y"); ?></h6>
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
                    the_content('<a href="'.post_permalink().'" class="category_more_button"><i class="icon-chevron-right"></i></a>');
                    if(!is_page()){
                    ?>
                        <?php if(get_option("nt_posttags")){ ?>
                            <p>
                            <?php
                            $posttags = get_the_tags();
                            if ($posttags) {
                                print "Метки: ";
                                foreach($posttags as $tag) {
                                    print "<a href=\"".get_tag_link($tag->term_id)."\"><span class=\"label label-info\">".$tag->name."</span></a> ";
                                }
                            }
                        } ?>
                        </p>
                        <?php
                        if(get_option("nt_postpanel")){
                        ?>
                            <p>
                            <span class="glyphicon glyphicon-user"></span> <?php the_author(); ?>
                            | <span class="glyphicon glyphicon-calendar"></span> <?php the_time("d F, Y"); ?>
                            | <span class="glyphicon glyphicon-comment"></span> <?php comments_popup_link(__('Комментариев нет','templatelite'),__('1 комментарий','templatelite'), __('% комент.','templatelite'), '',__('','templatelite')); ?>
                            </p>
                    <?php
                        }
                    }
                }
                if(is_category()){
		        ?>
            </div>
        </div>
    <?php
    }
    if(is_single()){
        comments_template( '', true );
    }
    ?>
    <p class="clearfix"></p>

<?php
	endwhile;
endif;

//Reset Query
wp_reset_query();

?>