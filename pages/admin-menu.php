<?php
add_action( 'admin_menu', 'rjrapi_disable_menu' );
	function restapi_admin_page(){
	?>
<div class="wrap">
<h2>Disable Wordpress Default Rest API Endpoints</h2>
<form method="post" action="options.php">
				<?php
					settings_fields( 'disable_rest_settings' );
					do_settings_sections( 'disable_rest' );
					submit_button();
				?>
</form>
<?php	
}
	
function rjrapi_disable_menu() {
 add_menu_page('Rest View', 'Disable Rest Api', 'manage_options', 'restapi-admin-page.php', 'restapi_admin_page', 'dashicons-table-row-delete', 6  );
}
add_action( 'admin_init',  'rjrapi_settings_fields' );
function rjrapi_settings_fields(){
	$page_slug = 'disable_rest';
	$option_group = 'disable_rest_settings';
	add_settings_section(
		'disable_checkbox_id',
		'',
		'',
		$page_slug
	);
	register_setting( $option_group, 'disable_all', 'rjrapi_sanitize_checkbox' );
	register_setting( $option_group, 'endpoints_list');
	add_settings_field(
		'disable_all',
		'Disable All Json Rest Api',
		'rjrapi_disable_all_checkbox',
		$page_slug,
		'disable_checkbox_id'
	);
	add_settings_field(
		'num_of_api',
		'End points',
		'rjrapi_list_of_endpoints',
		$page_slug,
		'disable_checkbox_id',
		array(
			'label_for' => 'endpoints_list',
			'class' => 'hello',
			'name' => 'endpoints_list'
		)
	);

}
function rjrapi_list_of_endpoints( $args ){
	?>
<textarea name="endpoints_list" type="text" id="content" 
cols="50" rows="6" class="regular-text"><?php form_option('endpoints_list'); ?></textarea>
<?php	
}
function rjrapi_disable_all_checkbox( $args ) {
	$value = get_option( 'disable_all' );
	?>
		<label>
			<input type="checkbox" name="disable_all" <?php  esc_attr(checked( $value, 'yes' )); ?> /> Yes
		</label>
	<?php
}
function rjrapi_sanitize_checkbox( $value ) {
	return 'on' === $value ? 'yes' : 'no';
}
