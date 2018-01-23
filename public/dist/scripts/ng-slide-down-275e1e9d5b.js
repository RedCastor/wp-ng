(function(){"use strict";angular.module("ng-slide-down",[]).directive("ngSlideDown",["$timeout",function(n){var i,t;return i=function(n,i){return void 0!==i.lazyRender?"<div><div ng-transclude ng-if='lazyRender'></div></div>":"<div><div ng-transclude></div></div>"},t=function(i,t,e,r,o){var u,c,l,a,d,s,h,f,g,v,p;return c=e.duration||1,p=e.timingFunction||"ease-in-out",l=t.scope(),a=e.emitOnClose,f=e.onClose,h=void 0!==e.lazyRender,u=null,g=null,d=function(n){var i,e,r,o,u;for(r=0,e=t.children(),o=0,u=e.length;o<u;o++)i=e[o],r+=i.clientHeight;return r+"px"},v=function(){return u&&n.cancel(u),h&&(i.lazyRender=!0),n(function(){return g&&n.cancel(g),t.css({overflowY:"hidden",transitionProperty:"height",transitionDuration:c+"s",transitionTimingFunction:p,height:d()}),g=n(function(){return t.css({overflowY:"visible",transition:"none",height:"auto"})},1e3*c)})},s=function(){if(g&&n.cancel(g),t.css({overflowY:"hidden",transitionProperty:"height",transitionDuration:c+"s",transitionTimingFunction:p,height:"0px"}),a||f||h)return u=n(function(){if(a&&i.$emit(a,{}),f&&l.$eval(f),h)return i.lazyRender=!1},1e3*c)},i.$watch("expanded",function(i,e){return i?n(v):(null!=i&&(t.css({height:d()}),t[0].clientHeight),n(s))})},{restrict:"A",scope:{expanded:"=ngSlideDown"},transclude:!0,link:t,template:function(n,t){return i(n,t)}}}])}).call(this);