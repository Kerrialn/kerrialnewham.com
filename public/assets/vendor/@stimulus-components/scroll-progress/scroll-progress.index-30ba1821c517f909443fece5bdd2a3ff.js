/**
 * Bundled by jsDelivr using Rollup v2.79.1 and Terser v5.19.2.
 * Original file: /npm/@stimulus-components/scroll-progress@5.0.0/dist/stimulus-scroll-progress.mjs
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
import{Controller as t}from"@hotwired/stimulus";const e=class extends t{initialize(){this.scroll=this.scroll.bind(this)}connect(){this.throttleDelayValue>0&&(this.scroll=function(t,e){let l=!1;return(...s)=>{l||(t.apply(this,s),l=!0,setTimeout((()=>{l=!1}),e))}}(this.scroll,this.throttleDelayValue)),window.addEventListener("scroll",this.scroll,{passive:!0}),this.scroll()}disconnect(){window.removeEventListener("scroll",this.scroll)}scroll(){const t=document.documentElement.scrollHeight-document.documentElement.clientHeight,e=window.scrollY/t*100;this.element.style.width=`${e}%`}};e.values={throttleDelay:{type:Number,default:15}};let l=e;export{l as default};
