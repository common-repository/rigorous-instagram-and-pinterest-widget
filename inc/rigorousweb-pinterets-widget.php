<?php
/**
 *  Widget for Pinterest
 *
 */
class Rigorous_Instagram_Pinterest_Widget_Pinterest extends WP_Widget {
	/**
	* Declares the Rigorous_Instagram_Pinterest_Widget_Pinterest class.
	*
	*/	

	public function __construct() {

		global $control_ops;

		$widget_ops = array(						
			'classname' 	=> 'rigorous-instagram-pinterest-feed', 
			'description' 	=> __( 'A widget that displays your Pinterest.', 'rigorous-instagram-pinterest-feed') 
			);

		parent::__construct('Rigorous_Instagram_Pinterest_Widget_Pinterest', __('Rigorous Web: Pinterest Widget', 'rigorous-instagram-pinterest-feed'), $widget_ops, $control_ops);

		$this->alt_option_name = 'widget_blif';		
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;			
		$instance['title'] = strip_tags( stripslashes( $new_instance['title'] ) );
		$instance['label_text'] = strip_tags( stripslashes( $new_instance['label_text'] ) );
		$instance['pinterest_username'] = strip_tags( stripslashes( $new_instance['pinterest_username'] ) );
		$instance['pinterest_quantity'] = strip_tags( stripslashes( $new_instance['pinterest_quantity'] ) );
		$instance['pinterest_width'] = $new_instance['pinterest_width'];
		

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, array( 'title'=>__('Find Us in Pinterest ','rigorous-instagram-pinterest-feed'),'label_text'=>__('Pinterest Activity','rigorous-instagram-pinterest-feed'), 'pinterest_username'=>__('thisismyurl','rigorous-instagram-pinterest-feed'), 'pinterest_quantity'=>'8','pinterest_width'=>__('sidebar','rigorous-instagram-pinterest-feed') ) );

		$title = htmlspecialchars( $instance['title'] );
		$label_text = htmlspecialchars( $instance['label_text'] );
		$pinterest_username = ( $instance['pinterest_username'] );
		$pinterest_quantity = ( $instance['pinterest_quantity'] );
		$pinterest_width = strip_tags( $instance['pinterest_width'] );

		echo '<p style="text-align:left;"><label for="' . esc_attr($this->get_field_name( 'title' )) . '">' . esc_html__( 'Title:','rigorous-instagram-pinterest-feed' ) . '</label><br />
		<input style="width: 280px;" id="' . esc_attr($this->get_field_id( 'title' ) ). '" name="' . esc_attr($this->get_field_name( 'title' )) . '" type="text" value="' . esc_attr($title) . '" /></p>';

		echo '<p style="text-align:left;"><label for="' . esc_attr($this->get_field_name( 'label_text' )) . '">' .  esc_html__( 'Label Title:','rigorous-instagram-pinterest-feed' ) . '</label><br />
		<input style="width: 280px;" id="' . esc_attr($this->get_field_id( 'label_text' )) . '" name="' . esc_attr($this->get_field_name( 'label_text' )) . '" type="text" value="' . esc_attr($label_text) . '" /></p>';

		echo '<p style="text-align:left;"><label for="' . esc_attr($this->get_field_name( 'pinterest_username' )) . '">' . __( 'Pinterest Username:','rigorous-instagram-pinterest-feed' ) . '</label><br />
		<input style="width: 280px;" id="' . esc_attr($this->get_field_id( 'pinterest_username' )) . '" name="' . esc_attr($this->get_field_name( 'pinterest_username' )) . '" type="text" value="' . esc_attr($pinterest_username) . '" /></p>';

		echo '<p style="text-align:left;"><label for="' . esc_attr($this->get_field_name( 'pinterest_quantity' )) . '">' . esc_html__( 'Number of Images:','rigorous-instagram-pinterest-feed' ) . '</label><br />
		<input style="width: 280px;" id="' . esc_attr($this->get_field_id( 'pinterest_quantity' )) . '" name="' . esc_attr($this->get_field_name( 'pinterest_quantity' )) . '" type="text" value="' . esc_attr($pinterest_quantity) . '" /></p>'; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'pinterest_width' ); ?>"><?php _e( 'Widget Position:', 'rigorous-instagram-pinterest-feed' ); ?></label><br />
			<select name="<?php echo $this->get_field_name( 'pinterest_width' ); ?>" id="<?php echo $this->get_field_id( 'pinterest_width' ); ?>">
				<option value="full_page" <?php selected( $instance['pinterest_width'], 'full_page' ); ?>><?php _e( 'Full Page', 'rigorous-instagram-pinterest-feed' ); ?></option>
				<option value="sidebar" <?php selected( $instance['pinterest_width'], 'sidebar' ); ?>><?php _e( 'Sidebar', 'rigorous-instagram-pinterest-feed' ); ?></option>
				
			</select>
		</p>

		<?php }

		function widget( $args, $instance ) {

			extract( $args );
			$pinterest_logo = plugins_url('images/pinterest.png', __FILE__);					
			$pinterest_width 		= !empty($instance['pinterest_width']) ? $instance['pinterest_width'] : 'sidebar';			
			
			$instance = wp_parse_args( ( array ) $instance, array( 'title'=>esc_html__('Find Us in Pinterest ','rigorous-instagram-pinterest-feed'),'label_text'=>esc_html__('Pinterest Activity','rigorous-instagram-pinterest-feed'), 'pinterest_username'=>esc_html__('thisismyurl','rigorous-instagram-pinterest-feed'), 'pinterest_quantity'=>'8') );

			$pinterest_feed = fetch_feed( "http://pinterest.com/" . esc_attr($instance['pinterest_username']) . "/feed.rss" );

			if (!is_wp_error( $pinterest_feed ) ) :
				$maxitems = $pinterest_feed->get_item_quantity( $instance['pinterest_quantity'] );
			$pinterest_feed = $pinterest_feed->get_items(0, $maxitems);
			endif;

			if($pinterest_width=='sidebar'){
				$pinterest_class='rws-pinterest-siderbar';
			} else{
				$pinterest_class='rws-pinterest-fullwidth';
			}

			if ( !empty( $pinterest_feed ) ) {

				echo $before_widget; 	

				echo '<div class="'.$pinterest_class.'">';			

				if (!empty( $instance['title'] )):     	

					echo '<div class="rws-container">';	

				echo $args['before_title'] . esc_html($instance['title']). $args['after_title'];

				echo '</div>';

				endif;


				echo '<div class="content"><div class="textwidget">';

				echo '<div class="pinterest-image-wrapper">';

				echo '<div class="container pinterest-title">';

				echo '<h3 class="pinterest-feed-title v-center"><a href="http://pinterest.com/' . esc_html($instance['pinterest_username']). '"
				target="_blank"><img src="'.esc_url($pinterest_logo).'"></i>' . esc_html($instance['label_text']).'</a></h3>';

				echo '</div>';


				if ( ! is_wp_error( $pinterest_feed ) ) {

					echo '<ul class="thumbnails">';


					$secure = '';

					if ( ! empty( $_SERVER['HTTPS'] ) )
						$secure = 's';

					foreach ( $pinterest_feed as $item ) {

						if ( ! empty( $item ) ) {
							$pinterest_content = $item->get_content();
							$pinterest_content = str_replace( '&gt;','>',$pinterest_content );	
							$pinterest_content = str_replace( '&lt;','<',$pinterest_content );
							$pinterest_content = str_replace( '<a','<a target="_blank"',$pinterest_content );
							$pinterest_content = str_replace( 'href="','href="http' . $secure . '://www.pinterest.com', $pinterest_content );

							$pinterest_content = strip_tags( $pinterest_content, "<a>,<img>" );
							$pinterest_content_array = explode( '</a>', $pinterest_content );						
							$pinterest_content = $pinterest_content_array[0];
							?><li><a href='<?php echo esc_url( $item->get_permalink() ); ?>'
							title='<?php echo esc_html__('Posted ', 'rigorous-instagram-pinterest-feed').$item->get_date('j F Y | g:i a'); ?>'><?php echo $pinterest_content;?></a></li><?php
						}
					}

					echo "</ul>";
				} else {
					esc_html__('Error loading Pinterest feed, likely an invalid character in the feed source.','rigorous-instagram-pinterest-feed');
				}
				echo '</div>';
				echo '</div></div>';
				echo '</div>';

				echo $after_widget;
			}
		}

	}

/**
* Register  widget.
*
* Calls 'widgets_init' action after widget has been registered.
*/
function rigorous_instagram_pinterest_widget_pinterest_init() {

	register_widget('Rigorous_Instagram_Pinterest_Widget_Pinterest');

}	

add_action('widgets_init', 'rigorous_instagram_pinterest_widget_pinterest_init');