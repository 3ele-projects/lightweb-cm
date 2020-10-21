<?php 
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	add_menu_page( 'Lightweb Media', 'Restrict Access', 'manage_options', 'myplugin/myplugin-admin-page.php', 'lwmedia_admin_page', 'dashicons-tickets', 6  );
}

function lwmedia_admin_page(){
    if (isset($_POST['lwmedia-save-options']) && check_admin_referer('lwmedia-save-options')) {
<<<<<<< HEAD
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
=======
        update_post_meta( $_POST['membership_id'], '_forbidden_metafields', $_POST['forbidden_fields']  );
  
>>>>>>> 78e1ce1ac32491888cbbc225a8d3e2c674ff6556

    }
    if (isset($_POST['lwmedia-save-memberships-options']) && check_admin_referer('lwmedia-save-memberships-options')) {
  $options_array = array();
  $options_array['text_field'] = $_POST['text_field'];
  $options_array['redirect_url'] = $_POST['redirect_url'];
  $options_array['membership_access'] = $_POST['membership_access'];

        update_memberships($options_array);

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
<select name="membership_access[]" id="metafields" multiple>
<?php get_all_memberschips(); ?>
</select>
<?php wp_nonce_field('lwmedia-save-memberships-options'); ?>
<?php submit_button(__('Update Settings')); ?>

</form>
</div>
<<<<<<< HEAD
<div class="result">
<h3>Restricted Metafields:</h3>

</div>
</div>
-->
<?php $forbidden_fields =  get_option ('lightwebt_options_forbidden_metafields'); ?>

<?php var_dump($forbidden_fields);?>
=======
<div class="lwadmin postbox-container" style="width: 100%;">

>>>>>>> 78e1ce1ac32491888cbbc225a8d3e2c674ff6556
<?php 
$plans = wc_memberships_get_membership_plans();
//var_dump($plans);
foreach($plans as $plan){
    ?>
<<<<<<< HEAD
 <?php echo get_the_title($id)?>

=======
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
>>>>>>> 78e1ce1ac32491888cbbc225a8d3e2c674ff6556
    <form method="POST" action="<?php echo esc_html( admin_url( 'options-general.php?page=myplugin%2Fmyplugin-admin-page.php' ) );?>">
<input type="hidden" value="true" name="lwmedia-save-options" />

<?php wp_nonce_field('lwmedia-save-options'); ?>
<<<<<<< HEAD
<input type="hidden" value="<?php echo $id->ID; ?>" name="membership_id" />
=======
<input type="hidden" value="<?php echo $plan->id; ?>" name="membership_id" />
>>>>>>> 78e1ce1ac32491888cbbc225a8d3e2c674ff6556
<select name="forbidden_fields[]" id="metafields" multiple>
<?php get_all_metafields(); ?>
</select>
<?php submit_button(__('Update forbidden Fields')); ?>

</form>
<<<<<<< HEAD
<?php foreach($forbidden_fields[$id->ID] as $values): ?>

<?php foreach($values as $field){
    echo $field;
}

;?>
<?php endforeach;?>
    <?php
}
?><?php }
=======
</div>


    <?php
}

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5f8f51bd202d6',
        'title' => 'test',
        'fields' => array(
            array(
                'key' => 'field_5f8f51c345df0',
                'label' => 'z',
                'name' => 't',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => '',
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                    2 => 'taxonomy',
                ),
                'elements' => '',
                'min' => '',
                'max' => '',
                'return_format' => 'object',
            ),
            array(
                'key' => 'field_5f8f539752b2b',
                'label' => 'kjlj',
                'name' => 'kjljkjhk',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
    endif;
?>

<style>
.lwadmin {
    display:grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
}
</style>
<?php }
>>>>>>> 78e1ce1ac32491888cbbc225a8d3e2c674ff6556
