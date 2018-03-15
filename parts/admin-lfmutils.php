<div class="wrap">
	<h2><?php echo '<i class="fa-lastfm2"></i>&nbsp;'.__( 'Last.fm Utilities Setting', 'lastfm-utils' ); ?></h2>
	<form method="POST" action="options.php">
<?php
		global $lfmutils;
		settings_fields( 'lfmutils_settings_group' );
		do_settings_sections( 'lfmutils_settings_group' );
?>

		<h3><?php _e( 'Setup', 'relatedpages' ); ?></h3>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="lfmutils_apikey"><?php _e( 'API Key', 'lastfm-utils' ); ?></label>
				</th>
				<td><fieldset>
					<input type="text" name="lfmutils_apikey" id="lfmutils_apikey" placeholder="<?php _e( 'Input Last.fm API Key', 'lastfm-utils' ); ?>" value="<?php echo esc_attr( $lfmutils->getOption( 'lfmutils_apikey', '' ) ); ?>">
					<p class="description"><?php _e( 'Please create an API account <a href="https://www.last.fm/api/account/create" target="_blank">here</a> and get the API KEY.(Optical)', 'lastfm-utils' ); ?></p>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="lfmutils_username"><?php _e( 'Username', 'lastfm-utils' ); ?></label>
				</th>
				<td><fieldset>
					<input type="text" name="lfmutils_username" id="lfmutils_username" placeholder="<?php _e( 'Input Last.fm username', 'lastfm-utils' ); ?>" value="<?php echo esc_attr( $lfmutils->getOption( 'lfmutils_username' ) ); ?>">
					<p class="description required"><?php _e( 'Required', 'lastfm-utils' ); ?></p>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="lfmutils_cache_expire"><?php _e( 'Cache Expiration (seconds)', 'lastfm-utils' ); ?></label>
				</th>
				<td><fieldset>
					<input type="number" name="lfmutils_cache_expire" id="lfmutils_cache_expire" placeholder="<?php _e( 'Input Cache enabled seconds', 'lastfm-utils' ); ?>" value="<?php echo esc_attr( $lfmutils->getOption( 'lfmutils_cache_expire' ) ); ?>">
					<p class="description"><?php _e( 'API Key is needed to change the cache expiration.', 'lastfm-utils' ); ?></p>
					<p>
						<input type="button" class="button-primary" name="cache_clear" id="cache_clear" value="<?php _e( 'Cache Clear', 'lastfm-utils' ); ?>" />
					</p>
					</fieldset>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>

	</form>

	<section id="shortcode-generator">

		<h2 class="generator-title"><?php _e( 'Shortcode Generator', 'lastfm-utils' ); ?></h2>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="shortcode-type"><?php _e( 'Type:', 'lastfm-utils' ); ?></label>
				</th>
				<td><fieldset>
					<select id="shortcode-type" name="shortcode-type">
						<option value="recenttracks" selected><?php _e( 'Recent Tracks', 'lastfm-utils' ); ?></option>
						<option value="toptracks"><?php _e( 'Top Tracks', 'lastfm-utils' ); ?></option>
						<option value="topalbums"><?php _e( 'Top Albums', 'lastfm-utils' ); ?></option>
						<option value="topartists"><?php _e( 'Top Artists', 'lastfm-utils' ); ?></option>
					</select>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="shortcode-id"><?php _e( 'ID:', 'lastfm-utils' ); ?></label>
					<p class="description required"><?php _e( 'Required', 'lastfm-utils' ); ?></p>
				</th>
				<td><fieldset>
					<input id="shortcode-id" name="shortcode-id" type="text" value="" />
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="shortcode-title"><?php _e( 'Title:', 'lastfm-utils' ); ?></label>
					<p class="description"><?php _e( 'Optical', 'lastfm-utils' ); ?></p>
				</th>
				<td><fieldset>
					<input id="shortcode-title" name="shortcode-title" type="text" value="" />
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="shortcode-limit"><?php _e( 'Limit:', 'lastfm-utils' ); ?></label>
				</th>
				<td><fieldset>
					<select id="shortcode-limit" name="shortcode-limit">
						<option value="1">1</option>
						<option value="3" selected>3</option>
						<option value="5">5</option>
						<option value="10">10</option>
					</select>
					</fieldset>
				</td>
			</tr>
			<tr class="input-period">
				<th scope="row">
					<label for="shortcode-period"><?php _e( 'Period:', 'lastfm-utils' ); ?></label>
				</th>
				<td><fieldset>
					<select id="shortcode-period" name="shortcode-period">
						<option value="overall" selected><?php _e( 'All time', 'lastfm-utils' ); ?></option>
						<option value="7day"><?php _e( 'Last 7 days', 'lastfm-utils' ); ?></option>
						<option value="1month"><?php _e( 'Last 30 days', 'lastfm-utils' ); ?></option>
						<option value="3month"><?php _e( 'Last 90 days', 'lastfm-utils' ); ?></option>
						<option value="6month"><?php _e( 'Last 180 days', 'lastfm-utils' ); ?></option>
						<option value="12month"><?php _e( 'Last 365 days', 'lastfm-utils' ); ?></option>
					</select>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Color:', 'lastfm-utils' ); ?>
				</th>
				<td><fieldset>
					<input type="radio" id="shortcode-color-light" name="shortcode-color" value="light" checked /><label for="shortcode-color-light"><?php _e( 'Light', 'lastfm-utils' ); ?></label>
					<input type="radio" id="shortcode-color-dark" name="shortcode-color" value="dark" /><label for="shortcode-color-dark"><?php _e( 'Dark', 'lastfm-utils' ); ?></label>&emsp;
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Link Target:', 'lastfm-utils' ); ?>
				</th>
				<td><fieldset>
					<input type="checkbox" id="shortcode-linktarget" name="shortcode-linktarget" value="_blank" />
					<label for="shortcode-linktarget"><?php _e( 'Open a link in a new window', 'lastfm-utils' ); ?></label>&emsp;
					</fieldset>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="button" id="shortcode-generate-btn" class="button-primary" name="shortcode-generate-btn" value="<?php _e( 'Generate', 'lastfm-utils' ); ?>" />
					<p class="message"></p>
					<div id="shortcode-output"></div>
				</td>
			</tr>
		</table>

	</section>

</div>
