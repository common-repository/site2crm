<?php
/* Copyright (C) 2019  Site2CRM*/
defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );
if((int)get_option('Site2CRM_upload_limit')>30){
    echo '<div class="notice notice-success is-dismissible" style="background:#efefef">
        <p><strong>Hello! We created 30 leads in your CRM this month.</strong></p>
        <p>Could you please do me a BIG favor and give Site2CRM a five star rating on WordPress?
                <a style="background:#FFA500;color:#fff;padding: 1px 1px;" 
                href="https://wordpress.org/support/plugin/site2crm/reviews/#new-post" target=_BLANK>Write a Review.</a> 
                </br></br> <a style="margin-left:3em;;text-transform:capitalize; font-size:1.5em; text-decoration:none; background:#FFA500; color:#fff; padding:1px 1px;" href="https://www.site2crm.com/pro" 
                target=_BLANK>GO PRO for Unlimited Lead Creation in '.get_option('site2CRM_user_CRM').'!</a> 
        </p></div>';
}
echo '<img style="position:fixed; right:6vw; bottom:4vh; height:10%;" alt="Site2CRM" src="https://site2crm.com/wp-content/uploads/2019/07/Site2CRM-Logo.png" ></img>';
