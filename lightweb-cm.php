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




function update_fobidden_metafields($metafields_string){
    $metafields_array = explode(",", $metafields_string);
    update_option('lightwebt_options_forbidden_metafields', '');
    update_option('lightwebt_options_forbidden_metafields', $metafields_array);
}

function update_memberships($memberships_string){
    $memberships_array = explode(",", $memberships_string);
    update_option('lightwebt_options_memberships', '');
    update_option('lightwebt_options_memberships', $memberships_array);
}



function get_all_meta_fields_from_cpt($cpt){
    $posts = get_posts(array(
        'post_type'   => $cpt,
        'posts_per_page' => -1,
        'fields' => 'ids'
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

    $args = array(
        'author'        =>  $user_id, 
        'orderby'       =>  'post_date',
        'order'         =>  'ASC',
        'posts_per_page' => -1,
        'post_type' => 'wc_user_membership'
      );
      
      
      $current_user_posts = get_posts( $args );

    }

function  get_all_metafields(){

$result = get_all_meta_fields_from_cpt('job_listing');

$format = ' <option value="%s">%s</option>';

foreach ($result as $value){
echo sprintf($format, $value);
var_dump($value);

} 
}


function get_all_memberschips (){

    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'wc_membership_plan'
      );
      
      
      $posts = get_posts( $args );
      $format = ' <option value="%d">%s</option>';
      foreach ($posts as $post){

        echo sprintf($format, $post->ID, $post->post_title);

      }

}


function getpostmeta_filter($metadata, $object_id, $meta_key, $single){
    $forbidden_fields =  get_option ('lightwebt_options_forbidden_metafields');

    if(($forbidden_fields) && (!is_admin())){
    if (in_array ( $meta_key , $forbidden_fields)){
        var_dump(get_current_user_id());

        return 'nur für Premium User sichtbar';
    }
} else {
    return $metadata;
} 



}

add_filter( 'get_post_metadata', 'getpostmeta_filter', 100, 4 );



