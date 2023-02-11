import{P as v,A as k,M as w,V as P,c as r,a as l,w as p,u as c,b as s,i as B,v as D,F as b,f as N,d as u,g,j as x,o,X as S,t,n as V}from"./app.5e913b12.js";import{_ as M,a as j}from"./Breadcrumb.6f6c19fb.js";import{_ as F}from"./Pagination.8c5f5a81.js";const K=s("title",null,"Product Management",-1),T={class:"px-4 grid gap-4"},$={class:"card w-full rounded-none border-2 border-info shadow-xl"},C={class:"card-body grid gap-4"},G={class:"flex justify-between items-center mb-4"},O={class:"form-control"},A={class:"card w-full rounded-none border-2 border-info shadow-xl"},E={class:"card-body grid gap-4"},I={class:"w-full text-left text-base"},J=s("thead",{class:"text-sm uppercase bg-primary/20"},[s("tr",null,[s("th",{class:"tw-w-[10rem]"}),s("th",{class:"py-3 px-6"},"#"),s("th",{class:"py-3 px-6"},"Barcode / Kode"),s("th",{class:"py-3 px-6"},"Nama Produk"),s("th",{class:"py-3 px-6"},"Deskripsi / Keterangan"),s("th",{class:"py-3 px-6"},"Kategori"),s("th",{class:"py-3 px-6"},"Satuan"),s("th",{class:"py-3 px-6"},"Stock"),s("th",{class:"py-3 px-6"},"Dibuat Oleh"),s("th",{class:"py-3 px-6"},"Dibuat pada")])],-1),L={class:"hover:cursor-pointer group border-b"},U=s("th",{class:"group-hover:bg-base-300 py-4 px-6"},null,-1),X={class:"group-hover:bg-base-300 py-4 px-6"},q={class:"group-hover:bg-base-300 py-4 px-6"},z={class:"group-hover:bg-base-300 py-4 px-6"},H={class:"group-hover:bg-base-300 py-4 px-6"},Q={class:"group-hover:bg-base-300 py-4 px-6"},R={class:"group-hover:bg-base-300 py-4 px-6"},W={class:"group-hover:bg-base-300 py-4 px-6"},Y={class:"group-hover:bg-base-300 py-4 px-6"},Z={class:"group-hover:bg-base-300 py-4 px-6"},ss={key:1},es={colspan:"6",class:"text-center border-b-2"},rs={__name:"ProductIndex",props:{search:String,products:{type:Object}},setup(y){const a=y,m=[{url:route("app.index"),label:"Beranda"},{url:route("app.management.index"),label:"Management"},{url:null,label:"Product"}],d=v({search:a.search});return k(d,w.exports.debounce(function(n){P.get(route("app.management.product.index"),{search:n.search},{preserveState:!0,replace:!0})},500),{deep:!0}),(n,i)=>(o(),r(b,null,[l(c(S),null,{default:p(()=>[K]),_:1}),l(j,{links:m}),l(M,{classes:"bg-base-content",class:""},{default:p(()=>[u("Product")]),_:1}),s("section",T,[s("div",$,[s("div",C,[s("div",G,[s("div",O,[B(s("input",{"onUpdate:modelValue":i[0]||(i[0]=e=>c(d).search=e),type:"text",placeholder:"Search\u2026",class:"input input-bordered"},null,512),[[D,c(d).search]])])])])]),s("div",A,[s("div",E,[s("table",I,[J,s("tbody",null,[a.products.data.length?(o(!0),r(b,{key:0},N(a.products.data,(e,f)=>{var h,_;return o(),r("tr",L,[U,s("th",X,t(a.products.from+f),1),s("td",q,t(e.barcode),1),s("td",z,t(e.name),1),s("td",H,t(e.description),1),s("td",Q,t(e.category),1),s("td",R,t(e.unit),1),s("td",W,[s("div",null,"Gudang : "+t((h=e.stock.warehouse)!=null?h:0),1),s("div",null,"Toko : "+t((_=e.stock.store)!=null?_:0),1)]),s("td",Y,t(e.created_by),1),s("td",Z,t(e.created_at),1)])}),256)):(o(),r("tr",ss,[s("td",es,[u("No Data "),a.products.current_page>1?(o(),g(c(V),{key:0,class:"link link-primary",href:n.route("app.management.product.index")},{default:p(()=>[u("Goto First Page")]),_:1},8,["href"])):x("",!0)])]))])]),a.products.data.length?(o(),g(F,{key:0,links:a.products.links},null,8,["links"])):x("",!0)])])])],64))}};export{rs as default};