<?php
add_action('admin_menu', 'wpbw_create_config_page');

function wpbw_create_config_page() {
	add_options_page('Bitcoin Wallet Options', 'Bitcoin Wallet', 'manage_options', 'wpbw-config-menu', 'wpbw_config_page');
	add_action('admin_init', 'wpbw_register_settings');
}

function wpbw_config_page() {
	if(!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	?>
	<div class="wrap">
	<h2>Bitcoin Wallet Options</h2>
	<form action="options.php" method="post">
	<?php settings_fields('wpbw_plugin_options'); ?>
	<?php $options = get_option('wpbw_plugin_options'); ?>
	<label>bitcoind RPC Host:</label>
	<input id="bitcoind_rpc_host" name="wpbw_plugin_options[bitcoind_rpc_host]" size="40" type="text" value="<?php echo $options['bitcoind_rpc_host'] ?>" />
	<br />
	<label>bitcoind RPC Port:</label>
	<input id="bitcoind_rpc_port" name="wpbw_plugin_options[bitcoind_rpc_port]" size="40" type="text" value="<?php echo $options['bitcoind_rpc_port'] ?>" />
	<br />
	<label>bitcoind RPC Username:</label>
	<input id="bitcoind_rpc_username" name="wpbw_plugin_options[bitcoind_rpc_username]" size="40" type="text" value="<?php echo $options['bitcoind_rpc_username'] ?>" />
	<br />
	<label>bitcoind RPC Password:</label>
	<input id="bitcoind_rpc_password" name="wpbw_plugin_options[bitcoind_rpc_password]" size="40" type="text" value="<?php echo $options['bitcoind_rpc_password'] ?>" />
	<br />
	<label>bitcoind account prefix:</label>
	<input id="bitcoind_account_prefix" name="wpbw_plugin_options[bitcoind_account_prefix]" size="40" type="text" value="<?php echo $options['bitcoind_account_prefix'] ?>" />
	<br />
	<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
	</div>
	<?php
}

function wpbw_register_settings() {
	register_setting('wpbw_plugin_options', 'wpbw_plugin_options', 'wpbw_plugin_options_validate');
}

function wpbw_plugin_options_validate($input) {
	$newinput['bitcoind_rpc_host'] = trim($input['bitcoind_rpc_host']);
	$newinput['bitcoind_rpc_port'] = trim($input['bitcoind_rpc_port']);
	$newinput['bitcoind_rpc_username'] = trim($input['bitcoind_rpc_username']);
	$newinput['bitcoind_rpc_password'] = trim($input['bitcoind_rpc_password']);
	$newinput['bitcoind_account_prefix'] = trim($input['bitcoind_account_prefix']);

	//TODO: Actually validate the input.

	return $newinput;
}

?>
