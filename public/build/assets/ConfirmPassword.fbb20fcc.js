import{P as c,c as m,a as t,u as e,b as s,p as f,w as r,F as _,o as p,X as u,d,n as h}from"./app.1a1a22c1.js";import{_ as w}from"./Button.338dbc52.js";import{_ as b,a as x,b as v}from"./Label.24614602.js";const g={class:"hero min-h-screen max-w-5xl"},y={class:"hero-content flex-col lg:flex-row-reverse"},P=s("div",{class:"text-center lg:text-left"},[s("h1",{class:"text-5xl font-bold"},"Confirm Password"),s("p",{class:"py-6"},"This is a secure area of the application. Please confirm your password before continuing.")],-1),V={class:"card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100"},C=["onSubmit"],$={class:"card-body"},k={class:"form-control"},B={class:"form-control mt-6"},F=s("div",{class:"divider"},"OR",-1),q={__name:"ConfirmPassword",setup(N){const o=c({password:""}),i=()=>{o.post(route("password.confirm"),{onFinish:()=>o.reset()})};return(n,a)=>(p(),m(_,null,[t(e(u),{title:"Confirm Password"}),s("div",g,[s("div",y,[P,s("div",V,[s("form",{onSubmit:f(i,["prevent"])},[s("div",$,[s("div",k,[t(v,{for:"password",value:"Password"}),t(b,{id:"password",type:"password",class:"input-bordered",modelValue:e(o).password,"onUpdate:modelValue":a[0]||(a[0]=l=>e(o).password=l),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),t(x,{class:"mt-2",message:e(o).errors.password},null,8,["message"])]),s("div",B,[t(w,{disabled:e(o).processing,type:"submit",class:"btn-primary"},{default:r(()=>[d("Confirm")]),_:1},8,["disabled"]),F,t(e(h),{href:n.route("logout"),disabled:e(o).processing,method:"post",as:"button",class:"btn btn-error"},{default:r(()=>[d("Log Out")]),_:1},8,["href","disabled"])])])],40,C)])])])],64))}};export{q as default};