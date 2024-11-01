<?php
/*
Plugin Name: Thumbnail RecentPost 
Plugin URI: http://www.kopkap.in.th
Description: WordPress has a recenpost widget . but Don't have thumbnail recenpost.
Version: 1.0
Author: K'opkap
Author URI: http://www.kopkap.in.th
Text Domain: Thumbnail RecenPost 
*/


function web_scripts_load(){
	wp_register_style( 'style', plugins_url( 'css/style.css', __FILE__ ));
	wp_enqueue_style( 'style' );
}
add_action( 'wp_enqueue_scripts', 'web_scripts_load' );


class thumbnail_recent extends WP_Widget {

	function __construct() {
		parent::__construct(
// ID name of widget 
			'thumbnail_recent', 

// Name of Widget
			__('Thumbnail Recentpost', 'kopkap'), 

// Details of widget
			array( 'description' => __( 'thumbnail recent for who wanna to have', 'kopkap' ), ) 
			);
	}



// input
	public function form( $instance ) {
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" placeholder="Recent Post" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'result' ); ?>"><?php _e('Number Post', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'result' ); ?>" name="<?php echo $this->get_field_name( 'result' ); ?>" value="<?php echo $instance['result']; ?>" placeholder="Recent Post" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'wh' ); ?>"><?php _e('Feature Image size', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'wh' ); ?>" name="<?php echo $this->get_field_name( 'wh' ); ?>" value="<?php echo $instance['wh']; ?>" placeholder="50" style="width:100%;" />
		</p>

		<?php 
	}

	


// output
	public function widget( $args, $instance ) {
		$title = $instance['title'];
		$result = $instance['result'];
		$wh = $instance['wh'];

		echo  $args['before_widget'];
		?>

		
		<?php echo $args['before_title'] . $title . $args['after_title']; ?>
		<ul>
			<?php 
				// the query
			$the_query = new WP_Query( array( 
				'post_status' => 'publish', 
				'post_type' => 'post',
				'posts_per_page' => $result,
				)); ?>

				<?php if ( $the_query->have_posts() ) : ?>
					<!-- the loop -->
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); $n++;?>


						<li>
							<div class="pic">
								<?php if ( has_post_thumbnail() ) {
									the_post_thumbnail(array($wh,$wh));
								} ?>

							</div>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<div class="clear"></div>
						</li>

					<?php endwhile; ?>
				<?php endif; ?>
			</ul>
			<?php

			echo  $args['after_widget'];

		}


		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;


			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['result'] = strip_tags( $new_instance['result'] );
			$instance['wh'] = strip_tags( $new_instance['wh'] );
			return $instance;
		}






	} 
	function thumbnail_recent() {
		register_widget( 'thumbnail_recent' );
	}
	add_action( 'widgets_init', 'thumbnail_recent' );
