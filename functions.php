<?php
add_theme_support('post-thumbnails');
set_post_thumbnail_size(get_option("thumbnail_size_w"),get_option("thumbnail_size_h"),true);
add_image_size('gallery',get_option("thumbnail_size_w"),get_option("thumbnail_size_h"),true);
register_nav_menu( 'primary', __( 'topmenu', 'twentyeleven' ) );

add_filter('category_link', create_function('$a', 'return str_replace("category/", "", $a);'), 9999);

add_filter('the_generator', create_function('', 'return "";'));
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

if ( function_exists('remove_filter') ) {
    remove_filter('the_content', 'wptexturize');
    remove_filter('the_title', 'wptexturize');
    remove_filter('comment_text', 'wptexturize');
}

/*Widgets*/
if ( function_exists('register_sidebar') )
{
    register_sidebar(array(
        'name' => 'Верхний правый',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Центр левый 1',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Центр левый 2',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Центр правый 1',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Центр правый 2',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Боковая',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Нижний левый',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Нижний правый',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}

function wpbootstrap_scripts_with_jquery()
{

// Register the script like this for a theme: 
    wp_register_script( 'custom-script', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ) );

// For either a plugin or a theme, you can then enqueue the script: 
    wp_enqueue_script( 'custom-script' );
}

add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );

class description_walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth, $args)
    {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        // If the item has children, add the dropdown class for bootstrap
        if ( $args->has_children ) {
            $class_names = "dropdown ";
        }

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="'. esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        // if the item has children add these two attributes to the anchor tag
        if ( $args->has_children ) {
            $attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
        $item_output .= $args->link_after;
        // if the item has children add the caret just before closing the anchor tag
        if ( $args->has_children ) {
            $item_output .= '<b class="caret"></b></a>';
        }
        else{
            $item_output .= '</a>';
        }
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
    {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}
// this is the fallback for header menu
function bones_main_nav_fallback() {
    // Figure out how to make this output bootstrap-friendly html
    //wp_page_menu( 'show_home=Home&menu_class=nav' );
}