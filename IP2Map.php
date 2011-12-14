<?php
/*
Plugin Name: IP2Map
Plugin URI: http://www.ip2map.com
Description: Shows last 100 visitors location on map.
Version: 1.0
Author: Sei Kan
Author URI: http://www.ip2map.com
*/

add_action("widgets_init", array('IP2Map', 'register'));

class IP2Map {
	function activate(){
		if(!function_exists('register_sidebar_widget')) return;

		$options = array( 'title' => 'IP2Map');

		if(!get_option('IP2Map')){
			add_option('IP2Map' , $options);
		}
		else{
			update_option('IP2Map' , $options);
		}
	}

	function deactivate(){
		delete_option('IP2Map');
	}

	function control(){
		$options = get_option('IP2Map');

		if(!is_array($options)) $options = array('title'=>'IP2Map');

		if( $_POST['ip2map-title']){
			$data['title'] = strip_tags(stripslashes($_POST['ip2map-title']));
			update_option('IP2Map', $data);
		}

		echo '<p style="text-align:right;"><label for="ip2map-title">' . __('Title:') . '</label> <input style="width: 200px;" id="ip2map-title" name="ip2map-title" type="text" value="' . htmlspecialchars($options['title'], ENT_QUOTES) . '" /></p>';
	}

	function widget($args){
		$options = get_option('IP2Map');
		echo $args['before_widget'] . $args['before_title'] . $options['title'] . $args['after_title'];
		echo '<a href="http://www.ip2map.com" target="_blank"><img src="http://www.ip2map.com/ip2map.gif" border="0" width="100" height="50" /></a>';
		echo $args['after_widget'];
	}

	function register(){
		register_sidebar_widget('IP2Map', array('IP2Map', 'widget'));
		register_widget_control('IP2Map', array('IP2Map', 'control'));
	}
}
?>