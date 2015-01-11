<?php
add_filter('wp_title', 'baw_hack_wp_title_for_home');
function baw_hack_wp_title_for_home( $title ) {
    if (empty( $title ) && ( is_home() || is_front_page())) {
        return get_bloginfo( 'name', 'display' ) . ' | ' . get_bloginfo( 'description' );
    } else {
        return $title.' '.get_bloginfo( 'name', 'display' );
    }
    return $title;
}

// Настройки темы
add_action('after_setup_theme', 'theme_setup');
function theme_setup() {
	register_nav_menus(array(
		'primary' => __('Верхнее меню')
	));

	if (function_exists('add_theme_support')) {
		add_theme_support('post-thumbnails');
	}

	// Отключаем лишнее
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
}

/* USER-AGENTS
================================================== */
function check_user_agent($type = NULL) {
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if ($type == 'bot') {
        // matches popular bots
        if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                return true;
                // watchmouse|pingdom\.com are "uptime services"
        }
    } else if ($type == 'mobile') {
        // matches popular mobile devices that have small screens and/or touch inputs
        // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
        // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
        if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                // these are the most common
                return true;
        } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                // these are less common, and might not be worth checking
                return true;
        }
    } else if ($type == 'browser') {
        // matches core browser types
        if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                return true;
        }
    }
    return false;
}
//$ismobile = check_user_agent('mobile');

// Подключение скриптов и стилей
add_action('wp_enqueue_scripts', 'theme_styles_scripts');
function theme_styles_scripts() {
	wp_enqueue_style('main-style', get_template_directory_uri().'/css/main.css', null, '22-07-2014');
    wp_deregister_script('jquery');

    if (!is_404()) {
        wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', false, null, false);
        
        wp_enqueue_style('slick', get_template_directory_uri().'/css/slick.css');
        wp_enqueue_script('slick', get_template_directory_uri().'/js/slick.js', array('jquery'), true);

        if (is_front_page()) {
            wp_enqueue_script('wordsChanger', get_template_directory_uri().'/js/wordsChanger.js', array('jquery'), '0.1');

            wp_enqueue_style('front-style', get_template_directory_uri().'/css/front.css', null, '22-07-2014');
            wp_enqueue_script('front-script', get_template_directory_uri().'/js/front.js', array('jquery', 'site-script'), '11-01-2015', true);
        }

        if (is_category('works')) {
            wp_enqueue_style('lightbox', get_template_directory_uri().'/css/lightbox.css', null, '2.7.1');
            wp_enqueue_script('lightbox', get_template_directory_uri().'/js/lightbox.js', array('jquery'), '2.7.1');

            wp_enqueue_style('works-style', get_template_directory_uri().'/css/portfolio.css', null, '22-07-2014');
            wp_enqueue_script('works-script', get_template_directory_uri().'/js/works.js', array('jquery', 'site-script'), '11-01-2015');
        }

        wp_enqueue_script('site-script', get_template_directory_uri().'/js/scripts.js', array('jquery'), '22-07-2014');
    }
}

/* Настройки темы в админке */
require get_template_directory().'/inc/customizer.php';

// Allow SVG files upload
function cc_mime_types($mimes){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// async scripts
function add_async_forscript($url) {
    if (strpos($url, '#asyncload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#asyncload', '', $url);
    else
        return str_replace('#asyncload', '', $url)."' async='async"; 
}
add_filter('clean_url', 'add_async_forscript', 11, 1);

// Убираем инлайновые стили галереи
add_filter('use_default_gallery_style', '__return_false');
// Свой вывод изображений галереи
add_filter('post_gallery', 'my_post_gallery', 10, 2);
function my_post_gallery($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) return '';

    // Here's your actual output, you may customize it to your need
    $output = '<div class="slider">';
    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
        // Fetch the thumbnail (or full image, it's up to you)
        $img_med = wp_get_attachment_image_src($id, 'medium');
        $img_large = wp_get_attachment_image_src($id, 'large');
        $img_full = wp_get_attachment_image_src($id, 'full');

        $output .= '<div><a class="slide" href="'.$img_large[0].'" data-lightbox="work-'.$attachment->post_parent.'">';
        $output .= '<img src="'.$img_med[0].'" alt="" />'."\n";
        $output .= "</a></div>\n";
    }
    $output .= "</div>\n";

    return $output;
}