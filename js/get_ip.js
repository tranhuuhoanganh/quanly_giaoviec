$(document).ready(function(){
  $.getJSON("https://api.ipify.org?format=json", function(data){
    var userIP = data.ip;
    $.getJSON("https://api.ipgeolocationapi.com/geolocate/" + userIP, function(data){
      var userLat = data.geo.latitude;
      var userLng = data.geo.longitude;
      // You can now use the user's latitude and longitude to determine if they're within your geo fence
    });
  });
});