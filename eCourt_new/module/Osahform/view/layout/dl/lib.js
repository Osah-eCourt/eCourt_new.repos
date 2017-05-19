(function($) {
    var isDebugEnabled = false;
    var carouselContent ;
    var imageWidth ;
    var speed=7000 ;//Set timer - this will repeat itself every 7 seconds
    var imageSum ;
    var imageReelWidth ;
    var paging;
    var curTriggerID=1;//Used if paging is disabled
    var lastSlide;//Used if paging is disabled
    var autoRotate=true;
    var heroTypeA=false;
    $.fn.deltaSlideImage= function(options){
         //Get size of the image, how many images there are, then determine the size of the image reel.
        imageWidth = $("#slides").width();
        heroTypeA = options.heroTypeA;
        if(DeltaUtils.exists(options) && DeltaUtils.exists(options.autoRotate) ){
            autoRotate=options.autoRotate;
        }
        if(DeltaUtils.exists(options) && DeltaUtils.exists(options.timer) ){
            var speed=options.timer  ;  //Over ride the default timer value- 
        }
        imageSum = $(".slide_reel "+options.slideParam ).size();
        imageReelWidth = imageWidth * imageSum;
        if(DeltaUtils.exists(options) && DeltaUtils.exists(options.paging) && options.paging){
            $(".slideShowControlref a:first").addClass("active"); //Set the first pagination number as active
            // add class to <a> tag for image reference
            $("#slides div.slide_reel a:first").addClass("activeImage");
            $(".slideShowControlref > a").each(function() {//Add Click handler for pagination 
                var $target = $(this);
                $.fn.bindClickHandler($target);
            });
            paging=options.paging;
        }else{
            paging=false;
            lastSlide=imageSum/(Math.round(imageWidth/$(".slide_reel "+options.slideParam ).width()));
        } 
        if(DeltaUtils.exists(options) && DeltaUtils.exists(options.carouselContent) ){
            carouselContent = options.carouselContent;
            var slideContent = carouselContent[$("#slides div.slide_reel a.activeImage img").attr('id')];
            var marketingTitle = (DeltaUtils.exists(slideContent.marketingTitle)) ? slideContent.marketingTitle : "";
            var marketingCopy = (DeltaUtils.exists(slideContent.marketingCopy)) ? slideContent.marketingCopy : "";
            var photoLocation = (DeltaUtils.exists(slideContent.photoLocation)) ? slideContent.photoLocation : "";
            var terms = (DeltaUtils.exists(slideContent.terms)) ? slideContent.terms : "";
            var textColor;
            $('span.marketingTitle').html(marketingTitle);
            $('span.marketingCopy').html(marketingCopy);
            $('span.photoLocation').html(photoLocation);
            $('span.terms').html(terms);
          if(DeltaUtils.exists(slideContent.textColor) && slideContent.textColor != ""){
              if(slideContent.textColor == "dark"){
                  textColor = "#333";
              } else if(slideContent.textColor == "light"){
                  textColor = "#fff";
              }
              $('span.marketingTitle').css("color",textColor);
              $('span.marketingCopy').css("color",textColor);
              $('span.marketingCopy a').css("color",textColor);
              $('span.photoLocation').css("color",textColor);
              $('span.terms').css("color",textColor);
              $(".slideShowControl p").css("color",textColor);
          }
        }
        if(DeltaUtils.exists(options) && DeltaUtils.exists(options.nextPrev) && options.nextPrev){
            var $nextTarget = $(".next");
            var $prevTarget = $(".previous");
            $.fn.bindMouseHoverHandler($nextTarget);
            $.fn.bindMouseHoverHandler($prevTarget);
            $.fn.bindClickHandler($nextTarget);
            $.fn.bindPrevClickHandler($prevTarget);
        }
        $(".slide_reel > a").each(function() {//On mouse over of image stop the rotation
            var $target = $(this);
            $.fn.bindMouseHoverHandler($target);
        });
        //Adjust the image reel to its new size
        $(".slide_reel").css({'width' : imageReelWidth});
        if(autoRotate){
            rotateSwitch();
        }
    };
    //On Click
    $.fn.bindClickHandler = function($target){
        $target.click( function() {
            $active="";
            if(paging){
                $active = $(this); //Activate the clicked paging
                // get rel number for fetching appropriate image
                var relAttr = $active.attr("rel");
                $activeImage = $("#slides div.slide_reel a[rel="+relAttr + "]");
            }else{
                if(curTriggerID==lastSlide){
                    return false;
                }
                // get rel number for fetching appropriate image
                $activeImage = $("#slides div.slide_reel a[rel="+(curTriggerID) + "]");
            }
            if(autoRotate){
                //Reset Timer
                clearInterval(play); //Stop the rotation
            }
            rotate(); //Trigger rotation immediately
            if(autoRotate){
                    rotateSwitch(); // Resume rotation timer
            }
            return false; //Prevent browser jump to link anchor
        });
    };  
    $.fn.bindPrevClickHandler = function($target){
        $target.click( function() {
            if(curTriggerID>=0){
                curTriggerID-=2;
            }else{
                curTriggerID=1;
                return false;
            }
            if(curTriggerID<0){
                curTriggerID=1;
                return false;
            }
            // get rel number for fetching appropriate image
            var $activeImage = $("#slides div.slide_reel a[rel="+(curTriggerID) + "]");
            if(autoRotate){
                //Reset Timer
                clearInterval(play); //Stop the rotation
            }
            rotate(); //Trigger rotation immediately
            if(autoRotate){
                rotateSwitch(); // Resume rotation timer
            }
            return false; //Prevent browser jump to link anchor
        });
    };  
    //On Hover
    $.fn.bindMouseHoverHandler = function($target){
        $target.hover(
        function() {
             clearInterval(play); //Stop the rotation
        }, function() {
            if(autoRotate){
            rotateSwitch(); //Resume rotation timer
            }
        } );
    };  
    rotate = function(){
        var triggerID;
        // remove activeImage class from image
        $("#slides div.slide_reel a").removeClass('activeImage');
            if(paging){
                triggerID = $active.attr("rel") - 1; //Get number of times to slide
                $("#currentImage").text(triggerID+1); 
                $(".slideShowControlref a").removeClass('active');
            $active.addClass('active'); //Add active class (the $active is declared in the rotateSwitch function)
            }else{
                triggerID=curTriggerID;
                curTriggerID+=1;
            }
             // add active class to current image
        $activeImage.addClass('activeImage');
        var image_reelPosition = triggerID * imageWidth; //Determines the distance the image reel needs to slide
        if(DeltaUtils.exists(carouselContent)){
            var slideContent = carouselContent[$("#slides div.slide_reel a.activeImage img").attr('id')];
            var marketingTitle = (DeltaUtils.exists(slideContent.marketingTitle)) ? slideContent.marketingTitle : "";
            var marketingCopy = (DeltaUtils.exists(slideContent.marketingCopy)) ? slideContent.marketingCopy : "";
            var photoLocation = (DeltaUtils.exists(slideContent.photoLocation)) ? slideContent.photoLocation : "";
            var terms = (DeltaUtils.exists(slideContent.terms)) ? slideContent.terms : "";
            $('span.marketingTitle').html(marketingTitle);
            $('span.marketingCopy').html(marketingCopy);
            $('span.photoLocation').html(photoLocation);
            $('span.terms').html(terms);
            if(DeltaUtils.exists(slideContent.textColor) && slideContent.textColor != ""){
                if(slideContent.textColor == "dark"){
                    textColor = "#333";
                } else if(slideContent.textColor == "light"){
                    textColor = "#fff";
                }
                $('span.marketingTitle').css("color",textColor);
                $('span.marketingCopy').css("color",textColor);
                $('span.marketingCopy a').css("color",textColor);
                $('span.photoLocation').css("color",textColor);
                $('span.terms').css("color",textColor);
                $(".slideShowControl p").css("color",textColor);
            }
            if(heroTypeA){

                var termsObject = $('span.terms');
                var locationObject = $('span.photoLocation');
                var controlsObject = $('div.slideShowControl');
                var imageObject = $('.slide_reel img');
                
                var termsCSS = {
                    "top":"",
                    "right":"10px",
                    "bottom": "14px",
                    "left":""
                };
                termsObject.css(termsCSS);
                
                var locationCSS = {
                    "top":"",
                    "right":"",
                    "bottom": "14px",
                    "left":"10px"
                };
                locationObject.css(locationCSS);
                
                var controlsTopPosition = termsObject.height() > 0 ? imageObject.height() - 10 - controlsObject.height() - termsObject.height() :
                                            imageObject.height() - 10 - controlsObject.height();
                var controlsLeftPosition = imageObject.outerWidth() - controlsObject.outerWidth() - 70;
                var controlsCSS = {
                    "top": controlsTopPosition + "px",
                    "right":"",
                    "bottom": "",
                    "left": controlsLeftPosition + "px"
                };
                controlsObject.css(controlsCSS);
                
                // TODO: Determine what to do about Terms and Conditions width (too long)
                
            }
            if(DeltaUtils.exists(slideContent.position)){
                ViewportHandler.positionElement($(".marketingMessage"), $("#slides"),"absolute", slideContent.position );
            }
        }
        //Slider Animation
        $(".slide_reel").animate({
            left: -image_reelPosition
        }, 200 );
    }; 
    //Rotation  and Timing Event
    rotateSwitch = function(){
        //paging,curTriggerID,finalSlide
        play = setInterval(function(){
        $active = "";
        // get active image..
        $activeImage = $('#slides div.slide_reel a.activeImage').next();
        if(paging){
            $active=$('.slideShowControlref a.active').next(); //Move to the next paging
            if ( $active.length == 0) { //If paging reaches the end...
                $active = $('.slideShowControlref a:first'); //go back to first
                // go back to first image
                $activeImage = $("#slides div.slide_reel a:first");
            }
        } else {
            $active=curTriggerID+1;
            if(curTriggerID==lastSlide){
                curTriggerID=0;
                // go back to first image
                $activeImage = $("#slides div.slide_reel a:first");
            }
        }
        rotate(); //Trigger the paging and slider function
        },speed ); //Timer speed in milliseconds (7 seconds)
    };
})(jQuery);

/*!
 * jQuery.ScrollTo
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 06/05/2009
 *
 * @projectDescription Easy element scrolling using jQuery.
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 * Works with jQuery +1.2.6. Tested on FF 2/3, IE 6/7/8, Opera 9.5/6, Safari 3, Chrome 1 on WinXP.
 *
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * @id jQuery.scrollTo
 * @id jQuery.fn.scrollTo
 * @param {String, Number, DOMElement, jQuery, Object} target Where to scroll the matched elements.
 *    The different options for target are:
 *      - A number position (will be applied to all axes).
 *      - A string position ('44', '100px', '+=90', etc ) will be applied to all axes
 *      - A jQuery/DOM element ( logically, child of the element to scroll )
 *      - A string selector, that will be relative to the element to scroll ( 'li:eq(2)', etc )
 *      - A hash { top:x, left:y }, x and y can be any kind of number/string like above.
 *      - A percentage of the container's dimension/s, for example: 50% to go to the middle.
 *      - The string 'max' for go-to-end. 
 * @param {Number, Function} duration The OVERALL length of the animation, this argument can be the settings object instead.
 * @param {Object,Function} settings Optional set of settings or the onAfter callback.
 *   @option {String} axis Which axis must be scrolled, use 'x', 'y', 'xy' or 'yx'.
 *   @option {Number, Function} duration The OVERALL length of the animation.
 *   @option {String} easing The easing method for the animation.
 *   @option {Boolean} margin If true, the margin of the target element will be deducted from the final position.
 *   @option {Object, Number} offset Add/deduct from the end position. One number for both axes or { top:x, left:y }.
 *   @option {Object, Number} over Add/deduct the height/width multiplied by 'over', can be { top:x, left:y } when using both axes.
 *   @option {Boolean} queue If true, and both axis are given, the 2nd axis will only be animated after the first one ends.
 *   @option {Function} onAfter Function to be called after the scrolling ends. 
 *   @option {Function} onAfterFirst If queuing is activated, this function will be called after the first scrolling ends.
 * @return {jQuery} Returns the same jQuery object, for chaining.
 *
 * @desc Scroll to a fixed position
 * @example $('div').scrollTo( 340 );
 *
 * @desc Scroll relatively to the actual position
 * @example $('div').scrollTo( '+=340px', { axis:'y' } );
 *
 * @desc Scroll using a selector (relative to the scrolled element)
 * @example $('div').scrollTo( 'p.paragraph:eq(2)', 500, { easing:'swing', queue:true, axis:'xy' } );
 *
 * @desc Scroll to a DOM element (same for jQuery object)
 * @example var second_child = document.getElementById('container').firstChild.nextSibling;
 *          $('#container').scrollTo( second_child, { duration:500, axis:'x', onAfter:function(){
 *              alert('scrolled!!');                                                                   
 *          }});
 *
 * @desc Scroll on both axes, to different values
 * @example $('div').scrollTo( { top: 300, left:'+=200' }, { axis:'xy', offset:-20 } );
 */

;(function( $ ){
    
    var $scrollTo = $.scrollTo = function( target, duration, settings ){
        $(window).scrollTo( target, duration, settings );
    };

    $scrollTo.defaults = {
        axis:'xy',
        duration: parseFloat($.fn.jquery) >= 1.3 ? 0 : 1,
        limit:true
    };

    // Returns the element that needs to be animated to scroll the window.
    // Kept for backwards compatibility (specially for localScroll & serialScroll)
    $scrollTo.window = function( scope ){
        return $(window)._scrollable();
    };

    // Hack, hack, hack :)
    // Returns the real elements to scroll (supports window/iframes, documents and regular nodes)
    $.fn._scrollable = function(){
        return this.map(function(){
            var elem = this,
                isWin = !elem.nodeName || $.inArray( elem.nodeName.toLowerCase(), ['iframe','#document','html','body'] ) != -1;

                if( !isWin )
                    return elem;

            var doc = (elem.contentWindow || elem).document || elem.ownerDocument || elem;
            
            return $.browser.safari || doc.compatMode == 'BackCompat' ?
                doc.body : 
                doc.documentElement;
        });
    };

    $.fn.scrollTo = function( target, duration, settings ){
        if( typeof duration == 'object' ){
            settings = duration;
            duration = 0;
        }
        if( typeof settings == 'function' )
            settings = { onAfter:settings };
            
        if( target == 'max' )
            target = 9e9;
            
        settings = $.extend( {}, $scrollTo.defaults, settings );
        // Speed is still recognized for backwards compatibility
        duration = duration || settings.duration;
        // Make sure the settings are given right
        settings.queue = settings.queue && settings.axis.length > 1;
        
        if( settings.queue )
            // Let's keep the overall duration
            duration /= 2;
        settings.offset = both( settings.offset );
        settings.over = both( settings.over );

        return this._scrollable().each(function(){
            var elem = this,
                $elem = $(elem),
                targ = target, toff, attr = {},
                win = $elem.is('html,body');

            switch( typeof targ ){
                // A number will pass the regex
                case 'number':
                case 'string':
                    if( /^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(targ) ){
                        targ = both( targ );
                        // We are done
                        break;
                    }
                    // Relative selector, no break!
                    targ = $(targ,this);
                case 'object':
                    // DOMElement / jQuery
                    if( targ.is || targ.style )
                        // Get the real position of the target 
                        toff = (targ = $(targ)).offset();
            }
            $.each( settings.axis.split(''), function( i, axis ){
                var Pos = axis == 'x' ? 'Left' : 'Top',
                    pos = Pos.toLowerCase(),
                    key = 'scroll' + Pos,
                    old = elem[key],
                    max = $scrollTo.max(elem, axis);

                if( toff ){// jQuery / DOMElement
                    attr[key] = toff[pos] + ( win ? 0 : old - $elem.offset()[pos] );

                    // If it's a dom element, reduce the margin
                    if( settings.margin ){
                        attr[key] -= parseInt(targ.css('margin'+Pos)) || 0;
                        attr[key] -= parseInt(targ.css('border'+Pos+'Width')) || 0;
                    }
                    
                    attr[key] += settings.offset[pos] || 0;
                    
                    if( settings.over[pos] )
                        // Scroll to a fraction of its width/height
                        attr[key] += targ[axis=='x'?'width':'height']() * settings.over[pos];
                }else{ 
                    var val = targ[pos];
                    // Handle percentage values
                    attr[key] = val.slice && val.slice(-1) == '%' ? 
                        parseFloat(val) / 100 * max
                        : val;
                }

                // Number or 'number'
                if( settings.limit && /^\d+$/.test(attr[key]) )
                    // Check the limits
                    attr[key] = attr[key] <= 0 ? 0 : Math.min( attr[key], max );

                // Queueing axes
                if( !i && settings.queue ){
                    // Don't waste time animating, if there's no need.
                    if( old != attr[key] )
                        // Intermediate animation
                        animate( settings.onAfterFirst );
                    // Don't animate this axis again in the next iteration.
                    delete attr[key];
                }
            });

            animate( settings.onAfter );            

            function animate( callback ){
                $elem.animate( attr, duration, settings.easing, callback && function(){
                    callback.call(this, target, settings);
                });
            };

        }).end();
    };
    
    // Max scrolling position, works on quirks mode
    // It only fails (not too badly) on IE, quirks mode.
    $scrollTo.max = function( elem, axis ){
        var Dim = axis == 'x' ? 'Width' : 'Height',
            scroll = 'scroll'+Dim;
        
        if( !$(elem).is('html,body') )
            return elem[scroll] - $(elem)[Dim.toLowerCase()]();
        
        var size = 'client' + Dim,
            html = elem.ownerDocument.documentElement,
            body = elem.ownerDocument.body;

        return Math.max( html[scroll], body[scroll] ) 
             - Math.min( html[size]  , body[size]   );
    };

    function both( val ){
        return typeof val == 'object' ? val : { top:val, left:val };
    };

})( jQuery );

/*
 * jQuery One Page Nav Plugin
 * http://github.com/davist11/jQuery-One-Page-Nav
 *
 * Copyright (c) 2010 Trevor Davis (http://trevordavis.net)
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://jquery.org/license
 *
 * @version 2.1
 *
 * Example usage:
 * $('#nav').onePageNav({
 *   currentClass: 'current',
 *   changeHash: false,
 *   scrollSpeed: 750
 * });
 */

;(function($, window, document, undefined){

	// our plugin constructor
	var OnePageNav = function(elem, options){
		this.elem = elem;
		this.$elem = $(elem);
		this.options = options;
		this.metadata = this.$elem.data('plugin-options');
		this.$nav = this.$elem.find('a');
		this.$win = $(window);
		this.sections = {};
		this.didScroll = false;
		this.$doc = $(document);
		this.docHeight = this.$doc.height();
	};

	// the plugin prototype
	OnePageNav.prototype = {
		defaults: {
			currentClass: 'current',
			changeHash: false,
			easing: 'swing',
			filter: '',
			scrollSpeed: 750,
			scrollOffset: 0,
			scrollThreshold: 0.5,
			begin: false,
			end: false,
			scrollChange: false
		},

		init: function() {
			var self = this;
			
			// Introduce defaults that can be extended either
			// globally or using an object literal.
			self.config = $.extend({}, self.defaults, self.options, self.metadata);
			
			//Filter any links out of the nav
			if(self.config.filter !== '') {
				self.$nav = self.$nav.filter(self.config.filter);
			}
			
			//Handle clicks on the nav
			self.$nav.on('click.onePageNav', $.proxy(self.handleClick, self));

			//Get the section positions
			self.getPositions();
			
			//Handle scroll changes
			self.bindInterval();
			
			//Update the positions on resize too
			self.$win.on('resize.onePageNav', $.proxy(self.getPositions, self));

			return this;
		},
		
		adjustNav: function(self, $parent) {
			self.$elem.find('.' + self.config.currentClass).removeClass(self.config.currentClass);
			$parent.addClass(self.config.currentClass);
		},
		
		bindInterval: function() {
			var self = this;
			var docHeight;
			
			self.$win.on('scroll.onePageNav', function() {
				self.didScroll = true;
			});
			
			self.t = setInterval(function() {
				docHeight = self.$doc.height();
				
				//If it was scrolled
				if(self.didScroll) {
					self.didScroll = false;
					self.scrollChange();
				}
				
				//If the document height changes
				if(docHeight !== self.docHeight) {
					self.docHeight = docHeight;
					self.getPositions();
				}
			}, 250);
		},
		
		getHash: function($link) {
			return $link.attr('href').split('#')[1];
		},
		
		getPositions: function() {
			var self = this;
			var linkHref;
			var topPos;
			
			self.$nav.each(function() {
				linkHref = self.getHash($(this));
				topPos = $('#' + linkHref).offset().top;
			
				self.sections[linkHref] = Math.round(topPos) - self.config.scrollOffset;
			});
		},
		
		getSection: function(windowPos) {
			var returnValue = null;
			var windowHeight = Math.round(this.$win.height() * this.config.scrollThreshold);

			for(var section in this.sections) {
				if((this.sections[section] - windowHeight) < windowPos) {
					returnValue = section;
				}
			}
			
			return returnValue;
		},
		
		handleClick: function(e) {
			var self = this;
			var $link = $(e.currentTarget);
			var $parent = $link.parent();
			var newLoc = '#' + self.getHash($link);
			
			if(!$parent.hasClass(self.config.currentClass)) {
				//Start callback
				if(self.config.begin) {
					self.config.begin();
				}
				
				//Change the highlighted nav item
				self.adjustNav(self, $parent);
				
				//Removing the auto-adjust on scroll
				self.unbindInterval();
				
				//Scroll to the correct position
				$.scrollTo(newLoc, self.config.scrollSpeed, {
					axis: 'y',
					easing: self.config.easing,
					offset: {
						top: -self.config.scrollOffset
					},
					onAfter: function() {
						//Do we need to change the hash?
						if(self.config.changeHash) {
							window.location.hash = newLoc;
						}
						
						//Add the auto-adjust on scroll back in
						self.bindInterval();
						
						//End callback
						if(self.config.end) {
							self.config.end();
						}
					}
				});
			}

			e.preventDefault();
		},
		
		scrollChange: function() {
			var windowTop = this.$win.scrollTop();
			var position = this.getSection(windowTop);
			var $parent;
			
			//If the position is set
			if(position !== null) {
				$parent = this.$elem.find('a[href$="#' + position + '"]').parent();
				
				//If it's not already the current section
				if(!$parent.hasClass(this.config.currentClass)) {
					//Change the highlighted nav item
					this.adjustNav(this, $parent);
					
					//If there is a scrollChange callback
					if(this.config.scrollChange) {
						this.config.scrollChange($parent);
					}
				}
			}
		},
		
		unbindInterval: function() {
			clearInterval(this.t);
			this.$win.unbind('scroll.onePageNav');
		}
	};

	OnePageNav.defaults = OnePageNav.prototype.defaults;

	$.fn.onePageNav = function(options) {
		return this.each(function() {
			new OnePageNav(this, options).init();
		});
	};
	
})( jQuery, window , document );
/*
* touchSwipe - jQuery Plugin
* https://github.com/mattbryson/TouchSwipe-Jquery-Plugin
* http://labs.skinkers.com/touchSwipe/
* http://plugins.jquery.com/project/touchSwipe
*
* Copyright (c) 2010 Matt Bryson (www.skinkers.com)
* Dual licensed under the MIT or GPL Version 2 licenses.
*
* $version: 1.3.3
*/(function(g){function P(c){if(c&&void 0===c.allowPageScroll&&(void 0!==c.swipe||void 0!==c.swipeStatus))c.allowPageScroll=G;c||(c={});c=g.extend({},g.fn.swipe.defaults,c);return this.each(function(){var b=g(this),f=b.data(w);f||(f=new W(this,c),b.data(w,f))})}function W(c,b){var f,p,r,s;function H(a){var a=a.originalEvent,c,Q=n?a.touches[0]:a;d=R;n?h=a.touches.length:a.preventDefault();i=0;j=null;k=0;!n||h===b.fingers||b.fingers===x?(r=f=Q.pageX,s=p=Q.pageY,y=(new Date).getTime(),b.swipeStatus&&(c= l(a,d))):t(a);if(!1===c)return d=m,l(a,d),c;e.bind(I,J);e.bind(K,L)}function J(a){a=a.originalEvent;if(!(d===q||d===m)){var c,e=n?a.touches[0]:a;f=e.pageX;p=e.pageY;u=(new Date).getTime();j=S();n&&(h=a.touches.length);d=z;var e=a,g=j;if(b.allowPageScroll===G)e.preventDefault();else{var o=b.allowPageScroll===T;switch(g){case v:(b.swipeLeft&&o||!o&&b.allowPageScroll!=M)&&e.preventDefault();break;case A:(b.swipeRight&&o||!o&&b.allowPageScroll!=M)&&e.preventDefault();break;case B:(b.swipeUp&&o||!o&&b.allowPageScroll!= N)&&e.preventDefault();break;case C:(b.swipeDown&&o||!o&&b.allowPageScroll!=N)&&e.preventDefault()}}h===b.fingers||b.fingers===x||!n?(i=U(),k=u-y,b.swipeStatus&&(c=l(a,d,j,i,k)),b.triggerOnTouchEnd||(e=!(b.maxTimeThreshold?!(k>=b.maxTimeThreshold):1),!0===D()?(d=q,c=l(a,d)):e&&(d=m,l(a,d)))):(d=m,l(a,d));!1===c&&(d=m,l(a,d))}}function L(a){a=a.originalEvent;a.preventDefault();u=(new Date).getTime();i=U();j=S();k=u-y;if(b.triggerOnTouchEnd||!1===b.triggerOnTouchEnd&&d===z)if(d=q,(h===b.fingers||b.fingers=== x||!n)&&0!==f){var c=!(b.maxTimeThreshold?!(k>=b.maxTimeThreshold):1);if((!0===D()||null===D())&&!c)l(a,d);else if(c||!1===D())d=m,l(a,d)}else d=m,l(a,d);else d===z&&(d=m,l(a,d));e.unbind(I,J,!1);e.unbind(K,L,!1)}function t(){y=u=p=f=s=r=h=0}function l(a,c){var d=void 0;b.swipeStatus&&(d=b.swipeStatus.call(e,a,c,j||null,i||0,k||0,h));if(c===m&&b.click&&(1===h||!n)&&(isNaN(i)||0===i))d=b.click.call(e,a,a.target);if(c==q)switch(b.swipe&&(d=b.swipe.call(e,a,j,i,k,h)),j){case v:b.swipeLeft&&(d=b.swipeLeft.call(e, a,j,i,k,h));break;case A:b.swipeRight&&(d=b.swipeRight.call(e,a,j,i,k,h));break;case B:b.swipeUp&&(d=b.swipeUp.call(e,a,j,i,k,h));break;case C:b.swipeDown&&(d=b.swipeDown.call(e,a,j,i,k,h))}(c===m||c===q)&&t(a);return d}function D(){return null!==b.threshold?i>=b.threshold:null}function U(){return Math.round(Math.sqrt(Math.pow(f-r,2)+Math.pow(p-s,2)))}function S(){var a;a=Math.atan2(p-s,r-f);a=Math.round(180*a/Math.PI);0>a&&(a=360-Math.abs(a));return 45>=a&&0<=a?v:360>=a&&315<=a?v:135<=a&&225>=a? A:45<a&&135>a?C:B}function V(){e.unbind(E,H);e.unbind(F,t);e.unbind(I,J);e.unbind(K,L)}var O=n||!b.fallbackToMouseEvents,E=O?"touchstart":"mousedown",I=O?"touchmove":"mousemove",K=O?"touchend":"mouseup",F="touchcancel",i=0,j=null,k=0,e=g(c),d="start",h=0,y=p=f=s=r=0,u=0;try{e.bind(E,H),e.bind(F,t)}catch(P){g.error("events not supported "+E+","+F+" on jQuery.swipe")}this.enable=function(){e.bind(E,H);e.bind(F,t);return e};this.disable=function(){V();return e};this.destroy=function(){V();e.data(w,null); return e}}var v="left",A="right",B="up",C="down",G="none",T="auto",M="horizontal",N="vertical",x="all",R="start",z="move",q="end",m="cancel",n="ontouchstart"in window,w="TouchSwipe";g.fn.swipe=function(c){var b=g(this),f=b.data(w);if(f&&"string"===typeof c){if(f[c])return f[c].apply(this,Array.prototype.slice.call(arguments,1));g.error("Method "+c+" does not exist on jQuery.swipe")}else if(!f&&("object"===typeof c||!c))return P.apply(this,arguments);return b};g.fn.swipe.defaults={fingers:1,threshold:75, maxTimeThreshold:null,swipe:null,swipeLeft:null,swipeRight:null,swipeUp:null,swipeDown:null,swipeStatus:null,click:null,triggerOnTouchEnd:!0,allowPageScroll:"auto",fallbackToMouseEvents:!0};g.fn.swipe.phases={PHASE_START:R,PHASE_MOVE:z,PHASE_END:q,PHASE_CANCEL:m};g.fn.swipe.directions={LEFT:v,RIGHT:A,UP:B,DOWN:C};g.fn.swipe.pageScroll={NONE:G,HORIZONTAL:M,VERTICAL:N,AUTO:T};g.fn.swipe.fingers={ONE:1,TWO:2,THREE:3,ALL:x}})(jQuery);

var delta = window.delta || {};

delta.dockableNavigation = (function($) {
    var scrollTimeout;
    var nav;
    var mainContainer;
    var pub = {}; // obj used to expose public vars and methods
    pub.init = function(containerToDock, mainContainer) {
        this.nav = containerToDock;
        this.mainContainer = mainContainer;
        this.makeContainerDockable();
        this.addDockingWithScroll();
    };
    function addDockingWithScroll(){
        // fixes and unfixes the main nav
        $(window).scroll(function(e) {
            var mainHeight = $(delta.dockableNavigation.getMainContainer()).offset().top;
            var windowHeight = $(window).scrollTop();
            if (mainHeight > windowHeight) {
                $(delta.dockableNavigation.getNavContainer()).removeClass('fixed');
            } else {
                $(delta.dockableNavigation.getNavContainer()).addClass('fixed');
            }
        });
    };
    function getMainContainer(){
        return this.mainContainer;
    };
    function getNavContainer(){
        return this.nav;
    };
    function makeContainerDockable(){
        $(delta.dockableNavigation.getNavContainer()).onePageNav({
            currentClass: 'active',
            changeHash: true,
            scrollSpeed: 600,
            scrollThreshold: 0.5,
            easing: 'easeInQuad',
            begin: function() {
                // hack so you can click other menu items after the initial click
                $('body').append('<div id="device-dummy" style="height: 1px;"></div>');
            },
            end: function() {
                $('#device-dummy').remove();
            },
            scrollChange: function($item) {
                var itemHash = $item.children('a').attr('href');
                $(itemHash).addClass('active');
            }
        });
    };
    pub.addDockingWithScroll = addDockingWithScroll;
    pub.makeContainerDockable = makeContainerDockable;
    pub.getMainContainer = getMainContainer;
    pub.getNavContainer = getNavContainer;
    return pub;
})(jQuery);


var delta = window.delta || {};
delta.collapsiblePanels = (function($) {
    var scrollTimeout;
    var panelSelector;
    var triggerSelector;
    var panels;
    var pub = {}; // obj used to expose public vars and methods
    pub.init = function(panelSelector, triggerSelector){
        this.panelSelector = panelSelector;
        this.triggerSelector = triggerSelector;
        this.panels = $(this.panelSelector);
        this.addPanelControls();
        this.applyPanelStyle();
    }
    function addPanelControls(){
        $(this.getTriggerSelector()).each(function(){
            $(this).on('click', function(e) {
                e.preventDefault();
                var $expandButton = $(this);
                var currentId = $(this).attr("id");
                var currentName=$(this).attr("name");
               
                //console.log('currentId: '+currentId);
                var targetRowCount=currentName.split("_")[1];
                var totalRowCount=currentName.split("_")[2];
                
                //console.log("targetRowCount"+targetRowCount);
                //console.log("totalRowCount"+totalRowCount);
               var rowCount=totalRowCount- targetRowCount;
               for(k=0;k<targetRowCount;k++){
                    
                    var rowID = rowCount+k;
                    //console.log("row ID: "+rowID);
                    var targetId = currentId.split("_")[0]+rowID+ "_last";
                   //console.log("targetId: "+targetId);
                    var $targetRow = $("#" + targetId);
                    if ($(this).hasClass('openState')) {
                        $targetRow.slideUp('slow', function() {
                        if(k==0){ 
                            $targetRow.prev().css('borderBottom', 0);
                        }
                            $expandButton.removeClass('openState');
                        });
                    } else {
                        $("#" + targetId + " .grid .highlight").each(function(){
                            $(this).attr("style",null);
                        })
                        $targetRow.slideDown('slow', function() {
                            //$targetRow.prev().css('borderBottom', 1);
                            $expandButton.addClass('openState');
                        });                       
                        ViewportHandler.matchHeight("#" + targetId + " .grid", ".highlight");
                        if(k==0){
                            $targetRow.prev().css('borderBottom', '1px solid #021322');
                        }
                    }
                }
                
            });
        });
    };
    function getPanelSelector(){
        return this.panelSelector;
    }
    function getTriggerSelector(){
        return this.triggerSelector;
    }
    function applyPanelStyle(){
        $(delta.collapsiblePanels.getPanelSelector()).each(function(ind, ele) {
            $(ele).children('.row:eq(1)').css('borderBottom', 0);
        });
    }
    pub.addPanelControls = addPanelControls;
    pub.getPanelSelector = getPanelSelector;
    pub.getTriggerSelector = getTriggerSelector;
    pub.applyPanelStyle = applyPanelStyle;
    return pub;
})(jQuery);


var delta = window.delta || {};

delta.fullbleedcarousel = (function($) {
    var pub = {};
    var slideInterval;
    var slideNav;
    var slideItems;
    var slideUL;
    pub.init = function(){
        delta.fullbleedcarousel.addNavBehavior();
        this.slideInterval = setInterval(function() { nextSlide(); }, 4000);
        try {
            $('div#fullBleedHeroContainer').swipe({
                swipeRight: function() {
                    window.clearInterval(slideInterval);
                    nextSlide();
                },
                swipeLeft: function() {
                    window.clearInterval(slideInterval);
                    prevSlide();
                }
            });
        } catch(error){}
    }
    function nextSlide() {
        var nextNum = delta.fullbleedcarousel.getSlide() + 1;
        if (nextNum >= $('nav.hero-slider li').length) {
            nextNum = 0;
        }
        delta.fullbleedcarousel.gotoSlide( nextNum );
    }
    function prevSlide() {
        var prevNum = delta.fullbleedcarousel.getSlide() - 1;
        if (prevNum < 0) {
            prevNum = $('nav.hero-slider li').length - 1;
        }
        delta.fullbleedcarousel.gotoSlide( prevNum );
    }
    function getSlide() {
        var slideNum = $('nav.hero-slider a.active').attr('href').substr(1);
        return parseFloat(slideNum);
    }
    function gotoSlide(num) {
        $('ul.slider-list li.active').fadeOut('slow');
        $('nav.hero-slider li a').removeClass('active');
        $('nav.hero-slider li:eq('+num+') a').addClass('active');
        $('ul.slider-list li:eq('+num+')').fadeIn('slow', function() {
            $('ul.slider-list a').removeClass('active');
            $(this).addClass('active');
        });
        return null;
    }
    function addNavBehavior(){
        $('nav.hero-slider a').click(function(e) {
            window.clearInterval(delta.fullbleedcarousel.slideInterval);
            gotoSlide( $(this).attr('href').substr(1) );
            return false;
        });
    }
    pub.nextSlide = nextSlide;
    pub.prevSlide = prevSlide;
    pub.getSlide = getSlide;
    pub.gotoSlide = gotoSlide;
    pub.addNavBehavior = addNavBehavior;
    return pub;
})(jQuery);

function adjustTabHeaders(){
    var minRuleWidth = 35;
    $(".tabpanelheader .yessubheader").each(function(){
        $subheader = $(this);
        var h2Width = $subheader.find("hgroup h2 span").outerWidth();
        var h4Width = $subheader.find("hgroup div h4").outerWidth();
        if(h2Width > h4Width){
            $subheader.find("hgroup").width(h2Width + 2*minRuleWidth);
            $subheader.find("hgroup h2").width(h2Width + 2*minRuleWidth);
            var spanWidth = ((h2Width + 2*minRuleWidth) - h4Width)/2;
            $subheader.find("hgroup div .rule").each(function(){
                $(this).width(spanWidth);
            });
        } else if(h2Width < h4Width) {
            $subheader.find("hgroup").width(h4Width + 2*minRuleWidth);
            $subheader.find("hgroup h2").width(h4Width + 2*minRuleWidth);
            $subheader.find("hgroup div .rule").each(function(){
                console.log(minRuleWidth)
                $(this).width(minRuleWidth);
            });
        } else {
            //donothing
        }
    })
}


