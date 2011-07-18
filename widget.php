<?php
class WPBW_Widget {
	private $bitcoind;
	private $account;

	public function register() {
		require_once('jsonRPCClient.php');
		$options = get_option('wpbw_plugin_options');
		$user = $options['bitcoind_rpc_username'];
		$pass = $options['bitcoind_rpc_password'];
		$host = $options['bitcoind_rpc_host'];
		$port = $options['bitcoind_rpc_port'];
		$wp_user = wp_get_current_user();

		if($wp_user != 0) {
			$this->account = $options['bitcoind_account_prefix'].hash("sha256", $wp_user->user_login);
			$this->bitcoind = new jsonRPCClient('http://'.$user.':'.$pass.'@'.$host.':'.$port.'/');

			wp_add_dashboard_widget('wpbw_widget', 'Bitcoin Wallet', array($this, 'display'));
		} else {
			// We shouldn't ever get here, since only logged-in users can access the dashboard.
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
	}

	public function display() {
		$this->handle_post();

		?>
		<label>Receiving address:</label>
		<pre><?php echo $this->bitcoind->getaccountaddress($this->account); ?></pre>
		</br>
		<label>Balance:</label>
		<pre><?php echo $this->bitcoind->getbalance($this->account); ?></pre>
		</br>
		</br>
		<strong>Send Coins:</strong>
		<br />
		<br />
		<form action="" method="post">
		<?php wp_nonce_field('wpbw_widget_nonce'); ?>
		<label>Number of coins:</label>
		<input name="wpbw_send_numcoins" type="text" size="10" />
		<br />
		<label>Destination address:</label>
		<input name="wpbw_send_address" type="text" size="40" />
		<br />
		<input name="wpbw_widget_send" type="submit" value="Send" />
		</form>
		<br />
		<br />
		<strong>Last 10 Transactions:</strong>
		<br />
		<br />
		<ul>
		<?php
		$transactions = array_reverse($this->bitcoind->listtransactions($this->account));

		foreach($transactions as $t) {
			?>
			<li><?php echo $t['txid']; ?></li>
			<?php
		}
		?>
		</ul>
		<?php
	}

	public function handle_post() {
		if(isset($_REQUEST['wpbw_widget_send'])) {
			check_admin_referer('wpbw_widget_nonce');
			//TODO: Sanitize inputs!
			$transaction = $this->bitcoind->sendfrom($this->account, $_REQUEST['wpbw_send_address'], (float)$_REQUEST['wpbw_send_numcoins']);
			?>
			<label>Sent, transaction ID is:</label>
			<pre><?php echo $transaction; ?>.</pre>
			<br />
			<br />
			<?php
		}
	}
}

$wpbw_widget = new WPBW_Widget();

add_action('wp_dashboard_setup', array($wpbw_widget, 'register'));

?>
