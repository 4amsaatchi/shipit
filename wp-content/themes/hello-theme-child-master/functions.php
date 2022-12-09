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
/*function cambiar_datos_del_usuario($userid){
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
    
add_action( 'user_register', 'cambiar_datos_del_usuario' );*/
// // termina aqui  el codigo para modificar alias luego de creacion de usuario */

/*
add_filter( 'wpc_email_meta_tags', 'custom_additional_email_meta_tags' );
function custom_additional_email_meta_tags( $tags ){
    $tags['{test}'] = 'MENSAJE DESDE PHP';
    return $tags;
}*/




function process_data_form_tyepform_webhook() {
    echo "DS";
    $username = "test";
    $password = "1234";
    $email = "test@gmail.com";
    wp_create_user($username,$password,$email);
   /*$request = file_get_contents('php://input'); // get data from webhoook

   $data = json_decode($request, true); // decode the data is you are getting data in JSON format
   // log it in debug.log
  error_log( $request );*/
}
add_action('admin_post_nopriv_get_typeform_data',  'process_data_form_tyepform_webhook', 10);



add_action( 'elementor_pro/forms/new_record',  'thewpchannel_elementor_form_create_new_user' , 10, 2 );
function thewpchannel_elementor_form_create_new_user($record,$ajax_handler)
{
    $form_name = $record->get_form_settings('form_name');
    //Check that the form is the "create new user form" if not - stop and return;
    if ('registroclientes' !== $form_name) {
        return;
    }
    $form_data = $record->get_formatted_data();    
    $username=$form_data['nombre']; //Get the value of the input with the label "User Name"
    $password = $form_data['password']; //Get the value of the input with the label "Password"
    $email=$form_data['email'];  //Get the value of the input with the label "Email"*/
    $telefono=$form_data['telefono'];
    $dni=$form_data['dni'];
    $dir1=$form_data['dir1'];
    $dir2=$form_data['dir2'];
    $ciudad=$form_data['ciudad'];
    
  

    $user = wp_create_user($username,$password,$email); // Create a new user, on success return the user_id no failure return an error object
    if (is_wp_error($user)){ // if there was an error creating a new user
        $ajax_handler->add_error_message("Error al crear el usuario: ".$user->get_error_message()); //add the message
        $ajax_handler->is_success = false;
        return;
    }

    $tuser = get_user_by('ID', $user);
    $nickname = get_user_meta($user, 'nickname', true);
    $tuser->data->user_nicename = $tuser->data->user_nicename . $tuser->data->ID . "-" . "BOX" ;
    $tuser->data->display_name = $tuser->data->user_nicename . "-" . $tuser->data->ID . "-" . "BOX" ;   
    $nickname = $nickname . "-" . "BOX" . $user;
    
    wp_update_user($tuser->data);
    update_user_meta($user,"last_name", $nickname);

    update_user_meta( $user, 'telefono', $telefono );
    update_user_meta( $user, 'dni', $dni );
    update_user_meta( $user, 'dir1', $dir1 );
    update_user_meta( $user, 'dir2', $dir2 );
    update_user_meta( $user, 'ciudad', $ciudad );
    $urllogin = site_url()."/ingresar";

    /**************************** */
    /*$email = "jescobar@4amsaatchi.com"*/;
    /*******************************************/

    sendemailuseraccount($username, $nickname, $urllogin, $email);

}




add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
    <tr>
        <th><label for="telefono"><?php _e("Teléfono"); ?></label></th>
        <td>
            <input type="text" name="telefono" id="telefono" value="<?php echo esc_attr( get_the_author_meta( 'telefono', $user->ID ) ); ?>" class="regular-text" /><br />            
        </td>
    </tr>
    <tr>
        <th><label for="dni"><?php _e("Dni"); ?></label></th>
        <td>
            <input type="text" name="dni" id="dni" value="<?php echo esc_attr( get_the_author_meta( 'dni', $user->ID ) ); ?>" class="regular-text" /><br />            
        </td>
    </tr>
    <tr>
    <th><label for="dir1"><?php _e("Dirección 1"); ?></label></th>
        <td>
            <input type="text" name="dir1" id="dir1" value="<?php echo esc_attr( get_the_author_meta( 'dir1', $user->ID ) ); ?>" class="regular-text" /><br />            
        </td>
    </tr>
     <tr>
    <th><label for="dir2"><?php _e("Dirección 2"); ?></label></th>
        <td>
            <input type="text" name="dir2" id="dir2" value="<?php echo esc_attr( get_the_author_meta( 'dir2', $user->ID ) ); ?>" class="regular-text" /><br />            
        </td>
    </tr>
     <th><label for="ciudad"><?php _e("Ciudad"); ?></label></th>
        <td>
            <input type="text" name="ciudad" id="ciudad" value="<?php echo esc_attr( get_the_author_meta( 'ciudad', $user->ID ) ); ?>" class="regular-text" /><br />            
        </td>
    </tr>

    </table>
<?php }

/*
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }
    
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'address', $_POST['address'] );
    update_user_meta( $user_id, 'city', $_POST['city'] );
    update_user_meta( $user_id, 'postalcode', $_POST['postalcode'] );
}*/

function sendemailuseraccount($nombre, $usuario, $urllogin, $correo){

        

        $headers = array('Content-Type: text/html; charset=UTF-8');     

        $postdata = http_build_query(

          array(

              'nombre' => mb_strtoupper($nombre,'utf-8'),

              'usuario'   => $usuario,               

              "url" => site_url(),

              "urlogin"=> $urllogin     

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

        $html = file_get_contents(get_stylesheet_directory_uri()."/templates/emailcreacioncuenta.php", false, $context); 

        $envio= wp_mail( $correo, "Cuenta Creada en Shipit", $html, $headers );

        return $envio;

}


add_action('wpcargo_tn_submit_val', function(){
    return 'RASTREAR';
});


add_action('wpcargo_tn_placeholder', function(){
    return 'Ingrese el código de su paquete';
});