<?php

function get_estadoparaconsolidar() {
	return 'En Shipit! Miami';
}

function get_estadoconsolidado(){
	return "Volando a ESA";
}

function getorderuser() {
	/*$args = array(
       'post_type' => 'wpcargo_shipment',
        'meta_key' => 'registered_shipper',
       'meta_value' => get_current_user_id()
     );*/

     $args = array(

    'post_type'        => 'wpcargo_shipment',   
    'meta_query'       => array(
        //comparison between the inner meta fields conditionals
        'relation'    => 'AND',
        //meta field's first condition
        array(
            'key'          => 'registered_shipper',
            'value'        => get_current_user_id(),
            'compare'      => '=',
        ),
        //meta field's second condition
        /*array(
            'key'          => 'wpcargo_status',
            'value'        => 'En Shipit! Miami',
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => '=',
        )*/
    ),

);

    $query = new WP_Query( $args );

    return $query;
}


function loadorder() {
	 $idorder = $_POST['idorder'];	 
	 $paquetes = get_post_meta($idorder, 'wpc-multiple-package', true); 
	
	foreach ($paquetes as $paquete): 
		echo '<tr class="package-row">';
			echo "<td>".$paquete["wpc-pm-qty"]."</td>";			               
			echo "<td>".$paquete["wpc-pm-piece-type"]."</td>";					            
			echo "<td>".$paquete["wpc-pm-description"]."</td>";					               				            
			echo "<td>".$paquete["wpc-pm-weight"]."</td>";					               
			echo "<td class='colimagepa'><img src='".wp_get_attachment_image_src($paquete["imagen_paquete"])[0]."'></td>";					               					            
			echo "<td>".$paquete["store"]."</td>";					               					            
			echo "<td>".$paquete["tracking"]."</td>";
	    echo '</tr>';
	 endforeach;

	 wp_die();

}

add_action( 'wp_ajax_nopriv_loadorder', 'loadorder' );
add_action( 'wp_ajax_loadorder', 'loadorder' );


function consolidarpedido() {
	$result = 1;
	$idorder = $_POST['idorder'];	 
	update_post_meta($idorder, 'wpcargo_status', get_estadoconsolidado());
	$agente = get_post_meta($idorder, 'agent_fields', true);
	$nombrepedido = get_post_meta($idorder, 'post_name', true);
	$cliente = get_post_meta($idorder, 'registered_shipper', true); 
	$urlenvio = site_url()."/envio?idenvio=".$idorder;
	
	if ($agente):
	enviarcorreoconsolidadoagente($agente, $nombrepedido, $urlenvio);	
	endif;


	enviarcorreoconsolidadocliente($cliente, $nombrepedido);

	
	echo json_encode(array("result"=>$result));
	wp_die();

}

add_action( 'wp_ajax_nopriv_consolidarpedido', 'consolidarpedido' );
add_action( 'wp_ajax_consolidarpedido', 'consolidarpedido' );


function enviarcorreoconsolidadoagente($agente, $nombrepedido,$urlenvio){
  $user = get_user_by( 'id', intval($agente) );  
  $nombre = $tuser->user_nicename;
	
 $headers = array('Content-Type: text/html; charset=UTF-8');     

      $postdata = http_build_query(

        array(        
        		'nombre' => $nombre,    

            'idorden'   => $nombrepedido,               

            "url" => site_url(),

            "urlenvio" => $urlenvio

            )

        );

      $opts = array('http' =>

            array(

                'method'  => 'POST',

                'header'  => 'Content-type: application/x-www-form-urlencoded',

                'content' => $postdata

            )

        );

      $context  = stream_context_create($opts);      

      $html = file_get_contents(get_stylesheet_directory_uri()."/templates/emailenvioconsolidadoagente.php", false, $context); 

      $envio= wp_mail( $user->user_email, "Se ha consolidado el envío ".$nombrepedido, $html, $headers );

      return $envio;
}

function enviarcorreoconsolidadocliente($cliente, $nombrepedido){
	$tuser = get_user_by('ID', $cliente);	
  $nombre = get_user_meta( $cliente, 'first_name', true );;
  $correo = $tuser->user_email;

  
	 $headers = array('Content-Type: text/html; charset=UTF-8');     

        $postdata = http_build_query(

          array(

              'nombre' => $nombre,

              'idorden'   => $nombrepedido,               

              "url" => site_url()

              )

          );

        $opts = array('http' =>

              array(

                  'method'  => 'POST',

                  'header'  => 'Content-type: application/x-www-form-urlencoded',

                  'content' => $postdata

              )

          );

        $context  = stream_context_create($opts);      

        $html = file_get_contents(get_stylesheet_directory_uri()."/templates/emailenvioconsolidadocliente.php", false, $context); 

        $envio= wp_mail( $correo, "Su envio ".$nombrepedido." ha sido consolidado ", $html, $headers );

        return $envio;
}


function registrar_preentrega() {
	$paquete       = $_POST['nombre'];
	$trackingid    = $_POST['trackingid'];
	$factura       = $_FILES['factura'];
	$fechaestimada = $_POST['datepicker'];
	$tienda        = $_POST['tienda'];
	$result = -1;   
	$dir = wp_upload_dir()["basedir"]."/preentregas/"; 

	$img = $_FILES['factura']['name'];
	$tmp = $_FILES['factura']['tmp_name'];	
	
	
	$final_image = rand(1000,1000000).$img;
	$path = $dir.strtolower($final_image); 

	


	if(!empty($paquete) || !empty($trackingid) || !empty($factura) || !empty($fechaestimada))
	{
	   	$args = array('post_title'    => $paquete,  
	  	'post_status'   => 'publish',
	  	'post_type'=>'preentregas',
	  	'post_author'   => get_current_user_id());

		$result= wp_insert_post($args);

		if ($result){
			if(move_uploaded_file($tmp,$path)) 
				{
				add_post_meta($result, 'trackingid', $trackingid, true);
			  	add_post_meta($result, 'factura',  wp_upload_dir()["baseurl"]."/preentregas/".strtolower($final_image), true);
			  	add_post_meta($result, 'fechaestimada', $fechaestimada, true);
			  	add_post_meta($result, 'tienda', $tienda, true);

				} else {					
					wp_delete_post($result);
					$result = -2;
				}
			  
		} 
	}

	echo json_encode(array("result"=>$result));
	wp_die();

}

add_action( 'wp_ajax_nopriv_registrar_preentrega', 'registrar_preentrega' );
add_action( 'wp_ajax_registrar_preentrega', 'registrar_preentrega' );

function asignarapedido() {
	$result = 1;
	
	$idpaquete = $_POST['idpaquete'];	 
	$iduser = $_POST['iduser'];
	$orderid = buscarpedidenconsolidacion($iduser); 

	if ($orderid == -1){
		//Crear pedido de 0
		
		/* Generar nombre aleatorio*/
		$prefijo = get_option("wpcargo_option_settings")["wpcargo_title_prefix"];
		$sufijo = get_option("wpcargo_title_suffix");
		$ndigitos = get_option("wpcargo_title_numdigit"); 
		$naleatorio = rand(1,5);
		$datos = true;
		do {
		    $naleatorio = naleatorio($ndigitos);
		    $title= $prefijo.$naleatorio.$sufijo;	
			$args = array("post_type" => "wpcargo_shipment", "s" => $title);
			$query = get_posts( $args );
			if (!$query){
				$datos = false;
			}
		} while ($datos);		
		/* */

		$info = array('post_type'=>'wpcargo_shipment', 'post_title'=>$title, 'post_status' => 'publish');
		$orderid = wp_insert_post($info);
		if ($orderid != 0){
		update_post_meta($orderid, 'wpcargo_status', 'En Shipit! Miami');
		update_post_meta($orderid, 'registered_shipper', $iduser);
		add_post_meta($orderid, 'wpc-multiple-package', "");
		agregarpaquete($orderid, $idpaquete);		
		} else {
			$result= -1;
		}
	} else {
		$title = get_the_title( $orderid );
		agregarpaquete($orderid, $idpaquete);
		$result = 1;
	}
	
	if ($result == 1){
		update_post_meta($orderid, 'agent_fields', retornaragente());

		
		$tuser = get_user_by('ID',$iduser);
    $nombre = $tuser->user_nicename;
    $correo = $tuser->user_email;
  
		enviarcorreopreconsolidacion($nombre, $title, $correo);

	wp_update_post(array(
        'ID'    =>  $idpaquete,
        'post_status'   =>  'trash'
        ));

	}

	echo json_encode(array("result"=>$result));
	wp_die();


}

add_action( 'wp_ajax_asignarapedido', 'asignarapedido' );
add_action( 'wp_ajax_nopriv_asignarapedido', 'asignarapedido');


/*  Retorna el id del primer pedido que se encentre pendiente de consolidación si no encuentra retorna -1*/
function buscarpedidenconsolidacion($iduser){
GLOBAL $wpdb; 

/*
$args = array(

    'post_type'        => 'wpcargo_shipment', 
    'posts_per_page'    => 1,
    'post_status' => 'publish',
    'orderby' => 'id',
    'meta_query'       => array(
        //comparison between the inner meta fields conditionals
        'relation'    => 'AND',
        //meta field's first condition
        array(
            'key'          => 'registered_shipper',
            'value'        => $iduser,
            'type' => 'numeric',
            'compare'      => '=',

        ),
        //meta field's second condition
        array(
          'relation'    => 'OR',
          array(
              'key'          => 'wpcargo_status',
              'value'        => 'SUS PAQUETES ESTAN SIENDO CONSOLIDADOS',
              //I think you really want != instead of NOT LIKE, fix me if I'm wrong
              //'compare'      => 'NOT LIKE',
              'compare'      => 'EXISTS',
          ),
            array(
              'key'          => 'wpcargo_status',
              'value'        => 'SU ENVIO ESTA SIENDO CONSOLIDADO',
              //I think you really want != instead of NOT LIKE, fix me if I'm wrong
              //'compare'      => 'NOT LIKE',
              'compare'      => '=',
          )     
        )
    ),

);
*/

  /*if ( $query->have_posts() ) : 
      $idorder   = $query->posts[0]->ID;
    else: 
      $idorder = -1;
    endif;*/

$sql = "SELECT wp_posts.ID FROM wp_posts INNER JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id ) INNER JOIN wp_postmeta AS mt1 ON ( wp_posts.ID = mt1.post_id ) WHERE 1=1 AND ( ( wp_postmeta.meta_key = 'registered_shipper' AND wp_postmeta.meta_value = $iduser ) AND ( ( mt1.meta_key = 'wpcargo_status' AND mt1.meta_value = '".get_estadoparaconsolidar()."' ) OR ( mt1.meta_key = 'wpcargo_status' AND mt1.meta_value = 'SU ENVIO ESTA SIENDO CONSOLIDADO' ) ) ) AND wp_posts.post_type = 'wpcargo_shipment' AND ((wp_posts.post_status = 'publish')) LIMIT 1";

$results = $wpdb->get_results($sql);

if (count($results)> 0):
  $idorder = $results[0]->ID;
else: 
  $idorder = -1;
endif;

    return $idorder;

}

function agregarpaquete($orderid,$idpaquete) {
	/* get info*/
	$trackinid     = get_post_meta($idpaquete, 'trackingid', true);
	$factura       = get_post_meta($idpaquete, 'factura', true);
	$fechaestimada = get_post_meta($idpaquete, 'fechaestimada', true);
	$tienda        = get_post_meta($idpaquete, 'tienda', true);
	$descripcion   = get_the_title($idpaquete);
	/* */

	$paquetes = get_post_meta($orderid, 'wpc-multiple-package', true); 
	
	if (empty( $paquetes)){
		$paquetes = array();
	}
	array_push($paquetes, array("wpc-pm-description"=>$descripcion, 'store'=>$tienda, "tracking"=>$trackinid, "factura"=>$factura, "fechaestimada"=> $fechaestimada));
	update_post_meta($orderid, 'wpc-multiple-package', $paquetes);	
}


function enviarcorreopreconsolidacion($nombre, $idorden, $correo){

        

        $headers = array('Content-Type: text/html; charset=UTF-8');     

        $postdata = http_build_query(

          array(

              'nombre' => $nombre,

              'idorden'   => $idorden,               

              "url" => site_url()

              )

          );

        $opts = array('http' =>

              array(

                  'method'  => 'POST',

                  'header'  => 'Content-type: application/x-www-form-urlencoded',

                  'content' => $postdata

              )

          );

        $context  = stream_context_create($opts);      

        $html = file_get_contents(get_stylesheet_directory_uri()."/templates/emailregistropreentrega.php", false, $context); 

        $envio= wp_mail( $correo, "Se ha agregado un nuevo paquete a tu envio ".$idorden, $html, $headers );

        return $envio;

}


function nombreusuario1() {
return get_user_meta( get_current_user_id(), 'first_name', true );;
}
add_shortcode('nombreusuario', 'nombreusuario1');

function retornaragente(){
	/*$agentes = get_users( array( 'role__in' => array( 'WPCargo Agent' ) ) );*/
	/*$tuser = get_user_by('ID',103);	*/
	return 103;
}
/*
function get_classestado($estado1, $estado2){
	if ($estado1 == $estado2){

	} else {
		return "";
	}
}*/

function naleatorio($x){
	if ($x > 0){
		$x = $x-1;
	}
	$min = pow(10,$x);
	$max = pow(10,$x+1)-1;
	$value = rand($min, $max);
	return $value;
}

?>