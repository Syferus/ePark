/*  Device Detect Script
    
    Functions and return values:
    
    deviceDetect.Android() – TRUE if Android
    deviceDetect.BlackBerry() – TRUE if BlackBerry
    deviceDetect.iOS() – TRUE if iOS
    deviceDetect.any() – TRUE if mobile
    isRetina() – TRUE if Retina display

    This script is free to use. You can appreciate it by following my work: http://themeforest.net/user/lukepostulka
*/

var deviceDetect={Android:function(){return navigator.userAgent.match(/Android/i);},BlackBerry:function(){return navigator.userAgent.match(/BlackBerry/i);},iOS:function(){return navigator.userAgent.match(/iPhone|iPad|iPod/i);},Windows:function(){return navigator.userAgent.match(/IEMobile/i);},any:function(){return(deviceDetect.Android()||deviceDetect.BlackBerry()||deviceDetect.iOS()||deviceDetect.Windows());}};var iOS={iPhone:function(){return navigator.userAgent.match(/iPhone/i);},iPad:function(){return navigator.userAgent.match(/iPad/i);},iPod:function(){return navigator.userAgent.match(/iPod/i);},};function isRetina(){if(window.matchMedia){var scn=window.matchMedia("only screen and(min--moz-device-pixel-ratio:1.3),only screen and(-o-min-device-pixel-ratio:2.6/2),only screen and(webkit-min-device-pixel-ratio:1.3),only screen and(min-device-pixel-ratio:1.3),only screen and (min-resolution:1.3dppx)");if((window.devicePixelRatio>1||scn&&scn.matches)){return true;}else{return false;}}}