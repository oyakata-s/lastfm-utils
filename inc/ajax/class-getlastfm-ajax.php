<?php
/*
 * 非同期でデータを取得する
 */
require_once LFMUTILS_DIR_PATH . 'inc/utils/class-lastfm-utils.php';	// Lastfm使用
require_once LFMUTILS_DIR_PATH . 'inc/base/class-ft-ajax.php';			// ajax用

if ( ! class_exists( 'GetLastfmRunner' ) ) {
class GetLastfmRunner extends FtAjaxRunner {

	/* 
	 * ajax処理実装
	 */
	protected function run() {
		$widget_id = sanitize_html_class( $_POST['widgetid'] );
		$widget_type = esc_attr( $_POST['type'] );

		global $lfmutils;
		try {
			$lfm = LastfmUtils::getInstance(
				$lfmutils->getOption( 'lfmutils_username' ),
				$lfmutils->getOption( 'lfmutils_apikey' ),
				LFMUTILS_CACHE_DIR_PATH,
				$lfmutils->getOption( 'lfmutils_cache_expire' )
			);

			switch( $widget_type ) {
				case 'recenttracks':
				$result = $lfm->getRecentTracks( absint( $_POST['limit'] ) );

				break;
				case 'toptracks':
				$result = $lfm->getTopTracks( $_POST['period'], absint( $_POST['limit'] ) );

				break;
				case 'topalbums':
				$result = $lfm->getTopAlbums( $_POST['period'], absint( $_POST['limit'] ) );

				break;
				case 'topartists':
				$result = $lfm->getTopArtists( $_POST['period'], absint( $_POST['limit'] ) );

				break;
				default:
				break;
			}
		} catch ( Exception $e ) {
			return array(
				'result' => 'error',
				'cause' => $e->getMessage()
			);
		}


		if ( ! empty( $result ) ) {
			return array(
				'result' => 'success',
				'type' => $widget_type,
				'widgetid' => $widget_id,
				'data' => $result
			);
		} else {
			return array(
				'result' => 'error',
				'cause' => 'Data could not be retrieved.'
			);
		}
	}

}
}

?>
