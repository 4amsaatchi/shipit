<?php
	$shipment_origin  					= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_origin_field' );
	$wpcargo_status   					= get_post_meta( $shipment->ID, 'wpcargo_status', true);
	$shipment_destination  				= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_destination' ); 
	$type_of_shipment  					= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_type_of_shipment' );
	$shipment_weight  					= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_weight' );
	$shipment_courier  					= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_courier' );
	$shipment_carrier_ref_number  		= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_carrier_ref_number' );
	$shipment_product  					= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_product' );
	$shipment_qty  						= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_qty' );
	$shipment_payment_mode  			= wpcargo_get_postmeta( $shipment->ID, 'payment_wpcargo_mode_field' );
	$shipment_total_freight  			= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_total_freight' );
	$shipment_mode  					= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_mode_field' );
	$departure_time  			        = wpcargo_get_postmeta( $shipment->ID, 'wpcargo_departure_time_picker' );
	$delivery_date	                    = wpcargo_get_postmeta( $shipment->ID, 'wpcargo_expected_delivery_date_picker', 'date' );
	$shipment_comments  				= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_comments' );
	$shipment_packages  				= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_packages' );
	$shipment_carrier  					= wpcargo_get_postmeta( $shipment->ID, 'wpcargo_carrier_field' );
	$pickup_date  				        = wpcargo_get_postmeta( $shipment->ID, 'wpcargo_pickup_date_picker', 'date' );
	$pickup_time  				        = wpcargo_get_postmeta( $shipment->ID, 'wpcargo_pickup_time_picker' );/*
	$shipment_paquete_1  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_1_img' );
    $shipment_paquete_2  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_2._img' );
    $shipment_paquete_3  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_3._img' );
    $shipment_paquete_4  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_4._img' );
    $shipment_paquete_5  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_5._img' );
    $shipment_paquete_6  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_6._img' );
    $shipment_paquete_7  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_7._img' );
    $shipment_paquete_8  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_8._img' );
    $shipment_paquete_9  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_9._img' );
    $shipment_paquete_10  					= wpcargo_get_postmeta( $shipment->ID, 'paquete_10._img' );
	$shipment_tn_1  					= wpcargo_get_postmeta( $shipment->ID, 'tracking_number_paquete_1');
    $shipment_tn_2  					= wpcargo_get_postmeta( $shipment->ID, 'tracking_number_paquete_2'); */
    ?>
<script>
jQuery(function($) {
	$('.detail-section:not(:has(img))').hide();
});
</script>
<div id="shipment-info" class="wpcargo-row detail-section">
    
    <div class="wpcargo-col-md-12">
    <p id="shipment-information-header" class="header-title"><strong><?php echo apply_filters('result_shipment_information', esc_html__('Shipment Information', 'wpcargo')); ?></strong></p></div>
    
	<<div class="wpcargo-col-md-12">
	    <h2>Paquetes</h2>
	    <div class="wpcargo-container">
            <div class="wpcargo-image"><p>aqui</p><?php echo $shipment_paquete_1; ?></div>
			<div class="wpcargo-tracking-number"><h1> <?php echo $shipment_tn_1; ?></h1></div>
		</div>
	
            <p class="wpcaetiquetapicabel-info">
            <?php echo $shipment_paquete_2; ?></p>
            <p class="wpcaetiquetapicabel-info">
            <?php 
            echo $shipment_paquete_3; 
            ?></p>
            <p class="wpcaetiquetapicabel-info">
            <?php 
            echo $shipment_paquete_4; 
            ?></p>
            <p class="wpcaetiquetapicabel-info">
            <?php 
            echo $shipment_paquete_5; 
            ?></p>
            <p class="wpcaetiquetapicabel-info">
            <?php 
            echo $shipment_paquete_6; 
            ?></p>
            <p class="wpcaetiquetapicabel-info">
            <?php 
            echo $shipment_paquete_7; 
            ?></p>
            <p class="wpcaetiquetapicabel-info">
            <?php 
            echo $shipment_paquete_8; 
            ?></p>
            <p class="wpcaetiquetapicabel-info">
            <?php 
            echo $shipment_paquete_9; 
            ?></p>
             <p class="wpcaetiquetapicabel-info">
            <?php 
            echo $shipment_paquete_10; 
            ?></p>
	    <div><?php echo pods_field_display( 'imagenes_de_pedido' ); ?></div>
    	<p class="wpcargo-label"><?php esc_html_e('Origin:', 'wpcargo') . ''; ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_origin; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Package:', 'wpcargo') . ''; ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_packages; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Status:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><span class="<?php echo str_replace( ' ','_', strtolower( $wpcargo_status ) ); ?>" ><?php  echo $wpcargo_status; ?></span></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php  esc_html_e('Destination:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_destination; ?></td></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Carrier:', 'wpcargo') . ''; ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_carrier; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Type of Shipment:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php  echo $type_of_shipment; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Weight:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_weight; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Shipment Mode:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_mode; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Carrier Reference No.:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_carrier_ref_number; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Product:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_product; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Qty:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_qty; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Payment Mode:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_payment_mode; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Total Freight:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $shipment_total_freight; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Expected Delivery Date:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $delivery_date; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Departure Time:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $departure_time; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Pick-up Date:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $pickup_date; ?></p>
    </div>
    <div class="wpcargo-col-md-4">
    	<p class="wpcargo-label"><?php esc_html_e('Pick-up Time:', 'wpcargo'); ?></p>
        <p class="wpcargo-label-info"><?php echo $pickup_time; ?></p>
    </div>
    <div class="wpcargo-col-md-12">
    	<p class="wpcargo-label"><?php esc_html_e('Comments:', 'wpcargo'); ?> </p>
        <p class="wpcargo-label-info"><?php echo $shipment_comments; ?></p>
    </div>
</div>