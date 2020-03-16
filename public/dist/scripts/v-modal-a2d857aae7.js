!function(h){"use strict";function e(a,i){return{restrict:"AE",transclude:!0,scope:{close:"&?onclose"},controller:h.noop,link:function(t,o,e,n,l){function r(e){("V-MODAL"===e.target.tagName||function(e){for(;"V-CLOSE"!==e.tagName;)if(!(e=e.parentNode))return!1;return!0}(e.target))&&t.$apply(function(){t.close()})}function c(e){if(!i.closeOnEsc)return!1;27===e.keyCode&&t.$apply(function(){t.close()})}l(t.$parent,function(e){o.append(e)}),t.close=h.isFunction(t.close)?t.close:h.noop,o.on("click",r),a.on("keydown",c),t.$on("$destroy",function(){o.off("click",r),a.off("keydown",c)})}}}function t(d,s,f,v,t,n,m,p,$){return function(e){if(!(!e.template^!e.templateUrl))throw new Error("Expected modal to have exacly one of either `template` or `templateUrl`");var o,l,r=e.controller||null,c=e.controllerAs,a=h.element(e.container||p[0].querySelector($.containerSelector)),i=h.element(p[0].querySelector("html")),u=null;return o=e.template?t.when(e.template):n.get(e.templateUrl,{cache:m}).then(function(e){return e.data}),{activate:function(t){return o.then(function(e){u||function(e,t){if(0===(u=h.element(e)).length)throw new Error("The template contains no elements; you need to wrap text nodes");if(l=f.$new(),r){for(var o in t||(t={}),t)l[o]=t[o];var n=v(r,{$scope:l});c&&(l[c]=n)}else if(t)for(var o in t)l[o]=t[o];s(u)(l),a.attr("v-modal-open",""),i.attr("v-modal-active",""),d.enter(u,a)}(e,t)})},deactivate:function(){return u?d.leave(u).then(function(){l.$destroy(),l=null,u.remove(),u=null,a.removeAttr("v-modal-open"),i.removeAttr("v-modal-active","")}):t.when()},active:function(){return!!u}}}}h.module("vModal.config",[]).constant("modalConfig",{containerSelector:"body",closeOnEsc:!0}),h.module("vModal.directives",[]),h.module("vModal.services",[]),h.module("vModal",["vModal.config","vModal.directives","vModal.services"]),h.module("vModal.directives").directive("vClose",function(){return{restrict:"E",scope:{label:"@"},link:function(e,t,o){e.label&&o.$set("aria-label",e.label),o.$set("role","button"),o.$set("tabindex",0)}}}),h.module("vModal.directives").directive("vDialog",function(){return{restrict:"AE",require:"^vModal",transclude:!0,scope:{heading:"@",role:"@"},link:function(e,t,o,n,l){l(e.$parent,function(e){t.append(e)}),e.heading&&o.$set("aria-label",e.heading),o.$set("role","dialog"),o.$set("tabindex",-1),t[0].focus(),setTimeout(function(){t[0].focus()},0)}}}),h.module("vModal.directives").directive("vModal",e),e.$inject=["$document","modalConfig"],h.module("vModal.services").factory("vModal",t),t.$inject=["$animate","$compile","$rootScope","$controller","$q","$http","$templateCache","$document","modalConfig"]}(angular);