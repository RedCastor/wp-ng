!function(t,o,n){"use strict";function e(t,o){return("string"==typeof o||o instanceof String)&&(o=new RegExp(o)),o instanceof RegExp?o.test(t):o&&Array.isArray(o.and)?o.and.every(function(o){return e(t,o)}):o&&Array.isArray(o.or)?o.or.some(function(o){return e(t,o)}):!(!o||!o.not)&&!e(t,o.not)}function i(t,o){return("string"==typeof o||o instanceof String)&&(o=new RegExp(o)),o instanceof RegExp?o.exec(t):o&&Array.isArray(o)?o.reduce(function(o,n){return o||i(t,n)},null):null}n&&n.module("reTree",[]).factory("reTree",[function(){return{test:e,exec:i}}]),o&&(o.reTree={test:e,exec:i}),t&&(t.exports={test:e,exec:i})}("undefined"==typeof module?null:module,"undefined"==typeof window?null:window,"undefined"==typeof angular?null:angular),function(t,o){"function"==typeof define&&define.amd?define(o):"object"==typeof exports?module.exports=o():t.Sifter=o()}(this,function(){var t=function(t,o){this.items=t,this.settings=o||{diacritics:!0}};t.prototype.tokenize=function(t){if(!(t=i(String(t||"").toLowerCase()))||!t.length)return[];var o,n,e,a,l=[],c=t.split(/ +/);for(o=0,n=c.length;o<n;o++){if(e=r(c[o]),this.settings.diacritics)for(a in s)s.hasOwnProperty(a)&&(e=e.replace(new RegExp(a,"g"),s[a]));l.push({string:c[o],regex:new RegExp(e,"i")})}return l},t.prototype.iterator=function(t,o){var n;n=a(t)?Array.prototype.forEach||function(t){for(var o=0,n=this.length;o<n;o++)t(this[o],o,this)}:function(t){for(var o in this)this.hasOwnProperty(o)&&t(this[o],o,this)},n.apply(t,[o])},t.prototype.getScoreFunction=function(t,o){var n,i,r,a,s;n=this,t=n.prepareSearch(t,o),r=t.tokens,i=t.options.fields,a=r.length,s=t.options.nesting;var l=function(t,o){var n,e;return t?(t=String(t||""),-1===(e=t.search(o.regex))?0:(n=o.string.length/t.length,0===e&&(n+=.5),n)):0},c=function(){var t=i.length;return t?1===t?function(t,o){return l(e(o,i[0],s),t)}:function(o,n){for(var r=0,a=0;r<t;r++)a+=l(e(n,i[r],s),o);return a/t}:function(){return 0}}();return a?1===a?function(t){return c(r[0],t)}:"and"===t.options.conjunction?function(t){for(var o,n=0,e=0;n<a;n++){if((o=c(r[n],t))<=0)return 0;e+=o}return e/a}:function(t){for(var o=0,n=0;o<a;o++)n+=c(r[o],t);return n/a}:function(){return 0}},t.prototype.getSortFunction=function(t,n){var i,r,a,s,l,c,f,u,y,m,b;if(a=this,t=a.prepareSearch(t,n),b=!t.query&&n.sort_empty||n.sort,y=function(t,o){return"$score"===t?o.score:e(a.items[o.id],t,n.nesting)},l=[],b)for(i=0,r=b.length;i<r;i++)(t.query||"$score"!==b[i].field)&&l.push(b[i]);if(t.query){for(m=!0,i=0,r=l.length;i<r;i++)if("$score"===l[i].field){m=!1;break}m&&l.unshift({field:"$score",direction:"desc"})}else for(i=0,r=l.length;i<r;i++)if("$score"===l[i].field){l.splice(i,1);break}for(u=[],i=0,r=l.length;i<r;i++)u.push("desc"===l[i].direction?-1:1);return c=l.length,c?1===c?(s=l[0].field,f=u[0],function(t,n){return f*o(y(s,t),y(s,n))}):function(t,n){var e,i,r;for(e=0;e<c;e++)if(r=l[e].field,i=u[e]*o(y(r,t),y(r,n)))return i;return 0}:null},t.prototype.prepareSearch=function(t,o){if("object"==typeof t)return t;o=n({},o);var e=o.fields,i=o.sort,r=o.sort_empty;return e&&!a(e)&&(o.fields=[e]),i&&!a(i)&&(o.sort=[i]),r&&!a(r)&&(o.sort_empty=[r]),{options:o,query:String(t||"").toLowerCase(),tokens:this.tokenize(t),total:0,items:[]}},t.prototype.search=function(t,o){var n,e,i,r,a=this;return e=this.prepareSearch(t,o),o=e.options,t=e.query,r=o.score||a.getScoreFunction(e),t.length?a.iterator(a.items,function(t,i){n=r(t),(!1===o.filter||n>0)&&e.items.push({score:n,id:i})}):a.iterator(a.items,function(t,o){e.items.push({score:1,id:o})}),i=a.getSortFunction(e,o),i&&e.items.sort(i),e.total=e.items.length,"number"==typeof o.limit&&(e.items=e.items.slice(0,o.limit)),e};var o=function(t,o){return"number"==typeof t&&"number"==typeof o?t>o?1:t<o?-1:0:(t=l(String(t||"")),o=l(String(o||"")),t>o?1:o>t?-1:0)},n=function(t,o){var n,e,i,r;for(n=1,e=arguments.length;n<e;n++)if(r=arguments[n])for(i in r)r.hasOwnProperty(i)&&(t[i]=r[i]);return t},e=function(t,o,n){if(t&&o){if(!n)return t[o];for(var e=o.split(".");e.length&&(t=t[e.shift()]););return t}},i=function(t){return(t+"").replace(/^\s+|\s+$|/g,"")},r=function(t){return(t+"").replace(/([.?*+^$[\]\\(){}|-])/g,"\\$1")},a=Array.isArray||"undefined"!=typeof $&&$.isArray||function(t){return"[object Array]"===Object.prototype.toString.call(t)},s={a:"[aḀḁĂăÂâǍǎȺⱥȦȧẠạÄäÀàÁáĀāÃãÅåąĄÃąĄ]",b:"[b␢βΒB฿𐌁ᛒ]",c:"[cĆćĈĉČčĊċC̄c̄ÇçḈḉȻȼƇƈɕᴄＣｃ]",d:"[dĎďḊḋḐḑḌḍḒḓḎḏĐđD̦d̦ƉɖƊɗƋƌᵭᶁᶑȡᴅＤｄð]",e:"[eÉéÈèÊêḘḙĚěĔĕẼẽḚḛẺẻĖėËëĒēȨȩĘęᶒɆɇȄȅẾếỀềỄễỂểḜḝḖḗḔḕȆȇẸẹỆệⱸᴇＥｅɘǝƏƐε]",f:"[fƑƒḞḟ]",g:"[gɢ₲ǤǥĜĝĞğĢģƓɠĠġ]",h:"[hĤĥĦħḨḩẖẖḤḥḢḣɦʰǶƕ]",i:"[iÍíÌìĬĭÎîǏǐÏïḮḯĨĩĮįĪīỈỉȈȉȊȋỊịḬḭƗɨɨ̆ᵻᶖİiIıɪＩｉ]",j:"[jȷĴĵɈɉʝɟʲ]",k:"[kƘƙꝀꝁḰḱǨǩḲḳḴḵκϰ₭]",l:"[lŁłĽľĻļĹĺḶḷḸḹḼḽḺḻĿŀȽƚⱠⱡⱢɫɬᶅɭȴʟＬｌ]",n:"[nŃńǸǹŇňÑñṄṅŅņṆṇṊṋṈṉN̈n̈ƝɲȠƞᵰᶇɳȵɴＮｎŊŋ]",o:"[oØøÖöÓóÒòÔôǑǒŐőŎŏȮȯỌọƟɵƠơỎỏŌōÕõǪǫȌȍՕօ]",p:"[pṔṕṖṗⱣᵽƤƥᵱ]",q:"[qꝖꝗʠɊɋꝘꝙq̃]",r:"[rŔŕɌɍŘřŖŗṘṙȐȑȒȓṚṛⱤɽ]",s:"[sŚśṠṡṢṣꞨꞩŜŝŠšŞşȘșS̈s̈]",t:"[tŤťṪṫŢţṬṭƮʈȚțṰṱṮṯƬƭ]",u:"[uŬŭɄʉỤụÜüÚúÙùÛûǓǔŰűŬŭƯưỦủŪūŨũŲųȔȕ∪]",v:"[vṼṽṾṿƲʋꝞꝟⱱʋ]",w:"[wẂẃẀẁŴŵẄẅẆẇẈẉ]",x:"[xẌẍẊẋχ]",y:"[yÝýỲỳŶŷŸÿỸỹẎẏỴỵɎɏƳƴ]",z:"[zŹźẐẑŽžŻżẒẓẔẕƵƶ]"},l=function(){var t,o,n,e,i="",r={};for(n in s)if(s.hasOwnProperty(n))for(e=s[n].substring(2,s[n].length-1),i+=e,t=0,o=e.length;t<o;t++)r[e.charAt(t)]=n;var a=new RegExp("["+i+"]","g");return function(t){return t.replace(a,function(t){return r[t]}).toLowerCase()}}();return t}),function(t,o){"function"==typeof define&&define.amd?define(o):"object"==typeof exports?module.exports=o():t.MicroPlugin=o()}(this,function(){var t={};t.mixin=function(t){t.plugins={},t.prototype.initializePlugins=function(t){var n,e,i,r=this,a=[];if(r.plugins={names:[],settings:{},requested:{},loaded:{}},o.isArray(t))for(n=0,e=t.length;n<e;n++)"string"==typeof t[n]?a.push(t[n]):(r.plugins.settings[t[n].name]=t[n].options,a.push(t[n].name));else if(t)for(i in t)t.hasOwnProperty(i)&&(r.plugins.settings[i]=t[i],a.push(i));for(;a.length;)r.require(a.shift())},t.prototype.loadPlugin=function(o){var n=this,e=n.plugins,i=t.plugins[o];if(!t.plugins.hasOwnProperty(o))throw new Error('Unable to find "'+o+'" plugin');e.requested[o]=!0,e.loaded[o]=i.fn.apply(n,[n.plugins.settings[o]||{}]),e.names.push(o)},t.prototype.require=function(t){var o=this,n=o.plugins;if(!o.plugins.loaded.hasOwnProperty(t)){if(n.requested[t])throw new Error('Plugin has circular dependency ("'+t+'")');o.loadPlugin(t)}return n.loaded[t]},t.define=function(o,n){t.plugins[o]={name:o,fn:n}}};var o={isArray:Array.isArray||function(t){return"[object Array]"===Object.prototype.toString.call(t)}};return t}),function(t){"use strict";var o=[],n=t.module("isoCurrencies",o);n.provider("isoCurrencies",["iso4217Currencies",function(o){this.code="USD",this.text="US Dollar",this.fraction=2,this.symbol="$",this.position="left",this.decimalSep=".",this.thousandSep=",",this.setCurrencyIso4217=function(t){t&&(this.code=t.toUpperCase());var n=o[this.code];this.text=n.text,this.fraction=n.fraction,this.symbol=n.symbol},this.setCurrencyIso4217(),this.$get=[function(){var t={code:this.code,text:this.text,fraction:this.fraction,symbol:this.symbol,position:this.position,decimalSep:this.decimalSep,thousandSep:this.thousandSep};return{getCurrency:function(){return t},getCode:function(){return t.code},getText:function(){return t.text},getFraction:function(){return t.fraction},getSymbol:function(){return t.symbol},getPosition:function(){return t.position},getDecimalSep:function(){return t.decimalSep},getThousandSep:function(){return t.thousandSep}}}],this.setByCode=function(t){this.setCurrencyIso4217(t)},this.setCode=function(t){this.code=t.toUpperCase()||this.code},this.setText=function(o){t.isDefined(o)&&t.isString(o)&&(this.text=o)},this.setFraction=function(o){t.isDefined(o)&&t.isNumber(o)&&(this.fraction=o)},this.setSymbol=function(o){t.isDefined(o)&&(this.symbol=o)},this.setPosition=function(o){t.isDefined(o)&&t.isString(o)&&(this.position=o)},this.setDecimalSep=function(o){t.isDefined(o)&&t.isString(o)&&(this.decimalSep=o)},this.setThousandSep=function(o){t.isDefined(o)&&t.isString(o)&&(this.thousandSep=o)}}]),n.filter("isoCurrency",["$filter","isoCurrencyService",function(o,n){return Number.prototype.numberFormat=function(t,o,n){o=void 0!==o?o:".",n=void 0!==n?n:",";var e=parseFloat(this.toFixed(t)).toString().split(".");return e[0]=e[0].replace(/\B(?=(\d{3})+(?!\d))/g,n),e.join(o)},function(o,e,i,r,a,s){var l=n.getCurrencyByCode(e);t.isDefined(i)&&(l.fraction=i),t.isDefined(r)&&(l.decimalSep=r),t.isDefined(a)&&(l.thousandSep=a),t.isDefined(s)&&(l.position=s);var c=parseFloat(o).numberFormat(l.fraction,l.decimalSep,l.thousandSep),f="";switch(l.position){case"left":f=l.symbol+c;break;case"right":f=c+l.symbol;break;case"left_space":f=l.symbol+" "+c;break;case"right_space":f=c+" "+l.symbol}return f}}]),n.factory("isoCurrencyService",["isoCurrencies","iso4217Currencies",function(t,o){function n(t){t&&(e.code=t.toUpperCase());var n=o[e.code];return e.text=n.text,e.fraction=n.fraction,e.symbol=n.symbol,e}var e=t.getCurrency();return{getCurrencyByCode:function(t){return t&&n(t),e}}}]),n.constant("iso4217Currencies",{AFN:{text:"Afghani",fraction:2,symbol:"؋"},EUR:{text:"Euro",fraction:2,symbol:"€"},ALL:{text:"Lek",fraction:2,symbol:"Lek"},DZD:{text:"Algerian Dinar",fraction:2,symbol:!1},USD:{text:"US Dollar",fraction:2,symbol:"$"},AOA:{text:"Kwanza",fraction:2,symbol:!1},XCD:{text:"East Caribbean Dollar",fraction:2,symbol:"$"},ARS:{text:"Argentine Peso",fraction:2,symbol:"$"},AMD:{text:"Armenian Dram",fraction:2,symbol:!1},AWG:{text:"Aruban Florin",fraction:2,symbol:"ƒ"},AUD:{text:"Australian Dollar",fraction:2,symbol:"$"},AZN:{text:"Azerbaijanian Manat",fraction:2,symbol:"ман"},BSD:{text:"Bahamian Dollar",fraction:2,symbol:"$"},BHD:{text:"Bahraini Dinar",fraction:3,symbol:!1},BDT:{text:"Taka",fraction:2,symbol:!1},BBD:{text:"Barbados Dollar",fraction:2,symbol:"$"},BYR:{text:"Belarussian Ruble",fraction:0,symbol:"p."},BZD:{text:"Belize Dollar",fraction:2,symbol:"BZ$"},XOF:{text:"CF Franc BCEAO",fraction:0,symbol:!1},BMD:{text:"Bermudian Dollar",fraction:2,symbol:"$"},BTN:{text:"Ngultrum",fraction:2,symbol:!1},INR:{text:"Indian Rupee",fraction:2,symbol:""},BOB:{text:"Boliviano",fraction:2,symbol:"$b"},BOV:{text:"Mvdol",fraction:2,symbol:!1},BAM:{text:"Convertible Mark",fraction:2,symbol:"KM"},BWP:{text:"Pula",fraction:2,symbol:"P"},NOK:{text:"Norwegian Krone",fraction:2,symbol:"kr"},BRL:{text:"Brazilian Real",fraction:2,symbol:"R$"},BND:{text:"Brunei Dollar",fraction:2,symbol:"$"},BGN:{text:"Bulgarian Lev",fraction:2,symbol:"лв"},BIF:{text:"Burundi Franc",fraction:0,symbol:!1},KHR:{text:"Riel",fraction:2,symbol:"៛"},XAF:{text:"CF Franc BEAC",fraction:0,symbol:!1},CAD:{text:"Canadian Dollar",fraction:2,symbol:"$"},CVE:{text:"Cabo Verde Escudo",fraction:2,symbol:!1},KYD:{text:"Cayman Islands Dollar",fraction:2,symbol:"$"},CLF:{text:"Unidad de Fomento",fraction:4,symbol:!1},CLP:{text:"Chilean Peso",fraction:0,symbol:"$"},CNY:{text:"Yuan Renminbi",fraction:2,symbol:"¥"},COP:{text:"Colombian Peso",fraction:2,symbol:"$"},COU:{text:"Unidad de Valor Real",fraction:2,symbol:!1},KMF:{text:"Comoro Franc",fraction:0,symbol:!1},CDF:{text:"Congolese Franc",fraction:2,symbol:!1},NZD:{text:"New Zealand Dollar",fraction:2,symbol:"$"},CRC:{text:"Cost Rican Colon",fraction:2,symbol:"₡"},HRK:{text:"Croatian Kuna",fraction:2,symbol:"kn"},CUC:{text:"Peso Convertible",fraction:2,symbol:!1},CUP:{text:"Cuban Peso",fraction:2,symbol:"₱"},ANG:{text:"Netherlands Antillean Guilder",fraction:2,symbol:"ƒ"},CZK:{text:"Czech Koruna",fraction:2,symbol:"Kč"},DKK:{text:"Danish Krone",fraction:2,symbol:"kr"},DJF:{text:"Djibouti Franc",fraction:0,symbol:!1},DOP:{text:"Dominican Peso",fraction:2,symbol:"RD$"},EGP:{text:"Egyptian Pound",fraction:2,symbol:"£"},SVC:{text:"El Salvador Colon",fraction:2,symbol:"$"},ERN:{text:"Nakfa",fraction:2,symbol:!1},ETB:{text:"Ethiopian Birr",fraction:2,symbol:!1},FKP:{text:"Falkland Islands Pound",fraction:2,symbol:"£"},FJD:{text:"Fiji Dollar",fraction:2,symbol:"$"},XPF:{text:"CFP Franc",fraction:0,symbol:!1},GMD:{text:"Dalasi",fraction:2,symbol:!1},GEL:{text:"Lari",fraction:2,symbol:!1},GHS:{text:"Ghan Cedi",fraction:2,symbol:!1},GIP:{text:"Gibraltar Pound",fraction:2,symbol:"£"},GTQ:{text:"Quetzal",fraction:2,symbol:"Q"},GBP:{text:"Pound Sterling",fraction:2,symbol:"£"},GNF:{text:"Guine Franc",fraction:0,symbol:!1},GYD:{text:"Guyan Dollar",fraction:2,symbol:"$"},HTG:{text:"Gourde",fraction:2,symbol:!1},HNL:{text:"Lempira",fraction:2,symbol:"L"},HKD:{text:"Hong Kong Dollar",fraction:2,symbol:"$"},HUF:{text:"Forint",fraction:2,symbol:"Ft"},ISK:{text:"Iceland Krona",fraction:0,symbol:"kr"},IDR:{text:"Rupiah",fraction:2,symbol:"Rp"},XDR:{text:"SDR (Special Drawing Right)",fraction:0,symbol:!1},IRR:{text:"Iranian Rial",fraction:2,symbol:"﷼"},IQD:{text:"Iraqi Dinar",fraction:3,symbol:!1},ILS:{text:"New Israeli Sheqel",fraction:2,symbol:"₪"},JMD:{text:"Jamaican Dollar",fraction:2,symbol:"J$"},JPY:{text:"Yen",fraction:0,symbol:"¥"},JOD:{text:"Jordanian Dinar",fraction:3,symbol:!1},KZT:{text:"Tenge",fraction:2,symbol:"лв"},KES:{text:"Kenyan Shilling",fraction:2,symbol:!1},KPW:{text:"North Korean Won",fraction:2,symbol:"₩"},KRW:{text:"Won",fraction:0,symbol:"₩"},KWD:{text:"Kuwaiti Dinar",fraction:3,symbol:!1},KGS:{text:"Som",fraction:2,symbol:"лв"},LAK:{text:"Kip",fraction:2,symbol:"₭"},LBP:{text:"Lebanese Pound",fraction:2,symbol:"£"},LSL:{text:"Loti",fraction:2,symbol:!1},ZAR:{text:"Rand",fraction:2,symbol:"R"},LRD:{text:"Liberian Dollar",fraction:2,symbol:"$"},LYD:{text:"Libyan Dinar",fraction:3,symbol:!1},CHF:{text:"Swiss Franc",fraction:2,symbol:"CHF"},LTL:{text:"Lithuanian Litas",fraction:2,symbol:"Lt"},MOP:{text:"Pataca",fraction:2,symbol:!1},MKD:{text:"Denar",fraction:2,symbol:"ден"},MGA:{text:"Malagasy riary",fraction:2,symbol:!1},MWK:{text:"Kwacha",fraction:2,symbol:!1},MYR:{text:"Malaysian Ringgit",fraction:2,symbol:"RM"},MVR:{text:"Rufiyaa",fraction:2,symbol:!1},MRO:{text:"Ouguiya",fraction:2,symbol:!1},MUR:{text:"Mauritius Rupee",fraction:2,symbol:"₨"},XUA:{text:"ADB Unit of ccount",fraction:0,symbol:!1},MXN:{text:"Mexican Peso",fraction:2,symbol:"$"},MXV:{text:"Mexican Unidad de Inversion (UDI)",fraction:2,symbol:!1},MDL:{text:"Moldovan Leu",fraction:2,symbol:!1},MNT:{text:"Tugrik",fraction:2,symbol:"₮"},MAD:{text:"Moroccan Dirham",fraction:2,symbol:!1},MZN:{text:"Mozambique Metical",fraction:2,symbol:"MT"},MMK:{text:"Kyat",fraction:2,symbol:!1},NAD:{text:"Namibi Dollar",fraction:2,symbol:"$"},NPR:{text:"Nepalese Rupee",fraction:2,symbol:"₨"},NIO:{text:"Cordob Oro",fraction:2,symbol:"C$"},NGN:{text:"Naira",fraction:2,symbol:"₦"},OMR:{text:"Rial Omani",fraction:3,symbol:"﷼"},PKR:{text:"Pakistan Rupee",fraction:2,symbol:"₨"},PAB:{text:"Balboa",fraction:2,symbol:"B/."},PGK:{text:"Kina",fraction:2,symbol:!1},PYG:{text:"Guarani",fraction:0,symbol:"Gs"},PEN:{text:"Nuevo Sol",fraction:2,symbol:"S/."},PHP:{text:"Philippine Peso",fraction:2,symbol:"₱"},PLN:{text:"Zloty",fraction:2,symbol:"zł"},QAR:{text:"Qatari Rial",fraction:2,symbol:"﷼"},RON:{text:"New Romanian Leu",fraction:2,symbol:"lei"},RUB:{text:"Russian Ruble",fraction:2,symbol:"руб"},RWF:{text:"Rwand Franc",fraction:0,symbol:!1},SHP:{text:"Saint Helen Pound",fraction:2,symbol:"£"},WST:{text:"Tala",fraction:2,symbol:!1},STD:{text:"Dobra",fraction:2,symbol:!1},SAR:{text:"Saudi Riyal",fraction:2,symbol:"﷼"},RSD:{text:"Serbian Dinar",fraction:2,symbol:"Дин."},SCR:{text:"Seychelles Rupee",fraction:2,symbol:"₨"},SLL:{text:"Leone",fraction:2,symbol:!1},SGD:{text:"Singapore Dollar",fraction:2,symbol:"$"},XSU:{text:"Sucre",fraction:0,symbol:!1},SBD:{text:"Solomon Islands Dollar",fraction:2,symbol:"$"},SOS:{text:"Somali Shilling",fraction:2,symbol:"S"},SSP:{text:"South Sudanese Pound",fraction:2,symbol:!1},LKR:{text:"Sri Lank Rupee",fraction:2,symbol:"₨"},SDG:{text:"Sudanese Pound",fraction:2,symbol:!1},SRD:{text:"Surinam Dollar",fraction:2,symbol:"$"},SZL:{text:"Lilangeni",fraction:2,symbol:!1},SEK:{text:"Swedish Krona",fraction:2,symbol:"kr"},CHE:{text:"WIR Euro",fraction:2,symbol:!1},CHW:{text:"WIR Franc",fraction:2,symbol:!1},SYP:{text:"Syrian Pound",fraction:2,symbol:"£"},TWD:{text:"New Taiwan Dollar",fraction:2,symbol:"NT$"},TJS:{text:"Somoni",fraction:2,symbol:!1},TZS:{text:"Tanzanian Shilling",fraction:2,symbol:!1},THB:{text:"Baht",fraction:2,symbol:"฿"},TOP:{text:"Pa’anga",fraction:2,symbol:!1},TTD:{text:"Trinidad nd Tobago Dollar",fraction:2,symbol:"TT$"},TND:{text:"Tunisian Dinar",fraction:3,symbol:!1},TRY:{text:"Turkish Lira",fraction:2,symbol:"₺"},TMT:{text:"Turkmenistan New Manat",fraction:2,symbol:!1},UGX:{text:"Ugand Shilling",fraction:0,symbol:!1},UAH:{text:"Hryvnia",fraction:2,symbol:"₴"},AED:{text:"UAE Dirham",fraction:2,symbol:!1},USN:{text:"US Dollar (Next day)",fraction:2,symbol:!1},UYI:{text:"Uruguay Peso en Unidades Indexadas (URUIURUI)",fraction:0,symbol:!1},UYU:{text:"Peso Uruguayo",fraction:2,symbol:"$U"},UZS:{text:"Uzbekistan Sum",fraction:2,symbol:"лв"},VUV:{text:"Vatu",fraction:0,symbol:!1},VEF:{text:"Bolivar",fraction:2,symbol:"Bs"},VND:{text:"Dong",fraction:0,symbol:"₫"},YER:{text:"Yemeni Rial",fraction:2,symbol:"﷼"},ZMW:{text:"Zambian Kwacha",fraction:2,symbol:!1},ZWL:{text:"Zimbabwe Dollar",fraction:2,symbol:!1}})}(angular);