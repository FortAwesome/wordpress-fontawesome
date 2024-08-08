"use strict";(self.webpackChunkfont_awesome_admin=self.webpackChunkfont_awesome_admin||[]).push([[85],{7085:(e,t,s)=>{s.r(t),s.d(t,{CONFLICT_DETECTION_SCANNER_DURATION_MIN:()=>g,addPendingOption:()=>w,checkPreferenceConflicts:()=>F,chooseAwayFromKitConfig:()=>L,chooseIntoKitConfig:()=>W,preprocessResponse:()=>D,queryKits:()=>B,reportDetectedConflicts:()=>G,resetOptionsFormState:()=>R,resetPendingBlocklistSubmissionStatus:()=>M,resetPendingOptions:()=>P,resetUnregisteredClientsDeletionStatus:()=>v,setActiveAdminTab:()=>x,setConflictDetectionScanner:()=>H,submitPendingBlocklist:()=>b,submitPendingOptions:()=>q,submitPendingUnregisteredClientDeletions:()=>k,updateApiToken:()=>$,updatePendingBlocklist:()=>U,updatePendingUnregisteredClientsForDeletion:()=>A,userAttemptToStopScanner:()=>K});var o=s(1083),n=s(8938),r=s.n(n),a=s(7091),c=s.n(a),i=s(8156),u=s.n(i),l=s(7309),d=s.n(l),f=s(9458),_=s(7723);function p(e,t=0){let s=null,o=null;if("string"!=typeof e)return null;if(t>=e.length)return null;try{return s=JSON.parse(e.slice(t)),{start:t,parsed:s}}catch(s){const n=e.indexOf("[",t+1),r=e.indexOf("{",t+1);if(-1===n&&-1===r)return null;o=-1!==n&&-1!==r?n<r?n:r:-1!==r?r:n}return null===o?null:p(e,o)}const E=function(e){if(!e||""===e)return null;const t=p(e);if(null===t)return null;{const{start:s,parsed:o}=t;return{start:s,json:e.slice(s),trimmed:e.slice(0,s),parsed:o}}},T="wp-font-awesome-cache",m=o.A.create(),g=10,N=1,h=(0,_.__)("Couldn't save those changes","font-awesome"),S=(0,_.__)("Changes not saved because your WordPress server does not allow this kind of request. Look for details in the browser console.","font-awesome"),y=(0,_.__)("Couldn't check preferences","font-awesome"),I=(0,_.__)("A request to your WordPress server never received a response","font-awesome"),O=(0,_.__)("A request to your WordPress server failed","font-awesome"),C=(0,_.__)("Couldn't start the scanner","font-awesome");function D(e){const t=has(e,"headers.fontawesome-confirmation");if(204===e.status&&""!==e.data)return(0,f.Ay)({error:null,confirmed:t,trimmed:e.data,expectEmpty:!0}),e.data={},e;const s=u()(e,"data",null),o="string"==typeof s&&c()(s)>0,n=o?E(s):{};o&&n&&(e.data=u()(n,"parsed"));const r=u()(n,"trimmed",""),a=u()(e,"data.errors",null);if(e.status>=400){if(a)e.uiMessage=(0,f.Ay)({error:e.data,confirmed:t,trimmed:r});else{const s=u()(e,"config.method","").toUpperCase(),o=u()(e,"config.url"),n=e.status,r=u()(e,"statusText"),a=(0,f.b3)(e),c=(0,f.cA)(u()(e,"headers",{})),i=(0,f.cA)(u()(e,"config.headers",{})),l=u()(e,"data");e.uiMessage=(0,f.Ay)({confirmed:t,requestData:a,requestMethod:s,requestUrl:o,responseHeaders:c,requestHeaders:i,responseStatus:n,responseStatusText:r,responseData:l}),405===n&&(e.uiMessage=S)}return e}if(e.status<400&&e.status>=300)return t&&""===r||(e.uiMessage=(0,f.Ay)({error:null,confirmed:t,trimmed:r})),e;if(a){const s=!0;return e.falsePositive=!0,e.uiMessage=(0,f.Ay)({error:e.data,confirmed:t,falsePositive:s,trimmed:r}),e}{const s=u()(e,"data.error",null);return s?(e.uiMessage=(0,f.Ay)({error:s,ok:!0,confirmed:t,trimmed:r}),e):(t||(e.uiMessage=(0,f.Ay)({error:null,ok:!0,confirmed:t,trimmed:r})),e)}}function P(){return{type:"RESET_PENDING_OPTIONS"}}function R(){return{type:"OPTIONS_FORM_STATE_RESET"}}function w(e){return function(t,s){const{options:o}=s();for(const[s,n]of r()(e))t(o[s]===n?{type:"RESET_PENDING_OPTION",change:{[s]:n}}:{type:"ADD_PENDING_OPTION",change:{[s]:n}})}}function A(e=[]){return{type:"UPDATE_PENDING_UNREGISTERED_CLIENTS_FOR_DELETION",data:e}}function v(){return{type:"DELETE_UNREGISTERED_CLIENTS_RESET"}}function M(){return{type:"BLOCKLIST_UPDATE_RESET"}}function k(){return function(e,t){const{apiNonce:s,apiUrl:o,unregisteredClientsDeletionStatus:n}=t(),r=u()(n,"pending",null);if(!r||0===c()(r))return;e({type:"DELETE_UNREGISTERED_CLIENTS_START"});const a=({uiMessage:t})=>{e({type:"DELETE_UNREGISTERED_CLIENTS_END",success:!1,message:t||h})};return m.delete(`${o}/conflict-detection/conflicts`,{data:r,headers:{"X-WP-Nonce":s}}).then((t=>{const{status:s,data:o,falsePositive:n}=t;n?a(t):e({type:"DELETE_UNREGISTERED_CLIENTS_END",success:!0,data:204===s?null:o,message:""})})).catch(a)}}function U(e=[]){return{type:"UPDATE_PENDING_BLOCKLIST",data:e}}function b(){return function(e,t){const{apiNonce:s,apiUrl:o,blocklistUpdateStatus:n}=t(),r=u()(n,"pending",null);if(!r)return;e({type:"BLOCKLIST_UPDATE_START"});const a=({uiMessage:t})=>{e({type:"BLOCKLIST_UPDATE_END",success:!1,message:t||h})};return m.post(`${o}/conflict-detection/conflicts/blocklist`,r,{headers:{"X-WP-Nonce":s}}).then((t=>{const{status:s,data:o,falsePositive:n}=t;n?a(t):e({type:"BLOCKLIST_UPDATE_END",success:!0,data:204===s?null:o,message:""})})).catch(a)}}function F(){return function(e,t){e({type:"PREFERENCE_CHECK_START"});const{apiNonce:s,apiUrl:o,options:n,pendingOptions:r}=t(),a=({uiMessage:t})=>{e({type:"PREFERENCE_CHECK_END",success:!1,message:t||y})};return m.post(`${o}/preference-check`,{...n,...r},{headers:{"X-WP-Nonce":s}}).then((t=>{const{data:s,falsePositive:o}=t;o?a(t):e({type:"PREFERENCE_CHECK_END",success:!0,message:"",detectedConflicts:s})})).catch(a)}}function L({activeKitToken:e}){return function(t,s){const{releases:o}=s();t({type:"CHOOSE_AWAY_FROM_KIT_CONFIG",activeKitToken:e,concreteVersion:u()(o,"latest_version_6")})}}function W(){return{type:"CHOOSE_INTO_KIT_CONFIG"}}function B(){return function(e,t){const{apiNonce:s,apiUrl:o,options:n}=t(),r=u()(n,"kitToken",null);e({type:"KITS_QUERY_START"}),function(){if(window?.localStorage&&0!=localStorage.length)for(let e=localStorage.length-1;e>=0;e--){const t=localStorage.key(e);t.startsWith(T)&&localStorage.removeItem(t)}}();const a=({uiMessage:t})=>{e({type:"KITS_QUERY_END",success:!1,message:t||(0,_.__)("Failed to fetch kits","font-awesome")})},c=({uiMessage:t})=>{e({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:t||(0,_.__)("Couldn't update latest kit settings","font-awesome")})};return m.post(`${o}/api`,"query { me { kits { name version technologySelected licenseSelected minified token shimEnabled autoAccessibilityEnabled status }}}",{headers:{"X-WP-Nonce":s}}).then((t=>{if(t.falsePositive)return a(t);const i=u()(t,"data.data");if(!u()(i,"me"))return e({type:"KITS_QUERY_END",success:!1,message:(0,_.__)("Failed to fetch kits. Regenerate your API Token and try again.","font-awesome")});if(e({type:"KITS_QUERY_END",data:i,success:!0}),!r)return;const l=u()(i,"me.kits",[]),f=d()(l,{token:r});if(!f)return;const p={};return n.usePro&&"pro"!==f.licenseSelected?p.usePro=!1:n.usePro||"pro"!==f.licenseSelected||(p.usePro=!0),"svg"===n.technology&&"svg"!==f.technologySelected?(p.technology="webfont",p.pseudoElements=!0):"svg"!==n.technology&&"svg"===f.technologySelected&&(p.technology="svg",p.pseudoElements=!1),n.version!==f.version&&(p.version=f.version),n.compat&&!f.shimEnabled?p.compat=!1:!n.compat&&f.shimEnabled&&(p.compat=!0),e({type:"OPTIONS_FORM_SUBMIT_START"}),m.post(`${o}/config`,{options:{...n,...p}},{headers:{"X-WP-Nonce":s}}).then((t=>{const{data:s,falsePositive:o}=t;if(o)return c(t);e({type:"OPTIONS_FORM_SUBMIT_END",data:s,success:!0,message:(0,_.__)("Kit changes saved","font-awesome")})})).catch(c)})).catch(a)}}function q(){return function(e,t){const{apiNonce:s,apiUrl:o,options:n,pendingOptions:r}=t();e({type:"OPTIONS_FORM_SUBMIT_START"});const a=({uiMessage:t})=>{e({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:t||h})};return m.post(`${o}/config`,{options:{...n,...r}},{headers:{"X-WP-Nonce":s}}).then((t=>{const{data:s,falsePositive:o}=t;o?a(t):e({type:"OPTIONS_FORM_SUBMIT_END",data:s,success:!0,message:(0,_.__)("Changes saved","font-awesome")})})).catch(a)}}function $({apiToken:e=!1,runQueryKits:t=!1}){return function(s,o){const{apiNonce:n,apiUrl:r,options:a}=o();s({type:"OPTIONS_FORM_SUBMIT_START"});const c=({uiMessage:e})=>{s({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:e||h})};return m.post(`${r}/config`,{options:{...a,apiToken:e}},{headers:{"X-WP-Nonce":n}}).then((e=>{const{data:o,falsePositive:n}=e;if(n)c(e);else if(s({type:"OPTIONS_FORM_SUBMIT_END",data:o,success:!0,message:(0,_.__)("API Token saved","font-awesome")}),t)return s(B())})).catch(c)}}function K(){return{type:"USER_STOP_SCANNER"}}function G({nodesTested:e={}}){return(t,s)=>{const{apiNonce:o,apiUrl:n,unregisteredClients:r,showConflictDetectionReporter:a}=s();if(a){if(c()(e.conflict)>0){const s=Object.keys(e.conflict).reduce((function(t,s){return t[s]=e.conflict[s],t}),{});t({type:"CONFLICT_DETECTION_SUBMIT_START",unregisteredClientsBeforeDetection:r,recentConflictsDetected:e.conflict});const a=({uiMessage:e})=>{t({type:"CONFLICT_DETECTION_SUBMIT_END",success:!1,message:e||h})};return m.post(`${n}/conflict-detection/conflicts`,s,{headers:{"X-WP-Nonce":o}}).then((e=>{const{status:s,data:o,falsePositive:n}=e;n?a(e):t({type:"CONFLICT_DETECTION_SUBMIT_END",success:!0,data:204===s||0===c()(o)?null:o})})).catch(a)}t({type:"CONFLICT_DETECTION_NONE_FOUND"})}}}function x(e){return{type:"SET_ACTIVE_ADMIN_TAB",tab:e}}function H({enable:e=!0}){return function(t,s){const{apiNonce:o,apiUrl:n}=s(),r=e?"ENABLE_CONFLICT_DETECTION_SCANNER_END":"DISABLE_CONFLICT_DETECTION_SCANNER_END";t({type:e?"ENABLE_CONFLICT_DETECTION_SCANNER_START":"DISABLE_CONFLICT_DETECTION_SCANNER_START"});const a=({uiMessage:e})=>{t({type:r,success:!1,message:e||C})};return m.post(`${n}/conflict-detection/until`,e?Math.floor(new Date((new Date).valueOf()+1e3*g*60)/1e3):Math.floor(new Date/1e3)-N,{headers:{"X-WP-Nonce":o}}).then((e=>{const{status:s,data:o,falsePositive:n}=e;n?a(e):t({type:r,data:204===s?null:o,success:!0})})).catch(a)}}(0,_.__)("Couldn't snooze","font-awesome"),m.interceptors.response.use((e=>D(e)),(e=>{if(e.response)e.response=D(e.response),e.uiMessage=u()(e,"response.uiMessage");else if(e.request){const t="fontawesome_request_noresponse",s={errors:{[t]:[I]},error_data:{[t]:{request:e.request}}};e.uiMessage=(0,f.Ay)({error:s})}else{const t="fontawesome_request_failed",s={errors:{[t]:[O]},error_data:{[t]:{failedRequestMessage:e.message}}};e.uiMessage=(0,f.Ay)({error:s})}return Promise.reject(e)}))},9458:(e,t,s)=>{s.d(t,{Ay:()=>D,V2:()=>l,b3:()=>O,cA:()=>C});var o=s(8156),n=s.n(o),r=s(3560),a=s.n(r),c=s(7091),i=s.n(c),u=s(7723);const l=(0,u.__)("Font Awesome WordPress Plugin Error Report","font-awesome"),d=(0,u.__)("D'oh! That failed big time.","font-awesome"),f=(0,u.__)("There was an error attempting to report the error.","font-awesome"),_=(0,u.__)("Oh no! Your web browser could not reach your WordPress server.","font-awesome"),p=(0,u.__)("It looks like your web browser session expired. Try logging out and log back in to WordPress admin.","font-awesome"),E=(0,u.__)("The last request was successful, but it also returned the following error(s), which might be helpful for troubleshooting.","font-awesome"),T=(0,u.__)("Error","font-awesome"),m=(0,u.__)("WARNING: The last request contained errors, though your WordPress server reported it as a success. This usually means there's a problem with your theme or one of your other plugins emitting output that is causing problems.","font-awesome"),g=(0,u.__)("WARNING: The last response from your WordPress server did not include the confirmation header that should be in all valid Font Awesome responses. This is a clue that some code from another theme or plugin is acting badly and causing the wrong headers to be sent.","font-awesome"),N=(0,u.__)("CONFIRMED: The last response from your WordPress server included the confirmation header that is expected for all valid responses from the Font Awesome plugin's code running on your WordPress server.","font-awesome"),h=(0,u.__)("WARNING: Invalid Data Trimmed from Server Response","font-awesome"),S=(0,u.__)("WARNING: We expected the last response from the server to contain no data, but it contained something unexpected.","font-awesome"),y=(0,u.__)("Your WordPress server returned an error for that last request, but there was no information about the error.","font-awesome"),I=["requestMethod","responseStatus","responseStatusText","requestUrl","requestData","responseHeaders","responseData","requestHeaders"];function O(e={}){const t=n()(e,"config.headers.Content-Type","").toLowerCase(),s=n()(e,"config.data","");let o="";if("application/json"===t){try{const e=JSON.parse(s);"boolean"!=typeof n()(e,"options.apiToken")&&a()(e,"options.apiToken","REDACTED"),o=JSON.stringify(e)}catch(e){o=`ERROR while redacting request data: ${e.toString()}`}return o}return s}function C(e={}){const t={...e};for(const e in t)"x-wp-nonce"===e.toLowerCase()&&(t[e]="REDACTED");return t}const D=function(e){const{error:t=null,ok:s=!1,falsePositive:o=!1,confirmed:r=!1,expectEmpty:a=!1,trimmed:c=""}=e;console.group(l),s&&console.info(E),o&&console.info(m),r?console.info(N):console.info(g);const u=[];for(const t of I){const s=n()(e,t);if(void 0!==s){const e=typeof s;if("string"===e||"number"===e)u.push(`${t}: ${s}`);else if("object"===e){u.push(`${t}:`);for(const e in s)u.push(`\t${e}: ${s[e].toString()}`)}else console.info(`Unexpected report content type '${e}' for ${t}:`,s)}}i()(u)>0&&console.info(`Extra Info:\n${u.join("\n")}`),""!==c&&(console.group(h),a&&console.info(S),console.info(c),console.groupEnd());const O=null!==t?function(e={}){const t=Object.keys(e.errors||[]).map((t=>({code:t,message:n()(e,`errors.${t}.0`),data:n()(e,`error_data.${t}`)})));return 0===i()(t)&&t.push({code:"fontawesome_unknown_error",message:f}),t.reduce(((e,t)=>{console.group(T);const s=function(e){if(!n()(e,"code"))return console.info(f),d;let t=null,s="";const o=n()(e,"message");o&&(s=s.concat(`message: ${o}\n`),t=o);const r=n()(e,"code");if(r)switch(s=s.concat(`code: ${r}\n`),r){case"rest_no_route":t=_;break;case"rest_cookie_invalid_nonce":t=p;break;case"fontawesome_unknown_error":t=d}const a=n()(e,"data");if("string"==typeof a)s=s.concat(`data: ${a}\n`);else{const t=n()(e,"data.status");t&&(s=s.concat(`status: ${t}\n`));const o=n()(e,"data.trace");o&&(s=s.concat(`trace:\n${o}\n`))}s&&""!==s?console.info(s):console.info(e);const c=n()(e,"data.request");c&&console.info(c);const i=n()(e,"data.failedRequestMessage");return i&&console.info(i),t}(t);return console.groupEnd(),e||"previous_exception"===t.code?e:s}),null)}(t):null;return t&&""===c&&r&&console.info(y),console.groupEnd(),O}}}]);