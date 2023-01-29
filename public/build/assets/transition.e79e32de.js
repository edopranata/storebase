import{T as de,H as M,F as fe,J as N,K as T,D as S,y,z as A,E as k,C as E,I as G,A as ce}from"./app.8220ec02.js";function w(e,t,...r){if(e in t){let l=t[e];return typeof l=="function"?l(...r):l}let n=new Error(`Tried to handle "${e}" but there is no handler defined. Only defined handlers are: ${Object.keys(t).map(l=>`"${l}"`).join(", ")}.`);throw Error.captureStackTrace&&Error.captureStackTrace(n,w),n}var V=(e=>(e[e.None=0]="None",e[e.RenderStrategy=1]="RenderStrategy",e[e.Static=2]="Static",e))(V||{}),h=(e=>(e[e.Unmount=0]="Unmount",e[e.Hidden=1]="Hidden",e))(h||{});function I({visible:e=!0,features:t=0,ourProps:r,theirProps:n,...l}){var o;let a=pe(n,r),i=Object.assign(l,{props:a});if(e||t&2&&a.static)return $(i);if(t&1){let u=(o=a.unmount)==null||o?0:1;return w(u,{[0](){return null},[1](){return $({...l,props:{...a,hidden:!0,style:{display:"none"}}})}})}return $(i)}function $({props:e,attrs:t,slots:r,slot:n,name:l}){var o;let{as:a,...i}=J(e,["unmount","static"]),u=(o=r.default)==null?void 0:o.call(r,n),d={};if(n){let s=!1,c=[];for(let[p,f]of Object.entries(n))typeof f=="boolean"&&(s=!0),f===!0&&c.push(p);s&&(d["data-headlessui-state"]=c.join(" "))}if(a==="template"){if(u=z(u!=null?u:[]),Object.keys(i).length>0||Object.keys(t).length>0){let[s,...c]=u!=null?u:[];if(!ve(s)||c.length>0)throw new Error(['Passing props on "template"!',"",`The current component <${l} /> is rendering a "template".`,"However we need to passthrough the following props:",Object.keys(i).concat(Object.keys(t)).sort((p,f)=>p.localeCompare(f)).map(p=>`  - ${p}`).join(`
`),"","You can apply a few solutions:",['Add an `as="..."` prop, to ensure that we render an actual element instead of a "template".',"Render a single element as the child so that we can forward the props onto that element."].map(p=>`  - ${p}`).join(`
`)].join(`
`));return de(s,Object.assign({},i,d))}return Array.isArray(u)&&u.length===1?u[0]:u}return M(a,Object.assign({},i,d),{default:()=>u})}function z(e){return e.flatMap(t=>t.type===fe?z(t.children):[t])}function pe(...e){if(e.length===0)return{};if(e.length===1)return e[0];let t={},r={};for(let n of e)for(let l in n)l.startsWith("on")&&typeof n[l]=="function"?(r[l]!=null||(r[l]=[]),r[l].push(n[l])):t[l]=n[l];if(t.disabled||t["aria-disabled"])return Object.assign(t,Object.fromEntries(Object.keys(r).map(n=>[n,void 0])));for(let n in r)Object.assign(t,{[n](l,...o){let a=r[n];for(let i of a){if(l instanceof Event&&l.defaultPrevented)return;i(l,...o)}}});return t}function Ve(e){let t=Object.assign({},e);for(let r in t)t[r]===void 0&&delete t[r];return t}function J(e,t=[]){let r=Object.assign({},e);for(let n of t)n in r&&delete r[n];return r}function ve(e){return e==null?!1:typeof e.type=="string"||typeof e.type=="object"||typeof e.type=="function"}let me=0;function he(){return++me}function be(){return he()}var ge=(e=>(e.Space=" ",e.Enter="Enter",e.Escape="Escape",e.Backspace="Backspace",e.Delete="Delete",e.ArrowLeft="ArrowLeft",e.ArrowUp="ArrowUp",e.ArrowRight="ArrowRight",e.ArrowDown="ArrowDown",e.Home="Home",e.End="End",e.PageUp="PageUp",e.PageDown="PageDown",e.Tab="Tab",e))(ge||{});function x(e){var t;return e==null||e.value==null?null:(t=e.value.$el)!=null?t:e.value}let K=Symbol("Context");var F=(e=>(e[e.Open=0]="Open",e[e.Closed=1]="Closed",e))(F||{});function ye(){return Q()!==null}function Q(){return N(K,null)}function we(e){T(K,e)}const X=typeof window>"u"||typeof document>"u";function Ee(e){if(X)return null;if(e instanceof Node)return e.ownerDocument;if(e!=null&&e.hasOwnProperty("value")){let t=x(e);if(t)return t.ownerDocument}return document}let H=["[contentEditable=true]","[tabindex]","a[href]","area[href]","button:not([disabled])","iframe","input:not([disabled])","select:not([disabled])","textarea:not([disabled])"].map(e=>`${e}:not([tabindex='-1'])`).join(",");var Se=(e=>(e[e.First=1]="First",e[e.Previous=2]="Previous",e[e.Next=4]="Next",e[e.Last=8]="Last",e[e.WrapAround=16]="WrapAround",e[e.NoScroll=32]="NoScroll",e))(Se||{}),Ae=(e=>(e[e.Error=0]="Error",e[e.Overflow=1]="Overflow",e[e.Success=2]="Success",e[e.Underflow=3]="Underflow",e))(Ae||{}),Fe=(e=>(e[e.Previous=-1]="Previous",e[e.Next=1]="Next",e))(Fe||{});function Oe(e=document.body){return e==null?[]:Array.from(e.querySelectorAll(H)).sort((t,r)=>Math.sign((t.tabIndex||Number.MAX_SAFE_INTEGER)-(r.tabIndex||Number.MAX_SAFE_INTEGER)))}var Y=(e=>(e[e.Strict=0]="Strict",e[e.Loose=1]="Loose",e))(Y||{});function Le(e,t=0){var r;return e===((r=Ee(e))==null?void 0:r.body)?!1:w(t,{[0](){return e.matches(H)},[1](){let n=e;for(;n!==null;){if(n.matches(H))return!0;n=n.parentElement}return!1}})}function ze(e){e==null||e.focus({preventScroll:!0})}let Te=["textarea","input"].join(",");function xe(e){var t,r;return(r=(t=e==null?void 0:e.matches)==null?void 0:t.call(e,Te))!=null?r:!1}function Ne(e,t=r=>r){return e.slice().sort((r,n)=>{let l=t(r),o=t(n);if(l===null||o===null)return 0;let a=l.compareDocumentPosition(o);return a&Node.DOCUMENT_POSITION_FOLLOWING?-1:a&Node.DOCUMENT_POSITION_PRECEDING?1:0})}function Je(e,t,{sorted:r=!0,relativeTo:n=null,skipElements:l=[]}={}){var o;let a=(o=Array.isArray(e)?e.length>0?e[0].ownerDocument:document:e==null?void 0:e.ownerDocument)!=null?o:document,i=Array.isArray(e)?r?Ne(e):e:Oe(e);l.length>0&&(i=i.filter(v=>!l.includes(v))),n=n!=null?n:a.activeElement;let u=(()=>{if(t&5)return 1;if(t&10)return-1;throw new Error("Missing Focus.First, Focus.Previous, Focus.Next or Focus.Last")})(),d=(()=>{if(t&1)return 0;if(t&2)return Math.max(0,i.indexOf(n))-1;if(t&4)return Math.max(0,i.indexOf(n))+1;if(t&8)return i.length-1;throw new Error("Missing Focus.First, Focus.Previous, Focus.Next or Focus.Last")})(),s=t&32?{preventScroll:!0}:{},c=0,p=i.length,f;do{if(c>=p||c+p<=0)return 0;let v=d+c;if(t&16)v=(v+p)%p;else{if(v<0)return 3;if(v>=p)return 1}f=i[v],f==null||f.focus(s),c+=u}while(f!==a.activeElement);return t&6&&xe(f)&&f.select(),f.hasAttribute("tabindex")||f.setAttribute("tabindex","0"),2}function C(e,t,r){X||S(n=>{document.addEventListener(e,t,r),n(()=>document.removeEventListener(e,t,r))})}function Ke(e,t,r=A(()=>!0)){function n(o,a){if(!r.value||o.defaultPrevented)return;let i=a(o);if(i===null||!i.getRootNode().contains(i))return;let u=function d(s){return typeof s=="function"?d(s()):Array.isArray(s)||s instanceof Set?s:[s]}(e);for(let d of u){if(d===null)continue;let s=d instanceof HTMLElement?d:x(d);if(s!=null&&s.contains(i)||o.composed&&o.composedPath().includes(s))return}return!Le(i,Y.Loose)&&i.tabIndex!==-1&&o.preventDefault(),t(o,i)}let l=y(null);C("mousedown",o=>{var a,i;r.value&&(l.value=((i=(a=o.composedPath)==null?void 0:a.call(o))==null?void 0:i[0])||o.target)},!0),C("click",o=>{!l.value||(n(o,()=>l.value),l.value=null)},!0),C("blur",o=>n(o,()=>window.document.activeElement instanceof HTMLIFrameElement?window.document.activeElement:null),!0)}var Pe=(e=>(e[e.None=1]="None",e[e.Focusable=2]="Focusable",e[e.Hidden=4]="Hidden",e))(Pe||{});let Qe=k({name:"Hidden",props:{as:{type:[Object,String],default:"div"},features:{type:Number,default:1}},setup(e,{slots:t,attrs:r}){return()=>{let{features:n,...l}=e,o={"aria-hidden":(n&2)===2?!0:void 0,style:{position:"fixed",top:1,left:1,width:1,height:0,padding:0,margin:-1,overflow:"hidden",clip:"rect(0, 0, 0, 0)",whiteSpace:"nowrap",borderWidth:"0",...(n&4)===4&&(n&2)!==2&&{display:"none"}}};return I({ourProps:o,theirProps:l,slot:{},attrs:r,slots:t,name:"Hidden"})}}});function Z(){let e=[],t=[],r={enqueue(n){t.push(n)},addEventListener(n,l,o,a){return n.addEventListener(l,o,a),r.add(()=>n.removeEventListener(l,o,a))},requestAnimationFrame(...n){let l=requestAnimationFrame(...n);r.add(()=>cancelAnimationFrame(l))},nextFrame(...n){r.requestAnimationFrame(()=>{r.requestAnimationFrame(...n)})},setTimeout(...n){let l=setTimeout(...n);r.add(()=>clearTimeout(l))},add(n){e.push(n)},dispose(){for(let n of e.splice(0))n()},async workQueue(){for(let n of t.splice(0))await n()}};return r}function je(e){let t={called:!1};return(...r)=>{if(!t.called)return t.called=!0,e(...r)}}function D(e,...t){e&&t.length>0&&e.classList.add(...t)}function L(e,...t){e&&t.length>0&&e.classList.remove(...t)}var B=(e=>(e.Finished="finished",e.Cancelled="cancelled",e))(B||{});function $e(e,t){let r=Z();if(!e)return r.dispose;let{transitionDuration:n,transitionDelay:l}=getComputedStyle(e),[o,a]=[n,l].map(i=>{let[u=0]=i.split(",").filter(Boolean).map(d=>d.includes("ms")?parseFloat(d):parseFloat(d)*1e3).sort((d,s)=>s-d);return u});return o!==0?r.setTimeout(()=>t("finished"),o+a):t("finished"),r.add(()=>t("cancelled")),r.dispose}function W(e,t,r,n,l,o){let a=Z(),i=o!==void 0?je(o):()=>{};return L(e,...l),D(e,...t,...r),a.nextFrame(()=>{L(e,...r),D(e,...n),a.add($e(e,u=>(L(e,...n,...t),D(e,...l),i(u))))}),a.add(()=>L(e,...t,...r,...n,...l)),a.add(()=>i("cancelled")),a.dispose}function g(e=""){return e.split(" ").filter(t=>t.trim().length>1)}let R=Symbol("TransitionContext");var Ce=(e=>(e.Visible="visible",e.Hidden="hidden",e))(Ce||{});function De(){return N(R,null)!==null}function He(){let e=N(R,null);if(e===null)throw new Error("A <TransitionChild /> is used but it is missing a parent <TransitionRoot />.");return e}function Be(){let e=N(U,null);if(e===null)throw new Error("A <TransitionChild /> is used but it is missing a parent <TransitionRoot />.");return e}let U=Symbol("NestingContext");function P(e){return"children"in e?P(e.children):e.value.filter(({state:t})=>t==="visible").length>0}function ee(e){let t=y([]),r=y(!1);E(()=>r.value=!0),G(()=>r.value=!1);function n(o,a=h.Hidden){let i=t.value.findIndex(({id:u})=>u===o);i!==-1&&(w(a,{[h.Unmount](){t.value.splice(i,1)},[h.Hidden](){t.value[i].state="hidden"}}),!P(t)&&r.value&&(e==null||e()))}function l(o){let a=t.value.find(({id:i})=>i===o);return a?a.state!=="visible"&&(a.state="visible"):t.value.push({id:o,state:"visible"}),()=>n(o,h.Unmount)}return{children:t,register:l,unregister:n}}let te=V.RenderStrategy,Me=k({props:{as:{type:[Object,String],default:"div"},show:{type:[Boolean],default:null},unmount:{type:[Boolean],default:!0},appear:{type:[Boolean],default:!1},enter:{type:[String],default:""},enterFrom:{type:[String],default:""},enterTo:{type:[String],default:""},entered:{type:[String],default:""},leave:{type:[String],default:""},leaveFrom:{type:[String],default:""},leaveTo:{type:[String],default:""}},emits:{beforeEnter:()=>!0,afterEnter:()=>!0,beforeLeave:()=>!0,afterLeave:()=>!0},setup(e,{emit:t,attrs:r,slots:n,expose:l}){if(!De()&&ye())return()=>M(Ie,{...e,onBeforeEnter:()=>t("beforeEnter"),onAfterEnter:()=>t("afterEnter"),onBeforeLeave:()=>t("beforeLeave"),onAfterLeave:()=>t("afterLeave")},n);let o=y(null),a=y("visible"),i=A(()=>e.unmount?h.Unmount:h.Hidden);l({el:o,$el:o});let{show:u,appear:d}=He(),{register:s,unregister:c}=Be(),p={value:!0},f=be(),v={value:!1},_=ee(()=>{v.value||(a.value="hidden",c(f),t("afterLeave"))});E(()=>{let m=s(f);G(m)}),S(()=>{if(i.value===h.Hidden&&!!f){if(u&&a.value!=="visible"){a.value="visible";return}w(a.value,{hidden:()=>c(f),visible:()=>s(f)})}});let ne=g(e.enter),re=g(e.enterFrom),le=g(e.enterTo),q=g(e.entered),oe=g(e.leave),ae=g(e.leaveFrom),ie=g(e.leaveTo);E(()=>{S(()=>{if(a.value==="visible"){let m=x(o);if(m instanceof Comment&&m.data==="")throw new Error("Did you forget to passthrough the `ref` to the actual DOM node?")}})});function ue(m){let j=p.value&&!d.value,b=x(o);!b||!(b instanceof HTMLElement)||j||(v.value=!0,u.value&&t("beforeEnter"),u.value||t("beforeLeave"),m(u.value?W(b,ne,re,le,q,O=>{v.value=!1,O===B.Finished&&t("afterEnter")}):W(b,oe,ae,ie,q,O=>{v.value=!1,O===B.Finished&&(P(_)||(a.value="hidden",c(f),t("afterLeave")))})))}return E(()=>{ce([u],(m,j,b)=>{ue(b),p.value=!1},{immediate:!0})}),T(U,_),we(A(()=>w(a.value,{visible:F.Open,hidden:F.Closed}))),()=>{let{appear:m,show:j,enter:b,enterFrom:O,enterTo:Re,entered:Ue,leave:_e,leaveFrom:qe,leaveTo:We,...se}=e;return I({theirProps:se,ourProps:{ref:o},slot:{},slots:n,attrs:r,features:te,visible:a.value==="visible",name:"TransitionChild"})}}}),ke=Me,Ie=k({inheritAttrs:!1,props:{as:{type:[Object,String],default:"div"},show:{type:[Boolean],default:null},unmount:{type:[Boolean],default:!0},appear:{type:[Boolean],default:!1},enter:{type:[String],default:""},enterFrom:{type:[String],default:""},enterTo:{type:[String],default:""},entered:{type:[String],default:""},leave:{type:[String],default:""},leaveFrom:{type:[String],default:""},leaveTo:{type:[String],default:""}},emits:{beforeEnter:()=>!0,afterEnter:()=>!0,beforeLeave:()=>!0,afterLeave:()=>!0},setup(e,{emit:t,attrs:r,slots:n}){let l=Q(),o=A(()=>e.show===null&&l!==null?w(l.value,{[F.Open]:!0,[F.Closed]:!1}):e.show);S(()=>{if(![!0,!1].includes(o.value))throw new Error('A <Transition /> is used but it is missing a `:show="true | false"` prop.')});let a=y(o.value?"visible":"hidden"),i=ee(()=>{a.value="hidden"}),u=y(!0),d={show:o,appear:A(()=>e.appear||!u.value)};return E(()=>{S(()=>{u.value=!1,o.value?a.value="visible":P(i)||(a.value="hidden")})}),T(U,i),T(R,d),()=>{let s=J(e,["show","appear","unmount","onBeforeEnter","onBeforeLeave","onAfterEnter","onAfterLeave"]),c={unmount:e.unmount};return I({ourProps:{...c,as:"template"},theirProps:{},slot:{},slots:{...n,default:()=>[M(ke,{onBeforeEnter:()=>t("beforeEnter"),onAfterEnter:()=>t("afterEnter"),onBeforeLeave:()=>t("beforeLeave"),onAfterLeave:()=>t("afterLeave"),...r,...c,...s},n.default)]},attrs:{},features:te,visible:a.value==="visible",name:"Transition"})}}});export{ze as H,Ne as I,Se as N,Je as O,I as P,V as R,Ae as T,Ve as V,Pe as a,ge as b,we as c,Ie as d,X as e,Qe as f,Me as g,F as l,Ee as m,x as o,Q as p,Z as s,be as t,w as u,J as w,Ke as y};
