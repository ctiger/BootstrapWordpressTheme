<div id="myCarousel" class="carousel slide">
    <div class="carousel-inner">
        <?php
        $sticky = get_option( 'sticky_posts' );
        query_posts( array('post_type' => 'post', 'post__in' => $sticky) );
        $i = 0;
        if ( have_posts() ) : while ( have_posts() ) : the_post();
        ?>
            <div class="item <?php if ($i == 0) : print "active"; endif; ?>">
                <?php the_post_thumbnail('full'); ?>
                <div class="container">
                    <div class="carousel-caption">
                        <h1><?php the_title(); ?></h1>
                        <p class="lead"><?php the_excerpt(); ?></p>
                        <a class="btn btn-large btn-primary" href="<?php the_permalink() ?>">Прочитать</a>
                    </div>
                </div> <!-- post -->
            </div> <!-- post-wrapper -->
        <?php
            $i++;
            endwhile;
        endif;

        //Reset Query
        wp_reset_query();
        ?>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div> <!-- /.carousel -->
