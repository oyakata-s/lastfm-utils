<?php
/*
 * 設定関連
 */
define( 'LFMUTILS_HOOK_SUFFIX', 'settings_page_plugin_lfmutils_options' );

require_once LFMUTILS_DIR_PATH . 'inc/base/class-ft-setting.php';			// 設定ベースクラス

class LfmUtilsSetting extends  FtSetting {

	/*
	 * 初期化
	 */
	public function __construct() {

		try {
			parent::__construct(
				'lfmutils',
				array(
					'lfmutils_apikey' => LFMUTILS_APIKEY_DEFAULT,
					'lfmutils_username' => null,
					'lfmutils_cache_expire' => LFMUTILS_CACHE_EXPIRE_DEFAULT,
					'lfmutils_color' => 'light'
				) );
		} catch ( Exception $e ) {
			throw $e;
		}

		add_action( 'admin_menu', array( $this, 'addOptionsPage' ) );

		add_action( 'admin_print_styles-'.LFMUTILS_HOOK_SUFFIX, array( $this, 'enqueueStyles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );

	}

	/* 
	 * オプションページ追加
	 */
	public function addOptionsPage() {
		$this->registerOptionsPage(
				__( 'Last.fm Utilities Setting', 'lastfm-utils' ),
				__( 'Last.fm Utilities Setting', 'lastfm-utils' ),
				'manage_options',
				'plugin_lfmutils_options',
				LFMUTILS_DIR_PATH . 'parts/admin-lfmutils.php'
		);
	}

	/* 
	 * css追加
	 */
	public function enqueueStyles() {
		global $lfmutils;
		wp_enqueue_style( 'lfmutils_admin_style',
			LFMUTILS_DIR_URL . 'css/admin-style.min.css',
			array(),
			$lfmutils->getVersion(),
			'all' );
		wp_enqueue_style( 'lfmutils_icomoon_style',
			LFMUTILS_DIR_URL . 'css/icomoon.css',
			array(),
			$lfmutils->getVersion(),
			'all' );
	}

	/* 
	 * js追加
	 */
	public function enqueueScripts( $hook_suffix ) {
		if ( $hook_suffix == LFMUTILS_HOOK_SUFFIX ) {
			global $lfmutils;
			wp_enqueue_script( 'lfmutils_admin_script',
				LFMUTILS_DIR_URL.'js/admin_script.min.js',
				array( 'jquery' ),
				$lfmutils->getVersion() );
			wp_enqueue_script( 'lfmutils_cache_clear',
				LFMUTILS_DIR_URL.'js/cache_clear.min.js',
				array( 'jquery' ),
				$lfmutils->getVersion() );
			wp_localize_script( 'lfmutils_admin_script',
				'lfmutils_admin_script',
				array(
					'cache_exire_default' => LFMUTILS_CACHE_EXPIRE_DEFAULT,
					'api_key_default' => LFMUTILS_APIKEY_DEFAULT
				) );
			wp_enqueue_script( 'lfmutils_shortcode_generate',
				LFMUTILS_DIR_URL.'js/shortcode_generate.min.js',
				array( 'jquery' ),
				$lfmutils->getVersion() );
			wp_localize_script( 'lfmutils_shortcode_generate',
				'lfmutils_shortcode_generate',
				array(
					'errormsg_input_id' => __( 'Please enter ID.', 'lastfm-utils' ),
					'info_msg' => __( 'Please use the following shortcode.', 'lastfm-utils' )
				) );
		}
	}

}

?>
