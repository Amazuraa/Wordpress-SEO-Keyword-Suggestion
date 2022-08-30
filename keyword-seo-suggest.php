<?php
/*
Plugin Name: Keyword SEO Suggest
Description: Keyword SEO Suggest.
Version: 1.0.1
Author: Lorem Ipsum Dolor sit Amet
Text Domain: keyword-seo-suggest
License: GPL3
*/

/**
 * Keyword SEO Suggest
 * Keyword SEO Suggest.
 *
 * @version 1.0.1
 */

if (!defined('ABSPATH')) return;

require_once(__DIR__.'/modules/seo-ui.php');
require_once(__DIR__.'/modules/seo-content.php');

add_action('init', array(OpenWordPressSEO::get_instance(), 'initialize'));
add_action('admin_notices', array(OpenWordPressSEO::get_instance(), 'plugin_activation_notice'));
add_action('plugins_loaded', array(OpenWordPressSEO::get_instance(), 'load_textdomain'));
register_activation_hook(__FILE__, array(OpenWordPressSEO::get_instance(), 'setup_plugin_on_activation')); 

/**
 * Main class of the plugin.
 */
class OpenWordPressSEO {
	
	const PLUGIN_NAME = "Keyword SEO Suggest";
	const VERSION = '1.0.1';
	const OPTION_ON = 'on';
	const OPTION_OFF = 'off';
	const STATUS_OK = 'ok';
	const STATUS_ERROR = 'error';
	const TEXT_DOMAIN = 'open-wp-seo';
	
	private static $instance;
	private static $ui;
	
	private function __construct() {}
		
	public static function get_instance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
			self::$ui = new OpenWordPressSEOUi();
		}
		return self::$instance;
	}
	
	public function initialize() {
		load_plugin_textdomain(self::TEXT_DOMAIN, FALSE, basename(dirname( __FILE__ )) . '/languages');
		
		add_action('admin_enqueue_scripts', array($this, 'add_admin_style'));
		add_action('admin_enqueue_scripts', array($this, 'add_admin_javascript'));
		add_action('admin_menu', array($this, 'post_page_init'));
	}
	
	public function post_page_init(){
		add_action('add_meta_boxes', array(self::$ui,'add_post_metaboxes'));
	}

	public function save_post_meta_fields($post_id){
		if (isset($_POST['open_wp_seo_title'])){
			update_post_meta($post_id, 'open_wp_seo_title', sanitize_text_field($_POST['open_wp_seo_title']));
		}
		
		if (isset($_POST['open_wp_seo_description'])){
			update_post_meta($post_id, 'open_wp_seo_description', sanitize_text_field($_POST['open_wp_seo_description']));
		}
	}
	
	public function add_admin_style() {
		wp_register_style('open_wp_seo_admin_style', plugin_dir_url(__FILE__) . 'css/admin.css');
		wp_enqueue_style('open_wp_seo_admin_style');
	}
	
	public function add_admin_javascript() {
		wp_enqueue_script('open_wp_seo_admin_js', plugin_dir_url(__FILE__) . 'js/admin.js');		
	}	
	
	public function plugin_activation_notice() {
		if (get_transient('open_wp_seo_activation_notice')) {
			$settings_url = $settings_url = get_admin_url() . OpenWordPressSEO::ADMIN_SETTINGS_URL;
			echo '<div class="notice updated"><p><strong>'.sprintf(__('Open WordPress SEO activated. Please configure it at <a href="%s">settings page</a>.', self::TEXT_DOMAIN), $settings_url).'</strong></p></div>';	
		}		
	}
	
	public function load_textdomain() {
		load_plugin_textdomain(self::TEXT_DOMAIN, FALSE, dirname(plugin_basename(__FILE__)) . '/lang/');
	}
	
	public function remove_type_attribute($tag) {
		return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
	}
}