<?php
/**
 * @package WP_Bitcoin_Wallet
 * @version 0.1
 */
/*
Plugin Name: WP Bitcoin Wallet
Plugin URI: https://github.com/chrisacheson/wp-bitcoin-wallet
Description: Bitcoin web-wallet plugin for Wordpress.
Author: Chris Acheson
Version: 0.1
Author URI: http://chrisacheson.net/
License: GPLv3 or later
*/

if(is_admin()) {
	require_once dirname(__FILE__).'/admin.php';
	require_once dirname(__FILE__).'/widget.php';
}

?>
