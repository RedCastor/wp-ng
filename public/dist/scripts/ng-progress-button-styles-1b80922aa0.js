!function(f){"use strict";function n(c,d,g){return{restrict:"A",transclude:!0,scope:{pbStyle:"@",pbDirection:"@",pbProfile:"@",ngProgressButton:"="},template:'<span class="content" ng-transclude></span><span class="progress"><span class="progress-inner" ng-style="progressStyles" ng-class="{ notransition: !allowProgressTransition }"></span></span>',controller:function(){},link:function(s,o,n){var r;r=d.getProfile(s.pbProfile),s.pbStyle=s.pbStyle||r.style||"fill","lateral-lines"!==s.pbStyle?s.pbDirection=s.pbDirection||r.direction||"horizontal":s.pbDirection="vertical",s.pbPerspective=0===s.pbStyle.indexOf("rotate")||0===s.pbStyle.indexOf("flip-open"),s.pbRandomProgress=n.pbRandomProgress?"false"!==n.pbRandomProgress:r.randomProgress||!0;var e=function(n){var r={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var e in r)if(void 0!==n.style[e])return r[e]}(o[0]),t="vertical"===s.pbDirection?"height":"width";function i(n){s.progressStyles[t]=100*n+"%"}function a(){s.$apply(function(){s.disabled=!1})}function l(n){if(e&&(s.progressStyles.opacity=0,o.on(e,function n(r){("opacity"===r.propertyName||r.originalEvent&&"opacity"===r.originalEvent.propertyName)&&(o.off(e,n),s.$apply(function(){s.allowProgressTransition=!1,i(0),s.progressStyles.opacity=1}))})),"number"==typeof n){var r=0<=n?"state-success":"state-error";o.addClass(r),setTimeout(function(){o.removeClass(r),a()},1500)}else a();o.removeClass("state-loading")}if(s.pbPerspective){var p=f.element('<span class="progress-wrap"></span>');p.append(o.children()),o.append(p),o.addClass("progress-button-perspective")}s.progressStyles={},s.disabled=!1,s.allowProgressTransition=!1,o.addClass("progress-button"),o.addClass("progress-button-dir-"+s.pbDirection),o.addClass("progress-button-style-"+s.pbStyle),s.$watch("disabled",function(n){o.toggleClass("disabled",n)}),s.$watch("ngProgressButton",function(n,r){if(n!==r){if(s.disabled)return;s.disabled=!0,o.addClass("state-loading"),s.allowProgressTransition=!0;var e=null;c.when(n).then(function(){i(1),e&&g.cancel(e),l(1)},function(){e&&g.cancel(e),l(-1)},function(n){s.pbRandomProgress||i(n)}),s.pbRandomProgress&&(t=0,e=g(function(){i(t+=(1-t)*Math.random()*.5)},200))}var t})}}}var r=f.module("ngProgressButtonStyles",[]);r.provider("ngProgressButtonConfig",function(){var e={},t=null,r={style:"fill",direction:"horizontal",randomProgress:!0};this.profile=function(n,r){if(1===arguments.length){if(t)throw Error("Default profile already set.");t=n}else{if(e[n])throw Error("Profile ["+n+"] aready set.");e[n]=r}},this.$get=function(){return{getProfile:function(n){return n&&e[n]?e[n]:t||r}}}}),r.directive("ngProgressButton",n),n.$inject=["$q","ngProgressButtonConfig","$interval"]}(angular);