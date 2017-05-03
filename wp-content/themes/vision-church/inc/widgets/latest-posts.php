<?php include_once str_replace("\\","/",get_template_directory()).'/inc/init.php';
class Vision_Church_LatestPosts extends WP_Widget{
	function __construct(){
		$params = array('description'=> 'Display Latest Posts','name'=> 'Webnus-Latest Posts');
		parent::__construct('Vision_Church_LatestPosts', '', $params);
	}
	public function form($instance){
		extract($instance);?>
		<p><label for="<?php echo esc_attr( $this->get_field_id('title') ) ?>"><?php esc_html_e('Title:','vision-church') ?></label><input	type="text"	class="widefat"	id="<?php echo esc_attr( $this->get_field_id('title') ) ?>"	name="<?php echo esc_attr( $this->get_field_name('title') ) ?>"	value="<?php if( isset($title) )  echo esc_attr($title); ?>" /></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id('numberOfPosts') ) ?>"><?php esc_html_e('Number of Posts:','vision-church') ?></label><input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('numberOfPosts') ) ?>" name="<?php echo esc_attr( $this->get_field_name('numberOfPosts') ) ?>" value="<?php if( isset($numberOfPosts) )  echo esc_attr($numberOfPosts); ?>" /></p>
		<?php 
	}
	public function widget($args, $instance){
		extract($args);
		extract($instance);
		if(!isset($title)) $title='';
		if(!isset($numberOfPosts)) $numberOfPosts=5;
		echo '' . $before_widget;
		if(!empty($title))
			echo '' . $before_title.esc_html($title).$after_title; 
		?>
		<div class="side-list"><ul>
		<?php
		$wpbp = new WP_Query(array( 'post_type' => 'post', 'paged'=>1, 'posts_per_page'=>$numberOfPosts, 'order' => 'DESC'));
		$temp_out = "";
		if ($wpbp->have_posts()) : while ($wpbp->have_posts()) : $wpbp->the_post();
		?>
		  <li>
		  <?php get_the_image( array( 'meta_key' => array( 'Full', 'Full' ), 'size' => 'vision_church_tabs_img' ) );  ?>
		  <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
		  <p><?php the_time(get_option( 'date_format' )) ?></p>
		  </li>
		<?php
		endwhile; endif;
		wp_reset_postdata();
		?>
        </ul></div>	 
		<?php echo '' . $after_widget;
	} 
}
add_action('widgets_init', 'register_vision_church_LatestPosts');
function register_vision_church_LatestPosts(){
	register_widget('Vision_Church_LatestPosts');	
}