var AC = function() {
  var outer = {},
  inner = {};
  inner.autoComplete = {};
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
    document.querySelectorAll('select[name=region]')[0].value=inner.formData['administrative_area_level_1'];
    document.getElementById('postcode').value = inner.formData['postal_code'];
    document.getElementById('address1').focus();
  };

  inner.geolocate = function() {
    console.log('geolocate running');
    var circle = new window.google.maps.Circle({
      center: inner.geolocation,
      radius: 15000
    });
    inner.autoComplete.setBounds(circle.getBounds());
  };

  outer.complete = function() {
    // Create the inner.autoComplete object, restricting the search to geographical
    // location types.
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
  };

  outer.setCircle = function() {
    console.log("setCircle");
    //http://maps.googleapis.com/maps/api/js?libraries=places&callback=AC.complete
    document.getElementById("address1").addEventListener("focus", function(e) {

      inner.geolocate();
      e.preventDefault();
    }, null);
  };

// hot init function
  outer.init = function() {
    var script = document.createElement('script');
    script.id = '_gmaps';
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&callback=AC.complete';
    script.load = function() {
    console.log("setCircle");
    //http://maps.googleapis.com/maps/api/js?libraries=places&callback=AC.complete
    document.getElementById("address1").addEventListener("focus", function(e) {

      inner.geolocate();
      e.preventDefault();
    }, null);
  };
    document.body.appendChild(script);
  };

  return outer;
}();
jQuery(function() {
  AC.init();
});

/*  var placeSearch, autocomplete,
    // map of data we're going to use
    returnData = {
      street_number: 'short_name',
      route: 'long_name',
      locality: 'long_name',
      administrative_area_level_1: 'short_name',
      postal_code: 'short_name'
    },
    // rough center of the city
    geolocation = {
      lat: 39.952464,
      lng: -75.1662477
    },
    // intermediary between return and form
    formData = {};

  function init () {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
      // @type {!HTMLInputElement} 
      document.getElementById('address1'), {
        types: ['geocode']
      });
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
  }

  function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (returnData[addressType]) {
        var val = place.address_components[i][returnData[addressType]];
        formData[addressType] = val;
      }
    }
    document.getElementById('address1').value = formData['street_number'] + ' ' + formData['route'];
    document.getElementById('city').value = formData['locality'];
    document.getElementById('state').value = formData['administrative_area_level_1'];
    document.getElementById('postcode').value = formData['postal_code'];
  }

  // Bias the autocomplete object to the city center, with a 15000m radius
  function geolocate() {
    console.log('geolocate running');
    var circle = new google.maps.Circle({
      center: geolocation,
      radius: 15000
    });
    autocomplete.setBounds(circle.getBounds());
  }

  return{init:init,geolocate:geolocate};
};

  document.getElementById("address1").addEventListener("onfocus", function(e) {
    AC.geolocate();
    e.preventDefault();
  }, null);

  console.log($);*/