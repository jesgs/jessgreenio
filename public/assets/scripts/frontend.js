!function(t){var i={};function n(o){if(i[o])return i[o].exports;var s=i[o]={i:o,l:!1,exports:{}};return t[o].call(s.exports,s,s.exports,n),s.l=!0,s.exports}n.m=t,n.c=i,n.d=function(t,i,o){n.o(t,i)||Object.defineProperty(t,i,{configurable:!1,enumerable:!0,get:o})},n.n=function(t){var i=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(i,"a",i),i},n.o=function(t,i){return Object.prototype.hasOwnProperty.call(t,i)},n.p="",n(n.s=0)}([function(t,i,n){n(1),t.exports=n(2)},function(t,i,n){"use strict";var o,s;o=jQuery,(s={}).Sticky={init:function(){o(".js-sticky").each(function(){var t=o(this),i=t.outerHeight(),n=0;if(void 0!==t.data("elementStart")){var s=void 0!==t.data("elementStart")?o(t.data("elementStart")):null;n=0!==s.length?s.outerHeight():0}else n=void 0!==t.data("stickyStart")?t.data("stickyStart"):0;o(window).on("scroll",function(s){var e=window.innerWidth,r=o(this).scrollTop();e<=992||(r>i+n?(t.addClass("is-sticky"),t.is(".is-sticky--off")&&t.removeClass("is-sticky--off")):t.is(".is-sticky")&&0===r&&t.removeClass("is-sticky").addClass("is-sticky--off"))})}),o.fn.isInViewport=function(){var t=o(this).position().top,i=t+o(this).outerHeight(),n=o(window).scrollTop()+180;return i>n&&t<n},o(window).on("resize scroll",function(){o(".js-scroll-spy").each(function(){var t=o(this).attr("href"),i=o(t),n=window.innerWidth;i.isInViewport()&&n>992&&(o(this).is(".i-spy")||(o(this).parents("ul").find("a").removeClass("i-spy"),o(this).addClass("i-spy")))})}),o(".js-scroll-spy").on("click touchend",function(t){if(window.innerWidth>992){t.preventDefault();var i=o(o(this).attr("href"));o("html,body").animate({scrollTop:i.position().top-160+"px"},1e3,"swing")}})}},o(function(){s.Sticky.init()})},function(t,i){}]);
//# sourceMappingURL=frontend.js.map