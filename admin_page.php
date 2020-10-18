<?php 
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	add_menu_page( 'Lightweb Media', 'Restrict Access', 'manage_options', 'myplugin/myplugin-admin-page.php', 'lwmedia_admin_page', 'dashicons-tickets', 6  );
}

function lwmedia_admin_page(){


    if (isset($_POST['lwmedia-save-options']) && check_admin_referer('lwmedia-save-options')) {
       
        update_fobidden_metafields($_POST['forbidden_fields']);

    }
    if (isset($_POST['lwmedia-save-memberships-options']) && check_admin_referer('lwmedia-save-memberships-options')) {
  
        update_memberships($_POST['memberschips']);

    } 
    
    ?>

	<div class="wrap">

    <h2>Restrict MetaFields</h2>

<div class="lwadmin postbox-container" style="display:grid; width: 100%;">
<!--
<div class="postbox">
<div class="inputforms">

<form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>">
<input type="hidden" value="true" name="lwmedia-save-options" />
<?php wp_nonce_field('lwmedia-save-options'); ?>
<select name="forbidden_fields[]" id="metafields" multiple>
<?php get_all_metafields(); ?>
</select>
<?php submit_button(__('Update forbidden Fields')); ?>

</form>
</div>
<div class="result">
<h3>Restricted Metafields:</h3>
<?php $forbidden_fields =  get_option ('lightwebt_options_forbidden_metafields'); ?>
<?php if($forbidden_fields): 
   foreach ($forbidden_fields as $field):?>

   <?php echo $field;?>
   <?php endforeach;?>
   <?php  endif?>
</div>
</div>
-->
<?php 
$memberships = get_all_memberschips();
foreach($memberships as $id){
    ?>
 <?php echo get_the_title($id)?>
    <form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>">
<input type="hidden" value="true" name="lwmedia-save-options" />
<?php wp_nonce_field('lwmedia-save-options'); ?>
<select name="forbidden_fields[]" id="metafields" multiple>
<?php get_all_metafields(); ?>
</select>
<?php submit_button(__('Update forbidden Fields')); ?>

</form>
    <?php
}
?>
<div class="postbox">

<div class="inputforms">
<form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>" id="usrform">
<input type="hidden" value="true" name="lwmedia-save-memberships-options" />
<?php wp_nonce_field('lwmedia-save-memberships-options'); ?>
<select name="memberschips[]" id="memberships" multiple>
<?php get_all_memberschips(); ?>
</select>

<?php submit_button(__('Update forbidden Memberships')); ?>

</form>
</div>
<div class="result">
<?php $memberships =  get_option ('lightwebt_options_memberships'); ?>
<h3>Restrict Metafields for Memberships:</h3>
<?php if($memberships): 
   foreach ($memberships as $id):?>

   <?php echo get_the_title($id);?>
   <?php endforeach;?>
   <?php  endif?>
</div>
</div>
</div>
<style>
.lwadmin .postbox {
    min-height:25vh;
    padding:20px;
    display:flex;
}
</style>
<?php }

/*
TEST1234@test
*/
