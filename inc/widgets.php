<?php
/*
 * ウィジェット関連
 */

/*
 * ライブラリ読込
 */
require_once LFMUTILS_DIR_PATH . 'inc/widget/widget-recent-tracks.php';		// Recent Tracks
require_once LFMUTILS_DIR_PATH . 'inc/widget/widget-top-tracks.php';		// Top Tracks
require_once LFMUTILS_DIR_PATH . 'inc/widget/widget-top-albums.php';		// Top Albums
require_once LFMUTILS_DIR_PATH . 'inc/widget/widget-top-artists.php';		// Top Artists

/*
 * ウィジェット登録
 */
function lfmutils_widget_init() {
	// Recent Tracks
	register_widget( 'Widget_Recent_Tracks' );
	// Top Tracks
	register_widget( 'Widget_Top_Tracks' );
	// Top Albums
	register_widget( 'Widget_Top_Albums' );
	// Top Artists
	register_widget( 'Widget_Top_Artists' );
}
add_action( 'widgets_init', 'lfmutils_widget_init' );

?>
