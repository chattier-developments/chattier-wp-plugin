<?php

/**
 * Plugin Name: Chattier
 * Plugin URI: https://chattier.dev/
 * Description: Embed intelligent chatbots or avatars on any Wordpress site.
 * Version: 1.0.0
 * Author: Chattier
 * Author URI: https://chattier.dev/
 * License: GPLv2
 */

add_action('admin_menu', 'add_chattier_options_page');

// Add the options page to the admin menu
function add_chattier_options_page()
{
    add_options_page('Chattier Plugin Settings', 'Chattier Settings', 'administrator', 'chattier_embed', 'chattier_options_page');
    add_action('admin_init', 'register_chattier_options');
}

// Register the options settings
function register_chattier_options()
{
    register_setting('chattier_options', 'chattier_embed');
	register_setting('chattier_options', 'chattier_activation');
}

// Define the content of the options page
function chattier_options_page()
{
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <!-- Step 1 -->
        <h2><?php _e('Step 1: Create your chatbot', 'chattier_embed'); ?></h2>
        <p><?php _e('Go to <a href="https://chattier.dev/">https://chattier.dev/</a> and sign in with your email. Then click on the "MY CHATBOTS" button at the top right corner. If you have not created a chatbot before, then click on the button "Create new chatbot". Follow the instructions in order to configure your chatbot. Remember to include the domain of your WordPress site in the "Allowed domains" section. Wait until your chatbot is created and make sure you can see your chatbot in the dashboard.', 'chattier_embed'); ?></p>
        <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/step1.png'; ?>" alt="Step 1" width="1000" height="454">
        <!-- Step 2 -->
        <h2><?php _e('Step 2: Get your chatbot embed code', 'chattier_embed'); ?></h2>
        <p><?php _e('Click on the green "Embed on website" button. Copy the code that appears in the box. You can select and copy the text or simply click on the small copy icon on the upper right corner of the box.', 'chattier_embed'); ?></p>
        <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/step2.png'; ?>" alt="Step 2" width="1000" height="306">
        <!-- Step 3 -->
        <h2><?php _e('Step 3: Paste the code in the box below', 'chattier_embed'); ?></h2>
        <p><?php _e('Paste the code in the box below. Then select where you want to activate your chatbot. You can activate it only on the front page or on all pages. Finally, click on the "Save Changes" button below.', 'chattier_embed'); ?></p>

        <form method="post" action="options.php">
            <?php settings_fields('chattier_options'); ?>
            <?php do_settings_sections('chattier_options'); ?>
            <!-- Add a textarea to paste the chatbot embed code -->
            <textarea name="chattier_embed" id="chattier_embed" rows=15 cols=150><?php echo esc_html(get_option('chattier_embed')); ?></textarea>
        	<!-- Add a dropdown button which allows to configure chatbot activation only on front page or on all pages -->
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="chattier_embed"><?php _e('Where do you want to activate your chatbot?', 'chattier_activation'); ?></label></th>
                    <td>
                        <select name="chattier_activation" id="chattier_activation">
                            <option value="frontpage" <?php if (get_option('chattier_activation') == 'frontpage') echo 'selected="selected"'; ?>>Front page</option>
                            <option value="allpages" <?php if (get_option('chattier_activation') == 'allpages') echo 'selected="selected"'; ?>>All pages</option>
                        </select>
                    </td>
                </tr>
            </table>
            <!-- Add a submit button to save the settings -->
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Embed the script on the site using the code entered in the options page
function chattier_embed_chatbot()
{
    $chattier_embed = get_option('chattier_embed');
    if (get_option('chattier_activation') == 'allpages')
    {
        echo $chattier_embed;
    }
    // Only on front page if the setting has been selected
    else if ((get_option('chattier_activation') == 'frontpage') && (is_front_page()))
    {
		echo $chattier_embed;
	}
}
add_action('wp_footer', 'chattier_embed_chatbot');
?>