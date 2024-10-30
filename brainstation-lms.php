<?php

/**
 * Plugin Name:       Brainstation LMS Integration
 * Description:       Create user and direct login into app (portal.brainstationlms.com app). Shortcode [bslms_app_login].
 * Version:           1.15.0
 * Author:            Brainstation
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       brainstation-lms
 */



if (!defined('ABSPATH')) {
    die();
}

define( 'BSLMS_PATH', plugin_dir_path( __FILE__ ) );
define( 'BSLMS_URL', plugin_dir_url( __FILE__ ) );

if ( !function_exists('bslms_details_menu')) {
    function bslms_details_menu() {
        add_menu_page( __('Brainstation Details', 'brainstation-lms'), __('Brainstation Details', 'brainstation-lms'), 'manage_options', 'save-brainstation-details', 'bslms_save_details', '', 5 );

    }
    add_action('admin_menu', 'bslms_details_menu');
    
    function bslms_save_details() {
        require BSLMS_PATH . 'inc/bslms_save_details.php';
    }
}


if ( ! function_exists('bslms_enqueue_scripts') ) {

    function bslms_enqueue_scripts() {
        // Enqueue script using wp_enqueue_script
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'brainstation-script', BSLMS_URL . 'assets/js/bslms_custom.js', array(), '1.15.0', true );

        // Localize script
        wp_localize_script( 'brainstation-script', 'bslms_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

        add_action('admin_enqueue_scripts', 'bslms_enqueue_scripts');
        add_action('wp_enqueue_scripts', 'bslms_enqueue_scripts');

}




// bslms_api_validate function for call on click Validate Api Details button
add_action("wp_ajax_bslms_api_validate", "bslms_api_validate");

function bslms_api_validate() {
  
if ( ! isset( $_REQUEST['bslms_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['bslms_nonce'] ) ), 'bslms_validation_nonce' ) ) {
    exit( "Invalid request" );
}


        $api_endpoint = isset( $_REQUEST['bslms_api_endpoint'] ) ? esc_url_raw( $_REQUEST['bslms_api_endpoint'] ) : '';
        $api_secret_key = isset( $_REQUEST['bslms_api_secret_key'] ) ? sanitize_text_field( $_REQUEST['bslms_api_secret_key'] ) : '';

        $result = bslms_validate_details( $api_endpoint, $api_secret_key );

            
            echo wp_json_encode($result);
            die();
}


// function for Api validate

function bslms_validate_details($bslms_api_endpoint, $token) {
    // Set up the arguments for the HTTP GET request
    
    $sanitized_endpoint = esc_url_raw($bslms_api_endpoint); // Sanitize the URL
    $sanitized_token = sanitize_text_field($token); // Sanitize the token


    $args = array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $sanitized_token,
            'Cache-Control' => 'no-cache',
        ),
        'timeout' => 30, // You can adjust the timeout as needed
    );

    // Make the HTTP GET request
    $response = wp_remote_get($sanitized_endpoint, $args);

    // Check if there was an error with the request
    if (is_wp_error($response)) {
        return array(
            'type' => 'error',
            'msg' => 'HTTP Error: ' . $response->get_error_message(),
        );
    }

    // Get the response body and decode it
    $response_body = wp_remote_retrieve_body($response);
    $response_data = json_decode($response_body);

    // Check if the response is valid and contains the expected data
    if (isset($response_data->result->code)) {
        if ($response_data->result->code) {
           return array(
            'type' => 'success',
            'msg' => esc_html__( 'API details working fine.', 'brainstation-lms' ),
        );
        } else {
           return array(
            'type' => 'error',
            'msg' => esc_html__( 'API details are not correct.', 'brainstation-lms' ),
        );
        }
    } else {
        return array(
            'type' => 'error',
            'msg' => esc_html__( 'Unexpected response structure.', 'brainstation-lms' ),
        );
    }
}


/**
 * Show App Login Button
 */
if (!function_exists('bslms_app_login')) {
    function bslms_app_login(){
        if ( is_user_logged_in() ) {
            $bslms_button_label = "Login in app";
            $bslms_button_font_size = "";
            $bslms_button_font_color = "";
            $bslms_button_bg_color = "";
            $bslms_button_font_hover_color = '';
            $bslms_button_bg_hover_color = '';
            if ( !empty(get_option('bslms_button_label')) ) {
                $bslms_button_label = get_option('bslms_button_label');
            }
            if ( !empty(get_option('bslms_button_font_size')) ) {
                $bslms_button_font_size = get_option('bslms_button_font_size').'px';
            }
            if ( !empty(get_option('bslms_button_font_color')) ) {
                $bslms_button_font_color = get_option('bslms_button_font_color');
            }
            if ( !empty(get_option('bslms_button_bg_color')) ) {
                $bslms_button_bg_color = get_option('bslms_button_bg_color');
            }
            if ( !empty(get_option('bslms_button_font_hover_color')) ) {
                $bslms_button_font_hover_color = get_option('bslms_button_font_hover_color');
            }
            if ( !empty(get_option('bslms_button_bg_hover_color')) ) {
                $bslms_button_bg_hover_color = get_option('bslms_button_bg_hover_color');
            }

              $inline_styles = "
                .login_in_app {
                    " . (!empty($bslms_button_font_size) ? 'font-size: ' . esc_attr($bslms_button_font_size) . '; ' : '') . "
                    " . (!empty($bslms_button_font_color) ? 'color: ' . esc_attr($bslms_button_font_color) . '; ' : '') . "
                    " . (!empty($bslms_button_bg_color) ? 'background-color: ' . esc_attr($bslms_button_bg_color) . '; ' : '') . "
                }
                .login_in_app:hover {
                    " . (!empty($bslms_button_font_hover_color) ? 'color: ' . esc_attr($bslms_button_font_hover_color) . '; ' : '') . "
                    " . (!empty($bslms_button_bg_hover_color) ? 'background-color: ' . esc_attr($bslms_button_bg_hover_color) . '; ' : '') . "
                }";

                 // Register and enqueue a base stylesheet
                wp_register_style('bslms-base-styles', BSLMS_URL . 'assets/css/empty.css', array(), '1.15.0');
             
                // Add the inline styles
                wp_add_inline_style('bslms-base-styles', $inline_styles);

            ob_start();
?>
           

            <div class="login_in_app_div">
                <button class="login_in_app"><?php echo esc_attr($bslms_button_label); ?></button>



                <p class="bslms_loader hide_bslms_loader"></p>
            </div>
    <?php
            return ob_get_clean();
        }
    }

    add_shortcode('bslms_app_login', 'bslms_app_login');
}

function bslms_enqueue_styles_if_shortcode_is_present($content) {
    if (has_shortcode($content, 'bslms_app_login')) {
        wp_enqueue_style('bslms-styles', BSLMS_URL . 'assets/css/bslms_styles.css', array(), '1.15.0');
          wp_enqueue_style('bslms-base-styles');
    }

    return $content;
}

add_filter('the_content', 'bslms_enqueue_styles_if_shortcode_is_present');

// Function for login into app on click shortcode button
add_action("wp_ajax_bslms_login_into_app", "bslms_login_into_app");

function bslms_login_into_app(){
    $current_user = wp_get_current_user();
    if(!empty($current_user)){
        $bslms_api_endpoint = $bslms_api_secret_key = $bslms_clientid = $bslms_teamid = $bslms_type = '';
        $userResponse['type'] = 'error';
        $userResponse['url'] = '';
        $userResponse['msg'] = 'Api details empty';

        if ( !empty(get_option('bslms_api_endpoint')) ) {
            $bslms_api_endpoint = get_option('bslms_api_endpoint');
        }
        if ( !empty(get_option('bslms_api_secret_key')) ) {
            $bslms_api_secret_key = get_option('bslms_api_secret_key');
        }

        if ( !empty(get_option('bslms_clientid')) ) {
            $bslms_clientid = get_option('bslms_clientid');
        }

        if ( !empty(get_option('bslms_teamid')) ) {
            $bslms_teamid = get_option('bslms_teamid');
        }

        if ( !empty(get_option('bslms_type')) ) {
            $bslms_type = get_option('bslms_type');
        }
        if(!empty($bslms_api_endpoint) && !empty($bslms_api_secret_key)){
            $result = bslms_validate_details($bslms_api_endpoint,$bslms_api_secret_key);

        



if(!empty($result) && $result['type'] === 'success'){
    $url = "https://brainstationlms.com/services/getUser.php";

    $firstname = $current_user->user_firstname;
    if (empty($current_user->user_firstname) && !empty($current_user->user_login)) {
        $firstname = $current_user->user_login;
    }
    $lastname = $current_user->user_lastname;
    if (empty($current_user->user_lastname) && !empty($current_user->user_login)) {
        $lastname = $current_user->user_login;
    }
    $params = array(
        'clientid' => sanitize_text_field($bslms_clientid),
        'teamid' => sanitize_text_field($bslms_teamid),
        'type' => sanitize_text_field($bslms_type),
        'secret' => sanitize_text_field($bslms_api_secret_key),
        'firstname' => sanitize_text_field($firstname),
        'lastname' => sanitize_text_field($lastname),
        'email' => sanitize_email($current_user->user_email),
    );

    $json_body = wp_json_encode($params); // JSON encode the data

   $args = array(
        'method' => 'POST',
        'body' => $json_body, // Convert params to form-data
        'headers' => array(
           'Content-Type' => 'application/json', // Indicate form-data content type
        ),
        'timeout' => 30, // Timeout for the request
    );

    // Send the POST request using WordPress HTTP API
    $response = wp_remote_post($url, $args);

          if (!empty($response)) {


            $response_body = wp_remote_retrieve_body($response);

             
            $data = json_decode($response_body, true);
            echo wp_json_encode ($data, true);

    
        } else {

            $data = new stdClass(); // Standard class instance
            $data->redirecturl ="";
            echo wp_json_encode ($data, true);
         
        }

}

        }
    }else{
        exit("Invalide request");
    }
   
    
    die();
}
    
function bslms_plugin_activate() {
  add_option('bslms_button_font_size','13' );
  add_option('bslms_button_font_color','#ffffff' );
  update_option('bslms_button_bg_color','#0093DD' );
  update_option('bslms_button_bg_hover_color','#003399' );

  /* activation code here */
}
register_activation_hook( __FILE__, 'bslms_plugin_activate' );