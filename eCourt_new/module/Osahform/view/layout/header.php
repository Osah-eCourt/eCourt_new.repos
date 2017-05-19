<?php 

use Zend\Session\Container;
$session = new Container('base');
?>

<?php if($session->offsetExists('username')) {  ?> <?php
//$uname=str_replace('\n\', '',$session->offsetGet('username'));

//$uname=str_pad($session->offsetGet('username'), 5, "-", STR_PAD_RIGHT);
$uname=$session->offsetGet('username');

//$msg ='Welcome ';
//echo $msg . $uname; 

if (isset($_SESSION['username']) && (time() - $_SESSION['username'] > 1800)) {
	// last request was more than 30 minutes ago
	unset($_SESSION['username']);     // unset $_SESSION variable for the run-time
	$_SESSION['username'] = "false";
}


} ?>


 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!-- <link href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dijit/themes/claro/claro.css" rel="stylesheet" type="text/css"> -->
<!--<div data-dojo-type="dijit/layout/ContentPane" data-dojo-props="region:'top'"  style="color: #FFF"> -->
<!-- <div data-dojo-type="dijit/layout/ContentPane" data-dojo-props="region:'top'" > --> 

 
<!-- style="background-color:#8fb8cc;" --> 
<!--<div id="top"> -->
<!-- 
<table width="703"><tr><td>
<img src="/images/AdministrativeLawReport_Georgia.png" width="100" height="100" alt="osah" align="left" >
<!-- <script src='/js/json3.min.js'></script> -->
<!-- <h3 style="font-family:Verdana, Geneva, sans-serif; font-size:18px; color:#484500">OSAH - CASEMANAGEMENT SYSTEM</h1></td></tr></table> -->
<!--<p style="background-color:#036; color:#FFF;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home</p> -->


<!-- CODE STARTS HERE FOR HEADER -->

 <style>
.header-shadow12{
    background-image: url("/dl/header.jpg");
    width:100%;
    height:200px;
}
</style>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 <script>
 
  $(document).ready(function() {
     
		$("#nav-widget-mydelta").click(function(){
        $("#drpdwn1").slideToggle("slow");
		
		$("#drpdwn2").hide();
		$("#drpdwn24").hide();
		$("#drpdwn5").hide();
		// $("#drpdwn").slideDown("slow");
    });
	
	$("#nav-widget-booking").click(function(){
        $("#drpdwn2").slideToggle("slow");
		
		$("#drpdwn1").hide();
		$("#drpdwn5").hide();
		$("#drpdwn24").hide();
		// $("#drpdwn").slideDown("slow");
    });
	
	$("#test123").click(function(){
        $("#drpdwn5").slideToggle("slow");
		
		$("#drpdwn1").hide();
				$("#drpdwn2").hide();
				$("#drpdwn24").hide();
		// $("#drpdwn").slideDown("slow");
    });

	

$("#lblUser_Nm").click(function(){
       
		
		$("#lblUser_Nm").hide();
		// $("#drpdwn").slideDown("slow");
    });

$("#usernm").keydown(function(){
	$("#lblUser_Nm").hide();
});

$("#pwd").keydown(function(){
	$("#lblPwd").hide();
});

	$("#lblPwd").click(function(){
       
		
		$("#lblPwd").hide();
		// $("#drpdwn").slideDown("slow");
    });
	$("#nav-widget-checkin").click(function(){
        $("#drpdwn24").slideToggle("slow");
		
		$("#drpdwn1").hide();
				$("#drpdwn2").hide();
				$("#drpdwn5").hide();
		// $("#drpdwn").slideDown("slow");
    });
		//nav-widget-booking
    });
	</script>
	<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; -->
<div style="float:right"><br><br><br><br><img src="/images/AdministrativeLawReport_Georgia.png" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>	
<div class="header-shadow12" style="width:100%;height="150px;">

 <link rel="stylesheet" type="text/css" media="screen" href="/dl/widgetnav22.css">
 <link href="/dl/css22.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="/dl/home2.css">



 <nav id="nav-widget" class="">
	<section id="nav-widget-expander">
		<span class="minimized">↑</span>
		<span class="maximized">↓</span>
	</section>
    


<section id="nav-widget-user"> 

<!-- Not Logged in  -->


<div id="loginwidget" class="homepage loggedout">

		<div id="login">
			<form name="loginForm" id="loginForm" autocomplete="off" method="post" action="/Osahform/validatein">
				<input value="//www.delta.com" name="loginpath" class="setloginpath" type="hidden">
				<input value="" name="usernameType" class="usernameType" type="hidden">
				<input value="" name="passwordType" id="passwordType" type="hidden">
				<input value="homePg" name="homePg" id="homePg" type="hidden">
				<input value="" name="refreshURL" class="refreshURL" type="hidden">
				<!-- <input value="" name="username"  type="hidden">
				<input value="" name="password"  type="hidden"> -->
				<input value="" name="rememberMe" class="rememberMe" type="hidden">
				<input value="" name="BAUParams" id="BAUParams1" class="BAUParams" type="hidden">
				<input value="" name="formNameSubmitted" id="formNameSubmitted" type="hidden">
				<div class="loginWrapper">
				<?php if($session->offsetExists('username')) { ?>
				
				<div id="loginnav">
						<div class="">
							<div class="showLoginLinks"> <!-- Changes for login - as per styleguide - missed in the last build -->
							<br><br>
							<span class="loginDelta home-txt1"> <?php echo $uname;?><br>To <i>OSAH E-Court</i>  </span>
							<!-- <span class="loginDelta home-txt"><span class="login-ie">Welcome &nbsp;</span> OSAH</span> --> 
								<span class="loginDelta">&nbsp; | </span>
								<span class="signUp sign-up-now"><a href="/logout.php">Log Out<span class="login-ie">&nbsp;Now</span></a></span> 
							</div>
							<!-- <div class="showNotMe">
								<span class="notMe"></span>
								<span class="signUp linknotme">|&nbsp;<a href="#">Not Me</a></span>&nbsp;
							</div> -->
						</div>
					</div> 
				<?php } else { ?>
				
				 	<div id="loginnav">
						<div class="">
							<div class="showLoginLinks"> <!-- Changes for login - as per styleguide - missed in the last build -->
							<span class="loginDelta home-txt"><span class="login-ie">Log in To&nbsp;</span><i> OSAH E-Court</i></span> 
							<!--	<span class="loginDelta">&nbsp; | </span>
								<span class="signUp sign-up-now"><a href="https://www.delta.com/profile/enrolllanding.action">Sign Up<span class="login-ie">&nbsp;Now</span></a></span> -->
							</div>
							<!-- <div class="showNotMe">
								<span class="notMe"></span>
								<span class="signUp linknotme">|&nbsp;<a href="#">Not Me</a></span>&nbsp;
							</div> -->
						</div>
					</div> 
					<div id="loginnav1">
						<fieldset>
							<div id="loginFields">
								<div id="usernm-1" class="overlabel-wrapper">
								<!-- 	 -->
									 
									<label style="display: block; cursor: text;" for="usernm" class="overlabel overlabel-apply" id="lblUser_Nm" >Username</label>
									<input id="usernm" name="usernm" type="text">
										
								</div>
								<div id="pwd-1" class="overlabel-wrapper">
									<label style="display: block; cursor: text;" for="pwd" id="lblPwd" class="overlabel fixMe overlabel-apply">Password</label>  
									<input id="pwd" autocomplete="off" value="" name="pwd" mpdistrans="" type="password">

								</div>
								<div id="submit-1">
									<button role="button" type="submit" class="ui-button ui-button-secondary fancybox go-btn ui-widget ui-state-default ui-corner-all ui-button-text-only" name="" value="&gt;" id="submit1"><span class="ui-button-text">GO</span></button>
								</div>
							</div>  
							<!--<div id="remDiv">
								<div id="remberChkBox">
									<input class="remember_me" name="rememberme" type="checkbox">
								</div>
								<div id="remberLbl">
									<label for="rememberme" class="labelremember" id="lbl-remember-me">Remember Me</label>
								</div>
								
									<a href="https://www.delta.com/custlogin/validateUser.action?loginHelpPageName=forgotPassword" class="loginHelpLink2">Forgot Password</a>
									<a href="https://www.delta.com/custlogin/validateUser.action" class="loginHelpLink3">Forgot Login |</a> 
																	
							</div>-->
						</fieldset>
					</div> 
					
					<?php }?>
				</div> 
				
			</form>

		</div>
				
	</div>


</section>
 
<section style="width: 110px;" class="" id="nav-widget-status">
		<a href="/Osahform/validatein"><h3>Home</h3></a>		
	</section>


	<section style="width: 135px;" class="" id="nav-widget-mydelta">	
	           
    <nav id="utility-nav" class="clr" role="navigation">
    <a href="/Osahform/onlyform">	<h3>Docket New Cases</h3></a>     
     <!--   <div id="test1234"> </div>
        <ul class="row secondary clr">
            <li class="menu-item has-dropdown shop">
                
                
     
                    
                    <div id="drpdwn1" class="dropdown wide">
                        <ul>
                            
                                <li>
                                    <a href="/Osahform/onlyform">Create New Case
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                            
                                <li>
                                    <a href="/Osahform/allcases">All Cases
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                                 <li>
                                    <a href="/Osahform/casesbyjudges">By Judge
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                                 <li>
                                    <a href="/Osahform/casesbyjudgeassistant">By JudgeAssistant
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                            
                        </ul>
                    </div>                
            </li>
            
           
          
           
        </ul> --><!-- .secondary -->
    </nav><!-- .utilnav -->
    
	</section>   
    
    <section style="width: 115px;" class="" id="nav-widget-mydelta">
	<div id="test123">	<h3>Calendars</h3>  </div>       
    
    <nav id="utility-nav" class="clr" role="navigation">
        
        <ul class="row secondary clr">
            <li class="menu-item has-dropdown shop">
                
                
     
                    
                    <div id="drpdwn5" class="dropdown wide">
                        <ul>
                            
                                <li>
                                    <a href="/Osahform/calendaronly">Create New Calendars
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                            
                             <!--   <li>
                                    <a href="/Osahform/allcalendarforms">All Judges
                                    
                                        <small></small>
                                    
                                    </a>
                                </li> --> 
                                
                                 <li>
                                    <a href="/Osahform/calendarbyjudges">Judges
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                                 <li>
                                    <a href="/Osahform/calendarbyjudgeassistants">Assistants
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                            
                        </ul>
                    </div>                
            </li>
            
           
          
           
        </ul><!-- .secondary -->
    </nav><!-- .utilnav -->
    
	</section>   
    
	<section style="width: 110px;" class="" id="nav-widget-booking">
		<h3>All Cases</h3>
        
        
        <nav id="utility-nav" class="clr" role="navigation">
        
        <ul class="row secondary clr">
            <li class="menu-item has-dropdown shop">
                
                
     
                    
                    <div id="drpdwn2" class="dropdown wide">
                        <ul>
                            
                                <li>
                                    <a href="/Osahform/mycases">My Cases
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                            
                                <li>
                                    <a href="/Osahform/casesbyjudges">Judges
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                             <li>
                                    <a href="/Osahform/casesbyjudgeassistant">Assistants
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                        </ul>
                    </div>                
            </li>
            
           
          
           
        </ul><!-- .secondary -->
    </nav><!-- .utilnav -->
	</section>
	<section style="width: 165px;" class="" id="nav-widget-status">
	<a href="/Osahform/calendarreview">	<h3>Quick Calendar Review</h3></a>
	</section>
	<!-- <section style="width: 145px;" class="" id="nav-widget-checkin">
		<h3>Manager or Change Case</h3>
		
		 <nav id="utility-nav" class="clr" role="navigation">
        
        <ul class="row secondary clr">
            <li class="menu-item has-dropdown shop">
                
                
     
                    
                    <div id="drpdwn24" class="dropdown wide">
                        <ul>
                            
                                <li>
                                    <a href="/Osahform/casesbyjudges">By Judge
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                            
                                <li>
                                    <a href="/Osahform/casesbyjudges">By Judge Assistant
                                    
                                        <small></small>
                                    
                                    </a>
                                </li>
                            
                        </ul>
                    </div>                
            </li>
            
           
          
           
        </ul><!-- .secondary -->
  <!--  </nav><!-- .utilnav -->
<!--	</section> -->
	<section style="width: 110px;" class="" id="nav-widget-escape">
		<a href="/Osahform/search"><h3>Search</h3></a>		
	</section>








<!-- .nav-widget --> 


</nav>



</div>



   
<!-- CODE ENDS HERE FOR HEADER -->
<!-- <center>

    <img src="banner.png" width="464" height="62" align="left" />  </center>-->
   <!--  
    
  </div> -->

 
<!--</div> -->
<!-- <p style="background-color:#036; color:#FFF;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p> -->
  <!-- </div>   CONTENT PANE CODE ENDS HERE-->  
   
 
 
    <!--    ALL STYLE SHEET DEFINETIONS : STARTS HERE  -->
     <link rel="stylesheet" href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dijit/themes/claro/claro.css">
	
	<link rel="stylesheet" href="/css/css/style.css"> 
	<link rel="stylesheet" href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dojo/resources/dojo.css"> 
	<link rel="stylesheet" href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dojox/grid/enhanced/resources/claro/EnhancedGrid.css">
	<link rel="stylesheet" href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dojox/grid/enhanced/resources/EnhancedGrid_rtl.css"> 
	<link href="/css/css/Form_SSheet.css" rel="stylesheet" type="text/css" media="screen">
      <link href="/css/css/PrintForm_SSheet.css" rel="stylesheet" type="text/css" media="print"> 
	
	<!--  <link href="/required/UploaderFileList.css" rel="stylesheet" /> -->
      <link href="/js/dojo-release-1.9.1-src/dojo-release-1.9.1-src/dojox/grid/resources/claroGrid.css" rel="stylesheet" />
	
	
	
	<link href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dijit/themes/dijit.css" rel="stylesheet" />
	<link href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dijit/themes/claro/Common.css" rel="stylesheet" />
	<link href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dijit/themes/claro/form/Common.css" rel="stylesheet" />
	<link href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dijit/themes/claro/form/Button.css" rel="stylesheet" />
	<link href="/js/dojo-release-1.9.1/dojo-release-1.9.1/dojox/form/resources/UploaderFileList.css" rel="stylesheet" />  
	
	
	
	      <style type="text/css">
                        
            /* @import "{{baseUrl}}dojox/grid/resources/claroGrid.css"; */

            /*Grid needs an explicit height by default*/
            #gridDiv {
                    height: 25em;
                    }

            html, body {
                    width: 100%;
                    height: 100%;
                    margin: 0;
                        }
	           .demoHeaders {		margin-top: 2em;
                        }
                .demoHeaders {		margin-top: 2em;
                    }
                    
                                        
	 /* File upload CSS begins here  */
	 
	 
	 @import "/js/dojo-release-1.9.1/dojo-release-1.9.1/dijit/tests/css/dijitTests.css";
		
		.browseButton{
			width:300px;
			/*height:20px;*/
			font-weight:bold;
			margin:1px 0 2px 0;
		}
		.dijitTabPane{
			padding:20px;
		}
		fieldset{
			text-align:right;
			padding: 5px;
		}
		input[type=text]{
			width:135px;
		}
		.dijitButton{
			margin-top:15px;
		}
		.dojoxUploaderFileList{
			text-align:left;
			margin-top:10px;
		}
		.pageTable{
			width:100%;
		}
		.pageTable td{
			vertical-align:top;
		}
		#colForm{
			width:330px;
		}
		#colImages{
			padding-top:7px;
		}
		.thumb{
			border:1px solid #ccc;
			padding:5px;
			width:123px;
			background:#eee;
			float:left;
			margin:0 5px 5px 0;
		}
		.thumbbk{
			background:#fff;
			display:block;
		}
		.thumb img{
			border:1px solid #ccc;
			width:120px;
		}
		.form, .html5, .iframe, .flash{
			display:none;
		}
		.Form .form, .HTML5 .html5, .IFrame .iframe, .Flash .flash{
			display:block;
		}
		#dialog p{
			width:310px;
		}
		form{
			margin-bottom:15px;
		}
		code{
			font-family:monospace;
			white-space:nowrap;
		}
		.browseButton, .browseButton .dijitButton, .browseButton .dijitButtonNode {
			display:block;
		}
		.dijitUploadDisplayInput {
			width:100px;
		}
		
		/* File upload ends here */
		
/* @import "{{baseUrl}}dojox/grid/resources/claroGrid.css"; */

/*Grid needs an explicit height by default*/
	/*height: 40em;	
#Grid1 {
        width: 1000px;
        height: auto;
    }
    #Grid1 .dgrid-scroller {
        position: relative;
        overflow-y: hidden;
    }
    .has-ie-6 #Grid1 .dgrid-scroller {
        /* IE6 doesn't react properly to hidden on this page for some reason 
        overflow-y: visible;
    } */

#gridDiv1 {
                    height: 40em;
                    }
#gridDiv4 {
    height: 40em;
}


#gridDiv23 {
    height: 40em;

}
         
           </style>