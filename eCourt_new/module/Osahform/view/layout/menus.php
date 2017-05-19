
<div data-dojo-type="dijit/layout/AccordionPane" id="Mainpane" title="CASES">      
 	
<div id="mainMenu" data-dojo-type="dijit/Menu"><br>
<!-- <div id="welcome" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform','_self');">Welcome </div> -->
<div id="edit" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/onlyform','_self');">Create New Case </div>
<div id="newcases" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/allcases','_self');">All Cases</div> 
<div id="mycases" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/mycases','_self');">My Cases</div>
<div id="view" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/casesbyjudges','_self');">By Judge</div>
<div id="view2" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/casesbyjudgeassistant','_self');"> By Judge Assistant</div>
<div id="task" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/search','_self');"> Search </div>
<!-- <div id="view3" data-dojo-type="dijit/MenuItem"> Closed Cases </div>  -->
<div id="view7" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/calendarreview','_self');"> Calendar Review </div>                       
      </div><!-- end of sub-menu -->                              </div>     
     
      <div data-dojo-type="dijit/layout/AccordionPane" id="judgecalendarpane1" title="Judge Calendar">
      <div id="CalendarMenu" data-dojo-type="dijit/Menu"><br>
      <div id="newcalendar" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/calendaronly','_self');">Create a New Calendar </div>
      
      <div id="judgecalendar" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/allcalendarforms','_self');">All Judge Calendars </div>
      
      <div id="casetypecalendar" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/calendarbyjudges','_self');">Calendar By Judge </div>
      
      <div id="agencycalendar" data-dojo-type="dijit/MenuItem" onclick="window.open('/Osahform/calendarbyjudgeassistants','_self');">Calendar By Judge Assistant </div>
      
    
      </div>
      </div>