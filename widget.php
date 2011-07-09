<?php
add_action('wp_dashboard_setup', 'wpbw_create_widget');

function wpbw_create_widget() {
	wp_add_dashboard_widget('wpbw_widget', 'Bitcoin Wallet', 'wpbw_show_widget');
}

function wpbw_show_widget() {
	require_once('jsonRPCClient.php');
	$options = get_option('wpbw_plugin_options');
	$user = $options['bitcoind_rpc_username'];
	$pass = $options['bitcoind_rpc_password'];
	$host = $options['bitcoind_rpc_host'];
	$port = $options['bitcoind_rpc_port'];
	$bitcoind = new jsonRPCClient('http://'.$user.':'.$pass.'@'.$host.':'.$port.'/');
	?>
	<pre><?php print_r($bitcoind->getinfo()); ?></pre>
	<?php
}

?>
