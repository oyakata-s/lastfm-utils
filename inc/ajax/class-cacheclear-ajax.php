<?php
/*
 * キャッシュクリア
 */
require_once LFMUTILS_DIR_PATH . 'inc/utils/class-cache-utils.php';	// キャッシュ使用
require_once LFMUTILS_DIR_PATH . 'inc/base/class-ft-ajax.php';			// ajax用

if ( ! class_exists( 'CacheClearRunner' ) ) {
class CacheClearRunner extends FtAjaxRunner {

	protected function run() {
		try {
			$cache = CacheUtils::getInstance( LFMUTILS_CACHE_DIR_PATH );
			$deleted = $cache->clearCache();

			return array(
				'result' => 'success',
				'deleted' => $deleted
			);
		} catch ( Exception $e ) {
			return array(
				'result' => 'error',
				'cause' => $e->getMessage()
			);
		}
	}

}
}

?>
