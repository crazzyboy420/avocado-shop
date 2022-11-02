<div class="settings-warp sip-tab-content" style="margin-top:10px;">
  	<h2><?php _e('Settings' , 'sip-reviews-shortcode'); ?></h2>
  	<form method="post" action="options.php">
	  	<?php settings_fields( 'sip-rswc-settings-group' ); ?>
			<table>
				<tr>
					<td><input style="width:70px" id="sip-rswc-setting-limit-review-characters" type="number" name="sip-rswc-setting-limit-review-characters" value="<?php echo get_option('sip-rswc-setting-limit-review-characters'); ?>"  min="0"/></td>
					<td><?php _e('Limit review to number of characters. 0 mean complete review' , 'sip-reviews-shortcode');?></td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
</div>