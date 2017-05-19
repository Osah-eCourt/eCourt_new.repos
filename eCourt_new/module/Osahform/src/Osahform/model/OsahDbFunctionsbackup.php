<?php
namespace Osahform\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Log\Writer\Stream as LogWriter;
use Zend\Config\Reader\Ini as ConfigReader;
use Zend\Config\Config;
use Zend\Log\Logger;

use Zend\Log\Filter\Priority as LogFilter;


Class OsahDbFunctions
{
     
    public function getAgencyCode($db)
    {
    
    	// $db=$this->serviceLocator->get('test');
        	
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `agency` ORDER BY Agencycode ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    		    
    		    
    		    if($i == 0)
    		    {
    		    
    		    	$arraylist="{id:".$row->AgencyID .", name : '". $row->Agencycode . "'}" ;
    		    
    		    }
    		    else
    		    {
    		    	$arraylist=$arraylist.",{id :".$row->AgencyID .", name : '". $row->Agencycode . "'}" ;
    		    
    		    }
    		    
    			
    			$i = $i +1;
    		}// end of for loop
    			
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    	
    }
    
    
    public function getDispositionCode($db)
    {
    
    	// $db=$this->serviceLocator->get('test');
    	 
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `disposition` ORDER BY dispositioncode ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    
    			if($i == 0)
    			{
    
    				$arraylist="{id:".$row->idDisposition .", name : '". $row->dispositioncode . "'}" ;
    
    			}
    			else
    			{
    				$arraylist=$arraylist.",{id :".$row->idDisposition .", name : '". $row->dispositioncode . "'}" ;
    
    			}
    
    			 
    			$i = $i +1;
    		}// end of for loop
    		 
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    	 
    }
    
    public function getHearingMode($db)
    {    
    	// $db=$this->serviceLocator->get('test');    	 
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `hearingmode` ORDER BY HearingValues ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    		if($i == 0)
    			{
      				$arraylist="{id:".$row->id .", name : '". $row->HearingValues . "'}" ;
       			}
    			else
    			{
    				$arraylist=$arraylist.",{id :".$row->id .", name : '". $row->HearingValues . "'}" ;
       			}
    
    			$i = $i +1;
    		}// end of for loop
    		 
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    	 
    }
    
    Public function getCalendarByJudge($db, $judge)
    {
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `calendarform` where Judge="' . $judge . '"';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			$caseid11="<a href=\'/Osahform/newcalendar?docketno=\"" . $row->Calendarid . "\"\'>" . $row->Judge . "</a>";
    			//$caseid11="";
    			if($i == 0)
    			{
    				 
    				$arraylist="{col2 : '" . $caseid11 . "', col3 : '" . $row->Judgassistant . "', col4: '" . $row->Hearingsite . "', col5: '" . $row->Castypegroup . "', col6: '" . $row->Hearingtime . "' }";
    				 
    			}
    			else
    			{
    				$arraylist=$arraylist.", {col2 : '" . $caseid11 . "', col3 : '" . $row->Judgassistant . "', col4: '" . $row->Hearingsite . "', col5: '" . $row->Castypegroup . "', col6: '" . $row->Hearingtime . "' }";
    				 
    			}
    			 
    
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		return $arraylist;
    	}//end of if loop
    	 
    	return "";
    }
    
    
    
    Public function getCaseByJudge($db, $judge)
    {
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `docket` where judge="' . $judge . '"';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			$caseid11="<a href=\'/Osahform/newform?docketno=\"" . $row->caseid . "\"\'>" . $row->judge . "</a>";
    			//$caseid11="";
    			if($i == 0)
    			{    					
    				$arraylist="{col2 : '" . $caseid11 . "', col3 : '" . $row->judgeassistant . "', col4: '" . $row->hearingsite . "', col5: '" . $row->refagency . "', col6: '" . $row->casetype  . "', col7: '" . $row->hearingtime . "', col8: '" . $row->hearingdate . "', col9: '" . $row->county . "', col10: '" .$row->datereceivedbyOSAH . "', col11: '" . $row->caseid . "'}";
    			}
    			else
    			{
    				$arraylist=$arraylist.", {col2 : '" . $caseid11 . "', col3 : '" . $row->judgeassistant . "', col4: '" . $row->hearingsite . "', col5: '" . $row->refagency . "', col6: '" . $row->casetype  . "', col7: '" . $row->hearingtime . "', col8: '" . $row->hearingdate . "', col9: '" . $row->county . "', col10: '" .$row->datereceivedbyOSAH . "', col11: '" . $row->caseid . "'}";    				
    			}
    
    
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    }
    
    
    Public function getCaseByJudgeAssistant($db, $judge)
    {
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `docket` where judgeassistant="' . $judge . '"';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			$caseid11="<a href=\'/Osahform/newform?docketno=\"" . $row->caseid . "\"\'>" . $row->judge . "</a>";
    			//$caseid11="";
    			if($i == 0)
    			{
    				$arraylist="{col2 : '" . $caseid11 . "', col3 : '" . $row->judgeassistant . "', col4: '" . $row->hearingsite . "', col5: '" . $row->refagency . "', col6: '" . $row->casetype  . "', col7: '" . $row->hearingtime . "', col8: '" . $row->hearingdate . "', col9: '" . $row->county . "', col10: '" .$row->datereceivedbyOSAH . "', col11: '" . $row->caseid . "'}";
    			}
    			else
    			{
    				$arraylist=$arraylist.", {col2 : '" . $caseid11 . "', col3 : '" . $row->judgeassistant . "', col4: '" . $row->hearingsite . "', col5: '" . $row->refagency . "', col6: '" . $row->casetype  . "', col7: '" . $row->hearingtime . "', col8: '" . $row->hearingdate . "', col9: '" . $row->county . "', col10: '" .$row->datereceivedbyOSAH . "', col11: '" . $row->caseid . "'}";
    			}
    
    
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    }
    
    
    Public function getCaseBySearch($db, $judge)
    {
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `docket` where ' . $judge ;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			$caseid11="<a href=\'/Osahform/newform?docketno=\"" . $row->caseid . "\"\'>" . $row->judge . "</a>";
    			//$caseid11="";
    			if($i == 0)
    			{
    				$arraylist="{col2 : '" . $caseid11 . "', col3 : '" . $row->judgeassistant . "', col4: '" . $row->hearingsite . "', col5: '" . $row->refagency . "', col6: '" . $row->casetype  . "', col7: '" . $row->hearingtime . "', col8: '" . $row->hearingdate . "', col9: '" . $row->county . "', col10: '" .$row->datereceivedbyOSAH . "', col11: '" . $row->caseid . "'}";
    			}
    			else
    			{
    				$arraylist=$arraylist.", {col2 : '" . $caseid11 . "', col3 : '" . $row->judgeassistant . "', col4: '" . $row->hearingsite . "', col5: '" . $row->refagency . "', col6: '" . $row->casetype  . "', col7: '" . $row->hearingtime . "', col8: '" . $row->hearingdate . "', col9: '" . $row->county . "', col10: '" .$row->datereceivedbyOSAH . "', col11: '" . $row->caseid . "'}";
    			}
    
    
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    }
    
    Public function getAttorneyInfo($caseid, $db){
    	
    	$sql="SELECT * FROM `attorneybycase` where caseid='" . $caseid . "' and typeofcontact='Petitioner Attorney'";
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    	
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			 
    		   	$attorneyids[$i]=$row->attorneyid;		 
    	          
    			$i= $i + 1;
    			
    	}// end of for loop
    	
    	if($i !=0)
    	{
    		$attorneynames="";
    		$i=0;
    	foreach ($attorneyids as $attid)
    	{
    		$sql2="SELECT * FROM `attorney` where Attorneyid='" . $attid ."'";
    		$statement2=$db->createStatement($sql2);
    		$result2 = $statement2->execute();
    		$arraylist2="";
    		if ($result2 instanceof ResultInterface && $result2->isQueryResult())
    		{
    			$resultSet2 = new ResultSet;
    			$resultSet2->initialize($result2);
    			//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    			
    			
    			foreach ($resultSet2 as $row2) {
    				 
    				//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    				// /Osahform/newform
    				
    				if($i!=0)
    				{
    				$attorneynames=$attorneynames . ",<br>" . $row2->Lastname . " " . $row2->Firstname;
    				}
    				else
    				{
    					$attorneynames= $row2->Lastname . " " . $row2->Firstname;
    				}
    				
    				$i= $i + 1;
    				 
    			}// end of for loop
    		}   
    	}
    	}
    	
    		if ($i != 0)
    		{
    			return $attorneynames;
    		}
    		else 
    		{
    			return "Not Listed";
    		}
    		$i=0;
    	}//end of if loop
    	
    	return "";
    	
    	
    }

    public function getCaseWorkerInfo($caseid, $db)
    {
    	$sql="SELECT * FROM `agencycaseworkerbycase` where caseid='" . $caseid . "' and (typeofcontact='Case Worker' or typeofcontact='Investigator' or typeofcontact='Officer' )";
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    			 
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    	
    			$attorneyids[$i]=$row->contactid;
    			 
    			$i= $i + 1;
    			 
    		}// end of for loop
    		 
    		if($i !=0)
    		{
    			$attorneynames="";
    			$i=0;
    			foreach ($attorneyids as $attid)
    			{
    				$sql2="SELECT * FROM `agencycaseworkercontact` where Contactid='" . $attid ."'";
    				$statement2=$db->createStatement($sql2);
    				$result2 = $statement2->execute();
    				$arraylist2="";
    				if ($result2 instanceof ResultInterface && $result2->isQueryResult())
    				{
    					$resultSet2 = new ResultSet;
    					$resultSet2->initialize($result2);
    					//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    					 
    					 
    					foreach ($resultSet2 as $row2) {
    							
    						//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    						// /Osahform/newform
    	
    						if($i!=0)
    						{
    							$attorneynames=$attorneynames . ",<br>" . $row2->LastName . " " . $row2->FirstName;
    						}
    						else
    						{
    							$attorneynames= $row2->LastName . " " . $row2->FirstName;
    						}
    	
    						$i= $i + 1;
    							
    					}// end of for loop
    				}
    			}
    		}
    		 
    		if ($i != 0)
    		{
    			return $attorneynames;
    		}
    		else
    		{
    			return "Not Listed";
    		}
    		$i=0;
    	}//end of if loop
    	 
    	return "";
    	 
    }
    Public function getCalendarCases($db, $judge)
    {
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `docket` where ' . $judge ;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			
    			$attorneyinfo=$this->getAttorneyInfo($row->caseid,$db);
    			$caseworkerinfo=$this->getCaseWorkerInfo($row->caseid,$db);
    			$caseid11="<a href=\'/Osahform/newform?docketno=\"" . $row->caseid . "\"\'>" . $row->judge . "</a>";
    			//$caseid11="";
    			if($i == 0)
    			{
    				$arraylist="{col1 : '" . $row->docketnumber . "', col10: '" . $attorneyinfo . "', col11: '" . $caseworkerinfo . "', col9: '" . $row->county . "', col2 : '" . $caseid11 . "', col3 : '" . $row->judgeassistant . "', col4: '" . $row->hearingsite . "', col7: '" . $row->hearingtime . "', col8: '" . $row->hearingdate .  "'}";
    			}
    			else
    			{
    				//$row->docketnumber
    				$arraylist=$arraylist.", {col1 : '" .  $row->docketnumber .  "', col10: '" . $attorneyinfo . "', col11: '" . $caseworkerinfo . "', col9: '" . $row->county . "', col2 : '" . $caseid11 . "', col3 : '" . $row->judgeassistant . "', col4: '" . $row->hearingsite . "', col7: '" . $row->hearingtime . "', col8: '" . $row->hearingdate . "'}";
    			}
    
    
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    }
    
    
    
    
    
    Public function getCalendarByJudgeAssistant($db, $judgeassistant)
    {
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `calendarform` where Judgassistant="' . $judgeassistant . '"';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			$caseid11="<a href=\'/Osahform/newcalendar?docketno=\"" . $row->Calendarid . "\"\'>" . $row->Judge . "</a>";
    			//$caseid11="";
    			if($i == 0)
    			{
    					
    				$arraylist="{col2 : '" . $caseid11 . "', col3 : '" . $row->Judgassistant . "', col4: '" . $row->Hearingsite . "', col5: '" . $row->Castypegroup . "', col6: '" . $row->Hearingtime . "' }";
    					
    			}
    			else
    			{
    				$arraylist=$arraylist.", {col2 : '" . $caseid11 . "', col3 : '" . $row->Judgassistant . "', col4: '" . $row->Hearingsite . "', col5: '" . $row->Castypegroup . "', col6: '" . $row->Hearingtime . "' }";
    					
    			}
    
    
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    }
    
    
    Public function getAllCalendarForms($db)
    {
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `calendarform`';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    			 
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			$caseid11="<a href=\'/Osahform/newcalendar?docketno=\"" . $row->Calendarid . "\"\'>" . $row->Judge . "</a>";
    			//$caseid11="";
    			if($i == 0)
    			{
    	
    				$arraylist="{col2 : '" . $caseid11 . "', col3 : '" . $row->Judgassistant . "', col4: '" . $row->Hearingsite . "', col5: '" . $row->Castypegroup . "', col6: '" . $row->Hearingtime . "' }";
    	
    			}
    			else
    			{
    				$arraylist=$arraylist.", {col2 : '" . $caseid11 . "', col3 : '" . $row->Judgassistant . "', col4: '" . $row->Hearingsite . "', col5: '" . $row->Castypegroup . "', col6: '" . $row->Hearingtime . "' }";
    	
    			}
    	
    			 
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		return $arraylist;
    	}//end of if loop
    	
    	return "";
    }
    
    
  public function getAllCases($db)
  {
      //$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
      $sql='SELECT * FROM `docket`';
      $statement=$db->createStatement($sql);
      $result = $statement->execute();
      $arraylist="";
      if ($result instanceof ResultInterface && $result->isQueryResult())
      {
      	$resultSet = new ResultSet;
      	$resultSet->initialize($result); 
      	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
      	$i=0;
      	foreach ($resultSet as $row) {
      	    
      		//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
      	   // /Osahform/newform
      	    $caseid11="<a href=\'/Osahform/newform?docketno=\"" . $row->caseid . "\"\'>" . $row->caseid . "</a>";
      		//$caseid11="";
      		if($i == 0)
      		{
      
      			$arraylist="{col1 : '". $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }" ;
      
      		}
      		else
      		{
      			$arraylist=$arraylist.",{col1 : '".  $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }"  ;
      
      		}
      
      		 
      		$i = $i +1;
      	}// end of for loop
      //	$arraylist = $arraylist + "]";
      	return $arraylist;
      }//end of if loop
      
      return "";
      
  }
  
  
   public function getDocketInfo($db, $docketno)
  {
  	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
  //	$sql='SELECT * FROM `docket`';
  	
  	$sql='SELECT * FROM docket where caseid=' . $docketno;
  	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		foreach ($resultSet as $row) {
  			 
  			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
  			// /Osahform/newform
  			//$caseid11="<a href=\'/Osahform/newform?docketno=\"" . $row->caseid . "\"\'>" . $row->caseid . "</a>";
  			//$caseid11="";
  			if($i == 0)
  			{
    

  			    $post_data = array('docketnumber' => $row->docketnumber,
  			    		'docketclerk' => $row->docketclerk,
  			    		'hearingreqby' => $row->hearingreqby,
  			    		'status' => $row->status,
  			            'daterequested' => $row->daterequested,
  			    		'datereceivedbyOSAH' => $row->datereceivedbyOSAH,
  			    		'refagency' => $row->refagency,
  			            'casetype' => $row->casetype,
  			    		'casefiletype' => $row->casefiletype,
  			    		'county' => $row->county,
  			            'agencyrefnumber' => $row->agencyrefnumber,
  			    		'hearingmode' => $row->hearingmode,
  			            'hearingsite' => $row->hearingsite,
  			    		'hearingdate' => $row->hearingdate,
  			    		'hearingtime' => $row->hearingtime,
  			             'judge' => $row->judge,
  			            'judgeassistant' => $row->judgeassistant,
  			    		'hearingrequesteddate' => $row->hearingrequesteddate,
  			    		'others' => $row->others);
  			    
  			    $post_data = json_encode($post_data);
  			//    $arraylist="1 : '". $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }" ;
  
  			}
  			
  
  			 
  			$i = $i +1;
  		}// end of for loop
  		//	$arraylist = $arraylist + "]";
  		return $post_data;
  	}//end of if loop
  
  	return "";
  
  }
  
  Public function getAllSupDocuments($db, $docketno)
  {
      //$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
      //$sql='SELECT * FROM `docket`';
      $sql='SELECT * FROM `documentstable` where `caseid`='.$docketno;
      // 	$sql='SELECT * FROM docket where caseid='1300001'';
      $statement=$db->createStatement($sql);
      $result = $statement->execute();
      $arraylist="";
      $ids="noids";
      $flag=0;
      $filepath1="";
      $filepath2="";
      
      if ($result instanceof ResultInterface && $result->isQueryResult())
      {
      	$resultSet = new ResultSet;
      	$resultSet->initialize($result);
      	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
      	$i=0;
      	//$ids="";
      	
      	//filepath2= "/upload/" + dojo.byId("docketnum12").value + "/"+ file1.name;
      	//filepath1="<a href='/upload/" + dojo.byId("docketnum12").value + "/"+ file1.name +"' target='_new'>" + file1.name   +  "</a>";
      	$stt="";
      	foreach ($resultSet as $row) {
      		$filepath4="";
      		
      		$sql2='SELECT * FROM `Attachmentpaths` where `documentid`=' . $row->documentid;
			$statement2=$db->createStatement($sql2);
      		$result2 = $statement2->execute();
      		$stt=$stt . $sql2;
      		if ($result2 instanceof ResultInterface && $result2->isQueryResult())
      		{
      			$resultSet2 = new ResultSet;
      			$resultSet2->initialize($result2);
      			$filepath4="<ol>";
      			foreach ($resultSet2 as $row2) {
      				$filepath2= $row2->attachmentpath;
      			//	$filepath4="sdfsdf" . $row2->attachmentpath;
      				$pos1=strripos($filepath2, "/");
      				$filepath1 = substr($filepath2, $pos1);
      				$filepath1 = ltrim($filepath1, "/");
      				$filepath4=$filepath4 . "<li><a href=\'" .  $filepath2 . "\' target=\'_new\'>" .  $filepath1  .  "</a></li>";
      				
      			}
      			$filepath4=$filepath4 . "</ol>";
      		}
      
      		  if($i == 0)
      		  {
      		  	$arraylist= "{col1 : '" . $row->DocumentName . "', col2 : '" . $row->DocumentType . "', col3: '" . $row->Description . "', col4: '" . $row->Granted . "', col5: '" . $row->DateRequested . "', col6: '" . $filepath4 . "'}";
      		   $ids= $row->documentid;
      		  	$flag=1;
      		  }
      		  else
      		  {
      		  	
      		  	$arraylist= $arraylist . ",{col1 : '" . $row->DocumentName . "', col2 : '" . $row->DocumentType . "', col3: '" . $row->Description . "', col4: '" . $row->Granted . "', col5: '" . $row->DateRequested . "', col6: '" . $filepath4 . "'}";
      		  	$ids=$ids . "+" . $row->documentid;
      		  }
      		  
      		$i = $i +1;
      	}
     	
       }//en
      
      
      return  array($arraylist, $ids);
      
  }
  
  
  
  public function getCalendarHistory($db, $docketno)
  {
  	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
  	//$sql='SELECT * FROM `docket`';
  	$sql='SELECT * FROM `calendarhistory` where `Calendarid`='.$docketno;
  	// 	$sql='SELECT * FROM docket where caseid='1300001'';
  	
  //	echo $sql;
  	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  	$flag=0;
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		foreach ($resultSet as $row) {
  			/* var layout = [[
  			 {name: 'Date', field: 'col2', width: "80px"},
  			{name: 'Notes/Summary', field: 'col3', width: "600px"},
  			{name: 'Updated By', field: 'col4', width: "150px"},
  			]]; */
  	
  	
  			$date1= date_create($row->Date);
  			$requedate=date_format($date1, 'm/d/Y');
  	
  			if($i == 0)
  			{
  				 
  				//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$arraylist= "{col2 : '" . $requedate . "', col3 : '" . $row->Description . "', col4: '" . $row->Modifiedby . "'}" ;
  				//$flag=1;
  				//$ids= $row->peopleid;
  				 
  				//$
  				///$arraylist="tewe";
  			}
  	
  			else
  			{
  				/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "',
  				 col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
  				col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
  				col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
  				col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
  				col20: '" . $row->Zip . "'}";  */
  				 
  				$arraylist= $arraylist . ", {col2 : '" . $requedate . "', col3 : '" . $row->Description . "', col4: '" . $row->Modifiedby . "'}";
  					
  			}
  	
  			$i = $i +1;
  		}// end of for loop
  		  		 
  	}//end o
  	 
  	return  $arraylist;
  	
  }
  
  public function getHistory($db, $docketno)
  {
  	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
  	//$sql='SELECT * FROM `docket`';
  	$sql='SELECT * FROM `history` where `caseid`='.$docketno;
  	// 	$sql='SELECT * FROM docket where caseid='1300001'';
  	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  	$flag=0;
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		foreach ($resultSet as $row) {
  			/* var layout = [[
  			 {name: 'Date', field: 'col2', width: "80px"},
  			{name: 'Notes/Summary', field: 'col3', width: "600px"},
  			{name: 'Updated By', field: 'col4', width: "150px"},
  			]]; */
  			 
  			 
  			$date1= date_create($row->date);
  			$requedate=date_format($date1, 'm/d/Y');
  			 
  			if($i == 0)
  			{
  	
  				//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$arraylist= "{col2 : '" . $requedate . "', col3 : '" . $row->Description . "', col4: '" . $row->Modifiedby . "'}" ;
  				//$flag=1;
  				//$ids= $row->peopleid;
  	
  				//$
  				///$arraylist="tewe";
  			}
  			 
  			else
  			{
  				/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "',
  				 col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
  				col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
  				col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
  				col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
  				col20: '" . $row->Zip . "'}";  */
  	
  				$arraylist= $arraylist . ", {col2 : '" . $requedate . "', col3 : '" . $row->Description . "', col4: '" . $row->Modifiedby . "'}";
  				 
  				 
  				//  $arraylist="test";
  			}
  			 
  			$i = $i +1;
  		}// end of for loop
  		//	$arraylist = $arraylist + "]";
  		//return "inside loop";
  	
  		//return  array($arraylist, $ids);
  	
  	}//end o
  	
  	return  $arraylist;
  }
  
  public function getSummary($db, $docketno)
  {
      
      //$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
      //$sql='SELECT * FROM `docket`';
      $sql='SELECT * FROM `summarytable` where `caseid`='.$docketno;
      // 	$sql='SELECT * FROM docket where caseid='1300001'';
      $statement=$db->createStatement($sql);
      $result = $statement->execute();
      $arraylist="";
      $flag=0;
      if ($result instanceof ResultInterface && $result->isQueryResult())
      {
      	$resultSet = new ResultSet;
      	$resultSet->initialize($result);
      	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
      	$i=0;
      	$ids="";
      	foreach ($resultSet as $row) {
      	    /* var layout = [[
      	    {name: 'Date', field: 'col2', width: "80px"},
      	    {name: 'Notes/Summary', field: 'col3', width: "600px"},
      	    {name: 'Updated By', field: 'col4', width: "150px"},
      	    ]]; */
      	    
      	    
      	    $date1= date_create($row->date);
      	    $requedate=date_format($date1, 'm/d/Y');
      	    
      		if($i == 0)
      		{
      
      			//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
      			$arraylist= "{col2 : '" . $requedate . "', col3 : '" . $row->summarynotes . "', col4: '" . $row->updatedby . "', col6: '" . $row->id . "'}" ;
      			//$flag=1;
      			//$ids= $row->peopleid;
      
      			//$
      			///$arraylist="tewe";
      		}      			
      		else
      		{
      			/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "',
      			 col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
      			col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
      			col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
      			col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
      			col20: '" . $row->Zip . "'}";  */
      
      			$arraylist= $arraylist . ", {col2 : '" . $requedate . "', col3 : '" . $row->summarynotes . "', col4: '" . $row->updatedby . "', col6: '" . $row->id . "'}";
  	   		}
     		$i = $i +1;
      		}// end of for loop
      		//	$arraylist = $arraylist + "]";
      		//return "inside loop";
      
      		//return  array($arraylist, $ids);
      
      }//end o
      
      return  $arraylist;
  }
  
  
  Public function getAllDates($db, $docketno)
  {
  	
  	
  	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
  	//$sql='SELECT * FROM `docket`';
  	$sql='SELECT * FROM `schedule` where `Calendarid`='.$docketno;
  	//echo $sql;
  	$arraylist=$sql;
  	// 	$sql='SELECT * FROM docket where caseid='1300001'';
 	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  	$flag=0;
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		foreach ($resultSet as $row) {
  	      if($i == 0)
  			{
  				
  				$date1= date_create($row->cutoffdate);
  				$cutoffdate=date_format($date1, 'm/d/Y');
  				
  				$date2= date_create($row->hearingdate);
  				$hearingdate=date_format($date2, 'm/d/Y');
  								
  				$arraylist= "{col0 : '" . $cutoffdate . "', col1 : '" . $hearingdate . "'}" ;
  				$flag=1;
  				$ids= $row->idSchedule;
  			}  				
  			else
  			{
  				$date1= date_create($row->cutoffdate);
  				$cutoffdate=date_format($date1, 'm/d/Y');
  				
  				$date2= date_create($row->hearingdate);
  				$hearingdate=date_format($date2, 'm/d/Y');
  				
  				
  	     		$arraylist= $arraylist .  ", {col0 : '" . $cutoffdate . "', col1 : '" . $hearingdate . "'}";
  				$ids=$ids . "+" . $row->idSchedule;
  			}
  				
  			$i = $i +1;
  			}// end of for loop
  			
  	}//end of if loop
  	
  			return  array($arraylist, $ids);
  	
  }
  
  public function getPetitioner($db, $docketno)
  {
  	$sql='SELECT * FROM `peopledetails` where `caseid`='.$docketno .' and typeofcontact="petitioner"';
  	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  	
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		foreach ($resultSet as $row) {
  				
  				
  			if($i == 0)
  			{
  	
  				//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$arraylist= $row->Firstname . " " . $row->Lastname;
  				
  	
  				//$
  				///$arraylist="tewe";
  			}
  				
  			else
  			{
  				/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "',
  				 col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
  				col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
  				col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
  				col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
  				col20: '" . $row->Zip . "'}";  */
  	
  				$arraylist= $arraylist . ", " . $row->Firstname;
  	
  				
  					
  				//  $arraylist="test";
  			}
  				
  			$i = $i +1;
  			}// end of for loop
  		}//end of if loop
  	
  	return $arraylist;
  }
  
  public function getCma($db, $Firstn)
  {
  	
  	//SELECT * FROM test.judgeassistant where FirstName="Valerie"
  	$sql='SELECT * FROM `judgeassistant` where `FirstName`="'.$Firstn .'"';
  	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  	 
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		foreach ($resultSet as $row) {
  
  
  			
  				 
  				//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$arraylist= $row->FirstName . " " . $row->LastName . "+" . $row->phone ;
  
  			
  			$i = $i +1;
  		}// end of for loop
  	}//end of if loop
  	 
  	return $arraylist;
 // 	return $sql;
  }
  
  
  public function getJudgeFax($db, $Firstn)
  {  	 
  	//SELECT * FROM test.judgeassistant where FirstName="Valerie"
  	$sql='SELECT * FROM `judges` where `FirstName`="'.$Firstn .'"';
  	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		$arraylist="";
  		foreach ($resultSet as $row) {
  			//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  			$arraylist= $row->Fax;
  			$i = $i +1;
  		}// end of for loop
  	}//end of if loop
  
  	return $arraylist;
  	// 	return $sql;
  }
  
  
  public function getNotes($db, $refagency, $casetype)
  {
  	 
  	//SELECT * FROM test.judgeassistant where FirstName="Valerie"
  	$sql='SELECT * FROM `docnotes` where `Agencycode`="'. $refagency .'" and `CaseCode`="' . $casetype . '"';
  	$statement=$db->createStatement($sql);
	$result = $statement->execute();
  	$arraylist="";
  
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		foreach ($resultSet as $row) {
  
  
  				
  				
  			//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  			$arraylist= $row->Notes;
  
  				
  			$i = $i +1;
  		}// end of for loop
  	}//end of if loop
 
  	return $arraylist;
  	// 	return $sql;
  }
  
  public function getRespondent($db, $docketno)
  {
  	$sql='SELECT * FROM `peopledetails` where `caseid`='.$docketno .' and typeofcontact="respondent"';
  	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  	 
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		foreach ($resultSet as $row) {
  
  
  			if($i == 0)
  			{
  				 
  				//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$arraylist= $row->Firstname . " " . $row->Lastname;
  
  				 
  				//$
  				///$arraylist="tewe";
  			}
  
  			else
  			{
  				/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "',
  				 col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
  				col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
  				col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
  				col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
  				col20: '" . $row->Zip . "'}";  */
  				 
  				$arraylist= $arraylist . ", " . $row->Firstname;
  				 
  
  					
  				//  $arraylist="test";
  			}
  
  			$i = $i +1;
  		}// end of for loop
  	}//end of if loop
  	 
  	return $arraylist;
  }
  
  
  public function getAllParties($db, $docketno)
  {
  	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
  	//$sql='SELECT * FROM `docket`';
  	$sql='SELECT * FROM `peopledetails` where `caseid`='.$docketno;
 // 	$sql='SELECT * FROM docket where caseid='1300001'';
  	$statement=$db->createStatement($sql);
  	$result = $statement->execute();
  	$arraylist="";
  	$flag=0;
  	if ($result instanceof ResultInterface && $result->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		$ids="";
  		foreach ($resultSet as $row) {
  			
  		    $decision = "NONE";
  		    $mailtoreceive=$row->mailtoreceive;
  		    $mailtoreceive1=$row->mailtoreceive1;
  			if ($mailtoreceive!="" && $mailtoreceive1!="")
  			{
  				$decision="NOH" . ", " . "DECISION";
  			}else if ($mailtoreceive!="")
  			{
  				$decision="NOH";
  			}
  			else if ($mailtoreceive1!="")
  			{
  				$decision="DECISION";
  			}
  			  			
  			if($i == 0)
  			{
  			   
 		//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  		  $arraylist= "{col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "', col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $decision . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  		  $flag=1;
  		  $ids= $row->peopleid;
  		  
  			    //$
  			  ///$arraylist="tewe";
  			}  			
  			
  			else
  			{
  				/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', 
  				    col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
  			col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
  			col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
  			col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
  			col20: '" . $row->Zip . "'}";  */
  		
  			    $arraylist= $arraylist . ", {" . "col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $decision . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}";
  			
  			    $ids=$ids . "+" . $row->peopleid;
  			    
  			//  $arraylist="test";
  			}
  			
  			$i = $i +1;
  		}// end of for loop
  	}//end of if loop
  
  	
  	//CASE WORKER / INVESTIGATOR DETAILS LIST - BEGINING
  	//	select * FROM test.attorneybycase;
  	$sql2='SELECT * FROM `agencycaseworkerbycase` where `caseid`='.$docketno;
  	// 	$sql='SELECT * FROM docket where caseid='1300001'';
  	$statement2=$db->createStatement($sql2);
  	$result2 = $statement2->execute();
  	//	$arraylist="";
  	//	$flag=0;
  	if ($result2 instanceof ResultInterface && $result2->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result2);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		//$ids="";
  		foreach ($resultSet as $row) {
  	
  	
  			$decision = "NONE";
  			$mailtoreceive=$row->mailtoreceive;
  			$mailtoreceive1=$row->mailtoreceive1;
  			if ($mailtoreceive!="" && $mailtoreceive1!="")
  			{
  				$decision="NOH" . ", " . "DECISION";
  			}else if ($mailtoreceive!="")
  			{
  				$decision="NOH";
  			}
  			else if ($mailtoreceive1!="")
  			{
  				$decision="DECISION";
  			}
  	
  	
  			if($flag == 0)
  			{
  				 
  				//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$arraylist= "{col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "', col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->Fax . "', col12: '" . $decision . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$flag=1;
  				$ids= $row->sno;
  				 
  				//$
  				///$arraylist="tewe";
  			}
  	
  			else
  			{
  				/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "',
  				 col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
  				col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
  				col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
  				col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
  				col20: '" . $row->Zip . "'}";  */
  				 
  				$arraylist= $arraylist . ", {" . "col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->Fax . "', col12: '" . $decision . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}";
  				 
  				$ids=$ids . "+" . $row->sno;
  					
  				//  $arraylist="test";
  			}
  	
  			$i = $i +1;
  		}// end of for loop
  		//	$arraylist = $arraylist + "]";
  		//return "inside loop";
  		 
  		//return  array($arraylist, $ids);
  		 
  	}//end of if loop
  	 
  	//CASE WORKER / INVESTIGATOR DETAILS LIST - ENDING
  	
  	
  	
  	
  	
  	
  	//ATTORNEY DETAILS LIST - BEGINING
  //	select * FROM test.attorneybycase;
  	$sql2='SELECT * FROM `attorneybycase` where `caseid`='.$docketno;
  	// 	$sql='SELECT * FROM docket where caseid='1300001'';
  	$statement2=$db->createStatement($sql2);
  	$result2 = $statement2->execute();
  //	$arraylist="";
  //	$flag=0;
  	if ($result2 instanceof ResultInterface && $result2->isQueryResult())
  	{
  		$resultSet = new ResultSet;
  		$resultSet->initialize($result2);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		//$ids="";
  		foreach ($resultSet as $row) {
  				
  				
  			$decision = "NONE";
  			$mailtoreceive=$row->mailtoreceive;
  			$mailtoreceive1=$row->mailtoreceive1;
  			if ($mailtoreceive!="" && $mailtoreceive1!="")
  			{
  				$decision="NOH" . ", " . "DECISION";
  			}else if ($mailtoreceive!="")
  			{
  				$decision="NOH";
  			}
  			else if ($mailtoreceive1!="")
  			{
  				$decision="DECISION";
  			}
  				
  				
  			if($flag == 0)
  			{
  	
  				//	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$arraylist= "{col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "', col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->Fax . "', col12: '" . $decision . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				$flag=1;
  				$ids= $row->sno;
  	
  				//$
  				///$arraylist="tewe";
  			}
  				
  			else
  			{
  				/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "',
  				 col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
  				col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
  				col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
  				col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
  				col20: '" . $row->Zip . "'}";  */
  	
  				$arraylist= $arraylist . ", {" . "col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->Fax . "', col12: '" . $decision . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}";
  	
  				$ids=$ids . "+" . $row->sno;
  					
  				//  $arraylist="test";
  			}
  				
  			$i = $i +1;
  			}// end of for loop
  			//	$arraylist = $arraylist + "]";
  			//return "inside loop";
  	
  			//return  array($arraylist, $ids);
  	
  	}//end of if loop
  	
  	//ATTORNEY DETAILS LIST - ENDING
  	
  	$sql1='SELECT * FROM `minordetails` where `caseid`='.$docketno;
  	// 	$sql='SELECT * FROM docket where caseid='1300001'';
  	$statement1=$db->createStatement($sql1);
  	$result1 = $statement1->execute();
  	//$arraylist="";
  	if ($result1 instanceof ResultInterface && $result1->isQueryResult())
  	{
  		$resultSet1 = new ResultSet;
  		$resultSet1->initialize($result1);
  		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
  		$i=0;
  		//$ids="";
  		foreach ($resultSet1 as $row) {
  				
  			if($i == 0)
  			{
  			    //	$arraylist="{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
  				
  			    if ($flag == 0)
  			    {
  			        $flag=1;
  			        //grid.store.newItem({ id: partyid, col0:typeofcontact, col1: firstname, col2: middlename, col3: lastname, col9:phonet, col10:emailt, col11:faxt, col12:decision, col15:address1, col16:address2, col17:address2, col18:state, col19:city, col20:zip, col22:dob1});
  			        $arraylist= "{col0 : 'Minor/children', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "', col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col12: 'NONE', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "', col22: '" . $row->dob . "'}" ;
  			        
  			        $ids= $row->Minorid;
  			    }
  			    else
  			    {
  			        $arraylist= $arraylist . ", {col0 : 'Minor/children', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "', col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col12: 'NONE', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "', col22: '" . $row->dob . "'}" ;
  			        
  			        $ids=$ids . "+" . $row->Minorid;
  			    }
  							//$
  				//$arraylist="tewe";
  			}
  				
  			else
  			{
  				/* $arraylist=$arraylist."+{id : '". $row->peopleid . "', col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "',
  				 col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "',
  				col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "',
  				col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "',
  				col17: '" . $row->Address2 . "', col18: '" . $row->State . "'col19: '" . $row->City . "',
  				col20: '" . $row->Zip . "'}";  */
  	
  				$arraylist= $arraylist . ", {col0 : 'Minor/children', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "', col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col12: 'NONE', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "', col22: '" . $row->dob . "'}" ;
  	
  				$ids=$ids . "+" . $row->Minorid;
  					
  				//  $arraylist="test";
  			}
  				
  			$i = $i +1;
  			}// end of for loop
  			//	$arraylist = $arraylist + "]";
  			//return "inside loop";
  	}//end of if loop
  	
  	
  	
  	
  	//return "test2"; 
      
      return  array($arraylist, $ids);
  
  }
    
    public function getDocketnumber()
    {
        
    }
    
    //CASETYPES TABLE From MYSQL DATABASE.   - not using it currently
    public function getCaseTypes($db, $id)
    {
    
    	// $db=$this->serviceLocator->get('test');
        $configReader = new ConfigReader();
        $configData = $configReader->fromFile('C:\iti\ldap-config.ini');
        $config = new Config($configData, true);
        
        $log_path = "c:/iti/tmp/ldap.log";
        $options = $config->production->ldap->toArray();
        
       
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
        $sql='SELECT * FROM `casetypes` where AgencyID='. $id  . ' ORDER BY CaseCode ASC';
    	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    /*	if ($log_path) {
    		$messages = $result->getMessages();
    	
    		$logger = new Logger;
    		$writer = new LogWriter($log_path);
    	
    		$logger->addWriter($writer);
    	
    		$filter = new LogFilter(Logger::DEBUG);
    		$writer->addFilter($filter);
    	
    		foreach ($messages as $i => $message) {
    			if ($i-- > 1) { // $messages[2] and up are log messages
    				$message = str_replace("\n", "\n  ", $message);
    				$logger->debug("Ldap: $i: $message");
    			}
    		}
    	
    	}*/
    //	$t="";
    //	return $t;
    	$arraylist="";
    	//return $arraylist;
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		 
    		$i=0;
    		foreach ($resultSet as $row) {
    			if($i == 0)
    			{

    			    $arraylist="{id:".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
    			    
    			}
    			else
    			{
    			     $arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
    				
    			}
    			$i = $i +1;
    		}// end of for loop
    		// console.log("i am here... do i");
    		return $arraylist;
    	}     
    	
    	//console.log("i am here... do i");
    	return ""; 
    }   
       
    
    //COUNTY LIST 
    public function getCountyList($db)
    {
    
    	// $db=$this->serviceLocator->get('test');
    
      //  SELECT * FROM test.county;
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `county` ORDER BY Countydescription ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    		    
    		    
    		    if($i == 0)
    		    {
    		    
    		    	$arraylist="{id:".$row->CountyID .", name : '". $row->Countydescription . "'}" ;
    		    		
    		    }
    		    else
    		    {
    		    	$arraylist=$arraylist.",{id :".$row->CountyID .", name : '". $row->Countydescription . "'}" ;
    		    
    		    }
    		    
    					$i = $i +1;
    		}// end of for loop
    		 
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    	 
    }
    
    
    // ATTORNEY LAST NAME FIRST NAME ADDRESS 1
    public function getAttrList($db)
    {    
    	// $db=$this->serviceLocator->get('test');    
    	//  SELECT * FROM test.county;
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	//SELECT Lastname, Firstname, Address1 FROM test.attorney order by Lastname ASC;
    	$sql='SELECT * FROM `attorney` ORDER BY Lastname ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {    
    		$concat=$row->Lastname . ", " . $row->Firstname . "  -  " . $row->Address1 ;
    			if($i == 0)
    			{
    
    				$arraylist="{id:".$row->Attorneyid .", name : '". $concat . "'}" ;
    
    			}
    			else
    			{
    				$arraylist=$arraylist.",{id :".$row->Attorneyid .", name : '". $concat . "'}" ;
    
    			}
    
    			$i = $i +1;
    		}// end of for loop
    		 
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    
    }
    
    
    public function getCasetypegroupList($db)
    {
    
    	// $db=$this->serviceLocator->get('test');
    
    	//  SELECT * FROM test.county;
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `casetypegroups`';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    
    			if($i == 0)
    			{
    
    				$arraylist="{id:".$row->id .", name : '". $row->casetypegroup . "'}" ;
    
    			}
    			else
    			{
    				$arraylist=$arraylist.",{id :".$row->id .", name : '". $row->casetypegroup . "'}" ;
    
    			}
    
    			$i = $i +1;
    		}// end of for loop
    		 
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    
    }
    
    
    //Judges list.
    public function getJudgesList($db)
    {
    
    	// $db=$this->serviceLocator->get('test');
    
    	//  SELECT * FROM test.county;
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `judges` ORDER BY LastName ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    		    
    		    if($i == 0)
    		    {
    		    
    		    	$arraylist="{id:".$row->Judgeid .", name : '". $row->LastName . " " .$row->FirstName . "'}" ;
    		    
    		    }
    		    else
    		    {
    		    	$arraylist=$arraylist.",{id :". $row->Judgeid .", name : '". $row->LastName . " " .$row->FirstName . "'}" ;
    		    
    		    }
    			
    			$i = $i +1;
    		}// end of for loop
    		 
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    
    }
    
    
        
    
    public function getJudgesAssistantList($db)
    {
    
    	// $db=$this->serviceLocator->get('test');
    
    	//  SELECT * FROM test.county;
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `judgeassistant` ORDER BY LastName ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    		    
    		    
    		    if($i == 0)
    		    {
    		    
    		    	$arraylist="{id:". $row->JudgeAssistantID .", name : '". $row->LastName . " " .$row->FirstName . "'}" ;
    		    
    		    }
    		    else
    		    {
    		    	$arraylist=$arraylist.",{id :". $row->JudgeAssistantID .", name : '". $row->LastName . " " .$row->FirstName . "'}" ;
    		    
    		    }    		    
    			
    			$i = $i +1;
    		}// end of for loop
    		 
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    
    }
    
    Public function getCourtLocations($db)
    {
        // $db=$this->serviceLocator->get('test');
        
        //  SELECT * FROM test.county;
        //$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
        $sql='SELECT * FROM `courtlocations` ORDER BY Locationname ASC';
        $statement=$db->createStatement($sql);
        $result = $statement->execute();
        $arraylist="";
        if ($result instanceof ResultInterface && $result->isQueryResult())
        {
        	$resultSet = new ResultSet;
        	$resultSet->initialize($result);
        	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
        	$i=0;
        	foreach ($resultSet as $row) {
        
        
        		if($i == 0)
        		{
        
        			$arraylist="{id:". $row->courtlocationid .", name : '". $row->Locationname . "'}" ;
        
        		}
        		else
        		{
        			$arraylist=$arraylist.",{id :". $row->courtlocationid .", name : '". $row->Locationname . "'}" ;
               }
        		 
        		$i = $i +1;
        	}// end of for loop
        	 
        	return $arraylist;
        }//end of if loop
        
        return "";
        
    }
    
    Public function getDocTypeOfContact($db)
    {
    	// $db=$this->serviceLocator->get('test');
    
    	//  SELECT * FROM test.county;
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `documenttypes` ORDER BY documenttype ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    
    			if($i == 0)
    			{
    
    				$arraylist="{id:". $row->id .", name : '". $row->documenttype . "'}" ;
    
    			}
    			else
    			{
    				$arraylist=$arraylist.",{id :". $row->id .", name : '". $row->documenttype . "'}" ;
    			}
    
    			$i = $i +1;
    		}// end of for loop
    
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    
    }

    Public function getTypeOfContact($db)
    {
    	// $db=$this->serviceLocator->get('test');
    
    	//  SELECT * FROM test.county;
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `typeofcontact` ORDER BY partycontact ASC';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    
    			if($i == 0)
    			{
    
    				$arraylist="{id:". $row->id .", name : '". $row->partycontact . "'}" ;
    
    			}
    			else
    			{
    				$arraylist=$arraylist.",{id :". $row->id .", name : '". $row->partycontact . "'}" ;
    			}
    			 
    			$i = $i +1;
    		}// end of for loop
    
    		return $arraylist;
    	}//end of if loop
    
    	return "";
    
    }
    
    
    
    
    
}





