<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
Plugin Name: PopularPost Aink
Plugin URI: http://www.classifindo.com/popularpost-aink/
Description: Show popular post in scroll up.
Author: Dannie Herdyawan a.k.a k0z3y
Version: 4.0
Author URI: http://www.classifindo.com/
*/


/*
   _____                                                 ___  ___
  /\  __'\                           __                 /\  \/\  \
  \ \ \/\ \     __      ___     ___ /\_\     __         \ \  \_\  \
   \ \ \ \ \  /'__`\  /' _ `\ /` _ `\/\ \  /'__'\        \ \   __  \
    \ \ \_\ \/\ \L\.\_/\ \/\ \/\ \/\ \ \ \/\  __/    ___  \ \  \ \  \
     \ \____/\ \__/.\_\ \_\ \_\ \_\ \_\ \_\ \____\  /\__\  \ \__\/\__\
      \/___/  \/__/\/_/\/_/\/_/\/_/\/_/\/_/\/____/  \/__/   \/__/\/__/

*/

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

global $PopularPostAink_path;
$PopularPostAink_path = get_settings('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));

/* When plugin is deactivation*/
register_deactivation_hook( __FILE__, 'hapus_PopularPostAink' );
function hapus_PopularPostAink()
{
	/* Deletes the database field */
	global $options;
	$options = get_option('PopularPostAink_option');
	delete_option($options);
}

/* Call the html code */
add_action('admin_menu', 'PopularPostAink_admin_menu');
function PopularPostAink_admin_menu() {
	if((current_user_can('manage_options') || is_admin)) {
		global $PopularPostAink_path;
		add_object_page('PopularPost-Aink','PopularPost',1,'PopularPost-Aink','PopularPostAink_page',$PopularPostAink_path.'/images/favicon.png');
		add_submenu_page('PopularPost-Aink','PopularPost Settings','Settings',1,'PopularPost-Aink','PopularPostAink_page');
	}
}

function PopularPostAink_page() {
	if (isset($_POST['save'])) {
		$options['PopularPostAink_title']			= trim($_POST['PopularPostAink_title'],'{}');
		$options['PopularPostAink_longtitle']		= trim($_POST['PopularPostAink_longtitle'],'{}');
		$options['PopularPostAink_height']			= trim($_POST['PopularPostAink_height'],'{}');
		$options['PopularPostAink_longcontent']		= trim($_POST['PopularPostAink_longcontent'],'{}');
		$options['PopularPostAink_showpost']		= trim($_POST['PopularPostAink_showpost'],'{}');
		$options['PopularPostAink_link']			= trim($_POST['PopularPostAink_link'],'{}');
		update_option('PopularPostAink_option', $options);
		// Show a message to say we've done something
		echo '<div class="updated"><p>' . __("Save Changes") . '</p></div>';
	} else {		
		$options = get_option('PopularPostAink_option');
	}
	echo PopularPostAinkSettings();
}

function PopularPostAinkSettings() { global $options; $options = get_option('PopularPostAink_option'); ?>
<div class="wrap">
<div class="icon32" id="icon-tools"><br/></div>
<h2><?php echo __('PopularPost Aink'); ?></h2>

<form method="post" id="mainform" action="">
<table class="widefat fixed" style="margin:25px 0;">
	<thead>
		<tr>
			<th scope="col" width="200px">PopularPost Aink Settings</th>
			<th scope="col">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="titledesc">PopularPost Title Long:</td>
			<td class="forminp">
				<input name="PopularPostAink_longcontent" id="PopularPostAink_longcontent" style="width:55px;" value="<?php echo $options[PopularPostAink_longcontent]; ?>" type="text">
				<br /><small>Long for title. ex: "100" character (without quotes, digit only).</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopularPost Content Long:</td>
			<td class="forminp">
				<input name="PopularPostAink_longtitle" id="PopularPostAink_longtitle" style="width:55px;" value="<?php echo $options[PopularPostAink_longtitle]; ?>" type="text">
				<br /><small>Long for content. ex: "100" character (without quotes, digit only).</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopularPost Height:</td>
			<td class="forminp">
				<input name="PopularPostAink_height" id="PopularPostAink_height" style="width:100px;" value="<?php echo $options[PopularPostAink_height]; ?>" type="text">
				<br /><small>ex: "500px" (without quotes).</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopularPost Show Posts:</td>
			<td class="forminp">
				<input name="PopularPostAink_showpost" id="PopularPostAink_showpost" style="width:55px;" value="<?php echo $options[PopularPostAink_showpost]; ?>" type="text">
				<br /><small>Show how many want your post to show; ex: "10" or "25" (without quotes, digit only).</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopularPost Text Align:</td>
			<td class="forminp">
				<select name="PopularPostAink_text_align" id="PopularPostAink_text_align" style="min-width:100px;">
					<?php if ($options[PopularPostAink_text_align] == 'left'){ ?>
						<option value="left" selected="selected">Left</option>
						<option value="center">Center</option>
						<option value="right">Right</option>
					<?php } else if ($options[PopularPostAink_text_align] == 'center'){ ?>
						<option value="left">Left</option>
						<option value="center" selected="selected">Center</option>
						<option value="right">Right</option>
					<?php } else if ($options[PopularPostAink_text_align] == 'right'){ ?>
						<option value="left">Left</option>
						<option value="center">Center</option>
						<option value="right" selected="selected">Right</option>
					<?php } else { ?>
						<option value="left" selected="selected">Left</option>
						<option value="center">Center</option>
						<option value="right">Right</option>
					<?php } ?>
				</select>
				<br /><small>Text align for PopularPost.</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopularPost Show Link:</td>
			<td class="forminp">
				<input name="PopularPostAink_link" type="checkbox" <?php
				if($options[PopularPostAink_link] == 'check') {
					echo 'checked="checked" value="check"';
				} else if($options[PopularPostAink_link] != 'check') {
					echo 'value="check"';					
				} else {
					echo 'checked="checked" value="check"';
				}
				?> />
				<br /><small>Show PopularPost Aink link.</small>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="<?php get_option($options) ?>" />
<p class="submit bbot"><input name="save" type="submit" value="<?php esc_attr_e("Save Changes"); ?>" /></p>
</form>
</div>

	<div class="wrap"><hr /></div>

<div class="wrap">
<table class="widefat fixed" style="margin:25px 0;">
	<thead>
		<tr>
			<th scope="col" width="200px">Donate for PopularPost Aink</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="forminp">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="32CJTW7F75F8G">
<img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/id_ID/i/scr/pixel.gif" width="1" height="1">
<p class="submit bbot"><input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/en_GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online."></p>
</form>					
			</td>
		</tr>
	</tbody>
</table>
</div>

<?php }

function PopularPostAink_new()
{
	echo CreateNewPopularPostAink();
}

function PopularPostAink_init() {
	if ( !is_blog_installed() )
		return;
	register_widget('PopularPostAink');
	do_action('widgets_init');
}

add_action('init', 'PopularPostAink_init', 1);
add_action("wp_head", "PopularPostAink_head");

function PopularPostAink_head()
{
	global $PopularPostAink_path;

	echo '<!-- PopularPost Aink -->';
	echo '<link type="text/css" rel="stylesheet" href="'.$PopularPostAink_path.'/css/popularpost-aink.css" />';
	echo '	<style type="text/css">
				@font-face{
					font-family:Angelina;
					src:url("http://www.classifindo.com/fonts/Angelina.ttf");
				}
			</style>';
	echo '<script type="text/javascript" language="javascript" src="'.$PopularPostAink_path.'/js/popularpost-aink.js"></script>';
	echo '<!-- PopularPost Aink -->';
}

/* This Registers a Sidebar Widget.*/
class PopularPostAink extends WP_Widget {

	function PopularPostAink() {
		$widget_ops = array('description' => 'Show PopularPost Aink.' );
		parent::WP_Widget(false, __('PopularPost Aink', 'k0z3y'), $widget_ops);      
	}
	
	function widget( $args, $instance ) {
		extract($args);
		global $wpdb, $options;
		$options = get_option('PopularPostAink_option');
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		} else {
			if($options[PopularPostAink_link] == 'check'){
				echo $before_title . '<a href="http://www.classifindo.com/popularpost-aink/" target="_blank">PopularPost Aink</a>' . $after_title;
			} else {
				echo $before_title . 'PopularPost Aink' . $after_title;
			}
		}

?>
<div style="display:block;">
	<ul id="PopularPostAink" style="height:<?php if ($options[PopularPostAink_height]!=''){echo $options[PopularPostAink_height];}elseif($options[PopularPostAink_height]==''){echo '350px';}?>;">

<?php
	if ($options[PopularPostAink_showpost] != '' ) {
		$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , ".$options[PopularPostAink_showpost]."");
	} else {
		$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 5");
	}
	foreach ($result as $post) {
		if ($post->comment_count != 0) {
		query_posts("p=$post->ID");
			if (have_posts()) : while (have_posts()) : the_post();
?>
			<li>
				<div style="padding:5px 5px 8px 5px">
				<h3>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php
					if ($options[PopularPostAink_longtitle] != '' ) {
						if (mb_strlen(get_the_title()) >= $options[PopularPostAink_longtitle]) echo mb_substr(get_the_title(), 0, $options[PopularPostAink_longtitle]).'...'; else the_title();
					} else {
						if (mb_strlen(get_the_title()) >= 30) echo mb_substr(get_the_title(), 0, 30).'...'; else the_title();
					}
				?>
				</a>
				</h3>
				<small class="comment"><?php comments_popup_link('0', '1', '%'); ?></small>
				<small class="author"><?php the_author_posts_link(); ?></small>
				<small class="date"><?php the_time('M j, Y') ?></small>
				<div style="clear:both;padding:5px;display:block;"></div>
				<span>
				<?php
					if ($options[PopularPostAink_longcontent] != '' ) {
						$tcontent = strip_tags(get_the_content()); if (mb_strlen($tcontent) >= $options[PopularPostAink_longcontent]) echo mb_substr($tcontent, 0, $options[PopularPostAink_longcontent]).'.....'; else echo $tcontent;
					} else {
						$tcontent = strip_tags(get_the_content()); if (mb_strlen($tcontent) >= 250) echo mb_substr($tcontent, 0, 250).'.....'; else echo $tcontent;
					}
				?>
				</span>
				</div>
			</li>
<?php
			endwhile; endif;
			wp_reset_query();
		};
	};
?>
	</ul>
</div>

<?php
	if($options[PopularPostAink_link] == 'check'){
		echo '<div style="text-align:right;">';
			echo '<a href="http://www.classifindo.com/popularpost-aink/" target="_blank" style="font-size:11px;">';
				echo '<font face="font-family:Angelina, Helvetica, sans-serif, "Trebuchet MS", sans-serif, Arial, Tahoma;">';
					echo 'PopularPost Aink';
				echo '</font>';
			echo '</a>';
		echo '</div>';
	}

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

}

?>