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

/*Редирект на результат поиска*/
/*Если найден только один результат - редирект на страницу*/
add_action('template_redirect', 'redirect_single_post');
function redirect_single_post() {
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1) {
            wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
        }
    }
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
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => 'Центр левый 2',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => 'Центр правый 1',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => 'Центр правый 2',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
/*    register_sidebar(array(
        'name' => 'Боковая левая',
        'before_widget' => '<div id="%1$s" class="panel panel-primary widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="panel-heading"><h3 class="panel-title widgettitle">',
        'after_title' => '</h3></div>',
    ));
    register_sidebar(array(
        'name' => 'Боковая правая',
        'before_widget' => '<div id="%1$s" class="panel panel-success widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="panel-heading"><h3 class="panel-title widgettitle">',
        'after_title' => '</h3></div>',
    ));*/
    register_sidebar(array(
        'name' => 'Боковая левая',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Боковая правая',
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
    wp_register_script( 'custom-script', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ) );
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

function breadcrumbs() {

    /* === ОПЦИИ === */
    $text['home']     = 'Главная'; // текст ссылки "Главная"
    $text['category'] = 'Архив рубрики "%s"'; // текст для страницы рубрики
    $text['search']   = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
    $text['tag']      = 'Записи с тегом "%s"'; // текст для страницы тега
    $text['author']   = 'Статьи автора %s'; // текст для страницы автора
    $text['404']      = 'Ошибка 404'; // текст для страницы 404

    $showCurrent = 1; // 1 - показывать название текущей статьи/страницы, 0 - не показывать
    $showOnHome  = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
    $delimiter   = '</li>'; // разделить между "крошками"
    $before      = '<li class="active">'; // тег перед текущей "крошкой"
    $after       = '</li>'; // тег после текущей "крошки"
    /* === КОНЕЦ ОПЦИЙ === */

    global $post;
    $homeLink = get_bloginfo('url') . '/';
    $linkBefore = '<li>';
    $linkAfter = '';
    $linkAttr = '';
    $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1) echo '<ul class="breadcrumb"><a href="' . $homeLink . '">' . $text['home'] . '</a></ul>';

    } else {

        echo '<ul class="breadcrumb">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

        if ( is_category() ) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

        } elseif ( is_search() ) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;

        } elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
                if ($showCurrent == 1) echo $before . get_the_title() . $after;
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
            echo $cats;
            printf($link, get_permalink($parent), $parent->post_title);
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_page() && !$post->post_parent ) {
            if ($showCurrent == 1) echo $before . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) echo $delimiter;
            }
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_tag() ) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif ( is_404() ) {
            echo $before . $text['404'] . $after;
        }

        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

        echo '</ul>';

    }
} // end breadcrumbs()

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

    array ( "name" => "URL фона",
        "desc" => "Введите ссылку к картинке для фона",
        "id" => $shortname . "_background",
        "type" => "text",
        "std" => "" ),

    array ( "name" => "Пользовательский CSS",
        "desc" => "Хотите использовать свой CSS-код? Вставьте его в это поле",
        "id" => $shortname . "_custom_css",
        "type" => "textarea",
        "std" => "" ),

    array ( "name" => "Верхнее меню",
        "desc" => "Прикрепить верхнее меню?",
        "id" => $shortname . "_fixed_topmenu",
        "type" => "checkbox",
        "std" => "" ),

    array ( "name" => "Закрыть сайт",
        "desc" => "Закрыть сайт для посещений, показывая посетителям заглушку (ниже). Если вы залогинены администратором - сайт будет показываться.",
        "id" => $shortname . "_siteclose",
        "type" => "checkbox",
        "std" => "" ),

    array ( "name" => "Заглушка",
        "desc" => "Если сайт закрыт, то показывать этот текст.",
        "id" => $shortname . "_siteclosetext",
        "type" => "textarea",
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

    array ( "name" => "Интервал смены картинки",
        "desc" => "Укажите интервал смены миниатюр записей в карусели, в миллисекундах (1 сек = 1000 мсек).",
        "id" => $shortname . "_interval_carousel",
        "type" => "text",
        "std" => "5000" ),

    array ( "name" => "Какой текст записи показывать",
        "desc" => "В карусели показывать цитату, текст записи или не показывать совсем.",
        "id" => $shortname . "_show_posttext",
        "type" => "select",
        "options" => array ("Не показывать", "Цитату записи", "Текст записи"),
        "std" => "Цитату записи" ),

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
    array ( "name" => "Записи",
        "type" => "section" ),
    array ("type" => "open"),

    array ( "name" => "Показывать хлебные крошки",
        "desc" => "Если включено, то хлебные крошки будут отображаться при просмотре записи.",
        "id" => $shortname . "_postbreadcrumbs",
        "type" => "checkbox",
        "std" => "" ),

    array ( "name" => "Панель записи",
        "desc" => "Показывать панель с автором, датой записи и количеством комментариев.",
        "id" => $shortname . "_postpanel",
        "type" => "checkbox",
        "std" => "" ),

    array ( "name" => "Показывать метки",
        "desc" => "Если включено - метки будут отображаться.",
        "id" => $shortname . "_posttags",
        "type" => "checkbox",
        "std" => "" ),

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
    //wp_enqueue_script("jQuery", "https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js");
    //wp_enqueue_script("jQuery", "http://code.jquery.com/jquery-1.9.1.min.js");
    /*wp_enqueue_style("Bootstrap", $file_dir."/css/bootstrap.min.css");*/
    //wp_enqueue_style("bootstrapSwitch", $file_dir."/css/bootstrapSwitch.css");
    //wp_enqueue_script("bootstrapSwitch", $file_dir."/js/bootstrapSwitch.js");
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
    <form method="post" role="form">
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
                           value="<?php if (get_option($value['id']) != ""){ echo stripslashes(get_option($value['id'])); } else {echo $value["std"];} ?>"
                           class="form-control" />

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

                    <textarea name="<?php echo $value['id']?>" type="<?php echo $value['type']?>" class="form-control" >
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

                    <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="form-control">
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
                            <button name="save<?php echo $i; ?>" type="submit" class="btn btn-default">Сохранить</button>
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

/* Widgets */
/* Show one page */

class WidgetPage extends WP_Widget{

    public function WidgetPage() {
        $widget_ops = array( 'classname' => 'widgetpage', 'description' => 'Отображает одиночную страницу' );
        $control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'widgetpage' );
        parent::__construct( 'widgetpage', 'WidgetPage', $widget_ops, $control_ops );
    }

    public function form($instance) { ?>
        <label for="<?php echo $this->get_field_id('page_id');?>"><?php _e("Выберите страницу"); ?></label>:
        <?php
        echo '<select name="'.$this->get_field_name('page_id').'" id="'.$this->get_field_id('page_id').'">';
        $pages = get_pages();
        foreach ( $pages as $page ) {
            $option = '<option value="' . $page->ID.'"';
            if($page->ID == $instance['page_id']){
                $option .= ' selected';
            }
            $option .= '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
        echo "</select>";
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('page_excerpt');?>"><?php _e("Краткий текст"); ?></label>:
            <textarea id="<?php echo $this->get_field_id('page_excerpt');?>" name="<?php echo $this->get_field_name('page_excerpt');?>" cols="25" rows="8"><?php echo $instance['page_excerpt'];?></textarea>
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        return $new_instance;
    }

    public function widget($args, $instance) {
        if ( $instance['page_id'] ){
            echo $args['before_widget'],$args['before_title'];
            $page = get_page($instance['page_id']);
            echo "<a href='".get_page_link($instance['page_id'])."'>".$page->post_title."</a>";
            echo $args['after_title'];
            echo "<a href='".get_page_link($instance['page_id'])."'>".get_the_post_thumbnail( $instance['page_id'], 'medium', array('class' => 'img-responsive') )."</a>";
            if ( $instance['page_excerpt'] ){
                echo "<p>".$instance['page_excerpt']."</p>";
            }else{
                echo "<p>".$page->post_content."</p>";
            }
            //echo "<a class='btn btn-success' href='".get_page_link($instance['page_id'])."'>Подробнее</a>";
            echo $args['after_widget'];
        }
    }
}
add_action('widgets_init', create_function('','return register_widget("WidgetPage");'));

/* Show single post */

class WidgetPost extends WP_Widget{

    public function WidgetPost() {
        $widget_ops = array( 'classname' => 'widgetpost', 'description' => 'Отображает одиночную запись' );
        $control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'widgetpost' );
        parent::__construct( 'widgetpost', 'WidgetPost', $widget_ops, $control_ops );
    }

    public function form($instance) { ?>
        <label for="<?php echo $this->get_field_id('post_id');?>"><?php _e("Выберите запись"); ?></label>:
        <?php
        echo '<select name="'.$this->get_field_name('post_id').'" id="'.$this->get_field_id('post_id').'">';
        $myposts = get_posts();
        foreach( $myposts as $post ){
            $option = '<option value="' . $post->ID.'"';
            if($post->ID == $instance['post_id']){
                $option .= ' selected';
            }
            $option .= '>';
            $option .= $post->post_title;
            $option .= '</option>';
            echo $option;
        }
        echo "</select>";
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('post_excerpt');?>"><?php _e("Краткий текст"); ?></label>:
            <textarea id="<?php echo $this->get_field_id('post_excerpt');?>" name="<?php echo $this->get_field_name('post_excerpt');?>" cols="25" rows="8"><?php echo $instance['post_excerpt'];?></textarea>
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        return $new_instance;
    }

    public function widget($args, $instance) {
        if ( $instance['post_id'] ){
            echo $args['before_widget'],$args['before_title'];
            $page = get_page($instance['post_id']);
            echo "<a href='".get_permalink($instance['post_id'])."'>".$page->post_title."</a>";
            echo $args['after_title'];
            echo "<a href='".get_permalink($instance['post_id'])."'>".get_the_post_thumbnail( $instance['post_id'], 'medium', array('class' => 'img-responsive') )."</a>";
            if ( $instance['post_excerpt'] ){
                echo "<p>".$instance['post_excerpt']."</p>";
            }else{
                echo "<p>".$page->post_content."</p>";
            }
            //echo "<a class='btn btn-success' href='".get_permalink($instance['post_id'])."'>Подробнее</a>";
            echo $args['after_widget'];
        }
    }
}
add_action('widgets_init', create_function('','return register_widget("WidgetPost");'));

/* Show children pages */

class WidgetChildrenPages extends WP_Widget{

    public function WidgetChildrenPages() {
        $widget_ops = array( 'classname' => 'widgetpage', 'description' => 'Отображает список вложенных страниц' );
        $control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'widgetchildrenpages' );
        parent::__construct( 'widgetchildrenpages', 'WidgetChildrenPages', $widget_ops, $control_ops );
    }

    public function form($instance) {

    }

    public function update($new_instance, $old_instance) {
        return $new_instance;
    }

    public function widget($args, $instance) {
        global $post;
        $children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0&sort_column=menu_order&sort_order=ASC&depth=1');
        if($children){
            echo $args['before_widget'],$args['before_title'];
            echo $args['after_title'];
            $children = preg_replace('%<a ([^>]+)>%U','<a $1 class="btn btn-success btn-block">', $children);
            echo $children;
            echo $args['after_widget'];
        }
    }
}
add_action('widgets_init', create_function('','return register_widget("WidgetChildrenPages");'));

/* Show link on category */

class WidgetCategoryLink extends WP_Widget{

    public function WidgetCategoryLink() {
        $widget_ops = array( 'classname' => 'widgetcategorylink', 'description' => 'Отображает ссылку на одну категорию' );
        $control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'widgetcategorylink' );
        parent::__construct( 'widgetcategorylink', 'WidgetCategoryLink', $widget_ops, $control_ops );
    }

    public function form($instance) { ?>
        <label for="<?php echo $this->get_field_id('category_id');?>"><?php _e("Выберите рубрику"); ?></label>:
        <?php
        echo '<select name="'.$this->get_field_name('category_id').'" id="'.$this->get_field_id('category_id').'">';
        $cats = get_categories('hide_empty=0');
        foreach( $cats as $cat ){
            $option = '<option value="' . $cat->cat_ID.'"';
            if($cat->cat_ID == $instance['category_id']){
                $option .= ' selected';
            }
            $option .= '>';
            $option .= $cat->cat_name;
            $option .= '</option>';
            echo $option;
        }
        echo "</select>";
    }

    public function update($new_instance, $old_instance) {
        return $new_instance;
    }

    public function widget($args, $instance) {
        if ( $instance['category_id'] ){
            echo $args['before_widget'];
/*            echo $args['before_title'];
            echo $args['after_title'];*/
            $cat = get_category($instance['category_id']);
            /*$cat_name = get_term($instance['category_id'],'category');*/
            echo '<a href="'.get_category_link($instance['category_id']).'">'.$cat->cat_name.'</a>';
            echo $args['after_widget'];
        }
    }
}
add_action('widgets_init', create_function('','return register_widget("WidgetCategoryLink");'));

/* Show post as modal windows */

class WidgetModalPost extends WP_Widget{

    public function WidgetModalPost() {
        $widget_ops = array( 'classname' => 'widgetmodalpost', 'description' => 'Отображает запись, как модальное окно' );
        $control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'widgetmodalpost' );
        parent::__construct( 'widgetmodalpost', 'WidgetModalPost', $widget_ops, $control_ops );
    }

    public function form($instance) { ?>
        <label for="<?php echo $this->get_field_id('post_id');?>"><?php _e("Выберите запись"); ?></label>:
        <?php
        echo '<select name="'.$this->get_field_name('post_id').'" id="'.$this->get_field_id('post_id').'">';
        $myposts = get_posts();
        foreach( $myposts as $post ){
            $option = '<option value="' . $post->ID.'"';
            if($post->ID == $instance['post_id']){
                $option .= ' selected';
            }
            $option .= '>';
            $option .= $post->post_title;
            $option .= '</option>';
            echo $option;
        }
        echo "</select>";
    }

    public function update($new_instance, $old_instance) {
        return $new_instance;
    }

    public function widget($args, $instance) {
        if ( $instance['post_id'] ){
            echo $args['before_widget'],$args['before_title'];
            $page = get_page($instance['post_id']);
            echo $page->post_title;
            echo $args['after_title'];
            ?>
            <!-- Button trigger modal -->
            <a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg">Прочитать</a>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="widgettitle"><?php echo $page->post_title ?></h2>
                        </div>
                        <div class="modal-post">
                            <?php
                            echo get_the_post_thumbnail( $instance['post_id'], 'medium', array('class' => 'img-responsive') );
                            echo "<p>".$page->post_content."</p>";
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <script>
                !function ($) {
                    $(function(){
                        // carousel demo
                        $('#myCarousel').carousel({<?php if(trim(get_option('nt_interval_carousel')) <> "") echo 'interval: '.get_option("nt_interval_carousel")?>})
                    })
                }(window.jQuery)
            </script>
            <?php

            //echo "<a class='btn btn-success' href='".get_permalink($instance['post_id'])."'>Подробнее</a>";
            echo $args['after_widget'];
        }
    }
}
add_action('widgets_init', create_function('','return register_widget("WidgetModalPost");'));