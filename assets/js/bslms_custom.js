jQuery(document).ready( function() {
   var $ = jQuery;
   jQuery("#validate_bslms_api").click( function(e) {
      e.preventDefault(); 
      bslms_api_endpoint = jQuery("#bslms_api_endpoint").val();
      bslms_api_secret_key = jQuery("#bslms_api_secret_key").val();
      bslms_nonce = jQuery("#bslms_nonce").val();
      if(bslms_api_endpoint==='' || bslms_api_secret_key===''){
         alert('Please fill Api Endpoint and Api Secret Key');
      }
      else{
         $(".bslms_loader").removeClass('hide_bslms_loader');
         jQuery.ajax({
            type : "post",
            dataType : "json",
            url : bslms_object.ajax_url,
            data : {action: "bslms_api_validate", bslms_api_endpoint : bslms_api_endpoint, bslms_api_secret_key: bslms_api_secret_key, bslms_nonce: bslms_nonce},
            success: function(response) {
               $(".bslms_loader").addClass('hide_bslms_loader');
               setTimeout(function () {
                  alert(response.msg);
               }, 100);
            }
         });
      }
   });

   jQuery(".login_in_app").click( function(e) {
      $(".bslms_loader").removeClass('hide_bslms_loader');
      e.preventDefault();
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : bslms_object.ajax_url,
         data : {action: "bslms_login_into_app"},
         success: function(response) {
         if(response && response.redirecturl!=''){
               $(".bslms_loader").addClass('hide_bslms_loader');
               setTimeout(function () {
                  window.open(response.redirecturl, '_blank');
               }, 100);
            }else{
               $(".bslms_loader").addClass('hide_bslms_loader');
               alert("Something went wrong please try again!");
            }
         }
      });
   });

})