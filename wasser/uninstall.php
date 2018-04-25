<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 4/25/2018
 * Time: 3:51 PM
 */


class WS_Uninstall {


	/**
	 * @var
	 */
	/**
	 * @var
	 */
	/**
	 * @var
	 */
	private $i, $j, $k;
	/**
	 * @var string
	 */
	private $sql = '';

	/**
	 * @var array
	 */
	private $meta_keys = [
		'_upsell_active',
		'_upsell_products',
		'_crosssell_active',
		'_crosssell_products',
		'_related_items',
		'_related_active',
		'_rel',
		'_custom_order',
		'_product_order',
		//'__crosssell_ids',
		//'__upsell_ids',
		'_related_products',
		'product_order',
		'product_sort',
	];

	/**
	 * @var array
	 */
	private $option_keys = [
		'related_items_title',
		'show_related',
		'related_total',
		'related_columns',
		'cross_sells',
		'show_crosssells',
		'cross_sell_columns',
		'show_upsells',
		'upsells',
		'upsell_columns',
		'admin_columns',
		'use_minified',
		't',
		'prod_order_set',
		'cross_sell_columns',
		'sort_algorithm',
		'admin_columns',
		'wc_bom_settings',
		'wc_bom_options',
		'wc_rp_settings',
		'wc_rp_options',
		'crp_empty_behavior',
		'wc_rp_empty_behavior',
		'prod_order_set',
		'cols',
		'ad',
		'sit_settings',


	];

	/**
	 * @return int
	 */
	public function delete_postmeta() {

		global $wpdb;
		$this->k   = 0;
		$this->sql = '';

		foreach ( $this->option_keys as $key ) {
			$this->sql .= "DELETE FROM `wp_postmeta` WHERE `meta_key` LIKE \'%' . $key . '%\' ; ";
			$this->k ++;
		}
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $this->sql );

		return $this->k;
	}

	/**
	 * @return int
	 */
	public function delete_options() {

		global $wpdb;
		$this->k   = 0;
		$this->sql = '';

		foreach ( $this->option_keys as $key ) {
			$this->sql .= "DELETE FROM `wp_options` WHERE `option_name` LIKE \'%' . $key . '%\' ; ";
			$this->k ++;
		}
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $this->sql );

		return $this->k;
	}

	/**
	 * @return mixed
	 */
	public function delete_meta_keys() {

		foreach ( $this->meta_keys as $key ) {
			delete_post_meta_by_key( $key );
			$this->i ++;
		}

		return $this->i;
	}

	/**
	 * @return int
	 */
	public function handle_product_sort() {

		$args    = [ 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => - 1 ];
		$posts   = get_posts( $args );
		$this->i = 0;
		foreach ( $posts as $post ) {
			$prod = wc_get_product( $post->ID );

			foreach ( $this->meta_keys as $key ) {
				delete_post_meta( $prod->ID, $key );
				$this->i ++;
			}
		}

		return $this->i;
	}

}



