!function(){"use strict";angular.module("angular-loading-bar",["cfp.loadingBarInterceptor"]),angular.module("chieffancypants.loadingBar",["cfp.loadingBarInterceptor"]),angular.module("cfp.loadingBarInterceptor",["cfp.loadingBar"]).config(["$httpProvider",function(e){var n=["$q","$cacheFactory","$timeout","$rootScope","$log","cfpLoadingBar",function(n,t,a,r,i,c){function o(){a.cancel(d),c.complete(),u=0,s=0}function l(n){var a,r=t.get("$http"),i=e.defaults;!n.cache&&!i.cache||!1===n.cache||"GET"!==n.method&&"JSONP"!==n.method||(a=angular.isObject(n.cache)?n.cache:angular.isObject(i.cache)?i.cache:r);var c=void 0!==a&&void 0!==a.get(n.url);return void 0!==n.cached&&c!==n.cached?n.cached:(n.cached=c,c)}var d,s=0,u=0,g=c.latencyThreshold;return{request:function(e){return e.ignoreLoadingBar||l(e)||(r.$broadcast("cfpLoadingBar:loading",{url:e.url}),0===s&&(d=a(function(){c.start()},g)),s++,c.set(u/s)),e},response:function(e){return e&&e.config?(e.config.ignoreLoadingBar||l(e.config)||(u++,r.$broadcast("cfpLoadingBar:loaded",{url:e.config.url,result:e}),u>=s?o():c.set(u/s)),e):(i.error("Broken interceptor detected: Config object not supplied in response:\n https://github.com/chieffancypants/angular-loading-bar/pull/50"),e)},responseError:function(e){return e&&e.config?(e.config.ignoreLoadingBar||l(e.config)||(u++,r.$broadcast("cfpLoadingBar:loaded",{url:e.config.url,result:e}),u>=s?o():c.set(u/s)),n.reject(e)):(i.error("Broken interceptor detected: Config object not supplied in rejection:\n https://github.com/chieffancypants/angular-loading-bar/pull/50"),n.reject(e))}}}];e.interceptors.push(n)}]),angular.module("cfp.loadingBar",[]).provider("cfpLoadingBar",function(){this.autoIncrement=!0,this.includeSpinner=!0,this.includeBar=!0,this.latencyThreshold=100,this.startSize=.02,this.parentSelector="body",this.spinnerTemplate='<div id="loading-bar-spinner"><div class="spinner-icon"></div></div>',this.loadingBarTemplate='<div id="loading-bar"><div class="bar"><div class="peg"></div></div></div>',this.$get=["$injector","$document","$timeout","$rootScope",function(e,n,t,a){function r(){if(s||(s=e.get("$animate")),t.cancel(g),!v){var r=n[0],c=r.querySelector?r.querySelector(h):n.find(h)[0];c||(c=r.getElementsByTagName("body")[0]);var o=angular.element(c),l=c.lastChild&&angular.element(c.lastChild);a.$broadcast("cfpLoadingBar:started"),v=!0,S&&s.enter(p,o,l),$&&s.enter(m,o,p),i(y)}}function i(e){if(v){var n=100*e+"%";f.css("width",n),B=e,b&&(t.cancel(u),u=t(function(){c()},250))}}function c(){if(!(o()>=1)){var e=0,n=o();e=n>=0&&n<.25?(3*Math.random()+3)/100:n>=.25&&n<.65?3*Math.random()/100:n>=.65&&n<.9?2*Math.random()/100:n>=.9&&n<.99?.005:0;i(o()+e)}}function o(){return B}function l(){B=0,v=!1}function d(){s||(s=e.get("$animate")),a.$broadcast("cfpLoadingBar:completed"),i(1),t.cancel(g),g=t(function(){var e=s.leave(p,l);e&&e.then&&e.then(l),s.leave(m)},500)}var s,u,g,h=this.parentSelector,p=angular.element(this.loadingBarTemplate),f=p.find("div").eq(0),m=angular.element(this.spinnerTemplate),v=!1,B=0,b=this.autoIncrement,$=this.includeSpinner,S=this.includeBar,y=this.startSize;return{start:r,set:i,status:o,inc:c,complete:d,autoIncrement:this.autoIncrement,includeSpinner:this.includeSpinner,latencyThreshold:this.latencyThreshold,parentSelector:this.parentSelector,startSize:this.startSize}}]})}();