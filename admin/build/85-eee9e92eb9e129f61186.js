"use strict";(self.webpackChunkfont_awesome_admin=self.webpackChunkfont_awesome_admin||[]).push([[85],{85:(e,t,s)=>{s.r(t),s.d(t,{CONFLICT_DETECTION_SCANNER_DURATION_MIN:()=>d,addPendingOption:()=>y,checkPreferenceConflicts:()=>w,chooseAwayFromKitConfig:()=>A,chooseIntoKitConfig:()=>v,preprocessResponse:()=>N,queryKits:()=>M,reportDetectedConflicts:()=>F,resetOptionsFormState:()=>S,resetPendingBlocklistSubmissionStatus:()=>C,resetPendingOptions:()=>h,resetUnregisteredClientsDeletionStatus:()=>O,setActiveAdminTab:()=>L,setConflictDetectionScanner:()=>W,submitPendingBlocklist:()=>R,submitPendingOptions:()=>k,submitPendingUnregisteredClientDeletions:()=>D,updateApiToken:()=>U,updatePendingBlocklist:()=>P,updatePendingUnregisteredClientsForDeletion:()=>I,userAttemptToStopScanner:()=>b});var o=s(83),n=s(87),r=s(458),a=s(723);function i(e,t=0){let s=null,o=null;if("string"!=typeof e)return null;if(t>=e.length)return null;try{return s=JSON.parse(e.slice(t)),{start:t,parsed:s}}catch(s){const n=e.indexOf("[",t+1),r=e.indexOf("{",t+1);if(-1===n&&-1===r)return null;o=-1!==n&&-1!==r?n<r?n:r:-1!==r?r:n}return null===o?null:i(e,o)}const c=function(e){if(!e||""===e)return null;const t=i(e);if(null===t)return null;{const{start:s,parsed:o}=t;return{start:s,json:e.slice(s),trimmed:e.slice(0,s),parsed:o}}},u="wp-font-awesome-cache",l=o.A.create(),d=10,f=1,_=(0,a.__)("Couldn't save those changes","font-awesome"),p=(0,a.__)("Changes not saved because your WordPress server does not allow this kind of request. Look for details in the browser console.","font-awesome"),g=(0,a.__)("Couldn't check preferences","font-awesome"),E=(0,a.__)("A request to your WordPress server never received a response","font-awesome"),T=(0,a.__)("A request to your WordPress server failed","font-awesome"),m=(0,a.__)("Couldn't start the scanner","font-awesome");function N(e){const t=(0,n.has)(e,"headers.fontawesome-confirmation");if(204===e.status&&""!==e.data)return(0,r.Ay)({error:null,confirmed:t,trimmed:e.data,expectEmpty:!0}),e.data={},e;const s=(0,n.get)(e,"data",null),o="string"==typeof s&&(0,n.size)(s)>0,a=o?c(s):{};o&&a&&(e.data=(0,n.get)(a,"parsed"));const i=(0,n.get)(a,"trimmed",""),u=(0,n.get)(e,"data.errors",null);if(e.status>=400){if(u)e.uiMessage=(0,r.Ay)({error:e.data,confirmed:t,trimmed:i});else{const s=(0,n.get)(e,"config.method","").toUpperCase(),o=(0,n.get)(e,"config.url"),a=e.status,i=(0,n.get)(e,"statusText"),c=(0,r.b3)(e),u=(0,r.cA)((0,n.get)(e,"headers",{})),l=(0,r.cA)((0,n.get)(e,"config.headers",{})),d=(0,n.get)(e,"data");e.uiMessage=(0,r.Ay)({confirmed:t,requestData:c,requestMethod:s,requestUrl:o,responseHeaders:u,requestHeaders:l,responseStatus:a,responseStatusText:i,responseData:d}),405===a&&(e.uiMessage=p)}return e}if(e.status<400&&e.status>=300)return t&&""===i||(e.uiMessage=(0,r.Ay)({error:null,confirmed:t,trimmed:i})),e;if(u){const s=!0;return e.falsePositive=!0,e.uiMessage=(0,r.Ay)({error:e.data,confirmed:t,falsePositive:s,trimmed:i}),e}{const s=(0,n.get)(e,"data.error",null);return s?(e.uiMessage=(0,r.Ay)({error:s,ok:!0,confirmed:t,trimmed:i}),e):(t||(e.uiMessage=(0,r.Ay)({error:null,ok:!0,confirmed:t,trimmed:i})),e)}}function h(){return{type:"RESET_PENDING_OPTIONS"}}function S(){return{type:"OPTIONS_FORM_STATE_RESET"}}function y(e){return function(t,s){const{options:o}=s();for(const[s,r]of(0,n.toPairs)(e))t(o[s]===r?{type:"RESET_PENDING_OPTION",change:{[s]:r}}:{type:"ADD_PENDING_OPTION",change:{[s]:r}})}}function I(e=[]){return{type:"UPDATE_PENDING_UNREGISTERED_CLIENTS_FOR_DELETION",data:e}}function O(){return{type:"DELETE_UNREGISTERED_CLIENTS_RESET"}}function C(){return{type:"BLOCKLIST_UPDATE_RESET"}}function D(){return function(e,t){const{apiNonce:s,apiUrl:o,unregisteredClientsDeletionStatus:r}=t(),a=(0,n.get)(r,"pending",null);if(!a||0===(0,n.size)(a))return;e({type:"DELETE_UNREGISTERED_CLIENTS_START"});const i=({uiMessage:t})=>{e({type:"DELETE_UNREGISTERED_CLIENTS_END",success:!1,message:t||_})};return l.delete(`${o}/conflict-detection/conflicts`,{data:a,headers:{"X-WP-Nonce":s}}).then((t=>{const{status:s,data:o,falsePositive:n}=t;n?i(t):e({type:"DELETE_UNREGISTERED_CLIENTS_END",success:!0,data:204===s?null:o,message:""})})).catch(i)}}function P(e=[]){return{type:"UPDATE_PENDING_BLOCKLIST",data:e}}function R(){return function(e,t){const{apiNonce:s,apiUrl:o,blocklistUpdateStatus:r}=t(),a=(0,n.get)(r,"pending",null);if(!a)return;e({type:"BLOCKLIST_UPDATE_START"});const i=({uiMessage:t})=>{e({type:"BLOCKLIST_UPDATE_END",success:!1,message:t||_})};return l.post(`${o}/conflict-detection/conflicts/blocklist`,a,{headers:{"X-WP-Nonce":s}}).then((t=>{const{status:s,data:o,falsePositive:n}=t;n?i(t):e({type:"BLOCKLIST_UPDATE_END",success:!0,data:204===s?null:o,message:""})})).catch(i)}}function w(){return function(e,t){e({type:"PREFERENCE_CHECK_START"});const{apiNonce:s,apiUrl:o,options:n,pendingOptions:r}=t(),a=({uiMessage:t})=>{e({type:"PREFERENCE_CHECK_END",success:!1,message:t||g})};return l.post(`${o}/preference-check`,{...n,...r},{headers:{"X-WP-Nonce":s}}).then((t=>{const{data:s,falsePositive:o}=t;o?a(t):e({type:"PREFERENCE_CHECK_END",success:!0,message:"",detectedConflicts:s})})).catch(a)}}function A({activeKitToken:e}){return function(t,s){const{releases:o}=s();t({type:"CHOOSE_AWAY_FROM_KIT_CONFIG",activeKitToken:e,concreteVersion:(0,n.get)(o,"latest_version_6")})}}function v(){return{type:"CHOOSE_INTO_KIT_CONFIG"}}function M(){return function(e,t){const{apiNonce:s,apiUrl:o,options:r}=t(),i=(0,n.get)(r,"kitToken",null);e({type:"KITS_QUERY_START"}),function(){if(window?.localStorage&&0!=localStorage.length)for(let e=localStorage.length-1;e>=0;e--){const t=localStorage.key(e);t.startsWith(u)&&localStorage.removeItem(t)}}();const c=({uiMessage:t})=>{e({type:"KITS_QUERY_END",success:!1,message:t||(0,a.__)("Failed to fetch kits","font-awesome")})},d=({uiMessage:t})=>{e({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:t||(0,a.__)("Couldn't update latest kit settings","font-awesome")})};return l.post(`${o}/api`,"query { me { kits { name version technologySelected licenseSelected minified token shimEnabled autoAccessibilityEnabled status }}}",{headers:{"X-WP-Nonce":s}}).then((t=>{if(t.falsePositive)return c(t);const u=(0,n.get)(t,"data.data");if(!(0,n.get)(u,"me"))return e({type:"KITS_QUERY_END",success:!1,message:(0,a.__)("Failed to fetch kits. Regenerate your API Token and try again.","font-awesome")});if(e({type:"KITS_QUERY_END",data:u,success:!0}),!i)return;const f=(0,n.get)(u,"me.kits",[]),_=(0,n.find)(f,{token:i});if(!_)return;const p={};return r.usePro&&"pro"!==_.licenseSelected?p.usePro=!1:r.usePro||"pro"!==_.licenseSelected||(p.usePro=!0),"svg"===r.technology&&"svg"!==_.technologySelected?(p.technology="webfont",p.pseudoElements=!0):"svg"!==r.technology&&"svg"===_.technologySelected&&(p.technology="svg",p.pseudoElements=!1),r.version!==_.version&&(p.version=_.version),r.compat&&!_.shimEnabled?p.compat=!1:!r.compat&&_.shimEnabled&&(p.compat=!0),e({type:"OPTIONS_FORM_SUBMIT_START"}),l.post(`${o}/config`,{options:{...r,...p}},{headers:{"X-WP-Nonce":s}}).then((t=>{const{data:s,falsePositive:o}=t;if(o)return d(t);e({type:"OPTIONS_FORM_SUBMIT_END",data:s,success:!0,message:(0,a.__)("Kit changes saved","font-awesome")})})).catch(d)})).catch(c)}}function k(){return function(e,t){const{apiNonce:s,apiUrl:o,options:n,pendingOptions:r}=t();e({type:"OPTIONS_FORM_SUBMIT_START"});const i=({uiMessage:t})=>{e({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:t||_})};return l.post(`${o}/config`,{options:{...n,...r}},{headers:{"X-WP-Nonce":s}}).then((t=>{const{data:s,falsePositive:o}=t;o?i(t):e({type:"OPTIONS_FORM_SUBMIT_END",data:s,success:!0,message:(0,a.__)("Changes saved","font-awesome")})})).catch(i)}}function U({apiToken:e=!1,runQueryKits:t=!1}){return function(s,o){const{apiNonce:n,apiUrl:r,options:i}=o();s({type:"OPTIONS_FORM_SUBMIT_START"});const c=({uiMessage:e})=>{s({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:e||_})};return l.post(`${r}/config`,{options:{...i,apiToken:e}},{headers:{"X-WP-Nonce":n}}).then((e=>{const{data:o,falsePositive:n}=e;if(n)c(e);else if(s({type:"OPTIONS_FORM_SUBMIT_END",data:o,success:!0,message:(0,a.__)("API Token saved","font-awesome")}),t)return s(M())})).catch(c)}}function b(){return{type:"USER_STOP_SCANNER"}}function F({nodesTested:e={}}){return(t,s)=>{const{apiNonce:o,apiUrl:r,unregisteredClients:a,showConflictDetectionReporter:i}=s();if(i){if((0,n.size)(e.conflict)>0){const s=Object.keys(e.conflict).reduce((function(t,s){return t[s]=e.conflict[s],t}),{});t({type:"CONFLICT_DETECTION_SUBMIT_START",unregisteredClientsBeforeDetection:a,recentConflictsDetected:e.conflict});const i=({uiMessage:e})=>{t({type:"CONFLICT_DETECTION_SUBMIT_END",success:!1,message:e||_})};return l.post(`${r}/conflict-detection/conflicts`,s,{headers:{"X-WP-Nonce":o}}).then((e=>{const{status:s,data:o,falsePositive:r}=e;r?i(e):t({type:"CONFLICT_DETECTION_SUBMIT_END",success:!0,data:204===s||0===(0,n.size)(o)?null:o})})).catch(i)}t({type:"CONFLICT_DETECTION_NONE_FOUND"})}}}function L(e){return{type:"SET_ACTIVE_ADMIN_TAB",tab:e}}function W({enable:e=!0}){return function(t,s){const{apiNonce:o,apiUrl:n}=s(),r=e?"ENABLE_CONFLICT_DETECTION_SCANNER_END":"DISABLE_CONFLICT_DETECTION_SCANNER_END";t({type:e?"ENABLE_CONFLICT_DETECTION_SCANNER_START":"DISABLE_CONFLICT_DETECTION_SCANNER_START"});const a=({uiMessage:e})=>{t({type:r,success:!1,message:e||m})};return l.post(`${n}/conflict-detection/until`,e?Math.floor(new Date((new Date).valueOf()+1e3*d*60)/1e3):Math.floor(new Date/1e3)-f,{headers:{"X-WP-Nonce":o}}).then((e=>{const{status:s,data:o,falsePositive:n}=e;n?a(e):t({type:r,data:204===s?null:o,success:!0})})).catch(a)}}(0,a.__)("Couldn't snooze","font-awesome"),l.interceptors.response.use((e=>N(e)),(e=>{if(e.response)e.response=N(e.response),e.uiMessage=(0,n.get)(e,"response.uiMessage");else if(e.request){const t="fontawesome_request_noresponse",s={errors:{[t]:[E]},error_data:{[t]:{request:e.request}}};e.uiMessage=(0,r.Ay)({error:s})}else{const t="fontawesome_request_failed",s={errors:{[t]:[T]},error_data:{[t]:{failedRequestMessage:e.message}}};e.uiMessage=(0,r.Ay)({error:s})}return Promise.reject(e)}))},458:(e,t,s)=>{s.d(t,{Ay:()=>S,V2:()=>r,b3:()=>N,cA:()=>h});var o=s(87),n=s(723);const r=(0,n.__)("Font Awesome WordPress Plugin Error Report","font-awesome"),a=(0,n.__)("D'oh! That failed big time.","font-awesome"),i=(0,n.__)("There was an error attempting to report the error.","font-awesome"),c=(0,n.__)("Oh no! Your web browser could not reach your WordPress server.","font-awesome"),u=(0,n.__)("It looks like your web browser session expired. Try logging out and log back in to WordPress admin.","font-awesome"),l=(0,n.__)("The last request was successful, but it also returned the following error(s), which might be helpful for troubleshooting.","font-awesome"),d=(0,n.__)("Error","font-awesome"),f=(0,n.__)("WARNING: The last request contained errors, though your WordPress server reported it as a success. This usually means there's a problem with your theme or one of your other plugins emitting output that is causing problems.","font-awesome"),_=(0,n.__)("WARNING: The last response from your WordPress server did not include the confirmation header that should be in all valid Font Awesome responses. This is a clue that some code from another theme or plugin is acting badly and causing the wrong headers to be sent.","font-awesome"),p=(0,n.__)("CONFIRMED: The last response from your WordPress server included the confirmation header that is expected for all valid responses from the Font Awesome plugin's code running on your WordPress server.","font-awesome"),g=(0,n.__)("WARNING: Invalid Data Trimmed from Server Response","font-awesome"),E=(0,n.__)("WARNING: We expected the last response from the server to contain no data, but it contained something unexpected.","font-awesome"),T=(0,n.__)("Your WordPress server returned an error for that last request, but there was no information about the error.","font-awesome"),m=["requestMethod","responseStatus","responseStatusText","requestUrl","requestData","responseHeaders","responseData","requestHeaders"];function N(e={}){const t=(0,o.get)(e,"config.headers.Content-Type","").toLowerCase(),s=(0,o.get)(e,"config.data","");let n="";if("application/json"===t){try{const e=JSON.parse(s);"boolean"!=typeof(0,o.get)(e,"options.apiToken")&&(0,o.set)(e,"options.apiToken","REDACTED"),n=JSON.stringify(e)}catch(e){n=`ERROR while redacting request data: ${e.toString()}`}return n}return s}function h(e={}){const t={...e};for(const e in t)"x-wp-nonce"===e.toLowerCase()&&(t[e]="REDACTED");return t}const S=function(e){const{error:t=null,ok:s=!1,falsePositive:n=!1,confirmed:N=!1,expectEmpty:h=!1,trimmed:S=""}=e;console.group(r),s&&console.info(l),n&&console.info(f),N?console.info(p):console.info(_);const y=[];for(const t of m){const s=(0,o.get)(e,t);if(void 0!==s){const e=typeof s;if("string"===e||"number"===e)y.push(`${t}: ${s}`);else if("object"===e){y.push(`${t}:`);for(const e in s)y.push(`\t${e}: ${s[e].toString()}`)}else console.info(`Unexpected report content type '${e}' for ${t}:`,s)}}(0,o.size)(y)>0&&console.info(`Extra Info:\n${y.join("\n")}`),""!==S&&(console.group(g),h&&console.info(E),console.info(S),console.groupEnd());const I=null!==t?function(e={}){const t=Object.keys(e.errors||[]).map((t=>({code:t,message:(0,o.get)(e,`errors.${t}.0`),data:(0,o.get)(e,`error_data.${t}`)})));return 0===(0,o.size)(t)&&t.push({code:"fontawesome_unknown_error",message:i}),t.reduce(((e,t)=>{console.group(d);const s=function(e){if(!(0,o.get)(e,"code"))return console.info(i),a;let t=null,s="";const n=(0,o.get)(e,"message");n&&(s=s.concat(`message: ${n}\n`),t=n);const r=(0,o.get)(e,"code");if(r)switch(s=s.concat(`code: ${r}\n`),r){case"rest_no_route":t=c;break;case"rest_cookie_invalid_nonce":t=u;break;case"fontawesome_unknown_error":t=a}const l=(0,o.get)(e,"data");if("string"==typeof l)s=s.concat(`data: ${l}\n`);else{const t=(0,o.get)(e,"data.status");t&&(s=s.concat(`status: ${t}\n`));const n=(0,o.get)(e,"data.trace");n&&(s=s.concat(`trace:\n${n}\n`))}s&&""!==s?console.info(s):console.info(e);const d=(0,o.get)(e,"data.request");d&&console.info(d);const f=(0,o.get)(e,"data.failedRequestMessage");return f&&console.info(f),t}(t);return console.groupEnd(),e||"previous_exception"===t.code?e:s}),null)}(t):null;return t&&""===S&&N&&console.info(T),console.groupEnd(),I}}}]);