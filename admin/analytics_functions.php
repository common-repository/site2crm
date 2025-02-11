<?php
defined( 'ABSPATH' ) or die( '::NO INDIRECT ACCESS ALLOWED::' );
/**
 * * Copyright (C) 2019  Site2CRM
 * 
 */

/** 
 * Lead update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function codex_lead_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['lead'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Lead updated.', 'site2crm.com' ),
		2  => __( 'Custom field updated.', 'site2crm.com' ),
		3  => __( 'Custom field deleted.', 'site2crm.com' ),
		4  => __( 'Lead updated.', 'site2crm.com' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Lead restored to revision from %s', 'site2crm.com' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Lead published.', 'site2crm.com' ),
		7  => __( 'Lead saved.', 'site2crm.com' ),
		8  => __( 'Lead submitted.', 'site2crm.com' ),
		9  => sprintf(
			__( 'Lead scheduled for: <strong>%1$s</strong>.', 'site2crm.com' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'site2crm.com' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Lead draft updated.', 'site2crm.com' )
	);

	if ( $post_type_object->publicly_queryable && 'lead' === $post_type ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View lead', 'site2crm.com' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview lead', 'site2crm.com' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}
/**
 * Register a lead post type.
 *
 */
function site2crm_cpt_init() {

    $labels = array(
        'name'               => _x( 'Leads', 'post type general name', 'site2crm.com' ),
        'singular_name'      => _x( 'Lead', 'post type singular name', 'site2crm.com' ),
        'menu_name'          => _x( 'Site2CRM Analytics', 'site2CRM-admin', 'site2crm.com' ),
        'name_admin_bar'     => _x( 'Lead', 'site2CRM-admin', 'site2crm.com' ),
        'add_new'            => null,
        'add_new_item'       => null,
        'new_item'           => null,
        'edit_item'          => null,
        'view_item'          => __( 'View Lead', 'site2crm.com' ),
        'all_items'          => __( 'Lead Analytics', 'site2crm.com' ),
        'search_items'       => __( 'Search Leads', 'site2crm.com' ),
        'parent_item_colon'  => __( 'Parent Leads:', 'site2crm.com' ),
        'not_found'          => __( 'No leads found.', 'site2crm.com' ),
        'not_found_in_trash' => __( 'No leads found in Trash.', 'site2crm.com' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Lead', 'site2crm.com' ),
		'public'             => false,
		'exclude_from_search'=> true,
		'publicly_queryable' => false,
		'show_in_nav_menus'  => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'lead' ),
		'capability_type' => 'post',
        'capabilities' => array(
            'create_posts' => false,
        ),
		'map_meta_cap' => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 22,
		'menu_icon'          => 'dashicons-rest-api',
		'supports'           => array( 'title', 'custom-fields', 'revisions' )
	);

	register_post_type( 'lead', $args );
    
}
/**
 * get permalinks to work when the plugin is activated
 */
function site2crm_rewrite_flush() {
    site2crm_cpt_init();
    flush_rewrite_rules();
}
/**
 * Determines which columns can be displayed for CPT 'lead'
 * @return type null
 */
function site2crm_edit_lead_columns() {
	return array(
		'cb'        => '&lt;input type="checkbox" />',
		'title'     => __( 'Company' ),
                'date'      => __( 'Last Edited' ),
		'firstname' => __( 'Name' ),
		'phone'     => __( 'Phone' ),
                'email'     => __( 'Email' ),
                'website'   => __( 'URL' ),
                'address'   => __( 'Street Address' ),
                'city'      => __( 'City' ),
                'state'     => __( 'State' ),
                'zip'       => __( 'Zip' ),
                'country'   => __( 'Country' ),
                'website'   => __( 'URL' ),
	);
}
/**
 * Determine how lead data columns will be displayed
 * @global type $post 'lead'
 * @param type $column Which column is being managed
 * @param type $post_id the id of the post being displayed
 */ 
function site2crm_manage_lead_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'firstname' :
			$first_name = get_post_meta( $post_id, 'firstname', true );
                        if ( empty( $first_name ) ){echo __( '' );}
                        else{echo __( $first_name ) ;}
                        break;
		case 'phone' :
			$phone = get_post_meta( $post_id, 'phone', true );
                        if ( empty( $phone ) ){echo __( '' );}
                        else{echo __( $phone ) ;}
                        break;
                case 'email' :
			$email = get_post_meta( $post_id, 'email', true );
                        if ( empty( $email ) ){echo __( '' );}
                        else{echo __( $email ) ;}
                        break;
                case 'website' :
			$website = get_post_meta( $post_id, 'website', true );
                        if ( empty( $website ) ){echo __( '' );}
                        else{echo __( $website ) ;}
                        break;     
                case 'address' :
			$address = get_post_meta( $post_id, 'address', true );
                        if ( empty( $address ) ){echo __( '' );}
                        else{echo __( $address ) ;}
                        break;   
                case 'city' :
			$city = get_post_meta( $post_id, 'city', true );
                        if ( empty( $city ) ){echo __( '' );}
                        else{echo __( $city ) ;}
                        break; 
                case 'state' :
			$state = get_post_meta( $post_id, 'state', true );
                        if ( empty( $state ) ){echo __( '' );}
                        else{echo __( $state ) ;}
                        break; 
                case 'zip' :
			$zip = get_post_meta( $post_id, 'zip', true );
                        if ( empty( $zip ) ){echo __( '' );}
                        else{echo __( $zip ) ;}
                        break; 
                case 'country' :
			$country = get_post_meta( $post_id, 'country', true );
                        if ( empty( $country ) ){echo __( '' );}
                        else{echo __( $country ) ;}
                        break; 
                case 'message' :
			$message = get_post_meta( $post_id, 'message', true );
                        if ( empty( $message ) ){echo __( '' );}
                        else{echo __( $message ) ;}
                        break; 
		default :break;
	}
}

