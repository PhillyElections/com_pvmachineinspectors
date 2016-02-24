document.addEventListener("DOMContentLoaded", function(event) {
var placeSearch, autocomplete,
  returnData = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    postal_code: 'short_name'
  },
  formData = {};

function initAutocomplete() {
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

// [START region_geolocation]
// Bias the autocomplete object to the city center, with a 15000m radius
function geolocate() {
  console.log('geolocate running');
  var geolocation = {
    lat: 39.952464,
    lng: -75.1662477
  };
  var circle = new google.maps.Circle({
    center: geolocation,
    radius: 15000
  });
  console.log("geolocation", geolocation, "circle.getbounds()",circle.getBounds());
  autocomplete.setBounds(circle.getBounds());
}

document.addEventListener("focus", function(e) {
  console.log('focus triggered');
  for (var target = e.target; target && target != this; target = target.parentNode) {
    // loop parent nodes from the target to the delegation node
    if (selectorMatches(target, "#address")) {
      geolocate();
      break;
    }
  }
}, false);

function selectorMatches(el, selector) {
  var p = Element.prototype;
  var f = p.matches || p.webkitMatchesSelector || p.mozMatchesSelector || p.msMatchesSelector || function(s) {
    return [].indexOf.call(document.querySelectorAll(s), this) !== -1;
  };
  return f.call(el, selector);
}
});