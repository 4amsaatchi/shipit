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
    $dui=$form_data['dui'];
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
    $prefijo = get_option("wpcargo_option_settings")["wpcargo_title_prefix"];
    $tuser->data->user_nicename = $tuser->data->user_nicename . $tuser->data->ID . "-" .$prefijo;
    $tuser->data->display_name = $tuser->data->user_nicename . "-" . $tuser->data->ID . "-" .$prefijo ;   
    $nickname = $nickname . "-" .$prefijo. $user;
    
    wp_update_user($tuser->data);
    /*update_user_meta($user,"last_name", $nickname);*/

    update_user_meta( $user, 'telefono', $telefono );
    update_user_meta( $user, 'dui', $dui );
    update_user_meta( $user, 'dir1', $dir1 );
    update_user_meta( $user, 'dir2', $dir2 );
    update_user_meta( $user, 'ciudad', $ciudad );
    $urllogin = site_url()."/ingresar";

    /**************************** */
    /*$email = "jescobar@4amsaatchi.com"*/;
    /*******************************************/

    sendemailuseraccount($username, $nickname, $urllogin, $email, $dir1, $ciudad);

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
        <th><label for="dui"><?php _e("DUI"); ?></label></th>
        <td>
            <input type="text" name="dui" id="dui" value="<?php echo esc_attr( get_the_author_meta( 'dui', $user->ID ) ); ?>" class="regular-text" /><br />            
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


add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }
    
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'telefono', $_POST['telefono'] );
    update_user_meta( $user_id, 'dui', $_POST['dui'] );
    update_user_meta( $user_id, 'dir1', $_POST['dir1'] );
    update_user_meta( $user_id, 'dir2', $_POST['dir2'] );
    update_user_meta( $user_id, 'ciudad', $_POST['ciudad'] );
}

function sendemailuseraccount($nombre, $usuario, $urllogin, $correo,$direccion, $ciudad){


        

        $headers = array('Content-Type: text/html; charset=UTF-8');     

        $postdata = http_build_query(

          array(

              'nombre' => mb_strtoupper($nombre,'utf-8'),

              'usuario'   => $usuario,               

              "url" => site_url(),

              "urlogin"=> $urllogin,

              "direccion"=>$direccion,

              "ciudad"=>$ciudad

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

add_action('wpcargo_tn_print_results', function(){
    return 'Detalle de envío';
});

/**
 * Filter to redirect a user to default Register form.
 *
 * @return [URL] register url with page slug on which it will be redirected after logout
*/
add_filter( 'register_url', 'custom_register_url' );
function custom_register_url( $register_url )
{
    $register_url = site_url( ).'/crear-cuenta';
    return $register_url;
}



add_filter( 'wpcargo_print_invoice_label', 'wpcargo_print_invoice_labelv2', 10);
   
function wpcargo_print_invoice_labelv2( $no_via ) {
    return "Detalle de envío";
}


add_filter( 'wpcargo_track_shipment_status_result_title', 'wpcargo_track_shipment_status_result_titlev2', 10);
   
function wpcargo_track_shipment_status_result_titlev2( $no_via ) {
    return "Estado envío: ";
}



function wptips_has_user_role($check_role){
    $user = wp_get_current_user();
    if(in_array( $check_role, (array) $user->roles )){
        return true;
    }
    return false;
}

function hide_siteadmin() {

$adm = get_role('cargo_agent');
 $adm_cap= array_keys( $adm->capabilities );


  if (wptips_has_user_role('wpcargo_employee')) {

     /* DASHBOARD */
      remove_menu_page( 'options-general.php', );  // Update
      remove_menu_page( 'pwaforwp');
      remove_menu_page( 'eael-settings');
      remove_menu_page( 'elementor');
      remove_menu_page( 'jetpack');
      remove_menu_page( 'revslider');
      remove_menu_page( 'wpuf-post-forms');
      $contributor = get_role('wpcargo_employee');
      /*$contributor->add_cap('upload_files');
      $contributor->add_cap('cargo_agent');
      $contributor->add_cap('create_posts');*/

        $new_role = get_role('wpcargo_employee');

      foreach ( $adm_cap as $cap ) {
            $new_role->add_cap( $cap ); //clone administrator capabilities to new role
        }
      

      
  }
}
add_action('admin_head', 'hide_siteadmin');

add_filter('ure_attachments_show_full_list', 'show_attachments_full_list', 10, 1);

function show_attachments_full_list($show_full_list) {
    return true;
}

function rnz_elementor_get_field( $id, $record )
{
    $fields = $record->get_field( [
        'id' => $id,
    ] );

    if ( empty( $fields ) ) {
        return false;
    }

    return current( $fields );
}


add_action( 'elementor_pro/forms/validation', 'itchycode_restrict_maximum_entries', 10, 2);

function itchycode_restrict_maximum_entries( $record, $ajax_handler ) { 

    // target my form
    $target_form_id = '2740eab';

    if( $target_form_id != $record->get_form_settings('id') ) return;

    // Here is the target form, let's make some logic
    // use $ajax_handler->add_error( $field_id, $message) when you want to fail the submission.

    /*$ajax_handler->add_error( 'form-field-email', 'You must accept the policies to submit the form.'.rnz_elementor_get_field( 'field_0ed7712', $record)  );*/
    if( $field = rnz_elementor_get_field( 'field_0ed7712', $record ) )
    {   
        $password =  trim($field['value']);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('/([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/', $password);
        //$specialChars = preg_match('/[^a-zA-Z\d]/', $string);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {            
            $ajax_handler->add_error( 'field_0ed7712', 'La contraseña debe tener al menos 8 caracteres y debe incluir al menos una letra mayúscula, un número y un carácter especial.' );
        }
    }

    
};