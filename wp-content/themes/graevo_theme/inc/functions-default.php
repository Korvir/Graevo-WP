<?php
function dd( $value ) {
	echo '<pre>';
	var_dump( $value );
	echo '</pre>';
}

function pdd( $value ) {
	echo '<pre>';
	var_dump( $value );
	echo '</pre>';
	wp_die();
}



if ( function_exists('add_theme_support') ) {

	// Add Menu Support
    add_theme_support('menus');
    add_theme_support( 'woocommerce' );
	add_theme_support('automatic-feed-links');
	add_theme_support( 'html5', array( 'search-form' ) );

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('small', 300, '', true);
    add_image_size('medium', 600, '', true);
    add_image_size('large', 1000, '', true);
    add_image_size('large2', 1400, '', true);
    add_image_size('large3', 1920, '', true);

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}






// Remove invalid rel attribute values in the categorylist
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
function remove_category_rel_from_category_list($thelist){
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
// add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
function add_slug_to_body_class($classes){
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}


// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')){
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}


// Remove wp_head() injected Recent Comment styles
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
function my_remove_recent_comments_style(){
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}


// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
add_action('init', 'theme_pagination'); // Add our HTML5 Pagination
function theme_pagination(){
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text'          => __( '<i class="fas fa-angle-double-left"></i>' ),
        'next_text'          => __( '<i class="fas fa-angle-double-right"></i>' ),
    ));
}


// Custom View Article link to Post
add_filter('excerpt_more', 'theme_view_article'); // Add 'View Article' button instead of [...] for Excerpts
function theme_view_article($more){
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove 'text/css' from our enqueued stylesheet
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
function html5_style_remove($tag){
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}


// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
function remove_thumbnail_dimensions( $html ){
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}




/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/
// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);


// Add Filters
add_filter( 'use_block_editor_for_post', '__return_false' ); // disable Gutenbers
add_filter( 'widget_text', 'do_shortcode' ); // Allow shortcodes in Dynamic Sidebar
add_filter( 'widget_text', 'shortcode_unautop' ); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter( 'the_excerpt', 'shortcode_unautop' ); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter( 'the_excerpt', 'do_shortcode' ); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether


## remove version from css and js for proper caching
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
function _remove_script_version( $src ){
    $parts = explode( '?', $src );
    return $parts[0];
}


?>
