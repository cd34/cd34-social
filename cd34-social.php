<?php
/*
Plugin Name: Async Social Media Buttons (Google+, Twitter, Facebook, Pinterest)
Version: 0.7
Plugin URI: http://cd34.com/
Description: Uses async javascript/xdr to use vendor supplied buttons
Author: Chris Davies
Author URI: http://cd34.com/
*/

function cd34_social($content) {
    global $post;

    if ( (get_option('cd34_pageonly') == 'n') && (is_home()) ) {
      return $content;
    }
	
    $my_link = get_permalink($post->ID);	
    $my_title = rawurlencode(get_the_title($post->ID));

    if ( (!is_feed()) and (!is_page()) ) {
      if (get_option('cd34_google') != 'n') {
        $content .= <<<EOt
<div style="float:left;">
<g:plusone href="$my_link"></g:plusone>
</div>
EOt
;
      }
      if (get_option('cd34_twitter') != 'n') {
        $content .= <<<EOt
<div style="float:left;">
<a href="http://twitter.com/share?url=$my_link&text=$my_title" class="twitter-share-button" data-count="horizontal">Tweet</a>
</div>
EOt
;
      }
      if (get_option('cd34_pinterest') != 'n') {
        $media='';
        $res = preg_match('/<img\ .*src="(.*)"\ alt/', $post->post_content, $matches);
        if ($res == 1) {
          $media = '&media=' . $matches[1];
        }
        $content .= <<<EOt
<div style="float:left;">
<a href="http://pinterest.com/pin/create/button/?url=$my_link$media&description=$my_title" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
</div>
EOt
;
      }
      if (get_option('cd34_facebook') != 'n') {
        $content .= <<<EOt
<div style="float:left;">
<div id="fb-root"></div>
<fb:like href="$my_link" width="250" send="false" show_faces="false" layout="button_count" action="recommend"></fb:like>
</div>
EOt
;
      }
        $content .= <<<EOt
<div style="clear:both;"></div>
EOt
;
    }				  
	return $content;
}

function cd34_social_javascript() {
  echo <<<EOt
<script type="text/javascript">
<!--
var a=["//apis.google.com/js/plusone.js","//platform.twitter.com/widgets.js","//connect.facebook.net/en_US/all.js#xfbml=1","//assets.pinterest.com/js/pinit.js"];for(script_index in a){var b=document.createElement("script");b.type="text/javascript";b.async=!0;b.src=a[script_index];var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)};
// -->
</script>
EOt
;
}

function cd34_social_menu() {
  add_options_page('cd34 Social Button Options', 'cd34 Social Buttons', 'manage_options', 'cd34-social', 'cd34_social_options');
}

function cd34_social_options() {
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.'
) );
    }
    $pageonly_yes = get_option('cd34_pageonly') == 'y' ? 
        'selected="selected"' : '';
    $pageonly_no = get_option('cd34_pageonly') == 'n' ?
        'selected="selected"' : '';
    $google_yes = get_option('cd34_google') == 'y' ? 
        'selected="selected"' : '';
    $google_no = get_option('cd34_google') == 'n' ?
        'selected="selected"' : '';
    $twitter_yes = get_option('cd34_twitter') == 'y' ?
        'selected="selected"' : '';
    $twitter_no = get_option('cd34_twitter') == 'n' ?
        'selected="selected"' : '';
    $facebook_yes = get_option('cd34_facebook') == 'y' ?
        'selected="selected"' : '';
    $facebook_no = get_option('cd34_facebook') == 'n' ?
        'selected="selected"' : '';
    $pinterest_yes = get_option('cd34_pinterest') == 'y' ?
        'selected="selected"' : '';
    $pinterest_no = get_option('cd34_pinterest') == 'n' ?
        'selected="selected"' : '';
?>

<div class="wrap">
<h2>cd34 Social Buttons</h2>
<form method="post" action="options.php">
    <?php settings_fields( 'cd34-social' ); ?>

    <table class="form-table">
        <tr valign="top">
        <th scope="row">Display Social Button Bar on Frontpage and Post?</th>
        <td><select name="cd34_pageonly">
	    <option value="y" <?php echo $pageonly_yes;?>>Yes</option>
	    <option value="n" <?php echo $pageonly_no;?>>No</option>
	    </select>
	</td>
        <td>If you select No here, the Social Media Buttons will only
            show up on the individual post.
        </td>
        </tr>
        <tr valign="top">
        <th scope="row">Google Button?</th>
        <td><select name="cd34_google">
	    <option value="y" <?php echo $google_yes;?>>Yes</option>
	    <option value="n" <?php echo $google_no;?>>No</option>
	    </select>
	</td>
        <td>Do you want to show the Google +1 button?</td>
        </tr>
        <tr valign="top">
        <th scope="row">Twitter Button?</th>
        <td><select name="cd34_twitter">
	    <option value="y" <?php echo $twitter_yes;?>>Yes</option>
	    <option value="n" <?php echo $twitter_no;?>>No</option>
	    </select>
	</td>
        <td>Do you want to show the Twitter button?</td>
        </tr>
        <tr valign="top">
        <th scope="row">Facebook Button?</th>
        <td><select name="cd34_facebook">
	    <option value="y" <?php echo $facebook_yes;?>>Yes</option>
	    <option value="n" <?php echo $facebook_no;?>>No</option>
	    </select>
	</td>
        <td>Do you want to show the Facebook button?</td>
        </tr>
        <tr valign="top">
        <th scope="row">Pinterest Button?</th>
        <td><select name="cd34_pinterest">
	    <option value="y" <?php echo $pinterest_yes;?>>Yes</option>
	    <option value="n" <?php echo $pinterest_no;?>>No</option>
	    </select>
	</td>
        <td>Do you want to show the Pinterest button?</td>
        </tr>
    </table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"
/>
</p>
</form>
</div>
<?php
}

function validate_boolean ($input) {
  if ($input['text_string'] != 'n') {
    $input['text_string'] = 'y';
  }
  return $input;
}

function cd34_social_init() {
    register_setting('cd34-social', 'cd34_google', 'validate_boolean');
    register_setting('cd34-social', 'cd34_twitter', 'validate_boolean');
    register_setting('cd34-social', 'cd34_facebook', 'validate_boolean');
    register_setting('cd34-social', 'cd34_pinterest', 'validate_boolean');
    register_setting('cd34-social', 'cd34_pageonly', 'validate_boolean');
}

add_action('admin_init', 'cd34_social_init');
add_action('admin_menu', 'cd34_social_menu');
add_filter('the_content', 'cd34_social', 1968);
add_filter('the_excerpt', 'cd34_social', 1968);
add_filter('wp_footer', 'cd34_social_javascript', 1968);

?>
