"use strict";(globalThis.webpackChunkwordpress_icon_chooser=globalThis.webpackChunkwordpress_icon_chooser||[]).push([[875],{875:(i,t,s)=>{s.r(t),s.d(t,{fa_icon:()=>n});var e=s(858),o=s(31);let n=class{constructor(i){(0,e.r)(this,i),this.pro=!1,this.loading=!1}setIconDefinition(i){this.iconDefinition=i,"function"==typeof this.emitIconDefinition&&this.emitIconDefinition(i)}componentWillLoad(){if(this.iconUpload)return void this.setIconDefinition({prefix:this.stylePrefix,iconName:this.iconUpload.name,icon:[parseInt(`${this.iconUpload.width}`),parseInt(`${this.iconUpload.height}`),[],this.iconUpload.unicode.toString(16),this.iconUpload.pathData]});if(this.icon)return void this.setIconDefinition(this.icon);if(!this.svgApi)return void console.error(`${o.C}: fa-icon: svgApi prop is needed but is missing`,this);if(!this.stylePrefix||!this.name)return void console.error(`${o.C}: fa-icon: the 'stylePrefix' and 'name' props are needed to render this icon but not provided.`,this);if(!this.familyStylePathSegment)return void console.error(`${o.C}: fa-icon: the 'familyStylePathSegment' prop is required to render this icon but not provided.`,this);const{findIconDefinition:i}=this.svgApi,t=i&&i({prefix:this.stylePrefix,iconName:this.name});if(t)return void this.setIconDefinition(t);if(!this.pro)return void console.error(`${o.C}: fa-icon: 'pro' prop is false but no free icon is available`,this);if(!this.svgFetchBaseUrl)return void console.error(`${o.C}: fa-icon: 'svgFetchBaseUrl' prop is absent but is necessary for fetching icon`,this);if(!this.kitToken)return void console.error(`${o.C}: fa-icon: 'kitToken' prop is absent but is necessary for accessing icon`,this);this.loading=!0;const s=`${this.svgFetchBaseUrl}/${this.familyStylePathSegment}/${this.name}.svg?token=${this.kitToken}`,e=o.l.get(this,"svgApi.library");"function"==typeof this.getUrlText?this.getUrlText(s).then((i=>{const t={iconName:this.name,prefix:this.stylePrefix,icon:(0,o.p)(i)};e&&e.add(t),this.setIconDefinition(Object.assign({},t))})).catch((i=>{console.error(`${o.C}: fa-icon: failed when using 'getUrlText' to fetch icon`,i,this)})).finally((()=>{this.loading=!1})):console.error(`${o.C}: fa-icon: 'getUrlText' prop is absent but is necessary for fetching icon`,this)}buildSvg(i,t){if(!i)return;const[s,n,,,r]=o.l.get(i,"icon",[]),h=["svg-inline--fa"];this.class&&h.push(this.class),t&&h.push(t),this.size&&h.push(`fa-${this.size}`);const c=h.join(" ");return Array.isArray(r)?(0,e.h)("svg",{class:c,xmlns:"http://www.w3.org/2000/svg",viewBox:`0 0 ${s} ${n}`},(0,e.h)("path",{fill:"currentColor",class:"fa-primary",d:r[1]}),(0,e.h)("path",{fill:"currentColor",class:"fa-secondary",d:r[0]})):(0,e.h)("svg",{class:c,xmlns:"http://www.w3.org/2000/svg",viewBox:`0 0 ${s} ${n}`},(0,e.h)("path",{fill:"currentColor",d:r}))}render(){return this.iconDefinition?this.buildSvg(this.iconDefinition):(0,e.h)(e.f,null)}};n.style=""}}]);