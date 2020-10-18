<?php
/**
 * Plugin Name:     Lightweb Cm
 * Plugin URI:      www.lightweb-media.de
 * Description:     Restrict Access to Metafields
 * Author:          Sebastian Weiss
 * Author URI:      www.lightweb-media.de
 * Text Domain:     lightweb-cm
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Lightweb_Cm
 */

// Your code starts here.


include( plugin_dir_path( __FILE__ ) . 'admin_page.php');




function update_fobidden_metafields($metafields){
  //  $metafields_array = explode(",", $metafields_string);
    update_option('lightwebt_options_forbidden_metafields', '');
    update_option('lightwebt_options_forbidden_metafields', $metafields);
}

function update_memberships($memberships){
   // $memberships_array = explode(",", $memberships_string);
    update_option('lightwebt_options_memberships', '');
    update_option('lightwebt_options_memberships', $memberships);
}



function get_all_meta_fields_from_cpt($cpt){
    $posts = get_posts(array(
        'post_type'   => $cpt,
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_key'		=> '_case27_listing_type',
        'meta_value'	=> 'tender'
        )

    );

    //loop over each post
$meta_keys = array();

    foreach($posts as $post_id){
    //   var_dump (get_post_meta($post_id, '_short-description'));
        $result = build_postmeta_key_array($post_id);
        foreach ($result as $key => $value){
     
            if (!in_array ( $value['meta_key'] , $meta_keys)){
                $meta_keys[] = $value['meta_key']; 
    
            }
        }
    
    }
    return $meta_keys; 
}

function build_postmeta_key_array($post_id){
    global $wpdb;
    $results = $wpdb->get_results( "SELECT meta_key FROM {$wpdb->prefix}postmeta WHERE post_id = '.$post_id.'", ARRAY_A );
        return $results;
}

function check_if_user_id_is_in_groups ($user_id){

    $memberships =  get_option ('lightwebt_options_memberships');
      $membership_id = get_active_members_for_membership($user_id)[0];
  
      if (in_array ( $membership_id['ID'] ,  $memberships)){
          return 'More information is only visible in the Gold and Platinum membership.';
      } else {
          return false;
      }


    }

function get_all_metafields(){

$result = get_all_meta_fields_from_cpt('job_listing');

$format = ' <option value="%s">%s</option>';

foreach ($result as $value){
echo sprintf($format, $value, $value);

} 
}

function get_active_members_for_membership($user_id){
    global $wpdb;

    // Getting all User IDs and data for a membership plan
    return $wpdb->get_results( "
        SELECT DISTINCT  p2.ID
        FROM {$wpdb->prefix}posts AS p
        LEFT JOIN {$wpdb->prefix}posts AS p2 ON p2.ID = p.post_parent
        LEFT JOIN {$wpdb->prefix}users AS u ON u.id = p.post_author
        LEFT JOIN {$wpdb->prefix}usermeta AS um ON u.id = um.user_id
        WHERE p.post_type = 'wc_user_membership'
        AND p.post_author = $user_id
        AND p.post_status IN ('wcm-active')
        AND p2.post_type = 'wc_membership_plan'  
    ", ARRAY_A);
}


function get_all_memberschips(){

    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'wc_membership_plan'
      );
      
      
      $posts = get_posts( $args );
    //  $format = ' <option value="%d">%s</option>';
      foreach ($posts as $post){

      //  echo sprintf($format, $post->ID, $post->post_title);

      }
      return $posts;

}


function getpostmeta_filter($metadata, $object_id, $meta_key, $single){
   // var_dump(get_post_meta(get_the_ID(), '_case27_listing_type'));

    $forbidden_fields =  get_option ('lightwebt_options_forbidden_metafields');

    if(($forbidden_fields) && (!is_admin())){
    if (in_array ( $meta_key , $forbidden_fields)){
       $user_id = get_current_user_id();

       if(check_if_user_id_is_in_groups ($user_id)){
          return check_if_user_id_is_in_groups($user_id);
       };
        
    }
} else {
    return $metadata;
} 

}





function remove_post_with_empty_body ( $post ) {
  $var =  get_post_meta($post->ID, '_case27_listing_type') ;   

    if($var == 'tender'){
    
        add_filter( 'get_post_metadata', 'getpostmeta_filter', 100, 4 ); 
    }

    }
add_action('the_post', 'remove_post_with_empty_body');

