<?php
/*
 * ショートコード関連
 */

/*
 * Recent Tracksを出力する
 * [recenttracks]
 */
function shortcode_recenttracks( $atts ) {
	extract( shortcode_atts( array(
		'id' => null,
		'limit' => 3,
		'color' => 'light',
		'link_target' => '_self',
		'title' => __( 'Recent Tracks', 'lastfm-utils' )
	), $atts ) );

	$element =<<< ELEMENT
<div id="{$id}" class="widget-in-post">
	<h3 class="widget-title">{$title}</h3>
	<div class="message {$color}"><div class="loader"></div><span>Loading...</span></div>
	<ul class="list {$color}"></ul>
	<script>jQuery(document).ready(function () {
		load_lastfmdata('{$id}', 'recenttracks', '{$link_target}', '{$limit}');
	});
	</script>
</div>
ELEMENT;

	return $element;
}
add_shortcode( 'recenttracks', 'shortcode_recenttracks' );

/*
 * Top Albumsを出力する
 * [topalbums]
 */
function shortcode_topalbums( $atts ) {
	extract( shortcode_atts( array(
		'id' => null,
		'limit' => 3,
		'period' => 'overall',
		'color' => 'light',
		'link_target' => '_self',
		'title' => __( 'Top Albums', 'lastfm-utils' )
	), $atts) );

	$strPeriod = __( stringfyingPeriod( $period ), 'lastfm-utils' );

	$element =<<< ELEMENT
<div id="{$id}" class="widget-in-post">
	<h3 class="widget-title">{$title}<span class="period">{$strPeriod}</span></h3>
	<div class="message {$color}"><div class="loader"></div><span>Loading...</span></div>
	<ul class="list {$color}"></ul>
	<script>jQuery(document).ready(function () {
		load_lastfmdata('{$id}', 'topalbums', '{$link_target}', '{$limit}', '{$period}');
	});
	</script>
</div>
ELEMENT;

	return $element;
}
add_shortcode( 'topalbums', 'shortcode_topalbums' );

/*
 * Top Tracksを出力する
 * [toptracks]
 */
function shortcode_toptracks( $atts ) {
	extract( shortcode_atts( array(
		'id' => null,
		'limit' => 3,
		'period' => 'overall',
		'color' => 'light',
		'link_target' => '_self',
		'title' => __('Top Tracks', 'lastfm-utils')
	), $atts ) );

	$strPeriod = __( stringfyingPeriod( $period ), 'lastfm-utils' );

	$element =<<< ELEMENT
<div id="{$id}" class="widget-in-post">
	<h3 class="widget-title">{$title}<span class="period">{$strPeriod}</span></h3>
	<div class="message {$color}"><div class="loader"></div><span>Loading...</span></div>
	<ul class="list {$color}"></ul>
	<script>jQuery(document).ready(function () {
		load_lastfmdata('{$id}', 'toptracks', '{$link_target}', '{$limit}', '{$period}');
	});
	</script>
</div>
ELEMENT;

	return $element;
}
add_shortcode( 'toptracks', 'shortcode_toptracks' );

/*
 * Top Artistsを出力する
 * [topartists]
 */
function shortcode_topartists( $atts ) {
	extract( shortcode_atts( array(
		'id' => null,
		'limit' => 3,
		'period' => 'overall',
		'color' => 'light',
		'link_target' => '_self',
		'title' => __('Top Artists', 'lastfm-utils' )
	), $atts ) );

	$strPeriod = __( stringfyingPeriod( $period ), 'lastfm-utils' );

	$element =<<< ELEMENT
<div id="{$id}" class="widget-in-post">
	<h3 class="widget-title">{$title}<span class="period">{$strPeriod}</span></h3>
	<div class="message {$color}"><div class="loader"></div><span>Loading...</span></div>
	<ul class="list {$color}"></ul>
	<script>jQuery(document).ready(function () {
		load_lastfmdata('{$id}', 'topartists', '{$link_target}', '{$limit}', '{$period}');
	});
	</script>
</div>
ELEMENT;

	return $element;
}
add_shortcode( 'topartists', 'shortcode_topartists' );

function stringfyingPeriod( $str ) {
	switch ( $str ) {
		case 'overall':
			return 'All time';
			break;
		case '7day':
			return 'Last 7 days';
			break;
		case '1month':
			return 'Last 30 days';
			break;
		case '3month':
			return 'Last 90 days';
			break;
		case '6month':
			return 'Last 180 days';
			break;
		case '12month':
			return 'Last 365 days';
			break;
	}
}

?>
