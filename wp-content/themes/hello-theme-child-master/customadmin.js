jQuery(document).ready( function($) {
        
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

        jQuery('.wpc-add').click(function(e) {
                setTimeout(() => {
                    eventoclick();
                }, "1000");

     
                
            });
      

});

// Ajax request to refresh the image preview
function Refresh_Image(camposelected, the_id){
    jQuery('input[name="'+camposelected+'"]').hide();
    
    jQuery('input[name="'+camposelected+'"]').after("<div class='contimage'><span onclick='openselector("+'"'+camposelected+'"'+",this)'> Reemplazar foto </span><div data-id='preview"+camposelected+"'> aca va la imagen </div></div>");
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