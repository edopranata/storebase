import{u as p,c as u,a as e,b as a,d as o,w,e as _,F as f,o as b,H as h,f as x}from"./app.72997376.js";import{_ as g}from"./Button.37e1d8c4.js";import{_ as l,a as d,b as i}from"./Label.604b65a5.js";const v={class:"hero min-h-screen max-w-3xl"},V={class:"hero-content flex-col lg:flex-row-reverse"},y=o("div",{class:"text-center lg:text-left"},[o("h1",{class:"text-5xl font-bold"},"Reset password!"),o("p",{class:"py-6"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ")],-1),k={class:"card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100"},F=["onSubmit"],P={class:"card-body"},N={class:"form-control"},R={class:"form-control"},S={class:"form-control"},$={class:"form-control mt-6"},E={__name:"ResetPassword",props:{email:String,token:String},setup(m){const n=m,s=p({token:n.token,email:n.email,password:"",password_confirmation:""}),c=()=>{s.post(route("password.update"),{onFinish:()=>s.reset("password","password_confirmation")})};return(q,r)=>(b(),u(f,null,[e(a(h),{title:"Reset Password"}),o("div",v,[o("div",V,[y,o("div",k,[o("form",{onSubmit:w(c,["prevent"])},[o("div",P,[o("div",N,[e(i,{for:"email",value:"Email"}),e(l,{id:"email",type:"email",class:"input-bordered",modelValue:a(s).email,"onUpdate:modelValue":r[0]||(r[0]=t=>a(s).email=t),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),e(d,{class:"mt-2",message:a(s).errors.email},null,8,["message"])]),o("div",R,[e(i,{for:"password",value:"Password"}),e(l,{id:"password",type:"password",class:"input-bordered",modelValue:a(s).password,"onUpdate:modelValue":r[1]||(r[1]=t=>a(s).password=t),required:"",autocomplete:"new-password"},null,8,["modelValue"]),e(d,{class:"mt-2",message:a(s).errors.password},null,8,["message"])]),o("div",S,[e(i,{for:"password_confirmation",value:"Confirm Password"}),e(l,{id:"password_confirmation",type:"password",class:"input-bordered",modelValue:a(s).password_confirmation,"onUpdate:modelValue":r[2]||(r[2]=t=>a(s).password_confirmation=t),required:"",autocomplete:"new-password"},null,8,["modelValue"]),e(d,{class:"mt-2",message:a(s).errors.password_confirmation},null,8,["message"])]),o("div",$,[e(g,{disabled:a(s).processing,type:"submit",class:"btn-primary"},{default:_(()=>[x("Reset Password")]),_:1},8,["disabled"])])])],40,F)])])])],64))}};export{E as default};
