<?php
/**
 *  Widget for Instagram
 *
 */
class Rigorousweb_Instagram_Widget_Feeds extends WP_Widget {
	/**
	* Declares the Rigorousweb_Instagram_Widget_Feeds class.
	*
	*/	

	public function __construct() {

		global $control_ops;

		$widget_ops = array(						
			'classname' 	=> 'rigorous-instagram-pinterest-feed', 
			'description' 	=> __( 'A widget that displays your latest Instagram photos.', 'rigorous-instagram-pinterest-feed') 
			);

		parent::__construct('Rigorousweb_Instagram_Widget_Feeds', __('Rigorous Web: Instagram Feeds', 'rigorous-instagram-pinterest-feed'), $widget_ops, $control_ops);

		$this->alt_option_name = 'widget_blif';		
	}

	/**
	* Displays the Widget
	*
	*/
	function widget($args, $instance){		

		$title 				= ! empty( $instance['title'] ) ? $instance['title'] : '';		

		$label_text			= ! empty( $instance['label_text'] ) ? $instance['label_text'] : false;

		$access_token		= ! empty( $instance['access_token'] ) ? $instance['access_token'] : false;
		
		$image_num			= ! empty( $instance['image_num'] ) ? $instance['image_num'] : '8';

		$disable_cache 		= ! empty( $instance['disable_cache'] ) ? '1' : '0';

		$enable_full_width 		= ! empty( $instance['enable_full_width'] ) ? '1' : '0';

		
		?>

		<?php if( '1' == $enable_full_width ){
			$insta_class = 'rws-insta-full-width';			
		} else{
			$insta_class = 'rws-insta-half-width';
			
		} ?>

		<?php $instagram_logo =plugins_url( 'images/instagram.png', __FILE__ );?>
		
		
		<div class="<?php echo $insta_class;?>">
			<div class="footer-instagram">
				<?php
				echo $args['before_widget']; 			

				if (!empty( $title )):	

					echo '<div class="rws-container">';			

				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];

				echo '</div>';

				endif;

				echo '<div class="insta-image-wrapper">';

				$rt_feeds 	= rigorousweb_insta_feeds( $access_token, $image_num, $disable_cache ); 

				$count 		= count( $rt_feeds['images'] );							

				if ( ! empty( $label_text ) ) {
					echo '<h3 class="footer-instagram-title s-center">';
					echo '<a href="' . esc_url( 'https://www.instagram.com/' . $rt_feeds['link'] ) . '/" target="_blank"><img src="'.esc_url($instagram_logo).'">' . esc_textarea( $label_text ) . '</a>';
					echo '</h3>';
				}

				echo '<ul class="thumbnails">';
				for ( $i = 0; $i < $count; $i ++ ) {
					if ( $rt_feeds['images'][ $i ] ) {
						echo '<li>';
						echo '<a href="' . esc_url( $rt_feeds['images'][ $i ][1] ) . '" target="_blank" style="background-image: url('.esc_url( $rt_feeds['images'][ $i ][0] ).');"></a>';						
						echo '</li>';
					}
				}
				echo '</ul>';
				echo '</div>';
				echo $args['after_widget']; ?>
			</div>
		</div>		
		<?php
	}	

	/**
	* Creates the edit form for the widget.
	*
	*/
	function form($instance){	

		$instance = wp_parse_args( (array) $instance, 
			array(
				'title'			=> '',
				'label_text'	=> '', 
				'access_token'	=> '', 
				'image_num'		=> '', 
				) 
			);

		$title 			=  isset( $instance['title'] ) ? $instance['title'] : '';

		$label_text		= isset( $instance['label_text'] ) ? $instance['label_text'] : '';

		$access_token 	= isset( $instance['access_token'] ) ? $instance['access_token'] : '';

		$image_num		= isset( $instance['image_num']) ? $instance['image_num'] : '8';

		$disable_cache	= isset( $instance['disable_cache']) ? (bool) $instance['disable_cache'] : 'true';	

		$enable_full_width	= isset( $instance['enable_full_width']) ? (bool) $instance['enable_full_width'] : 'true';	




		# Output the options ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_name('title') ); ?>">
				<?php esc_html_e('Title:', 'rigorous-instagram-pinterest-feed'); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />		
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name('label_text') ); ?>">
				<?php esc_html_e('Label text:', 'rigorous-instagram-pinterest-feed'); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('label_text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('label_text') ); ?>" type="text" value="<?php echo esc_attr( $label_text ); ?>" />		
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name('access_token') ); ?>">
				<?php esc_html_e('Access Token:', 'rigorous-instagram-pinterest-feed'); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('access_token') ); ?>" name="<?php echo esc_attr( $this->get_field_name('access_token') ); ?>" type="text" value="<?php echo esc_attr($access_token); ?>" />
			<small>
				<?php esc_html_e('You can generate Instagram Access Token online. For ex: ', 'rigorous-instagram-pinterest-feed'); ?>	
				<a href="<?php echo esc_url('http://instagram.pixelunion.net/'); ?>" target="_blank"><?php esc_html_e('Click Here', 'rigorous-instagram-pinterest-feed'); ?></a>			
			</small>

		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name('image_num') ); ?>">
				<?php esc_html_e('Number of Image: ', 'rigorous-instagram-pinterest-feed'); ?>
			</label>
			<input class="small-text" id="<?php echo esc_attr( $this->get_field_id('image_num') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image_num') ); ?>" type="number" value="<?php echo absint( $image_num ); ?>" />
		</p>

		<p>			
			<input class="checkbox" type="checkbox" <?php checked( $enable_full_width ); ?> id="<?php echo esc_attr( $this->get_field_id('enable_full_width') ); ?>" name="<?php echo esc_attr( $this->get_field_name('enable_full_width') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_name('enable_full_width') ); ?>">
				<?php esc_html_e('Check for full width', 'rigorous-instagram-pinterest-feed'); ?>
				<br>								
			</label>
		</p>

		<p>			
			<input class="checkbox" type="checkbox" <?php checked( $disable_cache ); ?> id="<?php echo esc_attr( $this->get_field_id('disable_cache') ); ?>" name="<?php echo esc_attr( $this->get_field_name('disable_cache') ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_name('disable_cache') ); ?>">
				<?php esc_html_e('Disable Cache', 'rigorous-instagram-pinterest-feed'); ?>
				<br>
				<small><?php esc_html_e("Note: Work on 'Disable Cache' mode during widget setup. After you complete widget setup then enable cache. If you do not see change in number of image disable cache and save setting.", 'rigorous-instagram-pinterest-feed'); ?></small>					
			</label>
		</p>

		<?php		



	} //end of form

	/**
	* Saves the widgets settings.
	*
	*/
	function update($new_instance, $old_instance){

		$instance 					= $old_instance;

		$instance['title'] 			= strip_tags(stripslashes($new_instance['title']));

		$instance['label_text'] 	= $new_instance['label_text'];

		$instance['access_token'] 	= $new_instance['access_token'];

		$instance['image_num'] 		= $new_instance['image_num'];

		$instance['disable_cache'] 	= $new_instance['disable_cache'];

		$instance['enable_full_width'] 	= $new_instance['enable_full_width'];

		return $instance;
	}

}// END class

/**
* Register  widget.
*
* Calls 'widgets_init' action after widget has been registered.
*/
function Rigorousweb_Instagram_Widget_Feeds_init() {

	register_widget('Rigorousweb_Instagram_Widget_Feeds');

}	

add_action('widgets_init', 'Rigorousweb_Instagram_Widget_Feeds_init');
