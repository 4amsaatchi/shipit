<?php
/*
Plugin Name: Wp Cargo Shipit
Description: Proporciona nuevas funcionalidades al plugin Wp cargo
Version: 1
Author: Julián Andrés Escobar Herrera*/

define('ROOTWPSHIPIT', plugin_dir_path(__FILE__));
require_once(ROOTWPSHIPIT . '/functions/functionscliente.php');

function consolidar_pedido(){
		if ( is_user_logged_in() ) {
		ob_start();		
		include('views/templateconsolidar.php');    
		$template = ob_get_contents();
	    ob_get_clean(); 
	    return $template;   
		}	
}


add_shortcode('wpshipit_consolidar', 'consolidar_pedido');



function form_preentregas(){
		if ( is_user_logged_in() ) {
		ob_start();		
		include('views/templateformpreentregas.php');    
		$template = ob_get_contents();
	    ob_get_clean(); 
	    return $template;   
		}	
}


add_shortcode('wpshipit_preentregas', 'form_preentregas');


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
   $package_fields['factura'] = array(
    'label' => __('Factura', 'wpcargo'),
    'field' => 'text',
    'required' => false,
    'options' => array()
  );
    $package_fields['fechaestimada'] = array(
    'label' => __('Fecha estimada', 'wpcargo'),
    'field' => 'text',
    'required' => false,
    'options' => array()
  );
  return $package_fields;
}


function botonconsolidareemail($idenvio){

	$a = "";
    $status = get_post_meta($idenvio, 'wpcargo_status', true);
    $nombrepedido = get_post_meta($idenvio, 'post_name', true);
    if ($status == "SU ENVIO ESTA SIENDO CONSOLIDADO"){
        $a = "<h1 style='text-align: center'><a href='".site_url("/consolidar-pedido")."' style='background:#000;color:#fff;font-size: 16px;padding: 25px;text-decoration: none;'>Consolidar pedido #".$nombrepedido."</a></h1>";
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

/* Shortcodes 
	wp_cargo_btnconsolidar
	wpcargoshipit_packages
*/
function emailbodyshipit($idorder, $emailbody){
	$newemailbody = str_replace("{wp_cargo_btnconsolidar}",botonconsolidareemail($idorder),$emailbody);
	$newemailbody = str_replace("{wpcargoshipit_packages}",packages_list($idorder),$newemailbody);

	return $newemailbody;
}

function packages_list($idorder){
 	
	$paquetes = get_post_meta($idorder, 'wpc-multiple-package', true); 
	$html = '<table class="table wpcargo-table" style="width:100%;">
		<thead>
			<tr>
														<th>Cant.</th>
														<th>Tipo de pieza</th>
														<th>Descripción</th>
														<th>Peso (lbs)</th>
														<th>Imagen paquete</th>
														<th>Tienda</th>
														<th>Tracking</th>
							</tr>
		</thead>
		<tbody>';

	foreach ($paquetes as $paquete): 
		$html .= '<tr class="package-row">';
			$html .= "<td>".$paquete["wpc-pm-qty"]."</td>";			               
			$html .= "<td>".$paquete["wpc-pm-piece-type"]."</td>";					            
			$html .= "<td>".$paquete["wpc-pm-description"]."</td>";					               				            
			$html .= "<td>".$paquete["wpc-pm-weight"]."</td>";								               
			$html .= "<td class='colimagepa'><img src='".wp_get_attachment_image_src($paquete["imagen_paquete"])[0]."'></td>";					               					            
			$html .= "<td>".$paquete["store"]."</td>";					               					            
			$html .= "<td>".$paquete["tracking"]."</td>";
	    $html .= '</tr>';
	 endforeach;

	 $html .= '</tbody></table>' ;

	 return $html;
}



// Our custom post type function
function create_posttype() {
  
    register_post_type( 'preentregas',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Pre-entregas' ),
                'singular_name' => __( 'Preentrega' )
            ),
            'public' => true,
            'has_archive' => true,            
            'rewrite' => array('slug' => 'preentregas'),
            'show_in_rest' => true,            
            'supports' => array( 'title', 'editor', 'custom-fields' )
  
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );



function get_listado_preentregas(){	
	include('views/templatelistadopreentregas.php');    
}


add_action('admin_menu','menu_preentregas');
function menu_preentregas() {
	
	//this is the main item for the menu
	add_menu_page('Pre-entregas', //page title
	'Pre-entregas', //menu title
	'manage_options', //capabilities
	'get_listado_preentregas', //menu slug
	'get_listado_preentregas' //function
	);
	


}


function remove_menu () 
{
   remove_menu_page('edit.php?post_type=preentregas');
} 

add_action('admin_menu', 'remove_menu');

   