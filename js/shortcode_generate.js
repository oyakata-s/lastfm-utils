/*
 * ショートコードジェネレータ用スクリプト
 */

jQuery(document).ready(function($) {

	$('#shortcode-generator .input-period').css('display', 'none');
	$('#shortcode-type').change(function() {
		if ($('#shortcode-type').val() === 'recenttracks') {
			$('#shortcode-generator .input-period').css('display', 'none');
		} else {
			$('#shortcode-generator .input-period').css('display', '');
		}
	});

	$('#shortcode-generate-btn').click(function() {
		if ($('#shortcode-id').val() === '') {
			$('#shortcode-generator .message')
				.text(lfmutils_shortcode_generate.errormsg_input_id)
				.removeClass('info').addClass('error');
			return false;
		} else {
			$('#shortcode-generator .message')
				.text('').removeClass('error');
		}
		shortcode_generate();
		return false;
	});

	/*
	 * 生成
	 */
	function shortcode_generate() {
		var type = $('#shortcode-type').val();
		var id = $('#shortcode-id').val();
		var title = $('#shortcode-title').val();
		var limit = $('#shortcode-limit').val();
		var period = $('#shortcode-period').val();
		var color = $('input[name=shortcode-color]:checked').val();
		var linktarget = ($('input[name=shortcode-linktarget]').prop('checked')) ? $('input[name=shortcode-linktarget]').val() : '_self';

		var shortcode = type;
		shortcode += ' id="' + id + '"';
		if (title !== '') {
			shortcode += ' title="' + title + '"';
		}
		shortcode += ' limit="' + limit + '"';
		if (type !== 'recenttracks') {
			shortcode += ' period="' + period + '"';
		}
		shortcode += ' color="' + color + '"';
		shortcode += ' link_target="' + linktarget + '"';

		shortcode = '<code>[' + shortcode + ']</code>';
		$('#shortcode-output').html(shortcode);

		$('#shortcode-generator .message')
			.text(lfmutils_shortcode_generate.info_msg).addClass('info');
	}
});
