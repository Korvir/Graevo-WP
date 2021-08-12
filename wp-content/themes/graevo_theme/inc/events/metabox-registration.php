<?php
// Add Metabox to CPT 'cpt_events'
add_action( 'add_meta_boxes', 'register_event_metabox' );

// Event User Confirmation
add_action( 'wp_ajax_event_user_confirmation', 'event_user_confirmation_callback' );
add_action( 'wp_ajax_nopriv_event_user_confirmation', 'event_user_confirmation_callback' );

// Event User Delete
add_action( 'wp_ajax_event_user_delete', 'event_user_delete_callback' );
add_action( 'wp_ajax_nopriv_event_user_delete', 'event_user_delete_callback' );


function register_event_metabox() {

	add_meta_box(
			'event_registered_users',
			__( 'Зареєстровані користувачі' ),
			'register_event_metabox_callback',
			'cpt_events'
	);

}

function register_event_metabox_callback( $post ) {

	global $wpdb;
	$table_name     = 'events_user_table';
	$wp_track_table = $wpdb->prefix . "$table_name";

	$this_event_users = $wpdb->get_results( "
		SELECT * FROM `$wp_track_table`
		WHERE event_id = $post->ID " );


	if ( $this_event_users ) {
		?>
		<table id="registered-users" class="wp-list-table widefat">
			<thead>
			<tr>
				<th scope="col" class="manage-column "> №</th>
				<th scope="col" class="manage-column column-primary"> <?php _e( 'Ім\'я', 'html5blank' ) ?> </th>
				<th scope="col" class="manage-column "> <?php _e( 'Телефон', 'html5blank' ) ?> </th>
				<th scope="col" class="manage-column "> <?php _e( 'Підтвердження', 'html5blank' ) ?> </th>
				<th scope="col" class="manage-column "></th>
				<th scope="col" class="manage-column "></th>
			</tr>
			</thead>
			<?php
			foreach ( $this_event_users as $key => $event_user ) {
				$is_checked = $event_user->confirm == 1 ? 'checked' : '';
				?>
				<tr class="registered-users-row">
					<td>
						<?php echo $key + 1 ?>
						<input type="hidden" name="event_id" value="<?php echo $event_user->id ?>">
					</td>
					<td><input type="text" name="name" value="<?php echo $event_user->name ?>"></td>
					<td><input type="text" name="phone" value="<?php echo $event_user->phone ?>"></td>
					<td><input type="checkbox" name="confirmation" <?php echo $is_checked ?>></td>
					<td>
						<input type="button"
							   class="event-user-confirm button button-primary button-large"
							   value="<?php _e( 'Оновити', 'html5blank' ); ?>">
					</td>
					<td>
						<input type="button"
							   class="event-user-delete button button-attention button-large"
							   value="<?php _e( 'Видалити', 'html5blank' ); ?>">
					</td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
	} else {
		_e( 'Ще нікого немає', 'html5blank' );
	}

}


function event_user_confirmation_callback() {
	global $wpdb;
	$table_name     = 'events_user_table';
	$wp_track_table = $wpdb->prefix . "$table_name";

	$data       = $_POST['data'];
	$is_confirm = $data['confirmation'] == 'on' ? 1 : 0;

	$is_updated = $wpdb->update( $wp_track_table,
			[
				'name'    => $data['name'],
				'phone'   => $data['phone'],
				'confirm' => $is_confirm
			],
			[ 'id' => $data['event_id'] ],
			[ '%s', '%s', '%d' ],
			[ '%d' ]
	);

	wp_send_json_success( $is_updated );

}

function event_user_delete_callback() {
	global $wpdb;
	$table_name     = 'events_user_table';
	$wp_track_table = $wpdb->prefix . "$table_name";

	$data       = $_POST['data'];
	$is_deleted = $wpdb->delete( $wp_track_table, [ 'id' => $data['event_id'] ] );

	wp_send_json_success( $is_deleted );

}
