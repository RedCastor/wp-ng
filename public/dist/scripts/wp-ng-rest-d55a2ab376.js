!function(e){"use strict";var s=e.module("wpNgRest",["ngResource"]);s.config(["$resourceProvider",function(e){e.defaults.cancellable=!0}]),s.provider("wpNgRest",[function(){this.nonce={key:"X-WP-NG-Nonce",val:""},this.rest={url:"localhost/",path:""},this.lang={key:"X-WP-NG-Lang",val:""},this.$get=["$http",function(s){var t=this.nonce,a=this.rest,n=this.lang;return e.isDefined(t.key)&&e.isDefined(t.val)&&t.key.length>0&&t.val.length>0&&(s.defaults.headers.common[t.key]=t.val),e.isDefined(n.key)&&e.isDefined(n.val)&&n.key.length>0&&n.val.length>0&&(s.defaults.headers.common[n.key]=n.val),s.defaults.useXDomain=!0,s.defaults.headers.common["If-Modified-Since"]="0",s.defaults.headers.common["cache-control"]="private, max-age=0, no-cache",{getNonce:function(){return t},getRest:function(){return a},getLang:function(){return n}}}],this.setNonce=function(e){this.nonce=e},this.setRest=function(e){this.rest=e},this.setLang=function(e){this.lang=e}}]),s.factory("wpNgRestStatus",["$rootScope",function(s){var t={reset:function(){return{success:!1,statusCode:null,code:null,message:null}},setSuccess:function(s){var t={success:!0,statusCode:null,code:null,message:null};return t.statusCode=s.status,void 0!==s.messages&&e.isArray(s.messages)?(t.code=s.messages[0].code,t.message=s.messages[0].message):void 0!==s.message&&e.isObject(s.message)?(t.code=s.message.code,t.message=s.message.message):void 0!==s.message&&(t.message=s.message),t},setError:function(s){var t={success:!1,statusCode:null,code:null,message:null};return t.statusCode=s.status,null===s.data||void 0===s.data?(t.code=s.status,t.message="An error occured on request"):(t.code=s.data.code,t.message=s.data.message,e.isDefined(s.data.data)&&e.isObject(s.data.data)&&e.isDefined(s.data.data.errors)&&(t.errors=s.data.data.errors)),t},sendEvent:function(e,t){s.$broadcast(e,t)}};return t}])}(angular);