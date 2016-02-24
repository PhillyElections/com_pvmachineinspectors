var AC=function(){

  var placeSearch, autocomplete,
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
      /** @type {!HTMLInputElement} */
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

  console.log($);