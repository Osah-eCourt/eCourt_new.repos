<!DOCTYPE html>
<html >
<head>

	<link rel="stylesheet" href="dojo-release-1.9.1/dojo-release-1.9.1/dijit/themes/claro/claro.css"> 
	<style type="text/css">
html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    overflow:hidden;
}

#borderContainerTwo {
    width: 100%;
    height: 100%;
}
	</style>
	<script>dojoConfig = {parseOnLoad: true}</script>
	<script src='dojo-release-1.9.1/dojo-release-1.9.1/dojo/dojo.js'></script>
	
	<script>
require(["dojo/parser", "dijit/layout/ContentPane", "dijit/layout/BorderContainer", "dijit/layout/TabContainer", "dijit/layout/AccordionContainer", "dijit/layout/AccordionPane","dojo/parser","dijit/TitlePane"]);
	</script>
</head>
<body class="claro">
 

    <?php include 'header3.html' ?>
   
  
    <div data-dojo-type="dijit/TitlePane" style="height:500px;" data-dojo-props="">
  <img src="Atlanta_Skyline_from_Buckhead.jpg" width="100%" height="500px;">
   </div>
  <!--  <div data-dojo-type="dijit/layout/AccordionContainer" data-dojo-props="minSize:20, region:'leading', splitter:true" style="width: 300px;" id="leftAccordion">
        <div data-dojo-type="dijit/layout/AccordionPane" title="One fancy Pane">
        </div>
        <div data-dojo-type="dijit/layout/AccordionPane" title="Another one">
        </div>
        <div data-dojo-type="dijit/layout/AccordionPane" title="Even more fancy" selected="true">
        </div>
        <div data-dojo-type="dijit/layout/AccordionPane" title="Last, but not least">
        </div>
    </div> end AccordionContainer -->
   

</body>
</html>