<?php
if (!defined('ABSPATH')) {
    die();
}

if ( (isset($_POST['save_sso']))) {

 
   // Verify the nonce
    if ( ! isset( $_POST['bslms_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bslms_nonce'] ) ), 'bslms_validation_nonce' ) ) {
    // Nonce verification and sanitization
    die('Security check failed');
    }
   

    $nonce = isset($_POST['bslms_nonce']) ? sanitize_text_field(wp_unslash($_POST['bslms_nonce'])) : '';

    
    $status_updated = true;

    $bslms_clientid = isset($_POST['bslms_clientid']) ? sanitize_text_field($_POST['bslms_clientid']) : '';
    if (empty($bslms_clientid)) {
        die('Client ID cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_clientid) && get_option('bslms_clientid') !== $bslms_clientid) {
        $status_updated = update_option('bslms_clientid', $bslms_clientid);
    }



    $bslms_teamid = isset($_POST['bslms_teamid']) ? sanitize_text_field($_POST['bslms_teamid']) : '';
    if (empty($bslms_teamid)) {
        die('Team ID cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_teamid) && get_option('bslms_teamid') !== $bslms_teamid) {
        $status_updated = update_option('bslms_teamid', $bslms_teamid);
    }



    $bslms_type = isset($_POST['bslms_type']) ? sanitize_text_field($_POST['bslms_type']) : '';
    if (empty($bslms_type)) {
        die('Type cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_type) && get_option('bslms_type') !== $bslms_type) {
        $status_updated = update_option('bslms_type', $bslms_type);
    }



    $bslms_button_label = isset($_POST['bslms_button_label']) ? sanitize_text_field($_POST['bslms_button_label']) : ''; 
    if (empty($bslms_button_label)) {
        die('Button label cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_button_label) && get_option('bslms_button_label') !== $bslms_button_label) {
        $status_updated = update_option('bslms_button_label', $bslms_button_label);
    }



    $bslms_button_font_size = isset($_POST['bslms_button_font_size']) ? sanitize_text_field($_POST['bslms_button_font_size']) : '';
    if (empty($bslms_button_font_size) && !is_numeric($bslms_button_font_size)) {
        die('Button font size cannot be empty and it sholud be numeric only'); // If empty, stop further processing
    }
    if ( !empty($bslms_button_font_size) && get_option('bslms_button_font_size') !== $bslms_button_font_size) {
        $status_updated = update_option('bslms_button_font_size', $bslms_button_font_size);
    } 

  
    $bslms_button_font_color = isset($_POST['bslms_button_font_color']) ? sanitize_text_field($_POST['bslms_button_font_color']) : '';
    if (empty($bslms_button_font_color)) {
        die('Button font color cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_button_font_color) && get_option('bslms_button_font_color') !== $bslms_button_font_color) {
        $status_updated = update_option('bslms_button_font_color', $bslms_button_font_color);
    } 


    $bslms_button_bg_color = isset($_POST['bslms_button_bg_color']) ? sanitize_text_field($_POST['bslms_button_bg_color']) : '';
    if (empty($bslms_button_bg_color)) {
        die('Button background color cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_button_bg_color) && get_option('bslms_button_bg_color') !== $bslms_button_bg_color) {
        $status_updated = update_option('bslms_button_bg_color', $bslms_button_bg_color);
    } 


    $bslms_button_font_hover_color = isset($_POST['bslms_button_font_hover_color']) ? sanitize_text_field($_POST['bslms_button_font_hover_color']) : '';
    if (empty($bslms_button_font_hover_color)) {
        die('Button font hover color cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_button_font_hover_color) && get_option('bslms_button_font_hover_color') !== $bslms_button_font_hover_color) {
        $status_updated = update_option('bslms_button_font_hover_color', $bslms_button_font_hover_color);
    } 
    

    $bslms_button_bg_hover_color = isset($_POST['bslms_button_bg_hover_color']) ? sanitize_text_field($_POST['bslms_button_bg_hover_color']) : '';
    if (empty($bslms_button_bg_hover_color)) {
        die('Button background hover color cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_button_bg_hover_color) && get_option('bslms_button_bg_hover_color') !== $bslms_button_bg_hover_color) {
        $status_updated = update_option('bslms_button_bg_hover_color', $bslms_button_bg_hover_color);
    } 
    
    $bslms_api_endpoint = isset($_POST['bslms_api_endpoint']) ? sanitize_text_field($_POST['bslms_api_endpoint']) : '';
    if (empty($bslms_api_endpoint)) {
        die('Api endpoint cannot be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_api_endpoint) && get_option('bslms_api_endpoint') !== $bslms_api_endpoint) {
        $status_updated = update_option('bslms_api_endpoint', $bslms_api_endpoint);
    }

    
    $bslms_api_secret_key = isset($_POST['bslms_api_secret_key']) ? sanitize_text_field($_POST['bslms_api_secret_key']) : '';
    if (empty($bslms_api_secret_key)) {
        die('Api secret key canont be empty'); // If empty, stop further processing
    }
    if ( !empty($bslms_api_secret_key) && get_option('bslms_api_secret_key') !== $bslms_api_secret_key) {
        $status_updated = update_option('bslms_api_secret_key', $bslms_api_secret_key);
    }


    if ($status_updated) {
        echo '<div class="notice notice-success is-dismissible">
            <p>'.esc_html__('The configurations are updated', 'brainstation-lms'). '</p>
        </div>';
    } else {
        echo '<div class="notice notice-error is-dismissible">
            <p>'.esc_html__('Unable to save cofigs', 'brainstation-lms'). '</p>
        </div>';
    }

}

$bslms_clientid = $bslms_teamid = $bslms_type = $bslms_button_label = $bslms_button_font_size = $bslms_button_font_color = $bslms_button_bg_color = $bslms_button_font_hover_color = $bslms_button_bg_hover_color = $bslms_api_endpoint = $bslms_api_secret_key = '';

if ( !empty(get_option('bslms_clientid')) ) {
    $bslms_clientid = get_option('bslms_clientid');
}
if ( !empty(get_option('bslms_teamid')) ) {
    $bslms_teamid = get_option('bslms_teamid');
}
if ( !empty(get_option('bslms_type')) ) {
    $bslms_type = get_option('bslms_type');
}
if ( !empty(get_option('bslms_button_label')) ) {
    $bslms_button_label = get_option('bslms_button_label');
}
if ( !empty(get_option('bslms_button_font_size')) ) {
    $bslms_button_font_size = get_option('bslms_button_font_size');
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
if ( !empty(get_option('bslms_api_endpoint')) ) {
    $bslms_api_endpoint = get_option('bslms_api_endpoint');
}
if ( !empty(get_option('bslms_api_secret_key')) ) {
    $bslms_api_secret_key = get_option('bslms_api_secret_key');
}

?>
<div class="wrap">
<h1><?php echo esc_html(__('Brainstation Details - Config', 'brainstation-lms')); ?></h1>
    <form action="" method="post" class="save_bslms_details_form">
    <?php 
        $bslms_nonce = wp_create_nonce("bslms_validation_nonce");
    ?>
                        <input type="hidden" name="bslms_nonce" id="bslms_nonce" value="<?php echo esc_attr($bslms_nonce);?>">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="bslms_clientid"><?php esc_html_e('Client id', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="text" autocomplete="off" name="bslms_clientid" class="regular-text" id="bslms_clientid" value="<?php echo esc_attr( $bslms_clientid ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_teamid"><?php esc_html_e('Team id', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="text" autocomplete="off" name="bslms_teamid" class="regular-text" id="bslms_teamid" value="<?php echo esc_attr( $bslms_teamid ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_type"><?php esc_html_e('Type', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <select name="bslms_type" id="bslms_type" class="regular-text">
                            <option value=""><?php echo esc_html__('Select', 'brainstation-lms'); ?></option>
                            <option value="publisher" <?php if($bslms_type=='publisher'){echo 'selected';}?>><?php echo esc_html__('Publisher', 'brainstation-lms'); ?></option>
                            <option value="biggerbrains" <?php if($bslms_type=='biggerbrains'){echo 'selected';}?>><?php echo esc_html__('Biggerbrains', 'brainstation-lms'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_button_label"><?php esc_html_e('Button label', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="text" autocomplete="off" name="bslms_button_label" class="regular-text" id="bslms_button_label" value="<?php echo esc_attr( $bslms_button_label ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_button_font_size"><?php esc_html_e('Button font size in px', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="number" autocomplete="off" name="bslms_button_font_size" class="regular-text" id="bslms_button_font_size" value="<?php echo esc_attr( $bslms_button_font_size ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_button_font_color"><?php esc_html_e('Button font color', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="color" autocomplete="off" name="bslms_button_font_color" class="regular-text" id="bslms_button_font_color" value="<?php echo esc_attr( $bslms_button_font_color ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_button_bg_color"><?php esc_html_e('Button background color', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="color" autocomplete="off" name="bslms_button_bg_color" class="regular-text" id="bslms_button_bg_color" value="<?php echo esc_attr( $bslms_button_bg_color ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_button_font_hover_color"><?php esc_html_e('Button font hover color', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="color" autocomplete="off" name="bslms_button_font_hover_color" class="regular-text" id="bslms_button_font_hover_color" value="<?php echo esc_attr( $bslms_button_font_hover_color ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_button_bg_hover_color"><?php esc_html_e('Button background hover color', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="color" autocomplete="off" name="bslms_button_bg_hover_color" class="regular-text" id="bslms_button_bg_hover_color" value="<?php echo esc_attr( $bslms_button_bg_hover_color ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_api_endpoint"><?php esc_html_e('Api endpoint', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="text" autocomplete="off" name="bslms_api_endpoint" class="regular-text" id="bslms_api_endpoint" value="<?php echo esc_attr( $bslms_api_endpoint ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bslms_api_secret_key"><?php esc_html_e('Api secret key', 'brainstation-lms') ?></label>
                    </th>
                    <td>
                        <input type="text" autocomplete="off" name="bslms_api_secret_key" class="regular-text" id="bslms_api_secret_key" value="<?php echo esc_attr( $bslms_api_secret_key ) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">

                    </th>
                    <td>
                        
                        <input type="button" name="validate_bslms_api" id="validate_bslms_api" class="button button-primary" value="<?php echo esc_attr(__('Validate Api Details', 'brainstation-lms')); ?>">

                        <p class="bslms_loader hide_bslms_loader"></p>
                    </td>
                </tr>
            </tbody>
        </table>
      
<input type="submit" name="save_sso" id="submit" class="button button-primary" value="<?php echo esc_attr(__('Save Configs', 'brainstation-lms')); ?>">

    </form>
</div>