<?php
/*
 * Plugin Name: Last.fm Utilities
 * Plugin URI: https://github.com/oyakata-s/lastfm-utils
 * Description: Last.fm Widget, Shortcode, etc
 * Version: 0.1
 * Author: oyakata-s
 * Author URI: https://something-25.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lastfm-utils
 */

/*
 * 定数定義
 */
define( 'LFMUTILS_FILE', __FILE__ );								// プラグインファイル
define( 'LFMUTILS_DIR_PATH', plugin_dir_path( __FILE__ ) );			// プラグインディレクトリへのパス
define( 'LFMUTILS_DIR_URL', plugin_dir_url( __FILE__ ) );			// プラグインディレクトリへのURL
define( 'LFMUTILS_VERSION', get_lfmutils_version() );				// プラグインバージョン
define( 'LFMUTILS_TEXTDOMAIN', 'lastfm-utils' );					// テキストドメイン

define( 'LFMUTILS_CACHE_DIR_PATH', LFMUTILS_DIR_PATH.'cache/' );	// キャッシュ用ディレクトリパス
define( 'LFMUTILS_CACHE_EXPIRE_DEFAULT', 86400 );					// キャッシュ有効期間規定値
define( 'LFMUTILS_APIKEY_DEFAULT', '4740b418630db2fe2b5ea56efb92c3a4' );	// APIKEY規定値

/*
 * ライブラリ読込
 */
require_once ABSPATH . 'wp-admin/includes/file.php';		// WP_Filesystem使用
require_once LFMUTILS_DIR_PATH . 'inc/init.php';			// 初期化関連
require_once LFMUTILS_DIR_PATH . 'inc/admin.php';			// 管理画面
require_once LFMUTILS_DIR_PATH . 'inc/widgets.php';			// ウィジェット用
require_once LFMUTILS_DIR_PATH . 'inc/shortcodes.php';		// ショートコード用
require_once LFMUTILS_DIR_PATH . 'inc/cache_clear.php';		// キャッシュクリア用
require_once LFMUTILS_DIR_PATH . 'inc/async_getdata.php';	// 非同期データ取得用

/*
 * 初期化処理
 */

/*
 * プラグイン有効化時
 */
register_activation_hook( LFMUTILS_FILE, 'lfmutils_activation' );

/*
 * プラグイン無効化時
 */
register_deactivation_hook( LFMUTILS_FILE, 'lfmutils_deactivation' );

/*
 * プラグインロード
 */
add_action( 'plugins_loaded', 'lfmutils_loaded' );

/*
 * CSS&JS出力
 */
add_action( 'wp_head', 'lfmutils_header_script' );
add_action( 'wp_print_styles', 'lfmutils_print_styles' );
add_action( 'wp_enqueue_scripts', 'lfmutils_enqueue_scripts' );

/*
 * ajax処理
 */
add_action( 'wp_ajax_lfmutils_async_getdata', 'lfmutils_async_getdata' );
add_action( 'wp_ajax_nopriv_lfmutils_async_getdata', 'lfmutils_async_getdata' );

/*
 * 管理画面用初期化
 */

/*
 * 設定メニュー追加
 */
add_action( 'admin_menu', 'add_menu_lfmutils_setting' );

/*
 * 管理画面のみCSS&JS出力
 */
add_action( 'admin_print_styles-'.LFMUTILS_HOOK_SUFFIX, 'lfmutils_admin_print_style' );
add_action( 'admin_enqueue_scripts', 'lfmutils_admin_enqueue_script' );

/*
 * 管理画面のみajax処理
 */
add_action( 'wp_ajax_lfmutils_cacheclear', 'lfmutils_cacheclear' );	// キャッシュクリア用


/*
 * プラグインバージョン
 */
function get_lfmutils_version() {
	$data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
	$version = $data['version'];
	if ($version < '1.0') {
		return date( '0.Ymd.Hi' );
	} else {
		return $version;
	}
}

/*
 * オプションを取得
 * ※get_option($key, $default)で$defaultが
 * 　取得できないので仮で
 */
function get_lfmutils_option( $key, $default = false ) {
	$value = get_option( $key );
	if ( $value && ! empty( $value ) ) {
		return $value;
	} else {
		return $default;
	}
}

?>
