if(!Array.prototype.indexOf){Array.prototype.indexOf=function(c,d){for(var b=(d||0),a=this.length;
b<a;
b++){if(this[b]===c){return b
}}return -1
}
}if(!window.CQ_Analytics){window.CQ_Analytics={}
}if(typeof CQ_Analytics.TestTarget!=="undefined"){var oldTandT=CQ_Analytics.TestTarget
}CQ_Analytics.TestTarget=new function(){return{lateMboxArrivalTimeouts:{},init:function(clientcode){if(CQ_Analytics.TestTarget.clientCode){clientcode=CQ_Analytics.TestTarget.clientCode
}else{CQ_Analytics.TestTarget.clientCode=clientcode
}if(clientcode){CQ_Analytics.TestTarget.clientCode=clientcode;
var server=clientcode+".tt.omtrdc.net";
if(typeof mboxVersion=="undefined"){mboxVersion=41;
mboxFactories=new mboxMap();
mboxFactoryDefault=new mboxFactory(server,clientcode,"default")
}if(mboxGetPageParameter("mboxDebug")!=null||mboxFactoryDefault.getCookieManager().getCookie("debug")!=null){setTimeout(function(){if(typeof mboxDebugLoaded=="undefined"){alert("Could not load the remote debug.\nPlease check your connection to Test&amp;Target servers")
}},60*60);
document.write('<script language="Javascript1.2" src="http://admin4.testandtarget.omniture.com/admin/mbox/mbox_debug.jsp?mboxServerHost='+server+"&clientCode="+clientcode+'"><\/script>')
}}},pull:function(path){var wcmmode=CQ.shared.HTTP.getParameter(document.location.href,"wcmmode");
if(typeof CQ.WCM!=="undefined"){wcmmode="disabled"
}if(wcmmode&&wcmmode.length>0){path=CQ.shared.HTTP.addParameter(path,"wcmmode",wcmmode)
}var output=CQ.shared.HTTP.get(path);
var isOk=(output&&output.status&&output.status==200);
var hasBody=(output&&output.body&&output.body.length>0);
if(isOk&&hasBody){var caller=arguments.callee.caller;
if(!caller){document.write(output.body)
}else{var target;
while(caller){if(caller.arguments.length>0){if(caller.arguments[0].Fb){target=caller.arguments[0].Fb;
break
}}caller=caller.arguments.callee.caller
}if(target){var childDivs=target.getElementsByTagName("div");
if(childDivs.length==1){target=childDivs[0]
}var scriptwrapper=document.createElement("div");
scriptwrapper.innerHTML=output.body;
target.appendChild(scriptwrapper);
var scripts=target.getElementsByTagName("script");
for(var i=0;
i<scripts.length;
i++){eval(scripts[i].text)
}}}}else{if(console){console.log("Could not pull resource. Response[status:{},body:{}]",output.status,output.body)
}}},triggerUpdate:function(delay){if(typeof delay=="undefined"){delay=500
}if(!CQ_Analytics.TestTarget.reloadRequested){CQ_Analytics.TestTarget.reloadRequested=true;
setTimeout("CQ_Analytics.TestTarget.deleteMboxCookies(); CQ_Analytics.TestTarget.reloadRequested = false;",delay)
}},registerMboxUpdateCalls:function(){if(CQ_Analytics.mboxes){CQ_TestTarget={};
CQ_TestTarget.usedStoresLoaded=false;
CQ_TestTarget.usedStores=CQ_Analytics.TestTarget.getMappedSessionstores();
var trackStoreUpdate=function(sessionstore){var idx=$CQ.inArray(sessionstore.getName(),CQ_TestTarget.usedStores);
if(idx>-1&&!$CQ.isEmptyObject(sessionstore.getData())){CQ_TestTarget.usedStores.splice(idx,1)
}if(CQ_TestTarget.usedStores.length<1&&!CQ_TestTarget.usedStoresLoaded){var campaignStore=ClientContext.get("campaign");
if(campaignStore&&campaignStore.isCampaignSelected()){return
}CQ_Analytics.TestTarget.callMboxUpdate();
CQ_TestTarget.usedStoresLoaded=true
}};
if(CQ_TestTarget.usedStores.length>0){var usedStoresCopy=CQ_TestTarget.usedStores.slice(0);
for(var i=0;
i<usedStoresCopy.length;
i++){var storeName=usedStoresCopy[i];
var sessionstore=CQ_Analytics.ClientContextMgr.getRegisteredStore(storeName);
if(sessionstore.isInitialized()){trackStoreUpdate(sessionstore)
}}CQ_Analytics.CCM.addListener("storeupdate",function(e,sessionstore){trackStoreUpdate(sessionstore)
});
CQ_Analytics.CCM.addListener("storesinitialize",function(e,sessionstore){if(!CQ_TestTarget.usedStoresLoaded){var campaignStore=ClientContext.get("campaign");
if(campaignStore&&campaignStore.isCampaignSelected()){return
}CQ_Analytics.TestTarget.callMboxUpdate()
}})
}else{var campaignStore=ClientContext.get("campaign");
if(campaignStore&&campaignStore.isCampaignSelected()){return
}CQ_Analytics.TestTarget.callMboxUpdate()
}}},maxProfileParams:200,callMboxUpdate:function(){if(CQ_Analytics.mboxes){for(var i=0;
i<CQ_Analytics.mboxes.length;
i++){var updateArgs=[CQ_Analytics.mboxes[i].name];
var profileParams=0;
for(var j=0;
j<CQ_Analytics.mboxes[i].mappings.length;
j++){var profileprefix="";
var param=CQ_Analytics.mboxes[i].mappings[j].param;
var keypath="/"+CQ_Analytics.mboxes[i].mappings[j].ccKey.replace(".","/");
if(CQ_Analytics.mboxes[i].isProfile.indexOf(param)>-1){if(CQ_Analytics.TestTarget.maxProfileParams>0&&++profileParams>CQ_Analytics.TestTarget.maxProfileParams){mboxUpdate.apply(this,updateArgs);
updateArgs=[CQ_Analytics.mboxes[i].name];
profileParams=0
}profileprefix="profile."
}updateArgs.push(profileprefix+param+"="+CQ_Analytics.Variables.replaceVariables(CQ_Analytics.ClientContext.get(keypath)))
}var that=this;
(function(args){setTimeout(function(){mboxUpdate.apply(that,args)
},(i>0?100:0))
})(updateArgs)
}}},getMappedSessionstores:function(){var storenames=[];
if(CQ_Analytics.mboxes){for(var i=0;
i<CQ_Analytics.mboxes.length;
i++){for(var j=0;
j<CQ_Analytics.mboxes[i].mappings.length;
j++){var mapping=CQ_Analytics.mboxes[i].mappings[j].ccKey;
var tmp=mapping.split(".");
var storename=tmp[0];
var key=tmp[1];
if($CQ.inArray(storename,storenames)<0){storenames.push(storename)
}}}}return storenames
},deleteMboxCookies:function(){if(typeof mboxFactoryDefault=="undefined"){return
}mboxFactoryDefault.regenerateSession();
if(CQ&&CQ.WCM&&(CQ.WCM.isPreviewMode()||CQ.utils.WCM.isEditMode())){var campaignStore=ClientContext.get("campaign");
if(campaignStore&&campaignStore.isCampaignSelected()){return
}CQ_Analytics.TestTarget.callMboxUpdate()
}},registerListeners:function(){var stores=CQ_Analytics.CCM.getStores();
for(var storename in stores){var store=stores[storename];
if(storename!="mouseposition"&&store.addListener){store.addListener("update",function(event,property){if(typeof property=="undefined"||(property&&property.match&&property.match("^mouse")!="mouse")){CQ_Analytics.TestTarget.triggerUpdate()
}})
}}},ignoredUpdates:{},ignoreNextUpdate:function(mboxName){CQ_Analytics.TestTarget.ignoredUpdates[mboxName]=true
},addMbox:function(mboxDefinition){var replaced=false;
if(!CQ_Analytics.mboxes){CQ_Analytics.mboxes=[]
}for(var i=0;
i<CQ_Analytics.mboxes.length;
i++){var mbox=CQ_Analytics.mboxes[i];
if(mbox.id==mboxDefinition.id){CQ_Analytics.mboxes.splice(i,1);
replaced=true;
break
}}CQ_Analytics.mboxes.push(mboxDefinition);
return replaced
},hideDefaultMboxContent:function(mboxId){$CQ("#"+mboxId).find("div").css("visibility","hidden")
},showDefaultMboxContent:function(mboxId,mboxName){var defaultContent=$CQ("#"+mboxId);
if(!defaultContent.length){return
}mboxFactoryDefault.get(mboxName).show(new mboxOfferDefault());
CQ_Analytics.TestTarget.ignoreNextUpdate(mboxName)
},ignoreLateMboxArrival:function(mboxId,mboxName,timeout){this.clearLateMboxArrivalTimeout(mboxId);
var that=this;
this.lateMboxArrivalTimeouts[mboxId]=setTimeout(function(){that.showDefaultMboxContent(mboxId,mboxName);
that.clearLateMboxArrivalTimeout(mboxId)
},2000)
},clearLateMboxArrivalTimeout:function(mboxId){if(this.lateMboxArrivalTimeouts[mboxId]){clearTimeout(this.lateMboxArrivalTimeouts[mboxId]);
delete this.lateMboxArrivalTimeouts[mboxId]
}}}
};
if(typeof oldTandT!=="undefined "){for(var prop in oldTandT){CQ_Analytics.TestTarget[prop]=oldTandT[prop]
}}var tt_readyStateCheckInterval=setInterval(function(){if(document.readyState==="complete"){try{if(!mbox.prototype._setOffer){mbox.prototype._setOffer=mbox.prototype.setOffer;
mbox.prototype.setOffer=function(b){if("_onLoad" in b){b.show=function(g){var f=g.getDefaultDiv();
if(f==null){return 0
}var c=g.id?g.id:g.getName();
var e=document.getElementById("mboxClick-"+c);
if(e&&e.onclick){f.onclick=e.onclick
}var d=g.hide();
if(d==1){this._onLoad()
}return d
}
}CQ_Analytics.TestTarget.clearLateMboxArrivalTimeout(this.g);
if(CQ_Analytics.TestTarget.ignoredUpdates[this.g]){delete CQ_Analytics.TestTarget.ignoredUpdates[this.g];
return this
}else{return this._setOffer(b)
}}
}mbox.prototype.clearDefaultDiv=function(){this.Tb=null
};
mbox.prototype.setUrlBuilder=function(b){this.w=b;
this.w.addParameter("mbox",this.g).addParameter("mboxId",this.Ib)
};
mboxCookieManager.prototype.deleteAllCookies=function(){var b=this;
this.ec.each(function(d,c){b.deleteCookie(d)
})
};
mboxFactory.prototype.regenerateSession=function(){this.J.deleteAllCookies();
this.L=mboxGenerateId();
this.S=new mboxSession(this.L,"mboxSession","session",31*60,this.J);
this.T=new mboxPC("PC",1209600,this.J);
var b=this.D=="default";
this.w=new mboxUrlBuilder(this.C,CQ_Analytics.TestTarget.clientCode);
this.U(this.w,b);
var c=this;
this.getMboxes().each(function(d){d.setUrlBuilder(c.w.clone())
})
};
CQ_Analytics.CCM.onReady(function(){CQ_Analytics.TestTarget.registerListeners()
},CQ_Analytics.TestTarget)
}catch(a){if(console){console.error(a.message)
}}finally{clearInterval(tt_readyStateCheckInterval)
}}},10);