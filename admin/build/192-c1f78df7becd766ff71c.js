"use strict";(self.webpackChunkfont_awesome_admin=self.webpackChunkfont_awesome_admin||[]).push([[192],{7192:(e,t,r)=>{r.r(t),r.d(t,{default:()=>E});var n=r(6645);const o=(e,t)=>{let r,n,o=e.path;return"string"==typeof e.namespace&&"string"==typeof e.endpoint&&(r=e.namespace.replace(/^\/|\/$/g,""),n=e.endpoint.replace(/^\//,""),o=n?r+"/"+n:r),delete e.namespace,delete e.endpoint,t({...e,path:o})};function a(e){const t=e.split("?"),r=t[1],n=t[0];return r?n+"?"+r.split("&").map((e=>e.split("="))).map((e=>e.map(decodeURIComponent))).sort(((e,t)=>e[0].localeCompare(t[0]))).map((e=>e.map(encodeURIComponent))).map((e=>e.join("="))).join("&"):n}function s(e){try{return decodeURIComponent(e)}catch(t){return e}}function c(e){return(function(e){let t;try{t=new URL(e,"http://example.com").search.substring(1)}catch(e){}if(t)return t}(e)||"").replace(/\+/g,"%20").split("&").reduce(((e,t)=>{const[r,n=""]=t.split("=").filter(Boolean).map(s);return r&&function(e,t,r){const n=t.length,o=n-1;for(let a=0;a<n;a++){let n=t[a];!n&&Array.isArray(e)&&(n=e.length.toString()),n=["__proto__","constructor","prototype"].includes(n)?n.toUpperCase():n;const s=!isNaN(Number(t[a+1]));e[n]=a===o?r:e[n]||(s?[]:{}),Array.isArray(e[n])&&!s&&(e[n]={...e[n]}),e=e[n]}}(e,r.replace(/\]/g,"").split("["),n),e}),Object.create(null))}function i(e){let t="";const r=Object.entries(e);let n;for(;n=r.shift();){let[e,o]=n;if(Array.isArray(o)||o&&o.constructor===Object){const t=Object.entries(o).reverse();for(const[n,o]of t)r.unshift([`${e}[${n}]`,o])}else void 0!==o&&(null===o&&(o=""),t+="&"+[e,o].map(encodeURIComponent).join("="))}return t.substr(1)}function p(e="",t){if(!t||!Object.keys(t).length)return e;let r=e;const n=e.indexOf("?");return-1!==n&&(t=Object.assign(c(e),t),r=r.substr(0,n)),r+"?"+i(t)}function u(e,t){return Promise.resolve(t?e.body:new window.Response(JSON.stringify(e.body),{status:200,statusText:"OK",headers:e.headers}))}const l=({path:e,url:t,...r},n)=>({...r,url:t&&p(t,n),path:e&&p(e,n)}),d=e=>e.json?e.json():Promise.reject(e),h=e=>{const{next:t}=(e=>{if(!e)return{};const t=e.match(/<([^>]+)>; rel="next"/);return t?{next:t[1]}:{}})(e.headers.get("link"));return t},f=async(e,t)=>{if(!1===e.parse)return t(e);if(!(e=>{const t=!!e.path&&-1!==e.path.indexOf("per_page=-1"),r=!!e.url&&-1!==e.url.indexOf("per_page=-1");return t||r})(e))return t(e);const r=await C({...l(e,{per_page:100}),parse:!1}),n=await d(r);if(!Array.isArray(n))return n;let o=h(r);if(!o)return n;let a=[].concat(n);for(;o;){const t=await C({...e,path:void 0,url:o,parse:!1}),r=await d(t);a=a.concat(r),o=h(t)}return a},m=new Set(["PATCH","PUT","DELETE"]),w="GET";function _(e,t){return c(e)[t]}function y(e,t){return void 0!==_(e,t)}const g=(e,t=!0)=>Promise.resolve(((e,t=!0)=>t?204===e.status?null:e.json?e.json():Promise.reject(e):e)(e,t)).catch((e=>j(e,t)));function j(e,t=!0){if(!t)throw e;return(e=>{const t={code:"invalid_json",message:(0,n.__)("The response is not a valid JSON response.")};if(!e||!e.json)throw t;return e.json().catch((()=>{throw t}))})(e).then((e=>{const t={code:"unknown_error",message:(0,n.__)("An unknown error occurred.")};throw e||t}))}function O(e,...t){const r=e.indexOf("?");if(-1===r)return e;const n=c(e),o=e.substr(0,r);t.forEach((e=>delete n[e]));const a=i(n);return a?o+"?"+a:o}const v={Accept:"application/json, */*;q=0.1"},b={credentials:"include"},P=[(e,t)=>("string"!=typeof e.url||y(e.url,"_locale")||(e.url=p(e.url,{_locale:"user"})),"string"!=typeof e.path||y(e.path,"_locale")||(e.path=p(e.path,{_locale:"user"})),t(e)),o,(e,t)=>{const{method:r=w}=e;return m.has(r.toUpperCase())&&(e={...e,headers:{...e.headers,"X-HTTP-Method-Override":r,"Content-Type":"application/json"},method:"POST"}),t(e)},f],T=e=>{if(e.status>=200&&e.status<300)return e;throw e};let x=e=>{const{url:t,path:r,data:o,parse:a=!0,...s}=e;let{body:c,headers:i}=e;return i={...v,...i},o&&(c=JSON.stringify(o),i["Content-Type"]="application/json"),window.fetch(t||r||window.location.href,{...b,...s,body:c,headers:i}).then((e=>Promise.resolve(e).then(T).catch((e=>j(e,a))).then((e=>g(e,a)))),(e=>{if(e&&"AbortError"===e.name)throw e;throw{code:"fetch_error",message:(0,n.__)("You are probably offline.")}}))};function A(e){return P.reduceRight(((e,t)=>r=>t(r,e)),x)(e).catch((t=>"rest_cookie_invalid_nonce"!==t.code?Promise.reject(t):window.fetch(A.nonceEndpoint).then(T).then((e=>e.text())).then((t=>(A.nonceMiddleware.nonce=t,A(e))))))}A.use=function(e){P.unshift(e)},A.setFetchHandler=function(e){x=e},A.createNonceMiddleware=function(e){const t=(e,r)=>{const{headers:n={}}=e;for(const o in n)if("x-wp-nonce"===o.toLowerCase()&&n[o]===t.nonce)return r(e);return r({...e,headers:{...n,"X-WP-Nonce":t.nonce}})};return t.nonce=e,t},A.createPreloadingMiddleware=function(e){const t=Object.fromEntries(Object.entries(e).map((([e,t])=>[a(e),t])));return(e,r)=>{const{parse:n=!0}=e;let o=e.path;if(!o&&e.url){const{rest_route:t,...r}=c(e.url);"string"==typeof t&&(o=p(t,r))}if("string"!=typeof o)return r(e);const s=e.method||"GET",i=a(o);if("GET"===s&&t[i]){const e=t[i];return delete t[i],u(e,!!n)}if("OPTIONS"===s&&t[s]&&t[s][i]){const e=t[s][i];return delete t[s][i],u(e,!!n)}return r(e)}},A.createRootURLMiddleware=e=>(t,r)=>o(t,(t=>{let n,o=t.url,a=t.path;return"string"==typeof a&&(n=e,-1!==e.indexOf("?")&&(a=a.replace("?","&")),a=a.replace(/^\//,""),"string"==typeof n&&-1!==n.indexOf("?")&&(a=a.replace("?","&")),o=n+a),r({...t,url:o})})),A.fetchAllMiddleware=f,A.mediaUploadMiddleware=(e,t)=>{if(!function(e){const t=!!e.method&&"POST"===e.method;return(!!e.path&&-1!==e.path.indexOf("/wp/v2/media")||!!e.url&&-1!==e.url.indexOf("/wp/v2/media"))&&t}(e))return t(e);let r=0;const o=e=>(r++,t({path:`/wp/v2/media/${e}/post-process`,method:"POST",data:{action:"create-image-subsizes"},parse:!1}).catch((()=>r<5?o(e):(t({path:`/wp/v2/media/${e}?force=true`,method:"DELETE"}),Promise.reject()))));return t({...e,parse:!1}).catch((t=>{const r=t.headers.get("x-wp-upload-attachment-id");return t.status>=500&&t.status<600&&r?o(r).catch((()=>!1!==e.parse?Promise.reject({code:"post_process",message:(0,n.__)("Media upload failed. If this is a photo or a large image, please scale it down and try again.")}):Promise.reject(t))):j(t,e.parse)})).then((t=>g(t,e.parse)))},A.createThemePreviewMiddleware=e=>(t,r)=>{if("string"==typeof t.url){const r=_(t.url,"wp_theme_preview");void 0===r?t.url=p(t.url,{wp_theme_preview:e}):""===r&&(t.url=O(t.url,"wp_theme_preview"))}if("string"==typeof t.path){const r=_(t.path,"wp_theme_preview");void 0===r?t.path=p(t.path,{wp_theme_preview:e}):""===r&&(t.path=O(t.path,"wp_theme_preview"))}return r(t)};const C=A,E=e=>async(t,r)=>{try{const{apiNonce:n,rootUrl:o,restApiNamespace:a}=e;return C.use(C.createRootURLMiddleware(o)),C.use(C.createNonceMiddleware(n)),await C({path:`${a}/api`,method:"POST",headers:{"content-type":"application/json"},body:JSON.stringify({query:t.replace(/\s+/g," "),variables:r})})}catch(e){throw console.error("CAUGHT:",e),new Error(e)}}}}]);