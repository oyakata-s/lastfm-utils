/*
 * キャッシュクリア用スクリプト
 */

jQuery(document).ready(function($) {
	/*
	 * キャッシュクリアボタン
	 */
	$('#cache_clear').click(function() {
		cache_clear();

		return false;
	});

	/*
	 * キャッシュクリア実行
	 */
	function cache_clear() {
		var query = 'action=lfmutils_cacheclear';

		$.post(ajaxurl, query, function(data) {
			console.log(data);
			if (data.result === 'success') {
				alert('Cache cleared successfully.');
			} else {
				alert('Clear cache failed.');
			}
		});
	}
});
