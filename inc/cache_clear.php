<?php
/*
 * キャッシュクリア
 */
require_once LFMUTILS_DIR_PATH . 'inc/utils/utils-cache.php';	// キャッシュ使用

function lfmutils_cacheclear() {
	try {
		$cache = CacheUtils::getInstance( LFMUTILS_CACHE_DIR_PATH );
		$deleted = $cache->clearCache();

		/*
		 * 結果をJSONで返す
		 */
		// header定義
		header( 'Content-Type:application/json;charset=utf-8' );
		echo json_encode( array(
			'result' => 'success',
			'deleted' => $deleted)
		);
	} catch ( Exception $e ) {
		header( 'Content-Type:application/json;charset=utf-8' );
		echo json_encode( array(
			'result' => 'error',
			'cause' => $e->getMessage())
		);
	}

	die();
}

?>
