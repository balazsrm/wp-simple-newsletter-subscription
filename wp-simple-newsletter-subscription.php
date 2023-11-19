<?php
/**
 * Plugin Name: WP Simple Newsletter Subscription
 * Description: Collects names and emails for newsletter subscriptions and stores them in a custom database table.
 * Version: 1.0
 * Author: Balázs Piller
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class WPSimpleNewsletterSubscription {
	private $db_table;

	public function __construct() {
		global $wpdb;
		$this->db_table = $wpdb->prefix . 'newsletter_subscribers';

		register_activation_hook(__FILE__, [$this, 'install']);
		add_action('admin_menu', [$this, 'add_admin_menu']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('wp_ajax_subscribe', [$this, 'handle_subscription']);
		add_action('wp_ajax_nopriv_subscribe', [$this, 'handle_subscription']);
		add_action('wp_footer', [$this, 'output_subscription_modal']);
	}

	public function install() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $this->db_table (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name tinytext NOT NULL,
			email varchar(50) NOT NULL,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	public function add_admin_menu() {
		add_menu_page('Newsletter Subscribers', 'Subscribers', 'manage_options', 'newsletter-subscribers', [$this, 'admin_page'], 'dashicons-email-alt');
	}

	public function admin_page() {
		require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
		require_once(plugin_dir_path(__FILE__) . 'class-subscribers-list-table.php');

		$subscribersListTable = new Subscribers_List_Table();
		$subscribersListTable->prepare_items();
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline">Newsletter Subscribers</h1>
			<form method="post">
				<?php
				$subscribersListTable->search_box('search', 'search_id');
				$subscribersListTable->display(); 
				?>
			</form>
		</div>
		<?php
	}

	public function enqueue_scripts() {
		wp_enqueue_style('wp-newsletter-modal', plugins_url('style.css', __FILE__));
		wp_enqueue_script('wp-newsletter-modal', plugins_url('script.js', __FILE__), ['jquery'], null, true);
		wp_localize_script('wp-newsletter-modal', 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php')]);
	}

	// Add this function to output the modal HTML in footer
	public function output_subscription_modal() {
		?>
		<div id="newsletter-modal" style="display:none;">
			<form id="newsletter-form">
				<label for="name">Name:</label>
				<input type="text" id="name" name="name" required>

				<label for="email">Email:</label>
				<input type="email" id="email" name="email" required>

				<label>
					<input type="checkbox" name="consent" required> Agree to Terms of Service and Privacy Policy
				</label>

				<input type="submit" value="Subscribe">
			</form>
		</div>
		<?php
		wp_nonce_field('newsletter_nonce', 'newsletter_nonce_field');
	}

	public function handle_subscription() {
		check_ajax_referer('newsletter_nonce', 'nonce');

		// Validate and sanitize input
		$name = sanitize_text_field($_POST['name']);
		$email = sanitize_email($_POST['email']);
		$consent = isset($_POST['consent']) ? 1 : 0;

		if (empty($name) || empty($email)) {
			wp_send_json_error('Name and email are required.');
		}

		if (!is_email($email)) {
			wp_send_json_error('Invalid email address.');
		}

		if (!$consent) {
			wp_send_json_error('You must agree to the Terms of Service and Privacy Policy.');
		}

		// Insert into database
		global $wpdb;
		$wpdb->insert(
			$this->db_table,
			[
				'name' => $name,
				'email' => $email,
				'time' => current_time('mysql')
			]
		);

		wp_send_json_success('Subscribed successfully.');
	}

}

new WPSimpleNewsletterSubscription();
