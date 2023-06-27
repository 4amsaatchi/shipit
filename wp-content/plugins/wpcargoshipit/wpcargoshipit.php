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

function form_preentregas2(){
        if ( is_user_logged_in() ) {
        ob_start();     
        include('views/templateformpreentregas2.php');    
        $template = ob_get_contents();
        ob_get_clean(); 
        return $template;   
        }   
}


add_shortcode('wpshipit_preentregas2', 'form_preentregas2');


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
 $package_fields['carrier'] = array(
    'label' => __('Carrier', 'wpcargo'),
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
    wp_enqueue_script( 'handle', get_stylesheet_directory_uri(). '/customadmin.js?v=b2' );
     wp_localize_script( 'handle', 'ajax_var', array(
        'url'    => admin_url( 'admin-ajax.php' ),
        'nonce'  => wp_create_nonce( 'my-ajax-nonce' ),
        'action' => 'cargarcarriers'
    ) );
} );

// Ajax action to refresh the user image
add_action( 'wp_ajax_myprefix_get_image', 'myprefix_get_image'   );
function myprefix_get_image() {
    if(isset($_GET['id']) ){
    	$tipo = "imagen";
        $image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array( 'id' => 'preview'.$_GET['campo'] ) );
        if (!$image){
        	$image = wp_get_attachment_url($_GET['id']);
        	$tipo = "pdf";
        }
        if (isset($_GET['tipoimg']) == "urlimagen"){
        	$image = wp_get_attachment_url($_GET['id']);
        	$tipo = "pdf";
        }
        $data = array(
            'image'    => $image,
            'tipo'     => $tipo
        );


        wp_send_json_success( $data );
        
    } else {
        wp_send_json_error("ERROR");
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
	$html = '<table class="table wpcargo-table" style="width:100%;"><thead><tr><th style="width: 25%; text-align:center">Descripción</th><th style="width: 25%: text-align:center">Imagen paquete</th><th style="width: 25%; text-align:center">Tienda</th><th style="width: 25%; text-align:center">Tracking</th></tr></thead><tbody>';

	foreach ($paquetes as $paquete): 
		$html .= '<tr class="package-row">';
			/*$html .= "<td>".$paquete["wpc-pm-qty"]."</td>";			               
			$html .= "<td>".$paquete["wpc-pm-piece-type"]."</td>";					            */
			$html .= "<td style='width: 25%; text-align:center'>".$paquete["wpc-pm-description"]."</td>";					               				            
			/*$html .= "<td>".$paquete["wpc-pm-weight"]."</td>";*/
			if ($paquete["imagen_paquete"] != ""){			               
			$html .= "<td style='width: 25%; text-align:center' class='colimagepa'><img src='".wp_get_attachment_image_src($paquete["imagen_paquete"])[0]."'></td>";					               					            
			} else {
			$html .= "<td style='width: 25%; text-align:center' class='colimagepa'></td>";					               					            	
			}
			$html .= "<td style='width: 25%; text-align:center'>".$paquete["store"]."</td>";					               					            
			$html .= "<td style='width: 25%; text-align:center'>".$paquete["tracking"]."</td>";
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
	add_menu_page('Notificaciones', //page title
	'Notificaciones', //menu title
	/*array('cargo_agent','wpcargo_employee'), //capabilities
	//'read',*/
	'manage_options',
	'get_listado_preentregas', //menu slug
	'get_listado_preentregas' //function
	);
	


}


function remove_menu () 
{
   remove_menu_page('edit.php?post_type=preentregas');
} 

add_action('admin_menu', 'remove_menu');

function singleenvio(){
		if ( is_user_logged_in() ) {
		ob_start();		
		include('views/templatesingleenvio.php');    
		$template = ob_get_contents();
	    ob_get_clean(); 
	    return $template;   
		}	
}


add_shortcode('wpshipit_envio', 'singleenvio');

/* New custom fields */

function wpt_add_event_metaboxes() {
	add_meta_box(
		'wpshipit_paymentstatus',
		'Pago de envío',
		'wpshipit_paymentstatus',
		'wpcargo_shipment',
		'side',
		'0'
	);
}



function wpshipit_paymentstatus(){
	global $post;
    $meta_element_class = get_post_meta($post->ID, 'wpshipit_paymentstatus', true); //true ensures you get just one value instead of an array
    ?>   
    <label style="margin: 20px 0px; display: block;">Selecciona el estado de pago del pedido:  </label>
    
    <select name="wpshipit_paymentstatus" id="wpshipit_paymentstatus">      
      <option value="Pendiente" <?php selected( $meta_element_class, 'Pendiente' ); ?>>Pago pendiente</option>
      <option value="Efectuado" <?php selected( $meta_element_class, 'Efectuado' ); ?>>Pago efectuado</option>      
    </select>
    <?php
}


function so_save_metabox(){ 
    global $post;
    if(isset($_POST["wpshipit_paymentstatus"])){
         //UPDATE: 
        $meta_element_class = $_POST['wpshipit_paymentstatus'];
        //END OF UPDATE

        update_post_meta($post->ID, 'wpshipit_paymentstatus', $meta_element_class);
        //print_r($_POST);
    }
}

add_action( 'add_meta_boxes', 'wpt_add_event_metaboxes' );
add_action('save_post', 'so_save_metabox');

function wpt_add_event_metaboxes2() {
	add_meta_box(
		'infoclientepedido',
		'Información de Contacto del Cliente',
		'infoclientepedido',
		'wpcargo_shipment',
		'normal',
		'0'
	);
}



function infoclientepedido(){
	global $post;
    $idcliente = get_post_meta($post->ID, 'registered_shipper', true);
    $clientepedido = get_user_by( 'id', $idcliente ); 
    ?>   
    
    
    <div class="rowcli">
    	<label> Nombre </label>
    	<span> <?= $clientepedido->nickname; ?> </span>	
    </div>
    <div class="rowcli">
    	<label> Teléfono</label>
    	<span> <?= get_user_meta($idcliente, "telefono")[0]; ?> </span>	
    </div>
      <div class="rowcli">
    	<label> Email </label>
    	<span> <?= $clientepedido->user_email; ?> </span>	
    </div>
     <div class="rowcli">
    	<label> Dirección 1 </label>
    	<span> <?= get_user_meta($idcliente, "dir1")[0]; ?> </span>	
    </div>
     <div class="rowcli">
    	<label> Dirección 2 </label>
    	<span> <?= get_user_meta($idcliente, "dir2")[0]; ?> </span>	
    </div>
     <div class="rowcli">
    	<label> Ciudad</label>
    	<span> <?= get_user_meta($idcliente, "ciudad")[0]; ?> </span>	
    </div>
    <style type="text/css">
    	.rowcli {
    		display: flex;
    		width: 100%;
    	}

    	.rowcli label {
    		font-weight: bold;
    		width: 100px;
    	}
    </style>
    
    
    <?php
}

add_action( 'add_meta_boxes', 'wpt_add_event_metaboxes2' );

/* Eliminar tipo de pieza */
add_filter( 'wpcargo_package_fields', 'modify_package_fields' );
function modify_package_fields( $package_fields){
    unset( $package_fields['wpc-pm-piece-type'] );
    return $package_fields;
}
?>