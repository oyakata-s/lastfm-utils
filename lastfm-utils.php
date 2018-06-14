<?php
/*
 * Plugin Name: Last.fm Utilities
 * Plugin URI: https://github.com/oyakata-s/lastfm-utils
 * Description: Last.fm Widget, Shortcode, etc
 * Version: 0.2.2
 * Author: oyakata-s
 * Author URI: https://something-25.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lastfm-utils
 */

/*
 * 定数定義
 */
define( 'LFMUTILS_FILE', __FILE__ );								// プラグインファイルへのパス
define( 'LFMUTILS_DIR_PATH', plugin_dir_path( __FILE__ ) );			// プラグインディレクトリへのパス
define( 'LFMUTILS_DIR_URL', plugin_dir_url( __FILE__ ) );			// プラグインディレクトリへのURL
define( 'LFMUTILS_TEXTDOMAIN', 'lastfm-utils' );					// テキストドメイン

define( 'LFMUTILS_CACHE_DIR_PATH', LFMUTILS_DIR_PATH.'cache/' );	// キャッシュ用ディレクトリパス
define( 'LFMUTILS_CACHE_EXPIRE_DEFAULT', 86400 );					// キャッシュ有効期間規定値
define( 'LFMUTILS_APIKEY_DEFAULT', '1bab269306fdc9fdd43df4649a99a109' );	// APIKEY規定値

/*
 * ライブラリ読込
 */
require_once ABSPATH . 'wp-admin/includes/file.php';		// WP_Filesystem使用
require_once LFMUTILS_DIR_PATH . 'inc/setting.php';			// 設定関連
require_once LFMUTILS_DIR_PATH . 'inc/widgets.php';			// ウィジェット用
require_once LFMUTILS_DIR_PATH . 'inc/shortcodes.php';		// ショートコード用

require_once LFMUTILS_DIR_PATH . 'inc/ajax/class-getlastfm-ajax.php';	// 非同期データ取得用
require_once LFMUTILS_DIR_PATH . 'inc/ajax/class-cacheclear-ajax.php';	// キャッシュクリア用

require_once LFMUTILS_DIR_PATH . 'inc/base/class-ft-base.php';			// 初期化関連
require_once LFMUTILS_DIR_PATH . 'inc/base/class-ft-utils.php';			// ユーティリティ関連

class LfmUtils extends  FtBase {

	/*
	 * 初期化
	 */
	public function __construct() {
		
		/*
		 * ベースクラスのコンストラクタ呼び出し
		 */
		try {
			parent::__construct( LFMUTILS_FILE );
		} catch ( Exception $e ) {
			throw $e;
		}

		// 多言語翻訳用
		load_plugin_textdomain( 'lastfm-utils', false, 'lastfm-utils/languages' );

		// 設定
		$this->setting = new LfmUtilsSetting();

		register_activation_hook( LFMUTILS_FILE, array( $this, 'activation' ) );		
		register_deactivation_hook( LFMUTILS_FILE, array( $this, 'deactivation' ) );

		add_action( 'wp_head', array( $this, 'addHead' ) );
		add_action( 'wp_print_styles', array( $this, 'enqueueStyles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
	}

	/* 
	 * プラグイン有効化
	 */
	public function activation() {
		// キャッシュディレクトリの準備
		FtUtils::checkDirectory( LFMUTILS_CACHE_DIR_PATH );
	}

	/* 
	 * プラグイン無効化
	 */
	public function deactivation() {
		// キャッシュディレクトリの削除
		FtUtils::removeDirectory( LFMUTILS_CACHE_DIR_PATH );
	}

	/* 
	 * head追加
	 */
	public function addHead() {
		echo '<script>';
		echo 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";';
		echo '</script>';
	}

	/* 
	 * style追加
	 */
	public function enqueueStyles() {
		wp_enqueue_style( 'plugin-lastfm-utils',
			LFMUTILS_DIR_URL . 'css/style.min.css',
			array(),
			$this->getVersion(),
			'all' );
		wp_enqueue_style( 'lfmutils_icomoon_style',
			LFMUTILS_DIR_URL . 'css/icomoon.css',
			array(),
			$this->getVersion(),
			'all' );
	}

	/* 
	 * js追加
	 */
	public function enqueueScripts() {
		wp_enqueue_script( 'lastfm_utils_async_getdata',
			LFMUTILS_DIR_URL . 'js/async_getdata.js',
			array( 'jquery' ),
			$this->getVersion(),
			false );
		wp_localize_script( 'lastfm_utils_async_getdata',
			'lastfm_utils_async_getdata',
			array(
				'data_error_message' => __( 'Data Error', 'lastfm-utils' ),
				'server_error_message' => __( 'Server Error', 'lastfm-utils' ),
				'default_image' => LFMUTILS_DIR_URL . 'img/noimage.jpg'
			) );
	}

}

$lfmutils = new LfmUtils();

$getlfm = new GetLastfmRunner( 'lfmutils_getdata', true );
$cachec = new CacheClearRunner( 'lfmutils_cacheclear' );

?>
