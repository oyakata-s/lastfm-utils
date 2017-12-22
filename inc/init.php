<?php
/*
 * 初期化関連
 */

/*
 * プラグイン有効化
 */
function lfmutils_activation() {
	// キャッシュディレクトリの準備
	lfmutils_check_dir( LFMUTILS_CACHE_DIR_PATH );
}

/*
 * プラグイン無効化
 */
function lfmutils_deactivation() {
	// キャッシュディレクトリの削除
	lfmutils_remove_dir( LFMUTILS_CACHE_DIR_PATH );
}

/*
 * プラグインロード時
 */
function lfmutils_loaded() {
	// 多言語翻訳用
	load_plugin_textdomain( 'lastfm-utils', false, 'lastfm-utils/languages' );
}

/*
 * headタグにscriptタグを出力
 */
function lfmutils_header_script() {
?>
<script>
var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
</script>
<?php
}

/*
 * スタイル出力
 */
function lfmutils_print_styles() {
	wp_enqueue_style( 'plugin-lastfm-utils',
		LFMUTILS_DIR_URL . 'css/style.css',
		array(),
		get_lfmutils_version(),
		'all' );
	wp_enqueue_style( 'lfmutils_icomoon_style',
		LFMUTILS_DIR_URL . 'css/icomoon.css',
		array(),
		get_lfmutils_version(),
		'all' );
}

/*
 * JS出力
 */
function lfmutils_enqueue_scripts() {
	wp_enqueue_script( 'lastfm_utils_async_getdata',
		LFMUTILS_DIR_URL . 'js/async_getdata.js',
		array( 'jquery' ),
		get_lfmutils_version(),
		false );
	wp_localize_script( 'lastfm_utils_async_getdata',
		'lastfm_utils_async_getdata',
		array(
			'data_error_message' => __( 'Data Error', 'lastfm-utils' ),
			'server_error_message' => __( 'Server Error', 'lastfm-utils' ),
			'default_image' => LFMUTILS_DIR_URL . 'img/noimage.jpg'
		) );
}

/*
 * ディレクトリの存在をチェックする
 * 存在しなかったら作成する
 */
function lfmutils_check_dir( $dir ) {
	if ( ! file_exists( $dir ) ) {
		return wp_mkdir_p( $dir );
	}

	return false;
}

/*
 * 指定したディレクトリが存在したら削除する
 */
function lfmutils_remove_dir( $dir ) {
	if ( file_exists( $dir ) ) {
		if ( WP_Filesystem() ) {
			global $wp_filesystem;
			return $wp_filesystem->delete( $dir, true );
		}
	}

	return false;
}

?>
