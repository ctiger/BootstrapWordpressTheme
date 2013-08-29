<div id="myCarousel" class="carousel slide">
    <?php
    $myCounter = 0;
    $sticky = get_option( 'sticky_posts' );
    query_posts( array('post_type' => 'post', 'post__in' => $sticky) );
    ?>
    <ol class="carousel-indicators">
        <?php
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            $myCounter++;
            ?>
            <li data-target="#myCarousel" data-slide-to="<?php print ($myCounter-1); ?>"<?php if ($myCounter == 1) : print " class='active'"; endif; ?>></li>
            <?php
            endwhile;
        endif;
        ?>
    </ol>
    <div class="carousel-inner">
        <?php
        $myCounter = 0;
        rewind_posts();
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            $myCounter++;
            ?>
            <div class="item<?php if ($myCounter == 1) : print " active"; endif; ?>">
                <?php the_post_thumbnail('full'); ?>
                <div class="container">
                    <div class="carousel-caption">
                        <h1><?php the_title(); ?></h1>
                        <p><?php the_excerpt(); ?></p>
                        <a class="btn btn-large btn-primary" href="<?php the_permalink() ?>">Прочитать</a>
                    </div>
                </div> <!-- post -->
            </div> <!-- post-wrapper -->
            <?php
            endwhile;
        endif;

        //Reset Query
        wp_reset_query();
        ?>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div> <!-- /.carousel -->