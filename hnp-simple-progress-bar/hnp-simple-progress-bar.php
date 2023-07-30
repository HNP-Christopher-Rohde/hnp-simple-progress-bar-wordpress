<?php

/*
  Plugin Name: HNP - Simple Progress Bar
  Description: Display a customizable and lightweight frontend progress bar to indicate loading progress on your website.
  Author: Christopher Rohde
  Version: 1.1
  Author URI: https://homepage-nach-preis.de/
  License: GPLv3
  Text Domain: hnp-spb-textdomain
  Domain Path: /languages
 */

defined('ABSPATH') or die('Huh, are you trying to cheat?');
$plugin_url = plugin_dir_url(__FILE__);
$options = array();

function hnp_spb_load_textdomain() {
   $domain = 'hnp-spb-textdomain';
   $locale = apply_filters('plugin_locale', get_locale(), $domain);
   $mofile = WP_PLUGIN_DIR . '/hnp-spb-plugin/languages/' . $domain . '-' . $locale . '.mo';

   if (file_exists($mofile)) {
      load_textdomain($domain, $mofile);
   } else {
      load_plugin_textdomain($domain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
   }
}
add_action('plugins_loaded', 'hnp_spb_load_textdomain');

function hnp_spb_menu() {
   add_menu_page(
      esc_html__('HNP - Simple Progress Bar', 'hnp-spb-textdomain'),
      esc_html__('HNP - Simple Progress Bar', 'hnp-spb-textdomain'),
      'manage_options',
      'hnp_spb_options',
      'hnp_spb_display',
      plugin_dir_url(__FILE__) . 'img/hnp-favi.png'
   );
}
add_action('admin_menu', 'hnp_spb_menu');

function hnp_spb_plugin_settings_link($links) {
   $settings_link = '<a href="admin.php?page=hnp_spb_options">' . esc_html__('Settings', 'hnp-spb-textdomain') . '</a>';
   array_push($links, $settings_link);
   return $links;
}
$plugin_file = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin_file", 'hnp_spb_plugin_settings_link');

function hnp_spb_display() {
   if (!current_user_can('manage_options')) {
      wp_die(esc_html__('You do not have enough permission to view this page', 'hnp-spb-textdomain'));
   }

   global $plugin_url;
   global $options;
   
	// Main OPTIONS 	
   if (isset($_POST['hnp_form_submit_1'])) {
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      require_once(ABSPATH . 'wp-admin/includes/file.php');
      require_once(ABSPATH . 'wp-admin/includes/media.php');

      echo '<h2 style="color:green">' . esc_html__('Saved', 'hnp-spb-textdomain') . '</h2>';
      echo '<script src="' . plugin_dir_url(__FILE__) . 'js/hnp-spb-admin-save.js"></script>';
	  	  
      $options['hnp_spb_data_checked'] = isset($_POST['hnp_spb_data_checked']) ? esc_html($_POST['hnp_spb_data_checked']) : '';
	  $options['hnp_spb_data_opacity'] = isset($_POST['hnp_spb_data_opacity']) ? sanitize_text_field($_POST['hnp_spb_data_opacity']) : '0.7';
	  $options['hnp_spb_data_color'] = isset($_POST['hnp_spb_data_color']) ? sanitize_hex_color($_POST['hnp_spb_data_color']) : '';	  
	  	  
      update_option('hnp-spb-plugin-options-main', $options);
   }
	
	// Other OPTIONS   
	if (isset($_POST['hnp_form_submit_9'])) {
	  require_once(ABSPATH . 'wp-admin/includes/image.php');
      require_once(ABSPATH . 'wp-admin/includes/file.php');
      require_once(ABSPATH . 'wp-admin/includes/media.php');

      echo '<h2 style="color:green">' . esc_html__('Saved', 'hnp-spb-textdomain') . '</h2>';
      echo '<script src="' . plugin_dir_url(__FILE__) . 'js/hnp-spb-admin-save.js"></script>';
	  
	  $options['hnp_spb_data_licence'] = isset($_POST['hnp_spb_data_licence']) ? esc_html($_POST['hnp_spb_data_licence']) : '';
	  $options['hnp_spb_data_custom_css'] = isset($_POST['hnp_spb_data_custom_css']) ? esc_html($_POST['hnp_spb_data_custom_css']) : '';
	
	  update_option('hnp-spb-plugin-options-other', $options);
	}

   $options = get_option('hnp-spb-plugin-options-main');
   $options = get_option('hnp-spb-plugin-options-other');
   require('inc/options-page-wrapper.php');
}


// ******* CHECK THE FUNCTION ******

// Check the Licence
// Its just a test, Main-Function comes later
function hnp_spb_check_licence_key_status() {
    $options = get_option('hnp-spb-plugin-options-other');

    $hnp_licence_key = 'Free Version';
    $color = '';

    if (isset($options['hnp_spb_data_licence'])) {
        $licence_key = $options['hnp_spb_data_licence'];

        if (substr($licence_key, 0, 4) === 'hnp-' || substr($licence_key, 0, 4) === 'HNP-') {
            $hnp_licence_key = esc_html__('Licence Activated', 'hnp-spb-textdomain');
            $color = 'green';
        } elseif (strlen($licence_key) === 9 && substr($licence_key, -1) === '-') {
            $hnp_licence_key = esc_html__('Licence Activated', 'hnp-spb-textdomain');
            $color = 'green';
        }
    }

    if ($hnp_licence_key === '') {
        $hnp_licence_key = esc_html__('Licence Not activated', 'hnp-spb-textdomain');
        $color = 'red';
    }

    return '<div class="hnp_plugin_data_active" style="color: ' . $color . '; font-weight: bold;">' . esc_html($hnp_licence_key) . '</div>';
}


// Check Status of Function
function hnp_spb_check_status_main() {
    $options = get_option('hnp-spb-plugin-options-main');

    $hnp_function_status = '';
    $function_color = '';

    if (isset($options['hnp_spb_data_checked'])) {
        $function_activate = $options['hnp_spb_data_checked'];

        if ($function_activate === '1') {
            $hnp_function_status = esc_html__('Activated', 'hnp-spb-textdomain');
            $function_color = 'green';
        } else {
            $hnp_function_status = esc_html__('Not Activated', 'hnp-spb-textdomain');
            $function_color = 'red';
        }
    } else {
        $hnp_function_status = esc_html__('Not Activated', 'hnp-spb-textdomain');
        $function_color = 'red';
    }

		$output = '<div class="hnp_spb_data_active" style="font-weight: bold;">';
		$output .= sprintf(
		   __('Function: <span style="color: %s;">%s</span></div>', 'hnp-spb-textdomain'),
		   $function_color,
		   esc_html($hnp_function_status)
		);


    return $output;
}
//**** END CHECK FUNCTION


//Hover Box
function hnp_spb_generate_hover_box($text) {
    $html = '<div class="hover-box">';
    $html .= '<span class="hover-text">' . esc_html($text) . '</span>';
    $html .= '</div>';
    
    return $html;
}

//Frontend-Inline CSS
function hnp_spb_output_custom_css() {
   $options = get_option('hnp-spb-plugin-options-other');
   $custom_css = !empty($options['hnp_spb_data_custom_css']) ? $options['hnp_spb_data_custom_css'] : '';

   if (!empty($custom_css)) {
      echo '<style>' . esc_html($custom_css) . '</style>';
   }
}
add_action('wp_head', 'hnp_spb_output_custom_css');


// Enqueue Scripts
function hnp_spb_plugin_admin_styles() {
   wp_enqueue_style('hnp_spb_unique-admin-styles', plugin_dir_url(__FILE__) . 'css/hnp_spb_backend.css', array(), '1.0');
   wp_enqueue_script('hnp_spb_custom-admin-script', plugin_dir_url(__FILE__) . 'js/hnp_spb_custom-admin-script.js', array('jquery'), '1.0', true);
   wp_enqueue_media();
}

add_action('admin_enqueue_scripts', 'hnp_spb_plugin_admin_styles', 999);


// Start Main Function
function hnp_add_top_progress_bar() {
 $options = get_option('hnp-spb-plugin-options-main');
 $is_checked = isset($options['hnp_spb_data_checked']) && $options['hnp_spb_data_checked'] === '1';
	if ($is_checked) {
	echo '<div id="hnp_top-progress-bar"></div>';
	}
}
add_action('wp_footer', 'hnp_add_top_progress_bar');

function hnp_top_progress_bar_script() {
 $options = get_option('hnp-spb-plugin-options-main');
 $is_checked = isset($options['hnp_spb_data_checked']) && $options['hnp_spb_data_checked'] === '1';
    
    $color = isset($options['hnp_spb_data_color']) && !empty($options['hnp_spb_data_color']) ? sanitize_hex_color($options['hnp_spb_data_color']) : '#e82c67';
    $opacity = !empty($options['hnp_spb_data_opacity']) ? floatval($options['hnp_spb_data_opacity']) : 0.7;
	
	if ($is_checked) {
    ?>
    <style>
        #hnp_top-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%; 
            height: 3px;
            background-color: <?php echo $color; ?>; /
            z-index: 9999;
            transform: scaleX(0); 
            transform-origin: left; 
            transition: transform 0.2s ease; 
            opacity: <?php echo $opacity; ?>; 
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var progressBar = document.getElementById('hnp_top-progress-bar');
            var totalResources = document.querySelectorAll('img, script, link[rel="stylesheet"], audio, video').length;
            var loadedResources = 0;
            var cssLoaded = false;
            var domLoaded = false;

            function updateProgressBar(progress) {
                progressBar.style.transform = 'scaleX(' + progress / 100 + ')'; 
            }

            function calculateProgress() {
                var domProgress = domLoaded ? 10 : 0;
                var cssProgress = cssLoaded ? 15 : 0;
                var resourcesProgress = Math.floor((loadedResources / (totalResources + 1)) * 25);
                var progress = domProgress + cssProgress + resourcesProgress;
                return progress;
            }

            function resourceLoaded() {
                loadedResources++;
                var progress = calculateProgress();
                updateProgressBar(progress);

                if (loadedResources === totalResources && domLoaded && cssLoaded) {
                    progressBar.style.transform = 'scaleX(1)'; 
                    setTimeout(function() {
                        progressBar.parentNode.removeChild(progressBar);
                    }, 300);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                domLoaded = true;
                var progress = calculateProgress();
                updateProgressBar(progress);
            });

            var resourceElements = document.querySelectorAll('img, script, audio, video');

            resourceElements.forEach(function(element) {
                if (element.complete) {
                    resourceLoaded();
                } else {
                    element.addEventListener('load', resourceLoaded);
                    element.addEventListener('error', resourceLoaded);
                }
            });

            var cssLinks = document.querySelectorAll('link[rel="stylesheet"]');
            var totalCssLinks = cssLinks.length;

            function cssLoadedHandler() {
                cssLoaded = true;
                var progress = calculateProgress();
                updateProgressBar(progress);

               
                cssLinks.forEach(function(link) {
                    link.removeEventListener('load', cssLoadedHandler);
                    link.removeEventListener('error', cssLoadedHandler);
                });
            }

            cssLinks.forEach(function(link) {
                link.addEventListener('load', cssLoadedHandler);
                link.addEventListener('error', cssLoadedHandler);
            });

            window.addEventListener('load', function() {
                progressBar.style.transform = 'scaleX(1)'; 
                setTimeout(function() {
                    progressBar.parentNode.removeChild(progressBar);
                }, 300);
            });
        });
    </script>
    <?php }
}
add_action('wp_footer', 'hnp_top_progress_bar_script');