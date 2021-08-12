<?php
add_action('after_switch_theme', 'create_events_user_table' );



function create_events_user_table()
{
	global $wpdb;

	$table_name = 'events_user_table';
	$wp_track_table = $wpdb->prefix . "$table_name";

	#Check to see if the table exists already, if not, then create it
	if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table)
	{
		$sql = "CREATE TABLE $wp_track_table (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			event_id mediumint(9) NOT NULL,
			date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			name tinytext DEFAULT '' NOT NULL,
			phone tinytext DEFAULT '' NOT NULL,
			confirm tinyint DEFAULT 0 NOT NULL,
			UNIQUE KEY id (id)
		);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}
