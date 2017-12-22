<?php
/*
 * 管理画面関連
 */
define( 'LFMUTILS_HOOK_SUFFIX', 'settings_page_plugin_lfmutils_options' );

/*
 * 設定メニューに追加
 */
function add_menu_lfmutils_setting() {
	add_options_page(
		__( 'Last.fm Utilities Setting', 'lastfm-utils' ),
		__( 'Last.fm Utilities Setting', 'lastfm-utils' ),
		'manage_options',
		'plugin_lfmutils_options',
		'create_lfmutils_options' );
	add_action( 'admin_init', 'register_lfmutils_settings' );
}
function register_lfmutils_settings() {
	register_setting( 'lfmutils_settings_group', 'lfmutils_apikey' );
	register_setting( 'lfmutils_settings_group', 'lfmutils_username' );
	register_setting( 'lfmutils_settings_group', 'lfmutils_cache_expire' );
	register_setting( 'lfmutils_settings_group', 'lfmutils_color' );
}
function create_lfmutils_options() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	require_once LFMUTILS_DIR_PATH . 'parts/admin-lfmutils.php';
}

/*
 * 管理画面のみ必要なstyle読み込み
 */
function lfmutils_admin_print_style() {
	wp_enqueue_style( 'lfmutils_admin_style',
		LFMUTILS_DIR_URL . 'css/admin-style.css',
		array(), get_lfmutils_version(), 'all' );
	wp_enqueue_style( 'lfmutils_icomoon_style',
		LFMUTILS_DIR_URL . 'css/icomoon.css',
		array(), get_lfmutils_version(), 'all' );
}

/*
 * 管理画面のみ必要なJS読み込み
 */
function lfmutils_admin_enqueue_script( $hook_suffix ) {
	if ( $hook_suffix == LFMUTILS_HOOK_SUFFIX ) {
		wp_enqueue_script( 'lfmutils_admin_script',
			LFMUTILS_DIR_URL.'js/admin_script.js',
			array( 'jquery' ), get_lfmutils_version() );
		wp_enqueue_script( 'lfmutils_cache_clear',
			LFMUTILS_DIR_URL.'js/cache_clear.js',
			array( 'jquery' ), get_lfmutils_version() );
		wp_localize_script( 'lfmutils_admin_script',
			'lfmutils_admin_script',
			array(
				'cache_exire_default' => LFMUTILS_CACHE_EXPIRE_DEFAULT,
				'api_key_default' => LFMUTILS_APIKEY_DEFAULT
			) );
		wp_enqueue_script( 'lfmutils_shortcode_generate',
			LFMUTILS_DIR_URL.'js/shortcode_generate.js',
			array( 'jquery' ), get_lfmutils_version() );
		wp_localize_script( 'lfmutils_shortcode_generate',
			'lfmutils_shortcode_generate',
			array(
				'errormsg_input_id' => __( 'Please enter ID.', 'lastfm-utils' ),
				'info_msg' => __( 'Please use the following shortcode.', 'lastfm-utils' )
			) );
	}
}

?>
