<?php
/**
* Template Name: Test
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
**/


$postid= 2249;

/*$image = wp_get_attachment_image(2698)*/;
$image = wp_get_attachment_url(2698);

print_r($image);
die();
 get_post_meta($postid, 'wpcargo_status', true)."<br>";
 $agente = get_post_meta($postid, 'agent_fields', true)."<br>";
  get_post_meta($postid, 'post_name', true)."<br>";
 
  $user = get_user_by( 'id', intval($agente) );
  //echo $user->user_email;
  $message = "TEST";
  


  
$paquetes = get_post_meta($postid, 'wpc-multiple-package', true); 
//print_r($paquetes);
//echo count($paquetes);
foreach ($paquetes as $paquete) {
	echo $paquete["wpc-pm-description"]." - ";
  if ($paquete["imagen_paquete"] != ""){
    echo "TIENE FOTO";
  }else {
    echo "NO TIENE FOTO";
  }
//print_r($paquete);
	//echo $paquete["imagen_paquete"]."<br>";  
}

array_push($paquetes, array("wpc-pm-description"=>"descripcion", 'store'=>"Tienda", "tracking"=>"1235"));
//print_r($paquetes);

//update_post_meta($postid, 'wpc-multiple-package', $paquetes);
/*print_r($paquetes);*/

function get_all_meta($type){
              global $wpdb;
              $result = $wpdb->get_results($wpdb->prepare(
                  "SELECT post_id,meta_key,meta_value FROM wp_posts,wp_postmeta WHERE post_type = %s
                    AND wp_posts.ID = wp_postmeta.post_id", $type
              ), ARRAY_A);
               return $result;
          }

          $a =  get_all_meta("wpcargo_shipment");

print_r($a);

/*
$emailbody =" <h1>TEST ONLINE SHORTCODE {shortcodeconsolidado} </h1>";
echo $emailbody."<br>";
$emailbody2 = str_replace("{shortcodeconsolidado}","<a href='test'>TESMOD replace shortcode </a>",$emailbody);
echo $emailbody2;*/




    $args = array(

    'post_type'        => 'wpcargo_shipment', 
    'posts_per_page'    => 1,
    'post_status'       => "publish",
    'meta_query'       => array(
        //comparison between the inner meta fields conditionals
        'relation'    => 'AND',
        //meta field's first condition
        array(
            'key'          => 'registered_shipper',
            'value'        => 21,
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
              'compare'      => '=',
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

    $query = new WP_Query( $args );

     if ( $query->have_posts() ) : 
      $idorder   = $query->posts[0]->ID;
    else: 
      $idorder = -1;
    endif;
   
/*echo $query->request;
   echo $idorder;*/
  
/*

$trackinid = get_post_meta(1399, 'trackingid', true);
echo "<br> TRACKINID";
echo $trackinid;

$iduser = "142";
$fecha = new DateTime();
$title = $fecha->getTimestamp();
$title = "hn".$title."box";
$info = array('post_type'=>'wpcargo_shipment', 'post_title'=>$title);
$orderid = wp_insert_post($info);
update_post_meta($orderid, 'wpcargo_status', 'SUS PAQUETES ESTAN SIENDO CONSOLIDADOS');
update_post_meta($orderid, 'registered_shipper', $iduser);
*/

$sql = "SELECT wp_posts.ID FROM wp_posts INNER JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id ) INNER JOIN wp_postmeta AS mt1 ON ( wp_posts.ID = mt1.post_id ) WHERE 1=1 AND ( ( wp_postmeta.meta_key = 'registered_shipper' AND wp_postmeta.meta_value = '142' ) AND ( ( mt1.meta_key = 'wpcargo_status' AND mt1.meta_value = 'SUS PAQUETES ESTAN SIENDO CONSOLIDADOS' ) OR ( mt1.meta_key = 'wpcargo_status' AND mt1.meta_value = 'SU ENVIO ESTA SIENDO CONSOLIDADO' ) ) ) AND wp_posts.post_type = 'wpcargo_shipment' AND ((wp_posts.post_status = 'publish')) LIMIT 1";

$results = $wpdb->get_results($sql);
if (count($results)> 0){
  /*print_r($results[0]->ID);*/
  echo "CON  RESULTADOS"; 
  } ELSE {
    echo "SIN RESULTADOS";
  }