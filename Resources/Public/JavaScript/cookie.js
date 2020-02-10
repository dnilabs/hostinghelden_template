function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
jQuery(function($){

  if (!getCookie('acceptCookie') && !getCookie("declineCookie")) {
    setTimeout(function() {
      $('#cookies').slideDown(500);
    }, 1500);
  }

  $('#cookies a.accept').on('click', function() {
    $('#cookies').slideUp(500);
    setCookie("acceptCookie", true, 100);
    return false;
  });

  $('#cookies a.decline').on('click', function() {
    $('#cookies').slideUp(500);
    setCookie("declineCookie", true, 100);
    return false;
  });

  // show cookie warning again
  $(".reaccept-cookies").click(function(){
    setCookie("declineCookie", null, 0);
    setCookie("acceptCookie", null, 0);
    window.location.reload();
    return false;
  });

  // google analytics
  if (window.googleAnalytics && getCookie('acceptCookie')) {
    $.ajax({
      url: 'https://www.googletagmanager.com/gtag/js?id='+window.googleAnalytics,
      dataType: 'script',
      cache: true, // otherwise will get fresh copy every page load
      success: function () {
        window.dataLayer = window.dataLayer || [];
        function gtag() {
          dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', window.googleAnalytics, {'anonymize_ip': true});
      }
    });
  }

  // google maps
  var googlemaps = $(".googlemaps");
  if (googlemaps.length > 0) {
    // reload page after accepting cookies on a pagewith google maps
    $('#cookies a.accept').on('click', function() {
      window.location.reload();
      return false;
    });

    var googlemapswarn = $(".googlemaps-warning");
    var showMaps = function(){
      googlemapswarn.hide();
      $(googlemaps).each(function(){
        var src = $(this).data("src");
        $(this).attr("src", src);
        $(this).show();

      });
      return false;
    };
    $(".load-googlemaps").click(showMaps);
    if (!getCookie("declineCookie") && getCookie("acceptCookie")) {
      showMaps();
    } else {
      googlemapswarn.show();
    }
  }
  // facebook plugin
  var facebook = $("#fb-root");
  if (facebook.length > 0) {
    // reload page after accepting cookies on a pagewith fbplugin
    $('#cookies a.accept').on('click', function() {
      window.location.reload();
      return false;
    });
    var warn = $(".facebook-warning");
    var showFacebook = function(){
      warn.hide();
      var initFB = function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.8";
        fjs.parentNode.insertBefore(js, fjs);
      };
      initFB(document, 'script', 'facebook-jssdk');
      return false;
    };
    $(".load-facebook").click(showFacebook);
    if (!getCookie("declineCookie") && getCookie("acceptCookie")) {
      showFacebook();
    } else {
      warn.show();
    }
  }
});
