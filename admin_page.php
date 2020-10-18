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
  
        update_fobidden_metafields($_POST['memberschips']);

    } 
    
    ?>

	<div class="wrap">
		<h2>Restrict MetaFields</h2>
	</div>
    <ul>
	<?php
$result = get_all_meta_fields_from_cpt('job_listing');

?>
<ul style="width:30%;   float: left;">
<?php
$format = '<li>%s</li>';


foreach ($result as $value){
echo sprintf($format, $value);

} ?>

</ul>

<?php $forbidden_fields =  get_option ('lightwebt_options_forbidden_metafields'); ?>
<form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>" style="width:50%;   float: right;" id="usrform">
<input type="hidden" value="true" name="lwmedia-save-options" />
<?php wp_nonce_field('lwmedia-save-options'); ?>
<select name="metafields[]" id="metafields" multiple>
<?php get_all_metafields(); ?>
</select>

    <textarea id="forbidden_fields" name="forbidden_fields" form="usrform"><?php if($forbidden_fields): echo implode(',',$forbidden_fields ); endif?></textarea> 

    <input type="submit" value="Do it!" />

</form>
<?php $memberships =  get_option ('lightwebt_options_memberships'); ?>
<form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>" style="width:50%;   float: right;" id="usrform">
<input type="hidden" value="true" name="lwmedia-save-memberships-options" />
<?php wp_nonce_field('lwmedia-save-memberships-options'); ?>
<select name="memberschips[]" id="memberships" multiple>
<?php get_all_memberschips(); ?>
</select>

    <input type="submit" value="Do it!" />

</form>
<?php if($memberships): echo implode(',',$memberships ); endif?>
<?php }
