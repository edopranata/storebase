import{c as r,a as n,u as d,w as l,b as s,t as a,F as i,r as y,d as c,e as p,f as _,o,H as m,L as x}from"./app.6829f0fb.js";import{_ as f,a as k}from"./Breadcrumb.fb985bca.js";import{_ as v}from"./Pagination.41e0ee51.js";const w={class:"px-4 grid gap-4"},D={class:"grid md:grid-cols-2"},N={class:"stats bg-primary text-primary-content rounded-none"},B={class:"stat"},F=s("div",{class:"stat-title"},"Total Asset",-1),I={class:"stat-value"},L={class:"stat-desc"},A=s("div",{class:"stat-actions flex justify-end"},[s("a",{class:"btn btn-sm btn-outline btn-warning",href:"#",onclick:"window.open(route('app.report.asset.show', 'download'), '_blank')"},"Download")],-1),T=s("div",{class:"hidden badge-primary badge-secondary badge badge-accent badge-ghost badge-info badge-error"},null,-1),V={class:"card w-full rounded-none border-2 border-info shadow-xl"},j={class:"card-body grid gap-4"},H={class:"w-full text-left text-base"},R=s("thead",{class:"text-sm uppercase bg-primary/20"},[s("tr",null,[s("th",{class:"py-3 px-6",rowspan:"2"},"#"),s("th",{class:"py-3 px-6",rowspan:"2"},"Barcode"),s("th",{class:"py-3 px-6",rowspan:"2"},"Nama Barang"),s("th",{class:"py-3 px-6 text-center border-b",colspan:"3"},"Stock"),s("th",{class:"py-3 px-6 text-right",rowspan:"2"},"Total")]),s("tr",null,[s("th",{class:"py-3 px-6"},"Gudang"),s("th",{class:"py-3 px-6"},"Toko"),s("th",{class:"py-3 px-6"},"Total")])],-1),S={class:"hover:cursor-pointer group border-b"},$={class:"group-hover:bg-base-300 py-4 px-6"},C={class:"group-hover:bg-base-300 py-4 px-6"},G={class:"badge badge-primary badge-md"},O={class:"group-hover:bg-base-300 py-4 px-6"},E={class:"group-hover:bg-base-300 py-4 px-6"},P={class:"group-hover:bg-base-300 py-4 px-6"},q={class:"group-hover:bg-base-300 py-4 px-6"},z={class:"group-hover:bg-base-300 py-4 px-6 text-right"},J={key:1},K={colspan:"7",class:"text-center border-b-2"},X={__name:"ReportAsset",props:{position:String,total:Object,assets:Object},setup(u){const e=u,b=[{url:route("app.index"),label:"Beranda"},{url:route("app.report.index"),label:"Laporan"},{url:null,label:"Aset"}];return(h,M)=>(o(),r(i,null,[n(d(m),{title:"Laporan Aset"}),n(k,{links:b}),n(f,{classes:"bg-base-content",class:""},{default:l(()=>[c("Laporan Aset")]),_:1}),s("section",w,[s("div",D,[s("div",N,[s("div",B,[F,s("div",I,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(e.total.balance)),1),s("div",L,"Hingga "+a(e.position),1),A])])]),T,s("div",V,[s("div",j,[s("table",H,[R,s("tbody",null,[e.assets.data.length?(o(!0),r(i,{key:0},y(e.assets.data,(t,g)=>(o(),r("tr",S,[s("th",$,a(e.assets.from+g),1),s("td",C,[s("div",G,a(t.barcode),1)]),s("td",O,a(t.name),1),s("td",E,a(t.warehouse_stock+" "+t.unit.name),1),s("td",P,a(t.store_stock+" "+t.unit.name),1),s("td",q,a(t.store_stock+t.warehouse_stock+" "+t.unit.name),1),s("td",z,a(Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0}).format(t.total_asset)),1)]))),256)):(o(),r("tr",J,[s("td",K,[c("No Data "),e.assets.current_page>1?(o(),p(d(x),{key:0,class:"link link-primary",href:h.route("app.report.asset.index")},{default:l(()=>[c("Goto First Page")]),_:1},8,["href"])):_("",!0)])]))])]),e.assets.data.length?(o(),p(v,{key:0,links:e.assets.links},null,8,["links"])):_("",!0)])])])],64))}};export{X as default};
