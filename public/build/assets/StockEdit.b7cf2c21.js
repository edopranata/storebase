import{P as f,A as k,N as v,U as w,c as d,a as u,w as l,u as r,b as s,i as j,v as S,F as g,f as A,d as n,g as i,j as p,o as e,X as N,t as a,V as B,_ as E,n as _}from"./app.1a1a22c1.js";import{_ as V,a as D}from"./Breadcrumb.856ee079.js";import{_ as C}from"./Pagination.d93b63bb.js";const $=s("title",null,"Stock Adjustment",-1),F={class:"px-4 grid gap-4"},O={class:"card w-full rounded-none border-2 border-info shadow-xl"},P={class:"card-body grid gap-4"},T={class:"flex justify-between items-center mb-4"},K={class:"form-control"},L={class:"card w-full rounded-none border-2 border-info shadow-xl"},M={class:"card-body grid gap-4"},U={class:"w-full text-left text-base"},z=s("thead",{class:"text-sm uppercase bg-primary/20"},[s("tr",null,[s("th",{class:"tw-w-[10rem]",rowspan:"2"}),s("th",{class:"py-3 px-6",rowspan:"2"},"#"),s("th",{class:"py-3 px-6",rowspan:"2"},"Barcode / Kode"),s("th",{class:"py-3 px-6",rowspan:"2"},"Nama Produk"),s("th",{class:"py-3 px-6",rowspan:"2"},"Kategori"),s("th",{class:"py-3 px-6 text-center border-b-1 border-gray-800",colspan:"3"},"Stock Adjustment"),s("th",{class:"py-3 px-6",rowspan:"2"},"Satuan"),s("th",{class:"py-3 px-6",rowspan:"2"},"Aksi")]),s("tr",null,[s("th",{class:"py-3 px-6"},"Opening"),s("th",{class:"py-3 px-6"},"Adjustment"),s("th",{class:"py-3 px-6"},"Ending")])],-1),G={class:"hover:cursor-pointer group border-b"},J=s("th",{class:"group-hover:bg-base-300 py-4 px-6"},null,-1),X={class:"group-hover:bg-base-300 py-4 px-6"},q={class:"group-hover:bg-base-300 py-4 px-6"},H={class:"group-hover:bg-base-300 py-4 px-6"},I={class:"group-hover:bg-base-300 py-4 px-6"},Q={class:"group-hover:bg-base-300 py-4 px-6"},R={class:"group-hover:bg-base-300 py-4 px-6"},W={class:"group-hover:bg-base-300 py-4 px-6"},Y={class:"group-hover:bg-base-300 py-4 px-6"},Z={class:"group-hover:bg-base-300 py-4 px-6"},ss={key:0,class:"alert alert-success p-2 shadow-lg rounded-none"},ts={key:1},es={colspan:"6",class:"text-center border-b-2"},ns={__name:"StockEdit",props:{search:String,adjustment:Object,products:{type:Object}},setup(m){const o=m,y=[{url:route("app.index"),label:"Beranda"},{url:route("app.management.index"),label:"Management"},{url:null,label:"Stock Adjustment"}],h=f({search:o.search});return k(h,v.exports.debounce(function(c){w.get(route("app.management.stock.edit",o.adjustment.id),{search:c.search},{preserveState:!0,replace:!0})},500),{deep:!0}),(c,b)=>(e(),d(g,null,[u(r(N),null,{default:l(()=>[$]),_:1}),u(D,{links:y}),u(V,{classes:"bg-base-content",class:""},{default:l(()=>[n("Stock Adjustment")]),_:1}),s("section",F,[s("div",O,[s("div",P,[s("div",T,[s("div",K,[j(s("input",{"onUpdate:modelValue":b[0]||(b[0]=t=>r(h).search=t),type:"text",placeholder:"Search\u2026",class:"input input-bordered"},null,512),[[S,r(h).search]])])])])]),s("div",L,[s("div",M,[s("table",U,[z,s("tbody",null,[o.products.data.length?(e(!0),d(g,{key:0},A(o.products.data,(t,x)=>(e(),d("tr",G,[J,s("th",X,a(o.products.from+x),1),s("td",q,a(t.barcode),1),s("td",H,a(t.name),1),s("td",I,a(t.category),1),s("td",Q,a(t.stock.total),1),s("td",R,a(t.stock.adjust),1),s("td",W,a(t.stock.ending),1),s("td",Y,a(t.unit),1),s("td",Z,[t.status?(e(),d("div",ss,[s("div",null,[u(E,{size:"20",path:r(B)},null,8,["path"]),n(" Done at "+a(t.status),1)])])):p("",!0),t.status?p("",!0):(e(),i(r(_),{key:1,as:"button",href:c.route("app.management.details.show",t.id),class:"btn rounded-none btn-sm btn-primary"},{default:l(()=>[n("Adjustment")]),_:2},1032,["href"])),t.status?p("",!0):(e(),i(r(_),{key:2,as:"button",href:c.route("app.management.stock.destroy",t.id),method:"DELETE",class:"btn rounded-none btn-sm btn-warning"},{default:l(()=>[n("Cocok")]),_:2},1032,["href"]))])]))),256)):(e(),d("tr",ts,[s("td",es,[n("No Data "),o.products.current_page>1?(e(),i(r(_),{key:0,class:"link link-primary",href:c.route("app.management.product.index")},{default:l(()=>[n("Goto First Page")]),_:1},8,["href"])):p("",!0)])]))])]),o.products.data.length?(e(),i(C,{key:0,links:o.products.links},null,8,["links"])):p("",!0)])])])],64))}};export{ns as default};
