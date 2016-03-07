$(document).ready(function(){
  /*fill out the postcode and hit search*/
  (function($) {
    $.fn.searchPc = function(options) {

      var settings = $.extend({
            //address1: 'address1',
            addressOne: 'addressOne',
            addressTwo: 'addressTwo',
            city: 'city'
      }, options);

      return this.each(function() {

        var $el = $(this);
        var $form = $el.closest('form');

        //insert the button on the form
        //$('<label></label><a class="postCodeLookup">Postcode Search</a>').insertAfter($el);
        //$('<label></label><input type="button" class="postCodeLookup" value="Postcode Search" />').insertAfter($el);
        //$('.postCodeLookup', $form).button({icons:{primary:'ui-icon-search'}});

        $form.on('click', '.postCodeLookup', function() {
          $.post('http://maps.googleapis.com/maps/api/geocode/json?address='+$el.val()+'&region=uk&sensor=false', function(r) {
            if(r.results.length > 0){
              var lat = r.results[0].geometry.location.lat;
              var lng = r.results[0].geometry.location.lng;
            }
            else if(r.results.length == 0){
              $('#postcode').notify("Incorrect Postcode");
            }
            
            $.post('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&sensor=false', function(address) {
              //$('input[name='+settings.address1+']').val(address['results'][0]['address_components'][0]['long_name']);
              $('input[name='+settings.addressOne+']').val(address['results'][0]['address_components'][1]['long_name']);
              $('input[name='+settings.addressTwo+']').val(address['results'][0]['address_components'][2]['long_name']);
              $('input[name='+settings.city+']').val(address['results'][0]['address_components'][3]['long_name']);
            });
          });
        });

      });
    };
  })(jQuery);

  $('input[name=postcode]').searchPc({
      address2: 'custom_field',
  });
});