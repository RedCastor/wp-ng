!function(u,e){"use strict";var t=u.module("rcGalleryGalleria",[]);t.provider("rcGalleryGalleria",[function(){this.loadUrls=[],this.setUrls=function(e){u.isArray(e)&&(this.loadUrls=e)},this.setThemeUrls=function(e){u.isArray(e)&&(this.themeUrls=e)},this.$get=[function(){var e=this.loadUrls,t=this.themeUrls;return{getLoadUrls:function(){return e},getThemeUrls:function(){return t}}}]}]),t.directive("rcgGalleria",["$interval","rcGalleryGalleria",function(o,d){return{restrict:"EA",require:"^rc-gallery",link:function(e,t,r,a){var s,i,n;function h(){o.cancel(n)}a.addLoadUrls(d.getLoadUrls()),e.$on("$destroy",function(){s&&s.destroy&&s.destroy()}),i=e.$watch(function(){return a.isReady},function(e){if(!0===e){i();var l=0;n=o(function(){if(0!==a.mediaGalleryElement.length&&u.isDefined(window.Galleria)){if(h(),a.theme&&0<a.theme.length&&u.extend(a.options,{theme:a.theme}),a.width){var e=a.width.substr(a.width.length-2),t=parseFloat(a.width.substr(0,e.length+1));"vw"===e&&(t=a.vwTOpx(parseFloat(t,10))),isNaN(t)||u.extend(a.options,{width:t})}if(a.height){var r=a.height.substr(a.height.length-2),i=parseFloat(a.height.substr(0,r.length+1));"vh"===r&&(i=a.vhTOpx(i)),isNaN(i)||u.extend(a.options,{height:i})}var n=u.extend({},a.options,{extend:function(){s=this}});u.forEach(d.getThemeUrls(),function(e){Galleria.loadTheme(e)}),Galleria.run(a.mediaGalleryElement,n),a.setMediaReady()}else 240<=l&&h();l++},250)}})}}}])}(angular,jQuery);