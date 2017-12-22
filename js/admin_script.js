/*
 * 管理画面用スクリプト
 */

jQuery(document).ready(function($) {

	/*
	 * 表示後チェック
	 */
	reset_cacheexpire();
	reset_submit();

	/*
	 * 入力チェック
	 */
	$('#lfmutils_apikey').change(function() {
		reset_cacheexpire();
	});
	$('#lfmutils_username').change(function() {
		reset_submit();
	});

	/*
	 * usernameが入力されていなかったら
	 * submitできない
	 */
	function reset_submit() {
		if ($('#lfmutils_username').val() === '') {
			$('#submit').prop('disabled', true);
		} else {
			$('#submit').prop('disabled', false);
		}
	}

	/*
	 * API KEYが入力されていなかったら
	 * キャッシュ期間を変更できない
	 */
	function reset_cacheexpire() {
		if ($('#lfmutils_apikey').val() === '' || $('#lfmutils_apikey').val() === lfmutils_admin_script.api_key_default) {
			$('#lfmutils_cache_expire').val(lfmutils_admin_script.cache_exire_default).prop('readonly', true);
		} else {
			$('#lfmutils_cache_expire').prop('readonly', false);
		}
	}
});
