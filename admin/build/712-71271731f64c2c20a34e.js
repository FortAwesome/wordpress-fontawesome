(self.webpackChunkfont_awesome_admin=self.webpackChunkfont_awesome_admin||[]).push([[712],{5500:(e,o,t)=>{var n={"./fa-icon-chooser.entry.js":[4191,888,191],"./fa-icon.entry.js":[2875,888,875]};function r(e){if(!t.o(n,e))return Promise.resolve().then((()=>{var o=new Error("Cannot find module '"+e+"'");throw o.code="MODULE_NOT_FOUND",o}));var o=n[e],r=o[0];return Promise.all(o.slice(1).map(t.e)).then((()=>t(r)))}r.keys=()=>Object.keys(n),r.id=5500,e.exports=r},5068:(e,o,t)=>{"use strict";t.r(o),t.d(o,{setupIconChooser:()=>E});var n=t(8156),r=t.n(n),s=t(1609),a=t(6427),i=t(7523),l=t(7723),c=t(4627);const m=e=>{const{onSubmit:o,kitToken:t,version:n,pro:r,handleQuery:m,modalOpenEvent:d,getUrlText:h,settingsPageUrl:u}=e,[f,w]=(0,s.useState)(!1);document.addEventListener(d.type,(()=>w(!0)));const p=()=>w(!1),g=!!r&&!t;return(0,s.createElement)(s.Fragment,null,f&&(0,s.createElement)(a.Modal,{title:"Add a Font Awesome Icon",onRequestClose:p},g&&(0,s.createElement)("div",{style:{margin:"1em",backgroundColor:"#FFD200",padding:"1em",borderRadius:".5em",fontSize:"15px"}},(0,l.__)("Looking for Pro icons and styles? You’ll need to use a kit. ","font-awesome"),(0,s.createElement)("a",{href:u},(0,l.__)("Go to Font Awesome Plugin Settings","font-awesome"))),(0,s.createElement)(i.s,{version:n,kitToken:t,handleQuery:m,getUrlText:h,onFinish:e=>(e=>{"function"==typeof o&&o(e),p()})(e),searchInputPlaceholder:(0,l.__)("Find icons by name, category, or keyword","font-awesome")},(0,s.createElement)("span",{slot:"fatal-error-heading"},(0,l.__)("Well, this is awkward...","font-awesome")),(0,s.createElement)("span",{slot:"fatal-error-detail"},(0,l.__)("Something has gone horribly wrong. Check the console for additional error information.","font-awesome")),(0,s.createElement)("span",{slot:"start-view-heading"},(0,l.__)("Font Awesome is the web's most popular icon set, with tons of icons in a variety of styles.","font-awesome")),(0,s.createElement)("span",{slot:"start-view-detail"},(0,c.A)((0,l.__)("Not sure where to start? Here are some favorites, or try a search for <strong>spinners</strong>, <strong>shopping</strong>, <strong>food</strong>, or <strong>whatever you're looking for</strong>.","font-awesome"),{strong:(0,s.createElement)("strong",null)})),(0,s.createElement)("span",{slot:"search-field-label-free"},(0,l.__)("Search Font Awesome Free Icons in Version","font-awesome")),(0,s.createElement)("span",{slot:"search-field-label-pro"},(0,l.__)("Search Font Awesome Pro Icons in Version","font-awesome")),(0,s.createElement)("span",{slot:"searching-free"},(0,l.__)("You're searching Font Awesome Free icons in version","font-awesome")),(0,s.createElement)("span",{slot:"searching-pro"},(0,l.__)("You're searching Font Awesome Pro icons in version","font-awesome")),(0,s.createElement)("span",{slot:"light-requires-pro"},(0,l.__)("You need to use a Pro kit to get Light icons.","font-awesome")),(0,s.createElement)("span",{slot:"thin-requires-pro"},(0,l.__)("You need to use a Pro kit with Version 6 to get Thin icons.","font-awesome")),(0,s.createElement)("span",{slot:"duotone-requires-pro"},(0,l.__)("You need to use a Pro kit with Version 5.10 or later to get Duotone icons.","font-awesome")),(0,s.createElement)("span",{slot:"uploaded-requires-pro"},(0,l.__)("You need to use a Pro kit to get Uploaded icons.","font-awesome")),(0,s.createElement)("span",{slot:"kit-has-no-uploaded-icons"},(0,l.__)("This kit contains no uploaded icons.","font-awesome")),(0,s.createElement)("span",{slot:"no-search-results-heading"},(0,l.__)("Sorry, we couldn't find anything for that.","font-awesome")),(0,s.createElement)("span",{slot:"no-search-results-detail"},(0,l.__)("You might try a different search...","font-awesome")),(0,s.createElement)("span",{slot:"suggest-icon-upload"},(0,c.A)((0,l.__)("Or <a>upload your own icon</a> to a Pro kit!","font-awesome"),{a:(0,s.createElement)("a",{target:"_blank",rel:"noopener noreferrer",href:"https://fontawesome.com/v5.15/how-to-use/on-the-web/using-kits/uploading-icons"})})),(0,s.createElement)("span",{slot:"get-fontawesome-pro"},(0,c.A)((0,l.__)("Or <a>use Font Awesome Pro</a> for more icons and styles!","font-awesome"),{a:(0,s.createElement)("a",{target:"_blank",rel:"noopener noreferrer",href:"https://fontawesome.com/"})})),(0,s.createElement)("span",{slot:"initial-loading-view-heading"},(0,l.__)("Fetching icons","font-awesome")),(0,s.createElement)("span",{slot:"initial-loading-view-detail"},(0,l.__)("When this thing gets up to 88 mph...","font-awesome")))))};function d(e){const o=[];if(!e.iconName)return void console.error("Font Awesome Icon Chooser: missing required iconName attribute for shortcode");o.push(`name="${e.iconName}"`);const t=["prefix","style","class","aria-hidden","aria-label","aria-labelledby","title","role"];for(const n of t){const t=r()(e,n);t&&o.push(`${n}="${t}"`)}return`[icon ${o.join(" ")}]`}var h=t(6087),u=t(876),f=t(4715),w=t(5795),p=t.n(w);function g(e){const o=r()(window,"wp.media.editor.insert");o&&o(d(e.detail))}let _=!1;function E(e){const o={...e,modalOpenEvent:new Event("fontAwesomeIconChooserOpen",{bubbles:!0,cancelable:!1})};return window.__FontAwesomeOfficialPlugin__openIconChooserModal=()=>{document.dispatchEvent(o.modalOpenEvent)},r()(e,"isGutenbergPage")&&function(e){const o="font-awesome/icon",t=(0,l.__)("Font Awesome Icon"),{modalOpenEvent:n,kitToken:r,version:i,pro:c,handleQuery:w,getUrlText:p,settingsPageUrl:g}=e;(0,u.registerFormatType)(o,{name:o,title:(0,l.__)("Font Awesome Icon"),keywords:[(0,l.__)("icon"),(0,l.__)("font awesome")],tagName:"i",className:null,object:!1,edit:class extends h.Component{constructor(e){super(...arguments),this.handleFormatButtonClick=this.handleFormatButtonClick.bind(this),this.handleSelect=this.handleSelect.bind(this)}handleFormatButtonClick(){document.dispatchEvent(n)}handleSelect(e){const{value:o,onChange:t}=this.props;if(!e.detail)return;const n=d(e.detail);t((0,u.insert)(o,n))}render(){return(0,s.createElement)(h.Fragment,null,(0,s.createElement)(f.RichTextToolbarButton,{icon:(0,s.createElement)(a.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 448 512",className:"svg-inline--fa fa-font-awesome fa-w-14"},(0,s.createElement)(a.Path,{fill:"currentColor",d:"M397.8 32H50.2C22.7 32 0 54.7 0 82.2v347.6C0 457.3 22.7 480 50.2 480h347.6c27.5 0 50.2-22.7 50.2-50.2V82.2c0-27.5-22.7-50.2-50.2-50.2zm-45.4 284.3c0 4.2-3.6 6-7.8 7.8-16.7 7.2-34.6 13.7-53.8 13.7-26.9 0-39.4-16.7-71.7-16.7-23.3 0-47.8 8.4-67.5 17.3-1.2.6-2.4.6-3.6 1.2V385c0 1.8 0 3.6-.6 4.8v1.2c-2.4 8.4-10.2 14.3-19.1 14.3-11.3 0-20.3-9-20.3-20.3V166.4c-7.8-6-13.1-15.5-13.1-26.3 0-18.5 14.9-33.5 33.5-33.5 18.5 0 33.5 14.9 33.5 33.5 0 10.8-4.8 20.3-13.1 26.3v18.5c1.8-.6 3.6-1.2 5.4-2.4 18.5-7.8 40.6-14.3 61.5-14.3 22.7 0 40.6 6 60.9 13.7 4.2 1.8 8.4 2.4 13.1 2.4 22.7 0 47.8-16.1 53.8-16.1 4.8 0 9 3.6 9 7.8v140.3z"})),title:t,onClick:this.handleFormatButtonClick}),(0,s.createElement)(m,{modalOpenEvent:n,kitToken:r,version:i,pro:c,settingsPageUrl:g,handleQuery:w,onSubmit:this.handleSelect,getUrlText:p}))}}})}(o),{setupClassicEditorIconChooser:()=>function(e){_||window.tinymce&&(function(e){const{iconChooserContainerId:o,modalOpenEvent:n,kitToken:r,version:a,pro:i,handleQuery:l,getUrlText:c,settingsPageUrl:d}=e,h=document.querySelector(`#${o}`);if(!h)return;if(!window.tinymce)return;let u=!1;u||(u=!0,Promise.resolve().then(t.t.bind(t,4990,23)).then((()=>{})).catch((e=>console.error("Font Awesome Plugin failed to load styles for the Icon Chooser in the Classic Editor",e)))),p().render((0,s.createElement)(m,{kitToken:r,version:a,pro:i,modalOpenEvent:n,handleQuery:l,settingsPageUrl:d,onSubmit:g,getUrlText:c}),h)}({...e,iconChooserContainerId:"font-awesome-icon-chooser-container",iconChooserMediaButtonClass:"font-awesome-icon-chooser-media-button"}),_=!0)}(o)}}},4627:(e,o,t)=>{"use strict";t.d(o,{A:()=>n});const n=t(6087).createInterpolateElement}}]);