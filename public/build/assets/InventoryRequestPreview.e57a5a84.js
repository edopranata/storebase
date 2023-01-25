import{D as I,h as m,A as _,C as D,c as o,a as u,w as x,u as w,b as t,F as n,e as h,o as c,H as F,d as N,t as e,j as B,J as y}from"./app.efba5474.js";import"./multiselect.d899e918.js";import{_ as P,a as R}from"./Breadcrumb.fe2f7d4a.js";const k=t("title",null,"Inventory Product",-1),q={class:"px-2 grid gap-4 mt-4"},H={class:"grid"},T={class:"card w-full rounded-none border-2 border-info shadow-xl"},V={class:"card-body"},C={class:"w-full text-left text-base min-w-4xl"},Q=t("thead",{class:"text-sm uppercase bg-primary/40"},[t("tr",null,[t("th",{class:"py-3 px-6"},"#"),t("th",{class:"py-3 px-6"},"Product"),t("th",{class:"py-3 px-6"},"Jumlah Beli"),t("th",{class:"py-3 px-6"},"Qty Terkecil"),t("th",{class:"py-3 px-6 text-right"},"Harga Modal"),t("th",{class:"py-3 px-6 text-right"},"Total")])],-1),S={class:"hover:cursor-pointer"},j={class:"group-hover:bg-base-300 py-2 px-4"},J={class:"group-hover:bg-base-300 py-2 px-4"},M={class:"group-hover:bg-base-300 py-2 px-4"},$={class:"group-hover:bg-base-300 py-2 px-4"},A={class:"group-hover:bg-base-300 py-2 px-4 text-right"},E={class:"group-hover:bg-base-300 py-2 px-4 text-right"},L=t("tr",{class:"text-xs"},[t("td",{class:"bg-primary/20 px-4 text-sm"}),t("td",{class:"bg-primary/20 px-4 text-sm text-right"},"Supplier"),t("td",{class:"bg-primary/20 px-4 text-sm"},"Qty Beli"),t("td",{class:"bg-primary/20 px-4 text-sm"},"Qty Sisa"),t("td",{class:"bg-primary/20 px-4 text-sm text-right"},"Harga Beli"),t("td",{class:"bg-primary/20 px-4 text-sm text-right"},"Total")],-1),O={key:0,class:"text-xs"},z=t("td",{class:"bg-primary/10 px-4 text-sm"},null,-1),G={class:"bg-primary/10 px-4 text-sm text-right"},K={class:"bg-primary/10 px-4 text-sm"},U={class:"bg-primary/10 px-4 text-sm"},W={class:"bg-primary/10 px-4 text-sm text-right"},X={class:"bg-primary/10 px-4 text-sm text-right"},et={__name:"InventoryRequestPreview",props:{purchases:Object},setup(b){const i=b,g=[{url:route("app.index"),label:"Beranda"},{url:route("app.inventory.index"),label:"Inventory"},{url:route("app.inventory.request.index"),label:"Inventory Product"},{url:null,label:"Preview"}];I({data:i.purchases});const f=m({id:""}),d=m({purchase_id:i.purchases.id,bill:"",payment:"",fund:""});_(()=>y.cloneDeep(f.id),(r,p)=>{r&&addProduct(r)}),_(()=>y.cloneDeep(d),(r,p)=>{r&&(d.fund=r.bill-r.payment)});const v=r=>{let p=r.details.reduce((s,l)=>(s.push(l.total),s),[]);d.bill=p.reduce((s,l)=>s+=l,0)};return D(()=>{v(i.purchases)}),(r,p)=>(c(),o(n,null,[u(w(F),null,{default:x(()=>[k]),_:1}),u(R,{links:g}),u(P,{classes:"bg-base-content",class:""},{default:x(()=>[N("Inventory Product")]),_:1}),t("section",q,[t("div",H,[t("div",T,[t("div",V,[t("table",C,[Q,t("tbody",null,[(c(!0),o(n,null,h(i.purchases.details,(s,l)=>(c(),o(n,null,[t("tr",S,[t("td",j,e(l+1),1),t("td",J,e(s.product_name),1),t("td",M,e(s.quantity+" "+s.price.unit.name),1),t("td",$,e(s.product_price_quantity+" "+s.product.unit.name),1),t("td",A,e(new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(s.buying_price)),1),t("td",E,e(new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(s.total)),1)]),L,(c(!0),o(n,null,h(s.product.stocks,(a,Y)=>(c(),o(n,null,[a.available_stock?(c(),o("tr",O,[z,t("td",G,[t("span",null,e(a.supplier.name),1)]),t("td",K,e(a.first_stock),1),t("td",U,e(a.available_stock),1),t("td",W,e(new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:2}).format(a.buying_price)),1),t("td",X,e(new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:2}).format(a.total)),1)])):B("",!0)],64))),256))],64))),256))])])])])])])],64))}};export{et as default};
