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

$categories = get_categories('hide_empty=0&order_by=name');
$wp_cats = array();

foreach ($categories as $category_list){
    $wp_cats[$category_list -> cat_ID] = $category_list -> cat_name;
}

array_unshift($wp_cats, "Выберите рубрику");

/*--------------------------------------------------------*/

$options = array(

    array( "name" => "Настройки",
        "type" => "title" ),

    array ( "name" => "Основные настройки",
        "type" => "section" ),
    array ( "type" => "open"),

    array ( "name" => "Цветовая схема",
        "desc" => "Выберите цветовую схему темы",
        "id" => $shortname . "_color_scheme",
        "type" => "select",
        "options" => array ("синяя", "красная", "зеленая"),
        "std" => "blue" ),

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

    array ( "type" => "close"),

    array ( "name" => "Домашняя страница",
        "type" => "section" ),

    array ("type" => "open"),

    array ( "name" => "Картинка в шапке, на главной странице",
        "desc" => "Введите URL картинки, которая будет использоваться в шапке",
        "id" => $shortname ."_header_img",
        "type" => "text",
        "std" => ""),

    array ( "name" => "Рубрика домашней страницы",
        "desc" => "Выберите рубрику, в которую будут публиковатся записи",
        "id" => $shortname ."_feat_cat",
        "type" => "select",
        "options" => $wp_cats,
        "std" => "Выберите рубрику"),

    array ( "type" => "close"),

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
    wp_enqueue_style("admin_panel", $file_dir."/css/admin-panel.css", false, "1.0", "all");
    wp_enqueue_script("admin_panel", $file_dir."/js/admin-panel.js", false, "1.0");
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
                           value="<?php if (get_settings($value['id']) != ""){ echo stripslashes(get_settings($value['id'])); } else {echo $value["std"];} ?>" />

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
                        <?php if (get_settings($value['id']) != ""){
                            echo stripslashes(get_settings($value['id']));
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
                            <option <?php if(get_settings($value['id']) == $option){ echo "selected=selected";} ?>>
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

                    <?php if(get_options($value['id'])){
                        $checked = "checked=\"checked\"";
                    }else{
                        $checked = "";
                    }
                    ?>

                    <input type="checkbox" name="<?php echo $value['id']?>" id="<?php echo $value['id']?>" value="true" <?php echo $checked; ?> />

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
                            <input name="save<?php echo $i; ?>" type="submit" value="Сохранить" />
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

    </div>

<?php  }

add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');