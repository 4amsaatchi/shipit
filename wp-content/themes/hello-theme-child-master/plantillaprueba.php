<?php
/**
* Template Name: Test
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
**/


$postid= 1343;
 echo get_post_meta($postid, 'wpcargo_status', true)."<br>";
 $agente = get_post_meta($postid, 'agent_fields', true)."<br>";
 echo get_post_meta($postid, 'post_name', true)."<br>";
 
  $user = get_user_by( 'id', intval($agente) );
  echo $user->user_email;
  $message = "TEST";
  


  
$paquetes = get_post_meta($postid, 'wpc-multiple-package', true); 

foreach ($paquetes as $paquete) {
	/*echo $paquete["wpc-pm-description"]." - ";
	echo $paquete["imagen_paquete"]."<br>";
  print_r(wp_get_attachment_image_src($paquete["imagen_paquete"]));*/
}
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

//print_r($a);


$emailbody =" <h1>TEST ONLINE SHORTCODE {shortcodeconsolidado} </h1>";
echo $emailbody."<br>";
$emailbody2 = str_replace("{shortcodeconsolidado}","<a href='test'>TESMOD replace shortcode </a>",$emailbody);
echo $emailbody2;