<?php
if (!class_exists('WP_List_Table')) {
	require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Subscribers_List_Table extends WP_List_Table {

	public function prepare_items() {
		$columns = $this->get_columns();
		$hidden = [];
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = [$columns, $hidden, $sortable];

		// Fetch data from database
		global $wpdb;
		$table_name = $wpdb->prefix . 'newsletter_subscribers';
		$this->items = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
	}

	public function get_columns() {
		return [
			'id' => 'ID',
			'name' => 'Name',
			'email' => 'Email',
			'time' => 'Time Subscribed'
		];
	}

	public function column_default($item, $column_name) {
		return esc_html($item[$column_name]);
	}

}
