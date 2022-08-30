<?php
/**
 * Module for UI.
 */
if (!defined('ABSPATH')) return;

class OpenWordPressSEOUi {
	
	private $content;
	
	public function __construct() {
		$this->content = new OpenWordPressSEOContent();
	}
	
	public function add_post_metaboxes() {
		add_meta_box('open_wp_seo', 
				   '<span class="dashicons dashicons-admin-generic open-wp-seo-animated"></span> Keyword SEO Suggest', 
				   array($this, 'create_metabox_main'), $post_type, 'normal', 'high');
	}

	public function create_metabox_main($post){
		?>
		<div style="display: grid; grid-template-columns: 30% auto;">
			<div class="open-wp-seo-settings" style="border-right: 1px solid #ddd">
			
				<p><strong><?php _e('Keyword', OpenWordPressSEO::TEXT_DOMAIN); ?></strong></p>
				<input type="text" maxlength="60" name="ipt_keyword" id="ipt_keyword" style="widht:90%" /><br>
				
				<p><strong><?php _e('Region', OpenWordPressSEO::TEXT_DOMAIN); ?></strong></p>
				<select name="ipt_region" id="ipt_region" style="max-widht:90%">
					<option value="id">Indonesia</option>
					<option value="us">USA</option>
				</select><br>
				
				<br>
				<button type="button" id="btn_testing">Submit</button>

			</div>

			<div class="open-wp-seo-settings" style="margin-left:35px;">
				<p><strong><?php _e('Keywords Suggestion', OpenWordPressSEO::TEXT_DOMAIN); ?></strong></p>
				<br>
				<div id="txt_suggest"></div>
			</div>
		</div>
		<?php 
	}
}