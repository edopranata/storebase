import{P as h,z as f,c as i,a as o,u as s,b as e,p as _,j as p,w as n,F as v,o as a,X as g,d as r,n as w}from"./app.1a1a22c1.js";import{_ as b}from"./Button.338dbc52.js";const x={class:"hero min-h-screen max-w-5xl"},y={class:"hero-content flex-col lg:flex-row-reverse"},k=e("div",{class:"text-center lg:text-left"},[e("h1",{class:"text-5xl font-bold"},"Verify Email"),e("p",{class:"py-6"},"Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another. ")],-1),V={class:"card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100"},B=["onSubmit"],E={class:"card-body"},N={key:0,class:"alert alert-success shadow-lg"},S=e("div",null,[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"stroke-current flex-shrink-0 h-6 w-6",fill:"none",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"})]),e("span",null,"A new verification link has been sent to the email address you provided during registration.")],-1),j=[S],z={class:"form-control mt-6"},C=e("div",{class:"divider"},"OR",-1),O={__name:"VerifyEmail",props:{status:String},setup(l){const d=l,t=h(),c=()=>{t.post(route("verification.send"))},u=f(()=>d.status==="verification-link-sent");return(m,F)=>(a(),i(v,null,[o(s(g),{title:"Email Verification"}),e("div",x,[e("div",y,[k,e("div",V,[e("form",{onSubmit:_(c,["prevent"])},[e("div",E,[s(u)?(a(),i("div",N,j)):p("",!0),e("div",z,[o(b,{disabled:s(t).processing,type:"submit",class:"btn-primary"},{default:n(()=>[r("Resend Verification Email")]),_:1},8,["disabled"]),C,o(s(w),{href:m.route("logout"),disabled:s(t).processing,method:"post",as:"button",class:"btn btn-error"},{default:n(()=>[r("Log Out")]),_:1},8,["href","disabled"])])])],40,B)])])])],64))}};export{O as default};
