<?php

/**
 * Plugin Name: Iframe Block for Gutenberg
 * Plugin URI: https://wordpress.org/plugins/wpxero-iframe/
 * Description: Iframe Block for  WordPress Users. You can use this block to embed iframe, video, audio, maps, google map, etc.
 * Version: 1.0.0
 * Author: WPXERO
 * Author URI: https://wpxero.com
 * License: GPLv3
 * Text Domain: wpxero-iframe
 * Domain Path: /languages/
 */

// Stop Direct Access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Blocks Final Class
 */

final class WPXERO_Iframe {
	public function __construct() {

		// define constants
		$this->agm_define_constants();

		// add theme support
		add_action('after_setup_theme', [$this, 'wpxero_iframe_add_theme_support']);
		// block initialization
		add_action('init', [$this, 'wpxero_iframe_blocks_init']);

		// blocks category
		if (version_compare($GLOBALS['wp_version'], '5.7', '<')) {
			add_filter('block_categories', [$this, 'wpxero_iframe_register_block_category'], 10, 2);
		} else {
			add_filter('block_categories_all', [$this, 'wpxero_iframe_register_block_category'], 10, 2);
		}


		// enqueue block assets
		add_action('enqueue_block_assets', [$this, 'wpxero_iframe_external_libraries']);
	}

	/**
	 * Initialize the plugin
	 */

	public static function init() {
		static $instance = false;
		if (!$instance) {
			$instance = new self();
		}
		return $instance;
	}


	/**
	 * Add Theme Support
	 */

	public function wpxero_iframe_add_theme_support() {
		add_theme_support('responsive-embeds');
		add_theme_support('align-wide');
		add_theme_support('editor-styles');
		add_editor_style('build/css/editor.css');
	}

	/**
	 * Define the plugin constants
	 */
	private function agm_define_constants() {
		define('WPXERO_IFRAME_VERSION', '1.1.0');
		define('WPXERO_IFRAME_URL', plugin_dir_url(__FILE__));
		define('WPXERO_IFRAME_INC_URL', WPXERO_IFRAME_URL . 'includes/');
	}

	/**
	 * Blocks Registration
	 */

	public function wpxero_iframe_register_block($name, $options = array()) {
		register_block_type(__DIR__ . '/build/blocks/' . $name, $options);
	}

	/**
	 * Blocks Initialization
	 */
	public function wpxero_iframe_blocks_init() {
		// register single block
		// $this->wpxero_iframe_register_block('gmap');
		$this->wpxero_iframe_register_block('iframe');
	}

	/**
	 * Register Block Category
	 */

	public function wpxero_iframe_register_block_category($categories, $post) {
		return array_merge(
			array(
				array(
					'slug'  => 'wpxero-iframe',
					'title' => __('WPXero Iframe', 'wpxero-iframe'),
				),
			),
			$categories,
		);
	}

	/**
	 * Enqueue Block Assets
	 */
	public function wpxero_iframe_external_libraries() {
		$suffix       = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		// enqueue JS
		wp_enqueue_script('recliner', WPXERO_IFRAME_INC_URL . 'assets/js/recliner.min.js', ['jquery'], WPXERO_IFRAME_VERSION, true);
		wp_enqueue_script('wpxero-iframe', WPXERO_IFRAME_INC_URL . 'assets/js/plugin.js', ['jquery'], time(), true);
	}
}

/**
 * Kickoff
 */

WPXERO_Iframe::init();
