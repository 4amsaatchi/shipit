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