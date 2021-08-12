<?php
// CPT
add_action('init', 'create_feedback' );
add_action('init', 'create_events' );

// CPT Taxonomy

// Pre get post
add_action( 'pre_get_posts', 'archive_page__sort_order');

// Redirects
add_action( 'template_redirect', 'redirect_single_to_archive');

// Admin columns
add_filter( 'manage_cpt_events_posts_columns', 'manage_cpt_events_posts_columns__callback' );
add_action( 'manage_cpt_events_posts_custom_column', 'manage_cpt_events_posts_custom_column__callback', 10, 2);


function create_feedback(){
    register_post_type('cpt_feedback', // Register Custom Post Type
        array(
        'labels' => array(
            'name'          => __('Звернення'),
            'edit_item'     => __('Звернення'),
            'singular_name' => __('Звернення'),
            'menu_name'     => __('Звернення'),
        ),
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'menu_icon'  => 'dashicons-welcome-widgets-menus',
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => false,
        'supports' => array('title', 'editor'), // Go to Dashboard Custom HTML5 Blank post for supports
    ));
}

function create_events(){
	register_post_type('cpt_events', // Register Custom Post Type
		array(
			'labels' => array(
				'name'          => __('Події / Заходи'), // Rename these to suit
				'singular_name' => __('Події / Заходи'),
				'menu_name'     => __('Події / Заходи'),
			),
			'public' => true,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'menu_icon'  => 'dashicons-calendar',
			'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
			'has_archive' => false,
			'supports' => array('title', 'editor', 'thumbnail'), // Go to Dashboard Custom HTML5 Blank post for supports
		));
}



function redirect_single_to_archive(){
	global $post;

	if ( is_singular('cpt_feedback') ) {
		$redirectLink = get_post_type_archive_link( 'cpt_feedback' );
		wp_redirect( $redirectLink, 302 );
		exit;
	}

}



function archive_page__sort_order($query){
	if( is_archive() ):
		//Set the order ASC or DESC
		$query->set( 'order', 'ASC' );
		//Set the orderby
		$query->set( 'orderby', 'date' );
	endif;
};







function manage_cpt_events_posts_columns__callback( $columns ) {
	$columns['date_time_event'] = __( 'Дата події' );
	return $columns;
}

function manage_cpt_events_posts_custom_column__callback( $column, $post_id ) {
	switch ($column) {
		case 'date_time_event' :
			$date_time_event = get_post_meta($post_id, 'date_time_event', true);
			echo $date_time_event;
			break;
	}
}
