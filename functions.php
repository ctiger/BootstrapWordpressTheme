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
function my_breadcrumb() {
    print "<ul class='breadcrumb'>";
    if ( !is_front_page() ) {
        echo "<li><a href=\"";
        echo get_option('home');
        echo "\">";
        echo "Главная";
	  echo "</a></li> <span class='divider'>/</span> ";
	}

	if ( is_category() || is_single() ) {
	  $category = get_the_category();
	  $ID = $category[0]->cat_ID;
	  echo get_category_parents($ID, TRUE, ' / ', FALSE );
	}

	if(is_single() || is_page()) { echo "<li class='active'>"; the_title(); echo "</li>"; }
	if(is_tag()){ echo "Tag: ".single_tag_title('',FALSE); }
	if(is_404()){ echo "404 - Page not Found"; }
	if(is_search()){ echo "Search"; }
	if(is_year()){ echo get_the_time('Y'); }

	echo "</ul>";

}//function


/**
 * ПАНЕЛЬ НАСТРОЕК
 */

$themename = "Дополнит. настройки";
$shortname = "nt";

/*--------------------------------------------------------*/

$options = array(

    array( "name" => "Настройки",
        "type" => "title" ),
    /*===========================================================*/
    array ( "name" => "Основные настройки",
        "type" => "section" ),
    array ( "type" => "open"),

    array ( "name" => "URL Логотипа",
        "desc" => "Введите ссылку к картинке логотипа",
        "id" => $shortname . "_logo",
        "type" => "text",
        "std" => "" ),

    array ( "name" => "Пользовательский CSS",
        "desc" => "Хотите использовать свой CSS-код? Вставьте его в это поле",
        "id" => $shortname . "_custom_css",
        "type" => "textarea",
        "std" => "" ),

    array ( "name" => "Responsive CSS",
        "desc" => "Включать адаптивный Bootstrap CSS-код?",
        "id" => $shortname . "_responsive_css",
        "type" => "checkbox",
        "std" => "" ),

    array ( "name" => "Верхнее меню",
        "desc" => "Прикрепить верхнее меню?",
        "id" => $shortname . "_fixed_topmenu",
        "type" => "checkbox",
        "std" => "" ),

    array ( "type" => "close"),
    /*===========================================================*/

    array ( "name" => "Карусель",
        "type" => "section" ),

    array ("type" => "open"),

    array ( "name" => "Показывать карусель",
        "desc" => "Укажите, где показывать карусель",
        "id" => $shortname . "_show_carousel",
        "type" => "select",
        "options" => array ("Не показывать", "Только на главной", "Везде"),
        "std" => "Только на главной" ),

    array ( "type" => "close"),
    /*===========================================================*/

    array ( "name" => "Центральные виджеты",
        "type" => "section" ),

    array ("type" => "open"),

    array ( "name" => "Показывать центральные виджеты",
        "desc" => "Укажите, где показывать центральные виджеты",
        "id" => $shortname . "_show_centralwidgets",
        "type" => "select",
        "options" => array ("Не показывать", "Только на главной", "Везде"),
        "std" => "Везде" ),

    array ( "type" => "close"),
    /*===========================================================*/

    array ( "name" => "Подвал",
        "type" => "section"),

    array ( "type" => "open"),

    array(  "name" => "Текст копирайта",
        "desc" => "Введите текст, который будет размещен в правой части подвала. Можно использовать HTML",
        "id" => $shortname."_footer_text",
        "type" => "text",
        "std" => ""),

    array(  "name" => "Код Google Analytics",
        "desc" => "Здесь вы можете разместить код Google Analytics, или любой другой счетчик",
        "id" => $shortname."_ga_code",
        "type" => "textarea",
        "std" => ""),

    array( "name" => "Favicon",
        "desc" => "Favicon - это пиксельная иконка, которая представляет ваш сайт. Вставьте URL к картинке с расширением .ico",
        "id" => $shortname."_favicon",
        "type" => "text",
        "std" => get_bloginfo('url') ."/favicon.ico"),

    array(  "name" => "Feedburner URL",
        "desc" => "Feedburner - это сервис Google, управляющий RSS-потоками. Paste your Feedburner URL here to let readers see it in your website",
        "id" => $shortname."_feedburner",
        "type" => "text",
        "std" => get_bloginfo('rss2_url')),

    array( "type" => "close")
    /*===========================================================*/
);

/*--------------------------------------------------------*/

function mytheme_add_admin(){

    global $themename, $shortname, $options;

    if($_GET['page'] == basename(__FILE__) ){

        if( 'saved' == $_REQUEST['action']){
            foreach ($options as $value){
                update_option($value['id'], $_REQUEST[$value['id']]);
            }

            foreach ($options as $value){
                if( isset ($_REQUEST[$value['id']]) ){
                    update_option($value['id'], $_REQUEST[$value['id']] );
                }else{
                    delete_option($value['id']);
                }
            }
            header("Location: admin.php?page=functions.php&saved=true");
            die;
        }
    }

    else if('reset' == $_REQUEST['action']){
        foreach($options as $value){
            delete_option($value['id']);
        }

        header("Location: admin.php&page=functions.php&reset=true");

        die;
    }

    add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mytheme_admin');
}

function mytheme_add_init() {
    $file_dir = get_bloginfo('template_directory');
    wp_enqueue_style("admin_panel", $file_dir."/css/admin-panel.css");
    wp_enqueue_script("admin_panel", $file_dir."/js/admin-panel.js");
    wp_enqueue_script("jQuery", "https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js");
    /*wp_enqueue_style("Bootstrap", $file_dir."/css/bootstrap.min.css");*/
    wp_enqueue_style("bootstrapSwitch", $file_dir."/css/bootstrapSwitch.css");
    wp_enqueue_script("bootstrapSwitch", $file_dir."/js/bootstrapSwitch.js");
}

function mytheme_admin(){
    global $themename, $shortname, $options;
    $i = 0;

    if($_REQUEST['action'] == 'saved')
        echo '<div id="message" class="updated fade"><p><strong> настройки темы '. $themename .' были сохранены</strong></p></div>';

    if($_REQUEST['reset'])
        echo '<div id="message" class="updated fade"><p><strong> настройки темы '. $themename .' были сброшены</strong></p></div>';
?>

<div class="wrap rm_wrap">
    <h2>Настройки <?php echo $themename ?></h2>

    <div class="rm_opts">
        <form method="post">
    <?php foreach($options as $value) {
        switch ($value['type']){
            case "open" :
                ?>

                <?php
                break;
            case "close" :
                ?>

                </div>
                </div>
                <br />

                <?php
                break;
            case "title" :
                ?>

                <p>Для более удобного управления темой <?php echo $themename;?>, вы можете использовать меню, расположенное ниже</p>

                <?php
                break;
            case "text" :
                ?>

                <div class="rm_input rm_text">
                    <label for="<?php echo $value['id']?>">
                        <?php echo $value['name']?>
                    </label>

                    <input name="<?php echo $value['id']?>" id="<?php echo $value['id']?>" type="<?php echo $value['type']?>"
                           value="<?php if (get_option($value['id']) != ""){ echo stripslashes(get_option($value['id'])); } else {echo $value["std"];} ?>" />

                    <small><?php echo $value['desc']; ?></small>
                    <div class="clearfix"></div>
                </div>

                <?php
                break;
            case "textarea" :
                ?>

                <div class="rm_input rm_textarea">
                    <label for="<?php echo $value['id']?>">
                        <?php echo $value['name']?>
                    </label>

                    <textarea name="<?php echo $value['id']?>" type="<?php echo $value['type']?>" >
                        <?php if (get_option($value['id']) != ""){
                            echo stripslashes(get_option($value['id']));
                        }else {
                            echo $value["std"];
                        }?>
                    </textarea>

                    <small><?php echo $value['desc']; ?></small>
                    <div class="clearfix"></div>
                </div>

                <?php
                break;
            case "select" :
                ?>

                <div class="rm_input rm_select">
                    <label for="<?php echo $value['id']?>">
                        <?php echo $value['name']?>
                    </label>

                    <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                        <?php foreach ($value['options'] as $option) : ?>
                            <option <?php if(get_option($value['id']) == $option){ echo "selected=selected";} ?>>
                                <?php echo $option; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <small><?php echo $value['desc']; ?></small>
                    <div class="clearfix"></div>
                </div>

                <?php
                break;
            case "checkbox" :
                ?>

                <div class="rm_input rm_checkbox">
                    <label for="<?php echo $value['id']?>">
                        <?php echo $value['name']?>
                    </label>

                    <?php if(get_option($value['id'])){
                        /*$checked = "checked=\"checked\"";*/
                        $checked = "checked";
                    }else{
                        $checked = "";
                    }
                    ?>

                    <div class="switch" data-on-label="ВКЛ." data-off-label="Выкл." data-animated="false" data-on="success" data-off="danger">
                        <input type="checkbox" name="<?php echo $value['id']?>" id="<?php echo $value['id']?>" value="true" <?php echo $checked; ?> />
                    </div>
<!--                    <script>
                        $('#normal-toggle-button').toggleButtons();
                    </script>-->
                    <small><?php echo $value['desc']; ?></small>
                    <div class="clearfix"></div>
                </div>

                <?php
                break;
            case "section" :
                $i++;
                ?>

                <div class="rm_section">
                <div class="rm_title">
                    <h3>
                        <img src="<?php bloginfo('template_directory')?>/img/trans.png" class="inactive" alt=""/>
                        <?php echo $value['name']; ?>
                    </h3>

                     <span class="submit">
                            <button name="save<?php echo $i; ?>" type="submit" class="btn">Сохранить</button>
                     </span>
                    <div class="clearfix"></div>
                </div>

                <div class="rm_options">
                <?php
                break;
        }
    }
    ?>
    <input type="hidden" name="action" value="saved" />
    </form>

    <form method="post">
        <p class="submit">
            <input name="reset" type="submit" value="Сброс" />
            <input name="action" type="hidden" value="reset" />
        </p>
    </form>
    <a href="https://github.com/ctiger/BootstrapWordpressTheme"><img
            style="position: absolute; top: 0; right: 0; border: 0;"
            src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"
            alt="Fork me on GitHub"></a>
    <div class="row-fluid">
        <div class="span8 offset2" style="text-align: center;">
            <iframe src="http://ghbtns.com/github-btn.html?user=ctiger&repo=BootstrapWordpressTheme&type=watch&count=true"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
            <iframe src="http://ghbtns.com/github-btn.html?user=ctiger&repo=BootstrapWordpressTheme&type=fork&count=true"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
            <iframe src="http://ghbtns.com/github-btn.html?user=ctiger&type=follow&count=true"
                    allowtransparency="true" frameborder="0" scrolling="0" width="170" height="30"></iframe>
        </div>
    </div>
    </div>

<?php  }

add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');

function templatelite_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case '' :
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, 40 ); ?>
                    <?php printf( __( '%s <span class="says">сказал:</span>', 'templatelite' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                </div><!-- .comment-author .vcard -->

                <div class="comment-meta commentmetadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                        <?php
                        printf( __( '%1$s в %2$s', 'templatelite' ), get_comment_date(),  get_comment_time() ); /* translators: 1: date, 2: time */
                        ?>
                    </a>
                    <?php edit_comment_link(__('Edit','templatelite'),'(',') ');?>
                </div><!-- .comment-meta .commentmetadata -->

                <div class="comment-body">
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em><?php _e('Ваш комментарий ожидает одобрения хозяина блога.');?></em><br/><br/>
                    <?php endif; ?>
                    <?php comment_text(); ?>
                </div>

                <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .reply -->
            </div><!-- #comment-##  -->
            <?php
            break;
        case 'pingback'  :
        case 'trackback' :
            ?>
            <li class="post pingback">
            <div><?php _e( 'Pingback:', 'templatelite' ); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Изменить','templatelite'),'(',') '); ?></div>
            <?php
            break;
    endswitch;
}