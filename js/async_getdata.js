/*
 * lastfmからデータを非同期で取得する
 */

function load_lastfmdata(widget_id, type, link_target, limit, period = null) {
	/*
	 * ajax通信
	 */
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
			'action': 'lfmutils_async_getdata',
			'widgetid': widget_id,
			'type': type,
			'limit': limit,
			'period': period
		},
		dataType: 'json'
	})
	.done(function(data) {
		console.log(data);
		if (data.result !== 'success') {
			console.log(data.cause);
			output_error(widget_id, lastfm_utils_async_getdata.data_error_message);
		} else {
			output_html(data, link_target);
		}
	})
	.fail(function() {
		output_error(widget_id, lastfm_utils_async_getdata.server_error_message);
	});
}

/*
 * ローダーを消去
 */
function clear_loader(widgetid) {
	var target = jQuery('#' + widgetid + ' .message');
	target.fadeOut('fast').remove();
}

/*
 * エラー表示
 */
function output_error(widgetid, message) {
	var loader = jQuery('#' + widgetid + ' .message .loader');
	loader.remove();
	var target = jQuery('#' + widgetid + ' .message');
	target.html('<span>' + message + '</span>');
}

/*
 * 取得したJSONデータをHTMLで出力
 */
function output_html(json, link_target) {
	clear_loader(json.widgetid);

	var target = jQuery('#' + json.widgetid + ' .list');
	var type = json.type;

	for (i=0; i<json.data.length; i++) {
		li = create_element(type, json.data[i], link_target);
		target.append(li);
	}
}

/*
 * リストのひとつを生成
 */
function create_element(type, data, link_target) {
	var key;
	switch (type) {
	case 'recenttracks':
	case 'toptracks':
		key = 'track';
		break;
	case 'topalbums':
		key = 'album';
		break;
	case 'topartists':
		key = 'artist';
		break;
	default:
		break;
	}
	var li = jQuery('<li />', {
		'class': key
	});
	var a = jQuery('<a />', {
		'class': 'lfm-link',
		'href': data.url,
	});
	var imgsrc = (data.image !== null) ? data.image : lastfm_utils_async_getdata.default_image;
	var img = jQuery('<img />', {
		'class': key + '-img',
		'src': imgsrc
	})
	var p = jQuery('<p />', {
		'class': key + '-name'
	}).text(data.name);

	a.append(img);
	a.append(p);
	a.attr('target', link_target);

	if (key !== 'topartists') {
		var p_artist = jQuery('<p />', {
			'class': 'artist-name'
		}).text(data.artist_name);
		a.append(p_artist);
	}

	li.append(a);

	return li;
}
