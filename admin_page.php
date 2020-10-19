<?php 
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	add_menu_page( 'Lightweb Media', 'Restrict Access', 'manage_options', 'myplugin/myplugin-admin-page.php', 'lwmedia_admin_page', 'dashicons-tickets', 6  );
}

function lwmedia_admin_page(){
    if (isset($_POST['lwmedia-save-options']) && check_admin_referer('lwmedia-save-options')) {
        $current_options = get_option ('lightwebt_options_forbidden_metafields');
            if ($current_options):
            if (array_key_exists($_POST['membership_id'],$current_options)) {
                $current_options[$_POST['membership_id']] =  $_POST['forbidden_fields'];
            } else {
                $options = array(
                    $_POST['membership_id'] => $_POST['forbidden_fields'],
                   );
                   array_push($current_options,$options);   
            }
       
       //var_dump($options);
     //  
        else:
            $options = array(
                $_POST['membership_id'] => $_POST['forbidden_fields'],
               );
            $current_options =  array();
            array_push($current_options,$options);  
        endif;

        update_fobidden_metafields($current_options);

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

</div>
</div>
-->
<?php $forbidden_fields =  get_option ('lightwebt_options_forbidden_metafields'); ?>

<?php var_dump($forbidden_fields);?>
<?php 
$memberships = get_all_memberschips();
foreach($memberships as $id){
    ?>
 <?php echo get_the_title($id)?>

    <form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>">
<input type="hidden" value="true" name="lwmedia-save-options" />

<?php wp_nonce_field('lwmedia-save-options'); ?>
<input type="hidden" value="<?php echo $id->ID; ?>" name="membership_id" />
<select name="forbidden_fields[]" id="metafields" multiple>
<?php get_all_metafields(); ?>
</select>
<?php submit_button(__('Update forbidden Fields')); ?>

</form>
<?php foreach($forbidden_fields[$id->ID] as $values): ?>

<?php foreach($values as $field){
    echo $field;
}

;?>
<?php endforeach;?>
    <?php
}
?><?php }