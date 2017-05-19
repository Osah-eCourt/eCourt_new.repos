var MP = {

	<!-- mp_trans_disable_start -->

	Version: '1.0.22',

	Domains: {'zh':'zh.delta.com',

	'zt':'zt.delta.com',

	'fr':'fr.delta.com',

	'de':'de.delta.com',

	'it':'it.delta.com',

	'ja':'ja.delta.com',

	'ko':'ko.delta.com',

	'pt':'pt.delta.com',

	'ru':'ru.delta.com',

	'es':'es.delta.com'},

	SrcLang: 'en',

	<!-- mp_trans_disable_end -->

	UrlLang: 'mp_js_current_lang',

	SrcUrl: unescape('mp_js_orgin_url'),

	<!-- mp_trans_disable_start -->

	init: function(){

		if (MP.UrlLang.indexOf('p_js_')==1) {

			MP.SrcUrl=window.top.document.location.href;

			MP.UrlLang=MP.SrcLang;

		}

	},

	getCookie: function(name){

		var start=document.cookie.indexOf(name+'=');

		if(start < 0) return null;

		start=start+name.length+1;

		var end=document.cookie.indexOf(';', start);

		if(end < 0) end=document.cookie.length;

		while (document.cookie.charAt(start)==' '){ start++; }

		return unescape(document.cookie.substring(start,end));

	},

	setCookie: function(name,value,path,domain){

		var cookie=name+'='+escape(value);

		if(path)cookie+='; path='+path;

		if(domain)cookie+='; domain='+domain;

		var now=new Date();

		now.setTime(now.getTime()+1000*60*60*24*365);

		cookie+='; expires='+now.toUTCString();

		document.cookie=cookie;

	},

	switchLanguage: function(lang){

		if(lang!=MP.SrcLang){

			var script=document.createElement('SCRIPT');

			/*if(window.location.search!=null && window.location.search.indexOf("lang")!=-1){
					MP.SrcUrl=window.location.href.replace(
									window.location.href.substring(
									window.location.href.indexOf("lang"),
									window.location.href.indexOf("lang")+14),"");
			}else{*/
					MP.SrcUrl=MP.SrcUrl;
			//}
			script.src=location.protocol+'//'+MP.Domains[lang]+'/'+MP.SrcLang+lang+'/?1023749632;'+encodeURIComponent(MP.SrcUrl);

			document.body.appendChild(script);

		} else if(lang==MP.SrcLang && MP.UrlLang!=MP.SrcLang){

			var script=document.createElement('SCRIPT');
			var hrefURI="";
			if(window.location.search!=null && window.location.search.indexOf("lang")!=-1){
					hrefURI=window.location.href.replace(
									window.location.href.substring(
									window.location.href.indexOf("lang"),
									window.location.href.indexOf("lang")+14),"");
			}else{
				hrefURI=location.href;
			}
			script.src=location.protocol+'//'+MP.Domains[MP.UrlLang]+'/'+MP.SrcLang+MP.UrlLang+'/?1023749634;'+encodeURIComponent(hrefURI);

			document.body.appendChild(script);

		} else if(lang==MP.SrcLang ){

			MP.SrcUrl=MP.SrcUrl.replace("-ru","").replace("ru.","www.");

			window.location.href=MP.SrcUrl;
		}

		return false;

	},

	switchToLang: function(url) {

		window.top.location.href=url;

	}

	<!-- mp_trans_disable_end -->

};



MP.SrcUrl=unescape('mp_js_orgin_url');

MP.UrlLang='mp_js_current_lang';

MP.init();

