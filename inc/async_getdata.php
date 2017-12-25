<?php
/*
 * 非同期でデータを取得する
 */
require_once LFMUTILS_DIR_PATH . 'inc/utils/utils-lastfm.php';	// Lastfm使用

function lfmutils_async_getdata() {

	$widget_id = sanitize_html_class( $_POST['widgetid'] );
	$widget_type = esc_html( $_POST['type'] );

	try {
		$lfm = LastFmUtils::getInstance(
			get_lfmutils_option( 'lfmutils_username', null ),
			get_lfmutils_option( 'lfmutils_apikey', LFMUTILS_APIKEY_DEFAULT ),
			LFMUTILS_CACHE_DIR_PATH,
			get_lfmutils_option( 'lfmutils_cache_expire', LFMUTILS_CACHE_EXPIRE_DEFAULT )
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
		header( 'Content-Type:application/json;charset=utf-8' );
		echo json_encode( array(
			'result' => 'error',
			'cause' => $e->getMessage()
		) );
		die();
	}

	/*
	 * 結果をJSONで返す
	 */
	// header定義
	header( 'Content-Type:application/json;charset=utf-8' );
	if ( empty( $result ) ) {
		echo json_encode( array(
			'result' => 'error',
			'cause' => 'Data could not be retrieved.'
		) );
	} else {
		echo json_encode( array(
			'result' => 'success',
			'type' => $widget_type,
			'widgetid' => $widget_id,
			'data' => $result
		) );
	}

	die();
}

?>
