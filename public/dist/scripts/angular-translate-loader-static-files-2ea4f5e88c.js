!function(e,i){"function"==typeof define&&define.amd?define([],function(){return i()}):"object"==typeof exports?module.exports=i():i()}(this,function(){function e(e,i){"use strict";return function(r){if(!(r&&(angular.isArray(r.files)||angular.isString(r.prefix)&&angular.isString(r.suffix))))throw new Error("Couldn't load static files, no files and prefix or suffix specified!");r.files||(r.files=[{prefix:r.prefix,suffix:r.suffix}]);for(var t=function(t){if(!t||!angular.isString(t.prefix)||!angular.isString(t.suffix))throw new Error("Couldn't load static file, no prefix or suffix specified!");var f=[t.prefix,r.key,t.suffix].join("");return angular.isObject(r.fileMap)&&r.fileMap[f]&&(f=r.fileMap[f]),i(angular.extend({url:f,method:"GET",params:""},r.$http)).then(function(e){return e.data},function(){return e.reject(r.key)})},f=[],n=r.files.length,a=0;a<n;a++)f.push(t({prefix:r.files[a].prefix,key:r.key,suffix:r.files[a].suffix}));return e.all(f).then(function(e){for(var i=e.length,r={},t=0;t<i;t++)for(var f in e[t])r[f]=e[t][f];return r})}}return e.$inject=["$q","$http"],angular.module("pascalprecht.translate").factory("$translateStaticFilesLoader",e),e.displayName="$translateStaticFilesLoader","pascalprecht.translate"});