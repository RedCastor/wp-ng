(function(){"use strict";angular.module("ng-slide-down",[]).directive("ngSlideDown",["$timeout",function(p){var t;return t=function(n,i){return void 0!==i.lazyRender?"<div><div ng-transclude ng-if='lazyRender'></div></div>":"<div><div ng-transclude></div></div>"},{restrict:"A",scope:{expanded:"=ngSlideDown"},transclude:!0,link:function(n,o,i,t,e){var r,u,c,l,a,d,s,h,f,g,v;return u=i.duration||1,v=i.timingFunction||"ease-in-out",c=o.scope(),l=i.emitOnClose,h=i.onClose,s=void 0!==i.lazyRender,f=r=null,a=function(n){var i,t,e,r;for(e=t=0,r=(i=o.children()).length;e<r;e++)t+=i[e].clientHeight;return t+"px"},g=function(){return r&&p.cancel(r),s&&(n.lazyRender=!0),p(function(){return f&&p.cancel(f),o.css({overflowY:"hidden",transitionProperty:"height",transitionDuration:u+"s",transitionTimingFunction:v,height:a()}),f=p(function(){return o.css({overflowY:"visible",transition:"none",height:"auto"})},1e3*u)})},d=function(){if(f&&p.cancel(f),o.css({overflowY:"hidden",transitionProperty:"height",transitionDuration:u+"s",transitionTimingFunction:v,height:"0px"}),l||h||s)return r=p(function(){if(l&&n.$emit(l,{}),h&&c.$eval(h),s)return n.lazyRender=!1},1e3*u)},n.$watch("expanded",function(n,i){return n?p(g):(null!=n&&(o.css({height:a()}),o[0].clientHeight),p(d))})},template:function(n,i){return t(0,i)}}}])}).call(this);