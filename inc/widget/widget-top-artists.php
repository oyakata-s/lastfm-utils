<?php
/*
 * Top Artists Widget
 */
class Widget_Top_Artists extends WP_Widget {

	/*
	 * Instantiate
	 */
	function Widget_Top_Artists() {
		$widget_ops = array(
			'description' => __( 'Last.fm Top Artists' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct(
			'topartists',
			__( 'Top Artists', 'lastfm-utils' ),
			$widget_ops );
	}

	/*
	 * widget output
	 */
	function widget( $args, $instance ) {
		$title = empty( $instance['title'] ) ? __( 'Top Artists', 'lastfm-utils' ) : $instance['title'];
		$limit = empty( $instance['limit'] ) ? '3' : $instance['limit'];
		$period = empty( $instance['period'] ) ? '7day' : $instance['period'];
		$color = empty( $instance['color'] ) ? 'dark' : $instance['color'];
		$link_target = isset( $instance['linktarget'] ) ? $instance['linktarget'] : '_self';

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		$this->output_topartists( $this->id, $limit, $period, $color, $link_target );
		echo $args['after_widget'];
	}

	/*
	 * save widget options
	 */
	function update( $new_instance, $old_instance ) {
		if ( ! empty( $new_instance['title'] ) &&
			! filter_var( $new_instance['title'], FILTER_DEFAULT ) ) {
			return false;
		}
		if ( ! filter_var( $new_instance['period'], FILTER_DEFAULT ) ) {
			return false;
		}
		if ( ! filter_var( $new_instance['limit'], FILTER_VALIDATE_INT ) ) {
			return false;
		}
		if ( ! filter_var( $new_instance['color'], FILTER_DEFAULT ) ) {
			return false;
		}
		if ( ! empty( $new_instance['linktarget'] ) &&
			! filter_var( $new_instance['linktarget'], FILTER_DEFAULT ) ) {
			return false;
		}
		return $new_instance;
	}

	/*
	 * output admin widget options form
	 */
	function form( $instance ) {
		$title = $instance['title'];
		$limit = empty( $instance['limit'] ) ? '3' : $instance['limit'];
		$period = empty( $instance['period'] ) ? '7day' : $instance['period'];
		$color = empty( $instance['color'] ) ? 'dark' : $instance['color'];
		$color_id = esc_attr( $this->get_field_id( 'color' ) );
		$link_target = isset( $instance['linktarget'] ) ? $instance['linktarget'] : '_self';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'lastfm-utils' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'period' ) ); ?>"><?php _e( 'Period:', 'lastfm-utils' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'period' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'period' ) ); ?>">
				<option value="overall" <?php echo ( $period === 'overall' ) ? 'selected' : ''; ?>><?php _e( 'All time', 'lastfm-utils' ); ?></option>
				<option value="7day" <?php echo ( $period === '7day' ) ? 'selected' : ''; ?>><?php _e( 'Last 7 days', 'lastfm-utils' ); ?></option>
				<option value="1month" <?php echo ( $period === '1month' ) ? 'selected' : ''; ?>><?php _e( 'Last 30 days', 'lastfm-utils' ); ?></option>
				<option value="3month" <?php echo ( $period === '3month' ) ? 'selected' : ''; ?>><?php _e( 'Last 90 days', 'lastfm-utils' ); ?></option>
				<option value="6month" <?php echo ( $period === '6month' ) ? 'selected' : ''; ?>><?php _e( 'Last 180 days', 'lastfm-utils' ); ?></option>
				<option value="12month" <?php echo ( $period === '12month' ) ? 'selected' : ''; ?>><?php _e( 'Last 365 days', 'lastfm-utils' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', 'lastfm-utils' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>">
				<option value="1" <?php echo ( $limit == '1' ) ? 'selected' : ''; ?>>1</option>
				<option value="3" <?php echo ( $limit == '3' ) ? 'selected' : ''; ?>>3</option>
				<option value="5" <?php echo ( $limit == '5' ) ? 'selected' : ''; ?>>5</option>
				<option value="10" <?php echo ( $limit == '10' ) ? 'selected' : ''; ?>>10</option>
			</select>
		</p>
		<p>
			<?php _e( 'Color:', 'lastfm-utils' ); ?>
			<input type="radio" id="<?php echo $color_id; ?>-light" name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>" value="light" <?php echo ( $color !== 'dark' ) ? 'checked' : ''; ?> /><label for="<?php echo $color_id; ?>-light"><?php _e( 'Light', 'lastfm-utils' ); ?></label>
			<input type="radio" id="<?php echo $color_id; ?>-dark" name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>" value="dark" <?php echo ( $color === 'dark' ) ? 'checked' : ''; ?> /><label for="<?php echo $color_id; ?>-dark"><?php _e( 'Dark', 'lastfm-utils' ); ?></label>&emsp;
		</p>
		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'linktarget' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linktarget' ) ); ?>" value="_blank" <?php checked( ( empty( $link_target ) || $link_target !== '_self' ), 1 ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'linktarget' ) ); ?>"><?php _e( 'Open a link in a new window', 'lastfm-utils' ); ?></label>&emsp;
		</p>
		<?php
	}

	/*
	 * アーティストをリストで出力
	 */
	private function output_topartists( $widget_id, $limit, $period, $color, $link_target ) {
		?>
		<div class="message <?php echo $color; ?>"><div class="loader"></div><span>Loading...</span></div>
		<ul class="list <?php echo $color; ?>"></ul>
		<script>jQuery(document).ready(function () {
			load_lastfmdata('<?php echo $widget_id; ?>', 'topartists', '<?php echo $link_target; ?>', '<?php echo $limit; ?>', '<?php echo $period; ?>');
		});
		</script>
		<?php
	}
}

?>
