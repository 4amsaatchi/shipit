jQuery(document).ready( function($) {
        jQuery("#menu-posts-wpcargo_shipment").removeClass("hidden");
            setTimeout(() => {
  loadimages();
}, "1000");
      jQuery('.wpc-multiple-package input#imagen_paquete').click(function(e) {
            var camposelected = $(this).attr("name");
             e.preventDefault();
             var image_frame;
             if(image_frame){
                 image_frame.open();
             }
             // Define image_frame as wp.media object
             image_frame = wp.media({
                           title: 'Select Media',
                           multiple : false,
                           library : {
                                type : 'image',
                            }
                       });

                       image_frame.on('close',function() {
                          // On close, get selections and save to the hidden input
                          // plus other AJAX stuff to refresh the image preview
                          var selection =  image_frame.state().get('selection');
                          var gallery_ids = new Array();
                          var my_index = 0;
                          selection.each(function(attachment) {
                             gallery_ids[my_index] = attachment['id'];
                             my_index++;
                          });
                          var ids = gallery_ids.join(",");
                          if(ids.length === 0) return true;//if closed withput selecting an image
                          jQuery('input[name="'+camposelected+'"]').val(ids);
                          Refresh_Image(camposelected,ids);
                       });

                      image_frame.on('open',function() {
                        // On open, get the id from the hidden input
                        // and select the appropiate images in the media manager
                        var selection =  image_frame.state().get('selection');
                        var ids = jQuery('input#imagen_paquete').val().split(',');
                        ids.forEach(function(id) {
                          var attachment = wp.media.attachment(id);
                          attachment.fetch();
                          selection.add( attachment ? [ attachment ] : [] );
                        });

                      });
    
                    image_frame.open();
     });

         jQuery('.wpc-multiple-package input#factura').click(function(e) {
            var camposelected = $(this).attr("name");
             e.preventDefault();
             var image_frame;
             if(image_frame){
                 image_frame.open();
             }
             // Define image_frame as wp.media object
             image_frame = wp.media({
                           title: 'Select Media',
                           multiple : false,
                           library : {
                                type : ['image','application/pdf'],
                            }
                       });

                       image_frame.on('close',function() {
                          // On close, get selections and save to the hidden input
                          // plus other AJAX stuff to refresh the image preview
                          var selection =  image_frame.state().get('selection');
                          var gallery_ids = new Array();
                          var my_index = 0;
                          selection.each(function(attachment) {
                             gallery_ids[my_index] = attachment['id'];
                             my_index++;
                          });
                          var ids = gallery_ids.join(",");
                          if(ids.length === 0) return true;//if closed withput selecting an image
                          jQuery('input[name="'+camposelected+'"]').val(ids);
                          console.log("IDS length");
                          console.log(ids.length);
                          Cargarfactura(camposelected,ids);
                       });

                      image_frame.on('open',function() {
                        // On open, get the id from the hidden input
                        // and select the appropiate images in the media manager
                        var selection =  image_frame.state().get('selection');
                        var ids = jQuery('input#factura').val().split(',');
                        ids.forEach(function(id) {
                          var attachment = wp.media.attachment(id);
                          attachment.fetch();
                          selection.add( attachment ? [ attachment ] : [] );
                        });

                      });
    
                    image_frame.open();
     });


        jQuery('.wpc-add').click(function(e) {
                setTimeout(() => {
                    eventoclick();
                    eventoclick2();
                }, "1000");

     
                
            });
      

});

// Ajax request to refresh the image preview
function Refresh_Image(camposelected, the_id){
    jQuery('input[name="'+camposelected+'"]').find('.contimage').remove();
    jQuery('input[name="'+camposelected+'"]').hide();
    
    jQuery('input[name="'+camposelected+'"]').after("<div class='contimage'><span onclick='openselector("+'"'+camposelected+'"'+",this)'> Reemplazar imagen paquete </span><div data-id='preview"+camposelected+"'> aca va la imagen </div></div>");
        var data = {
            action: 'myprefix_get_image',
            id: the_id,
            campo: camposelected
        };

        jQuery.get(ajaxurl, data, function(response) {
                console.log(response);
            if(response.success === true) {
                jQuery('[data-id="preview'+camposelected+'"]').replaceWith( response.data.image );
                console.log(jQuery('[data-id="preview'+camposelected+'"]'));
            }
        });
}

const isValidUrl = urlString=> {
        var urlPattern = new RegExp('^(https?:\\/\\/)?'+ // validate protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // validate domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // validate OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // validate port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // validate query string
        '(\\#[-a-z\\d_]*)?$','i'); // validate fragment locator
      return !!urlPattern.test(urlString);
    }

function Cargarfactura(camposelected, value){
    jQuery('input[name="'+camposelected+'"]').find('.contimage').remove();
    
    jQuery('input[name="'+camposelected+'"]').hide();
    jQuery('input[name="'+camposelected+'"]').after("<div class='contimage'><span onclick='openselector("+'"'+camposelected+'"'+",this)'> Reemplazar factura </span><div data-id='preview"+camposelected+"'> aca va la imagen </div></div>");

    if (isValidUrl(value)) {
        jQuery('[data-id="preview'+camposelected+'"]').replaceWith( "<a style='width: 100%;display: block; margin-top: 20px;' href='"+value+"' target='_blank'>Ver Factura </a>" );
    }else {

     var data = {
            action: 'myprefix_get_image',
            id: value,
            campo: camposelected,
            tipoimg: 'urlimagen'

        };

        jQuery.get(ajaxurl, data, function(response) {
                console.log(response);
            if(response.success === true) {
                if (response.data.tipo == "imagen"){
                jQuery('[data-id="preview'+camposelected+'"]').replaceWith( response.data.image );
                } else {
                jQuery('[data-id="preview'+camposelected+'"]').replaceWith( "<a style='width: 100%;display: block; margin-top: 20px;' href='"+response.data.image+"' target='_blank'>Ver Factura </a>" );    
                }
                
            }
        });
    }
    
}

function openselector(camposelected, elemento){
        jQuery(elemento).parent().hide();
        jQuery('input[name="'+camposelected+'"]').show();
        jQuery('input[name="'+camposelected+'"]').click();
}

function loadimages(){
    console.log("ENTRO");
jQuery('input[name^=wpc-multiple-package]').each(function(index, el) {
    console.log("NADA");
    if (el.id == "imagen_paquete" && el.value != ""){
           Refresh_Image(el.name,el.value);
    }

     if (el.id == "factura" && el.value != ""){
           Cargarfactura(el.name,el.value);
    }
   
});
}

function eventoclick(){
    jQuery('.wpc-multiple-package input#imagen_paquete').click(function(e) {
              var camposelected = jQuery(this).attr("name");
             e.preventDefault();
             var image_frame;
             if(image_frame){
                 image_frame.open();
             }
             // Define image_frame as wp.media object
             image_frame = wp.media({
                           title: 'Select Media',
                           multiple : false,
                           library : {
                                type : 'image',
                            }
                       });

                       image_frame.on('close',function() {
                          // On close, get selections and save to the hidden input
                          // plus other AJAX stuff to refresh the image preview
                          var selection =  image_frame.state().get('selection');
                          var gallery_ids = new Array();
                          var my_index = 0;
                          selection.each(function(attachment) {
                             gallery_ids[my_index] = attachment['id'];
                             my_index++;
                          });
                          var ids = gallery_ids.join(",");
                          if(ids.length === 0) return true;//if closed withput selecting an image
                          jQuery('input[name="'+camposelected+'"]').val(ids);
                          Refresh_Image(camposelected,ids);
                       });

                      image_frame.on('open',function() {
                        // On open, get the id from the hidden input
                        // and select the appropiate images in the media manager
                        var selection =  image_frame.state().get('selection');
                        var ids = jQuery('input#imagen_paquete').val().split(',');
                        ids.forEach(function(id) {
                          var attachment = wp.media.attachment(id);
                          attachment.fetch();
                          selection.add( attachment ? [ attachment ] : [] );
                        });

                      });
    
                    image_frame.open();
        });
}

function eventoclick2(){
    jQuery('.wpc-multiple-package input#factura').click(function(e) {
              var camposelected = jQuery(this).attr("name");
             e.preventDefault();
             var image_frame;
             if(image_frame){
                 image_frame.open();
             }
             // Define image_frame as wp.media object
             image_frame = wp.media({
                           title: 'Select Media',
                           multiple : false,
                           library : {
                                type : ['image','application/pdf'],
                            }
                       });

                       image_frame.on('close',function() {
                          // On close, get selections and save to the hidden input
                          // plus other AJAX stuff to refresh the image preview
                          var selection =  image_frame.state().get('selection');
                          var gallery_ids = new Array();
                          var my_index = 0;
                          selection.each(function(attachment) {
                             gallery_ids[my_index] = attachment['id'];
                             my_index++;
                          });
                          var ids = gallery_ids.join(",");
                          if(ids.length === 0) return true;//if closed withput selecting an image
                          jQuery('input[name="'+camposelected+'"]').val(ids);
                          Cargarfactura(camposelected,ids);
                       });

                      image_frame.on('open',function() {
                        // On open, get the id from the hidden input
                        // and select the appropiate images in the media manager
                        var selection =  image_frame.state().get('selection');
                        var ids = jQuery('input#factura').val().split(',');
                        ids.forEach(function(id) {
                          var attachment = wp.media.attachment(id);
                          attachment.fetch();
                          selection.add( attachment ? [ attachment ] : [] );
                        });

                      });
    
                    image_frame.open();
        });
}