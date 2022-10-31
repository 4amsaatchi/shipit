<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */

add_filter( 'wpc_email_meta_tags', 'custom_additional_email_meta_tags' );
function custom_additional_email_meta_tags( $tags ){
    $tags['{location}'] = 'MENSAJE DESDE PHP';
    return $tags;
}

function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );


/* Agregar titulo en automatico a los posts */
function save_post_func_2134( $post_id ) {
     
    $post_type = 'encomienda'; //Change your post_type here
     
    if ( $post_type == get_post_type ( $post_id ) ) {  //Check and update for the specific $post_type
         
        $my_post = array(
            'ID'           => $post_id,
            'post_title' => $post_type . ' ' . $post_id //Construct post_title 
        );
 
        remove_action('save_post', 'save_post_func_2134'); //Avoid the infinite loop
 
        // Update the post into the database
        wp_update_post( $my_post );     
         
    }
}
add_action( 'save_post', 'save_post_func_2134' );


// Codigo para modificar alias luego de creación de usuario
// Definir $tuser en base a $userid, apellido y departamento seleccionado. 
function cambiar_datos_del_usuario($userid){
	//Esperar que se popule el usermeta completo o bastantito
	sleep(3);
    $tuser = get_user_by('ID', $userid);
    $nickname = get_user_meta($userid, 'nickname', true);
	$departamento = get_user_meta($userid, 'user_registration_select_1644783744', true);
	
// Modificar las variables con inforamci[]	
	
	$tuser->data->user_nicename = $tuser->data->user_nicename . $tuser->data->ID . "-" . "BOX" ;
    $tuser->data->display_name = $tuser->data->user_nicename . "-" . $tuser->data->ID . "-" . "BOX" ;
   
	$nickname = $nickname . "-" . "BOX" . $userid;
	
      wp_update_user($tuser->data);
	  update_user_meta($userid,"last_name", $nickname);
// Tests varios	
//     echo "<pre>";
 //    var_dump($last_name);
  //   die("si estoy llegando aqui");
}
    
add_action( 'user_register', 'cambiar_datos_del_usuario' );
// // termina aqui  el codigo para modificar alias luego de creacion de usuario */

/*
add_filter( 'wpc_email_meta_tags', 'custom_additional_email_meta_tags' );
function custom_additional_email_meta_tags( $tags ){
    $tags['{test}'] = 'MENSAJE DESDE PHP';
    return $tags;
}*/




add_filter( 'wpcargo_package_fields', 'wpcargo_package_add_fields_callback' );
function wpcargo_package_add_fields_callback( $package_fields){
  //Add fields
  $package_fields['imagen_paquete'] = array(
    'label' => __('Imagen paquete', 'wpcargo'),
    'field' => 'text',
    'required' => false,
     'class' => array('imagen_paquetes'),
    'label_class' => array('imagen_paquetesv2')
  );
  $package_fields['store'] = array(
    'label' => __('Tienda', 'wpcargo'),
    'field' => 'text',
    'required' => false,
    'options' => array()
  );  
  $package_fields['tracking'] = array(
    'label' => __('Tracking', 'wpcargo'),
    'field' => 'text',
    'required' => false,
    'options' => array()
  );  
  return $package_fields;
}


function template_consolidar($idenvio){

    $status = get_post_meta($postid, 'status', true);
    if ($status == "SUS PAQUETES ESTAN SIENDO CONSOLIDADOS"){
        $a = "<h1><a href='link'>Consolidar pedido #".$idenvio."</a></h1>";
    }
     
    return $a;
}


// I'm using an anonymous function for brevity.
add_action( 'admin_enqueue_scripts', function() {
    wp_enqueue_script( 'handle', get_stylesheet_directory_uri(). '/customadmin.js?v=bv2v' );
} );

// Ajax action to refresh the user image
add_action( 'wp_ajax_myprefix_get_image', 'myprefix_get_image'   );
function myprefix_get_image() {
    if(isset($_GET['id']) ){
        $image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array( 'id' => 'preview'.$_GET['campo'] ) );
        $data = array(
            'image'    => $image,
        );
        wp_send_json_success( $data );
    } else {
        wp_send_json_error();
    }
}