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

function check_if_user_id_is_in_groups ($user_id, $plan_id){
    $user_id = 88;
    $active_membership = wc_memberships_get_user_memberships( $user_id);

    if($plan_id == $active_membership[0]->plan_id){
return true;
    }
    else {
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
     $format = ' <option value="%d">%s</option>';
      foreach ($posts as $post){

        echo sprintf($format, $post->ID, $post->post_title);

      }
      return $posts;

}


function getpostmeta_filter($metadata, $object_id, $meta_key, $single){

    global $fb_fields;
    global $plan_id;


    if(($fb_fields) && (!is_admin())){
    if (in_array ( $meta_key , $fb_fields)){
        //   var_dump($fb_fields);
           $user_id = get_current_user_id();
           $user_id = 88;
          if(check_if_user_id_is_in_groups ($user_id, $plan_id)){
     $options = get_option('lightwebt_options_memberships'); 
$text = '<strong style="color:red;">'.$options['text_field'].'</strong>';
return $text;
          } else {
            return $metadata;
        } 
    }
} else {
    return $metadata;
} 

}

<<<<<<< HEAD
=======

>>>>>>> 78e1ce1ac32491888cbbc225a8d3e2c674ff6556
add_action( 'pre_get_posts', 'modify_access_to_pages' );

// Create a function to excplude some categories from the main query
function modify_access_to_pages( $query ) {
    if ( ! is_admin() && $query->is_main_query()  ){
<<<<<<< HEAD
        if($query->query['listing_type']){
            //var_dump($query);
            $url = '../membership/';
           $user_id = get_current_user_id();
           $user_id = 88;
            $args = array( 
                'status' => array( 'active', 'complimentary', 'pending' ),
            );  
            
            $active_memberships = wc_memberships_get_user_memberships( $user_id);

       
     
            if ($user_id == 88){
             //   wp_redirect( $url );
//exit;
            }
        }
return $query;
    }
}


=======
        $user_id = 88;

    $active_memberships = wc_memberships_get_user_memberships( $user_id);
    global $plan_id;
    $plan_id =  $active_memberships[0]->plan_id;
    $forbidden_fields =  get_post_meta($plan_id,'_forbidden_metafields');
    global $fb_fields;

    $fb_fields = $forbidden_fields[0];
    if($fb_fields):
     add_filter('get_post_metadata', 'getpostmeta_filter', 10, 4);
       
    endif;


  
        if(isset($query->query['listing_type'])){
            if($query->query_vars['listing_type'] == 'tender'){
                $options = get_option('lightwebt_options_memberships'); 
$membership_ids = $options['membership_access'];
$url = $options['redirect_url'];
if (!in_array ( $plan_id , $membership_ids)){
    wp_redirect( $url );
    exit;
}
            }
>>>>>>> 78e1ce1ac32491888cbbc225a8d3e2c674ff6556

           
        } 	 
    
return $query;
    }
}
