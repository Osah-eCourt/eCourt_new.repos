var delta = delta || {};
delta.promowidget = (function (window, $) {
	var _this;
	var $c;
	var $currentPanel;
	var $nav;
	var autoPlayInterval;
	var currentPanelIndex = -1;
	var i;
	var isAnimating;
	var isAutoPlayDisabled = false;
	var minPanelIndex = -1;
	var maxPanelIndex = -1;
	var panels = [];
	var panelWidth = -1;
	var promotions;
	var promotionsCount = -1;
	var promotionsPerSet = 2;
	var transitionDuration = 1000;
	var pub = {};	
	pub.getNextPanelIndex = function() {
		if (currentPanelIndex+1 > maxPanelIndex) {
			return minPanelIndex;
		} else {
			return currentPanelIndex + 1;
		}
	}
	pub.animatePanelOut = function($panel) {
		if (currentPanelIndex < 0) {
			return $panel;
		} else {
			return $panel.removeClass('current').animate({ left: -1 * panelWidth }, transitionDuration, 'easeInOutExpo');
		}
	}
	pub.animatePanelIn = function($panel) {
		return $panel.addClass('current').show().css('left', panelWidth).animate({ left: 0 }, transitionDuration, 'easeInOutExpo');
	}
	pub.rotatePanel = function(){
		if(isAutoPlayDisabled) {return; }
		delta.promowidget.showPanel(delta.promowidget.getNextPanelIndex());
	}
	pub.showPanel = function(newPanelIndex) {
		var $newPanel;
		// Ignore if panel doesn't change or if already animating a panel transition
		if ((newPanelIndex === currentPanelIndex) || isAnimating) {
			return;
		}
		isAnimating = true;
		$.when(
			delta.promowidget.animatePanelOut($(panels[currentPanelIndex])),
			delta.promowidget.animatePanelIn($(panels[newPanelIndex]))
		).then(function () {
			isAnimating = false;
		});
		$c.attr('style','');
		$(panels[newPanelIndex]).parent('.promotions').css({'z-index':'10'});
		/* Set Active Nav Item */
		$nav.find('.selected').removeClass('selected');
		$nav.find('li:eq(' + newPanelIndex + ')').addClass('selected');
		currentPanelIndex = newPanelIndex;
	}
	pub.navClicked = function(e) {
		var $li = $(e.currentTarget),
		newPanelIndex;
		newPanelIndex = $li.data('index');
		window.clearInterval(autoPlayInterval);
		delta.promowidget.showPanel(newPanelIndex);
	}
	pub.init = function () {
		_this = this;
		$c = $('.promotions');
		promotionsCheck = $c.find('article');
		promotionsCheckCount = promotionsCheck.length;
		if (promotionsCheckCount % 2 !== 0){
			$c.each(function(){
				$(this).find("article").last().remove();
			});
		}
		promotions = $c.find('article');
		promotionsCount = promotions.length;		// If there are too few promotions, there is no need for widget navigation
		if(promotionsCount <= promotionsPerSet) { return; }
		// Wrap Sets of 2 with a div
		promotions.each(function (index, el) {
			var $article = $(this);
			if (index % 2 === 0) {
				$article.add($article.next()).add($article.next().next()).wrapAll('<div class="panel"></div>');
			} 
		});
		panels = $c.find('div');
		minPanelIndex = 0;
		maxPanelIndex = panels.length - 1;
		/* Nav */
		$nav = $('<ul>', {
			'class': 'nav'
		});
		for (i=0;i<=maxPanelIndex;i++) {
			$nav.append($('<li>', {
				'data-index': i,
				'class': 'dot'
			}));
		}
		$c.append($nav);
		$c.on('click', 'li.dot', $.proxy(delta.promowidget.navClicked, _this)).on('hover', 'article', function (e) {
			isAutoPlayDisabled = (e.type === 'mouseenter');
		});
		panelWidth = $c.width();
		/* Show Initial Panel */
		delta.promowidget.showPanel(minPanelIndex);
		autoPlayInterval = window.setInterval(delta.promowidget.rotatePanel, 8000);
	}
	return pub;
})(window, jQuery);

$(document).ready(function(window, jQuery) {
	delta.promowidget.init(window, jQuery); 
});

var delta = delta || {};
delta.advisorywidget = (function(window, $){
    var $c,         // container for widget as JQuery object
    $nextButton,
    $prevButton,
    $closeButton,
    that = this,    // context for events
    advisoryList,
    maxIndex = -1,
    currentIndex = -1,
    animSpeed = 200,
    initialized = false;
    
    function showDetailView() {
        $c.find('.slider').addClass('detail');
        $closeButton.show();
    }

    function hideDetailView() {
        if(initialized) {
            $c.find('.slider').removeClass('detail');
            $closeButton.hide();
        }
    }
    
    function articleClicked() {
        showDetailView();
    }

    function closeClicked() {
        hideDetailView();
    }

    function prevClicked() {
        // Display Previous Advisory

        // If at the beginning of the list, jumped to cloned first element
        // at the end and animated from there
        if(currentIndex === 0) {
            $(advisoryList[currentIndex]).hide();
            currentIndex = maxIndex;
            $(advisoryList[currentIndex]).next().show();
        } else {
            currentIndex--;
        }

        $(advisoryList[currentIndex]).css('marginLeft', -292)
            .show()
            .animate({ marginLeft: 0 }, animSpeed, function() {
                $(this).next().hide();
            });
    }

    function nextClicked() {
        // Display Next Advisory
        // Animate Current Advisory to the Left
        // Hide the Current Advisory after the animation is complete

        // At the end of the list, animate with a cloned version of the 
        // advisory. After the animation is complete, jump to the front of the list
        $(advisoryList[currentIndex]).next().show().end()
            .animate({ marginLeft: -292 }, animSpeed, function() {
                $(this).hide().css('marginLeft',0);

                // Special case for the end of the list of advisories
                if(currentIndex > maxIndex) {
                    $(advisoryList[currentIndex]).hide();
                    currentIndex = 0;
                    $(advisoryList[currentIndex]).show();
                }
            });
        currentIndex++;
    }
    
    function buildHTML() {
        // Only add buttons if they are needed
        if(maxIndex > 0) {
            $nextButton = $('<div />', {
                'class': 'nav next'
            }).appendTo($c);

            $prevButton = $('<div />', {
                'class': 'nav prev'
            }).appendTo($c);
        }

        $closeButton = $('<div />', {
            'class': 'nav close'
        }).appendTo($c);
    }

    function bindEvents() {
        $c.delegate('article', 'click', $.proxy(articleClicked, that))
            .delegate('.prev', 'click', $.proxy(prevClicked, that))
            .delegate('.next', 'click', $.proxy(nextClicked, that))
            .delegate('.close', 'click', $.proxy(closeClicked, that));
    }
    
    return {
        init: function() {
            var advisoryCount;

            $c = $('#advisory .window');
            advisoryList = $c.find('article');

            advisoryCount = advisoryList.length;
            if(advisoryCount === 0) {
                return;
            }
            initialized = true;
            maxIndex = advisoryCount - 1;
            currentIndex = 0;

            // Hide All but First Advisory
            // HTML should already have done this to prevent a flicker of content
            advisoryList.filter(':gt(0)').hide();

            advisoryList.first().clone().hide().appendTo('.slider', $c);

            buildHTML();
            bindEvents();
            hideDetailView(); // Default to collapsed view.  
        },
        close: hideDetailView
    };
})(window, jQuery);

$(document).ready(function(window, jQuery) {
    delta.advisorywidget.init(window, jQuery);  
});

var counter = 0;
Date.locale = {
    en: {
       month_names: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
       month_names_short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    }
};
var d, cd, date1, day1, month1, year1, timeSplit, splitDate, m, yr, mth, day, hrs, min, sec, rtnVal;
function returnDateDiff(b) {
    cd = new Date;
    splitDate = b.split(" ");
    date1 = splitDate[2];
    day1= date1.split("");
    if(day1[0]=="0"){day1=day1[1];}
    else{day1=date1;}
    month1 = include(Date.locale['en'].month_names_short,splitDate[1]);
    year1 = splitDate[5];
    time1 = splitDate[3];
    timeSplit = time1.split(":");
    d = new Date(parseInt(year1), parseInt(month1), parseInt(day1), parseInt(timeSplit[0]), parseInt(timeSplit[1]), timeSplit[2]);  
    m = DateDiff(cd, d);
    if(m>=0){   
        yr = Math.floor(m /(3600*24*1000*365));
        mth = Math.floor(m /(3600*24*1000*30));
        day = Math.floor(m /(3600*24*1000));
        hrs = Math.floor(m /(3600*1000));
        min = Math.floor(m /(60*1000));
        sec = Math.floor(m /1000);
    }   
    if (yr > 0){                
        if(yr == 1){rtnVal = yr + " year ago";}
        else{rtnVal = yr + " years ago";}                               
    }else if (mth > 0){             
        if(mth == 1){rtnVal = mth + " month ago";}
        else{rtnVal = mth + " months ago";}                     
    }else if (day > 0){ 
        if(day == 1){rtnVal = day + " day ago";}
        else{rtnVal = day + " days ago";}   
    }else if (hrs > 0){ 
        if(hrs == 1){rtnVal = hrs + " hour ago";}
        else{rtnVal = hrs + " hours ago";}  
    }else if (min > 0){                 
        rtnVal = min + " minutes ago";
    }else if (sec > 0){                     
        rtnVal = sec + " seconds ago";
    }else{
        rtnVal="";
    }                           
    return rtnVal;
}
function include(arr, obj) {
    for(var i=0; i<arr.length; i++) {
        if (arr[i] == obj) return i;
    }
}

function DateDiff(b, c) {
  return b.getTime() - c.getTime()
}
            

var timer_is_on=0;
function timedCount(){
    if ($.browser.safari){  
        fadeEffect.init('twitContent', 0);
    }else{
        fadeOut();  
    }
    loadValuesToScreen();   
    t = setTimeout("timedCount()",10000);   
}

function doTimer(){
if (!timer_is_on)
  {
  timer_is_on = 1;
  timedCount();
  }
}

function loadValuesToScreen(){
    if(counter<responseObj-1){
        counter=counter+1;
    }else{
        counter = 0;    
    }   
    
    $("#twitterDisplayName").html(x[counter][1]);
    $("#twitterTweets").html(x[counter][0]);        
    $("#timeDiff").html(returnDateDiff(x[counter][2])); 
    counter=counter+1;  
    
    if ($.browser.safari){  
        fadeEffect.init('twitContent', 1);
    }else{  
        FadeIn();
    }
}

var duration = 1000; /* fade duration in millisecond */
function SetOpa(Opa) {/* TODO: Set CSS*/
 /* $("#twitContent").css(opacity = Opa);
  $("#twitContent").style.MozOpacity = Opa;
  $("#twitContent").style.KhtmlOpacity = Opa;
  $("#twitContent").style.filter = 'alpha(opacity=' + (Opa * 100) + ');';
  $("#twitContent").style.opacity = Opa;
  $("#timeDiff").style.MozOpacity = Opa;
  $("#timeDiff").style.KhtmlOpacity = Opa;
  $("#timeDiff").style.filter = 'alpha(opacity=' + (Opa * 100) + ');';*/
}

function fadeOut() {
  for (i = 0; i <= 1; i += 0.01) {
    setTimeout("SetOpa(" + (1 - i) +")", i * duration);
  } 
}
function FadeIn() {
  for (i = 0; i <= 1; i += 0.01) {
    setTimeout("SetOpa(" + i +")", i * duration);
  } 
}
var fadeEffect=function(){
    return{
        init:function(id, flag, target){
            this.elem = document.getElementById(id);
            clearInterval(this.elem.si);
            this.target = target ? target : flag ? 100 : 0;
            this.flag = flag || -1;
            this.alpha = this.elem.style.opacity ? parseFloat(this.elem.style.opacity) * 100 : 0;
            this.si = setInterval(function(){fadeEffect.tween()}, 20);
        },
        tween:function(){
            if(this.alpha == this.target){
                clearInterval(this.si);
            }else{
                var value = Math.round(this.alpha + ((this.target - this.alpha) * .05)) + (1 * this.flag);
                this.elem.style.opacity = value / 100;
                this.elem.style.filter = 'alpha(opacity=' + value + ')';
                this.alpha = value
            }
        }
    }
}();
function returnFormatedString(st){
    var b, c, cc, dd;
    if(st.indexOf("http") !=-1){
         b = st.substring(0,st.indexOf("http"));
         c = st.substring(st.indexOf("http"));
         cc = c.substring(0, c.indexOf(" "));
        if(cc == "" && c.substring(c.length-1, c.length) ==".")cc = c.substring(0, c.length-1);/* check for "." at end*/
        if(c.indexOf(". ") !=-1)cc = c.substring(0, c.indexOf(". "));/* check for ". " after url*/
        if(cc=="")cc=c;
        dd = st.substring(st.indexOf(cc)+cc.length);
        if(dd==" ")dd="";
        st= b+"<span class='hp_NewssubLink'>"+cc +"</span>"+dd;
    }
    return st; 
}
/*
function onloadTwitterContents(){   
    if(responseObj>0){
        doTimer();
    }
}
if(document.loaded) {
    onloadTwitterContents();
} else {
    if (window.addEventListener) {  
        window.addEventListener('load', onloadTwitterContents, false);
    } else {
        window.attachEvent('onload', onloadTwitterContents);
    }
}*/
