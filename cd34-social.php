<?php
/**
 * Plugin Name: Async Social Media Buttons (Twitter/X, Facebook, Pinterest)
 * Version: 1.0
 * Plugin URI: http://cd34.com/
 * Description: Adds social sharing buttons using async JavaScript for fast page loads
 * Author: Chris Davies
 * Author URI: http://cd34.com/
 * License: MIT
 */

defined('ABSPATH') || exit;

function cd34_social_content($content) {
    global $post;

    if (!$post) {
        return $content;
    }

    if (get_option('cd34_pageonly') === 'n' && is_home()) {
        return $content;
    }

    if (is_feed() || is_page()) {
        return $content;
    }

    $my_link = esc_url(get_permalink($post->ID));
    $my_title = rawurlencode(get_the_title($post->ID));

    $buttons = '';

    if (get_option('cd34_twitter') !== 'n') {
        $buttons .= '<div style="float:left;">'
            . '<a href="https://x.com/intent/post?url=' . esc_attr($my_link) . '&text=' . esc_attr($my_title) . '" target="_blank" rel="noopener noreferrer">Post</a>'
            . '</div>';
    }

    if (get_option('cd34_facebook') !== 'n') {
        $buttons .= '<div style="float:left;">'
            . '<div id="fb-root"></div>'
            . '<div class="fb-share-button" data-href="' . esc_attr($my_link) . '" data-layout="button_count"></div>'
            . '</div>';
    }

    if (get_option('cd34_pinterest') !== 'n') {
        $media = '';
        if (has_post_thumbnail($post->ID)) {
            $media = '&media=' . esc_url(get_the_post_thumbnail_url($post->ID, 'large'));
        } elseif (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $post->post_content, $matches)) {
            $media = '&media=' . esc_url($matches[1]);
        }
        $buttons .= '<div style="float:left;">'
            . '<a href="https://pinterest.com/pin/create/button/?url=' . esc_attr($my_link) . esc_attr($media) . '&description=' . esc_attr($my_title) . '" '
            . 'data-pin-do="buttonPin" data-pin-count="beside" target="_blank" rel="noopener noreferrer">Pin It</a>'
            . '</div>';
    }

    if ($buttons) {
        $content .= $buttons . '<div style="clear:both;"></div>';
    }

    return $content;
}

function cd34_social_enqueue_scripts() {
    if (is_feed()) {
        return;
    }

    if (get_option('cd34_facebook') !== 'n') {
        wp_enqueue_script(
            'facebook-sdk',
            'https://connect.facebook.net/en_US/sdk.js#xfbml=1',
            [],
            null,
            ['strategy' => 'async', 'in_footer' => true]
        );
    }

    if (get_option('cd34_pinterest') !== 'n') {
        wp_enqueue_script(
            'pinterest-sdk',
            'https://assets.pinterest.com/js/pinit.js',
            [],
            null,
            ['strategy' => 'async', 'in_footer' => true]
        );
    }
}

function cd34_social_menu() {
    add_options_page(
        'cd34 Social Button Options',
        'cd34 Social Buttons',
        'manage_options',
        'cd34-social',
        'cd34_social_options'
    );
}

function cd34_social_options() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    $fields = [
        'cd34_pageonly'  => 'Display Social Button Bar on Frontpage and Post?',
        'cd34_twitter'   => 'Twitter/X Button?',
        'cd34_facebook'  => 'Facebook Button?',
        'cd34_pinterest' => 'Pinterest Button?',
    ];
    ?>
    <div class="wrap">
        <h2>cd34 Social Buttons</h2>
        <form method="post" action="options.php">
            <?php settings_fields('cd34-social'); ?>
            <table class="form-table">
                <?php foreach ($fields as $key => $label) :
                    $value = get_option($key, 'y');
                ?>
                <tr>
                    <th scope="row"><?php echo esc_html($label); ?></th>
                    <td>
                        <select name="<?php echo esc_attr($key); ?>">
                            <option value="y" <?php selected($value, 'y'); ?>>Yes</option>
                            <option value="n" <?php selected($value, 'n'); ?>>No</option>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
            </p>
        </form>
    </div>
    <?php
}

function cd34_social_sanitize_boolean($input) {
    return $input === 'n' ? 'n' : 'y';
}

function cd34_social_init() {
    $options = ['cd34_twitter', 'cd34_facebook', 'cd34_pinterest', 'cd34_pageonly'];
    foreach ($options as $option) {
        register_setting('cd34-social', $option, [
            'type'              => 'string',
            'sanitize_callback' => 'cd34_social_sanitize_boolean',
            'default'           => 'y',
        ]);
    }
}

add_action('admin_init', 'cd34_social_init');
add_action('admin_menu', 'cd34_social_menu');
add_action('wp_enqueue_scripts', 'cd34_social_enqueue_scripts');
add_filter('the_content', 'cd34_social_content', 1968);
add_filter('the_excerpt', 'cd34_social_content', 1968);
