!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.Velocity=t()}(this,function(){"use strict";var e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")},n=function(){function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}}(),r=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e};function i(e){return!0===e||!1===e}function o(e){return"[object Function]"===Object.prototype.toString.call(e)}function a(e){return!(!e||!e.nodeType)}function l(e){return"number"==typeof e}function s(t){if(!t||"object"!==(void 0===t?"undefined":e(t))||t.nodeType||"[object Object]"!==Object.prototype.toString.call(t))return!1;var n=Object.getPrototypeOf(t);return!n||n.hasOwnProperty("constructor")&&n.constructor===Object}function u(e){return"string"==typeof e}function c(e){return e&&l(e.length)&&o(e.velocity)}function f(e){return e&&e!==window&&l(e.length)&&!u(e)&&!o(e)&&!a(e)&&(0===e.length||a(e[0]))}function d(e){return Array.prototype.slice.call(e,0)}function v(e,t,n,r){e&&Object.defineProperty(e,t,{configurable:!r,writable:!r,value:n})}function p(){for(var e=arguments.length,t=Array(e),n=0;n<e;n++)t[n]=arguments[n];var r=!0,i=!1,o=void 0;try{for(var a,l=arguments[Symbol.iterator]();!(r=(a=l.next()).done);r=!0){var s=a.value;if(void 0!==s&&s==s)return s}}catch(e){i=!0,o=e}finally{try{!r&&l.return&&l.return()}finally{if(i)throw o}}}var y=Date.now?Date.now:function(){return(new Date).getTime()};function g(e,t){e instanceof Element&&(e.classList?e.classList.remove(t):e.className=e.className.replace(new RegExp("(^|\\s)"+t+"(\\s|$)","gi")," "))}var h={};function m(e,t){var n,r,i=e[0],a=e[1];u(i)?o(a)?h[i]&&(n=h,r=i,!Object.prototype.propertyIsEnumerable.call(n,r))?console.warn("VelocityJS: Trying to override internal 'registerAction' callback",i):!0===t?v(h,i,a):h[i]=a:console.warn("VelocityJS: Trying to set 'registerAction' callback to an invalid value:",i,a):console.warn("VelocityJS: Trying to set 'registerAction' name to an invalid value:",i)}m(["registerAction",m],!0);var w=400,b={fast:200,normal:400,slow:600},S={};function x(e){var t=e[0],n=e[1];u(t)?o(n)?S[t]?console.warn("VelocityJS: Trying to override 'registerEasing' callback",t):S[t]=n:console.warn("VelocityJS: Trying to set 'registerEasing' callback to an invalid value:",t,n):console.warn("VelocityJS: Trying to set 'registerEasing' name to an invalid value:",t)}function k(e,t,n,r){return t+e*(n-t)}function O(e){return Math.min(Math.max(e,0),1)}function E(e,t){return 1-3*t+3*e}function _(e,t){return 3*t-6*e}function T(e){return 3*e}function M(e,t,n){return((E(t,n)*e+_(t,n))*e+T(t))*e}function V(e,t,n){return 3*E(t,n)*e*e+2*_(t,n)*e+T(t)}function q(e,t,n,r){var i=4,o=.001,a=1e-7,l=10,s=11,u=1/(s-1),c="Float32Array"in window;if(4===arguments.length){for(var f=0;f<4;++f)if("number"!=typeof arguments[f]||isNaN(arguments[f])||!isFinite(arguments[f]))return;e=O(e),n=O(n);var d=c?new Float32Array(s):new Array(s),v=!1,p="generateBezier("+[e,t,n,r]+")",y=function(i,o,a,l){return v||h(),0===i?o:1===i?a:e===t&&n===r?o+i*(a-o):o+M(g(i),t,r)*(a-o)};return y.getControlPoints=function(){return[{x:e,y:t},{x:n,y:r}]},y.toString=function(){return p},y}function g(t){for(var r=s-1,c=0,f=1;f!==r&&d[f]<=t;++f)c+=u;var v=c+(t-d[--f])/(d[f+1]-d[f])*u,p=V(v,e,n);return p>=o?function(t,r){for(var o=0;o<i;++o){var a=V(r,e,n);if(0===a)return r;r-=(M(r,e,n)-t)/a}return r}(t,v):0===p?v:function(t,r,i){var o=void 0,s=void 0,u=0;do{(o=M(s=r+(i-r)/2,e,n)-t)>0?i=s:r=s}while(Math.abs(o)>a&&++u<l);return s}(t,c,c+u)}function h(){v=!0,e===t&&n===r||function(){for(var t=0;t<s;++t)d[t]=M(t*u,e,n)}()}}m(["registerEasing",x],!0),x(["linear",k]),x(["swing",function(e,t,n){return t+(.5-Math.cos(e*Math.PI)/2)*(n-t)}]),x(["spring",function(e,t,n){return t+(1-Math.cos(4.5*e*Math.PI)*Math.exp(6*-e))*(n-t)}]);var N=q(.42,0,1,1),A=q(0,0,.58,1),L=q(.42,0,.58,1);function J(e){return-e.tension*e.x-e.friction*e.v}function I(e,t,n){var r={x:e.x+n.dx*t,v:e.v+n.dv*t,tension:e.tension,friction:e.friction};return{dx:r.v,dv:J(r)}}function j(e,t){var n={dx:e.v,dv:J(e)},r=I(e,.5*t,n),i=I(e,.5*t,r),o=I(e,t,i),a=1/6*(n.dx+2*(r.dx+i.dx)+o.dx),l=1/6*(n.dv+2*(r.dv+i.dv)+o.dv);return e.x=e.x+a*t,e.v=e.v+l*t,e}x(["ease",q(.25,.1,.25,1)]),x(["easeIn",N]),x(["ease-in",N]),x(["easeOut",A]),x(["ease-out",A]),x(["easeInOut",L]),x(["ease-in-out",L]),x(["easeInSine",q(.47,0,.745,.715)]),x(["easeOutSine",q(.39,.575,.565,1)]),x(["easeInOutSine",q(.445,.05,.55,.95)]),x(["easeInQuad",q(.55,.085,.68,.53)]),x(["easeOutQuad",q(.25,.46,.45,.94)]),x(["easeInOutQuad",q(.455,.03,.515,.955)]),x(["easeInCubic",q(.55,.055,.675,.19)]),x(["easeOutCubic",q(.215,.61,.355,1)]),x(["easeInOutCubic",q(.645,.045,.355,1)]),x(["easeInQuart",q(.895,.03,.685,.22)]),x(["easeOutQuart",q(.165,.84,.44,1)]),x(["easeInOutQuart",q(.77,0,.175,1)]),x(["easeInQuint",q(.755,.05,.855,.06)]),x(["easeOutQuint",q(.23,1,.32,1)]),x(["easeInOutQuint",q(.86,0,.07,1)]),x(["easeInExpo",q(.95,.05,.795,.035)]),x(["easeOutExpo",q(.19,1,.22,1)]),x(["easeInOutExpo",q(1,0,0,1)]),x(["easeInCirc",q(.6,.04,.98,.335)]),x(["easeOutCirc",q(.075,.82,.165,1)]),x(["easeInOutCirc",q(.785,.135,.15,.86)]);var C={};function P(e,t){return l(e)?e:u(e)?b[e.toLowerCase()]||parseFloat(e.replace("ms","").replace("s","000")):null==t?void 0:P(t)}function z(e){if(i(e))return e;null!=e&&console.warn("VelocityJS: Trying to set 'cache' to an invalid value:",e)}function F(e){if(o(e))return e;null!=e&&console.warn("VelocityJS: Trying to set 'begin' to an invalid value:",e)}function H(e,t){if(o(e))return e;null==e||t||console.warn("VelocityJS: Trying to set 'complete' to an invalid value:",e)}function R(e){var t=P(e);if(!isNaN(t))return t;null!=e&&console.error("VelocityJS: Trying to set 'delay' to an invalid value:",e)}function B(e,t){var n=P(e);if(!isNaN(n)&&n>=0)return n;null==e||t||console.error("VelocityJS: Trying to set 'duration' to an invalid value:",e)}function W(e,t,n){if(u(e))return S[e];if(o(e))return e;if(Array.isArray(e)){if(1===e.length)return r=e[0],C[r]||(C[r]=function(e,t,n){return 0===e?t:1===e?n:t+Math.round(e*r)*(1/r)*(n-t)});if(2===e.length)return function e(t,n,r){var i={x:-1,v:0,tension:parseFloat(t)||500,friction:parseFloat(n)||20},o=[0],a=null!=r,l=0,s=void 0,u=void 0;for(s=a?(l=e(i.tension,i.friction))/r*.016:.016;u=j(u||i,s),o.push(1+u.x),l+=16,Math.abs(u.x)>1e-4&&Math.abs(u.v)>1e-4;);return a?function(e,t,n){return 0===e?t:1===e?n:t+o[Math.floor(e*(o.length-1))]*(n-t)}:l}(e[0],e[1],t);if(4===e.length)return q.apply(null,e)||!1}var r;null==e||n||console.error("VelocityJS: Trying to set 'easing' to an invalid value:",e)}function $(e){if(!1===e)return 0;var t=parseInt(e,10);if(!isNaN(t)&&t>=0)return Math.min(t,60);null!=e&&console.warn("VelocityJS: Trying to set 'fpsLimit' to an invalid value:",e)}function G(e){switch(e){case!1:return 0;case!0:return!0;default:var t=parseInt(e,10);if(!isNaN(t)&&t>=0)return t}null!=e&&console.warn("VelocityJS: Trying to set 'loop' to an invalid value:",e)}function Q(e,t){if(!1===e||u(e))return e;null==e||t||console.warn("VelocityJS: Trying to set 'queue' to an invalid value:",e)}function D(e){switch(e){case!1:return 0;case!0:return!0;default:var t=parseInt(e,10);if(!isNaN(t)&&t>=0)return t}null!=e&&console.warn("VelocityJS: Trying to set 'repeat' to an invalid value:",e)}function U(e){if(l(e))return e;null!=e&&console.error("VelocityJS: Trying to set 'speed' to an invalid value:",e)}function Z(e){if(i(e))return e;null!=e&&console.error("VelocityJS: Trying to set 'sync' to an invalid value:",e)}var Y=void 0,X=void 0,K=void 0,ee=void 0,te=void 0,ne=void 0,re=void 0,ie=void 0,oe=void 0,ae=void 0,le=void 0,se=void 0,ue=void 0,ce=void 0,fe=void 0,de=void 0,ve=function(){function e(){t(this,e)}return n(e,null,[{key:"reset",value:function(){Y=!0,X=void 0,K=void 0,ee=0,te=w,ne=W("swing",w),re=60,ie=0,ae=980/60,le=!0,se=!0,ue="",ce=0,fe=1,de=!0}},{key:"cache",get:function(){return Y},set:function(e){void 0!==(e=z(e))&&(Y=e)}},{key:"begin",get:function(){return X},set:function(e){void 0!==(e=F(e))&&(X=e)}},{key:"complete",get:function(){return K},set:function(e){void 0!==(e=H(e))&&(K=e)}},{key:"delay",get:function(){return ee},set:function(e){void 0!==(e=R(e))&&(ee=e)}},{key:"duration",get:function(){return te},set:function(e){void 0!==(e=B(e))&&(te=e)}},{key:"easing",get:function(){return ne},set:function(e){void 0!==(e=W(e,te))&&(ne=e)}},{key:"fpsLimit",get:function(){return re},set:function(e){void 0!==(e=$(e))&&(re=e,ae=980/e)}},{key:"loop",get:function(){return ie},set:function(e){void 0!==(e=G(e))&&(ie=e)}},{key:"mobileHA",get:function(){return oe},set:function(e){i(e)&&(oe=e)}},{key:"minFrameTime",get:function(){return ae}},{key:"promise",get:function(){return le},set:function(e){void 0!==(e=function(e){if(i(e))return e;null!=e&&console.warn("VelocityJS: Trying to set 'promise' to an invalid value:",e)}(e))&&(le=e)}},{key:"promiseRejectEmpty",get:function(){return se},set:function(e){void 0!==(e=function(e){if(i(e))return e;null!=e&&console.warn("VelocityJS: Trying to set 'promiseRejectEmpty' to an invalid value:",e)}(e))&&(se=e)}},{key:"queue",get:function(){return ue},set:function(e){void 0!==(e=Q(e))&&(ue=e)}},{key:"repeat",get:function(){return ce},set:function(e){void 0!==(e=D(e))&&(ce=e)}},{key:"repeatAgain",get:function(){return ce}},{key:"speed",get:function(){return fe},set:function(e){void 0!==(e=U(e))&&(fe=e)}},{key:"sync",get:function(){return de},set:function(e){void 0!==(e=Z(e))&&(de=e)}}]),e}();Object.freeze(ve),ve.reset();var pe=[],ye={},ge=new Set,he=[],me=new Map,we="velocityData";function be(e){var t=e[we];if(t)return t;for(var n=e.ownerDocument.defaultView,r=0,i=0;i<he.length;i++){var o=he[i];u(o)?e instanceof n[o]&&(r|=1<<i):e instanceof o&&(r|=1<<i)}var a={types:r,count:0,computedStyle:null,cache:{},queueList:{},lastAnimationList:{},lastFinishList:{},window:n};return Object.defineProperty(e,we,{value:a}),a}var Se=window&&window===window.window,xe=Se&&void 0!==window.pageYOffset,ke={isClient:Se,isMobile:Se&&/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),isGingerbread:Se&&/Android 2\.3\.[3-7]/i.test(navigator.userAgent),prefixElement:Se&&document.createElement("div"),windowScrollAnchor:xe,scrollAnchor:xe?window:!Se||document.documentElement||document.body.parentNode||document.body,scrollPropertyLeft:xe?"pageXOffset":"scrollLeft",scrollPropertyTop:xe?"pageYOffset":"scrollTop",className:"velocity-animating",isTicking:!1,first:void 0,last:void 0,firstNew:void 0};function Oe(e){var t=ke.last;e._prev=t,e._next=void 0,t?t._next=e:ke.first=e,ke.last=e,ke.firstNew||(ke.firstNew=e);var n=e.element;be(n).count++||function(e,t){e instanceof Element&&(e.classList?e.classList.add(t):(g(e,t),e.className+=(e.className.length?" ":"")+t))}(n,ke.className)}function Ee(e,t,n){var r=be(e);if(!1!==n&&(r.lastAnimationList[n]=t),!1===n)Oe(t);else{u(n)||(n="");var i=r.queueList[n];if(i){for(;i._next;)i=i._next;i._next=t,t._prev=i}else null===i?r.queueList[n]=t:(r.queueList[n]=null,Oe(t))}}function _e(e){var t=e._next,n=e._prev,r=null==e.queue?e.options.queue:e.queue;(ke.firstNew===e&&(ke.firstNew=t),ke.first===e?ke.first=t:n&&(n._next=t),ke.last===e?ke.last=n:t&&(t._prev=n),r)&&(be(e.element)&&(e._next=e._prev=void 0))}var Te={};function Me(e){var t=e.options,n=p(e.queue,t.queue),r=p(e.loop,t.loop,ve.loop),i=p(e.repeat,t.repeat,ve.repeat),o=8&e._flags;if(o||!r&&!i){var a=e.element,l=be(a);if(--l.count||o||g(a,ke.className),t&&++t._completed===t._total){!o&&t.complete&&(!function(e){var t=e.complete||e.options.complete;if(t)try{var n=e.elements;t.call(n,n,e)}catch(e){setTimeout(function(){throw e},1)}}(e),t.complete=null);var s=t._resolver;s&&(s(e.elements),delete t._resolver)}!1!==n&&(o||(l.lastFinishList[n]=e.timeStart+p(e.duration,t.duration,ve.duration)),function(e,t,n){if(!1!==t){u(t)||(t="");var r=be(e),i=r.queueList[t];i?(r.queueList[t]=i._next||null,n||Oe(i)):null===i&&delete r.queueList[t]}}(a,n)),_e(e)}else i&&!0!==i?e.repeat=i-1:r&&!0!==r&&(e.loop=r-1,e.repeat=p(e.repeatAgain,t.repeatAgain,ve.repeatAgain)),r&&(e._flags^=64),!1!==n&&(be(e.element).lastFinishList[n]=e.timeStart+p(e.duration,t.duration,ve.duration)),e.timeStart=e.ellapsedTime=e.percentComplete=0,e._flags&=-5}function Ve(e){var t=e[0],n=e[1],r=e[2];if((!u(t)||window[t]instanceof Object)&&(u(t)||t instanceof Object))if(u(n))if(o(r)){var i=he.indexOf(t),a=3;if(i<0&&!u(t))if(me.has(t))i=he.indexOf(me.get(t));else for(var l in window)if(window[l]===t){(i=he.indexOf(l))<0&&(i=he.push(l)-1,pe[i]={},me.set(t,l));break}if(i<0&&(i=he.push(t)-1,pe[i]={}),pe[i][n]=r,u(e[a])){var s=e[a++],c=ye[s];c||(c=ye[s]=[]),c.push(r)}!1===e[a]&&ge.add(n)}else console.warn("VelocityJS: Trying to set 'registerNormalization' callback to an invalid value:",n,r);else console.warn("VelocityJS: Trying to set 'registerNormalization' name to an invalid value:",n);else console.warn("VelocityJS: Trying to set 'registerNormalization' constructor to an invalid value:",t)}function qe(e){var t=e[0],n=e[1],r=he.indexOf(t);if(r<0&&!u(t))if(me.has(t))r=he.indexOf(me.get(t));else for(var i in window)if(window[i]===t){r=he.indexOf(i);break}return r>=0&&pe[r].hasOwnProperty(n)}function Ne(e,t){for(var n=be(e),r=void 0,i=he.length-1,o=n.types;!r&&i>=0;i--)o&1<<i&&(r=pe[i][t]);return r}function Ae(e,t,n,r){var i=ge.has(t),o=!i&&be(e);(i||o&&o.cache[t]!==n)&&(i||(o.cache[t]=n||void 0),(r=r||Ne(e,t))&&r(e,n),Ut.debug>=2&&console.info('Set "'+t+'": "'+n+'"',e))}function Le(e){if(e.indexOf("calc(")>=0){for(var t=e.split(/([\(\)])/),n=0,r=0;r<t.length;r++){var i=t[r];switch(i){case"(":n++;break;case")":n--;break;default:n&&"0"===i[0]&&(t[r]=i.replace(/^0[a-z%]+ \+ /,""))}}return t.join("").replace(/(?:calc)?\(([0-9\.]+[a-z%]+)\)/g,"$1")}return e}m(["registerNormalization",Ve]),m(["hasNormalization",qe]);var Je={};function Ie(e){var t=Je[e];return t||(Je[e]=e.replace(/-([a-z])/g,function(e,t){return t.toUpperCase()}))}var je=/#([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})/gi,Ce=/#([a-f\d])([a-f\d])([a-f\d])/gi,Pe=/(rgba?\(\s*)?(\b[a-z]+\b)/g,ze=/rgb(a?)\(([^\)]+)\)/gi,Fe=/\s+/g,He={};function Re(e,t,n,r){return"rgba("+parseInt(t,16)+","+parseInt(n,16)+","+parseInt(r,16)+",1)"}function Be(e){return e.replace(je,Re).replace(Ce,function(e,t,n,r){return Re(0,t+t,n+n,r+r)}).replace(Pe,function(e,t,n){return He[n]?(t||"rgba(")+He[n]+(t?"":",1)"):e}).replace(ze,function(e,t,n){return"rgba("+n.replace(Fe,"")+(t?"":",1")+")"})}function We(e,t,n){if("border-box"===Qe(e,"boxSizing").toString().toLowerCase()===n){var r="width"===t?["Left","Right"]:["Top","Bottom"],i=["padding"+r[0],"padding"+r[1],"border"+r[0]+"Width","border"+r[1]+"Width"],o=0,a=!0,l=!1,s=void 0;try{for(var u,c=i[Symbol.iterator]();!(a=(u=c.next()).done);a=!0){var f=u.value,d=parseFloat(Qe(e,f));isNaN(d)||(o+=d)}}catch(e){l=!0,s=e}finally{try{!a&&c.return&&c.return()}finally{if(l)throw s}}return n?-o:o}return 0}function $e(e,t){return e.getBoundingClientRect()[t]+We(e,t,!0)+"px"}function Ge(e,t){var n=be(e),r=n.computedStyle?n.computedStyle:n.window.getComputedStyle(e,null),i=0;if(n.computedStyle||(n.computedStyle=r),"none"===r.display)switch(t){case"width":case"height":return Ae(e,"display","auto"),i=$e(e,t),Ae(e,"display","none"),String(i)}if((i=r[t])||(i=e.style[t]),"auto"===i)switch(t){case"width":case"height":i=$e(e,t);break;case"top":case"left":case"right":case"bottom":var o=Qe(e,"position");if("fixed"===o||"absolute"===o){i=e.getBoundingClientRect[t]+"px";break}default:i="0px"}return i?String(i):""}function Qe(e,t,n,r){var i=be(e),o=void 0;return ge.has(t)&&(r=!0),!r&&i&&null!=i.cache[t]?o=i.cache[t]:(n=n||Ne(e,t))&&(o=n(e),i&&(i.cache[t]=o)),Ut.debug>=2&&console.info('Get "'+t+'": "'+o+'"',e),o}var De=/^#([A-f\d]{3}){1,2}$/i,Ue={function:function(e,t,n,r,i,o){return e.call(t,r,n.length,i)},number:function(e,t,n,r,i,o){return String(e)+function(e){for(var t in ye)if(ye[t].includes(e))return t;return""}(o.fn)},string:function(e,t,n,r,i,o){return Be(e)},undefined:function(e,t,n,r,i,o){return Be(Qe(t,i,o.fn)||"")}};function Ze(t,n){var r=t.tweens=Object.create(null),i=t.elements,a=t.element,s=i.indexOf(a),c=be(a),f=p(t.queue,t.options.queue),d=p(t.options.duration,ve.duration);for(var v in n)if(n.hasOwnProperty(v)){var y=Ie(v),g=Ne(a,y),h=n[v];if(!g&&"tween"!==y){Ut.debug&&console.log('Skipping "'+v+'" due to a lack of browser support.');continue}if(null==h){Ut.debug&&console.log('Skipping "'+v+'" due to no value supplied.');continue}var m=r[y]={},w=void 0,b=void 0;if(m.fn=g,o(h)&&(h=h.call(a,s,i.length,i)),Array.isArray(h)){var x=h[1],k=h[2];w=h[0],u(x)&&(/^[\d-]/.test(x)||De.test(x))||o(x)||l(x)?b=x:u(x)&&S[x]||Array.isArray(x)?(m.easing=W(x,d),b=k):b=x||k}else w=h;m.end=Ue[void 0===w?"undefined":e(w)](w,a,i,s,y,m),null==b&&!1!==f&&void 0!==c.queueList[f]||(m.start=Ue[void 0===b?"undefined":e(b)](b,a,i,s,y,m),et(y,m,d))}}var Ye=/((?:[+\-*\/]=)?(?:[+-]?\d*\.\d+|[+-]?\d+)[a-z%]*|(?:.(?!$|[+-]?\d|[+\-*\/]=[+-]?\d))+.|.)/g,Xe=/^([+\-*\/]=)?([+-]?\d*\.\d+|[+-]?\d+)(.*)$/;function Ke(e,t){for(var n=e.length,r=[],i=[],o=void 0,a=0;a<n;a++){if(!u(e[a]))return;""===e[a]?r[a]=[""]:r[a]=d(e[a].match(Ye)),i[a]=0,o=o||r[a].length>1}for(var l=[],s=l.pattern=[],c=function(e){if(u(s[s.length-1]))s[s.length-1]+=e;else if(e){s.push(e);for(var t=0;t<n;t++)l[t].push(null)}},f=function(){if(!(o||s.length>1)){for(var r="display"===t,i="visibility"===t,a=0;a<n;a++){var u=e[a];l[a][0]=u,l[a].easing=W(r&&"none"===u||i&&"hidden"===u||!r&&!i?"at-end":"at-start",400)}return s[0]=!1,l}},v=!0,p=0;p<n;p++)l[p]=[];for(;v;){for(var y=[],g=[],h=void 0,m=!1,w=!1,b=0;b<n;b++){var S=i[b]++,x=r[b][S];if(!x){if(b)return;for(;b<n;b++){var k=i[b]++;if(r[b][k])return f()}v=!1;break}var O=x.match(Xe);if(O){if(h)return f();var E=parseFloat(O[2]),_=O[3],T=O[1]?O[1][0]+_:void 0,M=T||_;E&&!g.includes(M)&&g.push(M),_||(E?w=!0:m=!0),y[b]=T?[E,M,!0]:[E,M]}else{if(y.length)return f();if(h){if(h!==x)return f()}else h=x}}if(h)c(h);else if(g.length)if(2===g.length&&m&&!w&&g.splice(g[0]?1:0,1),1===g.length){var V=g[0];switch(V[0]){case"+":case"-":case"*":case"/":return void(t&&console.error('Velocity: The first property must not contain a relative function "'+t+'":',e))}s.push(!1);for(var q=0;q<n;q++)l[q].push(y[q][0]);c(V)}else{c("calc(");for(var N=s.length-1,A=0;A<g.length;A++){var L=g[A],J=L[0],I="*"===J||"/"===J,j=I||"+"===J||"-"===J;I&&(s[N]+="(",c(")")),A&&c(" "+(j?J:"+")+" "),s.push(!1);for(var C=0;C<n;C++){var P=y[C],z=P[1]===L?P[0]:3===P.length?l[C-1][l[C-1].length-1]:I?1:0;l[C].push(z)}c(j?L.substring(1):L)}c(")")}}for(var F=0,H=0;F<s.length;F++){var R=s[F];u(R)?H&&R.indexOf(",")>=0?H++:R.indexOf("rgb")>=0&&(H=1):H&&(H<4?s[F]=!0:H=0)}return l}function et(e,t,n,r){var i=t.start,o=t.end;if(u(o)&&u(i)){var a=Ke([i,o],e);if(!a&&r){var l=i.match(/\d\.?\d*/g)||["0"],s=l.length,c=0;a=Ke([o.replace(/\d+\.?\d*/g,function(){return l[c++%s]}),o],e)}if(a)switch(Ut.debug&&console.log("Velocity: Sequence found:",a),a[0].percent=0,a[1].percent=1,t.sequence=a,t.easing){case S["at-start"]:case S.during:case S["at-end"]:a[0].easing=a[1].easing=t.easing}}}function tt(e){if(ke.firstNew===e&&(ke.firstNew=e._next),!(1&e._flags)){var t=e.element,n=e.tweens;p(e.options.duration,ve.duration);for(var r in n){var i=n[r];if(null==i.start){var o=Qe(e.element,r);u(o)?(i.start=Be(o),et(r,i,0,!0)):Array.isArray(o)||console.warn("bad type",i,r,o)}Ut.debug&&console.log('tweensContainer "'+r+'": '+JSON.stringify(i),t)}e._flags|=1}}function nt(e){var t=e.begin||e.options.begin;if(t)try{var n=e.elements;t.call(n,n,e)}catch(e){setTimeout(function(){throw e},1)}}function rt(e){var t=e.progress||e.options.progress;if(t)try{var n=e.elements,r=e.percentComplete,i=e.options,o=e.tween;t.call(n,n,r,Math.max(0,e.timeStart+(null!=e.duration?e.duration:null!=i.duration?i.duration:ve.duration)-vt),void 0!==o?o:String(100*r),e)}catch(e){setTimeout(function(){throw e},1)}}function it(){var e=!0,t=!1,n=void 0;try{for(var r,i=lt[Symbol.iterator]();!(e=(r=i.next()).done);e=!0){rt(r.value)}}catch(e){t=!0,n=e}finally{try{!e&&i.return&&i.return()}finally{if(t)throw n}}lt.clear();var o=!0,a=!1,l=void 0;try{for(var s,u=at[Symbol.iterator]();!(o=(s=u.next()).done);o=!0){Me(s.value)}}catch(e){a=!0,l=e}finally{try{!o&&u.return&&u.return()}finally{if(a)throw l}}at.clear()}var ot=1e3/60,at=new Set,lt=new Set,st=function(){var e=window.performance||{};if("function"!=typeof e.now){var t=e.timing&&e.timing.navigationStart?e.timing.navigationStart:y();e.now=function(){return y()-t}}return e}(),ut=function(e){return setTimeout(e,Math.max(0,ot-(st.now()-vt)))},ct=window.requestAnimationFrame||ut,ft=void 0,dt=void 0,vt=0;try{(dt=new Worker(URL.createObjectURL(new Blob(["("+function(){var e=this,t=void 0;this.onmessage=function(n){switch(n.data){case!0:t||(t=setInterval(function(){e.postMessage(!0)},1e3/30));break;case!1:t&&(clearInterval(t),t=0);break;default:e.postMessage(n.data)}}}+")()"])))).onmessage=function(e){!0===e.data?pt():it()},ke.isMobile||void 0===document.hidden||document.addEventListener("visibilitychange",function(){dt.postMessage(ke.isTicking&&document.hidden)})}catch(e){}function pt(e){if(!ft){if(ft=!0,!1!==e){var t=st.now(),n=vt?t-vt:ot,r=ve.speed,i=ve.easing,o=ve.duration,a=void 0,l=void 0;if(n>=ve.minFrameTime||!vt){for(vt=t;ke.firstNew;)tt(ke.firstNew);for(a=ke.first;a&&a!==ke.firstNew;a=a._next){var s=a.element,u=be(s);if(s.parentNode&&u){var c=a.options,f=a._flags,d=a.timeStart;if(!d){var v=null!=a.queue?a.queue:c.queue;d=t-n,!1!==v&&(d=Math.max(d,u.lastFinishList[v]||0)),a.timeStart=d}16&f?a.timeStart+=n:2&f||(a._flags|=2,c._ready++)}else _e(a)}for(a=ke.first;a&&a!==ke.firstNew;a=l){var p=a._flags;if(l=a._next,2&p&&!(16&p)){var y=a.options;if(32&p&&y._ready<y._total)a.timeStart+=n;else{var g=null!=a.speed?a.speed:null!=y.speed?y.speed:r,h=a.timeStart;if(!(4&p)){var m=null!=a.delay?a.delay:y.delay;if(m){if(h+m/g>t)continue;a.timeStart=h+=m/(m>0?g:1)}a._flags|=4,0==y._started++&&(y._first=a,y.begin&&(nt(a),y.begin=void 0))}1!==g&&(a.timeStart=h+=Math.min(n,t-h)*(1-g));var w=null!=a.easing?a.easing:null!=y.easing?y.easing:i,b=a.ellapsedTime=t-h,S=null!=a.duration?a.duration:null!=y.duration?y.duration:o,x=a.percentComplete=Ut.mock?1:Math.min(b/S,1),O=a.tweens,E=64&p;for(var _ in(a.progress||y._first===a&&y.progress)&&lt.add(a),1===x&&at.add(a),O){var T=O[_],M=T.sequence,V=M.pattern,q="",N=0;if(V){for(var A=(T.easing||w)(x,0,1,_),L=0,J=0;J<M.length-1;J++)M[J].percent<A&&(L=J);for(var I=M[L],j=M[L+1]||I,C=(x-I.percent)/(j.percent-I.percent),P=E?1-C:C,z=j.easing||w||k;N<V.length;N++){var F=I[N];if(null==F)q+=V[N];else{var H=j[N];if(F===H)q+=F;else{var R=z(P,F,H,_);q+=!0!==V[N]?R:Math.round(R)}}}"tween"!==_?(1===x&&(q=Le(q)),Ae(a.element,_,q,T.fn)):a.tween=q}else console.warn("VelocityJS: Missing pattern:",_,JSON.stringify(T[_])),delete O[_]}}}}(lt.size||at.size)&&(document.hidden?dt?dt.postMessage(""):setTimeout(it,1):it())}}ke.first?(ke.isTicking=!0,document.hidden?dt?!1===e&&dt.postMessage(!0):ut(pt):ct(pt)):(ke.isTicking=!1,vt=0,document.hidden&&dt&&dt.postMessage(!1)),ft=!1}}function yt(e,t,n){if(tt(e),void 0===t||t===p(e.queue,e.options.queue,n)){if(!(4&e._flags)){var r=e.options;0==r._started++&&(r._first=e,r.begin&&(nt(e),r.begin=void 0)),e._flags|=4}for(var i in e.tweens){var o=e.tweens[i],a=o.sequence,l=a.pattern,s="",u=0;if(l)for(var c=a[a.length-1];u<l.length;u++){var f=c[u];s+=null==f?l[u]:f}Ae(e.element,i,s,o.fn)}Me(e)}}m(["finish",function(e,t,n){var r=Q(e[0],!0),i=ve.queue,o=!0===e[void 0===r?0:1];if(c(t)&&t.velocity.animations){var a=!0,l=!1,s=void 0;try{for(var u,f=t.velocity.animations[Symbol.iterator]();!(a=(u=f.next()).done);a=!0)yt(u.value,r,i)}catch(e){l=!0,s=e}finally{try{!a&&f.return&&f.return()}finally{if(l)throw s}}}else{for(;ke.firstNew;)tt(ke.firstNew);for(var d,v=ke.first;v&&(o||v!==ke.firstNew);v=d||ke.firstNew)d=v._next,t&&!t.includes(v.element)||yt(v,r,i)}n&&(c(t)&&t.velocity.animations&&t.then?t.then(n._resolver):n._resolver(t))}],!0);var gt={isExpanded:1,isReady:2,isStarted:4,isStopped:8,isPaused:16,isSync:32,isReverse:64};function ht(e,t,n,r){void 0!==t&&t!==p(e.queue,e.options.queue,n)||(r?e._flags|=16:e._flags&=-17)}function mt(e,t,n,r){var i=0===r.indexOf("pause"),o="false"!==(r.indexOf(".")>=0?r.replace(/^.*\./,""):void 0)&&Q(e[0]),a=ve.queue;if(c(t)&&t.velocity.animations){var l=!0,s=!1,u=void 0;try{for(var f,d=t.velocity.animations[Symbol.iterator]();!(l=(f=d.next()).done);l=!0){ht(f.value,o,a,i)}}catch(e){s=!0,u=e}finally{try{!l&&d.return&&d.return()}finally{if(s)throw u}}}else for(var v=ke.first;v;)t&&!t.includes(v.element)||ht(v,o,a,i),v=v._next;n&&(c(t)&&t.velocity.animations&&t.then?t.then(n._resolver):n._resolver(t))}function wt(t,n,r,i){var o=t[0],a=t[1];if(!o)return console.warn("VelocityJS: Cannot access a non-existant property!"),null;if(void 0===a&&!s(o)){if(Array.isArray(o)){if(1===n.length){var f={},d=!0,v=!1,p=void 0;try{for(var y,g=o[Symbol.iterator]();!(d=(y=g.next()).done);d=!0){var h=y.value;f[h]=Be(Qe(n[0],h))}}catch(e){v=!0,p=e}finally{try{!d&&g.return&&g.return()}finally{if(v)throw p}}return f}var m=[],w=!0,b=!1,S=void 0;try{for(var x,k=n[Symbol.iterator]();!(w=(x=k.next()).done);w=!0){var O=x.value,E={},_=!0,T=!1,M=void 0;try{for(var V,q=o[Symbol.iterator]();!(_=(V=q.next()).done);_=!0){var N=V.value;E[N]=Be(Qe(O,N))}}catch(e){T=!0,M=e}finally{try{!_&&q.return&&q.return()}finally{if(T)throw M}}m.push(E)}}catch(e){b=!0,S=e}finally{try{!w&&k.return&&k.return()}finally{if(b)throw S}}return m}if(1===n.length)return Be(Qe(n[0],o));var A=[],L=!0,J=!1,I=void 0;try{for(var j,C=n[Symbol.iterator]();!(L=(j=C.next()).done);L=!0){var P=j.value;A.push(Be(Qe(P,o)))}}catch(e){J=!0,I=e}finally{try{!L&&C.return&&C.return()}finally{if(J)throw I}}return A}var z=[];if(s(o)){for(var F in o)if(o.hasOwnProperty(F)){var H=!0,R=!1,B=void 0;try{for(var W,$=n[Symbol.iterator]();!(H=(W=$.next()).done);H=!0){var G=W.value,Q=o[F];u(Q)||l(Q)?Ae(G,F,o[F]):(z.push('Cannot set a property "'+F+'" to an unknown type: '+(void 0===Q?"undefined":e(Q))),console.warn('VelocityJS: Cannot set a property "'+F+'" to an unknown type:',Q))}}catch(e){R=!0,B=e}finally{try{!H&&$.return&&$.return()}finally{if(R)throw B}}}}else if(u(a)||l(a)){var D=!0,U=!1,Z=void 0;try{for(var Y,X=n[Symbol.iterator]();!(D=(Y=X.next()).done);D=!0){Ae(Y.value,o,String(a))}}catch(e){U=!0,Z=e}finally{try{!D&&X.return&&X.return()}finally{if(U)throw Z}}}else z.push('Cannot set a property "'+o+'" to an unknown type: '+(void 0===a?"undefined":e(a))),console.warn('VelocityJS: Cannot set a property "'+o+'" to an unknown type:',a);r&&(z.length?r._rejecter(z.join(", ")):c(n)&&n.velocity.animations&&n.then?n.then(r._resolver):r._resolver(n))}function bt(e,t,n){tt(e),void 0!==t&&t!==p(e.queue,e.options.queue,n)||(e._flags|=8,Me(e))}m(["option",function(e,t,n,r){var i=e[0],o=r.indexOf(".")>=0?r.replace(/^.*\./,""):void 0,a="false"!==o&&Q(o,!0),l=void 0,s=e[1];if(!i)return console.warn("VelocityJS: Cannot access a non-existant key!"),null;if(c(t)&&t.velocity.animations)l=t.velocity.animations;else{l=[];for(var u=ke.first;u;u=u._next)t.indexOf(u.element)>=0&&p(u.queue,u.options.queue)===a&&l.push(u);if(t.length>1&&l.length>1){for(var f=1,d=l[0].options;f<l.length;)if(l[f++].options!==d){d=null;break}d&&(l=[l[0]])}}if(void 0===s){var v=[],y=gt[i],g=!0,h=!1,m=void 0;try{for(var w,b=l[Symbol.iterator]();!(g=(w=b.next()).done);g=!0){var S=w.value;void 0===y?v.push(p(S[i],S.options[i])):v.push(0==(S._flags&y))}}catch(e){h=!0,m=e}finally{try{!g&&b.return&&b.return()}finally{if(h)throw m}}return 1===t.length&&1===l.length?v[0]:v}var x=void 0;switch(i){case"cache":s=z(s);break;case"begin":s=F(s);break;case"complete":s=H(s);break;case"delay":s=R(s);break;case"duration":s=B(s);break;case"fpsLimit":s=$(s);break;case"loop":s=G(s);break;case"percentComplete":x=!0,s=parseFloat(s);break;case"repeat":case"repeatAgain":s=D(s);break;default:if("_"!==i[0]){var k=parseFloat(s);s===String(k)&&(s=k);break}case"queue":case"promise":case"promiseRejectEmpty":case"easing":case"started":return void console.warn("VelocityJS: Trying to set a read-only key:",i)}if(void 0===s||s!=s)return console.warn("VelocityJS: Trying to set an invalid value:"+i+"="+s+" ("+e[1]+")"),null;var O=!0,E=!1,_=void 0;try{for(var T,M=l[Symbol.iterator]();!(O=(T=M.next()).done);O=!0){var V=T.value;x?V.timeStart=vt-p(V.duration,V.options.duration,ve.duration)*s:V[i]=s}}catch(e){E=!0,_=e}finally{try{!O&&M.return&&M.return()}finally{if(E)throw _}}n&&(c(t)&&t.velocity.animations&&t.then?t.then(n._resolver):n._resolver(t))}],!0),m(["pause",mt],!0),m(["resume",mt],!0),m(["property",wt],!0),m(["reverse",function(e,t,n,r){throw new SyntaxError("VelocityJS: The 'reverse' action is built in and private.")}],!0),m(["stop",function(e,t,n,r){var i=Q(e[0],!0),o=ve.queue,a=!0===e[void 0===i?0:1];if(c(t)&&t.velocity.animations){var l=!0,s=!1,u=void 0;try{for(var f,d=t.velocity.animations[Symbol.iterator]();!(l=(f=d.next()).done);l=!0)bt(f.value,i,o)}catch(e){s=!0,u=e}finally{try{!l&&d.return&&d.return()}finally{if(s)throw u}}}else{for(;ke.firstNew;)tt(ke.firstNew);for(var v,p=ke.first;p&&(a||p!==ke.firstNew);p=v||ke.firstNew)v=p._next,t&&!t.includes(p.element)||bt(p,i,o)}n&&(c(t)&&t.velocity.animations&&t.then?t.then(n._resolver):n._resolver(t))}],!0),m(["style",wt],!0),m(["tween",function(e,t,n,i){var o=void 0;if(t){if(1!==t.length)throw new Error("VelocityJS: Cannot tween more than one element!")}else{if(!e.length)return console.info('Velocity(<element>, "tween", percentComplete, property, end | [end, <easing>, <start>], <easing>) => value\nVelocity(<element>, "tween", percentComplete, {property: end | [end, <easing>, <start>], ...}, <easing>) => {property: value, ...}'),null;t=[document.body],o=!0}var a=e[0],c={elements:t,element:t[0],queue:!1,options:{duration:1e3},tweens:null},f={},d=e[1],v=void 0,y=void 0,g=e[2],h=0;if(u(e[1])?Te&&Te[e[1]]?(y=Te[e[1]],d={},g=e[2]):(v=!0,d=r({},e[1],e[2]),g=e[3]):Array.isArray(e[1])&&(v=!0,d={tween:e[1]},g=e[2]),!l(a)||a<0||a>1)throw new Error("VelocityJS: Must tween a percentage from 0 to 1!");if(!s(d))throw new Error("VelocityJS: Cannot tween an invalid property!");if(o)for(var m in d)if(d.hasOwnProperty(m)&&(!Array.isArray(d[m])||d[m].length<2))throw new Error("VelocityJS: When not supplying an element you must force-feed values: "+m);var b=W(p(g,ve.easing),w);for(var S in y?tn(c,y):Ze(c,d),c.tweens){var x=c.tweens[S],O=x.sequence,E=O.pattern,_="",T=0;if(h++,E){for(var M=(x.easing||b)(a,0,1,S),V=0,q=0;q<O.length-1;q++)O[q].percent<M&&(V=q);for(var N=O[V],A=O[V+1]||N,L=(a-N.percent)/(A.percent-N.percent),J=A.easing||k;T<E.length;T++){var I=N[T];if(null==I)_+=E[T];else{var j=A[T];if(I===j)_+=I;else{var C=J(L,I,j,S);_+=!0===E[T]?Math.round(C):C}}}f[S]=_}}if(v&&1===h)for(var P in f)if(f.hasOwnProperty(P))return f[P];return f}],!0);var St={aliceblue:15792383,antiquewhite:16444375,aqua:65535,aquamarine:8388564,azure:15794175,beige:16119260,bisque:16770244,black:0,blanchedalmond:16772045,blue:255,blueviolet:9055202,brown:10824234,burlywood:14596231,cadetblue:6266528,chartreuse:8388352,chocolate:13789470,coral:16744272,cornflowerblue:6591981,cornsilk:16775388,crimson:14423100,cyan:65535,darkblue:139,darkcyan:35723,darkgoldenrod:12092939,darkgray:11119017,darkgrey:11119017,darkgreen:25600,darkkhaki:12433259,darkmagenta:9109643,darkolivegreen:5597999,darkorange:16747520,darkorchid:10040012,darkred:9109504,darksalmon:15308410,darkseagreen:9419919,darkslateblue:4734347,darkslategray:3100495,darkslategrey:3100495,darkturquoise:52945,darkviolet:9699539,deeppink:16716947,deepskyblue:49151,dimgray:6908265,dimgrey:6908265,dodgerblue:2003199,firebrick:11674146,floralwhite:16775920,forestgreen:2263842,fuchsia:16711935,gainsboro:14474460,ghostwhite:16316671,gold:16766720,goldenrod:14329120,gray:8421504,grey:8421504,green:32768,greenyellow:11403055,honeydew:15794160,hotpink:16738740,indianred:13458524,indigo:4915330,ivory:16777200,khaki:15787660,lavender:15132410,lavenderblush:16773365,lawngreen:8190976,lemonchiffon:16775885,lightblue:11393254,lightcoral:15761536,lightcyan:14745599,lightgoldenrodyellow:16448210,lightgray:13882323,lightgrey:13882323,lightgreen:9498256,lightpink:16758465,lightsalmon:16752762,lightseagreen:2142890,lightskyblue:8900346,lightslategray:7833753,lightslategrey:7833753,lightsteelblue:11584734,lightyellow:16777184,lime:65280,limegreen:3329330,linen:16445670,magenta:16711935,maroon:8388608,mediumaquamarine:6737322,mediumblue:205,mediumorchid:12211667,mediumpurple:9662683,mediumseagreen:3978097,mediumslateblue:8087790,mediumspringgreen:64154,mediumturquoise:4772300,mediumvioletred:13047173,midnightblue:1644912,mintcream:16121850,mistyrose:16770273,moccasin:16770229,navajowhite:16768685,navy:128,oldlace:16643558,olive:8421376,olivedrab:7048739,orange:16753920,orangered:16729344,orchid:14315734,palegoldenrod:15657130,palegreen:10025880,paleturquoise:11529966,palevioletred:14381203,papayawhip:16773077,peachpuff:16767673,peru:13468991,pink:16761035,plum:14524637,powderblue:11591910,purple:8388736,rebeccapurple:6697881,red:16711680,rosybrown:12357519,royalblue:4286945,saddlebrown:9127187,salmon:16416882,sandybrown:16032864,seagreen:3050327,seashell:16774638,sienna:10506797,silver:12632256,skyblue:8900331,slateblue:6970061,slategray:7372944,slategrey:7372944,snow:16775930,springgreen:65407,steelblue:4620980,tan:13808780,teal:32896,thistle:14204888,tomato:16737095,turquoise:4251856,violet:15631086,wheat:16113331,white:16777215,whitesmoke:16119285,yellow:16776960,yellowgreen:10145074};for(var xt in St)if(St.hasOwnProperty(xt)){var kt=St[xt];He[xt]=Math.floor(kt/65536)+","+Math.floor(kt/256%256)+","+kt%256}function Ot(e){return e<1/2.75?7.5625*e*e:e<2/2.75?7.5625*(e-=1.5/2.75)*e+.75:e<2.5/2.75?7.5625*(e-=2.25/2.75)*e+.9375:7.5625*(e-=2.625/2.75)*e+.984375}function Et(e){return 1-Ot(1-e)}!function(e,t){x([e,function(e,n,r){return 0===e?n:1===e?r:Math.pow(e,2)*((t+1)*e-t)*(r-n)}])}("easeInBack",1.7),function(e,t){x([e,function(e,n,r){return 0===e?n:1===e?r:(Math.pow(--e,2)*((t+1)*e+t)+1)*(r-n)}])}("easeOutBack",1.7),function(e,t){t*=1.525,x([e,function(e,n,r){return 0===e?n:1===e?r:.5*((e*=2)<1?Math.pow(e,2)*((t+1)*e-t):Math.pow(e-2,2)*((t+1)*(e-2)+t)+2)*(r-n)}])}("easeInOutBack",1.7),x(["easeInBounce",function(e,t,n){return 0===e?t:1===e?n:Et(e)*(n-t)}]),x(["easeOutBounce",function(e,t,n){return 0===e?t:1===e?n:Ot(e)*(n-t)}]),x(["easeInOutBounce",function(e,t,n){return 0===e?t:1===e?n:(e<.5?.5*Et(2*e):.5*Ot(2*e-1)+.5)*(n-t)}]);var _t=2*Math.PI;function Tt(e,t){return function(n,r){if(void 0===r)return We(n,e,t)+"px";Ae(n,e,parseFloat(r)-We(n,e,t)+"px")}}!function(e,t,n){x([e,function(e,r,i){return 0===e?r:1===e?i:-t*Math.pow(2,10*(e-=1))*Math.sin((e-n/_t*Math.asin(1/t))*_t/n)*(i-r)}])}("easeInElastic",1,.3),function(e,t,n){x([e,function(e,r,i){return 0===e?r:1===e?i:(t*Math.pow(2,-10*e)*Math.sin((e-n/_t*Math.asin(1/t))*_t/n)+1)*(i-r)}])}("easeOutElastic",1,.3),function(e,t,n){x([e,function(e,r,i){if(0===e)return r;if(1===e)return i;var o=n/_t*Math.asin(1/t);return((e=2*e-1)<0?t*Math.pow(2,10*e)*Math.sin((e-o)*_t/n)*-.5:t*Math.pow(2,-10*e)*Math.sin((e-o)*_t/n)*.5+1)*(i-r)}])}("easeInOutElastic",1,.3*1.5),x(["at-start",function(e,t,n){return 0===e?t:n}]),x(["during",function(e,t,n){return 0===e||1===e?t:n}]),x(["at-end",function(e,t,n){return 1===e?n:t}]),Ve(["Element","innerWidth",Tt("width",!0)]),Ve(["Element","innerHeight",Tt("height",!0)]),Ve(["Element","outerWidth",Tt("width",!1)]),Ve(["Element","outerHeight",Tt("height",!1)]);var Mt=/^(b|big|i|small|tt|abbr|acronym|cite|code|dfn|em|kbd|strong|samp|let|a|bdo|br|img|map|object|q|script|span|sub|sup|button|input|label|select|textarea)$/i,Vt=/^(li)$/i,qt=/^(tr)$/i,Nt=/^(table)$/i,At=/^(tbody)$/i;function Lt(e,t){return function(n,r){if(null==r)return Qe(n,"client"+e,null,!0),Qe(n,"scroll"+e,null,!0),n["scroll"+t]+"px";var i=parseFloat(r);switch(r.replace(String(i),"")){case"":case"px":n["scroll"+t]=i;break;case"%":var o=parseFloat(Qe(n,"client"+e)),a=parseFloat(Qe(n,"scroll"+e));n["scroll"+t]=Math.max(0,a-o)*i/100}}}Ve(["Element","display",function(e,t){var n=e.style;if(void 0===t)return Ge(e,"display");if("auto"===t){var r=e&&e.nodeName,i=be(e);t=Mt.test(r)?"inline":Vt.test(r)?"list-item":qt.test(r)?"table-row":Nt.test(r)?"table":At.test(r)?"table-row-group":"block",i.cache.display=t}n.display=t}]),Ve(["HTMLElement","scroll",Lt("Height","Top"),!1]),Ve(["HTMLElement","scrollTop",Lt("Height","Top"),!1]),Ve(["HTMLElement","scrollLeft",Lt("Width","Left"),!1]),Ve(["HTMLElement","scrollWidth",function(e,t){if(null==t)return e.scrollWidth+"px"}]),Ve(["HTMLElement","clientWidth",function(e,t){if(null==t)return e.clientWidth+"px"}]),Ve(["HTMLElement","scrollHeight",function(e,t){if(null==t)return e.scrollHeight+"px"}]),Ve(["HTMLElement","clientHeight",function(e,t){if(null==t)return e.clientHeight+"px"}]);var Jt=/^(b(lockSize|o(rder(Bottom(LeftRadius|RightRadius|Width)|Image(Outset|Width)|LeftWidth|R(adius|ightWidth)|Spacing|Top(LeftRadius|RightRadius|Width)|Width)|ttom))|column(Gap|RuleWidth|Width)|f(lexBasis|ontSize)|grid(ColumnGap|Gap|RowGap)|height|inlineSize|le(ft|tterSpacing)|m(a(rgin(Bottom|Left|Right|Top)|x(BlockSize|Height|InlineSize|Width))|in(BlockSize|Height|InlineSize|Width))|o(bjectPosition|utline(Offset|Width))|p(adding(Bottom|Left|Right|Top)|erspective)|right|s(hapeMargin|troke(Dashoffset|Width))|t(extIndent|op|ransformOrigin)|w(idth|ordSpacing))$/;function It(e,t){return function(n,r){if(void 0===r)return Ge(n,e)||Ge(n,t);n.style[e]=n.style[t]=r}}function jt(e){return function(t,n){if(void 0===n)return Ge(t,e);t.style[e]=n}}var Ct=/^(webkit|moz|ms|o)[A-Z]/,Pt=ke.prefixElement;if(Pt)for(var zt in Pt.style)if(Ct.test(zt)){var Ft=zt.replace(/^[a-z]+([A-Z])/,function(e,t){return t.toLowerCase()}),Ht=Jt.test(Ft)?"px":void 0;Ve(["Element",Ft,It(zt,Ft),Ht])}else if(!qe(["Element",zt])){var Rt=Jt.test(zt)?"px":void 0;Ve(["Element",zt,jt(zt),Rt])}function Bt(e){return function(t,n){if(void 0===n)return t.getAttribute(e);t.setAttribute(e,n)}}var Wt=document.createElement("div"),$t=/^SVG(.*)Element$/,Gt=/Element$/;function Qt(e){return function(t,n){if(void 0===n)try{return t.getBBox()[e]+"px"}catch(e){return"0px"}t.setAttribute(e,n)}}Object.getOwnPropertyNames(window).forEach(function(e){var t=$t.exec(e);if(t&&"SVG"!==t[1])try{var n=t[1]?document.createElementNS("http://www.w3.org/2000/svg",(t[1]||"svg").toLowerCase()):document.createElement("svg");for(var r in n){var i=n[r];!u(r)||"o"===r[0]&&"n"===r[1]||r===r.toUpperCase()||Gt.test(r)||r in Wt||o(i)||Ve([e,r,Bt(r)])}}catch(t){console.error("VelocityJS: Error when trying to identify SVG attributes on "+e+".",t)}}),Ve(["SVGElement","width",Qt("width")]),Ve(["SVGElement","height",Qt("height")]),Ve(["Element","tween",function(e,t){if(void 0===t)return""}]);var Dt,Ut=an;if(function(e){e.Actions=h,e.Easings=S,e.Sequences=Te,e.State=ke,e.defaults=ve,e.patch=sn,e.debug=!1,e.mock=!1,e.version="2.0.5",e.Velocity=an}(Dt||(Dt={})),function(){if(document.documentMode)return document.documentMode;for(var e=7;e>4;e--){var t=document.createElement("div");if(t.innerHTML="\x3c!--[if IE "+e+"]><span></span><![endif]--\x3e",t.getElementsByTagName("span").length)return t=null,e}}()<=8)throw new Error("VelocityJS cannot run on Internet Explorer 8 or earlier");if(window){var Zt=window.jQuery,Yt=window.Zepto;sn(window,!0),sn(Element&&Element.prototype),sn(NodeList&&NodeList.prototype),sn(HTMLCollection&&HTMLCollection.prototype),sn(Zt,!0),sn(Zt&&Zt.fn),sn(Yt,!0),sn(Yt&&Yt.fn)}var Xt=function(t){if(Dt.hasOwnProperty(t))switch(void 0===t?"undefined":e(t)){case"number":case"boolean":v(Ut,t,{get:function(){return Dt[t]},set:function(e){Dt[t]=e}},!0);break;default:v(Ut,t,Dt[t],!0)}};for(var Kt in Dt)Xt(Kt);Object.freeze(Ut);var en=/(\d*\.\d+|\d+\.?|from|to)/g;function tn(e,t){var n=e.tweens=Object.create(null),r=e.element;for(var i in t.tweens)if(t.tweens.hasOwnProperty(i)){var o=Ne(r,i);if(!o&&"tween"!==i){Ut.debug&&console.log("Skipping ["+i+"] due to a lack of browser support.");continue}n[i]={fn:o,sequence:t.tweens[i]}}}m(["registerSequence",function e(t){if(s(t[0]))for(var n in t[0])t[0].hasOwnProperty(n)&&e([n,t[0][n]]);else if(u(t[0])){var r=t[0],i=t[1];if(u(r))if(s(i)){Te[r]&&console.warn("VelocityJS: Replacing named sequence:",r);var o={},a=new Array(100),c=[],f=Te[r]={},d=B(i.duration);for(var v in f.tweens={},l(d)&&(f.duration=d),i)if(i.hasOwnProperty(v)){var p=String(v).match(en);if(p){var y=!0,g=!1,h=void 0;try{for(var m,b=p[Symbol.iterator]();!(y=(m=b.next()).done);y=!0){var S=m.value,x="from"===S?0:"to"===S?100:parseFloat(S);if(x<0||x>100)console.warn("VelocityJS: Trying to use an invalid value as a percentage (0 <= n <= 100):",r,x);else if(isNaN(x))console.warn("VelocityJS: Trying to use an invalid number as a percentage:",r,v,S);else for(var k in o[String(x)]||(o[String(x)]=[]),o[String(x)].push(v),i[v])c.includes(k)||c.push(k)}}catch(e){g=!0,h=e}finally{try{!y&&b.return&&b.return()}finally{if(g)throw h}}}}var O=Object.keys(o).sort(function(e,t){var n=parseFloat(e),r=parseFloat(t);return n>r?1:n<r?-1:0});O.forEach(function(e){a.push.apply(o[e])});var E=!0,_=!1,T=void 0;try{for(var M,V=c[Symbol.iterator]();!(E=(M=V.next()).done);E=!0){var q=M.value,N=[],A=Ie(q),L=!0,J=!1,I=void 0;try{for(var j,C=O[Symbol.iterator]();!(L=(j=C.next()).done);L=!0){var P=j.value,z=!0,F=!1,H=void 0;try{for(var R,$=o[P][Symbol.iterator]();!(z=(R=$.next()).done);z=!0){var G=i[R.value];G[A]&&N.push(u(G[A])?G[A]:G[A][0])}}catch(e){F=!0,H=e}finally{try{!z&&$.return&&$.return()}finally{if(F)throw H}}}}catch(e){J=!0,I=e}finally{try{!L&&C.return&&C.return()}finally{if(J)throw I}}if(N.length){var Q=Ke(N,A),D=0;if(Q){var U=!0,Z=!1,Y=void 0;try{for(var X,K=O[Symbol.iterator]();!(U=(X=K.next()).done);U=!0){var ee=X.value,te=!0,ne=!1,re=void 0;try{for(var ie,oe=o[ee][Symbol.iterator]();!(te=(ie=oe.next()).done);te=!0){var ae=i[ie.value][A];ae&&(Array.isArray(ae)&&ae.length>1&&(u(ae[1])||Array.isArray(ae[1]))&&(Q[D].easing=W(ae[1],f.duration||w)),Q[D++].percent=parseFloat(ee)/100)}}catch(e){ne=!0,re=e}finally{try{!te&&oe.return&&oe.return()}finally{if(ne)throw re}}}}catch(e){Z=!0,Y=e}finally{try{!U&&K.return&&K.return()}finally{if(Z)throw Y}}f.tweens[A]=Q}}}}catch(e){_=!0,T=e}finally{try{!E&&V.return&&V.return()}finally{if(_)throw T}}}else console.warn("VelocityJS: Trying to set 'registerSequence' sequence to an invalid value:",r,i);else console.warn("VelocityJS: Trying to set 'registerSequence' name to an invalid value:",r)}}],!0);var nn=void 0;try{nn=Promise}catch(e){}var rn=", if that is deliberate then pass `promiseRejectEmpty:false` as an option";function on(e,t){v(t,"promise",e),v(t,"then",e.then.bind(e)),v(t,"catch",e.catch.bind(e)),e.finally&&v(t,"finally",e.finally.bind(e))}function an(){for(var e=arguments.length,t=Array(e),n=0;n<e;n++)t[n]=arguments[n];var r=ve,y=arguments,g=y[0],m=s(g)&&(g.p||s(g.properties)&&!g.properties.names||u(g.properties)),w=0,b=void 0,S=void 0,x=void 0,k=void 0,O=void 0,E=void 0,_=void 0;a(this)?b=[this]:f(this)?(b=d(this),c(this)&&(k=this.velocity.animations)):m?(b=d(g.elements||g.e),w++):a(g)?(b=d([g]),w++):f(g)&&(b=d(g),w++),b&&(v(b,"velocity",an.bind(b)),k&&v(b.velocity,"animations",k));var T="reverse"===(S=m?p(g.properties,g.p):y[w++]),M=!T&&u(S),V=M&&Te[S],q=m?p(g.options,g.o):y[w];if(s(q)&&(x=q),nn&&p(x&&x.promise,r.promise)&&(O=new nn(function(e,t){_=t,E=function(t){c(t)&&t.promise?(delete t.then,delete t.catch,delete t.finally,e(t),on(t.promise,t)):e(t)}}),b&&on(O,b)),O){var N=x&&x.promiseRejectEmpty,A=p(N,r.promiseRejectEmpty);b||M?S||(A?_("Velocity: No properties supplied"+(i(N)?"":rn)+". Aborting."):E()):A?_("Velocity: No elements supplied"+(i(N)?"":rn)+". Aborting."):E()}if(!b&&!M||!S)return O;if(M){for(var L=[],J=O&&{_promise:O,_resolver:E,_rejecter:_};w<y.length;)L.push(y[w++]);var I=S.replace(/\..*$/,""),j=h[I];if(j){var C=j(L,b,J,S);return void 0!==C?C:b||O}if(!V)return void console.error("VelocityJS: First argument ("+S+") was not a property map, a known action, or a registered redirect. Aborting.")}var P=void 0;if(s(S)||T||V){var z={},$=r.sync;if(O&&(v(z,"_promise",O),v(z,"_rejecter",_),v(z,"_resolver",E)),v(z,"_ready",0),v(z,"_started",0),v(z,"_completed",0),v(z,"_total",0),s(x)){var Y=B(x.duration);P=void 0!==Y,z.duration=p(Y,r.duration),z.delay=p(R(x.delay),r.delay),z.easing=W(p(x.easing,r.easing),z.duration)||W(r.easing,z.duration),z.loop=p(G(x.loop),r.loop),z.repeat=z.repeatAgain=p(D(x.repeat),r.repeat),null!=x.speed&&(z.speed=p(U(x.speed),1)),i(x.promise)&&(z.promise=x.promise),z.queue=p(Q(x.queue),r.queue),x.mobileHA&&!ke.isGingerbread&&(z.mobileHA=!0),!0===x.drag&&(z.drag=!0),(l(x.stagger)||o(x.stagger))&&(z.stagger=x.stagger),T||(null!=x.display&&(S.display=x.display,console.error('Deprecated "options.display" used, this is now a property:',x.display)),null!=x.visibility&&(S.visibility=x.visibility,console.error('Deprecated "options.visibility" used, this is now a property:',x.visibility)));var X=F(x.begin),K=H(x.complete),ee=function(e){if(o(e))return e;null!=e&&console.warn("VelocityJS: Trying to set 'progress' to an invalid value:",e)}(x.progress),te=Z(x.sync);null!=X&&(z.begin=X),null!=K&&(z.complete=K),null!=ee&&(z.progress=ee),null!=te&&($=te)}else if(!m){var ne=0;if(z.duration=B(y[w],!0),void 0===z.duration?z.duration=r.duration:(P=!0,ne++),!o(y[w+ne])){var re=W(y[w+ne],p(z&&B(z.duration),r.duration),!0);void 0!==re&&(ne++,z.easing=re)}var ie=H(y[w+ne],!0);void 0!==ie&&(z.complete=ie),z.delay=r.delay,z.loop=r.loop,z.repeat=z.repeatAgain=r.repeat}if(T&&!1===z.queue)throw new Error("VelocityJS: Cannot reverse a queue:false animation.");!P&&V&&V.duration&&(z.duration=V.duration);var oe={options:z,elements:b,_prev:void 0,_next:void 0,_flags:$?32:0,percentComplete:0,ellapsedTime:0,timeStart:0};k=[];for(var ae=0;ae<b.length;ae++){var le=b[ae],se=0;if(a(le)){if(T){var ue=be(le).lastAnimationList[z.queue];if(!(S=ue&&ue.tweens)){console.error("VelocityJS: Attempting to reverse an animation on an element with no previous animation:",le);continue}se|=64&~(64&ue._flags)}var ce=Object.assign({},oe,{element:le,_flags:oe._flags|se});if(z._total++,k.push(ce),z.stagger)if(o(z.stagger)){var fe=ln(z.stagger,le,ae,b.length,b,"stagger");l(fe)&&(ce.delay=z.delay+fe)}else ce.delay=z.delay+z.stagger*ae;z.drag&&(ce.duration=z.duration-z.duration*Math.max(1-(ae+1)/b.length,.75)),V?tn(ce,V):T?ce.tweens=S:(ce.tweens=Object.create(null),Ze(ce,S)),Ee(le,ce,z.queue)}}!1===ke.isTicking&&pt(!1),k&&v(b.velocity,"animations",k)}return b||O}function ln(e,t,n,r,i,o){try{return e.call(t,n,r,i,o)}catch(e){console.error("VelocityJS: Exception when calling '"+o+"' callback:",e)}}function sn(e,t){try{v(e,(t?"V":"v")+"elocity",an)}catch(e){console.warn("VelocityJS: Error when trying to add prototype.",e)}}var un,cn=an;if(function(e){e.Actions=h,e.Easings=S,e.Sequences=Te,e.State=ke,e.defaults=ve,e.patch=sn,e.debug=!1,e.mock=!1,e.version="2.0.5",e.Velocity=an}(un||(un={})),function(){if(document.documentMode)return document.documentMode;for(var e=7;e>4;e--){var t=document.createElement("div");if(t.innerHTML="\x3c!--[if IE "+e+"]><span></span><![endif]--\x3e",t.getElementsByTagName("span").length)return t=null,e}}()<=8)throw new Error("VelocityJS cannot run on Internet Explorer 8 or earlier");if(window){var fn=window.jQuery,dn=window.Zepto;sn(window,!0),sn(Element&&Element.prototype),sn(NodeList&&NodeList.prototype),sn(HTMLCollection&&HTMLCollection.prototype),sn(fn,!0),sn(fn&&fn.fn),sn(dn,!0),sn(dn&&dn.fn)}var vn=function(t){if(un.hasOwnProperty(t))switch(void 0===t?"undefined":e(t)){case"number":case"boolean":v(cn,t,{get:function(){return un[t]},set:function(e){un[t]=e}},!0);break;default:v(cn,t,un[t],!0)}};for(var pn in un)vn(pn);return Object.freeze(cn),cn});
var Cookie =
{
   set: function(name, value, days)
   {
      var domain, domainParts, date, expires, host;

      if (days)
      {
         date = new Date();
         date.setTime(date.getTime()+(days*24*60*60*1000));
         expires = "; expires="+date.toGMTString();
      }
      else
      {
         expires = "";
      }

      host = location.host;
      if (host.split('.').length === 1)
      {
         // no "." in a domain - it's localhost or something similar
         document.cookie = name+"="+value+expires+"; path=/";
      }
      else
      {
         // Remember the cookie on all subdomains.
          //
         // Start with trying to set cookie to the top domain.
         // (example: if user is on foo.com, try to set
         //  cookie to domain ".com")
         //
         // If the cookie will not be set, it means ".com"
         // is a top level domain and we need to
         // set the cookie to ".foo.com"
         domainParts = host.split('.');
         domainParts.shift();
         domain = '.'+domainParts.join('.');

         document.cookie = name+"="+value+expires+"; path=/; domain="+domain;

         // check if cookie was successfuly set to the given domain
         // (otherwise it was a Top-Level Domain)
         if (Cookie.get(name) == null || Cookie.get(name) != value)
         {
            // append "." to current domain
            domain = '.'+host;
            document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
         }
      }
   },

   get: function(name)
   {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i=0; i < ca.length; i++)
      {
         var c = ca[i];
         while (c.charAt(0)==' ')
         {
            c = c.substring(1,c.length);
         }

         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
   },

   erase: function(name)
   {
      Cookie.set(name, '', -1);
   }
};

function create_new_order(){
  if('undefined' !== typeof(frontdesk_order_new)){
    frontdesk_order_new.set_prop('visible', true);
  }

  if('undefined' !== typeof(frontdesk_list)){
    frontdesk_list.set_prop('visible', false);
    frontdesk_list.set_prop('selected_order_id', -1);
  }

  if('undefined' !== typeof(filters)){
    filters.set_prop('visible', false);
  }

  if('undefined' !== typeof(frontdesk_order)){
    frontdesk_order.set_prop('visible', false);
  }
}

function strip(val){
  return JSON.parse(JSON.stringify(val));
}

function ctime(label, color){
  if (theme_debug) {
    if(!color){
      color = 'blue';
    }
   console.group('%c '+label+' FINISHED', 'color:'+color);
   console.timeEnd(label);
   console.groupEnd();
  }
}

function slog(label, color, bg_color) {
  if (theme_debug) {
    if(!color){
      color = 'blue';
    }
    if(!bg_color){
      bg_color = '#fff';
    }
   console.group('%c '+ label , 'color:'+color+'; background: '+bg_color);
  }
}

function elog() {
  if (theme_debug) {
   console.groupEnd();
  }
}

function clog(value, color) {

    if(!color){
      color = 'black';
    }

  if (theme_debug) {

    if(typeof(value) === 'string'){
     console.log('%c ' + value , 'color:'+color);
    }else{
     console.log(value);
    }
  }
}

function block(){
  jQuery('.block-screen').addClass('shown')
}

function unblock(){
  jQuery('.block-screen').removeClass('shown')
}


function is_boolean(val){
  switch(typeof(val)){
    case 'boolean':
      return val;
      break;
    case 'string':
      if(val.toLowerCase() === 'false'){
        return false;
      }
      if(val.toLowerCase() === 'true'){
        return true;
      }
      return !!parseInt(val);
      break;
    case 'number':
      return !!parseInt(val);
      break;
    case 'undefined':
      return false;
      break;
  }
}
jQuery(document).on('click', '.mobile-menu-switcher', function(){
  jQuery(this).toggleClass('active');
  jQuery('.menu-holder').toggleClass('shown');
})

jQuery(document).on('click', '.site-container', function(e){
  if(!jQuery(e.target).closest('.menu-holder').length && !jQuery(e.target).closest('.mobile-menu-switcher').length){
    jQuery('.mobile-menu-switcher').removeClass('active');
    jQuery('.menu-holder').removeClass('shown');
  }
})
jQuery(document).ready(function(){
  init_date_range();
})

function init_date_range(){
  var now     = new Date();
  var last_7  = new Date();
  var last_30 = new Date();
  var last_90 = new Date();
  last_7.setDate(last_7.getDate() - 7);
  last_30.setDate(last_30.getDate() - 30);
  last_90.setDate(last_7.getDate() - 90);

  var now     = new Date();
  var today_str = (now.getMonth() + 1) + '/' + now.getDate() + '/' + now.getFullYear();

  var last_7_str   = (last_7.getMonth() + 1) + '/' + last_7.getDate() + '/' + last_7.getFullYear();
  var last_30_str  = (last_30.getMonth() + 1) + '/' + last_30.getDate() + '/' + last_30.getFullYear();
  var last_90_str  = (last_90.getMonth() + 1) + '/' + last_90.getDate() + '/' + last_90.getFullYear();
  var for_last_day = new Date(now.getFullYear(), now.getMonth() + 1, 0);

  var month_first_day = (now.getMonth() + 1) + '/' + 1 + '/' + now.getFullYear();

  var month_last_day = (now.getMonth() + 1) + '/' + for_last_day.getDate() + '/' + now.getFullYear();

  var ranges =  {
        "Today": [
            today_str,
            today_str
        ],
        'This Month': [
          month_first_day,
          today_str
        ],

        'Past 7 Days': [
          last_7_str,
          today_str
        ],

        'Past 30 Days':[
          last_30_str,
          today_str
        ],

        'Past 90 Days': [
          last_90_str,
          today_str
        ],
        'All time':[
          '01/01/1999',
          today_str,
        ],
    };

  var saved_interval = Cookie.get('date_range_frontdesk')? JSON.parse(Cookie.get('date_range_frontdesk')) : data = {
      label : 'Past 30 Days',
      start : last_30_str,
      end   : today_str,
    };

  var date_0 = new Date( saved_interval.start );
  var date_1 = new Date( saved_interval.end );
  var fmt  = new DateFormatter();

  var range_text = fmt.formatDate(date_0, 'M d Y')  + ' → ' + fmt.formatDate(date_1, 'M d Y');

  jQuery('.range-datepicker__label').text(saved_interval.label);
  jQuery('.range-datepicker__text').text(range_text);

  jQuery('.range-datepicker').daterangepicker({
    "autoApply": true,
    "ranges": ranges,
    "alwaysShowCalendars": true,
    "startDate": saved_interval.start,
    "endDate"  : saved_interval.end,
  }, function(start, end, label) {

    var text = start.format('MMM DD YYYY') + ' → ' + end.format('MMM DD YYYY');

    var data = {
      label : label,
      start : start.format('M/D/YYYY'),
      end   : end.format('M/D/YYYY'),
      end_his : end.format('D MMM YYYY'),
      start_his: start.format('D MMM YYYY'),
    };

    Cookie.set('date_range_frontdesk', JSON.stringify(data));
    jQuery('.range-datepicker__text').text(text);
    jQuery('.range-datepicker__label').text(label);

    var data = {from: start.format('MMM DD YYYY') , to: end.format('MMM DD YYYY'), label: label, _from: start.format('MM/DD/YYYY'), _to: end.format('MM/DD/YYYY'), }
    data.type = jQuery('#page_type').val();
    jQuery(document).trigger('get_order_by_date', data);

  });
}

jQuery(document).on('get_order_by_date', function(e, data){
  slog('Update list of orders', 'green');
  block();

  jQuery.ajax({
    url: WP_URLS.ajax,
    type: 'POST',
    dataType: 'json',
    data: {action: 'get_orders_by_dates', data: data},
  })

  .done(function(data) {
    if('undefined' !== typeof(frontdesk_list)){
      frontdesk_list.items = strip(data.orders);
    }
    if('undefined' !== typeof(studio_app)){
      studio_app.items = strip(data.orders);
      studio_app.filter_values = strip(data.filters);
    }

    if('undefined' !== typeof(filters)){
      filters.filter_values = strip(data.filters);
      filters.init_selects();
    }
  })
  .fail(function(e) {
    alert("Request Failed");
  })
  .always(function(e) {
    clog(strip(e));
    ctime('list of orders')
    elog();
    unblock();
  });
})

console.time('vue script');
var select_mixin = {
  data: function () {
    return {
      select_name : this._select_name,
      options: '',
      selected:this._selected,
      isExpanded: this._isExpanded,
      isSelected: this._isSelected ? this._isSelected: [],
      isHiddenSelect: true,
      isHiddenImitation: false,
    }
  },

  props:{
    _select_name : String,
    _options: Array,
    _selected: String,
    _isExpanded: String,
    _isSelected: Array,
    _isHiddenSelect: Boolean,
    _isHiddenImitation: Boolean,
  },

  beforeMount:function(){
    this.options = this._options;

  },

  mounted: function(){
  },

  change: function(){
    this.options = this._options;
  },

  watch:{
    selected: function(){
      this.$el.classList.remove('error');
    },
  },

  mounted:function(){
    this.change_width();
  },

  directives: {
    'click-outside': {
      bind (el,binding, vnode) {
        const outsideClickEventHandler = event => {
          if(!el.contains(event.target) && el !== event.target){
            binding.value(event);
          }
        }

        el.__outsideClickEventHandler__ = outsideClickEventHandler;
        document.addEventListener("click", outsideClickEventHandler);
      },

      unbind(el) {
        document.removeEventListener("click", el.__outsideClickEventHandler__);
      },
    }
  },

  methods: {
    change: function(){
      this.$emit('update_list', {val: this.selected, name: this.select_name});
    },

    // toggles state of expanded list initation
    expand_select: function(){
      this.isExpanded = 'expanded';
    },

    // toggles select in expanded dropdown
    update_selected_option: function(){
      for(var id in this.options){
        this.isSelected[this.options[id]] = false;
      }

      this.isSelected[this.selected] = true;
    },

    // changes data on option click
    imitate_select_option: function(value){
      this.selected = value;
      this.isExpanded = '';
      this.update_selected_option();
      this.change();
    },

     // closes select
    discard_select:function(){
      this.isExpanded = '';
    },

     // updates options of a select
    update_options: function(options){
      this.options = options;
      this.selected = options[0];
      this.isExpanded = '';
      this.update_selected_option();
    },

    // sets value for a select
    set_value: function(key, value){
      this[key] = value;
      this.$emit('update_list', { val :this.selected, name: this.select_name});

      if(key === 'options'){
        this.change_width();
      }
    },

    change_width:function(){
      var vm = this;
      var select = vm.$el.getElementsByClassName( 'select-imitation__dropdown' )[0].getElementsByClassName( 'select-imitation__list' )[0];

      vm.$el.setAttribute("style", "width: auto");

      Vue.nextTick(function() {
        var width = 0;
        var options = select.getElementsByClassName('element');

        for( var option of options){
          width = Math.max(width, option.offsetWidth);
        }

        width += 90;
        width = Math.max(width, select.offsetWidth);

        var _width = (window.outerWidth < 768)? window.outerWidth - 30 : width;
        vm.$el.setAttribute("style", "width:" + (_width) + 'px');
      });
    },

    resert_width: function(){
      var vm = this;
      vm.$el.setAttribute("style", "width: auto");
    },

    // gets value of a select
    get_value: function(){
      return this.selected;
    },

    // gets name of a select
    get_name: function(){
      return this.select_name;
    },
  },
}
animation_mixin = {
  methods:{
   animation_beforeEnter: function (el) {
      el.style.opacity = 0
    },

    animation_enter: function (el, done) {
      const width = getComputedStyle(el).width;

      el.style.width = width;
      el.style.position = 'absolute';
      el.style.visibility = 'hidden';
      el.style.height = 'auto';

      const height = getComputedStyle(el).height;

      el.style.width = null;
      el.style.position = null;
      el.style.visibility = null;
      el.style.height = 0;

      getComputedStyle(el).height;

      var delay = el.dataset.index * 150
      setTimeout(function () {
        Velocity(
          el,
          { opacity: 1, height: height },
          { complete: done }
        )
      }, delay)
    },

    animation_leave: function (el, done) {
      var delay = el.dataset.index * 150
      setTimeout(function () {
        Velocity(
          el,
          { opacity: 0, height: 0 },
          { complete: done }
        )
      }, delay)
    },

    animation_enterAfter: function(el){
      el.style.height = 'auto';

      if(typeof(this.update_scroll)!=='undefined'){
        this.update_scroll();
      }
    },

    animation_leaveAfter: function(el){
      if(typeof(this.update_scroll)!=='undefined'){
        this.update_scroll();
      }
    }
  }
}
var fds_order = {
    watch:{

      visible:function(val){
        if(val){
        }else{
          var vm = this;
          Vue.nextTick(function(){
            vm.do_save = false;
            vm.order_was_changed = false;
            vm.studio_notes_count  = 1;
            vm.enquery_notes_count = 1;
          })
        }
      },

      enquery_note_text:function(){
        var height = this.$refs.note_textarea_enquery.scrollHeight;
        this.$refs.note_textarea_enquery.style.height = height+'px';
      },

      studio_note_text:function(){
        var height = this.$refs.note_textarea_studio.scrollHeight;
        this.$refs.note_textarea_studio.style.height = height+'px';
      },

      do_save: function(do_save){
        if(do_save){
          /**
          * update filter values on order change
          */
          for(var filter_id in this.order_data.filters){
            var _f = this.order_data.filters[filter_id];

            for(var val of _f){
              if(val){
                filters.filter_values[filter_id].push(val);
              }
            }
          }
        }
      },

      'order_data.customer.source': function(val){
        this.order_data.filters.source = [val];
      },

      'order_data.customer.assigned': function(val){
        this.order_data.filters.team = [val, this.order_data.studio.creator];
      },

      'order_data.studio.creator': function(val){
        this.order_data.filters.team = [val, this.order_data.customer.assigned];
      },
    },

    computed:{
      computed_enquery_notes: function(){
        var notes = this.order_data.messages.enquery.filter(el => {
          return el.show == '1';
        });

        if(this.enquery_notes_count <=1){
          notes.sort(function (a, b){
            var date_a = new Date(a._date.replace(/\s/, 'T'));
            var date_b = new Date(a._date.replace(/\s/, 'T'));
            if(date_a == date_b){
              return 0;
            }
            return date_b > date_a ? 1 : -1;
          });
        }

        return notes.splice(0, this.enquery_notes_count);
      },

      computed_enquery_notes_count: function(){
        var shown = this.order_data.messages.enquery.map(el=>{
          return parseInt(el.show);
        });
        return shown.reduce((a, b) => a + b, 0);
      },

      computed_studio_notes: function(){
        var notes = this.order_data.messages.studio.filter(el => {
          return el.show == '1';
        });

       if(this.studio_notes_count <=1){
        notes.sort(function (a, b){
          var date_a = new Date(a._date.replace(/\s/, 'T'));
          var date_b = new Date(a._date.replace(/\s/, 'T'));
          if(date_a == date_b){
            return 0;
          }
          return date_b > date_a ? 1 : -1;
        });

      }

        return notes.splice(0, this.studio_notes_count);
      },

      computed_studio_notes_count: function(){
        var shown = this.order_data.messages.studio.map(el=>{
          return parseInt(el.show);
        });
        return shown.reduce((a, b) => a + b, 0);
      },

      due_date:function(){
        var due_date = {
          value: '',
          days_left: '<span></span>',
        };

        var fmt  = new DateFormatter();
        var date = new Date(this.order_data.due_date.date.replace(/\s/, 'T'));
        var today = new Date();

        due_date.value = fmt.formatDate(date, 'd F Y');

        var difference = date.getTime() - today.getTime();

        difference = Math.ceil(difference / (1000 * 3600 * 24));

        var tag = (difference == 1 || difference == -1)? 'day' : 'days';

        due_date.days_left ='<span class="mark-tag">' + difference + ' '+ tag +'</span>';

        return due_date;
      },

      messages_left: function(){
        return 3 - this.order_data.message_count;
      },

      order_total: function(){
        var total = 0;

        for(var items of this.order_data.order.items){
          total +=parseFloat(items.price)
        }

        for(var items of this.order_data.order.fee){
         if(items.price){
           var price =typeof(items.price) == 'number'? items.price.toString(): items.price;
            total +=parseFloat(price.replace(/[^.|-|\d]/g, ''));
          }
        }

        for(var items in this.order_data.order.addons){
          if(this.order_data.order.addons[items].price){
            var price;

            if('undefined' == typeof(this.order_data.order.addons[items].discount_type) && this.order_data.order.addons[items].discount_type !== 'percent'){

              price = typeof(this.order_data.order.addons[items].price) == 'number'? this.order_data.order.addons[items].price.toString() : this.order_data.order.addons[items].price;

              total += parseFloat(price.replace(/[^-|\d]/g, ''));
           }
          }
        }

        for(var items in this.order_data.order.addons){
          if(this.order_data.order.addons[items].price){
            var price;

            if('undefined' != typeof(this.order_data.order.addons[items].discount_type) && this.order_data.order.addons[items].discount_type == 'percent'){

              price = this.order_data.order.addons[items].price;

              total += total *  (parseFloat(price.replace(/[^-|\d]/g, ''))/100);
            }
          }
        }

        total = total < 0? 0 : total;

        return total.toFixed(2);
      },

      order_sources: function(){
        return order_sources;
      },

      order_statuses: function(){
        return order_statuses;
      },

      order_brands: function(){
        return [];
      },

      order_addons: function(){
        return order_addons;
      },

      phone_left: function(){
        return 3 - this.order_data.phone_count;
      },
    },

    updated: function(){
      if(this.visible){
        this.init_selects();
        this.init_order_status_select();
      }
    },

    created: function(){},

    methods: {
      init_selects: function(){
        var options = {
          isExpanded: '',
          isSelected: [],
          isHiddenSelect: true,
          isHiddenImitation: false,
        };
      },

      init_order_status_select: function(){
      },

      change_order_data_value:  function(key, value){
        clog('change_order_data_value');
        if(this.visible){
          this.order_was_changed = true;
        }
        this.order_data[key] = value;
      },

      /**
      * displays and hides details of every product row
      */
      expand_product: function(key){
        var exp = this.order_data.order.items[key].expanded;
        this.$set(this.order_data.order.items[key], 'expanded', !exp);
      },

      exec_save:function(){
        this.do_save = true;
        this.exec_save_wordpress();
        this.upload_pdf();
      },

      exec_save_vue: function(){
        var item = frontdesk_list.get_item_by('order_id', this.order_data.order_id);
        item.data = this.order_data;
      },

      exec_save_wordpress:function(){
        var data = strip(this.order_data);

        var vm = this;

        this.is_run_saving = true;
        vm.order_was_changed = true;

        jQuery.ajax({
          url: WP_URLS.ajax,
          type: 'POST',
          dataType: 'json',
          data: {action: 'update_order_meta', data: data},
        })
        .always(function(e) {
          clog('update_order_meta');
          clog(e);
          vm.order_was_changed = false;
          vm.is_run_saving = false;
        });

      },

     /**
     * updates order_data
     */
      update_order: function(data, key){
        if(this.visible){
          clog('update_order')
          this.order_was_changed = true;
        }

        if(key != 'core'){
          this.order_data[key][data.name] = data['val'];
        }else{
          this.order_data[data.name] = data['val'];
        }
      },

      /**
      * update reminder value
      *
      * @param - obj {date: standart date, date_formatted: formatted date , is_overdue: boolean}
      */
      update_reminder:function(data){
        if(this.visible){
          clog('update_reminder')
          this.order_was_changed = true;
        }
        if(typeof(this.order_data.reminder) == 'undefined'){
          this.order_data.reminder = {};
        }

        this.order_data.reminder.date = data.value;
        this.order_data.reminder.date_formatted = data.value_formatted;
        this.order_data.reminder.is_overdue = is_boolean(data.overdue);


      },

      /**
      * updates order status
      *
      * @param - obj {val: value, name: select_name}
      */
      update_order_status: function(data){
        var order_status = Object.keys(order_statuses).filter(id => {return order_statuses[id].title == data.val} );
        this.order_data.order_status = order_status[0];

        if(this.visible){
          clog('update_order_status'),
          this.order_was_changed = true;
        }
      },

      /**
      * adds note callback
      */
      add_note: function(type){
        this.order_was_changed = true;
        type = 'undefined' !== typeof(type)? type : 'enquery';

        if(!this.enquery_note_text && type == 'enquery'){
          alert('Please enter some text');
          return false;
        }else  if(!this.studio_note_text && type == 'studio'){
          alert('Please enter some text');
          return false;
        }

        this.requre_save = true;

        var date = new Date();
        var fmt  = new DateFormatter();

        var new_note = {
          'date'       : fmt.formatDate(date, 'M d Y') + ' at ' + fmt.formatDate(date, 'H:i'),
          '_date'      : fmt.formatDate(date, 'Y-m-d H:i:s'),
          'user_name'  : logged_in_user.name,
          'user_id'    : logged_in_user.user_id,
          'is_manager' : 'no',
          'done'       : 'no',
          'show'       : 1,
        };

        if(type == 'enquery'){
          new_note.text =  this.enquery_note_text;
          this.order_data.messages.enquery.push(new_note);
          this.enquery_note_text = '';
          this.$refs.note_textarea_enquery.style.height = '';
        }else if (type =='studio'){
          new_note.text = this.studio_note_text;
          this.order_data.messages.studio.push(new_note);
          this.studio_note_text = '';
          this.$refs.note_textarea_studio.style.height = '';
        }
      },

      /**
      * delete note callback
      */
      delete_note: function(type, text, date){
        if(this.visible){
          this.order_was_changed = true;
        }
        type = 'undefined' !== typeof(type)? type : 'enquery';
        key = this.order_data.messages[type].findIndex(e=>{
          return e.text == text && e.date == date;
        });
        this.order_data.messages[type][key].show = 0;
      },

      update_due_date: function(data){
        if(data.val){
        if(this.visible){
          clog('update_due_date')
          this.order_was_changed = true;
        }
          this.order_data.due_date.date = data.val;
          var _date = new Date(data.val);
          var now = new Date();
          var fmt  = new DateFormatter();
          this.order_data.due_date.date_formatted = fmt.formatDate(_date, 'd M Y');
        }
      },

      shop_popup: function(name){
        switch(name){
          case 'product':
            popup_product.set_prop('visible', true);
            break;
          case 'fee':
            popup_fee.set_prop('visible', true);
            break;
          case 'address':
            popup_address.set_prop('visible', true);
            popup_address.set_prop('new_order', this.new_order);
            break;
          case 'billing_address':
            popup_address_billing.set_prop('visible', true);
            popup_address_billing.set_prop('new_order', this.new_order);
            break;
        }
      },
    },
}
get_set_props = {
  methods: {
    /**
    * update prop
    *
    * @param id - string, name of parameter from data object of this component
    * @param value  - mixed, value to store
    *
    * @return void;
    */
    update_prop: function(id, value){
      this[id] = value;
    },
    /**
    * update prop
    *
    * @param id - string, name of parameter from data object of this component
    * @param value  - mixed, value to store
    *
    * @return void;
    */
    set_prop: function(id, value){
      this[id] = value;
    },

    /**
    * get prop value
    *
    * @param id - string, name of parameter from data object of this component
    *
    * @return mixed - value of propery or 'not found';
    */
    get_prop: function(id){
      return typeof(this[id]) != 'undefined'? this[id] : 'not found';
    },
  },
}
var list_filter_mixin = {
  data:{
    shifts:{},
    show_number: false,
  },

  beforeMount: function(){
    for(var item of this.columns_data){
      this.$set(this.shifts, item.slug, { length: this.items_by_load, count: 0})
    }
  },

  computed:{

    //filters items according to selected filters
    filtered_items: function(){
      var vm = this;

      // show only numbers
      if(this.show_number){
        var items = this.items.filter(item => {
          return item.order_id.toString().indexOf(this.show_number) >= 0;
        });

        return items;
      }

      var items = this.items.filter(item => {
        validated = true;

        var is_overdue = is_boolean(item.data.reminder.is_overdue);

        for(var filter_id in vm.filters){
          var filter_val = vm.filters[filter_id].toLowerCase();

          if(filter_val.indexOf('all') >= 0){
            continue;
          }
          // all array values to lowercase
          var _filters = item.data.filters[filter_id].map(v => v.toLowerCase())

          validated = _filters.indexOf(filter_val) < 0? false : validated;
        }

        // validate by fasttrack
        validated = vm.fasttrack && !item.data.is_fasttrack? false: validated;


        // get comments count
        var comments_count;
        var comments_data = strip(item.data.wfp_images);

        if(typeof(comments_data) == 'object'){
          comments_data = Object.values(comments_data);
        }

        if(!comments_data){
          comments_count =  0;
        }else{
          comments_count = comments_data.filter(e=>{
            return typeof(e.request) != 'undefined' && e.is_active == 0;
          }).map(
          e=>{return e.request.length}
          ).reduce((a, b) => a + b, 0);
        }


        validated = vm.only_with_messages && comments_count == 0 ? false: validated;

        // validate by due date (if has due date);
        validated = vm.due_date_only && !item.data.reminder.date? false: validated;

        validated = vm.due_date_only && vm.overdue_only && !is_overdue? false : validated;

        return validated;
      });

      //calculate overdue number of elements
      var _items = items.filter(function(item){
        var is_overdue = is_boolean(item.data.reminder.is_overdue);
        return typeof(item.data.reminder.is_overdue) !== 'undefined' && is_overdue;
      });

      this._overdue_count = _items.length;

      if(typeof(filters) !== 'undefined'){
        filters.update_prop('overdue_count', _items.length);
      }

      //calculate number of elements that has due date
      var _items = items.filter(function(el){
          return  !!el.data.reminder.date
      });

      this._due_count = _items.length;

      if(typeof(filters) !== 'undefined'){
        filters.update_prop('due_count', _items.length);
      }


      return items;
    },


    /**
    * place items by column.
    * use data.state of each item as column id
    * in woocommerce this will be order status
    */
    items_by_column_all: function(){
      var items = {};

      var vm = this;

      for(var column of this.columns_data){
        var counter = 0;

        items[column.slug] = this.filtered_items.filter( item => {
          var validated = true;
          validated = item.data.order_status != column.slug? false : validated;
          counter++
          return validated;
        })
      }
      return items;
    },

    /**
    * place items by column.
    * use data.state of each item as column id
    * in woocommerce this will be order status
    */
    items_by_column: function(){
      for(var item of this.columns_data){
        this.shifts[item.slug].count = 0;
      }

      var items = {};

      var vm = this;

      for(var column_slug in this.items_by_column_all){
        var counter = 0;

        items[column_slug] = this.items_by_column_all[column_slug].filter( item => {
          var validated = true;

          vm.shifts[column_slug].count++;
          validated = counter > vm.shifts[column_slug].length ? false : validated;
          counter++
          return validated;
        })
      }

      return items;
    },

    // return columns data with items assigned
    columns: function(){
      var data = this.columns_data;
      var items = this.items_by_column;

      // sort items by columns
      for (var column_id in data){
        var column_slug = data[column_id].slug;

        // set items to a column
        data[column_id].items = 'undefined' == typeof(items[column_slug])? [] : items[column_slug];
      }
      return data;
    },
  },

  methods:{
   /**
   * changes length of visible elements in column
   */
    scroll_items: function(data){
      if(data.trigger){
        this.shifts[data.slug].length += this.items_by_load;
      }
    },


    may_be_add_item: function(item){
      var may_be_item = this.get_item_by('order_id', item.order_id);

      if(!may_be_item){
        this.items.push(item);
      }
    },
  }
}
var upload_pdf_mixin = {
  data:{
    file_name: '',
    files : '',
  },

  methods:{
    update_pdf: function(event){
      for(var file of event.target.files){
        this.order_was_changed = true;
        this.file_name = file.name;
        this.files = file;
      }
    },

    upload_pdf:function(){
      var vm = this;
      if(!vm.files){
        clog('no files to upload');
        return;
      }

      if('undefined' !== typeof(this.order_was_changed )){
        this.order_was_changed = true;
      }

      var fd   = new FormData();
      fd.append('pdf', vm.files);
      fd.append('action', 'upload_pdf');
      fd.append('order_id', vm.order_data.order_id);

      jQuery.ajax({
        url: WP_URLS.ajax,
        type: 'POST',
        processData: false,
        contentType: false,
        data: fd,
      })

      .done(function(e) {
        var item = frontdesk_list.get_item_by('order_id', vm.order_data.order_id);
        item.data.product_collection.pdf.push(e.pdf.file_loaded.url);
        vm.order_data.product_collection.pdf.push(e.pdf.file_loaded.url);
      })

      .always(function(e){
        slog('upload pdf', 'blue');
        clog(e);
        elog();
        vm.files = '';
      });
    },
  }
}
var upload_item_mixin = {

  data: function(){
    return {
      is_free: 0,
    };
  },

  watch:{
    _number: function(val){
      this.number =  val < 10? '0'+val: val;
    },

    _item_id: function(val){
      clog('_item_id' + val);
      this.item_id = val;
      this.$emit('file_changed', {files: this.files, number: this.number, item_id:this.item_id, thumbs_file: this.thumbs_file});
    },

    _files_uploaded: function(val){
      if(typeof(val) !== 'undefined'){
        this.thumbnail =   tracker_url[0]+"/assets/images/blank.svg";
        this.thumbs_file = false;
        this.files_uploaded =  val;
      }
    },

    files: function(){
      this.$el.classList.remove('error');
      this.$emit('file_changed', {files: this.files, number: this.number, item_id:this.item_id, thumbs_file: this.thumbs_file});
    },
  },

  computed: {
    files_to_show_ready: function(){
      if(this.show_comments && this.has_comment){
        return [];
      };

      return this.files_uploaded;
    },

    files_to_show:function(){
      if(this.show_comments && this.has_comment){
        return [];
      }

      var files = [];

      var counter = 0;

      for(file_id in this.files){
        var file = this.files[file_id];
        var image_id = file.name + '_' + this.number + '_' + counter;
        image_id = image_id.replace(' ', '');
        var data = {
          name : file.name,
          size : file.size,
          state: 'ready to load',
          image_id : image_id,
        };

        this.files[file_id].image_id = image_id;

        files.push(data);
        counter++;
      }


      return files;
    },

    parsed_comments: function(){
      if(!this.show_comments){
        return [];
      }
      var comments = this.comments.sort(function(a,b){
        var date_a = new Date(a.date);
        var date_b = new Date(b.date);
        return date_b - date_a;
      });

      return comments;
    },

    has_files: function(){
      return this.files.length > 0 || this.files_uploaded.length > 0;
    },

    has_comment: function(){
      return this.comments.length > 0;
    },

    exec_show_comments: function(){
      return this.show_comments && this.has_comment;
    },


    this_state: function(){


      var wfp_data = typeof(this.$parent.order_data.wfp_images) !== 'undefined' && typeof(this.$parent.order_data.wfp_images[this.item_id]) !== 'undefined' ? strip(this.$parent.order_data.wfp_images[this.item_id]) : [];

      wfp_data = (this.$parent.order_data.wfp_image_single)? strip(this.$parent.order_data.wfp_image_single) : wfp_data;

      // slog('item: #' + strip(this.item_id) + ' data', 'red');
      // clog('files_uploaded: ' , 'blue');
      // clog(strip(this.files_uploaded));
      // clog('files: ' , 'blue');
      // clog(strip(this.files));
      // clog('wfp_data: ' , 'blue');
      // clog(wfp_data);
      // elog();

      if(this.files.length == 0 &&  this.files_uploaded.length == 0){
        return 'Upload';
      }

      if(this.files.length > 0){
        return 'Upload';
      }

      if(parseInt(wfp_data.was_downloaded) == 1){
        return 'Downloaded';
      }

      if(parseInt(wfp_data.is_active) == 1){
        return 'Ready';
      }

      if(parseInt(wfp_data.is_active) == 0){
        return 'In Review';
      }

      return '';
    },

    is_downloaded: function(){

      if(typeof(this.$parent.order_data.wfp_images[this.item_id]) == 'undefined'){
        return false;
      }

      if(!this.$parent.order_data.wfp_images[this.item_id]){
        return false;
      }

      var wfp_data = strip(this.$parent.order_data.wfp_images[this.item_id]);

      return wfp_data.was_downloaded == 1;

    },
  },

  methods:{
    toggle_free_paid_cb: function(){
      this.is_free = 1 - this.is_free;
      this.$emit('toggle_free_paid', {'item_id': this.item_id, is_free: this.is_free});
    },


    get_state: function(){
      return this.this_state;
    },

    get_state_slug: function(state){
      state = state.replace(' ', '-');
      return state.toLowerCase();
    },

    /**
    * calculates date and return it in formatted view
    *
    * @param d - string 'Y-m-d H:i:s'
    *
    * @return string
    */
    date: function(d){
      var date = new Date(d);
      var fmt  = new DateFormatter();
      return fmt.formatDate(date, 'M d, H:i');

    },

     delete_image: function(data){
      if(this.is_old_order){
        alert('this order can be edited only in WordPress dashboard');
        return;
      }
      var file_id = this.files.findIndex(e=>{
      return e.image_id == data.image_id})
      this.files.splice(file_id, 1);
    },

    delete_image_loaded: function(data){
      if(this.is_old_order){
        alert('this order can be edited only in WordPress dashboard');
        return;
      }

      if(this.is_downloaded){
        alert("You can't delete downloaded image");
        return;
      }

      var file_id = this.files_uploaded.findIndex(e=>{
        return e.path == data.dropbox_path
      });

      slog('delete exist item');

      clog(file_id);
      clog(data);

      this.files_uploaded.splice(file_id, 1);
      this.$emit('delete_path_update', data);

      elog();
    },


    /**
    * handles drop image in drag-n-drop area
    *
    * @param e - event
    */
    handledrop: function(e){
      let dt = e.dataTransfer;
      let files = dt.files;
      var items = dt.items;

      for(var file of files){
        if(file.type != 'image/jpeg' && file.type != "image/png"){
          continue;
        }

        this.files.push(file);
      }
    },

    /**
    * adds highlight style for drag area
    */
    highlight: function(e) {
      this.$refs.drop_area.classList.add('highlight')
    },

    init_drop_area: function(){
      var dropArea = this.$refs.drop_area;

      if(this.is_old_order){
        return;
      }

      if(this.is_downloaded){
        return;
      }

      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, this.prevent_defaults, false)
      });

      ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, this.highlight, false)
      })

      ;['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, this.unhighlight, false)
      })

      dropArea.addEventListener('drop', this.handledrop, false);
    },

    prevent_defaults: function(e) {
      e.preventDefault()
      e.stopPropagation()
    },

    /**
    * shows preview of a passed file
    *
    * @param file - file
    *
    * @return void;
    */
    preview_file: function(file) {
      let reader = new FileReader()
      reader.readAsDataURL(file)
      var vm = this;
      reader.onloadend = function() {
        let img = document.createElement('img')
        img.src = reader.result
        vm.$emit('show_image',{img: img});
      }

    },

    show_image: function(data){
      var image = this.files.filter(
        e => {
          return e.image_id === data.image_id
        });

      this.preview_file(image[0]);
    },

    show_image_loaded: function(data){

      if(data.image_url){
        var img = "<img src='"+data.image_url+"'>"
        this.$emit('show_image',{img: img});
        return;
      }

      var data = JSON.stringify({
        "path": data.dropbox_path
      });

      var xhr = new XMLHttpRequest();

      xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
          slog('show_image_loaded', 'blue')
          clog(JSON.parse(this.responseText));
          elog();
        }
      });

      xhr.open("POST", "https://api.dropboxapi.com/2/files/get_temporary_link", false);
      xhr.setRequestHeader("authorization", "Bearer "+ dropbox.token);
      xhr.setRequestHeader("content-type", "application/json");
      xhr.setRequestHeader("cache-control", "no-cache");
      xhr.send(data);

      var response = JSON.parse(xhr.responseText);
      var img = "<img src='"+response.link+"'>"
      this.$emit('show_image',{img: img});
    },

    upload_from_input: function(event){
      for(var file of event.target.files){
        if(file.type != 'image/jpeg' && file.type != "image/png"){
          continue;
        }else{
          this.files.push(file);
        }
      }
    },

    unhighlight: function(e) {
      this.$refs.drop_area.classList.remove('highlight')
    },
  },
};
var column_mixin = {
    data: function () {
    return {
      name : '',
      slug : '',
      count : '',
      items : [],
      moved_item_id: -1,
      trigger_scroll : false,
    }
  },

  props:['_items', '_info', '_count'],

  watch:{
    _items: function(val){
      this.items = this._items;
    },

    _count: function(){
      this.count = this._count;
    },
  },

  computed:{
    items_formatted:function(){
      var items = this.items
      for(var id in items){
        items[id].data.order_status = this.slug;
      }

      return items;
    }
  },

  beforeMount: function(){
    this.name  = this._info.name;
    this.slug  = this._info.slug;
    this.items = this._items;
    this.count = this._count;
  },

  mounted: function(){
    var header = this.$el.getElementsByClassName('order-column__tag')[0];
    header.style.backgroundColor = this._info.bg_color;
    header.style.color           = this._info.text_color;
  },

  methods: {

    /**
    *  update items element
    */
    update_items: function(items){
      this.items = items;
    },

    return_column_slug: function(){
    },

    end_drag: function(evt,data){
      this.$emit('update_order_status_on_drag', {order_id: this.moved_item_id});
      this.moved_item_id = -1;
    },

    /**
    * stores move order id
    */
    checkMove: function(item){
      this.moved_item_id = item.draggedContext.element.order_id;
    },

    /**
    * emits open order data to a parent component
    */
    open_order_col_cb: function(data){
      this.$emit('open_order_col_cb', data);
    },

    /**
    * replaces default scroll of column.
    * scrolls column by 1 elemnt hieght
    */
    scroll_items: function(slug){
      event.preventDefault()

      if( !this.trigger_scroll ){
        this.$refs.scroll.scrollTop  = (event.deltaY > 0)? this.$refs.scroll.scrollTop + 76 : this.$refs.scroll.scrollTop - 76;
      }
    },

    /**
    * emits scroll if end of scroll content reached
    */
    scroll_items_emit:function(slug){
      this.trigger_scroll = this.$refs.scroll.offsetHeight + this.$refs.scroll.scrollTop >= this.$refs.scroll.scrollHeight - this.$refs.scroll.scrollHeight  * 0.05;

      var vm = this;

      this.$emit('trigger_scroll',{slug: slug, trigger: vm.trigger_scroll });
      var vm = this;

      Vue.nextTick(function(){
        vm.trigger_scroll = false;
      })
    },
  },
}
var upload_item_thumb = {
  data: function(){
    return{
      thumbnail       : tracker_url[0]+"/assets/images/blank.svg",
      thumbs_file     : false,
      thumbs_image_id : -1,
    }
  },

  watch:{
    thumbs_file: function(val){
      if(!val){
        return;
      }

      let reader = new FileReader()
      reader.readAsDataURL(val)

      var vm = this;
      reader.onloadend = function() {
        vm.thumbnail = reader.result;
      }
    },
  },


  methods:{
    upload_from_input_thumb: function(event){
      this.$refs.thumb.classList.remove('error');
      var files = [];
      for(var file of event.target.files){
        if(file.type != 'image/jpeg' && file.type != "image/png"){
          // alert('wrong file type, only png or jpeg allowed');
          continue;
        }
        files.push(file);
      }

      let reader = new FileReader()
      reader.readAsDataURL(files[0])

      var vm = this;
      reader.onloadend = function() {
        vm.thumbnail = reader.result;
      }

      this.thumbs_file = files[0];

      this.$emit('change_thumbnail', {item_id: this.item_id})
    },
  }
};
var get_item = {
  methods: {
    /**
    * gets item data by provided value
    *
    * @param key - string - key inside searching item object
    * @param value - mixed - the value to be searched by
    *
    * @return item object
    */
    get_item_by: function(key, value){
      var item = this.items.filter(obj => {
        return obj.data[key] === value
      });

      return item[0];
    },

    /**
    * gets index of item among this.items
    *
    * @param key - string - key inside searching item object
    * @param value - mixed - the value to be searched by
    *
    * @return item index, integer
    */
    get_index_of_item_by: function(key, value){
      return this.items.map(function(e) { return e[key]; }).indexOf(value);
    },
  }
};
var frontdesk_list,
    frontdesk_order,
    frontdesk_order_new,
    filters,
    popup_product,
    available_products,
    popup_fee,
    popup_address,
    studio_app,
    list_filter_mixin,
    popup_address_billing,
    search_field,
    popup_studio_errors,
    get_set_props,
    popup_shoot
;

/***********************

***********************/

var months_short = [
  'Jan',
  'Feb',
  'Mar',
  'Apr',
  'May',
  'Jun',
  'Jul',
  'Aug',
  'Sep',
  'Oct',
  'Nov',
  'Dec',
];

var icons_selects = {
  'clinics': '<svg class="icon svg-icon-clinics"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-clinics"></use> </svg>',

  'treatments': '<svg class="icon svg-icon-tooth"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-tooth"></use> </svg>',

  'campaign': '<svg class="icon svg-icon-campaign"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-campaign"></use> </svg>',

  'source': '<svg class="icon svg-icon-sourses"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-sourses"></use> </svg>',

  'team': '<svg class="icon svg-icon-team"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-team"></use> </svg>',

  'dentists': '<svg class="icon svg-icon-team"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-team"></use> </svg>',

  'human': '<svg class="icon svg-icon-human"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-human"></use> </svg>',

  'card': '<svg class="icon svg-icon-card"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-card"></use> </svg>',

  'currency': '<span class="currency-in-select">£</span>',

  'sortby': '<span class="icon-sortby"> <svg xmlns:dc="http://purl.org/dc/elements/1.1/"xmlns:cc="http://creativecommons.org/ns#"xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"xmlns:svg="http://www.w3.org/2000/svg"xmlns="http://www.w3.org/2000/svg"xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"width="105.73048mm"height="60.448288mm"viewBox="0 0 374.63554 214.18685"id="svg2"version="1.1"inkscape:version="0.91 r13725"sodipodi:docname="desc.svg"> <defs id="defs4" /> <sodipodi:namedview id="base"pagecolor="#ffffff"bordercolor="#666666"borderopacity="1.0"inkscape:pageopacity="0.0"inkscape:pageshadow="2"inkscape:zoom="0.35"inkscape:cx="533.25919"inkscape:cy="533.92856"inkscape:document-units="px"inkscape:current-layer="layer1"showgrid="false"fit-margin-top="0"fit-margin-left="0"fit-margin-right="0"fit-margin-bottom="0"inkscape:window-width="1920"inkscape:window-height="976"inkscape:window-x="-8"inkscape:window-y="1072"inkscape:window-maximized="1" /> <metadata id="metadata7"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g inkscape:label="Layer 1"inkscape:groupmode="layer"id="layer1"transform="translate(672.54491,-854.96105)"> <path style="fill:#838993"d="m -553.75621,1065.0846 c -7.99146,-7.3236 -6.87414,-19.1169 2.34368,-24.7373 3.83487,-2.3383 6.73931,-2.4401 69.62681,-2.4401 63.62166,0 65.75131,0.077 69.76273,2.5227 8.72665,5.3205 9.74037,16.9649 2.13868,24.5666 l -4.15141,4.1514 -67.64336,0 -67.64335,0 -4.43378,-4.0633 z"id="path4155"inkscape:connector-curvature="0" /> <path style="fill:#838993"d="m -599.26031,978.37748 c -4.88353,-2.6376 -7.56658,-8.71232 -7.05942,-15.98332 0.24135,-3.46003 1.21848,-7.06332 2.33486,-8.61003 4.51521,-6.25572 0.74969,-6.06481 119.62458,-6.06481 105.75005,0 111.35628,0.11175 114.63782,2.28409 3.74051,2.47623 7.15104,9.03755 7.15104,13.7575 0,4.43576 -2.86871,11.02393 -5.91003,13.57271 -2.55732,2.14316 -8.54166,2.275 -115.10261,2.53566 -94.99093,0.23238 -112.91182,10e-4 -115.67624,-1.4918 z"id="path4151"inkscape:connector-curvature="0" /> <path style="fill:#838993"d="m -665.69569,883.60895 c -7.01294,-5.51638 -8.83062,-13.77749 -4.56921,-20.76644 5.15136,-8.4485 -8.3984,-7.87319 185.42869,-7.87319 l 175.50221,0 4.24736,2.85325 c 4.99679,3.3567 8.22065,11.0967 6.86752,16.48795 -0.49088,1.95589 -2.77187,5.4355 -5.06884,7.73248 l -4.17633,4.17632 -177.45643,0 -177.45642,0 -3.31855,-2.61037 z"id="path4147"inkscape:connector-curvature="0" /> </g> </svg> </span>',
};

var blank_order = {order_id:      '',
    data: {
      order_id:      '',
      name:          '',
      address_billing: '',
      existing_customer: 0,

      customer: {
        'date_added': '',
        'phone'     : '',
        'email'     : '',
        'source'    : 'Site',
        'brand'     : '',
        'campaign'  : '',
        'assigned'  : '',
        'iser_id'   : -1,
      },

      messages: {
        enquery: [],
        studio:[],
      },

      reminder: {},

      gallery: {
        comments: 0,
        items: [],
      },

      order:{
        currency_symbol: '£',
        date           : '',
        items: [],
        fee:[],
        addons:{
          turnaround : {
            'title': 'Turnaround',
            'name'   : '',
            'price'  : 0,
          },

          handling:  {
            'title': 'Handling',
            'name'   : '',
            'price'  : 0,
          },

          sendvia:  {
            'title': 'Send Via',
            'name'   : '',
            'price'  : 0,
          },

          discount:  {
            'title': 'Discount',
            'name'   : '',
            'discount_type'   : '',
            'price'  : 0,
            'coupon_id'  : -1,
          },
        },
      },

      location: {
        unit: '',
        comment: '',
        box: '',
      },

      studio:{
        creator: '',
      },

      product_collection:{
        do_collect: false,
        address: '',
        requested:'',
        scheduled:'',
        pdf: [],
      },

      due_date:      {
        date: '',
        date_formatted: '',
        is_overdue: 0,
      },

      is_fasttrack:  '',
      message_count: 0,
      phone_count:   0,
      stage:         '0',
      state:         '',

      filters: {
        campaigns: [],
        sources:   [],
        team:      [],
      },
  } };
Vue.component('frontdesk-item', {
  data: function () {
    return {
      info:  ''
    }
  },

  props:['_info'],

  mounted:function(){
    clog(this.info);
  },

  computed: {
    is_fasttrack: function(){
      return this.info.is_fasttrack;
    },

    due_date: function(){
      return  this.info.due_date.date_formatted;
    },

    is_overdue: function(){
      return  is_boolean(this.info.reminder.is_overdue);
    },

    _stage: function(){
      var days = this.info.is_fasttrack ? parseInt(tracker_options.turnaround.fasttrack) : parseInt(tracker_options.turnaround.regular);

      var multiplier = days / 5;

      var due_date    = new Date(this.info.due_date.date.replace(/\s/, 'T'));
      var today       = new Date();
      var diff = days - Math.floor((due_date.getTime() - today.getTime() )/ (1000*60*60*24));

      diff = diff > days ? days : diff;
      diff = diff/multiplier;
      diff = diff <= 0 ? 1 : diff;
      diff = diff > 5? 5 : diff;

      return Math.floor(diff);
    },
  },

  watch:{
    '_info': function(val){
      this.info = this._info;
    },
  },

  beforeMount: function(){
    this.info = this._info;
  },

  mounted: function(){
    var test = this._stage;
  },

  methods: {
    open_order: function(order_id){
      var vm = this;
      this.$emit('open_order_el_cb',{order_id: order_id});
    }
  },

  template: `<div class="order-preview" :title="info.name" v-on:click="open_order(info.order_id)">
  <div class="row no-gutters">
    <div class="col-6">
      <span class="order-preview__name">{{info.name}}</span>
      <svg class="icon svg-icon-fastrack" v-if="is_fasttrack"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-fastrack"></use> </svg>
    </div>
    <div class="col-6 text-right">
      <svg class="icon svg-icon-bell" v-bind:class="{'green': !is_overdue }" v-if="info.reminder.date"><use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-bell"></use> </svg>

      <i class="icon-with-popup blue">
      <svg class="icon svg-icon-phone" v-bind:class="{'blue': info.phone_count > 0}"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-phone"></use> </svg>
        <span class="counter" v-if="info.phone_count > 0">{{info.phone_count}}</span>
      </i>

      <i class="icon-with-popup green">
      <svg class="icon svg-icon-email" v-bind:class="{'green': info.message_count > 0}" > <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-email"></use> </svg>
       <span class="counter" v-if="info.message_count > 0">{{info.message_count}}</span>
      </i>

      <span class="order-preview__number">#{{info.order_id}}</span>
    </div>
  </div><!-- row -->
  <div class="spacer-h-10"></div>

  <div class="row">
    <span class="col-6 order-preview__due-date">
       <svg class="icon svg-icon-due"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-due"></use> </svg>
       {{due_date}}
    </span>
    <div class="col-6" v-bind:class="'stage'+_stage">
      <div class="order-preview__progress">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div><!-- row -->
</div><!-- order-preview" -->`,
})
Vue.component('frontdesk-column', {
  mixins: [column_mixin],

  template: `
    <div class="order-column" v-on:mouseup="return_column_slug()">
      <div class="order-column__header">
        <span class="order-column__tag">{{name}}</span>
        <span class="order-column__count">{{count}}</span>
      </div>
      <div class="order-column__body"
        ref="scroll"
        @wheel="scroll_items(slug)"
        @scroll="scroll_items_emit(slug)"
        >
          <draggable v-bind:class="'scroll'" ref="scroll-inner" :move="checkMove" :list="items_formatted" group="slug" @end="end_drag"         >
              <frontdesk-item
                v-for="item in items_formatted"
                v-bind:_info="item.data"
                v-bind:key="item.data.order_id"
                v-on:open_order_el_cb="open_order_col_cb">
                </frontdesk-item>
          </draggable>
      </div>
    </div>`,
})
Vue.component('studio-item', {
  data: function () {
    return {
      info:  this._info
    }
  },

  props:['_info'],

  computed: {
    is_fasttrack: function(){
      return this.info.is_fasttrack;
    },

    due_date: function(){
      return  this.info.due_date.date_formatted;
    },

    is_overdue: function(){
       return  this.info.reminder.is_overdue;
    },

    comments_count: function(){
      if(!this.info.wfp_images){
        return 0;
      }
      var wfp_images = Object.values(strip(this.info.wfp_images));

      // if(typeof(wfp_images) == 'array'){
        var count = wfp_images.filter(e=>{
          return typeof(e.request) != 'undefined' &&  e.is_active == 0;
        }).map(
        e=>{return e.request.length}
        ).reduce((a, b) => a + b, 0);

        return count;
      // }
      // return 0;
    },

    _stage: function(){
      var days = this.info.is_fasttrack ? parseInt(tracker_options.turnaround.fasttrack) : parseInt(tracker_options.turnaround.regular);

      var multiplier = days / 5;

      var due_date    = new Date(this.info.due_date.date.replace(/\s/, 'T'));
      var today       = new Date();
      var diff = days - Math.floor((due_date.getTime() - today.getTime() )/ (1000*60*60*24));

      diff = diff > days ? days : diff;
      diff = diff/multiplier;
      diff = diff <= 0 ? 1 : diff;
      diff = diff > 5? 5 : diff;

      return Math.floor(diff);
    },
  },

  mounted: function(){
  },

  methods: {
    open_order: function(order_id){
      var vm = this;
      this.$emit('open_order_el_cb',{order_id: order_id});
    }
  },

  template: `<div class="order-preview" :title="info.name" v-on:click="open_order(info.order_id)">
  <div class="row no-gutters">
    <div class="col-6">
      <span class="order-preview__name">{{info.name}}</span>
      <svg class="icon svg-icon-fastrack" v-if="is_fasttrack"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-fastrack"></use> </svg>
    </div>
    <div class="col-6 text-right">
      <svg class="icon svg-icon-bell" v-bind:class="{'green': !is_overdue}" v-if="info.reminder.date"><use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-bell"></use> </svg>

      <i class="icon-with-popup" v-if="comments_count > 0">
      <svg class="icon svg-icon-comment"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-comment"></use> </svg>
        <span class="counter" v-if="info.gallery.comments > 0">{{info.gallery.comments}}</span>
      </i>

      <span class="order-preview__number">#{{info.order_id}}</span>

    </div>
  </div><!-- row -->
  <div class="spacer-h-10"></div>

  <div class="row">
    <span class="col-6 order-preview__due-date">
       <svg class="icon svg-icon-due"> <use xmlns:xlink="ttp://www.w3.org/1999/xlink" xlink:href="#svg-icon-due"></use> </svg>
       {{due_date}}
    </span>
     <div class="col-6" v-bind:class="'stage'+_stage">
      <div class="order-preview__progress">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div><!-- row -->
</div><!-- order-preview" -->`,
})
Vue.component('studio-column', {
  mixins: [column_mixin],

  template: `<div class="order-column" v-on:mouseup="return_column_slug()"> <div class="order-column__header"> <span class="order-column__tag">{{name}}</span> <span class="order-column__count">{{count}}</span> </div>
    <div class="order-column__body"
      ref="scroll"
      @wheel="scroll_items(slug)"
      @scroll="scroll_items_emit(slug)"
    >
  <draggable
   :move="checkMove"
   :list="items_formatted"
   group="slug"
   @end="end_drag">
   <studio-item v-for="item in items_formatted" v-bind:_info="item.data"  v-bind:key="'studio_item_'+item.data.order_id" v-on:open_order_el_cb="open_order_col_cb"></studio-item></draggable>  </div> </div>`,
})
Vue.component('single-studio-content', {
  data: function(){
    return {
      visible: false,
      item_index: -1,
      order_data: {},
      studio_note_text:  '',
      studio_notes_count:  1,
      show_popup_preview: false,
      files_to_load :{},
      thumbs_to_load :false,
      files_prepared:{},
      do_submit: false,
      state_changed : false,
      delete_paths: [],
    };
  },

  computed:{
    computed_studio_notes: function(){
      var notes = this.order_data.messages.studio.filter(el => {
        return el.show == '1';
      });

      if(this.studio_notes_count <= 1){
        notes.sort(function (a, b){
          var date_a = new Date(a._date.replace(/\s/, 'T'));
          var date_b = new Date(a._date.replace(/\s/, 'T'));
          if(date_a == date_b){
            return 0;
          }
          return date_b > date_a ? 1 : -1;
        });
      }

      return notes.splice(0, this.studio_notes_count);
    },


    computed_studio_notes_count: function(){
      var shown = this.order_data.messages.studio.map(el=>{
        return parseInt(el.show);
      });
      return shown.reduce((a, b) => a + b, 0);
    },


    turnaround: function(){
      data = this.order_data.order.addons.filter(e=>{
        return e.title == 'Turnaround';
      });
      return  'undefined' !== typeof(data[0])? data[0].name: 'Not defined';
    },


    /**
    * return data about current order status
    * uses parameter order_data.state as index
    * global variable studio_columns_data stores all data
    *
    * @return object {status, color}
    */
    column_data: function(){
      var vm = this;
      var data = Object.values(studio_columns_data)
                       .filter(e => {
                          return e.slug == vm.order_data.order_status;
                        })
                       .map(e=>{
                        return {status: e.name, color: e.text_color };
                       });

      if(data.length == 0){
        return {status: 'Undefined', color: '#eee' };
      }
      return data[0];
    },


    /**
    * return formatted date when photos should be ready
    *
    * @return string
    */
    due_date: function(){

      if('undefined' == typeof(this.order_data.due_date.date) || !this.order_data.due_date.date){
        return '-';
      }

      var date = new Date(this.order_data.due_date.date.replace(/\s/, 'T'));
      var fmt  = new DateFormatter();
      return fmt.formatDate(date, 'D d M');
    },

    /**
    * numbers of days left to complete photos
    *
    * @return integer
    */
    number_of_dates_left:function(){
      if('undefined' == typeof(this.order_data.due_date.date) || !this.order_data.due_date.date){
        return false;
      }

      var today = new Date();
      var due_date = new Date(this.order_data.due_date.date.replace(/\s/, 'T'));
      var diffTime = due_date - today;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      var last_num = diffDays.toString().slice(-1);


      return {
        diff : diffDays,
        label: last_num != 1 ? 'days' : 'day',
        };
    },

    /**
    * Total number of photos
    *
    * @return integer or '-' if no or 0 photos
    */
    number_of_photos: function(){
      var already_set = 0;

      var already_set_images = this.order_data.wfp_images;

      if(already_set_images){
        switch(typeof(this.order_data.wfp_images)){
          case 'object':
            already_set = Object.values(this.order_data.wfp_images).length
            break;
          case 'array':
            already_set = this.order_data.wfp_images.length
            break;
        }
      }

      return Math.max(this.number_of_photos_bought, already_set);
    },

    number_of_photos_bought: function(){
      var items = this.order_data.order.items;

      var count = Object.values(items).map(e => {return parseInt(e.image_count)});

      return count.reduce((a, b) => a + b, 0);
    },

    /**
    * Total number of comments to photos
    *
    * @return integer or '-' if no or 0 comments
    */
    number_of_comments: function(){
      if(!this.order_data.wfp_images){
        return 0;
      }

      var wfp_images = Object.values( strip(this.order_data.wfp_images) );

      return wfp_images.filter(e=>{
        return 'undefined' != typeof(e.request);
      }).map(e=>{
        return e.request.length;
      }).reduce((a, b) => a + b, 0);
    },

    /**
    * gets all uploaded files from order meta
    */
    files_uploaded: function(){
      var files = [];
      for(var i = 0; i < this.order_data.wfp_images.length; i++){
        files.push([]);
      }

      if(this.order_data.wfp_images){
        for(image_id in this.order_data.wfp_images){
          var image = this.order_data.wfp_images[image_id];
          /**
          * check if an array of images is set
          */
          if(typeof(image.files_uploaded) == 'undefined' && !is_boolean(image.archive_url) && image.archive_url){
            var file = {
                          name: typeof(image.name) != 'undefined'? image.name : 'Old version image',
                          size: typeof(image.size) != 'undefined'? image.size : '',
                          request: typeof(image.request)       != 'undefined'? image.request : '',
                          path: typeof(image.dropbox_path)     != 'undefined'? image.dropbox_path : '',
                          image_url: typeof(image.archive_url) != 'undefined'? image.archive_url.replace('?dl-1', '?dl-0') : '',
                          archive_url: typeof(image.archive_url) != 'undefined'? image.archive_url.replace('?dl-1', '?dl-0') : '',
                        };
            if('undefined' == typeof(files[image_id])){
              files[image_id] = [];
            }

            files[image_id].push(file);
          }else if(typeof(image.files_uploaded) == 'undefined'){
            file = [];
          }else{
            file = [];
            if(typeof(image.files_uploaded) === 'object'){
              var images = Object.values(image.files_uploaded);
            }else{
              var images = image.files_uploaded;
            }

            for(var image of images){
              var file = {
                      name: typeof(image.name) != 'undefined'? image.name : 'Old version image',
                      size: typeof(image.size) != 'undefined'? image.size : '',
                      path: typeof(image.path) != 'undefined'? image.path : '',
                      image_url: typeof(image.image_url) != 'undefined'? image.image_url : '',
                      request  : typeof(image.request)   != 'undefined'? image.request : '',
                    };
              if(image.image_url || image.path){
               if('undefined' == typeof(files[image_id])){
                  files[image_id] = [];
               }
               files[image_id].push(file);
              }
            }
          }
        }
      }

      files = files.filter(e=>{ return e.length > 0});
      return files;
    },


    /**
    * gets all prepared for upload files
    */
    watch_files_prepared: function(){
      if(this.is_old_order){
        return [];
      }
      if(this.wfp_image_single){
        return [];
      }
      var files_to_load =  this.files_prepared;
      var values = Object.values(files_to_load);
      return values;
    },

    /**
    * gets number of next upload item
    * used for blank item id
    */
    blank_item_id:function(){
      return this.watch_files_prepared.length + this.files_uploaded.length
    },


    /**
    * detects if order was created before feedsauce hub
    */
    is_old_order: function(){
      if('undefined' == typeof(this.order_data.wfp_images)){
        return false;
      }

      if(!this.order_data.wfp_images){
        return false;
      }

      var wfp_images = Object.values(this.order_data.wfp_images).filter(e=>{
        return 'undefined' != typeof(e.archive_url);
      });

      return wfp_images.length > 0;
    },


    /**
    * detect if is a single image order
    */
    is_single_order:function(){
      return !!this.order_data.wfp_image_single;
    },

    /**
    * return single order files
    */
    single_order_files: function(){
      if(!this.order_data.wfp_image_single){
        return [];
      }

      if('undefined' !== typeof(this.order_data.wfp_image_single.files_uploaded)){

        return this.order_data.wfp_image_single.files_uploaded.filter(e=>{
          return !!e.image_url;
        })
      }

      if('undefined' !== typeof(this.order_data.wfp_image_single.archive_url)){
        return this.order_data.wfp_image_single.archive_url;
      }
      return [];
    },

    shoot_started: function(){
      var shoot_started = this.order_data.order_status == tracker_options['orders_misc']['shoot'] || this.order_data.shoot_started;

      return shoot_started;
    },

    show_start_shoot_btn: function(){
      var shoot_started = this.shoot_started;
      return !this.is_old_order && !this.is_single_order && !shoot_started;
    },

    show_submit_button: function(){
      var shoot_started = this.shoot_started;
      return !this.is_old_order && !this.is_single_order && shoot_started;
    },

    files_to_load_exist: function(){
      var files_to_load = this.files_to_load;
      var thumbs_to_load = this.thumbs_to_load;
      var state_changed = this.state_changed;

      files_to_load = Object.values(this.files_to_load).filter(e=>{ return e.length > 0;});
      return files_to_load.length > 0 || thumbs_to_load || state_changed;
    }
  },

  watch: {
    visible: function(val){
        var vm = this;
      if(!val){
        Vue.nextTick(function(){
          vm.show_popup_preview = false;
          vm.do_submit = false;
          vm.studio_notes_count  = 1;
          vm.thumbs_to_load  = false;
          vm.state_changed  = false;
          vm.files_to_load   = {};
          vm.files_prepared  = {};
        })
      }else{
        Vue.nextTick(function(){
          vm.update_thumbs();
        })
      }
    },

    studio_note_text:function(){
      var height = this.$refs.note_textarea_studio.scrollHeight;
      this.$refs.note_textarea_studio.style.height = height+'px';
    },
  },

  mounted: function(){
    this.update_thumbs();
  },

  mixins: [get_set_props, animation_mixin],

  methods:{
    add_note: function(type){
      type = 'undefined' !== typeof(type)? type : 'enquery';

      if(!this.enquery_note_text && type == 'enquery'){
        alert('Please enter some text');
        return false;
      }else  if(!this.studio_note_text && type == 'studio'){
        alert('Please enter some text');
        return false;
      }

      this.requre_save = true;

      var date = new Date();
      var fmt  = new DateFormatter();

      var new_note = {
        'date'       : fmt.formatDate(date, 'M d Y') + ' at ' + fmt.formatDate(date, 'H:i'),
        '_date'      : fmt.formatDate(date, 'Y-m-d H:i:s'),
        'user_name'  : logged_in_user.name,
        'user_id'    : logged_in_user.user_id,
        'is_manager' : 'no',
        'done'       : 'no',
        'show'       : 1,
      };

      new_note.text = this.studio_note_text;
      this.order_data.messages.studio.push(new_note);
      this.studio_note_text = '';
      this.$refs.note_textarea_studio.style.height = '';
      this.save_notes();
    },

    update_thumbs: function(){
      var data = [];

      if('undefined'!== typeof(this.order_data.wfp_thumbnails)){
        data = strip(this.order_data.wfp_thumbnails);
      }

      var children = (this.$children).filter(e => {
        return e.constructor.options.name == 'upload-item-exists' || e.constructor.options.name == 'upload-item'});

      for( var child of children){
        var item_id = child.item_id;

        if('undefined' !== typeof(data[item_id])){
          child.thumbnail       = data[item_id].attachment_url;
          child.thumbs_image_id = data[item_id].attachment_id;
          child.thumbs_file = false;
        }else{
          child.thumbs_file = false;
          child.thumbnail       =  tracker_url[0]+"/assets/images/blank.svg";
          child.thumbs_image_id =  -1;
        }
      }
    },

    get_index_prepared: function(id){
      return this.files_uploaded.length + id;
    },


    /**
    * hides this component
    * displays list and filters
    */
    back_to_list: function(){
      var vm = this;
      this.files_prepared = {};
      this.files_to_load = {};
      var data = JSON.parse(JSON.stringify(vm.order_data));

      vm.$emit('update_data', {order_data: data, index: vm.item_index});

      Vue.nextTick(function(){
        vm.$parent.visible.columns = true
        vm.$parent.visible.filters = true
        vm.visible = false;
      })

    },

    change_thumbnail: function(){
      this.thumbs_to_load = true;
    },

    /**
    * delete note callback
    */
    delete_note: function(type, text, date){
      type = 'undefined' !== typeof(type)? type : 'enquery';
      key = this.order_data.messages[type].findIndex(e=>{
        return e.text == text && e.date == date;
      });
      this.order_data.messages[type][key].show = 0;

      this.save_notes();
    },

    /**
    * displays and hides details of every product row
    */
    expand_product: function(key){
      var exp = this.order_data.order.items[key].expanded;
      this.$set(this.order_data.order.items[key], 'expanded', !exp);
    },

    show_shoot_popup:function(){
      popup_shoot.visible  = true;
      popup_shoot.due_date = this.order_data.due_date.date_formatted;
      popup_shoot.number_of_dates_left = this.number_of_dates_left;
    },

    exec_start_shoot: function(){
      block();
      var vm = this;

      if( studio_app.filter_values.team.indexOf(logged_in_user.name) < 0){
        studio_app.filter_values.team.push(logged_in_user.name);
      }

      var item = vm.$parent.get_item_by('order_id',  vm.order_data.order_id);
      item.data.studio.creator = logged_in_user.name;
      item.data.studio.creator = logged_in_user.name;
      item.data.filters.team.push(logged_in_user.name);
      vm.order_data.studio.creator = logged_in_user.name;
      vm.order_data.filters.team.push(logged_in_user.name);

      Vue.nextTick(function(){
        jQuery.ajax({
          url: WP_URLS.ajax,
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'update_start_shoot',
            order_id:  vm.order_data.order_id,
            logged_in_user:  logged_in_user,
          },
        })
       .done(function(e){
          vm.order_data.shoot_started = 1;
          vm.order_data.order_status  = tracker_options['orders_misc']['shoot'];

          var item = vm.$parent.get_item_by('order_id',  vm.order_data.order_id);

          item.data.order_status = tracker_options['orders_misc']['shoot'];
          item.data.shoot_started = 1;
        })
        .fail(function(e) {
          if('undefined' !== typeof(e.responseJSON.data)){
            alert(e.responseJSON.data)
          }else{
            alert('Something gone wrong')
          }
        })
        .always(function(e) {
          unblock();
        });
      });
    },

    do_upload: function(){

      if(!this.files_to_load_exist){
        return;
      }

      var valid = this.exec_validate();

      if(!valid){
        return;
      }

      popup_quality.visible = true;
    },

    exec_upload: function(){
      var vm = this;
      vm.order_data.order_status = tracker_options.orders_misc.uploaded;

      popup_quality.visible = false;
      this.do_submit = true;
      var folder_name = 'order_' + this.order_data.order_id;

      for(var folder in this.files_to_load){
        for(var file of this.files_to_load[folder]){
          var path = folder_name +"/"+folder +"/"+file.name
          this.upload_file(path, file, folder);
        }
      }

      if(Object.values(this.files_to_load).length == 0){
        this.collect_thumbs();

        if(this.state_changed){
          this.update_wfp_meta();
        }
      }

      this.exec_delete_paths();
    },

    /**
    * gets comments for current image from all comments
    */
    get_comments_for_image: function(id){
      if('undefined' !== typeof(this.order_data.wfp_images[id]) && 'undefined' !== typeof(this.order_data.wfp_images[id].request)){
        var wfp_images = Object.values( strip(this.order_data.wfp_images));
        var comments = wfp_images[id].request;
      }else{
        return [];
      }

      var result = 0;

      try{
        var result = comments.map(
          e => {
            return {
              author: this.order_data.name,
              date: e.date,
              text: e.text,
            };
          }
        );
      }catch(e){

      }

      return result;
    },

    save_notes : function(){
      console.log(this.order_data.messages.studio);

      jQuery.ajax({
        url: WP_URLS.ajax,
        type: 'POST',
        dataType: 'JSON',
        data: {
          action     : 'save_notes',
          order_id   : this.order_data.order_id,
          notes      : this.order_data.messages.studio,
          notes_type : 'studio',
        },
      })

      .done(function() {
        console.log();
      })
      .fail(function() {
        console.log();
      })
      .always(function(e) {
        console.log(e);
      });
    },

    show_image_popup: function(data){
      jQuery('.image-preview-popup__inner').removeAttr('style');
      jQuery('.image-preview-popup__inner').removeClass('loaded');
      jQuery('.image-preview-popup__inner').find('img').remove();
      jQuery('.image-preview-popup__inner').append(data.img);
      this.show_popup_preview = true;

      jQuery('.image-preview-popup__inner').find('img').on('load', function(){
       jQuery('.image-preview-popup__inner').addClass('loaded');
        var width = jQuery('.image-preview-popup__inner').find('img').width();
        var height = jQuery('.image-preview-popup__inner').find('img').height();

        jQuery('.image-preview-popup__inner').width(width);
        jQuery('.image-preview-popup__inner').height(height);
      });

      Vue.nextTick(function(){
      });
    },

    show_image_loaded: function(dropbox_path){
      var data = JSON.stringify({
        "path": dropbox_path
      });

      var xhr = new XMLHttpRequest();

      xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
          slog('show_image_loaded', 'blue')
          clog(JSON.parse(this.responseText));
          elog();
        }
      });

      xhr.open("POST", "https://api.dropboxapi.com/2/files/get_temporary_link", false);
      xhr.setRequestHeader("authorization", "Bearer "+ dropbox.token);
      xhr.setRequestHeader("content-type", "application/json");
      xhr.setRequestHeader("cache-control", "no-cache");
      xhr.send(data);

      var response = JSON.parse(xhr.responseText);
      return response.link;
    },

    update_files: function(data){
      slog('update_files', 'green')
      this.$set(this.files_to_load, data.item_id, data.files);

      var count = 0;

      for(var i in this.files_to_load){
        count += this.files_to_load[i].length;
      }

      clog(' this.do_submit: ' +  this.do_submit);

      if(count === 0 && this.do_submit){
        var vm = this;
        Vue.nextTick(function(){
          vm.collect_thumbs();
          vm.update_wfp_meta();
        })
      }
      elog();
    },

    update_files_blank: function(data){
      this.$set(this.files_to_load, data.item_id, data.files);
      this.$set(this.files_prepared, data.item_id, data.files);
    },

    upload_file: function(path, file,folder_id){
      var parent = this.$children.filter(
        e => {
          return typeof(e.item_id) !== 'undefined' && e.item_id == parseInt(folder_id);
        }
      );

      var item = parent[0].$children.filter(
        e => {
          return e.image_id == file.image_id;
        }
      );

      item = item[0];

      var data = JSON.stringify({
        "path": "/duh/" + path,
        "mode": "add",
        "autorename": true,
        "mute": false,
        "strict_conflict": false
      });

      var xhr = new XMLHttpRequest();
      var vm = this;

      xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {

          clog('file was loaded', 'green');
          var data = JSON.parse(this.responseText);

          parent[0].files_uploaded.push({
            name: data.name,
            size: data.size,
            path: data.path_display,
          });

          Vue.nextTick(function(){
            var parent = vm.$children.filter(
              e => {
                return e.item_id == parseInt(folder_id);
              }
            );

            var item = parent[0].$children.filter(
              e => {
                return e.image_id == file.image_id;
              }
            );

            item = item[0];
            item.delete_image();
          })
        }
      });

      xhr.open("POST", "https://content.dropboxapi.com/2/files/upload");
      xhr.setRequestHeader("authorization", "Bearer "+ dropbox.token);
      xhr.setRequestHeader("Dropbox-API-Arg", data);
      xhr.setRequestHeader("content-type", "application/octet-stream");

      xhr.upload.onprogress = function(event) {
        var progress = parseInt((parseInt(event.loaded) / parseInt(event.total) )* 100);
        item.show_progress(progress);
      };

      xhr.send(file);
    },

    validate: function(){
      valid = true;
      errors = [];

      /**
      * validate thumbs
      */
      var thumbs = this.get_thumbs();
      var thumbs_parsed = thumbs.filter(e=>{ return e.thumbs_image_id > 0 || !!e.thumbs_file});

      if(thumbs.length !== thumbs_parsed.length){
        errors.push('You need to set up all thumbnails');
        valid = false;
      }

      // validate by items uploaded
      var childs_no_images = this.get_upload_childs().filter(e=> {
        var _return =  e.files.length == 0 && e.files_uploaded.length == 0;

        if(_return){
          e.$el.classList.add('error');
        }else{
          e.$el.classList.remove('error');
        }

        return _return;
      });

      if(childs_no_images.length > 0){
        valid = false;
        errors.push('Every image container should have fotos uploaded');
      }
      //validate review

      var childs_in_review = this.get_upload_childs().filter(e=>{
        var state = e.get_state();
        var error =  state == 'In Review' && e.files.length == 0;
        if(error){
          e.$el.classList.add('error');
        }else{
          e.$el.classList.remove('error');
        }
        return error;
      });

      if(childs_in_review.length > 0){
        valid = false;
        errors.push('You must update all images in Review');
      }

      // validate by items count
       var files_prepared = this.watch_files_prepared.filter(e => {return e.length > 0})

       valid = this.number_of_photos >  files_prepared.length + this.files_uploaded.length ? false : valid;

      return {
        valid: valid,
        errors: errors,
      }
    },

    exec_validate: function(){
      var validate = this.validate();

      if(!validate.valid){
        unblock();
        var files_prepared = this.watch_files_prepared.filter(e => {return e.length > 0})
        popup_studio_errors.errors = validate.errors;
        popup_studio_errors.visible = true;
        popup_studio_errors.images_to_show = this.number_of_photos;
        popup_studio_errors.images_uploaded = files_prepared.length + this.files_uploaded.length;
      }

      return validate.valid;
    },

    get_upload_childs: function(){
      var childs = (this.$children).filter(e => {
        return e.constructor.options.name == 'upload-item-exists' || e.constructor.options.name == 'upload-item'}).filter(e=>{
          if(!e.thumbs_file && e.thumbs_image_id < 0){
            e.$refs.thumb.classList.add('error');
          }else{
            e.$refs.thumb.classList.remove('error');
          }
          return e});

        return childs;
    },

    get_thumbs: function(){
      var vm = this;
      var child = this.get_upload_childs();

       var images = child.map(e=>{


        return {
                  'item_id'         :  e.item_id,
                  'thumbs_image_id' :  e.thumbs_image_id,
                  'thumbs_file'     :  e.thumbs_file,
                }
      });

      return images;
    },

    collect_thumbs: function(){

      if(!this.thumbs_to_load){
        return;
      }

      block();
      var vm = this;
      var childs = (this.$children).filter(e => {return e.constructor.options.name == 'upload-item-exists' || e.constructor.options.name == 'upload-item'}).filter(e=>{ return e.thumbs_file});

      var fd   = new FormData();
      var images = childs.map(e=>{

        if('undefined' !== typeof(fd)){
          fd.append('thumb_'+e.item_id, e.thumbs_file);
        }

        return JSON.stringify({
                  'item_id'         : e.item_id,
                  'thumbs_image_id' : e.thumbs_image_id,
                  'thumbs_file'     :  e.thumbs_file,
                })
      });

      fd.append('action', 'add_thumbnails');
      fd.append('order_id', this.order_data.order_id);


      jQuery.ajax({
        url: WP_URLS.ajax,
        type: 'POST',
        processData: false,
        contentType: false,
        data: fd,
      })

      .done(function(e){
        if('undefined' != typeof(e.meta)){
          vm.order_data.wfp_thumbnails = e.meta;
          vm.update_thumbs();
        }
      })

      .always(function(e){
        console.log(e);
        vm.thumbs_to_load = false;
        unblock();
      });
    },

    update_wfp_meta: function(){
      slog('update_wfp_meta', 'green');
      var vm = this;

      block();
      var meta = vm.get_upload_childs().filter(el=>{
        console.log(el.files_uploaded);
        return 'undefined' !== typeof(el.files_uploaded);
      }).map(el => {

        var file_uploaded = el.files_uploaded.map(e=>{
          var url;
          if('undefined' !== e.archive_url && e.archive_url){
            url = e.archive_url;
          }else if(e.path){
            url = '';
          }

          return {
            name: e.name,
            size: e.size,
            path: e.path,
            image_url: url,
          };
        });

        var was_downloaded = 'undefined' != typeof(vm.order_data.wfp_images[el.item_id])? vm.order_data.wfp_images[el.item_id].was_downloaded : 0;

        var meta = {
          id              :  el.item_id,
          files_uploaded  :  file_uploaded,
          request         :  el.comments,
          was_downloaded  : 'undefined' !== typeof(was_downloaded) ?  was_downloaded : 0,
          is_active       : 1,
          is_free         : is_boolean(el.is_free)? 1 : 0,
        };

        return meta;
      })

      clog(meta);
      elog();

      jQuery.ajax({
        url: WP_URLS.ajax,
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'update_order_images',
          order_id: this.order_data.order_id,
          meta: meta,
          limit: this.number_of_photos_bought,
        },
      })
      .done(function(e) {
        vm.files_to_load  = {};
        vm.files_prepared = {},
        vm.order_data.wfp_images     = e.meta;
      })

      .fail(function() {
      })

      .always(function(e) {
        unblock();
        vm.do_submit = false;
        vm.state_changed = false;
        vm.update_thumbs();
        slog('update_wfp_meta reuslt', 'green')
        clog(e);
        elog();
      });
    },

    get_item_visibility: function(id){
      var file          = this.watch_files_prepared[id];
      var files_uploaded = this.files_uploaded[this.get_index_prepared(id)];


      return ('undefined' != typeof(file) && file.length > 0) || ('undefined' != typeof(files_uploaded) && files_uploaded.length > 0);
    },


    delete_path_update: function(data){
      this.delete_paths.push(data.dropbox_path);
    },

    exec_delete_paths:function(){
      for(var path of this.delete_paths){
        var data = JSON.stringify({
          "path": path
        });

        var xhr = new XMLHttpRequest();

        xhr.addEventListener("readystatechange", function () {
          if (this.readyState === 4) {
            console.log(JSON.parse(this.responseText));
          }
        });

        xhr.open("POST", "https://api.dropboxapi.com/2/files/delete_v2");
        xhr.setRequestHeader("authorization", "Bearer " + dropbox.token);
        xhr.setRequestHeader("content-type", "application/json");
        xhr.setRequestHeader("cache-control", "no-cache");

        xhr.send(data);
      }
    },

    toggle_free_paid_cb: function(data){
      this.state_changed = true;
    }
  },

  template: '#studio-single-content',
});
Vue.component('upload-item', {
  data: function(){
    return {
      number         : '',
      item_id             : '',
      state          : this._state,
      comments       : [],
      files          : [],
      files_uploaded : [],
      show_comments  : false,
      is_single_order  : false,
    };
  },

  mixins: [upload_item_mixin, upload_item_thumb],

  props : [
    '_item_id',
    '_number',
    '_state',
    '_comments',
    '_files_uploaded',
    '_files',
    '_is_single_order',
  ],

  beforeMount: function(){
    this.number =  this._number < 10? '0' + this._number : this._number;
    this.comments = this._comments? this._comments : [];
    this.files_uploaded = typeof(this._files_uploaded) !== 'undefined' ?this._files_uploaded : this.files_uploaded  ;
    this.files = this._files;
    this.item_id = this._item_id;
    this.is_single_order = this._is_single_order;

    var item = this.$parent.order_data.wfp_images[this.item_id];
    this.is_free = 'undefined' != typeof(item) && item.is_free == 1;
  },

  mounted: function(){
    this.init_drop_area();
    var vm = this;


    /*
    * add event listener that will hide view comments state
    */
    this.$el.addEventListener('dragenter', function(){
      vm.show_comments = false;
      Vue.nextTick(function(){
        vm.highlight();
      });
    }, false);
  },

  watch :  {},

  methods: {},

  template: `
    <div class="upload-item" v-bind:class="{'has-files' : has_files}">
      <div class="upload-item__header">
        <div class="upload-item__state">
          <span class="number">{{number}} </span>
          <span class="state" v-bind:class="get_state_slug(this_state)">{{this_state}} </span>
        </div>
        <div class="col"></div>

        <label class="upload-item__thumb" ref="thumb">
          <img :src="thumbnail">
          <input type="file" v-on:change="upload_from_input_thumb">
        </label>

        <div class="upload-item__comments "
          v-bind:class="{cup: has_comment , active: exec_show_comments}"
          v-on:click="show_comments = !show_comments"
          >
          <svg class="icon svg-icon-comment" v-bind:class="{red: has_comment}"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-comment"></use> </svg>
          <span class="count">{{comments.length}}</span>
        </div>
      </div><!-- upload-item__header -->

      <div class="upload-item__body">
        <div class="upload-item__drop-area" v-show=" !exec_show_comments && !is_downloaded" ref="drop_area">
          <div class="download-cta">
            <img src="`+tracker_url[0]+`assets/images/load.png"  class="multiple-image" alt="">
            <img src="`+tracker_url[0]+`assets/images/load_blank.png" class="single-image" alt="">
            <span class="download-cta__text">
              <b>Drop your images here</b>
              or
              <input type="file" multiple :id="'fileupload'+number" v-on:change="upload_from_input">

              <label class="marked" :for="'fileupload'+number">
                browse
              </label>
            </span>
          </div>
        </div>

        <upload-item-image
          v-for="(file, file_id) in files_to_show"
          :key="'upload'+file_id"
          :_name = 'file.name'
          :_size = 'file.size'
          :_state = 'file.state'
          :_image_id = 'file.image_id'
          v-on:show_image_trigger = "show_image"
          v-on:delete_image_trigger = "delete_image"
        >
        </upload-item-image>

        <ready-item-image
          v-for="(file, _file_id) in files_to_show_ready"
          :key="'ready'+_file_id"
          :_name = 'file.name'
          :_size = 'file.size'
          :_dropbox_path = 'file.path'
          :_image_url    = 'file.image_url'
          v-on:show_image_loaded_trigger = 'show_image_loaded'
          v-on:delete_image_loaded_trigger = 'delete_image_loaded'
          >
        </ready-item-image>

        <div class="upload-item__scroll">
          <div class="upload-item__feedback"
            v-for="(comment, id) in parsed_comments"
            :key = "id"
           >
            <div class="title">
               <b>{{comment.author}}</b> · {{date(comment.date)}}
            </div>
            <p>
              {{comment.text}}
            </p>
            <div class="spacer-h-20"></div>
          </div>
        </div>
      </div>

      <div class="upload-item__footer">
        <div class="paid-free"
          v-bind:class="{active: is_free}"
          v-if="!is_single_order"
          v-on:click="toggle_free_paid_cb">
          <span class="paid">Paid</span>
          <span class="free">Free</span>
          <span class="paid-free__marker"></span>
        </div>
      </div>
    </div><!-- upload-item -->
  `,
});
Vue.component('upload-item-exists', {
  data: function(){
    return {
      number         : '',
      is_old_order   : '',
      is_single_order : '',
      item_id        : '',
      state          : this._state,
      comments       : [],
      files          : [],
      files_uploaded : [],
      show_comments  : false,
    };
  },

  props : [
    '_item_id',
    '_number',
    '_state',
    '_comments',
    '_files_uploaded',
    '_files',
    '_is_old_order',
    '_is_single_order',
  ],

  mixins: [upload_item_mixin, upload_item_thumb],

  beforeMount: function(){
    this.number =  this._number < 10? '0' + this._number : this._number;
    this.comments = this._comments? this._comments : [];
    this.files_uploaded = typeof(this._files_uploaded) !== 'undefined' ?this._files_uploaded : this.files_uploaded  ;
    this.item_id = this._item_id;
    this.is_old_order = this._is_old_order;
    this.is_single_order = this._is_single_order;
    var item = this.$parent.order_data.wfp_images[this.item_id];
    this.is_free = 'undefined' != typeof(item.is_free) && item.is_free == 1;
  },

  mounted: function(){
    this.init_drop_area();
    var vm = this;

    /*
    * add event listener that will hide view comments state
    */
    this.$el.addEventListener('dragenter', function(){
      vm.show_comments = false;
      Vue.nextTick(function(){
        vm.highlight();
      });
    }, false);
  },

  watch :  {
    _is_old_order: function(val){
      this.is_old_order = val;
    },

    _is_single_order: function(val){
      this.is_single_order = val;
    },
  },

  methods: {
    delete_in_dropbox:function(path){
      var data = JSON.stringify({
        "path": path
      });

      var xhr = new XMLHttpRequest();

      xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
          console.log(JSON.parse(this.responseText));
        }
      });

      xhr.open("POST", "https://api.dropboxapi.com/2/files/delete_v2");
      xhr.setRequestHeader("authorization", "Bearer " + dropbox.token);
      xhr.setRequestHeader("content-type", "application/json");
      xhr.setRequestHeader("cache-control", "no-cache");

      xhr.send(data);
    },
  },

  template: `
    <div class="upload-item" v-bind:class="{'has-files' : has_files}">
      <div class="upload-item__header">
        <div class="upload-item__state">
          <span class="number">{{number}} </span>
          <span class="state" v-bind:class="get_state_slug(this_state)">{{this_state}} </span>
        </div>
        <div class="col"></div>

        <label class="upload-item__thumb" ref="thumb" v-if="!is_old_order">
          <img :src="thumbnail">
          <input type="file" v-on:change="upload_from_input_thumb">
        </label>

        <div class="upload-item__comments "
          v-bind:class="{cup: has_comment , active: exec_show_comments}"
          v-on:click="show_comments = !show_comments"
          >
          <svg class="icon svg-icon-comment" v-bind:class="{red: has_comment}"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-comment"></use> </svg>
          <span class="count">{{comments.length}}</span>
        </div>
      </div><!-- upload-item__header -->

      <div class="upload-item__body">
        <div class="upload-item__drop-area" v-show=" !exec_show_comments && !is_old_order && !is_downloaded" ref="drop_area">
          <div class="download-cta">
            <img src="`+tracker_url[0]+`/assets/images/load.png"  class="multiple-image" alt="">
            <img src="`+tracker_url[0]+`/assets/images/load_blank.png" class="single-image" alt="">
            <span class="download-cta__text">
              <b>Drop your images here</b>
              or
              <input type="file" multiple :id="'fileupload'+number" v-on:change="upload_from_input">

              <label class="marked" :for="'fileupload'+number">
                browse
              </label>
            </span>
          </div>
        </div>

        <upload-item-image
          v-for="(file, file_id) in files_to_show"
          :key="'upload'+file_id"
          :_name = 'file.name'
          :_size = 'file.size'
          :_state = 'file.state'
          :_image_id = 'file.image_id'
          v-on:show_image_trigger = "show_image"
          v-on:delete_image_trigger = "delete_image"
        >
        </upload-item-image>

        <ready-item-image
          v-for="(file, _file_id) in files_to_show_ready"
          :key="'ready'+_file_id"
          :_name = 'file.name'
          :_size = 'file.size'
          :_dropbox_path = 'file.path'
          :_image_url    = 'file.image_url'
          v-on:show_image_loaded_trigger = 'show_image_loaded'
          v-on:delete_image_loaded_trigger = 'delete_image_loaded'
          >
        </ready-item-image>

        <div class="upload-item__scroll">
          <div class="upload-item__feedback"
            v-for="(comment, id) in parsed_comments"
            :key = "id"
           >
            <div class="title">
               <b>{{comment.author}}</b> · {{date(comment.date)}}
            </div>
            <p>
              {{comment.text}}
            </p>
            <div class="spacer-h-20"></div>
          </div>
        </div>
      </div>
      <div class="upload-item__footer">
        <div class="paid-free"
        v-bind:class="{active: is_free}"
        v-on:click="toggle_free_paid_cb"
        v-if="!is_single_order"
        >
          <span class="paid">Paid</span>
          <span class="free">Free</span>
          <span class="paid-free__marker"></span>
        </div>
      </div>
    </div><!-- upload-item -->
  `,
});
Vue.component('upload-item-blank', {
  data: function(){
    return {
      blank_number         : '',
      blank_item_id        :  '',
    };
  },

  props : [
    '_blank_item_id',
    '_blank_number',
  ],

  computed:{
    this_state: function(){
      return 'Add New';
    },
  },

  beforeMount: function(){
    this.blank_number =  this._blank_number < 10? '0' + this._blank_number : this._blank_number;
    this.blank_item_id = this._blank_item_id;
  },

  mounted: function(){
    this.init_drop_area();
    var vm = this;

    /*
    * add event listener that will hide view comments state
    */
    this.$el.addEventListener('dragenter', function(){
      Vue.nextTick(function(){
        vm.highlight();
      });
    }, false);
  },

  watch :  {
    _blank_number: function(val){
      this.blank_number =  val < 10? '0'+val: val;
    },

    _blank_item_id: function(val){
      this.blank_item_id = val;
    },
  },

  methods: {

    /**
    * calculates date and return it in formatted view
    *
    * @param d - string 'Y-m-d H:i:s'
    *
    * @return string
    */
    date: function(d){
      var date = new Date(d);
      var fmt  = new DateFormatter();
      return fmt.formatDate(date, 'M d, H:i');

    },

    /**
    * handles drop image in drag-n-drop area
    *
    * @param e - event
    */
    handledrop: function(e){
      let dt = e.dataTransfer;
      let files = dt.files;
      var items = dt.items;

      var files_temp = [];

      for(var file of files){
        if(file.type != 'image/jpeg' && file.type != "image/png"){
          continue;
        }
        files_temp.push(file);
      }

      this.$emit('file_changed_blank', {files: files_temp, number: this.blank_number, item_id:this.blank_item_id});
    },

    /**
    * adds highlight style for drag area
    */
    highlight: function(e) {
      this.$refs.drop_area_blank.classList.add('highlight')
    },

    init_drop_area: function(){
      var dropArea = this.$refs.drop_area_blank;

      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, this.prevent_defaults, false)
      });

      ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, this.highlight, false)
      })

      ;['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, this.unhighlight, false)
      })

      dropArea.addEventListener('drop', this.handledrop, false);
    },

    prevent_defaults: function(e) {
      e.preventDefault()
      e.stopPropagation()
    },

    upload_from_input: function(event){
      var files_temp = [];
      for(var file of event.target.files){
        if(file.type != 'image/jpeg' && file.type != "image/png"){
          continue;
        }else{
          files_temp.push(file);
        }
      }

      if(files_temp.length > 0){
        this.$emit('file_changed_blank', {files: files_temp, number: this.blank_number, item_id:this.blank_item_id});
      }

    },

    unhighlight: function(e) {
      this.$refs.drop_area_blank.classList.remove('highlight')
    },
  },

  template: `
    <div class="upload-item upload-item_blank">
      <div class="upload-item__header">
        <div class="upload-item__state">
          <span class="number">{{blank_number}} </span>
          <span class="state upload">{{this_state}} </span>
        </div>
        <div class="upload-item__comments ">
          <svg class="icon svg-icon-comment"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-comment"></use> </svg>
          <span class="count">-</span>
        </div>
      </div><!-- upload-item__header -->

      <div class="upload-item__body">
        <div class="upload-item__drop-area" ref="drop_area_blank">
          <div class="download-cta">
            <img src="`+tracker_url[0]+`/assets/images/load.png"  class="single-image-2" alt="">
             <span class="download-cta__text">
              <b>Drop your images here</b>
              or
              <input type="file" multiple :id="'fileupload'+blank_number" v-on:change="upload_from_input">

              <label class="marked" :for="'fileupload'+blank_number">
                browse
              </label>
            </span>
          </div>
        </div>
      </div>
    </div><!-- upload-item -->
  `,
});
Vue.component('upload-item-image', {
  data: function(){
    return {
      name: this._name,
      size: this._size,
      image_id: this._image_id,
      image_url: this._image_url,
      state: this._state,
    };
  },

  watch:{
    _name: function(val){
      this.name = val;
    },

    _size: function(val){
      this.size = val;
    },

    _image_id: function(val){
      this.image_id = val;
    },

    _image_url: function(val){
      this.image_url = val;
    },

    _state: function(val){
      this.state = val;
    },
  },

  computed: {
    image_size: function(){
      var size = this.size;

      if (size < 1024){
        return size + ' B';
      }else if(size < 1048576 ){
        return (size/1024).toFixed(2) + ' KB';
      } else if( size < 1048576*1024 ){
        return (size/(1024 * 1024)).toFixed(2) + ' MB';
      }
    },
  },

  props:['_name', '_size', '_image_id', '_image_url', '_state', ],

  methods:{

    delete_image:function(){
      this.$emit('delete_image_trigger', {image_id: this.image_id});
    },

    show_image: function(){
      this.$emit('show_image_trigger', {image_id: this.image_id});
    },


    show_progress: function(val){
      this.$refs.progress.style = "width:" + val +"%";
    },

  },

  template: `
    <div class="upload-item__image">
      <div class="upload-item__image-progress" ref="progress"></div>
      <div class="upload-item__image-data row">
        <div class="col-7">
          <span class="upload-item__image-title">{{name}}</span>
          <span class="upload-item__image-size">{{image_size}}</span>
        </div>
        <div class="col-5 valign-center text-right">
          <svg class="icon svg-icon-eye"
            v-on:click="show_image"
          > <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-eye"></use> </svg>

          <svg class="icon svg-icon-can"
            v-on:click="delete_image"
          > <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-can"></use> </svg>
        </div>
      </div><!-- upload-item__image-data  -->
    </div><!-- upload-item__image -->
  `,
});
Vue.component('ready-item-image', {
  data: function(){
    return {
      name: this._name,
      size: this._size,
      dropbox_path: this._dropbox_path,
      image_url: this._image_url,
      image_id: this._image_id,
    };
  },

  watch:{
    _name: function(val){
      this.name = val;
    },

    _size: function(val){
      this.size = val;
    },

    _image_id: function(val){
      this.image_id = val;
    },

    _image_url: function(val){
      this.image_url = val;
    },

    _dropbox_path: function(val){
      this.dropbox_path = val;
    },
  },

  computed: {
    image_size: function(){
      var size = this.size;

      if (size < 1024){
        return size + ' B';
      }else if(size < 1048576 ){
        return (size/1024).toFixed(2) + ' KB';
      } else if( size < 1048576*1024 ){
        return (size/(1024 * 1024)).toFixed(2) + ' MB';
      }
    },
  },

  props:['_name', '_size', '_image_id', '_image_url', '_dropbox_path', ],

  methods:{

    delete_image:function(){
      this.$emit('delete_image_loaded_trigger', {dropbox_path: this.dropbox_path});
    },

    show_image: function(){
      this.$emit('show_image_loaded_trigger', {dropbox_path: this.dropbox_path, image_url: this.image_url});
    },


    show_progress: function(val){
      this.$refs.progress.style = "width:" + val +"%";
    },

  },

  template: `
    <div class="upload-item__image">
      <div class="upload-item__image-progress" ref="progress" style="width:100%"></div>
      <div class="upload-item__image-data row">
        <div class="col-7">
          <span class="upload-item__image-title">{{name}}</span>
          <span class="upload-item__image-size">{{image_size}}</span>
        </div>
        <div class="col-5 valign-center text-right">
          <svg class="icon svg-icon-eye"
            v-on:click="show_image"
          > <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-eye"></use> </svg>

          <svg class="icon svg-icon-can"
            v-on:click="delete_image"
          > <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-can"></use> </svg>
        </div>
      </div><!-- upload-item__image-data  -->
    </div><!-- upload-item__image -->
  `,
});
select_imitation = Vue.component('select-imitation', {

  mixins: [select_mixin],

  template: '<div class="select-imitation" v-click-outside="discard_select"  v-bind:class="{ expanded: isExpanded}" > <select v-model="selected" v-on:change="change" v-bind:class="{ hidden: isHiddenSelect}"> <option v-for="data in options" v-bind:value="data">{{data}}</option> </select> <span class="select-imitation__view " v-on:click="expand_select"  v-bind:class="{ hidden: isHiddenImitation}">{{selected}}</span> <span class="select-imitation__arrow" onclick="imitate_select_expand(this)"></span> <div class="select-imitation__dropdown"> <ul class="select-imitation__list"> <li v-for="data in options" v-bind:class="{selected: isSelected[data]}"  v-on:click="imitate_select_option(data)"> <span  class="element">{{data}}</span> </li> </ul> </div> </div>',
})
Vue.component('select-imitation-obj', {

  props:{
    _options: Object,
  },

  computed:{
    is_selected: function(){
      if('undefined' != typeof(this.options[this.selected]) ){
        return this.options[this.selected].name;
      }else{
        return '';
      }
    },
  },

  methods:{
    change: function(){
      this.$emit('update_list', {val: this.options[this.selected], name: this.select_name});
    },


    update_selected_option: function(){
      for(var id in this.options){
        this.isSelected[id] = false;
      }

      this.isSelected[this.selected] = true;
    },
  },

  mixins: [select_mixin],

  template: '<div class="select-imitation" v-click-outside="discard_select"  v-bind:class="{ expanded: isExpanded}" > <select v-model="selected" v-on:change="change" v-bind:class="{ hidden: isHiddenSelect}"> <option v-for="(data, key) in options" v-bind:value="key">{{data.name}}</option> </select> <span class="select-imitation__view " v-on:click="expand_select"  v-bind:class="{ hidden: isHiddenImitation}">{{is_selected}}</span> <span class="select-imitation__arrow" onclick="imitate_select_expand(this)"></span> <div class="select-imitation__dropdown"> <ul class="select-imitation__list"> <li v-for="(data, key) in options" v-bind:class="{selected: isSelected[data]}"  v-on:click="imitate_select_option(key)"> <span  class="element">{{data.name}}</span> </li> </ul> </div> </div>',
})
select_imitation_icon = Vue.component('select-imitation-icon', {
  mixins: [select_mixin],

  data: function () {
    return {
      icon : this._icon,
    }
  },

  props:{
    _icon: String,
  },

  template: '<div class="select-imitation has-icon select-imitation_shift-bottom"  v-click-outside="discard_select" v-bind:class="{ expanded: isExpanded}" > <span v-html="icon"></span> <select v-model="selected" v-on:change="change" v-bind:class="{ hidden: isHiddenSelect}"> <option v-for="data in options" v-bind:value="data">{{data}}</option> </select> <span class="select-imitation__view " v-on:click="expand_select"  v-bind:class="{ hidden: isHiddenImitation}">{{selected}}</span> <span class="select-imitation__arrow" onclick="imitate_select_expand(this)"></span> <div class="select-imitation__dropdown"> <ul class="select-imitation__list"> <li class="select-imitation__item" v-for="data in options" v-bind:class="{selected: isSelected[data]}"  v-on:click="imitate_select_option(data)"> <span class="element">{{data}}</span> </li> </ul> </div> </div>',
})
Vue.component('order-status-select', {
  mixins: [select_mixin],

  data: function () {
    return {
      color : '#eee',
    }
  },

  props: {
    _options: Object,
    '_current_status' : String
  },

  watch: {
    _current_status: function(val){
      this.selected = order_statuses[val].title;
      this.color    = order_statuses[val].color;
    }
  },

  beforeMount: function(){
    this.selected = ('undefined' != typeof(this._current_status) && this._current_status)?order_statuses[this._current_status].title : '';
    this.color = ('undefined' != typeof(this._current_status) && this._current_status)?order_statuses[this._current_status].color : '';
  },

  mounted: function(){
    this.change_width();
  },

  methods:{
    imitate_select: function(title, color){
      this.selected = title;
      this.color    = color;
      this.isExpanded = '';
      this.update_selected_option();
      this.change();
    }
  },

  template: '<div class="select-imitation has-icon"  v-click-outside="discard_select" v-bind:class="{ expanded: isExpanded}" > <span class="marker-select" v-bind:style="{backgroundColor: color}"></span> <select v-model="selected" v-on:change="change" v-bind:class="{ hidden: isHiddenSelect}"> <option v-for="(data, key) in options" v-bind:value="key">{{data.title}}</option> </select> <span class="select-imitation__view " v-on:click="expand_select"  v-bind:class="{ hidden: isHiddenImitation}">{{selected}}</span> <span class="select-imitation__arrow" onclick="imitate_select_expand(this)"></span> <div class="select-imitation__dropdown"> <ul class="select-imitation__list"> <li class="select-imitation__item with-marker" v-for="(data, key) in options" v-bind:class="{selected: isSelected[data.title]}"  v-on:click="imitate_select(data.title, data.color)"> <span class="marker" v-bind:style="{backgroundColor: data.color}"></span> <span class="element">{{data.title}}</span> </li> </ul> </div> </div>',
})
Vue.component('user-select', {
  data: function () {
    return {
      names: '',
      current_user: '',
      gravatar: '',
      user_names: [],
      editing: false,
      all_creators: all_creators,
      all_users: all_users,
    }
  },

  props:['_current_user', '_select_name'],

  beforeMount: function(){

    var vm = this;
    vm.current_user = vm._current_user;
    vm.gravatar = this.get_gravatar();

    switch(this._select_name){
      case 'creator':
        for( var user of this.all_creators){
          this.user_names.push(user.name);
        }
        break;
      default:
        for( var user of this.all_users){
          this.user_names.push(user.name);
        }
        break;
    }
  },

  change:function(){
    var vm = this;
    vm.current_user = vm._current_user;
    vm.gravatar = this.get_gravatar();
  },

  watch: {
    current_user: function(val){
      this.$emit('user_select_change',{name: this._select_name,val: val});
    }
  },

  computed: {
    is_editing: function(){
      return this.editing || !this.current_user;
    }
  },

  directives: {
    'click-outside': {
      bind (el,binding, vnode) {
        const outsideClickEventHandler = event => {
          if(!el.contains(event.target) && el !== event.target){
            binding.value(event);
          }
        }

        el.__outsideClickEventHandler__ = outsideClickEventHandler;
        document.addEventListener("click", outsideClickEventHandler);
      },

      unbind(el) {
        document.removeEventListener("click", el.__outsideClickEventHandler__);
      },
    }
  },

  methods:{
    get_gravatar: function(){
      var vm = this

      if( vm._current_user){

        switch(this._select_name){
          case 'creator':
          var user_data = vm.all_creators.filter(
            obj => {
              return obj.name === vm.current_user ;
            }
          );

          return typeof(user_data[0]) != 'undefined'? user_data[0].gravatar : '';

          default:
            var user_data = vm.all_users.filter(
              obj => {
                return obj.name === vm.current_user ;
              }
            );
            return typeof(user_data[0]) != 'undefined'? user_data[0].gravatar : '';
            break;
        }
      }

      return false;
    },

    collapse: function(){
      this.editing = false;
    },

    expand: function(){
      this.editing = true;
    },

    update_user_data: function(data){
      this.current_user = data.val;
      this.gravatar = this.get_gravatar();
      this.editing = false;
    },
  },

  template: `<div class="edit-team text-left" v-click-outside="collapse">
     <table class="team-leads"  v-on:click.stop="expand" v-if="!is_editing"><tbody><tr><td><div class="team-leads__photo"><img v-bind:src="gravatar"  v-if="gravatar" :alt="current_user"></div></td> <td colspan="3"><div class="clearfix"><span class="team-leads__name">{{current_user}}</span></div></td></tr></tbody></table>

    <select-imitation
      v-if="is_editing"
      v-bind:class="'fullwidth'"
      _select_name="user_select"
      v-bind:_options="user_names"
      v-bind:_selected="current_user"
      v-on:update_list = "update_user_data"
      ref="select"
      ></select-imitation>
  </div>`,
});

datepicker_field = Vue.component('datepicker', {
  data: function () {
    return {
      name:  '',
      value : '',
    }
  },

  props:['_value', '_name'],


  beforeMount: function(){
    this.name = this._name ? this._name : 'datetimepicker';
    this.value = this._value ? this._value : '';
  },

  mounted: function(){
    this.$emit('input_value_changed', {name: this.name, val: this.value});
    var vm = this;

    jQuery(vm.$el).datetimepicker({
      format:'M d Y H:i',

      onClose:function(dp,$input){
        vm.value = $input.val();
        vm.$emit('input_value_changed', {name: vm.name, val: vm.value});
      }
    });
  },

  methods:{
    input: function(){
      this.$emit('input_value_changed', {name: this.name, val: this.value});
    }
  },

  template : '<input type="text" v-on:input="input" autocomplete="off" v-on:change="input" v-on:blur="input" v-bind:name="name" v-model="value" placeholder="Add" >',
});
Vue.component('datepicker-styled', {
  data: function () {
    return {
      name:  '',
      value : '',
    }
  },

  props:['_value', '_name'],


  beforeMount: function(){
    this.name = this._name ? this._name : 'datetimepicker';

    if(this._value){
      var date = new Date(this._value);
      var fmt  = new DateFormatter();
      this.value = fmt.formatDate(date, 'd F Y');
    }
  },

  watch:{
    _value: function(){
      var date = new Date(this._value);
      var fmt  = new DateFormatter();
      this.value = fmt.formatDate(date, 'd F Y');
    },
  },


  mounted: function(){
    this.$emit('input_value_changed', {name: this.name, val: this.value});
    var vm = this;

    jQuery(vm.$el).datetimepicker({
      format:'d F Y',
      timepicker:false,
      value: this.value,

      onClose:function(dp,$input){
        var fmt  = new DateFormatter();
        vm.value = $input.val();
        vm.$emit('input_value_changed', {name: vm.name, val: fmt.formatDate(dp, 'Y-m-d H:i:s')});
      }
    });
  },

  methods:{
    input: function(){
      this.$emit('input_value_changed', {name: this.name, val: this.value});
    }
  },

  template : '<div class="datepicker-wrapper"><svg class="icon svg-icon-calendar"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-calendar"></use> </svg><input type="text" v-on:input="input" autocomplete="off" v-on:change="input" v-on:blur="input" v-bind:name="name" v-model="value" placeholder="Add" ></div>',
});

datepicker_field = Vue.component('reminder', {
  data: function () {
    return {
      name:  '',
      value : '',
      value_formatted : '',
      overdue: '',
    }
  },

  props:['_value', '_name', '_value_formatted', '_overdue'],


  beforeMount: function(){
    this.name = this._name ? this._name : 'datetimepicker';
    this.value = this._value;
    this.overdue = is_boolean(this._overdue);
    this.value_formatted = this._value_formatted && this._value_formatted != 'No Due Date' ? this._value_formatted : '';
  },

  change: function(){},

  watch:{
    value_formatted:function(){
      this.$emit('input_value_changed', {value: this.value, value_formatted: this.value_formatted, overdue: this.overdue});
    },
  },

  mounted: function(){
    // this.$emit('input_value_changed', {name: this.name, val: this.value});
    var vm = this;

    jQuery(vm.$el).find('input').datetimepicker({
      format:'d M Y',
       timepicker:false,

      onClose:function(dp,$input){
        var now  = new Date();
        vm.overdue = now > dp? 1 : 0;

        var day      = dp.getDay();
        var month    = dp.getMonth();
        var hours    = dp.getHours();
        var minutes  = dp.getMinutes();

        day = day < 10? '0' + day: day;
        month = month + 1 < 10 ? '0' + month + 1: month + 1;
        hours = hours < 10? '0' + hours: hours;
        minutes = minutes < 10? '0' + minutes: minutes;
        vm.value_formatted = $input.val();
        vm.value = dp.getFullYear() + '-'+ month + '-' + day;
      }
    });
  },

  methods:{
    input: function(){
      // this.$emit('input_value_changed', {name: this.name, val: this.value});
    },

    clear: function(){
      this.value = '';
      this.value_formatted = '';
      this.overdue = false;
    }
  },

  template : '<div class="reminder"> <svg class="icon svg-icon-bell"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-bell"></use> </svg> <span class="label">Set Reminder</span> <input type="text" class="value" v-on:input="input" autocomplete="off" v-on:change="input" v-on:blur="input" v-bind:name="name" v-model="value_formatted" placeholder="Add" > <span href="javascript:void(0)" class="clear-reminder" v-if="value" v-on:click="clear">clear</span> </div>',
});
Vue.component('input-field', {
  data: function () {
    return {
      type: (this._type)? this._type : 'text',
      name:  this._name,
      value : this._value,
      readonly : this._readonly,
      placeholder : (this._placeholder)? this._placeholder : 'Add',
    }
  },

  props:['_value', '_name', '_readonly', '_placeholder', '_type'],

  watch:{
    _value: function(val){
      this.value = val;
    },

    value: function(){
      this.$el.classList.remove('error');
    },
  },

  mounted: function(){
    this.$emit('input_value_changed', {name: this.name, val: this.value});
  },

  methods:{
    input: function(){
      if(typeof(this.value) == 'undefined') {
        this.value = jQuery(this.$el).val();
      }

      this.$emit('input_value_changed', {name: this.name, val: this.value});
    },

    set_value:function(val){
      this.value = val;
      this.$emit('input_value_changed', {name: this.name, val: this.value});
    }
  },

  template : '<input v-bind:type="type" v-on:input="input"  v-on:change="input" v-on:blur="input" v-bind:name="name" v-model="value" placeholder="Add" class="leads-block__input":readonly="readonly == 1" autocomplete="off">',

});


input_field_decorated = Vue.component('input-decorated', {
  data: function () {
    return {
      type: (this._type)? this._type : 'text',
      name:  this._name,
      value : this._value,
      icon : this._icon,
      readonly : this._readonly,
      placeholder : (this._placeholder)? this._placeholder : 'Add',
    }
  },

  props:['_value', '_name', '_readonly', '_placeholder', '_type', '_icon'],

  mounted: function(){
    this.$emit('input_value_changed', {name: this.name, val: this.value});
  },

  methods:{
    input: function(){
      this.$emit('input_value_changed', {name: this.name, val: this.value});
    },

    set_value:function(val){
      this.value = val;
      this.$emit('input_value_changed', {name: this.name, val: this.value});
    }
  },

  template : '<div class="wrapper-input"><span v-html="icon"></span><input v-bind:type="type" v-on:input="input"  v-on:change="input" v-on:blur="input" v-bind:name="name" v-model="value" placeholder="Add" class="":readonly="readonly == 1" autocomplete="off"></div>',

});
Vue.component('input-text-search-product', {
  data: function () {
    return {
      title: '',
      name: '',
      options: available_products,
      img_url: '',
      searching: false,
      found: false,
      show_dropdown: false,
      variations :     {
      },
      free_product_id: false,
    }
  },



  mixins: [get_set_props],

  props: ['_img_url', '_placeholder', '_name'],

  watch: {
    title: function(val){
      var vm = this;
      vm.searching = true;
      vm.show_dropdown = val.length > 0? true : false;

      if('undefined' == typeof(timeout)){
        var timeout;
      }

      if(!timeout){
        timeout = setTimeout(function(){
          vm.searching = false;
        },100)
      }else{
        clearTimeout(timeout);
      }
    },

    show_dropdown: function(val){
    },

    _img_url: function(val){
      this.img_url = this._img_url;
    },

    _name: function(name){
      this.name = name;
    },

    found: function(is_found){
      if(is_found){
        this.$emit('product_found', {'variations' : this.variations, free_product_id: this.free_product_id, recipe: this.title});
      }else{
        this.$emit('product_found', {'variations' : false, free_product_id: false});
      }
    }
  },

  computed: {
    found_options: function(){
      var options = [];
      var search = this.title.toLowerCase();

      if( this.options ){
        for(var opt in this.options){
          var tried_value = this.options[opt].name.toLowerCase();

          // check if input text is a part of possible values
          if(tried_value.indexOf(search) >= 0 && search){
            var temp = this.options[opt];
            temp.slug = opt;
            options.push(temp);
          }

          // search name is equal to imput value
          if (search === tried_value){
            var vm = this;
            var id = opt;
            Vue.nextTick(function(){
              vm.title = vm.options[id].name;
              vm.variations = vm.options[id].variations;
              vm.free_product_id = vm.options[id].free_product_id;
              vm.show_dropdown = false;
              vm.found = id;
              return [vm.options[id]];
            })
          }
        }
      }
      return options;
    },
  },

  beforeMount: function(){
    this.img_url = this._img_url;
    this.name =   this._name;
  },

  mounted: function(){
  },

  methods: {
    set_title: function(id){
      this.title = this.options[id].name;
      this.variations = this.options[id].variations;
      this.free_product_id = this.options[id].free_product_id;
      this.found = id;
      var vm = this;
      Vue.nextTick(function(){
        vm.show_dropdown = false;
      })
    },

    resert_values: function(){
      this.title = '';
      this.searching = false;
      this.found = false;
      this.show_dropdown = false;
      this.variations  = {};
      this.free_product_id = false;
    },

    restore_data: function(){
    },
  },

  template: `
    <div class="input-holder">
      <input type="text" id="product-name" class="popup-inner__field" v-model="title" autocomplete="off"
        v-bind:placeholder = "_placeholder"
      >
       <img :src="img_url" v-if="searching">

       <div class="input-holder__dropdown" v-if="found_options.length > 0 && show_dropdown">
          <ul class="input-holder__list">
            <li v-for="(prod, id) in found_options" v-on:click="set_title(prod.slug)">{{prod.name}}</li>
          </ul>
       </div>

       <div class="input-holder__dropdown" v-if="found_options.length == 0 && show_dropdown">
          <p> No products found </p>
       </div>
    </div>
  `,
});
Vue.component('coupon-field', {
  data: function () {
    return {
      type: (this._type)? this._type : 'text',
      name:  this._name,
      value : '',
      readonly : this._readonly,
      placeholder : (this._placeholder)? this._placeholder : 'Add',
      focused: false,
      price: 0,
      coupon_id: '' ,
      coupon_name: '' ,
      discount_type: '' ,
    }
  },

  props:['_value', '_name', '_readonly', '_placeholder', '_type', '_currency'],

  watch:{
    _value: function(val){
      this.value = val;
    },
    _currency: function(val){
      this.currency = val;
    },

    _coupon_id: function(val){
      this.coupon_id = val;
    },

    value: function(){
      this.focused = true;
      this.$el.classList.remove('error');
      var vm = this;
      var search = this.all_coupons.filter(e=>{
        return vm.value.toLowerCase() == e.name.toLowerCase();
      });

      if(search.length == 1){
        vm.value       = search[0].name;
        vm.coupon_id   = search[0].coupon_id;
        vm.discount_type   = search[0].discount_type;
        vm.coupon_name = search[0].name;
        vm.price       = search[0].price;

        Vue.nextTick(function(){
          vm.focused = false;
          vm.$emit('input_value_changed', {name: vm.name, val: vm.get_data()});
        })
      }

      if(search.length == 0){
        vm.coupon_id   = -1;
        vm.coupon_name = vm.value;
        vm.price       = 0;
        vm.discount_type       = '';
        vm.$emit('input_value_changed', {name: vm.name, val: vm.get_data()});
      }
    },
  },

  beforeMount: function(){
    this.value = this._value;
    this.currency = this._currency;
  },

  computed:{
    all_coupons: function(){
      return all_coupons;
    },


    coupons_found: function(){
      var vm = this;
      if(vm.value.length >=1 && vm.focused){
        var c = this.all_coupons.filter(e=> {
          return e.name.toLowerCase().indexOf(vm.value.toLowerCase()) >=0
        });

        return c;
      }

      return [];
    }
  },

  mounted: function(){
    this.$emit('input_value_changed', {name: this.name, val: this.get_data()});
  },

  methods:{
    input: function(){
      // this.focused = true;
      // if(typeof(this.value) == 'undefined') {
      //   this.value = jQuery(this.$el).val();
      // }

      // this.$emit('input_value_changed', {name: this.name, val: this.get_data()});
    },

    set_value:function(val){
      this.value = val;
      this.$emit('input_value_changed', {name: this.name, val: this.get_data()});
    },

    get_data: function(){
      return {
        name:            this.coupon_name,
        price:           this.price,
        coupon_id:       this.coupon_id,
        discount_type:       this.discount_type,
      }
    },

    get_price: function(data){
        switch(data.discount_type){
          case "fixed_cart":
            return '-'+ this._currency + data.price;
            break;
          case "percent":
            return '-'+ data.price + '%';
            break;
          default:
            return '-'+ this._currency + data.price;
            break
        }
      return 0;
    },

    update_coupon: function(coupon){
      var vm = this;
      vm.value        = coupon.name;
      vm.coupon_id    = coupon.coupon_id;
      vm.coupon_name  = coupon.name;
      vm.price        = coupon.price;
      vm.discount_type       = coupon.discount_type;

      Vue.nextTick(function(){
        vm.focused = false;
        vm.$emit('input_value_changed', {name: vm.name, val: vm.get_data()});
      })
    },
  },

  template : `
  <div class="input-holder">
    <div class="wrapper-input">
     <input v-bind:type="type"
      v-on:input="input"
      v-on:change="input"
      v-bind:name="name"
      v-model="value"
      :placeholder="placeholder"
      class="":readonly="readonly == 1" autocomplete="off">
    </div>

    <div class="input-holder__dropdown" v-show="coupons_found.length > 0" ref="dropdown">
      <ul class="input-holder__list">
        <li
          v-for="(coupon , key) in coupons_found"
          :key="key"
          v-on:click="update_coupon(coupon)"
        >
        <span class="inner">{{coupon.name}} <span class="brand">{{get_price(coupon)}}</span></span></li>
      </ul>
    </div>
   </div>`,

});
Vue.component('customer_name', {
  data: function () {
    return {
      name: '',
      value: '',
      user_id: -1,
      user_registered: '',
      email: '',
      billing: {
        address_1: '',
        address_2: '',
        city: '',
        company: '',
        country: '',
        email: '',
        first_name: '',
        last_name: '',
        phone: '',
        postcode:'',
        state: '',
      },
      focused: false,
    }
  },

  props: ['_name', '_value'],

  watch: {
    '_name': function(val){
      this.name = val;
    },

    '_value': function(val){
      this.value = val;
    },

    value: function(val){
      this.focused = true;
      this.$el.classList.remove('error');
    },
  },

  computed: {
    all_customers: function(){
      return all_customers;
    },

    users_found:function(){
      var vm = this;
      if(vm.value.length >=2 && vm.focused){
        var users = this.all_customers.filter(e=> {
          return e.name.toLowerCase().indexOf(vm.value.toLowerCase()) >=0 || e.brand.toLowerCase().indexOf(vm.value.toLowerCase()) >=0
        });

        return users;
      }

      return [];
    }
  },

  beforeMount: function(){
     this.name = this._name;
     this.value = this._value;
  },

  mounted: function(){},

  methods: {
    input: function(){
      if(typeof(this.value) == 'undefined') {
        this.value = '';
      }

      this.$emit('input_value_changed', this.get_data());
    },

    get_data: function(){
      return {
        customer_name:   this.value,
        name:            this.name,
        email:           this.email,
        billing:         this.billing,
        user_id:         this.user_id,
        user_registered: this.user_registered,
      }
    },

    update_customer: function(customer){
      var vm = this;
      vm.value             = customer.name;
      vm.user_registered   = customer.user_registered;
      vm.user_id = customer.user_id;
      vm.billing = customer.billing;
      vm.email   = customer.email;

      Vue.nextTick(function(){
        vm.focused = false;
        vm.$emit('input_value_changed', vm.get_data());
      })
    },
  },

  template: `<div class="input-holder">
   <input
     :name="name"
     placeholder="Add"
     autocomplete="off"
     type="text"
     class="leads-block__input lg styled"
     v-model="value"
     v-on:input="input"
     v-on:change="input"
     >

    <div class="input-holder__dropdown" v-if="users_found.length > 0">
      <ul class="input-holder__list">
        <li
          v-for="(user , key) in users_found"
          :key="key"
          v-on:click="update_customer(user)"
        >
        {{user.name}} <span class="brand">{{user.brand}}</span></li>
      </ul>
    </div>
   </div>`,
})
if(document.getElementById('frontdesk_list')){

  frontdesk_list = new Vue({
    'el' : '#frontdesk_list',

    mixins: [get_set_props, list_filter_mixin, get_item],

    data: {
        visible: true,

        filters: {
          campaigns : 'All Campaigns',
          sources   : 'All Sources',
          team      : 'All Team',
        },

        fasttrack     : false,
        due_date_only : false,
        overdue_only  : false,
        _overdue_count: 0,
        _due_count: 0,
        selected_order_id: -1,
        items: frondtdesk_items,
        columns_data : frondtdesk_columns_data,
    },

    beforeCreate: function(){
      if (theme_debug) {
        console.time('frontdesk list');
      }
    },

    beforeMount:function(){
      this.debug();
    },

    created:function(){
    },

    computed:{
      overdue_count: function(){
        return this._overdue_count;
      },

      due_count: function(){
        return this._due_count;
      },

      items_by_load:function(){
        return 50;
      },

      _item_data: function(){
        var item = this.get_item_by('order_id', this.selected_order_id);
        const _item_data = JSON.parse(JSON.stringify(item.data));
        return _item_data;
      },
    },

    watch: {
      visible: function(val){
        if(val){
          this.selected_order_id = -1;
          var items = this.items;

          //calculate overdue number of elements
          var _items = items.filter(function(el){
            return typeof(el.data.reminder.is_overdue) !== 'undefined' && el.data.reminder.is_overdue && el.data.reminder.is_overdue != 'false'
          });

          this._overdue_count = _items.length;

          if(typeof(filters) !== 'undefined'){
            filters.update_prop('overdue_count', _items.length);
          }

          //calculate number of elements that has due date
          var _items = items.filter(function(el){
            return  !!el.data.reminder.date
          });

          this._due_count = _items.length;

          if(typeof(filters) !== 'undefined'){
            filters.update_prop('due_count', _items.length);
          }
        }
      },
    },

    mounted: function(){
      jQuery(this.$refs.column_container).css({
        'min-width' : this.columns.length * 300 + 'px',
      })
      document.getElementById('site-body').classList.remove('not-ready');

      ctime('frontdesk list');
    },

    methods: {
      debug:function(){
        if(!theme_debug){return;}
      },


      /**
      * opens order details
      *
      * @param data - item object
      */
      open_order: function(data){
        this.selected_order_id = data.order_id;
        var index = this.get_index_of_item_by('order_id', data.order_id);
        var item = this.get_item_by('order_id', data.order_id);
        const _data = JSON.parse(JSON.stringify(item.data));

        if(typeof(filters) == 'object'){
          filters.update_prop('visible', false);
        }

        // show order details
        if(typeof(frontdesk_order) == 'object'){
          frontdesk_order.update_prop('visible', true);
          frontdesk_order.update_prop('item_index', index);
          frontdesk_order.update_prop('order_data', _data);
        }

        this.visible = !this.visible;
      },

      /**
      * updates order status
      *
      * @param order_id - string, id of order to update
      */
      update_order_status:function(order_id, order_status){
        if('undefined' === typeof(order_id) || !order_id){
          return false;
        }

        console.log(order_status)

        jQuery.ajax({
          url: WP_URLS.ajax,
          type: 'POST',
          dataType: 'json',
          data: {
            action       : 'save_order_status',
            order_id     : order_id,
            order_status : order_status,
          },
        })
      },

      /**
      * gets element to update from items array
      * fires order_status_update function
      *
      * @param data - passed from emit object {order_id: value}
      *
      * @return void
      */
      update_order_status_on_drag_cb: function(data){
        var vm = this;
        var item = vm.get_item_by('order_id', data.order_id);

        if(item){
          vm.update_order_status(item.order_id, item.data.order_status);
        }
      },

      /**
      * updates filters
      *
      * @param
      */
      update_filters: function(filter_data){
        this.filters = filter_data;
      },
    },
  })
}
if(document.getElementById('filters-frontdesk')){
  filters = new Vue({
    'el' : '#filters-frontdesk',

    mixins: [get_set_props],

    data: {
      filters: {
        campaign : 'All Campaigns',
        source   : 'All Sources',
        team     : 'All Team',
      },

      fasttrack     : false,
      overdue_only  : false,
      due_date_only : false,

      filter_values: filter_values,

      overdue_count: 0,

      mode: 'frontdesk',

      visible: true,
    },

    computed: {},

    watch: {
      // watchs state of filter and passes change to a list component
      'filters.campaign': function(){
        frontdesk_list.update_filters(this.filters);
      },

      // watchs state of filter and passes change to a list component
      'filters.source': function(){
        frontdesk_list.update_filters(this.filters);
      },

      // watchs state of filter and passes change to a list component
      'filters.team': function(){
        frontdesk_list.update_filters(this.filters);
      },

      'fasttrack': function(val){
        frontdesk_list.update_prop('fasttrack', val);
      },

      'due_date_only': function(val){
        frontdesk_list.update_prop('due_date_only', val);
      },

      'overdue_only': function(val){
        this.due_date_only = val;
        frontdesk_list.update_prop('overdue_only', val);
      },

      visible: function(val){
        var vm = this;

        //reinitalizes select on visibility change
        if(val){

          Vue.nextTick(function(){
            //initialize selects

            for(var select_name in vm.filters){
             vm.init_select(select_name);
            }

            // init datepicker
             init_date_range();
          })
        }

        // initializes all select elements
      },

    },

    beforeMount: function(){
      this.overdue_count = frontdesk_list.get_prop('overdue_count');
      this.due_count = frontdesk_list.get_prop('due_count');
    },

    mounted: function(){
      var vm = this;

      // initializes all select elements
      vm.init_selects();
    },

    methods: {

      // initialize select callback
      init_select: function(name){
        var vm = this;

        var options = {
          options: this.filter_values[name],
          icon: icons_selects[name],
          isExpanded: '',
          isSelected: [],
          isHiddenSelect: true,
          isHiddenImitation: false,
        };

        for(var field_id in options){
          vm.$refs[name][0].set_value(field_id, options[field_id]);
        }
      },

      init_selects: function(){
        var vm = this;
        for(var select_name in vm.filters){
           vm.init_select(select_name);
        }
      },

      // callback for child select imitation emit
      run_filter_list: function(data){
        this.filters[data.name] = data.val;
      },
    },
  })
}
if(document.getElementById('single-frontdesk-order')){
  frontdesk_order = new Vue({
    el : '#single-frontdesk-order',

    mixins: [get_set_props, animation_mixin, fds_order, upload_pdf_mixin],

    data: {
      new_order: false,
      visible: false,
      item_index: -1,
      order_data: {},
      do_save: false,
      studio_note_text:  '',
      enquery_note_text: '',
      studio_notes_count:  1,
      enquery_notes_count: 1,
      order_was_changed: false,
      is_run_saving: false,
    },

    watch:{
      visible: function(val){
        var vm = this;
        if(val){
          Vue.nextTick(function(){
            vm.order_was_changed = false;
          })
        }
      },

      'order_was_changed': function(val){
        clog('order_was_changed: ' + val, 'red');
      },

      'order_data.location.unit': function(val){
        if(this.visible){
          this.order_was_changed = true;
        }
      },

      'order_data.location.box': function(val){
        if(this.visible){
          this.order_was_changed = true;
        }
      },

      'order_data.product_collection.address': function(val){
        if(this.visible){
          this.order_was_changed = true;
        }
      },
    },

    computed:{
      get_count_reviews:function(){
          if(!this.order_data.wfp_images){
            return 0;
          }
         return this.order_data.wfp_images.filter(e=>{
            return 'undefined' != typeof(e.request);
          }).map(e=>{
            return e.request.length;
          }).reduce((a, b) => a + b, 0);
      },

      _order_was_changed: function(){
        if(this.visible){
          return this.order_was_changed;
        }
        return false;
      },
    },

    methods:{

      do_toggler: function(){
        this.order_data.product_collection.do_collect =! this.order_data.product_collection.do_collect;

        if(this.visible){
          // this.order_was_changed = true;
        }
      },

      exec_save:function(){
        if(this.order_was_changed){
          this.do_save = true;
          this.exec_save_wordpress();
          this.upload_pdf();
          var vm = this;
        }
      },

      get_image_url(image){
        if('undefined' !== typeof(image.archive_url)){
          return image.archive_url;
        }
        clog(this.order_data);
        return '';
      },



      /**
      * hides single element and shows order_list and filters
      */
      return_to_list: function(){
        var vm = this;

        if(vm.do_save){
          vm.exec_save_vue();
        }

        Vue.nextTick(function(){
          vm.visible = !vm.visible;
          vm.do_save = false;

          if(typeof(filters) == 'object'){
            var visibility = filters.get_prop('visible');
            filters.update_prop('visible', !visibility);
          }

          if(typeof(frontdesk_list) == 'object'){
            var visibility = frontdesk_list.get_prop('visible');
            frontdesk_list.update_prop('visible', !visibility);
          }
        })
      },
    },
  });
}
if(document.getElementById('new-frontdesk-order')){
  frontdesk_order_new = new Vue({
    el : '#new-frontdesk-order',

    mixins: [get_set_props, animation_mixin, fds_order, upload_pdf_mixin],

    data: {
      visible: false,
      new_order: true,
      item_index: -1,
      order_data: blank_order.data,
      do_save: false,
      studio_note_text:  '',
      enquery_note_text: '',
      studio_notes_count:  1,
      enquery_notes_count: 1,
      order_was_changed: false, // doesn't used in new order just for mixin compatibility
      is_run_saving: false,// doesn't used in new order just for mixin compatibility
    },

    watch:{
      visible: function(visible){
          this.resert();
      },

      "order_data.address_billing":function(val){
         document.getElementsByClassName('add-address-btn')[0].classList.remove('error');
      },

      "order_data.order.addons.turnaround.name": function(val){
        this.order_data.is_fasttrack = (val.toLowerCase() == 'fast track' || val.toLowerCase() == 'fasttrack' )? 1: 0;
      },
    },



    change:function(){
      // this.update_prop('order_data', blank_order.data);
    },

    beforeMount:function(){
      this.resert();
    },

    mounted: function(){
    },

    methods:{
      add_product: function(data){
        document.getElementsByClassName('new-order-item')[0].classList.remove('error');
        this.order_data.order.items.push(data);
      },

      add_fee: function(data){
        this.order_data.order.fee.push(data);
      },

      init: function(){
        this.order_data = blank_order.data;
      },


      /**
      * hides single element and shows order_list and filters
      */
      return_to_list: function(){
        var vm = this;

        Vue.nextTick(function(){
          vm.visible = !vm.visible;

          if(typeof(filters) == 'object'){
            filters.update_prop('visible', true);
          }

          if(typeof(frontdesk_list) == 'object'){
            frontdesk_list.update_prop('visible', true);
          }
        })

      },


      /**
      * saves new order
      */
      save_order: function(){
        var v = this.save_order_validate();

        if(!v.is_valid){
          alert(v.messages[0])
          return;
        }

        block();

        var vm = this;

        jQuery.ajax({
          url: WP_URLS.ajax,
          type: 'POST',
          dataType: 'json',
          data: {action: 'create_new_order',
            data: vm.order_data,
          },
        })

        .done(function(data) {
          console.log(data);

          if(typeof(data.data) !=='undefined'){
            alert(data.data.error);
            return;
          }

          if(data.order_id > 0){
            var new_item = {
              order_id: data.order_id,
              data    : data.order_data,
            }

            var items = frontdesk_list.get_prop('items');
            items.push(new_item);

            Vue.nextTick(function(){
              frontdesk_list.selected_order_id = data.order_id;
              var index = frontdesk_list.get_index_of_item_by('order_id', data.order_id);
              var item = frontdesk_list.get_item_by('order_id', data.order_id);

              const _data = JSON.parse(JSON.stringify(item.data));

              // show order details
              if(typeof(frontdesk_order) == 'object'){
                frontdesk_order.update_prop('visible', true);
                frontdesk_order.update_prop('item_index', index);
                frontdesk_order.update_prop('order_data', _data);
              }

              vm.resert();
              vm.visible = false;
            })
          }
        })

        .fail(function(e) {
          console.log(e);
        })
        .always(function() {
          unblock();
        });

      },

      /**
      * validates order before save
      *
      * @ return obj - {status - bool, messages - array}
      */
      save_order_validate: function(){
        var validated,
            childs,
            check,
            child_ids;

        validated = {
          is_valid: true,
          messages : [],
        };

        check = {
           cusomer_data:     'Please set customer\'s name',
          // 'phone'     : 'Please set customer\'s phone',
          'email'     : 'Please set customer\'s email',
           order_status: 'Please select an order status',
        };

        child_ids = Object.keys(check);

        childs = this.$children.filter(e => {
          var name = e.name || e.select_name;
          var value = e.value || e.selected;
          e.$el.classList.remove('error');
          return child_ids.indexOf(name) >=0 && !value;
        });

        childs.filter(e => {
          e.$el.classList.add('error');
          return e;
        });

        validated.is_valid = childs.length == 0;

        validated.messages = childs.map(e=>{return check[e.name] || check[e.select_name]});

        if(this.order_data.order.items.length == 0){
          validated.is_valid = false;
          validated.messages.push('Add at least 1 product to an order');
          document.getElementsByClassName('new-order-item')[0].classList.add('error');
        }else{
          document.getElementsByClassName('new-order-item')[0].classList.remove('error');
        }

        if(!this.order_data.address_billing){
          validated.is_valid = false;
          validated.messages.push('Add billing address, please');
          document.getElementsByClassName('add-address-btn')[0].classList.add('error');
        }else{
          document.getElementsByClassName('add-address-btn')[0].classList.remove('error');
        }

        return validated;
      },

      resert: function(){
        this.order_data = strip(blank_order.data);
      },

      remove_product: function(key){
        var items = Object.entries(strip(this.order_data.order.items));

        items = items.filter(e=>{
          return e[0] != key;
        }).map(e=>{
          return e[1];
        });

        this.order_data.order.items = items;
      },

      remove_fee: function(key){
        var items = Object.entries(strip(this.order_data.order.fee));

        items = items.filter(e=>{
          return e[0] != key;
        }).map(e=>{
          return e[1];
        });

        this.order_data.order.fee = items;
      },

      update_order_addon: function(data, key){
        for(var id in data.val){
          this.order_data.order.addons[key][id] = data.val[id];
        }
      },

      update_coupon: function(data){
        this.order_data.order.addons.discount.name      = data.val.name;
        this.order_data.order.addons.discount.discount_type      = data.val.discount_type;
        this.order_data.order.addons.discount.coupon_id = data.val.coupon_id;
        var vm = this;

        switch(data.val.discount_type){
          case "fixed_cart":
            this.order_data.order.addons.discount.price     = '-'+ vm.order_data.order.currency_symbol + data.val.price;
            break;
          case "percent":
            this.order_data.order.addons.discount.price     = '-'+ data.val.price + '%';
            break;
          default:
            this.order_data.order.addons.discount.price     = '-'+ vm.order_data.order.currency_symbol + data.val.price;
            break
        }
      },

      update_customer: function(data){
        if(data.user_id < 0){
          this.order_data.name = data.customer_name;
        }else{
          this.order_data.name = data.customer_name;

         address_fields = Object.entries(data.billing).filter(e=>{
            if(["last_name", "first_name", "company", "email", "phone"].indexOf(e[0]) >= 0){
              return false;
            }
            return true;
          }).map(e=>{
            return e[1];
          }).join(' ');

          this.order_data.address_billing = address_fields? address_fields : this.order_data.address_billing

          this.order_data.customer.email = data.email ? data.email : this.order_data.customer.email;

          this.order_data.customer.phone = data.billing.phone? data.billing.phone: this.order_data.customer.phone;

          this.order_data.customer.brand = data.billing.company? data.billing.company : this.order_data.customer.brand;

          this.order_data.customer.user_id = data.user_id? data.user_id : this.order_data.customer.user_id;

          this.order_data.customer.billing = data.billing;
        }
      },
    },
  });
}
if(document.getElementById('add-product')){
  popup_product = new Vue({
  el: '#add-product',

  mixins: [get_set_props, animation_mixin],

  data:{
    visible          : false,
    is_product_selected : false,
    selected            : '',
    free_product_id     : '',
    variations          : {},

    selected_product_id : false,
    sizes: [],
    notes: '',
    recipe: '',
    product_title: '',
  },

  watch: {
    visible: function(show){
      if(show){
        this.$refs.recipe.resert_values();
        this.resert();
      }
    },

    product_title:  function(){
      this.$refs.product_title.classList.remove('error');
    },

    selected_product_id: function(){
      this.$refs.selected_product_id.classList.remove('error');
    },

    sizes: function(){
      this.$refs.sizes.classList.remove('error');
    },
  },

  methods: {
    set_product_data: function(data){
      this.is_product_selected = false;
      this.$refs.recipe.$el.classList.remove('error');
      this.variations = data.variations;
      this.recipe     = data.recipe;
      this.free_product_id = data.free_product_id;
      var vm = this;
      Vue.nextTick(function(){
        vm.is_product_selected = (data.variations || data.free_product_id)? true : false;
      })
    },

    update_sizes: function(size){
      var index = this.sizes.indexOf(size);

      if(index < 0){
        this.sizes.push(size);
      }else{
        this.sizes.splice(index, 1);
      }
    },

    has_size: function(size){
      return  this.sizes.indexOf(size) < 0 ? false : true;
    },

    submit: function(){
      var validated = this.validate();
      var vm = this;

      if(!validated.is_valid){
        setTimeout(function(){
          alert(validated.messages.join('\n'));
        },100);

        return;
      };

      var item = {
        title        : this.product_title,
        product_id   : this.selected_product_id,
        product_name : this.recipe,
        image_count  :  'undefined'  !== typeof(this.variations[this.selected_product_id])? this.variations[this.selected_product_id].images + ' images' : '1 image',
        price        :  'undefined'  !== typeof(this.variations[this.selected_product_id])? this.variations[this.selected_product_id].price : 0,
        sizes        :  this.sizes,
        notes        :  this.notes,
      };

      frontdesk_order_new.add_product(item);
      this.visible = false;
    },

    validate: function(){
      var check = {
        recipe: 'Select a recipe, please',
        selected_product_id : 'Please, select a number of images or free sample',
        sizes:        'Select at least one size, please',
        product_title: 'Type a product name please',
      }
      var validated = {
        is_valid: true,
        messages: [],
      };

      for(var id in check){
        var item = this[id];

        if('undefined' == typeof( this.$refs[id])){
          continue;
        }
        switch(typeof(item)){
          case 'object':
            var items = Object.values(item);
            validated.is_valid = items.length === 0 ? false : validated.is_valid;
            if(items.length === 0){
             this.$refs[id].classList.add('error');
             validated.messages.push(check[id]);
            }
            break;
          default:
            if(!item){
              if(id == 'recipe'){
                this.$refs[id].$el.classList.add('error');
              }else{
                this.$refs[id].classList.add('error');
              }
              validated.is_valid = false;
              validated.messages.push(check[id]);
            }

            break;
        };
      }
      return validated;
    },

    resert: function(){
      var data = {
        visible          : true,
        is_product_selected : false,
        selected            : '',
        free_product_id     : '',
        variations          : {},

        selected_product_id : false,
        sizes: [],
        notes: '',
        recipe: '',
        product_title: '',
      };

      for(var id in data){
        this[id] = data[id];
      };

      this.$refs.product_title.classList.remove('error');
      this.$refs.recipe.$el.classList.remove('error');

    }
  }
  })
}
if(document.getElementById('add-fee')){
  popup_fee = new Vue({
    el: '#add-fee',
    mixins: [get_set_props, animation_mixin],
    data: function(){
      return {
        visible: false,
        fee_title: '',
        fee_ammount: '',
      };
    },

    watch:{
      fee_title: function(){
        this.$refs.fee_title.classList.remove('error');
      },

      fee_ammount: function(val){
        this.$refs.fee_ammount.classList.remove('error');
        var _val = val.replace(/[^.|\d]/g,'');
        this.fee_ammount = _val;
      },
    },

    methods: {
      submit: function(){
        var validated = this.validate();
        var vm = this;

        if(!validated.is_valid){
          setTimeout(function(){
            alert(validated.messages.join('\n'));
          },100);

          return;
        };

        var item = {
          fee_name: this.fee_title,
          price:  parseFloat(this.fee_ammount).toFixed(2),
        }

        frontdesk_order_new.add_fee(item);
        this.visible = false;

      },

    validate: function(){
      var check = {
        fee_title   : 'Please enter the fee title',
        fee_ammount : 'Please enter the fee ammount',
      }

      var validated = {
        is_valid: true,
        messages: [],
      };

      for(var id in check){
        var item = this[id];
          if(!item){
            this.$refs[id].classList.add('error');
            validated.is_valid = false;
            validated.messages.push(check[id]);
          }
        }
        return validated;
      },
    },
  });
}
if(document.getElementById('add-address')){
  popup_address = new Vue({
    el: '#add-address',
    mixins: [get_set_props, animation_mixin],
    data: function(){
      return {
        visible: false,
        countries: ["United Kingdon", 'Ireland'],
        country: 'United Kingdon',
        city: '',
        line_1: '',
        line_2: '',
        zip: '',
        new_order: '',
      };
    },

    methods: {
      submit: function(){
        var validated = this.validate();
        var vm = this;

        if(!validated.is_valid){
          setTimeout(function(){
            alert(validated.messages.join('\n'));
          },100);

          return;
        };

        var _keys = [
          'country',
          'zip',
          'city',
          'line_1',
          'line_2',
        ];

        var item = [];

        for(var id of _keys){
          if(this[id]){
            item.push(this[id]);
          }
        }

        if(this.new_order){
          frontdesk_order_new.update_order({name: 'address', val: item.join(', ')}, 'product_collection');
        }else{
          frontdesk_order.update_order({name: 'address', val: item.join(', ')}, 'product_collection');
        }

        this.visible = false;

      },

      update_data: function(data){
        if(data.val){
          this[data.name] = data.val;
        }
      },

      validate: function(){
        var check = {
          city:   'Enter a City or Town please',
          line_1: 'Enter an address please',
          zip:    'Enter postal code please',
        }

        var validated = {
          is_valid: true,
          messages: [],
        };

        for(var id in check){
          var item = this[id];
            if(!item){
              this.$refs[id].classList.add('error');
              validated.is_valid = false;
              validated.messages.push(check[id]);
            }
          }
        return validated;
      },
    }
  })
}
if(document.getElementById('add-address-billing')){
  popup_address_billing = new Vue({
    el: '#add-address-billing',
    mixins: [get_set_props, animation_mixin],
    data: function(){
      return {
        visible: false,
        countries: ["United Kingdon", 'Ireland'],
        country: 'United Kingdon',
        city: '',
        address_1: '',
        address_2: '',
        postcode: '',
        company: '',
      };
    },

    watch:{
      visible:function(){
        this.country  = 'United Kingdon';
        this.city  = '';
        this.address_1  = '';
        this.address_2  = '';
        this.postcode  = '';
        this.company  = '';
      }
    },

    methods: {
      submit: function(){
        var validated = this.validate();
        var vm = this;

        if(!validated.is_valid){
          setTimeout(function(){
            alert(validated.messages.join('\n'));
          },100);

          return;
        };

        var _keys = [
          'country',
          'postcode',
          'city',
          'address_1',
          'address_2',
          'company',
        ];

        var item = {};

        for(var id of _keys){
          if(this[id]){
            item[id] = this[id];
          }
        }

       frontdesk_order_new.update_order({name: 'address_billing', val: Object.values(item).join(', ')}, 'core');

       frontdesk_order_new.update_order({name: 'billing', val: item}, 'customer');

        this.visible = false;
      },

      update_data: function(data){
        if(data.val){
          this[data.name] = data.val;
        }
      },

      validate: function(){
        var check = {
          city:    'Enter a City or Town please',
          address_1:  'Enter an address please',
          postcode:     'Enter postal code please',
          company: 'Enter your company name please',
        }

        var validated = {
          is_valid: true,
          messages: [],
        };

        for(var id in check){
          var item = this[id];
            if(!item){
              this.$refs[id].classList.add('error');
              validated.is_valid = false;
              validated.messages.push(check[id]);
            }
          }
        return validated;
      },
    }
  })
}
if(document.getElementById('search-field')){
  search_field = new Vue({
    'el' : '#search-field',
     data: {
       value: '',
       focused: false,
       user_id: -1,
       search_mode: 'customer',
     },

     watch: {
       // fires search value
       value: function(val){
        this.focused = true;
        var vm = this;

        // discard search only by digits in lists
        if(val.length < 2){
          if('undefined' != typeof(frontdesk_list)) {
            frontdesk_list.show_number = false;
          }

          if('undefined' != typeof(studio_app)) {
            studio_app.show_number = false;
          }
        }

        // search order by number
        if(val.search(/\D/) < 0 ){
          this.search_mode = 'order';
          if(val.length >= 2){
            if('undefined' != typeof(frontdesk_list)) {
              frontdesk_list.show_number = val;
            }

            if('undefined' != typeof(studio_app)) {
              studio_app.show_number = val;
            }
          }
        // search orderы by customer of brand
        }else{
          this.search_mode = 'customer';
          var search = this.all_customers.filter(e=>{
            return vm.value.toLowerCase() == e.name.toLowerCase();
          });

          if(search.length == 1){
            vm.value   = search[0].name;
            vm.user_id = search[0].user_id;

            Vue.nextTick(function(){
              vm.focused = false;
            })
          }
        }
       },
     },

     computed:{
       all_customers: function(){
        return all_customers;
       },

       _users_found: function(){
        var vm = this;

        if(vm.value.length >=2){
          var users = this.all_customers.filter(e=> {

            return (e.name.toLowerCase().indexOf(vm.value.toLowerCase()) >=0 || e.name.toLowerCase() == vm.value.toLowerCase())

             || e.brand.toLowerCase().indexOf(vm.value.toLowerCase()) >=0
          });

          return users;
        }

        return [];
       },

       users_found:function(){
         return this.focused? this._users_found : []
       }
     },

     mounted: function(){
      this.$refs.dropdown.classList.remove('visuallyhidden');
     },

     methods:{

      // search action on form submit
      exec_search: function(){
        var vm = this;
        vm.focused = false;

        if(vm.value.length < 2){
          alert('Enter some text to search, please. At least 3 symbols');
          return;
        }

        if(vm._users_found.length == 0 && vm.user_id < 0 && vm.search_mode == 'customer'){
          alert('No Customers found, please try another request');
          return;
        }

        block();
        slog('Search order by '+ vm.search_mode, 'blue');
        clog(vm.get_data());

        var data = {action: '', data: vm.get_data()};

        data.action = vm.search_mode == 'customer'? 'get_orders_by_user' : 'get_order_by_number';

        jQuery.ajax({
          url: WP_URLS.ajax,
          type: 'POST',
          dataType: 'json',
          data: data,
        })

        .done(function(e) {
          clog('response', 'green')

          if(e.search_mode == 'customer'){
            vm.apply_items_frontdesk(e.items, e.filters);
            vm.apply_items_studio(e.items, e.filters);
          }

          if(e.search_mode == 'order'){
            if(e.error){
              alert(e.error);
            }else{
              vm.may_be_add_item(e.item)
            }
          }
        })

        .fail(function(e) {
          alert('Search Failed');
        })

        .always(function(e) {
          clog(e);
          unblock();
          elog();
        });
      },

      get_data: function(){
        return {
          search_value:    this.value,
          user_id:         this.user_id,
          users_found:     this._users_found,
          search_mode:     this.search_mode,
        }
      },

      input: function(){
        if(typeof(this.value) == 'undefined') {
          this.value = '';
        }
      },

     // updates customer data;
      update_customer: function(customer){
        var vm = this;
        vm.value   = customer.name;
        vm.user_id = customer.user_id;

        Vue.nextTick(function(){
          vm.focused = false;
        })
      },

      // changes item data for studio after search
      // hides detailed view and shows list and filters
      apply_items_studio: function(_items, _filters){
        if('undefined' != typeof(studio_app)) {
          studio_app.visible.columns = true;
          studio_app.visible.filters = true;
          studio_app.$refs.detailed_view.visible = false;

          Vue.nextTick(function(){
            studio_app.items = _items;
            studio_app.filter_values = _filters;
          })
        }
      },

      // changes item data for frontdesk after search
      // hides detailed view and shows list and filters
      apply_items_frontdesk: function(_items, _filters){
        if('undefined' != typeof(frontdesk_list)) {
          frontdesk_list.visible = true;
          frontdesk_order_new.visible = false;
          frontdesk_order.visible = false;

          if(typeof(filters) == 'object'){
            filters.set_prop('visible', true);
          }

          Vue.nextTick(function(){
            frontdesk_list.items = _items;
            filters.filter_values = _filters;
          })
         }
       },


      may_be_add_item:function(item){
        if('undefined' != typeof(frontdesk_list)) {
          frontdesk_list.visible = true;
          frontdesk_order_new.visible = false;
          frontdesk_order.visible = false;

          Vue.nextTick(function(){
            frontdesk_list.may_be_add_item(item);
          });
        }

        if('undefined' != typeof(studio_app)) {
          studio_app.visible.columns = true;
          studio_app.visible.filters = true;
          studio_app.$refs.detailed_view.visible = false;

          Vue.nextTick(function(){
            studio_app.may_be_add_item(item);
          });
        }
      }
    },
  })
}
if(document.getElementById('studio-vue-app')){
  var studio_app = new Vue({
    el: '#studio-vue-app',
    mixins: [list_filter_mixin, get_item],
    data:{
      visible: {
        filters: true,
        columns: true,
      },

      only_with_messages: false,
      fasttrack: false,

      items:         studio_items,
      columns_data : studio_columns_data,

      filters: {
        team      : 'All Team',
      },

      filter_values: filter_values,
    },

    computed: {
      comment_count: function(){
        var comments_count = 0;
        var items = this.items;

        var __items = Object.values(items).filter(e=>{
          if(!e.data.wfp_images){
            return false;
          }

          var data = strip(e.data.wfp_images);

          if(typeof(data) == 'object'){
            data = Object.values(data);
          }
          var count = data.filter(e=>{
            return typeof(e.request) != 'undefined' && e.is_active == 0;
          }).map(
          e=>{return e.request.length}
          ).reduce((a, b) => a + b, 0);

          return count > 0;
        });

        return __items.length;
      },

      icons_selects: function(){
        return icons_selects;
      },

      items_by_load: function(){
        return 50;
      },
    },

    watch: {
      filter_values: function(val){
        this.$refs.team[0].set_value('options', val.team);
        this.$refs.team[0].set_value('selected', val.team[0]);
      },
    },

    beforeMount: function(){
    },

    mounted: function(){
      document.getElementById('site-body').classList.remove('not-ready');
    },

    methods:{
      /**
      * opens order details
      *
      * @variable data - object
      */
      open_order: function(_data){
        var item = this.get_item_by('order_id', _data.order_id);
        var item_index = this.get_index_of_item_by('order_id', _data.order_id);
        const data = strip(item.data);

        this.$refs.detailed_view.order_data = data;
        this.$refs.detailed_view.item_index = item_index;
        this.$refs.detailed_view.visible = true;

        this.visible.filters = false;
        this.visible.columns = false;
      },
      /**
      * updates order status
      *
      * @param order_id - string, id of order to update
      */
      update_order_status:function(order_id, order_status){
        if('undefined' === typeof(order_id) || !order_id){
          return false;
        }

        jQuery.ajax({
          url: WP_URLS.ajax,
          type: 'POST',
          dataType: 'json',
          data: {
            action       : 'save_order_status',
            order_id     : order_id,
            order_status : order_status,
          },
        })
        .always(function(e) {
          console.log(e);
        });
      },


      run_filter_list: function(data){
        if(data.val){
          this.filters[data.name] = data.val;
        }
      },

      update_item_data: function(data){
        this.items[data.index].data = data.order_data;
      },

      /**
      * gets element to update from items array
      * fires order_status_update function
      *
      * @param data - passed from emit object {order_id: value}
      *
      * @return void
      */
      update_order_status_on_drag_cb: function(data){
        var vm = this;

        var item = vm.get_item_by('order_id', data.order_id);

        Vue.nextTick(function(){
          if(item){
            vm.update_order_status(item.order_id, item.data.order_status);
          }
        })
      },

    },
  });
}
if(document.getElementById('popup_shoot')){
  popup_shoot = new Vue({
    'el' : '#popup_shoot',

    data:{
      visible: false,
      due_date: '',
      number_of_dates_left: {},
    },

    computed:{
      status: function(){
        var id = tracker_options['orders_misc']['shoot'];
        return tracker_options.orders[id].name;
      },

      color: function(){
        var id = tracker_options['orders_misc']['shoot'];
        return tracker_options.orders[id].bg_color;
      },

      due_date_formatted: function(){

      },
    },

    watch:{},

    methods: {
      submit: function(){
        studio_app.$refs.detailed_view.exec_start_shoot();
        this.visible = false;
      }
    },
  });
}
if(document.getElementById('popup_studio_errors')){
  popup_studio_errors = new Vue({
    'el' : '#popup_studio_errors',

    data:{
      visible: false,
      images_to_show: -1,
      images_uploaded: -1,
      errors: [],
    },

    watch:{
      visible:function(v){
        if(!v){
          this.images_to_show = -1;
          this.images_uploaded = -1;
          this.errors = {};
        }
      }
    },

    computed:{
      image_error:function(){
        var is_error = true;

        if(this.images_uploaded < 0 || this.images_to_show < 0){
          return false;
        }

        return this.images_uploaded < this.images_to_show;
      },
    },
  })
}
if(document.getElementById('popup_quality')){
  popup_quality = new Vue({
    'el' : '#popup_quality',

    data: {
      'visible' : false,
      'check_notes' : false,
      'check_sizes' : false,
      'check_product' : false,
    },

    watch: {
      visible : function(v){
        if(!v){
          this.check_notes  = false;
          this.check_sizes  = false;
          this.check_product  = false;
        }
      },

      check_notes: function(val){
        if(val){
          this.$refs.check_notes.classList.remove('error');
        }
      },

      check_sizes: function(val){
        if(val){
           this.$refs.check_sizes.classList.remove('error');
        }
      },

      check_product: function(val){
        if(val){
           this.$refs.check_product.classList.remove('error');
        }
      },
    },

    computed:{
      valid: function(){

        var check = [
          'check_notes',
          'check_sizes',
          'check_product',
        ];

        for(var index of check){
          if(!this[index]){
            this.$refs[index].classList.add('error');
          }else{
            this.$refs[index].classList.remove('error');
          }
        }

        return this.check_notes && this.check_sizes && this.check_product;
      },
    },

    methods: {
      submit: function(){
        if(!this.valid){
          return;
        }
        studio_app.$refs.detailed_view.exec_upload();
      },
    }
  });
}
ctime('vue script', 'green');