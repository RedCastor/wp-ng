!function(t,e){"function"==typeof define&&define.amd?define([],function(){return e()}):"object"==typeof exports?module.exports=e():e()}(this,function(){function t(t){"use strict";var e=t.storageKey(),n=t.storage(),r=function(){var r=t.preferredLanguage();angular.isString(r)?t.use(r):n.put(e,t.use())};r.displayName="fallbackFromIncorrectStorageValue",n?n.get(e)?t.use(n.get(e)).catch(r):r():angular.isString(t.preferredLanguage())&&t.use(t.preferredLanguage())}function e(){"use strict";var t,e,n,r=null,a=!1,i=!1;n={sanitize:function(t,e){return"text"===e&&(t=o(t)),t},escape:function(t,e){return"text"===e&&(t=s(t)),t},sanitizeParameters:function(t,e){return"params"===e&&(t=l(t,o)),t},escapeParameters:function(t,e){return"params"===e&&(t=l(t,s)),t},sce:function(t,e,n){return"text"===e?t=u(t):"params"===e&&"filter"!==n&&(t=l(t,s)),t},sceParameters:function(t,e){return"params"===e&&(t=l(t,u)),t}},n.escaped=n.escapeParameters,this.addStrategy=function(t,e){return n[t]=e,this},this.removeStrategy=function(t){return delete n[t],this},this.useStrategy=function(t){return a=!0,r=t,this},this.$get=["$injector","$log",function(s,o){var u={},l=function(t,e,r,a){return angular.forEach(a,function(a){if(angular.isFunction(a))t=a(t,e,r);else if(angular.isFunction(n[a]))t=n[a](t,e,r);else{if(!angular.isString(n[a]))throw new Error("pascalprecht.translate.$translateSanitization: Unknown sanitization strategy: '"+a+"'");if(!u[n[a]])try{u[n[a]]=s.get(n[a])}catch(t){throw u[n[a]]=function(){},new Error("pascalprecht.translate.$translateSanitization: Unknown sanitization strategy: '"+a+"'")}t=u[n[a]](t,e,r)}}),t},c=function(){a||i||(o.warn("pascalprecht.translate.$translateSanitization: No sanitization strategy has been configured. This can have serious security implications. See http://angular-translate.github.io/docs/#/guide/19_security for details."),i=!0)};return s.has("$sanitize")&&(t=s.get("$sanitize")),s.has("$sce")&&(e=s.get("$sce")),{useStrategy:function(t){return function(e){t.useStrategy(e)}}(this),sanitize:function(t,e,n,a){if(r||c(),n||null===n||(n=r),!n)return t;a||(a="service");var i=angular.isArray(n)?n:[n];return l(t,e,a,i)}}}];var s=function(t){var e=angular.element("<div></div>");return e.text(t),e.html()},o=function(e){if(!t)throw new Error("pascalprecht.translate.$translateSanitization: Error cannot find $sanitize service. Either include the ngSanitize module (https://docs.angularjs.org/api/ngSanitize) or use a sanitization strategy which does not depend on $sanitize, such as 'escape'.");return t(e)},u=function(t){if(!e)throw new Error("pascalprecht.translate.$translateSanitization: Error cannot find $sce service.");return e.trustAsHtml(t)},l=function(t,e,n){if(angular.isDate(t))return t;if(angular.isObject(t)){var r=angular.isArray(t)?[]:{};if(n){if(n.indexOf(t)>-1)throw new Error("pascalprecht.translate.$translateSanitization: Error cannot interpolate parameter due recursive object")}else n=[];return n.push(t),angular.forEach(t,function(t,a){angular.isFunction(t)||(r[a]=l(t,e,n))}),n.splice(-1,1),r}return angular.isNumber(t)?t:e(t)}}function n(t,e,n,r){"use strict";var a,i,s,o,u,l,c,f,g,p,h,d,v,$,m,y,b={},L=[],S=t,w=[],j="translate-cloak",N=!1,C=!1,E=".",P=!1,O=!1,k=0,A=!0,T="default",x={default:function(t){return(t||"").split("-").join("_")},java:function(t){var e=(t||"").split("-").join("_"),n=e.split("_");return n.length>1?n[0].toLowerCase()+"_"+n[1].toUpperCase():e},bcp47:function(t){var e=(t||"").split("_").join("-"),n=e.split("-");return n.length>1?n[0].toLowerCase()+"-"+n[1].toUpperCase():e},"iso639-1":function(t){var e=(t||"").split("_").join("-"),n=e.split("-");return n[0].toLowerCase()}},F="2.13.0",z=function(){if(angular.isFunction(r.getLocale))return r.getLocale();var t,n,a=e.$get().navigator,i=["language","browserLanguage","systemLanguage","userLanguage"];if(angular.isArray(a.languages))for(t=0;t<a.languages.length;t++)if(n=a.languages[t],n&&n.length)return n;for(t=0;t<i.length;t++)if(n=a[i[t]],n&&n.length)return n;return null};z.displayName="angular-translate/service: getFirstBrowserLanguage";var I=function(){var t=z()||"";return x[T]&&(t=x[T](t)),t};I.displayName="angular-translate/service: getLocale";var R=function(t,e){for(var n=0,r=t.length;n<r;n++)if(t[n]===e)return n;return-1},V=function(){return this.toString().replace(/^\s+|\s+$/g,"")},_=function(t){if(t){for(var e=[],n=angular.lowercase(t),r=0,a=L.length;r<a;r++)e.push(angular.lowercase(L[r]));if(R(e,n)>-1)return t;if(i){var s;for(var o in i)if(i.hasOwnProperty(o)){var u=!1,l=Object.prototype.hasOwnProperty.call(i,o)&&angular.lowercase(o)===angular.lowercase(t);if("*"===o.slice(-1)&&(u=o.slice(0,-1)===t.slice(0,o.length-1)),(l||u)&&(s=i[o],R(e,angular.lowercase(s))>-1))return s}}var c=t.split("_");return c.length>1&&R(e,angular.lowercase(c[0]))>-1?c[0]:void 0}},D=function(t,e){if(!t&&!e)return b;if(t&&!e){if(angular.isString(t))return b[t]}else angular.isObject(b[t])||(b[t]={}),angular.extend(b[t],K(e));return this};this.translations=D,this.cloakClassName=function(t){return t?(j=t,this):j},this.nestedObjectDelimeter=function(t){return t?(E=t,this):E};var K=function(t,e,n,r){var a,i,s,o;e||(e=[]),n||(n={});for(a in t)Object.prototype.hasOwnProperty.call(t,a)&&(o=t[a],angular.isObject(o)?K(o,e.concat(a),n,a):(i=e.length?""+e.join(E)+E+a:a,e.length&&a===r&&(s=""+e.join(E),n[s]="@:"+i),n[i]=o));return n};K.displayName="flatObject",this.addInterpolation=function(t){return w.push(t),this},this.useMessageFormatInterpolation=function(){return this.useInterpolation("$translateMessageFormatInterpolation")},this.useInterpolation=function(t){return p=t,this},this.useSanitizeValueStrategy=function(t){return n.useStrategy(t),this},this.preferredLanguage=function(t){return t?(M(t),this):a};var M=function(t){return t&&(a=t),a};this.translationNotFoundIndicator=function(t){return this.translationNotFoundIndicatorLeft(t),this.translationNotFoundIndicatorRight(t),this},this.translationNotFoundIndicatorLeft=function(t){return t?(v=t,this):v},this.translationNotFoundIndicatorRight=function(t){return t?($=t,this):$},this.fallbackLanguage=function(t){return U(t),this};var U=function(t){return t?(angular.isString(t)?(o=!0,s=[t]):angular.isArray(t)&&(o=!1,s=t),angular.isString(a)&&R(s,a)<0&&s.push(a),this):o?s[0]:s};this.use=function(t){if(t){if(!b[t]&&!h)throw new Error("$translateProvider couldn't find translationTable for langKey: '"+t+"'");return u=t,this}return u},this.resolveClientLocale=function(){return I()};var H=function(t){return t?(S=t,this):f?f+S:S};this.storageKey=H,this.useUrlLoader=function(t,e){return this.useLoader("$translateUrlLoader",angular.extend({url:t},e))},this.useStaticFilesLoader=function(t){return this.useLoader("$translateStaticFilesLoader",t)},this.useLoader=function(t,e){return h=t,d=e||{},this},this.useLocalStorage=function(){return this.useStorage("$translateLocalStorage")},this.useCookieStorage=function(){return this.useStorage("$translateCookieStorage")},this.useStorage=function(t){return c=t,this},this.storagePrefix=function(t){return t?(f=t,this):t},this.useMissingTranslationHandlerLog=function(){return this.useMissingTranslationHandler("$translateMissingTranslationHandlerLog")},this.useMissingTranslationHandler=function(t){return g=t,this},this.usePostCompiling=function(t){return N=!!t,this},this.forceAsyncReload=function(t){return C=!!t,this},this.uniformLanguageTag=function(t){return t?angular.isString(t)&&(t={standard:t}):t={},T=t.standard,this},this.determinePreferredLanguage=function(t){var e=t&&angular.isFunction(t)?t():I();return a=L.length?_(e)||e:e,this},this.registerAvailableLanguageKeys=function(t,e){return t?(L=t,e&&(i=e),this):L},this.useLoaderCache=function(t){return t===!1?m=void 0:t===!0?m=!0:"undefined"==typeof t?m="$translationCache":t&&(m=t),this},this.directivePriority=function(t){return void 0===t?k:(k=t,this)},this.statefulFilter=function(t){return void 0===t?A:(A=t,this)},this.postProcess=function(t){return y=t?t:void 0,this},this.keepContent=function(t){return O=!!t,this},this.$get=["$log","$injector","$rootScope","$q",function(t,e,n,r){var i,f,T,x=e.get(p||"$translateDefaultInterpolation"),z=!1,G={},q={},Y=function(t,e,n,o,l){!u&&a&&(u=a);var g=l&&l!==u?_(l)||l:u;if(l&&ct(l),angular.isArray(t)){var p=function(t){for(var a={},i=[],s=function(t){var i=r.defer(),s=function(e){a[t]=e,i.resolve([t,e])};return Y(t,e,n,o,l).then(s,s),i.promise},u=0,c=t.length;u<c;u++)i.push(s(t[u]));return r.all(i).then(function(){return a})};return p(t)}var h=r.defer();t&&(t=V.apply(t));var d=function(){var t=a?q[a]:q[g];if(f=0,c&&!t){var e=i.get(S);if(t=q[e],s&&s.length){var n=R(s,e);f=0===n?1:0,R(s,a)<0&&s.push(a)}}return t}();if(d){var v=function(){l||(g=u),st(t,e,n,o,g).then(h.resolve,h.reject)};v.displayName="promiseResolved",d.finally(v)}else st(t,e,n,o,g).then(h.resolve,h.reject);return h.promise},B=function(t){return v&&(t=[v,t].join(" ")),$&&(t=[t,$].join(" ")),t},J=function(t){u=t,c&&i.put(Y.storageKey(),u),n.$emit("$translateChangeSuccess",{language:t}),x.setLocale(u);var e=function(t,e){G[e].setLocale(u)};e.displayName="eachInterpolatorLocaleSetter",angular.forEach(G,e),n.$emit("$translateChangeEnd",{language:t})},Q=function(t){if(!t)throw"No language key specified for loading.";var a=r.defer();n.$emit("$translateLoadingStart",{language:t}),z=!0;var i=m;"string"==typeof i&&(i=e.get(i));var s=angular.extend({},d,{key:t,$http:angular.extend({},{cache:i},d.$http)}),o=function(e){var r={};n.$emit("$translateLoadingSuccess",{language:t}),angular.isArray(e)?angular.forEach(e,function(t){angular.extend(r,K(t))}):angular.extend(r,K(e)),z=!1,a.resolve({key:t,table:r}),n.$emit("$translateLoadingEnd",{language:t})};o.displayName="onLoaderSuccess";var u=function(t){n.$emit("$translateLoadingError",{language:t}),a.reject(t),n.$emit("$translateLoadingEnd",{language:t})};return u.displayName="onLoaderError",e.get(h)(s).then(o,u),a.promise};if(c&&(i=e.get(c),!i.get||!i.put))throw new Error("Couldn't use storage '"+c+"', missing get() or put() method!");if(w.length){var W=function(t){var n=e.get(t);n.setLocale(a||u),G[n.getInterpolationIdentifier()]=n};W.displayName="interpolationFactoryAdder",angular.forEach(w,W)}var X=function(t){var e=r.defer();if(Object.prototype.hasOwnProperty.call(b,t))e.resolve(b[t]);else if(q[t]){var n=function(t){D(t.key,t.table),e.resolve(t.table)};n.displayName="translationTableResolver",q[t].then(n,e.reject)}else e.reject();return e.promise},Z=function(t,e,n,a){var i=r.defer(),s=function(r){if(Object.prototype.hasOwnProperty.call(r,e)){a.setLocale(t);var s=r[e];if("@:"===s.substr(0,2))Z(t,s.substr(2),n,a).then(i.resolve,i.reject);else{var o=a.interpolate(r[e],n,"service");o=lt(e,r[e],o,n,t),i.resolve(o)}a.setLocale(u)}else i.reject()};return s.displayName="fallbackTranslationResolver",X(t).then(s,i.reject),i.promise},tt=function(t,e,n,r,a){var i,s=b[t];if(s&&Object.prototype.hasOwnProperty.call(s,e)){if(r.setLocale(t),i=r.interpolate(s[e],n,"filter",a),i=lt(e,s[e],i,n,t,a),!angular.isString(i)&&angular.isFunction(i.$$unwrapTrustedValue)){var o=i.$$unwrapTrustedValue();if("@:"===o.substr(0,2))return tt(t,o.substr(2),n,r,a)}else if("@:"===i.substr(0,2))return tt(t,i.substr(2),n,r,a);r.setLocale(u)}return i},et=function(t,n,r,a){return g?e.get(g)(t,u,n,r,a):t},nt=function(t,e,n,a,i){var o=r.defer();if(t<s.length){var u=s[t];Z(u,e,n,a).then(function(t){o.resolve(t)},function(){return nt(t+1,e,n,a,i).then(o.resolve,o.reject)})}else if(i)o.resolve(i);else{var l=et(e,n,i);g&&l?o.resolve(l):o.reject(B(e))}return o.promise},rt=function(t,e,n,r,a){var i;if(t<s.length){var o=s[t];i=tt(o,e,n,r,a),i||""===i||(i=rt(t+1,e,n,r))}return i},at=function(t,e,n,r){return nt(T>0?T:f,t,e,n,r)},it=function(t,e,n,r){return rt(T>0?T:f,t,e,n,r)},st=function(t,e,n,a,i){var o=r.defer(),u=i?b[i]:b,l=n?G[n]:x;if(u&&Object.prototype.hasOwnProperty.call(u,t)){var c=u[t];if("@:"===c.substr(0,2))Y(c.substr(2),e,n,a,i).then(o.resolve,o.reject);else{var f=l.interpolate(c,e,"service");f=lt(t,c,f,e,i),o.resolve(f)}}else{var p;g&&!z&&(p=et(t,e,a)),i&&s&&s.length?at(t,e,l,a).then(function(t){o.resolve(t)},function(t){o.reject(B(t))}):g&&!z&&p?a?o.resolve(a):o.resolve(p):a?o.resolve(a):o.reject(B(t))}return o.promise},ot=function(t,e,n,r,a){var i,o=r?b[r]:b,u=x;if(G&&Object.prototype.hasOwnProperty.call(G,n)&&(u=G[n]),o&&Object.prototype.hasOwnProperty.call(o,t)){var l=o[t];"@:"===l.substr(0,2)?i=ot(l.substr(2),e,n,r,a):(i=u.interpolate(l,e,"filter",a),i=lt(t,l,i,e,r,a))}else{var c;g&&!z&&(c=et(t,e,a)),r&&s&&s.length?(f=0,i=it(t,e,u,a)):i=g&&!z&&c?c:B(t)}return i},ut=function(t){l===t&&(l=void 0),q[t]=void 0},lt=function(t,n,r,a,i,s){var o=y;return o&&("string"==typeof o&&(o=e.get(o)),o)?o(t,n,r,a,i,s):r},ct=function(t){b[t]||!h||q[t]||(q[t]=Q(t).then(function(t){return D(t.key,t.table),t}))};Y.preferredLanguage=function(t){return t&&M(t),a},Y.cloakClassName=function(){return j},Y.nestedObjectDelimeter=function(){return E},Y.fallbackLanguage=function(t){if(void 0!==t&&null!==t){if(U(t),h&&s&&s.length)for(var e=0,n=s.length;e<n;e++)q[s[e]]||(q[s[e]]=Q(s[e]));Y.use(Y.use())}return o?s[0]:s},Y.useFallbackLanguage=function(t){if(void 0!==t&&null!==t)if(t){var e=R(s,t);e>-1&&(T=e)}else T=0},Y.proposedLanguage=function(){return l},Y.storage=function(){return i},Y.negotiateLocale=_,Y.use=function(t){if(!t)return u;var e=r.defer();n.$emit("$translateChangeStart",{language:t});var a=_(t);return L.length>0&&!a?r.reject(t):(a&&(t=a),l=t,!C&&b[t]||!h||q[t]?q[t]?q[t].then(function(t){return l===t.key&&J(t.key),e.resolve(t.key),t},function(t){return!u&&s&&s.length>0&&s[0]!==t?Y.use(s[0]).then(e.resolve,e.reject):e.reject(t)}):(e.resolve(t),J(t)):(q[t]=Q(t).then(function(n){return D(n.key,n.table),e.resolve(n.key),l===t&&J(n.key),n},function(t){return n.$emit("$translateChangeError",{language:t}),e.reject(t),n.$emit("$translateChangeEnd",{language:t}),r.reject(t)}),q[t].finally(function(){ut(t)})),e.promise)},Y.resolveClientLocale=function(){return I()},Y.storageKey=function(){return H()},Y.isPostCompilingEnabled=function(){return N},Y.isForceAsyncReloadEnabled=function(){return C},Y.isKeepContent=function(){return O},Y.refresh=function(t){function e(){i.resolve(),n.$emit("$translateRefreshEnd",{language:t})}function a(){i.reject(),n.$emit("$translateRefreshEnd",{language:t})}if(!h)throw new Error("Couldn't refresh translation table, no loader registered!");var i=r.defer();if(n.$emit("$translateRefreshStart",{language:t}),t)if(b[t]){var o=function(n){return D(n.key,n.table),t===u&&J(u),e(),n};o.displayName="refreshPostProcessor",Q(t).then(o,a)}else a();else{var l=[],c={};if(s&&s.length)for(var f=0,g=s.length;f<g;f++)l.push(Q(s[f])),c[s[f]]=!0;u&&!c[u]&&l.push(Q(u));var p=function(t){b={},angular.forEach(t,function(t){D(t.key,t.table)}),u&&J(u),e()};p.displayName="refreshPostProcessor",r.all(l).then(p,a)}return i.promise},Y.instant=function(t,e,n,r,i){var o=r&&r!==u?_(r)||r:u;if(null===t||angular.isUndefined(t))return t;if(r&&ct(r),angular.isArray(t)){for(var l={},c=0,f=t.length;c<f;c++)l[t[c]]=Y.instant(t[c],e,n,r,i);return l}if(angular.isString(t)&&t.length<1)return t;t&&(t=V.apply(t));var p,h=[];a&&h.push(a),o&&h.push(o),s&&s.length&&(h=h.concat(s));for(var d=0,m=h.length;d<m;d++){var y=h[d];if(b[y]&&"undefined"!=typeof b[y][t]&&(p=ot(t,e,n,o,i)),"undefined"!=typeof p)break}if(!p&&""!==p)if(v||$)p=B(t);else{p=x.interpolate(t,e,"filter",i);var L;g&&!z&&(L=et(t,e,i)),g&&!z&&L&&(p=L)}return p},Y.versionInfo=function(){return F},Y.loaderCache=function(){return m},Y.directivePriority=function(){return k},Y.statefulFilter=function(){return A},Y.isReady=function(){return P};var ft=r.defer();ft.promise.then(function(){P=!0}),Y.onReady=function(t){var e=r.defer();return angular.isFunction(t)&&e.promise.then(t),P?e.resolve():ft.promise.then(e.resolve),e.promise},Y.getAvailableLanguageKeys=function(){return L.length>0?L:null},Y.getTranslationTable=function(t){return t=t||Y.use(),t&&b[t]?angular.copy(b[t]):null};var gt=n.$on("$translateReady",function(){ft.resolve(),gt(),gt=null}),pt=n.$on("$translateChangeEnd",function(){ft.resolve(),pt(),pt=null});if(h){if(angular.equals(b,{})&&Y.use()&&Y.use(Y.use()),s&&s.length)for(var ht=function(t){return D(t.key,t.table),n.$emit("$translateChangeEnd",{language:t.key}),t},dt=0,vt=s.length;dt<vt;dt++){var $t=s[dt];!C&&b[$t]||(q[$t]=Q($t).then(ht))}}else n.$emit("$translateReady",{language:Y.use()});return Y}]}function r(t,e){"use strict";var n,r={},a="default";return r.setLocale=function(t){n=t},r.getInterpolationIdentifier=function(){return a},r.useSanitizeValueStrategy=function(t){return e.useStrategy(t),this},r.interpolate=function(n,r,a,i){r=r||{},r=e.sanitize(r,"params",i,a);var s;return angular.isNumber(n)?s=""+n:angular.isString(n)?(s=t(n)(r),s=e.sanitize(s,"text",i,a)):s="",s},r}function a(t,e,n,r,a){"use strict";var s=function(){return this.toString().replace(/^\s+|\s+$/g,"")};return{restrict:"AE",scope:!0,priority:t.directivePriority(),compile:function(o,u){var l=u.translateValues?u.translateValues:void 0,c=u.translateInterpolation?u.translateInterpolation:void 0,f=o[0].outerHTML.match(/translate-value-+/i),g="^(.*)("+e.startSymbol()+".*"+e.endSymbol()+")(.*)",p="^(.*)"+e.startSymbol()+"(.*)"+e.endSymbol()+"(.*)";return function(o,h,d){o.interpolateParams={},o.preText="",o.postText="",o.translateNamespace=i(o);var v={},$=function(t,e,n){if(e.translateValues&&angular.extend(t,r(e.translateValues)(o.$parent)),f)for(var a in n)if(Object.prototype.hasOwnProperty.call(e,a)&&"translateValue"===a.substr(0,14)&&"translateValues"!==a){var i=angular.lowercase(a.substr(14,1))+a.substr(15);t[i]=n[a]}},m=function(t){if(angular.isFunction(m._unwatchOld)&&(m._unwatchOld(),m._unwatchOld=void 0),angular.equals(t,"")||!angular.isDefined(t)){var n=s.apply(h.text()),r=n.match(g);if(angular.isArray(r)){o.preText=r[1],o.postText=r[3],v.translate=e(r[2])(o.$parent);var a=n.match(p);angular.isArray(a)&&a[2]&&a[2].length&&(m._unwatchOld=o.$watch(a[2],function(t){v.translate=t,j()}))}else v.translate=n?n:void 0}else v.translate=t;j()},y=function(t){d.$observe(t,function(e){v[t]=e,j()})};$(o.interpolateParams,d,u);var b=!0;d.$observe("translate",function(t){"undefined"==typeof t?m(""):""===t&&b||(v.translate=t,j()),b=!1});for(var L in d)d.hasOwnProperty(L)&&"translateAttr"===L.substr(0,13)&&L.length>13&&y(L);if(d.$observe("translateDefault",function(t){o.defaultText=t,j()}),l&&d.$observe("translateValues",function(t){t&&o.$parent.$watch(function(){angular.extend(o.interpolateParams,r(t)(o.$parent))})}),f){var S=function(t){d.$observe(t,function(e){var n=angular.lowercase(t.substr(14,1))+t.substr(15);o.interpolateParams[n]=e})};for(var w in d)Object.prototype.hasOwnProperty.call(d,w)&&"translateValue"===w.substr(0,14)&&"translateValues"!==w&&S(w)}var j=function(){for(var t in v)v.hasOwnProperty(t)&&void 0!==v[t]&&N(t,v[t],o,o.interpolateParams,o.defaultText,o.translateNamespace)},N=function(e,n,r,a,i,s){n?(s&&"."===n.charAt(0)&&(n=s+n),t(n,a,c,i,r.translateLanguage).then(function(t){C(t,r,!0,e)},function(t){C(t,r,!1,e)})):C(n,r,!1,e)},C=function(e,r,a,i){if(a||"undefined"!=typeof r.defaultText&&(e=r.defaultText),"translate"===i){(a||!a&&!t.isKeepContent()&&"undefined"==typeof d.translateKeepContent)&&h.empty().append(r.preText+e+r.postText);var s=t.isPostCompilingEnabled(),o="undefined"!=typeof u.translateCompile,l=o&&"false"!==u.translateCompile;(s&&!o||l)&&n(h.contents())(r)}else{var c=d.$attr[i];"data-"===c.substr(0,5)&&(c=c.substr(5)),c=c.substr(15),h.attr(c,e)}};(l||f||d.translateDefault)&&o.$watch("interpolateParams",j,!0),o.$on("translateLanguageChanged",j);var E=a.$on("$translateChangeSuccess",j);h.text().length?m(d.translate?d.translate:""):d.translate&&m(d.translate),j(),o.$on("$destroy",E)}}}}function i(t){"use strict";return t.translateNamespace?t.translateNamespace:t.$parent?i(t.$parent):void 0}function s(t,e){"use strict";return{restrict:"A",priority:t.directivePriority(),link:function(n,r,a){var i,s,u={},l=function(){angular.forEach(i,function(e,i){e&&(u[i]=!0,n.translateNamespace&&"."===e.charAt(0)&&(e=n.translateNamespace+e),t(e,s,a.translateInterpolation,void 0,n.translateLanguage).then(function(t){r.attr(i,t)},function(t){r.attr(i,t)}))}),angular.forEach(u,function(t,e){i[e]||(r.removeAttr(e),delete u[e])})};o(n,a.translateAttr,function(t){i=t},l),o(n,a.translateValues,function(t){s=t},l),a.translateValues&&n.$watch(a.translateValues,l,!0),n.$on("translateLanguageChanged",l);var c=e.$on("$translateChangeSuccess",l);l(),n.$on("$destroy",c)}}}function o(t,e,n,r){"use strict";e&&("::"===e.substr(0,2)?e=e.substr(2):t.$watch(e,function(t){n(t),r()},!0),n(t.$eval(e)))}function u(t,e){"use strict";return{compile:function(n){var r=function(){n.addClass(t.cloakClassName())},a=function(){n.removeClass(t.cloakClassName())};return t.onReady(function(){a()}),r(),function(n,i,s){s.translateCloak&&s.translateCloak.length&&(s.$observe("translateCloak",function(e){t(e).then(a,r)}),e.$on("$translateChangeSuccess",function(){t(s.translateCloak).then(a,r)}))}}}}function l(){"use strict";return{restrict:"A",scope:!0,compile:function(){return{pre:function(t,e,n){t.translateNamespace=i(t),t.translateNamespace&&"."===n.translateNamespace.charAt(0)?t.translateNamespace+=n.translateNamespace:t.translateNamespace=n.translateNamespace}}}}}function i(t){"use strict";return t.translateNamespace?t.translateNamespace:t.$parent?i(t.$parent):void 0}function c(){"use strict";return{restrict:"A",scope:!0,compile:function(){return function(t,e,n){n.$observe("translateLanguage",function(e){t.translateLanguage=e}),t.$watch("translateLanguage",function(){t.$broadcast("translateLanguageChanged")})}}}}function f(t,e){"use strict";var n=function(n,r,a,i){return angular.isObject(r)||(r=t(r)(this)),e.instant(n,r,a,i)};return e.statefulFilter()&&(n.$stateful=!0),n}function g(t){"use strict";return t("translations")}return t.$inject=["$translate"],n.$inject=["$STORAGE_KEY","$windowProvider","$translateSanitizationProvider","pascalprechtTranslateOverrider"],r.$inject=["$interpolate","$translateSanitization"],a.$inject=["$translate","$interpolate","$compile","$parse","$rootScope"],s.$inject=["$translate","$rootScope"],u.$inject=["$translate","$rootScope"],f.$inject=["$parse","$translate"],g.$inject=["$cacheFactory"],angular.module("pascalprecht.translate",["ng"]).run(t),t.displayName="runTranslate",angular.module("pascalprecht.translate").provider("$translateSanitization",e),angular.module("pascalprecht.translate").constant("pascalprechtTranslateOverrider",{}).provider("$translate",n),n.displayName="displayName",angular.module("pascalprecht.translate").factory("$translateDefaultInterpolation",r),r.displayName="$translateDefaultInterpolation",angular.module("pascalprecht.translate").constant("$STORAGE_KEY","NG_TRANSLATE_LANG_KEY"),angular.module("pascalprecht.translate").directive("translate",a),a.displayName="translateDirective",angular.module("pascalprecht.translate").directive("translateAttr",s),s.displayName="translateAttrDirective",angular.module("pascalprecht.translate").directive("translateCloak",u),u.displayName="translateCloakDirective",angular.module("pascalprecht.translate").directive("translateNamespace",l),l.displayName="translateNamespaceDirective",angular.module("pascalprecht.translate").directive("translateLanguage",c),c.displayName="translateLanguageDirective",angular.module("pascalprecht.translate").filter("translate",f),f.displayName="translateFilterFactory",angular.module("pascalprecht.translate").factory("$translationCache",g),g.displayName="$translationCache","pascalprecht.translate"});