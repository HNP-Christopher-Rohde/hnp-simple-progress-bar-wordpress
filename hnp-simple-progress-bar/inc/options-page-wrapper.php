<div class="hnp_spb_wrap">
<style>#wpfooter {display: none !important;}</style>
	<div class="hnp_flex_container">
	   <div class="hnp_spb_icon">
		  <img src="<?php echo plugins_url('/img/hnp-logo.png', dirname(__FILE__)); ?>" alt="Plugin Icon">
	   </div>
	   <div class="hnp_flex_content">
		  <h2 class="hnp_spb_backend-heading"><?php echo esc_html__('HNP Simple Progress Bar', 'hnp-spb-textdomain'); ?></h2>
		  <?php echo hnp_spb_check_licence_key_status(); ?>
	   </div>
	</div>
   <?php settings_errors(); ?>
   <?php
   $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'plugin';
   ?>
   <div class="hnp_spb_nav-tab-wrapper">
		<div class="hnp-tab">
		   <h2><a href="?page=hnp_spb_options&tab=plugin" class="hnp-nav-tab <?php echo isset($active_tab) && $active_tab == 'plugin' ? 'hnp-nav-tab-active' : ''; ?>"><?php echo esc_html__('Plugin', 'hnp-spb-textdomain'); ?></a></h2>
		</div>
		<div class="hnp-tab">
		   <h2>
			  <a href="?page=hnp_spb_options&tab=other" class="hnp-nav-tab <?php echo isset($active_tab) && $active_tab == 'other' ? 'hnp-nav-tab-active' : ''; ?>"><?php echo esc_html__('Other', 'hnp-spb-textdomain'); ?></a>
		   </h2>
		</div>
   </div>
   <form id="featured_upload" method="post" action="">
      <?php
      if ($active_tab == 'plugin') {
         $options = get_option('hnp-spb-plugin-options-main');
         if (!is_array($options)) {
            $options = array();
         }
         if (!array_key_exists('hnp_spb_data_checked', $options)) {
            $options['hnp_spb_data_checked'] = '';
         }      		 
      ?>
		<input type="hidden" name="hnp_form_submitted_1" value="hnp_1">
		<?php echo hnp_spb_check_status_main(); ?>

		<div class="hnp-option-container hnp-option-spacing hnp_30_pro">
			<label for="activate">
			<strong><?php echo esc_html__('Enable the Function?', 'hnp-spb-textdomain'); ?></strong><?php echo hnp_spb_generate_hover_box(esc_html__('Enable the functionality of the Plugin.', 'hnp-spb-textdomain')); ?></label>
			<input name="hnp_spb_data_checked" type="checkbox" id="hnp_spb_data_checked" value="1" <?php checked($options['hnp_spb_data_checked'], 1); ?> onchange="toggleSecondCheckbox(this);" />
		</div>
			  		
		<div class="hnp-option-desc hnp-option-spacing">
			<h3><?php echo esc_html__('Options:', 'hnp-spb-textdomain'); ?></h3>
		</div>
				
		<div class="hnp-option-container hnp_30_pro">
			<label for="hnp_spb_data_color"><?php echo esc_html__('Color:', 'hnp-spb-textdomain'); ?><?php echo hnp_spb_generate_hover_box(esc_html__('Color. Default value = #e82c67.', 'hnp-spb-textdomain')); ?></label>
			<input type="text" name="hnp_spb_data_color" id="hnp_spb_data_color" value="<?php echo isset($options['hnp_spb_data_color']) ? esc_attr(sanitize_text_field($options['hnp_spb_data_color'])) : ''; ?>" placeholder="#e82c67" />
		</div>
						
		<div class="hnp-option-container hnp-option-spacing hnp_30_pro">
			<label for="hnp_spb_data_opacity">
				<?php echo esc_html__('Opacity:', 'hnp-spb-textdomain'); ?>
				<?php echo hnp_spb_generate_hover_box(esc_html__('The Opacity of the Progress Bar Color. 1 = 100% Opacity. 0.1 = 10% Opacity. Default Value = 0.7', 'hnp-spb-textdomain')); ?>
			</label>
			<input type="number" name="hnp_spb_data_opacity" id="hnp_spb_data_opacity" value="<?php echo !empty($_POST['hnp_spb_data_opacity']) ? esc_attr(floatval($_POST['hnp_spb_data_opacity'])) : (isset($options['hnp_spb_data_opacity']) ? esc_attr(floatval($options['hnp_spb_data_opacity'])) : '0.7'); ?>" placeholder="<?php echo esc_attr__('0.7', 'hnp-spb-textdomain'); ?>" min="0" max="1" step="0.1" />
		</div>

		<div class="hnp-option-container hnp-option-spacing-2 hnp_30_pro">
			<input class="hnp-button-primary" type="submit" name="hnp_form_submit_1" value="<?php echo esc_html__('Update/Save', 'hnp-spb-textdomain'); ?>" />
		</div>
	 							
       <?php } elseif ($active_tab == 'other') {
		$options = get_option('hnp-spb-plugin-options-other');?>
		
	    <input type="hidden" name="hnp_form_submitted_9" value="hnp_9">
		<p>
			<strong><?php echo esc_html__('Do you have any questions? Do you need a custom plugin or custom function for WordPress / WooCommerce? Send us an email:', 'hnp-spb-textdomain'); ?> <a href="mailto:info@Homepage-nach-Preis.de">info@Homepage-nach-Preis.de</a></strong>
		</p>
	  
		 <div class="info-container">
		 <div class="hnp-option-container hnp-option-spacing hnp_30_pro">
			<label for="hnp_spb_plugin_data_licence"><strong><?php echo esc_html__('Licence Key:', 'hnp-spb-textdomain'); ?></strong><?php echo hnp_spb_generate_hover_box(esc_html__('Your Licence Key.', 'hnp-spb-textdomain')); ?></label>
			<input type="text" name="hnp_spb_data_licence" id="hnp_spb_data_licence" value="<?php echo isset($options['hnp_spb_data_licence']) ? esc_attr(sanitize_text_field($options['hnp_spb_data_licence'])) : ''; ?>" placeholder="<?php echo esc_attr__('Licence Code', 'hnp-spb-textdomain'); ?>" />
		</div>
		
		<div class="hnp-option-desc hnp-option-spacing"><h3><?php echo esc_html__('Custom Style:', 'hnp-spb-textdomain'); ?></h3></div>
		<div class="hnp-option-container hnp_30_pro">
		   <label for="hnp_spb_plugin_data_custom_css"><strong><?php echo esc_html__('Custom Style CSS:', 'hnp-spb-textdomain'); ?></strong><?php echo hnp_spb_generate_hover_box(esc_html__('Enter your custom CSS code here.', 'hnp-spb-textdomain')); ?></label>
		   <textarea name="hnp_spb_data_custom_css" rows="8" id="hnp_spb_data_custom_css" placeholder="<?php echo esc_attr__('.example-class{color: #000;}', 'hnp-spb-textdomain'); ?>"><?php echo isset($options['hnp_spb_data_custom_css']) ? esc_textarea($options['hnp_spb_data_custom_css']) : ''; ?></textarea>
		</div>
		
		<div class="hnp-option-container hnp-option-spacing-2 hnp_30_pro">
			<input class="hnp-button-primary" type="submit" name="hnp_form_submit_9" value="<?php echo esc_html__('Update/Save', 'hnp-spb-textdomain'); ?>" />
		</div>
		<div class="hnp-option-desc hnp-option-spacing"><h3><?php echo esc_html__('Plugin Style:', 'hnp-spb-textdomain'); ?></h3></div>
		<table class="info-table">
		   <tr>
			  <th><?php esc_html_e('Area', 'hnp-spb-textdomain'); ?></th>
			  <th><?php esc_html_e('CSS-Class', 'hnp-spb-textdomain'); ?></th>
		   </tr>
		   <tr>
			  <td><?php esc_html_e('Main-Container', 'hnp-spb-textdomain'); ?></td>
			  <td>.hnp_top-progress-bar</td>
		   </tr>
		</table>
		</div>
		   </br></br><p style="text-align: right;"><?php echo esc_html__('HNP - Programming made with love in Germany.', 'hnp-spb-textdomain'); ?>
		   </p>
		</div>

      <?php } ?>
   </form>
</div>