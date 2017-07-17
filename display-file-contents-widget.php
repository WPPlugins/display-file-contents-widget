<?php
/*
Plugin Name: Display File Contents Widget
Plugin URI: http://www.humbug.in/2011/wordpress-plugin-display-file-contents-widget-for-your-sidebar/
Description: Display the Contents of a Text/HTML File etc as a widget
Version: 0.2
Author: Pratik Sinha
Author URI: http://www.humbug.in/
License: GPL2
*/

class Display_File_Contents_Widget extends WP_Widget {
	function Display_File_Contents_Widget() {
		$widget_ops = array('classname' => 'widget_dfc', 'description' => __('Display the Contents of a Text/HTML File') );
		$this->WP_Widget('display-file-contents-widget', __('Display File Contents'), $widget_ops);	
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'filepath' => '' ) );
		$title = strip_tags($instance['title']);		
		$filepath = strip_tags($instance['filepath']);		
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('filepath'); ?>"><?php echo __('File Path'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('filepath'); ?>" name="<?php echo $this->get_field_name('filepath'); ?>" type="text" value="<?php echo attribute_escape($filepath); ?>" /></label></p>
<?php
		// outputs the options form on admin
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['filepath'] = strip_tags($new_instance['filepath']);
		$filepath = empty($instance['filepath']) ? ' ' : $instance['filepath'];
		if(file_exists ( $filepath ))
			return $instance;
		else
			return false;
		// processes widget options to be saved
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		extract($args);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$filepath = empty($instance['filepath']) ? ' ' : $instance['filepath'];
		$contents = file_get_contents($filepath);
		?>
			<?php echo $before_widget; ?>
				<?php if ( $title )
					echo $before_title . $title . $after_title; ?>
						<?php echo $contents; ?>
			<?php echo $after_widget; ?>
		<?php
	}

}
add_action('widgets_init', create_function('', 'return register_widget("Display_File_Contents_Widget");'));

?>
