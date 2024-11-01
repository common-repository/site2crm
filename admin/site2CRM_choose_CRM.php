<?php
/* Copyright (C) 2019  Site2CRM*/
defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );
echo '<div class="wrap"></br>';
include 'site2CRM_logo.php';
echo '<h1>Site2CRM Admin Panel - Choose your CRM from the list below...</h1></br>';
echo '<hr>';
echo '<h3>Your Current CRM: <b style="text-transform:capitalize;">'.get_option('site2CRM_user_CRM').'</b></h3>';
echo '<hr></br>';
echo '<form method="POST" action="options.php">';
settings_fields('site2CRM_choose_crm_options_group');
echo '<input type="radio" class="site2crm-choose-crm-radio" name="site2CRM_user_CRM" value="nutshell"><img alt="" id="site2crm-choose-crm-image-nutshell" src="https://site2crm.com/wp-content/uploads/2019/07/nutshell_logo_long.png" ></img></br>';
echo '</br><hr></br>';
echo '<input type="radio" class="site2crm-choose-crm-radio" name="site2CRM_user_CRM" value="pipedrive"><img alt="" id="site2crm-choose-crm-image-pipedrive" src="https://site2crm.com/wp-content/uploads/2019/07/pipedrive_logo_long.png" ></img></br>';
echo '</br><hr>';
echo '<input type="radio" class="site2crm-choose-crm-radio" name="site2CRM_user_CRM" value="hubspot"><img alt="" id="site2crm-choose-crm-image-hubspot"  src="https://site2crm.com/wp-content/uploads/2019/07/hubspot_logo_long.png" ></img></br>';
echo '</br><hr>';
do_settings_sections( 'site2CRM_choose_crm_options_group' );
submit_button('Update Your CRM');
echo '</form>';
echo '</div>';
function pippin_contextual_help($contextual_help, $screen_id, $screen) {	
	ob_start(); ?>
	<h3>Help Section Title</h3>
	<p>This is text that provides helpful information</p>
	<?php
	return ob_get_clean();
}
if (isset($_GET['page']) && $_GET['page'] == 'site2CRM-admin') 
{
	add_action('contextual_help', 'pippin_contextual_help', 10, 3);
}