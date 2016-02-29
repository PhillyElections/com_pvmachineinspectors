var AC = (function() {
  'use strict';
  var outer = {},
    inner = {};
  // map of data we're going to use
  inner.returnData = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    postal_code: 'short_name'
  };
  // rough center of the city
  inner.geolocation = {
    lat: 39.952464,
    lng: -75.1662477
  };
  // intermediary between return and form
  inner.formData = {};

  inner.fillInAddress = function() {
    // Get the place details from the inner.autoComplete object.
    var place = inner.autoComplete.getPlace();
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (inner.returnData[addressType]) {
        var val = place.address_components[i][inner.returnData[addressType]];
        inner.formData[addressType] = val;
      }
    }
    document.getElementById('address1').value = inner.formData['street_number'] + ' ' + inner.formData['route'];
    document.getElementById('city').value = inner.formData['locality'];
    document.getElementById('region').value = inner.formData['administrative_area_level_1'];
    document.getElementById('postcode').value = inner.formData['postal_code'];
    document.getElementById('address2').focus();
  };

  inner.geolocate = function() {
    // set center to city hall
    var circle = new window.google.maps.Circle({
      center: inner.geolocation,
      radius: 15000
    });
    inner.autoComplete.setBounds(circle.getBounds());
  };

  outer.complete = function() {
    // Create the inner.autoComplete object, restricting the search to geographical
    // location types.
    // singleton call
    if (typeof inner.autoComplete === 'undefined') {
      inner.autoComplete = new google.maps.places.Autocomplete(
        // @type {!HTMLInputElement} 
        document.getElementById('address1'), {
          types: ['geocode']
        });
      // When the user selects an address from the dropdown, populate the address
      // fields in the form.
      inner.autoComplete.addListener('place_changed', function() {
        inner.fillInAddress();
      });
    }
    // only set the circle once
    // singleton call
    if (typeof inner.located || inner.located === false) {
      inner.geolocate();
      inner.located = true;
    }
  };

  outer.noComplete = function() {
    this.autoComplete.unbindAll();
    google.maps.event.clearInstanceListeners(document.getElementById('address1'));
    inner.located = false;
  };

  // hot init function
  outer.init = function() {
    var script = document.createElement('script');
    script.id = '_gmaps';
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&callback=AC.complete';
    document.body.appendChild(script);
  };

  return outer;
})();
window.addEvent('domready', function() {
  AC.init();
});
