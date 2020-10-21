<?php 
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	add_menu_page( 'Lightweb Media', 'Restrict Access', 'manage_options', 'myplugin/myplugin-admin-page.php', 'lwmedia_admin_page', 'dashicons-tickets', 6  );
}


function lwmedia_admin_page(){
    if (isset($_POST['lwmedia-save-options']) && check_admin_referer('lwmedia-save-options')) {
        update_post_meta( $_POST['membership_id'], '_forbidden_metafields', $_POST['forbidden_fields']  );
  

    }
    if (isset($_POST['lwmedia-save-memberships-options']) && check_admin_referer('lwmedia-save-memberships-options')) {
  $options_array = array();
  $options_array['text_field'] = $_POST['text_field'];
  $options_array['redirect_url'] = $_POST['redirect_url'];
  $options_array['creator_page_id'] = $_POST['creator_page_id'];
 // $options_array['membership_access'] = $_POST['membership_access'];

        update_memberships($options_array);

    } 
  
    if (isset($_POST['lwmedia-forbidden-listing-types']) && check_admin_referer('lwmedia-forbidden-listing-types')) {

        update_post_meta( $_POST['membership_id'], '_forbidden_listing_types', $_POST['forbidden_listing_types']  );
  

    }

    ?>

	<div class="wrap">

    <h2>Restrict MetaFields</h2>
    <div class="container">
   <?php $options = get_option('lightwebt_options_memberships'); ?>

<form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>">
<input type="hidden" value="true" name="lwmedia-save-memberships-options" />
<label for="url">Redirect Url</label><input type="url" value="<?php echo $options['redirect_url']?>" name="redirect_url" />
<label for="text_field">Text Field forbidden fields</label><input type="text" value="<?php echo $options['text_field']?>"  name="text_field" />
<label for="url">Creator Page ID</label><input type="text" value="<?php echo $options['creator_page_id']?>" name="creator_page_id" />
<!--
<select name="membership_access[]" id="metafields" multiple>
<?php //get_all_memberschips(); ?>
</select>
-->
<?php wp_nonce_field('lwmedia-save-memberships-options'); ?>
<?php submit_button(__('Update Settings')); ?>

</form>
</div>
<div class="lwadmin postbox-container" style="width: 100%;">

<?php 
$plans = wc_memberships_get_membership_plans();
//var_dump($plans);
foreach($plans as $plan){
    ?>
    <?php //var_dump ($id); ?>
    <div class="container">
 <?php echo get_the_title($plan->id)?>
 <div class="result">

<?php $forbidden_fields =  get_post_meta($plan->id,'_forbidden_metafields'); ?>

<?php foreach($forbidden_fields as $values): ?>

<?php if($values) echo implode(',',$values);?>
<php } ?>

<?php endforeach;?>
</div>
    <form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>">
<input type="hidden" value="true" name="lwmedia-save-options" />

<?php wp_nonce_field('lwmedia-save-options'); ?>
<input type="hidden" value="<?php echo $plan->id; ?>" name="membership_id" />
<select name="forbidden_fields[]" id="metafields" multiple>
<?php get_all_metafields(); ?>
</select>
<?php submit_button(__('Update forbidden Fields')); ?>

</form>
<form method="POST" action="<?php echo esc_html( admin_url('options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>">
<input type="hidden" value="true" name="lwmedia-forbidden-listing-types" />

<?php wp_nonce_field('lwmedia-forbidden-listing-types'); ?>
<input type="hidden" value="<?php echo $plan->id; ?>" name="membership_id" />
<select name="forbidden_listing_types[]" id="metafields" multiple>
<?php get_all_listing_types(); ?>
</select>
<?php submit_button(__('Update forbidden Listing_types')); ?>

</form>
</div>


    <?php
}

?>

<style>
.lwadmin {
    display:grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
}
</style>
<?php }
