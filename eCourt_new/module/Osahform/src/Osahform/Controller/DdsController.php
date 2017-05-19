<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Osahform for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
//Osah Controller

namespace Osahform\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Osahform\model\OsahLdapCon;
use Zend\View\Model\ViewModel;

use Zend\Authentication\Result;
use Zend\Session\Container;
use Osahform\Model\OsahDbFun;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Osahform\model\OsahDbFunctions;
use Zend\Db\Sql\Sql;
use DateTime;
use mPDF;
//use Zend\View\Model\ViewModel;
//require_once '\PHPWord.php';

//require_once 'PHPWord\PHPWord.php';


use PHPWord;
use PHPWord_IOFactory;

//include "module\Dds\src\Dds\model\OsahDbFunctions.php";
//include "\..\..\..\..\..\OsahDbFunctions.php";
//use PHPWord\PHPWord_IOFactory;
//use PHPWord_DocumentProperties;
//use PHPWord\PHPWord;
//use PHPWord_Autoloader;
//use PHPW//

class DdsController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/dds-layout');
        
    }
    /* 
    Name : Affan S
    Date Created : 10-02-2016
    Description : Get data for auto complect field while adding part in daocket
    
    */
    public function templateloadAction()
    {
        
        $templatename = $_REQUEST['name'];
        $view         = new ViewModel();
        $view->setTerminal(true);
        $view->setTemplate('osahform/dds/' . $templatename);
        return $view;
    }
    /* 
    Name : Affan S
    Date Created : 10-02-2016
    Description : Get data for auto complect field while adding part in daocket
    
    */
    public function getofficerdataAction()
    {
        //$param= json_decode(file_get_contents('php://input'),true);
        
        $db = $this->serviceLocator->get('db1');
        
        $OsahDb = New OsahDbFunctions();
        $sql    = "SELECT  officerrid,Company,Address1,count(*) FROM `officerdetails` where Company!='' GROUP BY Address1";
        $result = $OsahDb->getDatabySql($db, $sql);
        echo json_encode($result);
        exit;
    }
    /* 
    Name : Affan S
    Date Created : 10-02-2016
    Description : Get data for auto complect field while adding part in daocket
    
    */
    public function getstatelistAction()
    {
        //$param= json_decode(file_get_contents('php://input'),true);
        
        $db = $this->serviceLocator->get('db1');
        
        $OsahDb = New OsahDbFunctions();
        $sql    = "SELECT idstates,state from states";
        $result = $OsahDb->getDatabySql($db, $sql);
        echo json_encode($result);
        exit;
    }
    
    /* 
    Name : Affan S
    Date Created : 10-02-2016
    Description : Get data for auto complect field while adding part in daocket
    
    */
    
    public function getselectedcountyAction()
    {
        $param         = json_decode(file_get_contents('php://input'), true);
        $db            = $this->serviceLocator->get('db1');
        $condition     = $param['condition'];
        $tablename     = $param['tableName'];
        $OsahDb        = New OsahDbFunctions();
        $sql           = "SELECT DISTINCT county FROM `docket` where $condition";
        $result_county = $OsahDb->getDatabySql($db, $sql);
        echo json_encode($result_county);
        exit;
    }
	
	    /* 
  Name :Affan shaikh
  DateModified : 22-02-2017
  Description : Function searchdocketinfoAction  is used to get the docket information for dds
 
 */
 public function searchdocketinfoAction(){
    
  $db=$this->serviceLocator->get('db1');
  $param= json_decode(file_get_contents('php://input'),true); 
  
  $condition = $param['condition'];
  $OsahDb=New OsahDbFunctions();
  $result_docket = $OsahDb->getData($db,"docket",$condition,0);
  $result_people = $OsahDb->getData($db,"peopledetails",$condition,0);
     echo json_encode(array('docketData'=>$result_docket, 'peopleData'=>$result_people));
     exit;
  
 }
    
    /* 
    Name : Affan S
    Date Created : 10-02-2016
    Description : Add docket
    
    */
	
    /* 
    Name : Affan S
    Date Created : 10-02-2016
    Description : Add docket
    
    */
	
    public function adddocketAction()
    {
		//date_default_timezone_set('Asia/Kolkata');
        
        $db          = $this->serviceLocator->get('db1');
        $param       = json_decode(file_get_contents('php://input'), true);	
        $OsahDb      = New OsahDbFunctions();
        $today_date  = date("m-d");
        $fiscal_date = "07-01";
        if ($today_date == $fiscal_date) {
            $current_year = date("y");
            $caseid       = $current_year . '00001';
        } else {
            $caseid = "";
        }
        $agency              = $param['docketdetails']['refagency'];
        $case_type           = $param['docketdetails']['casetype'];
		
        $eligiblepermit      = $param['docketdetails']['eligiblepermit'];
        //$dob     			 = $param['docketdetails']['DOB'];
		if(isset($param['docketdetails']['DOB'])){
			$dob = $param['docketdetails']['DOB'];
		}else{
			$dob=NULL;
		}
		if(isset($param['docketdetails']['expiryDate'])){
			$expiryDate = $param['docketdetails']['expiryDate'];
		}else{
			$expiryDate= NULL;
		}
		if(isset($param['docketdetails']['incident_date'])){
			$incidentDate = $param['docketdetails']['incident_date'];
		}else{
			$incidentDate= NULL;
		}
       // $expiryDate     	 = $param['docketdetails']['expiryDate'];
       // $incidentDate     	 = $param['docketdetails']['incident_date'];
	
        //$permiteffectivedate = $param['docketdetails']['permiteffectivedate'];
        if (isset($param['docketdetails']['permiteffectivedate'])) {
            $permiteffectivedate = $param['docketdetails']['permiteffectivedate'];
        } else {
            $permiteffectivedate = '';
        }
		$currentDate = new DateTime('now', new \DateTimeZone('UTC'));
		$nowdate= $currentDate->format('Y-m-d H:i:s');
        $current_datetime = $nowdate;
        $docketclerk     = $param['docketdetails']['docketclerk'];
        $daterequested   = $param['docketdetails']['daterequested'];
        $county          = $param['docketdetails']['county'];
        $agencyrefnumber = $param['docketdetails']['agencyrefnumber'];
        $hearingmode     = $param['docketdetails']['hearingmode'];
        $status          = $param['docketdetails']['status'];
        $location_id     = "UNASSIGNED";
		
        //$judge_firstname = $param['docketdetails']['location_id']?$param['docketdetails']['split_judgename']:"UNASSIGN";
        //$judge = $param['docketdetails']['judge'];
        //$split_judgename = "UNASSIGN";
        $judge_firstname = "UNASSIGNED";
        if ($caseid != '') {
            $searchCondition = 'caseid ="' . $caseid . '"';
            $result          = $OsahDb->getData($db, 'docket', $searchCondition, 0);
            if (empty($result)) {
                $addCaseid   = array(
                    'caseid' => $caseid
                );
                $updatedData = array_merge($param['docketdetails'], $addCaseid);
                $docketid    = $OsahDb->insertData($db, "docket", $updatedData, 1);
            } else {
                
                $docketid = $OsahDb->insertData($db, "docket", $param['docketdetails'], 1);
            }
        } else {
            
            $data     = array(
                'docketclerk' => $docketclerk,
                'daterequested' => $daterequested,
                'refagency' => $agency,
                'casetype' => $case_type,
                'county' => $county,
                'agencyrefnumber' => $agencyrefnumber,
                'status' => $status,
                'hearingmode' => $hearingmode
            );			
            $docketid = $OsahDb->insertData($db, "docket", $data, 1);
		
            //echo $docketid;
            if ($docketid) {
                
                $data = array(
                    'caseid' => $docketid,
                    'eligibility' => $eligiblepermit,
                    'expiry_date' => $expiryDate,               
					'created_date'=>$current_datetime,
					'modified_Date'=>$current_datetime  
                    //'effective_date' => date('Y-m-d', strtotime($permiteffectivedate))
                );
                if (isset($permiteffectivedate) && $permiteffectivedate != "") {
                    $permiteffectivedate    = str_replace('-', '/', $permiteffectivedate);
                    $data['effective_date'] = date('Y-m-d', strtotime($permiteffectivedate));
                }
	
                $docketidelig = $OsahDb->insertData($db, "permit_eligibility_effectivedate", $data, 1);
							
                if ($docketidelig) {
                    $data1205 = array(
                        'caseid' => $docketid,
						'county_of_occurences'=>$county,
						'incident_date' => $incidentDate,
						'dob'=>$dob,
						'date_createdfor91days'=>$current_datetime,
						'date_created'=>$current_datetime                        
                    );
                   
                    $docketideligoffence = $OsahDb->insertData($db, "form1205offence", $data1205, 0);
                 
                    
                }
            }
        }
        if ($docketid == 0 || $docketid == '' || $docketid == null) {
            $docketid = $caseid;
        }
        $docketnumber = $agency . '-' . $case_type . '-' . $docketid . '-' . $location_id . '-' . $judge_firstname;
        ;
        $condition    = array(
            'caseid' => $docketid
        );
        $data         = array(
            'docketnumber' => $docketnumber
        );
        $result       = $OsahDb->updateData($db, "docket", $data, $condition);
        $final_result = array(
            'docket_id' => $docketid,
            'status' => 'true'
        );
        echo json_encode($final_result);
        exit;
    }
    
    /* 
    Name : Affan S
    Date Created : 10-02-2016
    Description : Get data for auto complect field while adding part in daocket
    
    */
    public function autopopulateddsAction()
    {
	    $param= json_decode(file_get_contents('php://input'),true); 
        $db        = $this->serviceLocator->get('db1');
        // $param= json_decode(file_get_contents('php://input'),true); 
        // $tableName = $param['tableName'];
        // $condition = $param['condition'];
		$contact_type = $param['contact_type'];
        $OsahDb    = New OsahDbFunctions();
        $result    = $OsahDb->getAutocomplectDDSData($db,$contact_type);
        echo json_encode($result);
        exit;
    }
    
    
    /* 
    Name : Amol S
    Date Created : 11-11-2016
    Date Modified : 02-12-2016
    Description : getpartyinformationAction this function will get the party information (autopopulate the data)
    
    */
    public function getddsinformationAction()
    {
	        $db    = $this->serviceLocator->get('db1');
        $param = json_decode(file_get_contents('php://input'), true);
        if (!empty($param)) {
            $party_id = $param['pid'];
            
            $OsahDb = New OsahDbFunctions();
            $result = $OsahDb->getddspartyinformationData($db, $party_id);
            echo json_encode($result);
        }
        exit;
    }
    
    /* 
    Author Name : Neha Agrawal
    Description : Function is used to add party details regarding docket number.
    Created Date : 18-10-2016
    */
    /* 
    code optimised date - 16-01-2017.
    */
    public function addPartyDetailsAction()
    {
        $db    = $this->serviceLocator->get('db1');
        $param = json_decode(file_get_contents('php://input'), true);
       
        $OsahDb = New OsahDbFunctions();
		
        // $contact_type = $param['partydetails']['contactType'];
        //  $docketnum = $param['partydetails']['docket_number'];
        /*  $lastname = $param['partydetails']['last_name'];
        $firstname = $param['partydetails']['first_name']; */
        if (isset($param['partydetails']['docket_number'])) {
            $docket_number = $param['partydetails']['docket_number'];
        } else {
            $docket_number = '';
        }
        if (isset($param['partydetails']['docket_number'])) {
            $caseid = $param['partydetails']['docket_number'];
        } else {
            $caseid = '';
        }
		if (isset($param['partydetails']['City'])) {
            $city = $param['partydetails']['City'];
        } else {
            $city = '';
        }
		if (isset($param['partydetails']['refagency'])) {
            $agency = $param['partydetails']['refagency'];
        } else {
            $agency = '';
        }
		//$agency              = $param['docketdetails']['refagency'];
		if (isset($param['partydetails']['Company'])) {
            $company = $param['partydetails']['Company'];
        } else {
            $company = '';
        }
        if (isset($param['partydetails']['contactType'])) {
            $contact_type = $param['partydetails']['contactType'];
        } else {
            $contact_type = 'form1205';
        }
        if (isset($param['partydetails']['Lastname'])) {
            $lastname = $param['partydetails']['Lastname'];
        } else {
            $lastname = '';
        }
        if (isset($param['partydetails']['Firstname'])) {
            $firstname = $param['partydetails']['Firstname'];
        } else {
            $firstname = '';
        }
        if (isset($param['partydetails']['Middlename'])) {
            $middlename = $param['partydetails']['Middlename'];
        } else {
            $middlename = '';
        }
        if (isset($param['partydetails']['dobyear'])) {
            $dobyear = $param['partydetails']['dobyear'];
        } else {
            $dobyear = '';
        }
        if (isset($param['partydetails']['attorney'])) {
            $attorney = $param['partydetails']['attorney'];
        } else {
            $attorney = '';
        }
        if (isset($param['partydetails']['Title'])) {
            $title = $param['partydetails']['Title'];
        } else {
            $title = '';
        }
        if (isset($param['partydetails']['Company'])) {
            $company_name = $param['partydetails']['Company'];
        } else {
            $company_name = '';
            
        }
        if (isset($param['partydetails']['Address2'])) {
            $address2 = $param['partydetails']['Address2'];
        } else {
            $address2 = '';
        }
		 if (isset($param['partydetails']['Address1'])) {
            $address1 = $param['partydetails']['Address1'];
        } else {
            $address1 = '';
        }
        if (isset($param['partydetails']['Phone'])) {
            $phone = $param['partydetails']['Phone'];
        } else {
            $phone = '';
        }
        if (isset($param['partydetails']['Email'])) {
            $email = $param['partydetails']['Email'];
        } else {
            $email = '';
        }
        if (isset($param['partydetails']['fax'])) {
            $fax = $param['partydetails']['fax'];
        } else {
            $fax = '';
        }
		 if (isset($param['partydetails']['State'])) {
            $state = $param['partydetails']['State'];
        } else {
            $state = '';
        }
		 if (isset($param['partydetails']['Zip'])) {
            $zip = $param['partydetails']['Zip'];
        } else {
            $zip = '';
        }
        if (isset($param['partydetails']['attorney'])) {
            $attorney = $param['partydetails']['attorney'];
        } else {
            $attorney = '';
        }
        if (isset($param['partydetails']['state_of_issue'])) {
            $stateIssue = $param['partydetails']['state_of_issue'];
        } else {
            $stateIssue = '';
        }
        if (isset($param['partydetails']['height'])) {
            $height = $param['partydetails']['height'];
        } else {
            $height = '';
        }
        if (isset($param['partydetails']['weight'])) {
            $weight = $param['partydetails']['weight'];
        } else {
            $weight = '';
        }
        if (isset($param['partydetails']['license_class_id'])) {
            $licenseclass = $param['partydetails']['license_class_id'];
        } else {
            $licenseclass = '';
        }
        if (isset($param['partydetails']['restrictions'])) {
            $restrictions = $param['partydetails']['restrictions'];
        } else {
            $restrictions = '';
        }
        if (isset($param['partydetails']['gender'])) {
            $gender = $param['partydetails']['gender'];
        } else {
            $gender = '';
        }
        
        if (isset($param['partydetails']['officer_badge_number'])) {
            $officer_badge_number = $param['partydetails']['officer_badge_number'];
        } else {
            $officer_badge_number = '';
        }
        if (isset($param['partydetails']['driver_request'])) {
            $driver_request = $param['partydetails']['driver_request'];
        } else {
            $driver_request = '';
        }
        
        if (isset($param['partydetails']['attorney'])) {
            $attorney = $param['partydetails']['attorney'];
        } else {
            $attorney = '';
        }
        
        if (isset($param['partydetails']['officerrid'])) {
            $officerrid = $param['partydetails']['officerrid'];
        } else {
            $officerrid = '';
        }
		if (isset($param['partydetails']['countyid'])) {
            $countyid = $param['partydetails']['countyid'];
        } else {
            $countyid = '';
        }
		if (isset($param['partydetails']['incident_date'])) {
            $incidentDate = $param['partydetails']['incident_date'];
        } else {
            $incidentDate = '';
        }
		if (isset($param['partydetails']['incident_time'])) {
            $incidentTime = $param['partydetails']['incident_time'];
        } else {
            $incidentTime = '';
        }
		if (isset($param['partydetails']['county_of_occurences'])) {
            $countyOfOccurences =$param['partydetails']['county_of_occurences'];
        } else {
            $countyOfOccurences = '';
        }
		$address1_array = array("GEORGIA STATE PATROL","GEORGIA DEPARTMENT OF PUBLIC SAFETY");	
		$fulltowncounty = array('Roswell','Alpharetta','Sandy Springs','Johns Creek','Milton');	
		/*  print_r("zd");
		 exit; */

        $countytablename = 'judgeassist_court_mapping';
        $mailtoreceive1   = '';
        $mailtoreceive    = '';
		$data1205flag = '';
        $current_datetime = date("Y-m-d H:i:s");
		
		//$sql        = "SELECT flag_1205 FROM form1205offence where caseid=$caseid"; 
		$sql        = "SELECT telv_o_five FROM docket where caseid=$caseid";
/* 		print_r($get1205flagstatus);
		exit; 	 */
			$get1205flagstatus 	= $OsahDb->getDatabySql($db, $sql);
			
			
			//print_r($get1205flagstatus[0]['flag_1205']);
			//exit;
			if($get1205flagstatus[0]['telv_o_five'] == 0){
				 $data1205flag = array(
					 'telv_o_five' => '1',					 
				 );
			}else{
				 $data1205flag = array(
					 'telv_o_five' => '1',					 
				 );
			}			
        if ($contact_type == 'form1205' || $contact_type == 'form1205update') {
	            //$form1205flag = int(1);
				$form1205 = array(                
                'officerrid' => $param['partydetails']['officerrid'],
                'citiation' => $param['partydetails']['citiation_num'],
                'dob' => $param['partydetails']['dob'],
                'incident_date' => $incidentDate,
                'incident_time' => $incidentTime,
                'officer_badge_number' => $officer_badge_number,
                'commercial_vehicle' => $param['partydetails']['commercial_vehicle'],
                'hazourdous_vehicle' => $param['partydetails']['hazardous_vehicle'],
                'gender' => $gender,
                'license_class_id' => $licenseclass,
                'state_of_issue' => $stateIssue,
                'restrictions' => $restrictions,
                'height' => $height,
                'weight' => $weight,
                'county_of_occurences' => $countyOfOccurences,
                'driver_request' => $driver_request
              
            );
        } else {
            $data = array(
                'Lastname' => $lastname,
                'Firstname' => $firstname,
                'Middlename' => $middlename,
                'Title' => $title,
                'Company' => $company_name,
                'Address1' => $param['partydetails']['Address1'],
                'Address2' => $address2,
                'City' => $city,
                'State' =>$state,
                'Zip' =>$zip,
                'Email' => $email,
                'Phone' => $phone,
				'created_date' => $current_datetime,
                'modified_date' => $current_datetime
            );
        }
		$modifiedDate = array(
				'modified_date'=>$current_datetime,									
			);
        switch ($contact_type) {		
            case 'Officer':		
			
			if($contact_type=='Officer' && $get1205flagstatus[0]['telv_o_five'] != 0){
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."' and contactid!='".$param['partydetails']['contactid']."'";
				$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
				
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					
					$condition = array('officerrid' => $param['partydetails']['contactid']);
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
						);	
						$faxDateOfficerDetailsTable = array(
							'fax'=>$fax
						);	
							
					$parent_data = array_merge($data,$modifiedDate,$faxDateOfficerDetailsTable);
					$where_condition = "Lastname = '".$lastname."' and Firstname = '".$firstname."'";
					
					$result = $OsahDb->getData($db,"officerdetails",$where_condition,0);
					if(!empty($result))
					{																											
						//$contactTypeValuefor1205 = $result;
					
						$result = $OsahDb->updateData($db,"officerdetails",$parent_data,$condition);
		
						$condition = array('contactid' => $param['partydetails']['contactid'],'caseid'=>$caseid);
						
							$new_data = array(
								'Phone'=>$phone,
								'Email'=>$email,
								'Fax'=>$fax,
								'Docket_caseid'=>$caseid,
								'caseid'=>$caseid
								
							);
							$child_data = array_merge($data,$new_data,$modifiedDate);
							$result = $OsahDb->updateData($db,"agencycaseworkerbycase",$child_data,$condition);
							if($result){
								echo $param['partydetails']['contactid'];
							}
							exit;
					}else{
						
						$result = $OsahDb->insertData($db,"officerdetails",$parent_data,1);
						$contactTypeValuefor1205 = $result;
							$condition = array('contactid' => $param['partydetails']['contactid'],'caseid'=>$caseid);
							$new_data = array(							
								'Fax'=>$fax,
								'typeofcontact'=>$contact_type,
								'Docket_caseid'=>$caseid,
								'caseid'=>$caseid,
								'contactid'=>$contactTypeValuefor1205
						);
							$child_data = array_merge($data,$new_data,$modifiedDate);
							$result = $OsahDb->updateData($db,"agencycaseworkerbycase",$child_data,$condition);
							if($result){
								echo $contactTypeValuefor1205;
							}
								exit;							
					}
				}
			}else{
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
				$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
				
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
								'fax'=>$fax
					);
					$officerfaxdata = array(
								'fax'=>$fax
					);
					$parent_data = array_merge($data,$officerfaxdata);
					
					$result = $OsahDb->insertData($db,"officerdetails",$parent_data,1);
					//$parent_data = array_merge($data);
						
					$contactTypeValuefor1205 = $result;
						$new_data = array(
							
							'Fax'=>$fax,
							'typeofcontact'=>$contact_type,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid,
							'contactid'=>$contactTypeValuefor1205
							
						);
						$child_data = array_merge($data,$new_data);
						$result = $OsahDb->insertData($db,"agencycaseworkerbycase",$child_data);
						if($result){
							echo $contactTypeValuefor1205 ;
						}
						exit;
				}
			}
			break;
            
				case 'form1205':
								
                $condition             = array(
                    'caseid' => $caseid
                );	
					
				$result = $this->getCountyData($countytablename,$countyid,$OsahDb,$db);	
				
				//get county of occurences if not generated for hearing Date Info
				//$getCountyOfOccurencesForOptimization =  $this->getCountyOfOccurencesForOptimization($countyOfOccurences,$caseid,$OsahDb,$db);
				//if($countyOfOccurences !=$getCountyOfOccurencesForOptimization[0]['county'] || $get1205flagstatus[0]['flag_1205'] == 0){
				
					if($result){
						
						// get Hering Time ID for hearing date automation 
						$hearingTimeTemp = $result[0]['hearingtime'];
						
						$hearingTimeTempResult =  $this->getHearingTimeId('hearingtime',$hearingTimeTemp,$OsahDb,$db);	
						
						$getHearingDateInfo           = array(
								  'judge_id'=>$result[0]['Judgeid'],
								  'judge_assistant_id' => $result[0]['JudgeAssistantID'],
								  'court_location_id'=>$result[0]['courtlocationid'],
								  'casetype_id'=>$result[0]['Casetypeid'],
								  'casetype'=>'ALS',
								  'hearingTimeId'=>$hearingTimeTempResult[0]['timeid'],
								  'hearingtime'=>$result[0]['hearingtime'],
								  'token'=>1,
								  'hearingDateValEnteredByUser'=>0
							);
								
							
						$gethearingDate = $OsahDb->hearingDateAutomation($db,$getHearingDateInfo,0);	
						
					}

						$getautomatedHearingDateValue = $gethearingDate['hearingDate'];						
						$getautomatedHearingDate = $this->getReturnHearingDate($getautomatedHearingDateValue);
						
						/* $hearinngDateInfo           = array(
						      'hearingdate'=>$getautomatedHearingDate['getautomatedHearingDateValue'], 
						      'status'=>$getautomatedHearingDate['status'] 

						); */
					
					//exit;
				//}
			
				if(!in_array($address1, $address1_array)){					
					if($countyOfOccurences == 'Fulton' && !in_array($city,$fulltowncounty)){
						$countySaved           = $this->getFulltonData($caseid,$agency,$countyid,$countyOfOccurences);
					}else{						
						$countySaved           = array(
							  'refagency'=> $agency,
							  'county' => $countyOfOccurences,
							  'docketnumber'=>$agency."-".'ALS'."-".$caseid."-".$countyid."-".$result[0]['judges'],
							  'judge'=>$result[0]['judges'],
							  'judgeassistant'=>$result[0]['judgeassistant'],
							  'hearingtime'=>$result[0]['hearingtime'],
							  'hearingsite'=>$result[0]['Locationname'],
							  'hearingdate'=>$getautomatedHearingDate['getautomatedHearingDateValue'], 
						      'status'=>$getautomatedHearingDate['status'] 
						);
					}
					
								
					
				$parent_data = array_merge($countySaved,$data1205flag);
				
				$updateCountyForDocket = $OsahDb->updateData($db, "docket", $parent_data, $condition);	
			
				}else{
					$updateCountyForDocket = true;	
					
				}
				
			
				
                if ($updateCountyForDocket) {					
				
						$parent1205flag = array_merge($form1205,$data1205flag,$modifiedDate);
											
                    try {						
                        $result = $OsahDb->updateData($db, "form1205offence", $parent1205flag, $condition);						
						//update datereceivedbyOSAH
						if($result){
							$currentDate = new DateTime('now', new \DateTimeZone('UTC'));
							$nowdate= $currentDate->format('Y-m-d');
							 $datereceivedbyOSAH   = array(
								'datereceivedbyOSAH' => $nowdate
							);
							$sql        = "SELECT telv_o_five FROM docket where caseid=$caseid"; 
							$get1205flagstatus 	= $OsahDb->getDatabySql($db, $sql);						
							
							if($get1205flagstatus[0]['telv_o_five'] == 1){
									$sql        = "SELECT datereceivedbyOSAH FROM docket where caseid=$caseid"; 
									
									$getdatereceivedbyOSAH 	= $OsahDb->getDatabySql($db, $sql);
									/* print_R($getdatereceivedbyOSAH);
									exit; */
									if($getdatereceivedbyOSAH[0]['datereceivedbyOSAH'] == "" || $getdatereceivedbyOSAH[0]['datereceivedbyOSAH'] == 'null' ){
										$updatedatereceivedbyOSAH  = $OsahDb->updateData($db, "docket", $datereceivedbyOSAH, $condition);
										echo json_encode($updatedatereceivedbyOSAH);
										exit;
									}							
							}
														
						}
						echo json_encode($result);
                        exit;	
                        
                    }
                    catch (Exception $exception) {
                        return false;
                    }
					
				//echo $company_name;
				exit;
                }
				else{					
					echo "Not update";
					exit;
				}
                break;
				
				case 'form1205update':
				
                 $condition = array(
                    'officerrid' => $officerrid
                );	
				$conditionForFultonCounty = array(
                    'caseid' => $caseid
                );					
				
				if($countyOfOccurences == 'Fulton' && !in_array($city,$fulltowncounty)){
					
						$countySaved           = $this->getFulltonData($caseid,$agency,$countyid,$countyOfOccurences);
			
						}else{
						$result = $this->getCountyData($countytablename,$countyid,$OsahDb,$db);
						//$getCountyOfOccurencesForOptimization =  $this->getCountyOfOccurencesForOptimization($countyOfOccurences,$caseid,$OsahDb,$db);
						
						//if($countyOfOccurences !=$getCountyOfOccurencesForOptimization[0]['county'] || $get1205flagstatus[0]['flag_1205'] == 0){			
							if($result){
								
							$hearingTimeTemp = $result[0]['hearingtime'];
							$hearingTimeTempResult =  $this->getHearingTimeId('hearingtime',$hearingTimeTemp,$OsahDb,$db);		
							
							$getHearingDateInfo           = array(
									  'judge_id'=>$result[0]['Judgeid'],
									  'judge_assistant_id' => $result[0]['JudgeAssistantID'],
									  'court_location_id'=>$result[0]['courtlocationid'],
									  'casetype_id'=>$result[0]['Casetypeid'],
									  'hearingTimeId'=>$hearingTimeTempResult[0]['timeid'],
								      'hearingtime'=>$result[0]['hearingtime'],
									  'token'=>1,
									  'hearingDateValEnteredByUser'=>0
								);
							$gethearingDate = $OsahDb->hearingDateAutomation($db,$getHearingDateInfo,0);
												
						}
							//print_R($gethearingDate);
							$getautomatedHearingDateValue = $gethearingDate['hearingDate'];						
							$getautomatedHearingDate = $this->getReturnHearingDate($getautomatedHearingDateValue);	
								/* $hearinngDateInfo           = array(
								  'hearingdate'=>$getautomatedHearingDate['getautomatedHearingDateValue'], 
								  'status'=>$getautomatedHearingDate['status'] 

								);	 */
						//}						
						$countySaved           = array(
							  'refagency'=> $agency,
							  'county' => $countyOfOccurences,
							  'docketnumber'=>$agency."-".'ALS'."-".$caseid."-".$countyid."-".$result[0]['judges'],
							  'judge'=>$result[0]['judges'],
							  'judgeassistant'=>$result[0]['judgeassistant'],
							  'hearingtime'=>$result[0]['hearingtime'],
							  'hearingsite'=>$result[0]['Locationname'],
							  'hearingdate'=>$getautomatedHearingDate['getautomatedHearingDateValue'], 
						      'status'=>$getautomatedHearingDate['status'] 
							  
						);
						//print_r($countySaved);
					}						
						$parent_data= array_merge($countySaved,$data1205flag);
					//exi
					
						$updateCountyForDocket = $OsahDb->updateData($db, "docket", $parent_data, $conditionForFultonCounty);
						if($updateCountyForDocket){
							$parent_data= array_merge($form1205,$modifiedDate);
							$result = $OsahDb->updateData($db, "form1205offence",$parent_data, $condition);
						}
						echo json_encode($result);
						exit;
                
                
                
                break;
            
				default:
                echo "true";
                exit;
                break;
                
                
                
        }		
		
        
        
    }
		
		public function getReturnHearingDate($getautomatedHearingDateValue){
			if($getautomatedHearingDateValue == ''){
				$getautomatedHearingDateValue = NUll;
				$status = 'Pending';
			}else{
				$getautomatedHearingDateValue      = date('Y-m-d', strtotime(str_replace('-', '/',$getautomatedHearingDateValue)));
				$status = 'Hearing Scheduled';
			}
			return array('getautomatedHearingDateValue'=>$getautomatedHearingDateValue,'status'=>$status);
		}
	
			public function getCountyData($countytablename,$countyid,$OsahDb,$db){
					$sql        = "SELECT * FROM $countytablename where CountyID =$countyid AND Casetypeid ='612'"; 
					$result 	= $OsahDb->getDatabySql($db, $sql);	
					return $result;
					exit;
			}
			
			public function getHearingTimeId($countytablename,$hearingtime,$OsahDb,$db){
					$sql        = "SELECT timeid FROM $countytablename where heringtimestored = '$hearingtime'"; 
					$hearingTimeResult 	= $OsahDb->getDatabySql($db, $sql);	
					return $hearingTimeResult;
					exit;
			}
	
			public function getFulltonData($caseid,$agency,$countyid,$countyOfOccurences){
				$countySaved           = array(
				'county' => $countyOfOccurences,
				'refagency'=>$agency,
				'casetype'=>'ALS',
				'judge' => 'Malihi Michael',
				'judgeassistant' => 'Griffin Kacie',
				'hearingsite' => 'OSAH - Office of State Administrative Hearings',
				'hearingtime' => '09:00:00',
				'hearingmode' => 'Desk Review',
				'docketnumber'=>$agency."-".'ALS'."-".$caseid."-".$countyid."-".'Malihi Michael',
				);	
				return $countySaved;
				exit;
		}
    

	
    /* 
    Name : Affan S
    Date Created : 12-02-2017
    Description : Function searchdocketinfoAction  is used to get the docket information 
    *  from table based on paramiter like tbale and where condition.
    */
    public function search1205infoAction()
    {
	
        $db    = $this->serviceLocator->get('db1');
        $param = json_decode(file_get_contents('php://input'), true);
        if (isset($param['condition']['caseid'])) {
            $caseid = $param['condition']['caseid'];
			 if($caseid == 'c'){
				 $caseid = "";
			 }
        } else {
            $caseid = '';
        }
        $condition       = $param['condition'];
        $tablename       = $param['tableName'];
        $OsahDb          = New OsahDbFunctions();

		if($caseid == ""){
        $result_1205form = $OsahDb->getData($db, $tablename, $condition, 0);
		 echo json_encode($result_1205form);

		}else{
			$officerrid = $param['condition']['officerrid'];
			$sql        = "SELECT * FROM $tablename where caseid = $caseid AND contactid=$officerrid"; 
			$officerdetailsbydocket 	= $OsahDb->getDatabySql($db, $sql);	
			echo json_encode($officerdetailsbydocket);
		}
       
        exit;
        
    }
    // update dds to dps as per company.
    
    public function updateddstodpsAction()
    {
		
        $db        = $this->serviceLocator->get('db1');
        $param     = json_decode(file_get_contents('php://input'), true);
        $condition = $param['condition'];
		$agency = 	$param['docketDPSDetails']['agencey'];
		$casetype = 	$param['docketDPSDetails']['casetype'];
		$caseid  = 	$param['docketDPSDetails']['caseid'];
		$county  = 	$param['docketDPSDetails']['county'];
		$countyid  = 	$param['docketDPSDetails']['countyid'];
		$address1  = 	$param['docketDPSDetails']['Address1'];
        $tablename = $param['tableName'];
		$countytablename = 'judgeassist_court_mapping';
		
        $OsahDb    = New OsahDbFunctions();
		//$conditioncountymapping ="CountyID="+$countyid+" && Casetypeid='605'";
		//echo $countyid;
		$result = $this->getCountyData($countytablename,$countyid,$OsahDb,$db);

		if(!empty($result)){
        $data      = array(
            'refagency' => 'DPS',
			'docketnumber'=>'DPS'."-".$casetype."-".$caseid."-".$countyid."-".$result[0]['judges'],
			'judge'=>$result[0]['judges'],
			'judgeassistant'=>$result[0]['judgeassistant'],
			'hearingsite'=>$result[0]['Locationname'],	
			'hearingtime'=>$result[0]['hearingtime'],
			'county' => $county	
	        );
			
		}else if($countyid == 60 &&  $address1 == 'GEORGIA STATE PATROL' || $address1 == 'GEORGIA DEPARTMENT OF PUBLIC SAFETY'){
			$data   = array(
							 'county' => $county,
							 'refagency'=>'DPS',
							 'casetype'=>'ALS',
							 'judge' => 'Malihi Michael',
							 'judgeassistant' => 'Griffin Kacie',
							 'hearingsite' => 'OSAH - Office of State Administrative Hearings',
							 'hearingtime' => '09:00:00',
							 'hearingmode' => 'Desk Review',
							 'docketnumber'=>'DPS'."-".'ALS'."-".$caseid."-".$countyid."-".'Malihi Michael',
						);		
		}else{
			if($county =='No County'){
					$countyid ='UNASSIGNED';
			}
			
				$data   = array(
							 'county' => $county,
							 'refagency'=>'DPS',
							 'casetype'=>'ALS',
							 'judge' => 'Malihi Michael',
							 'judgeassistant' => 'Griffin Kacie',
							 'hearingsite' => 'OSAH - Office of State Administrative Hearings',
							 'hearingtime' => '09:00:00',
							 'hearingmode' => 'Desk Review',
							 'docketnumber'=>'DPS'."-".'ALS'."-".$caseid."-".$countyid."-".'Malihi Michael',
						);	
		}
		
			$result    = $OsahDb->updateData($db, "docket", $data, $condition);			
			echo json_encode($result);
			exit;
        
    }
    
    /* 
    Name : Affan S
    Date Created : 17-02-2017
    Description : get data for dee brophy attorney.
    
    */
    
    public function getattorneyAction()
    {
        $param = json_decode(file_get_contents('php://input'), true);
        
        $db        = $this->serviceLocator->get('db1');
        $tablename = $param['tblNm'];
        $OsahDb    = New OsahDbFunctions();
        $sql       = "SELECT * FROM $tablename where Attorneyid = 1139";
        
        $result = $OsahDb->getDatabySql($db, $sql);
        
        echo json_encode($result);
        exit;
    }
    
    /* 
    Name : Affan S
    Date Created : 17-02-2017
    Description : add data for dee brophy attorney to attorneybycase table.
    
    */
    
    public function addattorneyrespondentAction()
    {
        $param            = json_decode(file_get_contents('php://input'), true);
        /* $attorneyid = $param['partydetails'][0]['Attorneyid'];
        print_r($attorneyid);
        //print_r($param);
        exit; */
        $db               = $this->serviceLocator->get('db1');
        $tablename        = $param['tableName'];
        $condition        = $param['condition'];
        $caseid           = $param['caseid'];
        $attorneyid       = $param['partydetails'][0]['Attorneyid'];
        $current_datetime = date("Y-m-d H:i:s");
        $data             = array(
            'Lastname' => $param['partydetails'][0]['Lastname'],
            'Firstname' => $param['partydetails'][0]['Firstname'],
            'Middlename' => $param['partydetails'][0]['Middlename'],
            'Title' => $param['partydetails'][0]['Title'],
            'AttorneyBar' => $param['partydetails'][0]['AttorneyBar'],
            'Docket_caseid' => $caseid,
            'Company' => $param['partydetails'][0]['Company'],
            'Address1' => $param['partydetails'][0]['Address1'],
            'Address2' => $param['partydetails'][0]['Address2'],
            'City' => $param['partydetails'][0]['City'],
            'State' => $param['partydetails'][0]['State'],
            'Zip' => $param['partydetails'][0]['Zip'],
            'Email' => $param['partydetails'][0]['Email'],
            'Phone' => $param['partydetails'][0]['Phone'],
            'Fax' => $param['partydetails'][0]['Fax'],
            'created_date' => $current_datetime,
            'modified_date' => $current_datetime
            
        );
        $new_data         = array(
            'attorneyid' => $attorneyid,
            'caseid' => $caseid,
            'typeofcontact' => 'Respondent Attorney'
        );
        $OsahDb           = New OsahDbFunctions();
        $parent_data      = array_merge($data, $new_data);
        //$result_attorney = $OsahDb->getData($db,$tablename,$condition,0);
        
        $sql             = "SELECT caseid FROM $tablename where $condition";
        /* print_r($sql);
        exit; */
        $result_attorney = $OsahDb->getDatabySql($db, $sql);
        if (empty($result_attorney)) {
            $result = $OsahDb->insertData($db, $tablename, $parent_data, 1);
            echo json_encode($result);
        } else {
            echo "1";
            
        }
        exit;
    }
    /* 
    Name : Affan S
    Date Created : 17-02-2017
    Description : 91 Days Process
    
    */
    
    public function days91Action()
    {	
		// mail("affan.shaikh@azularc.com","My subject",'1');
        $db                      = $this->serviceLocator->get('db1');
        $OsahDb                  = New OsahDbFunctions();
        $sql                     = "select caseid,telv_o_five,docket_createddate from docket where telv_o_five = '0' AND casetype = 'ALS' AND datereceivedbyOSAH IS NULL AND DATE(docket_createddate) <= DATE_SUB(NOW(),INTERVAL 5 MINUTE) order by caseid desc";
        $result_1205flagfalse    = $OsahDb->getDatabySql($db, $sql);
        $now                     = date('Y-m-d H:i:s');
        $updateDocketAfterClosed = array(
            'judge' => 'Malihi Michael',
            'judgeassistant' => 'Griffin Kacie',
            'hearingsite' => 'OSAH - Office of State Administrative Hearings',
            'hearingtime' => '09:00:00',			 
            'hearingmode' => 'Desk Review',
            'county' => 'No County',
			'status'=>'Pending'
        );
       /*  $dispositionCloseDate    = date('Y-m-d');
		//echo $dispositionCloseDate;
        $addDisposition          = array(
            'dispositioncode' => 'Closed - 91-Day Letter',
            'dispositiondate' => $dispositionCloseDate,
            'signedbyjudge' => $dispositionCloseDate,
            'mailedddate' => $dispositionCloseDate,
            'hearingyesno' => 'No',
            'boxno' => ''
        ); */
        
       /*  $days91_update = array(
            'flag_91days' => '1',
			'datereceivedbyOSAH'=> $now			
        ); */
		
        $i             = 0;
		 //mail("affan.shaikh@azularc.com","My subject",'2');
        foreach ($result_1205flagfalse as $value) {
			print_r($result_1205flagfalse);
			$current_datetime = date('Y-m-d H:i:s');
			$date_createdfor91days     = $value['docket_createddate'];
			$dateEnteredfor91days      = date('Y-m-d H:i:s', strtotime($date_createdfor91days));
			$condition        = 'caseid =' . $value['caseid'];
            /* $date_createdfor91days     = $value['docket_createddate'];
          
           
            
			//echo $value['caseid'].'<br/>';
            $sql                = "select telv_o_five,caseid from form1205offence where caseid=" . $value['caseid'];
            $checkif1205created = $OsahDb->getDatabySql($db, $sql);
 */
            //foreach ($checkif1205created as $value1205) {
					//print_r($checkif1205created);
		
				
				 $start_date = new \DateTime( $current_datetime );
				 $since_start = $start_date->diff(new DateTime($dateEnteredfor91days));
				 $minutes = $since_start->i;

				
				 
		 
                if ($minutes >= 5 && $value['telv_o_five'] == 0) {
                    $sql = "select caseid,telv_o_five from docket where caseid=" . $value['caseid'];
                    
                    $get91daylist = $OsahDb->getDatabySql($db, $sql);
				
                    if(empty($get91daylist)){
						echo "EMpty";
					}					
                    else if($get91daylist[0]['telv_o_five'] == 0) {
						
                        $caseid               = array(
                            'caseid' => $value['caseid'],
                        );
                        //$addDispositionData   = array_merge($addDisposition, $caseid);
							
						
                        // this is to add disposition after case is closed
                        //$inserdispositiontype = $OsahDb->insertData($db, "docketdisposition", $addDispositionData, 0);
						
						/* print_r($inserdispositiontype);
						exit; */
						
						
								//if ($inserdispositiontype) {
								
							$currentDate = new DateTime('now', new \DateTimeZone('UTC'));
							$nowdate = $currentDate->format('Y-m-d');
							$updateDocketAfterClosedDocketNum = array(							
								'docketnumber'=>'DDS'."-".'ALS'."-".$value['caseid']."-".'No County'."-".'Malihi Michael',
								'datereceivedbyOSAH'=> $nowdate,
								'telv_o_five'=> '1',
							);
							
							$updateDocketAfterClosedParent   = array_merge($updateDocketAfterClosed, $updateDocketAfterClosedDocketNum);
							//print_r($updateDocketAfterClosedParent);
							
                            $result = $OsahDb->updateData($db, "docket", $updateDocketAfterClosedParent, $condition);
							if($result){
								$update1205OffenceCounty = array(							
									'county_of_occurences'=> 'No County',
								);	
								$result = $OsahDb->updateData($db, "form1205offence", $update1205OffenceCounty, $condition);	
							}
							$case = $value['caseid'];
                          
                       // }
                        //mail("someone@example.com","My subject",$case);
						 mail("affan.shaikh@azularc.com","My subject",$case);
                    }
                } else {
					echo "1";
                }
            //}
            
        }
        //print_r( $get91daylist);
        
        exit;        
        
    }
    
	public function updatelicensenumberAction(){
		$param            = json_decode(file_get_contents('php://input'), true);
		  if (isset($param['partydetails']['agencyrefnumber'])) {
            $agencyrefnumber = $param['partydetails']['agencyrefnumber'];
        } else {
            $agencyrefnumber = '';
        }
		  if (isset($param['partydetails']['docket_number'])) {
            $docket_number = $param['partydetails']['docket_number'];
        } else {
            $docket_number = '';
        }
		$db                      = $this->serviceLocator->get('db1');
		
        $OsahDb                  = New OsahDbFunctions();
		$updateDocketLisceneNuumber = array(
		'agencyrefnumber'=>$agencyrefnumber,
		);
		$condition        = 'caseid =' .  $docket_number;
		
		$result = $OsahDb->updateData($db, "docket", $updateDocketLisceneNuumber, $condition);
		exit;
	}	
	
	//AFFAN EDIT PARTY.
	
	/* 
		Name : Neha
		Date Created : 17-11-2016
		Description : This function is used to update party details.
	*/

	public function editpartydetailsAction()
	{
		$db=$this->serviceLocator->get('db1');
        $param= json_decode(file_get_contents('php://input'),true);
		$OsahDb=New OsahDbFunctions();
		if(isset($param['editpartydetails']['previous_contacttype'])){
			$previous_contacttype =$param['editpartydetails']['previous_contacttype']; 
		}else{
			$previous_contacttype = '';
		}
		$caseid = 	$param['editpartydetails']['caseid'];
		$lastname =  $param['editpartydetails']['Lastname'];
		$firstname = $param['editpartydetails']['Firstname'];
		if(isset($param['editpartydetails']['typeofcontact'])){
			$contact_type =  $param['editpartydetails']['typeofcontact'];
		}else{
			$contact_type = 'Minor/children';
		}
		if(isset($param['editpartydetails']['Middlename'])){
			$middle_name = $param['editpartydetails']['Middlename'];
		}else{
			$middle_name='';
		}
		if(isset($param['editpartydetails']['AttorneyBar'])){
			$attorneyBar = $param['editpartydetails']['AttorneyBar'];
		}else{
			$attorneyBar='';
		}
		if(isset($param['editpartydetails']['Title'])){
			$title = $param['editpartydetails']['Title'];
		}else{
			$title='';
		}
		if(isset($param['editpartydetails']['Company'])){
			$company = $param['editpartydetails']['Company'];
		}else{
			$company='';
		}
		if(isset($param['editpartydetails']['Address2'])){
			$address2 = $param['editpartydetails']['Address2'];
		}else{
			$address2='';
		}
		if(isset($param['editpartydetails']['Phone'])){
			$phone = $param['editpartydetails']['Phone'];
		}else{
			$phone='';
		}
		if(isset($param['editpartydetails']['Email'])){
			$email = $param['editpartydetails']['Email'];
		}else{
			$email = '';
		}
		if(isset($param['editpartydetails']['fax'])){
			$fax = $param['editpartydetails']['fax'];
		}else{
			$fax='';
		}
		if(isset($param['editpartydetails']['Address1'])){
			$address1 = $param['editpartydetails']['Address1'];
		}else{
			$address1='';
		}
		if(isset($param['editpartydetails']['City'])){
			$city = $param['editpartydetails']['City'];
		}else{
			$city='';
		}
		if(isset($param['editpartydetails']['State'])){
			$state = $param['editpartydetails']['State'];
		}else{
			$state='';
		}
		if(isset($param['editpartydetails']['Zip'])){
			$zip = $param['editpartydetails']['Zip'];
		}else{
			$zip='';
		}
		if(isset($param['editpartydetails']['dobyear'])){
			$dobyear = $param['editpartydetails']['dobyear'];
		}else{
			$dobyear='';
		}
		$current_datetime = date("Y-m-d H:i:s");
		
		if($contact_type==$previous_contacttype)
		{
			$created_date = $param['editpartydetails']['created_date'];
		}else{
			$created_date = $current_datetime;
		}
		$data = array(
						'Lastname'=>$param['editpartydetails']['Lastname'],
						'Firstname'=>$param['editpartydetails']['Firstname'],
						'Middlename'=>$middle_name,
						'Title'=>$title,
						'Company'=>$company,
						'Address1'=>$address1,
						'Address2'=>$address2,
						'City'=>$city,
						'State'=>$state,
						'Zip'=>$zip,
						'modified_date'=>$current_datetime,
						'created_date'=> $created_date
					);
		$minortable_data = array(
						'Lastname'=>$param['editpartydetails']['Lastname'],
						'Firstname'=>$param['editpartydetails']['Firstname'],
						'Middlename'=>$middle_name,
						'dobyear'=>$dobyear,
						'Docket_caseid'=>$caseid,
						'caseid'=>$caseid,
						'modified_date'=>$current_datetime,
						'created_date'=> $created_date
					);
		  switch ($contact_type){
		   case 'Minor/children':
				if((isset($param['editpartydetails']['minorid'])) && ($contact_type==$previous_contacttype)){
					$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and Minorid != '".$param['editpartydetails']['minorid']."'";
					$result = $OsahDb->getData($db,"minordetails",$condition,0);
					if(!empty($result))
					{
						echo "0";exit;
					}else{
						$condition = array('Minorid' => $param['editpartydetails']['minorid']);
						$result = $OsahDb->updateData($db,"minordetails",$minortable_data,$condition);
						echo "true";exit;
					}	
				}else{
					$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."'";
					$result = $OsahDb->getData($db,"minordetails",$condition,0);
					if(!empty($result))
					{
						echo "0";exit;
					}else{
						$result = $OsahDb->insertData($db,"minordetails",$minortable_data);
					}
				}
			break; 
			
			case 'Petitioner':
				
			if((isset($param['editpartydetails']['peopleid'])) && ($contact_type==$previous_contacttype)){
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."' and peopleid!='".$param['editpartydetails']['peopleid']."'";
					$result = $OsahDb->getData($db,"peopledetails",$condition,0);
					if(!empty($result))
					{
						echo "0";exit;
					}else{
						$condition = array('peopleid' => $param['editpartydetails']['peopleid']);
						$new_data = array(
									'Phone'=>$phone,
									'Email'=>$email,
									'fax'=>$fax
							);
							$parent_data = array_merge($data,$new_data);
						$result = $OsahDb->updateData($db,"peopledetails",$parent_data,$condition);
						echo "true";exit;
					}
			}else{
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
				$result = $OsahDb->getData($db,"peopledetails",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$new_data = array(
								'Phone'=>$phone,
								'Email'=>$email,
								'fax'=>$fax,
								'Docket_caseid'=>$caseid,
								'caseid'=>$caseid,
								'typeofcontact'=>$contact_type
								
						);
					$parent_data = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"peopledetails",$parent_data);
				}
			}
			
			break;
			
			// case 'Agency Attorney':
			case 'Petitioner Attorney':

			if((isset($param['editpartydetails']['attorney_id'])) && ($contact_type==$previous_contacttype)){
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."' and attorneyid!='".$param['editpartydetails']['attorney_id']."'";
				$result = $OsahDb->getData($db,"attorneybycase",$condition,0);
				;
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					
					$condition = array('Attorneyid' => $param['editpartydetails']['attorney_id']);
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
								'fax'=>$fax,
								'AttorneyBar'=>$attorneyBar
						);
					$parent_data = array_merge($data,$new_data);

					$where_condition = "Lastname = '".$lastname."' and Firstname = '".$firstname."'";
					
					$result = $OsahDb->getData($db,"attorney",$where_condition,0);
					
					if(!empty($result))
					{
						
						$result = $OsahDb->updateData($db,"attorney",$parent_data,$condition);
						
							$condition = array('attorneyid' => $param['editpartydetails']['attorney_id'],'caseid'=>$param['editpartydetails']['caseid']);
							$new_data = array(
								'Phone'=>$phone,
								'Email'=>$email,
								'Fax'=>$fax,
								'Docket_caseid'=>$caseid,
								'caseid'=>$caseid,
								'AttorneyBar'=>$attorneyBar,
								
							);
							
							$child_data = array_merge($data,$new_data);
							
							$result = $OsahDb->updateData($db,"attorneybycase",$child_data,$condition);
							echo "true";exit;
					}else{
						
						$result = $OsahDb->insertData($db,"attorney",$parent_data,1);
							$condition = array('attorneyid' => $param['editpartydetails']['attorney_id'],'caseid'=>$param['editpartydetails']['caseid']);
							$new_data = array(
							'attorneyid'=>$result,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'typeofcontact'=>$contact_type,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid
						);
							$child_data = array_merge($data,$new_data);
							
							$result = $OsahDb->updateData($db,"attorneybycase",$child_data,$condition);
							echo "true";exit;	
					}
				}
			}else{
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
				$result = $OsahDb->getData($db,"attorneybycase",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$new_data = array(
								'Phone'=>$phone,
								'Email'=>$email,
								'Fax'=>$fax,
								'AttorneyBar'=>$attorneyBar,	
								);
					$attorney_parentdata = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"attorney",$attorney_parentdata,1);
					
					$new_data = array(
							'AttorneyBar'=>$attorneyBar,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid,
							'typeofcontact'=>$contact_type,
							'attorneyid'=>$result
					);
					$attorney_childdata = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"attorneybycase",$attorney_childdata);
				}
			}
			break;
			
			// case 'Case Worker':
			case 'Investigator':
			case 'Hearing Coordinator':
			case 'Agency Contact':
			case 'Employer':
			case 'School District':
			case 'Candidate':
			case 'Probate Judge':
			case 'Administrator':
		
			if((isset($param['editpartydetails']['contactid'])) && ($contact_type==$previous_contacttype)){
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."' and contactid!='".$param['editpartydetails']['contactid']."'";
				$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$condition = array('Contactid' => $param['editpartydetails']['contactid']);
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
								'fax'=>$fax
						);
					$parent_data = array_merge($data,$new_data);
					$result = $OsahDb->updateData($db,"agencycaseworkercontact",$parent_data,$condition);
					if($result=="1")
					{
						$condition = array('contactid' => $param['editpartydetails']['contactid'],'caseid'=>$param['editpartydetails']['caseid']);
						$new_data = array(
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid
							
						);
						$child_data = array_merge($data,$new_data);
						$result = $OsahDb->updateData($db,"agencycaseworkerbycase",$child_data,$condition);
						echo "true";exit;
					}
				}
			}else{
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
				$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
								'fax'=>$fax
						);
						$parent_data = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"agencycaseworkercontact",$parent_data,1);
						$new_data = array(
							'contactid'=>$result,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'typeofcontact'=>$contact_type,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid
						);
						$child_data = array_merge($data,$new_data);
						$result = $OsahDb->insertData($db,"agencycaseworkerbycase",$child_data);
				}
			}
			break;
			
			case 'Case Worker':
			
			if((isset($param['editpartydetails']['contactid'])) && ($contact_type==$previous_contacttype)){
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."' and contactid!='".$param['editpartydetails']['contactid']."'";
				$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
				
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					
					$condition = array('Contactid' => $param['editpartydetails']['contactid']);
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
								'fax'=>$fax
						);
					$parent_data = array_merge($data,$new_data);
					$where_condition = "Lastname = '".$lastname."' and Firstname = '".$firstname."'";
					
					$result = $OsahDb->getData($db,"agencycaseworkercontact",$where_condition,0);
					
					if(!empty($result))
					{
						$result = $OsahDb->updateData($db,"agencycaseworkercontact",$parent_data,$condition);
							$condition = array('contactid' => $param['editpartydetails']['contactid'],'caseid'=>$param['editpartydetails']['caseid']);
							$new_data = array(
								'Phone'=>$phone,
								'Email'=>$email,
								'Fax'=>$fax,
								'Docket_caseid'=>$caseid,
								'caseid'=>$caseid
								
							);
							$child_data = array_merge($data,$new_data);
							$result = $OsahDb->updateData($db,"agencycaseworkerbycase",$child_data,$condition);
							echo "true";exit;
					}else{
						$result = $OsahDb->insertData($db,"agencycaseworkercontact",$parent_data,1);
							$condition = array('contactid' => $param['editpartydetails']['contactid'],'caseid'=>$param['editpartydetails']['caseid']);
							$new_data = array(
							'contactid'=>$result,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'typeofcontact'=>$contact_type,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid
						);
							$child_data = array_merge($data,$new_data);
							$result = $OsahDb->updateData($db,"agencycaseworkerbycase",$child_data,$condition);
							echo "true";exit;	
					}
				}
			}else{
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
				$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
								'fax'=>$fax
						);
						$parent_data = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"agencycaseworkercontact",$parent_data,1);
						$new_data = array(
							'contactid'=>$result,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'typeofcontact'=>$contact_type,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid
						);
						$child_data = array_merge($data,$new_data);
						$result = $OsahDb->insertData($db,"agencycaseworkerbycase",$child_data);
				}
			}
			
			break;
			
			case 'Agency Attorney':
			
			if((isset($param['editpartydetails']['attorney_id'])) && ($contact_type==$previous_contacttype)){
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."' and attorneyid!='".$param['editpartydetails']['attorney_id']."'";
				$result = $OsahDb->getData($db,"attorneybycase",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					
					$condition = array('Attorneyid' => $param['editpartydetails']['attorney_id']);
					$new_data = array(
									'AttorneyBar'=>$attorneyBar,
									'Phone'=>$phone,
									'Email'=>$email,
									'Fax'=>$fax
									);
					$attorney_parentdata = array_merge($data,$new_data);
					$where_condition = "Lastname = '".$lastname."' and Firstname = '".$firstname."'";
					
					$result = $OsahDb->getData($db,"attorney",$where_condition,0);
					
					if(!empty($result))
					{
						$result = $OsahDb->updateData($db,"attorney",$attorney_parentdata,$condition);
							$condition = array('attorneyid' => $param['editpartydetails']['attorney_id'],'caseid'=>$param['editpartydetails']['caseid']);
							$new_data = array(
									'AttorneyBar'=>$attorneyBar,
									'Phone'=>$phone,
									'Email'=>$email,
									'Fax'=>$fax,
									'Docket_caseid'=>$caseid,
									'caseid'=>$caseid,
							);
							$attorney_childdata = array_merge($data,$new_data);
							$result = $OsahDb->updateData($db,"attorneybycase",$attorney_childdata,$condition);
							echo "true";exit;
					}else{
						$result = $OsahDb->insertData($db,"attorney",$attorney_parentdata,1);
						
							$condition = array('attorneyid' => $param['editpartydetails']['attorney_id'],'caseid'=>$param['editpartydetails']['caseid']);
							$new_data = array(
								'AttorneyBar'=>$attorneyBar,
								'Phone'=>$phone,
								'Email'=>$email,
								'Fax'=>$fax,
								'Docket_caseid'=>$caseid,
								'caseid'=>$caseid,
								'typeofcontact'=>$contact_type,
								'attorneyid'=>$result
							);
							$attorney_childdata = array_merge($data,$new_data);
							$result = $OsahDb->updateData($db,"attorneybycase",$attorney_childdata,$condition);
							echo "true";exit;
					}
				}
			}else{
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
				$result = $OsahDb->getData($db,"attorneybycase",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$new_data = array(
								'Phone'=>$phone,
								'Email'=>$email,
								'Fax'=>$fax,
								'AttorneyBar'=>$attorneyBar,	
								);
						$attorney_parentdata = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"attorney",$attorney_parentdata,1);
						$new_data = array(
							'AttorneyBar'=>$attorneyBar,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid,
							'typeofcontact'=>$contact_type,
							'attorneyid'=>$result
					);
						$attorney_childdata = array_merge($data,$new_data);
						$result = $OsahDb->insertData($db,"attorneybycase",$attorney_childdata);
				}
			}
			
			break;
			
			case 'Officer':
			if((isset($param['editpartydetails']['contactid'])) && ($contact_type==$previous_contacttype)){
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."' and contactid!='".$param['editpartydetails']['contactid']."'";
				$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
				
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					
					$condition = array('officerrid' => $param['editpartydetails']['contactid']);
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
								'fax'=>$fax
						);
					$parent_data = array_merge($data,$new_data);
					$where_condition = "Lastname = '".$lastname."' and Firstname = '".$firstname."'";
					
					$result = $OsahDb->getData($db,"officerdetails",$where_condition,0);
					
					if(!empty($result))
					{

						$result = $OsahDb->updateData($db,"officerdetails",$parent_data,$condition);
							$condition = array('contactid' => $param['editpartydetails']['contactid'],'caseid'=>$param['editpartydetails']['caseid']);
							$new_data = array(
								'Phone'=>$phone,
								'Email'=>$email,
								'Fax'=>$fax,
								'Docket_caseid'=>$caseid,
								'caseid'=>$caseid
								
							);
							$child_data = array_merge($data,$new_data);
							$result = $OsahDb->updateData($db,"agencycaseworkerbycase",$child_data,$condition);
							echo "true";exit;
					}else{
						$result = $OsahDb->insertData($db,"officerdetails",$parent_data,1);
							$tempContactID = $result;
							$condition = array('contactid' => $param['editpartydetails']['contactid'],'caseid'=>$param['editpartydetails']['caseid']);
							$new_data = array(
							'contactid'=>$result,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'typeofcontact'=>$contact_type,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid
						);
							$child_data = array_merge($data,$new_data);
												$result = $OsahDb->updateData($db,"agencycaseworkerbycase",$child_data,$condition);
							if($result){
								
								$condition = array('caseid'=>$param['editpartydetails']['caseid']);
								$new_data = array(
								'officerrid'=>$tempContactID,							
								);
								$result = $OsahDb->updateData($db,"form1205offence",$new_data,$condition);			
							}
							echo "true";exit;	
					}
				}
			}else{
				$condition = "caseid = '".$caseid."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
				$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$new_data = array(
								'phone'=>$phone,
								'email'=>$email,
								'fax'=>$fax
						);
						$parent_data = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"officerdetails",$parent_data,1);
						$new_data = array(
							'contactid'=>$result,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'typeofcontact'=>$contact_type,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid
						);
						$child_data = array_merge($data,$new_data);
						$result = $OsahDb->insertData($db,"agencycaseworkerbycase",$child_data);
				}
			}
			break;
			default :
				echo "true";exit;
			break;
		}
		
		switch($previous_contacttype){
			
			case 'Petitioner':
			case 'Respondent':
			case 'Others':
			case 'Custodial Parent':
			case 'Head of Household':
			case 'Representative':
			case 'CPAFirm':
			
			$condition = array('peopleid' => $param['editpartydetails']['peopleid']);
            $result = $OsahDb->deleteData($db,"peopledetails",$condition);
			echo $result;exit;
			
			break;
			
			case 'Minor/children':
			$condition = array('Minorid' => $param['editpartydetails']['minorid']);
            $result = $OsahDb->deleteData($db,"minordetails",$condition);
			echo $result;exit;
			
			break;
			 
			case 'Agency Attorney':
			case 'Other Attorney':
			case 'Respondent Attorney':
			case 'Petitioner Attorney':
			$condition = array('attorneyid' => $param['editpartydetails']['attorney_id']);
            $result = $OsahDb->deleteData($db,"attorneybycase",$condition);
			echo $result;exit;
			break;
			

			case 'Officer':
			
			$condition = array('contactid' => $param['editpartydetails']['contactid'],'typeofcontact' => $previous_contacttype);
            $result = $OsahDb->deleteData($db,"agencycaseworkerbycase",$condition);
			echo $result;exit;
			break;
			
			default :
				echo "true";exit;
			break;
			
			
		}
	}
	/* 
	Name : Neha Agrawal
	Description : Function is used to update the docket information
	Created Date : 06-04-2017.
	*/
	public function updatedocketAction()
	{
		$db=$this->serviceLocator->get('db1');
        $OsahDb=New OsahDbFunctions();
        $param= json_decode(file_get_contents('php://input'),true);
		$current_datetime = date("Y-m-d H:i:s");
		$caseid = $param['docket_id'];
		$condition = array('caseid' => $param['docket_id']);
		if(isset($param['docketdetails']['agencyrefnumber'])){
			$agencyrefnumber = $param['docketdetails']['agencyrefnumber'];
		}else{
			$agencyrefnumber='';
		}

		if(isset($param['docketdetails']['permiteffectivedate'])){
			$permiteffectivedate = $param['docketdetails']['permiteffectivedate'];
		}else{
			$permiteffectivedate='';
		}
		
		//get permit effectivedate to set pront permit flag 0
		$getEffectiveDateToCompare = $this->getPermitEffectiveDateForTempPermits($caseid,$OsahDb,$db);
		if($getEffectiveDateToCompare[0]['effective_date'] !=$permiteffectivedate){
			$updateTempPermitFlag =  array(
				'temp_permits'=>0
			);
			$effctive = true;
		}else{
			$effctive = false;
		}		
			$docket_data = array(
				'agencyrefnumber'=>$agencyrefnumber
			);
			
			$permit_data = array(
				'effective_date'=>$permiteffectivedate,
				'eligibility'=>$param['docketdetails']['eligiblepermit'],
				'expiry_date'=>$param['docketdetails']['expiryDate'],					
				'modified_date'=>$current_datetime,			
			);
			
			$form1205OffenceIncidentDate = array(
				'incident_date'=>$param['docketdetails']['incidentDate'],
				'dob'=>$param['docketdetails']['DOB']
			);
			if(!$effctive){
				$parentData = $docket_data;
			}else{
				$parentData = array_merge($docket_data,$updateTempPermitFlag);
			}
	
		 $result = $OsahDb->updateData($db,"docket",$parentData,$condition);
		 $result = $OsahDb->updateData($db,"permit_eligibility_effectivedate",$permit_data,$condition);
		 $result = $OsahDb->updateData($db,"form1205offence",$form1205OffenceIncidentDate,$condition);
		  echo $result;
            exit;
	}
	
	
		/// get permit effective date flag.		
		
		public function getPermitEffectiveDateForTempPermits($caseid,$OsahDb,$db){
			$sql        = "SELECT effective_date FROM permit_eligibility_effectivedate where caseid =$caseid";		

			$result 	= $OsahDb->getDatabySql($db, $sql);	
			return $result;
			exit;
		}
	
		// get county of iccureneces for optimization
		public function getCountyOfOccurencesForOptimization($countyOfOccurences,$caseid,$OsahDb,$db){
			$sql        = "SELECT county FROM docket where caseid =$caseid";						
			$result 	= $OsahDb->getDatabySql($db, $sql);	
			return $result;
			exit;
		}
		/* 
			Name : Neha Agrawal
			Created Date : 18-04-2017
			Description : Function is used to delete the docket.
		*/
		public function deletedocketAction()
		{
			$db=$this->serviceLocator->get('db1');
			$OsahDb=New OsahDbFunctions();
			$param= json_decode(file_get_contents('php://input'),true);
			$condition = array('caseid' => $param['docket_number']);
            $result = $OsahDb->deleteData($db,"docket",$condition);
			$result = $OsahDb->deleteData($db,"form1205offence",$condition);
			$result = $OsahDb->deleteData($db,"permit_eligibility_effectivedate",$condition);
			echo $result;exit;
		}
		
		/* 
			Name :Affan Shaikh
			Created Date : 21-04-2017
			Description : Function is used to print the permits
		*/
		public function printpermitsAction()
		{
			$db=$this->serviceLocator->get('db1');
			$OsahDb=New OsahDbFunctions();
			$param= json_decode(file_get_contents('php://input'),true);
			$tablename = $param['tblNm'];
			if (isset($param['clerkName'])) {
				$condition = $param['clerkName'];
			} else {
				$condition = '';
			}
			if (isset($param['license_number'])) {
				$license_number = $param['license_number'];
			} else {
				$license_number = '';
			}
			$resultSetValue = array();
			if(empty($license_number)){
				$sql             = "SELECT caseid,refagency,agencyrefnumber FROM $tablename where docketclerk = '$condition' AND temp_permits = '0' AND casetype ='ALS'";
			}
			else{
				$sql             = "SELECT caseid,refagency,agencyrefnumber FROM $tablename where agencyrefnumber = '$license_number' AND casetype ='ALS'";
			}
			$resultDocket = $OsahDb->getDatabySql($db, $sql);
			
			if(!empty($resultDocket)){
				if(count($resultDocket) >=1){
			
				$temppermits = array(
					'temp_permits' =>1
				);
/* 				print_r($resultDocket);
				exit;
 */				foreach ($resultDocket as $results) {
									
						$caseid = $results['caseid'];
						$sql="SELECT a.caseid,a.dob, a.incident_date, b.effective_date,b.expiry_date,b.eligibility,c.refagency,c.agencyrefnumber
						FROM form1205offence a, permit_eligibility_effectivedate b, docket c
						WHERE a.caseid=".$results['caseid']. " AND  b.caseid=".$results['caseid']. " AND  c.caseid=".$results['caseid']. " AND  b.eligibility='1'";

						$resultForm1205= $OsahDb->getDatabySql($db, $sql);
		
						if(!empty($resultForm1205)){
							//print_r( $resultForm1205);
							
						foreach($resultForm1205 as $resultsSet) {	
						
								$con        = 'caseid =' . $resultsSet['caseid'];							
								/* $resultSetValue[] = $results['agencyrefnumber'];
								$resultSetValue[] = $results['refagency']; */
								
								$tempPermitsSet  = $OsahDb->updateData($db, "docket", $temppermits, $con);
									if($tempPermitsSet)
									{
										 $sql="SELECT Address1,concat(Lastname,' ',Firstname) as 'petitioner_name' from peopledetails where caseid=".$resultsSet['caseid'];								 
										 $petitionerDetails = $OsahDb->getDatabySql($db, $sql); 
										if(!empty($petitionerDetails)){ 
											$resultsSet['Address1'] = $petitionerDetails[0]['Address1'];
											$resultsSet['petitioner_name'] = $petitionerDetails[0]['petitioner_name'];
										} else{
											$resultsSet['Address1'] = "";
											$resultsSet['petitioner_name'] = "";
										}
										$resultSetValue[] = $resultsSet;
											}	
								
						}
					
						
						
					}else{
						
					}
					
				}				
				if(!empty($resultSetValue)){
				$bodyhtml= "";	
				foreach($resultSetValue as $outputvalue){
					//print_r($outputvalue);
				//Html Format
				

			$bodyhtml .= '
			<div style="width:600px;margin:0 auto;  page-break-after: auto;">
			<table width="100%" cellpadding="10" cellspacing="0" border="0">
				<tr>
					<td width="100%" style="text-align: center;">
						<img src="images/stateofgeorgialogo.png" />
					</td>
				</tr>
				<tr>
					<td style="text-align: center; font-family: Lucida Sans, Lucida Sans Regular, Lucida Grande, Lucida Sans Unicode, Geneva, Verdana, sans-serif; font-size: 15px; font-weight: bold;">Georgia Department of Driver Services</td>
				</tr>
				<tr>
					<td style="text-align: center; font-family: Lucida Sans, Lucida Sans Regular, Lucida Grande, Lucida Sans Unicode, Geneva, Verdana, sans-serif; font-size: 13px; font-weight: normal; padding: 0;">Customer Service Licensing  Records Division</td>
				</tr>
				<tr>
					<td style="text-align: center; font-family: Lucida Sans, Lucida Sans Regular, Lucida Grande, Lucida Sans Unicode, Geneva, Verdana, sans-serif; font-size: 13px; font-weight: normal; padding: 0;">PO Box 80447, Conyers Georgia 30013</td>
				</tr>
				<tr>
					<td style="padding:0;">
						<table  width="100%" cellpadding="10" cellspacing="0" border="0">
							<tr>
								<td align="left" style="padding:0;">
									<table>
										<tr>
											<td style="font-family: Lucida Sans, Lucida Sans Regular, Lucida Grande, Lucida Sans Unicode, Geneva, Verdana, sans-serif; font-size: 13px; font-weight: normal; padding: 0;">Nathan Deal</td>
										</tr>
										<tr>
											<td style="font-family: Lucida Sans, Lucida Sans Regular, Lucida Grande, Lucida Sans Unicode, Geneva, Verdana, sans-serif; font-size: 13px; font-weight: normal; padding: 0;">Governor</td>
										</tr>
									</table>
								</td>
								<td align="right" style="padding:0;">
									<table>
										<tr>
											<td style="font-family: Lucida Sans, Lucida Sans Regular, Lucida Grande, Lucida Sans Unicode, Geneva, Verdana, sans-serif; font-size: 13px; font-weight: normal; padding: 0;">Robert G. Mikell</td>
										</tr>
										<tr>
											<td style="font-family: Lucida Sans, Lucida Sans Regular, Lucida Grande, Lucida Sans Unicode, Geneva, Verdana, sans-serif; font-size: 13px; font-weight: normal; padding: 0;">Commissioner</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="text-align: center; font-family: Georgia, Times New Roman, Times, serif; font-size: 13px; font-weight: bold; padding: 20px 0 0 0; letter-spacing: 1px;">EXTENSION OF TEMPORARY DRIVING PERMIT</td>
				</tr>
				<tr>
					<td style="text-align: justify; font-family: Georgia, Times New Roman, Times, serif; font-size: 13px; font-weight: normal; padding: 10px 0 0 0;">The Department of Driver Services (DDS) has received your request to appeal the proposed administrative suspension of your drivers license arising from your recent arrest for driving under the influence, and your case is being referred to the Office of State Administrative Hearings (OSAH) to be scheduled for a hearing before an Administrative Law Judge (ALJ). The administrative suspension of your drivers license will not go into effect unless and until it is affirmed by the ALJ, and the status of your drivers license with the DDS will remain valid until your case is resolved (subject to any unrelated convictions or withdrawals).</td>
				</tr>
				<tr>
					<td style="text-align: justify; font-family: Georgia, Times New Roman, Times, serif; font-size: 13px; font-weight: normal; padding: 10px 0 0 0;">The DDS hereby extends the temporary driving permit previously issued to you at the bottom of your DDS Form 1205 for a period of <b>ninety (90) days</b> from the date on which this extension is issued as reflected below. <b>Please keep this extension and the DDS Form 1205 with you whenever you are driving.</b> Your temporary driving permit will become invalid immediately if the ALJ upholds the proposed administrative suspension of your drivers license or if the DDS receives information that results in some other suspension, revocation, cancellation or other withdrawal of your drivers license unrelated to the proposed administrative license suspens ion. Any extensions of this temporary driving permit must be issued by the DDS subject to the approval of the ALJ as signed to your case.</td>
				</tr>
				<tr>
					<td style="text-align: justify; font-family: Georgia, Times New Roman, Times, serif; font-size: 13px; font-weight: normal; padding: 10px 0 0 0;">Information relating to the date, time and location of your hearing will be sent to you from OSAH. You can obtain information about your case, including the date, time and location of your hearing, by visiting OSAHs website at <a href="https://osah.ga.gov/" target="_blank">www.osah.ga.gov</a>, or by telephone at (404) 657-2800. Please allow at least ten (10) business days from the extension issue date for processing your file and the scheduling of your hearing.</td>
				</tr>
				<tr>
					<td style="text-align: justify; font-family: Georgia, Times New Roman, Times, serif; font-size: 13px; font-weight: normal; padding: 10px 0 0 0;">All other questions relating to your drivers license should be referred to the DDS at (678) 413-8400. Additional information is also available from the DDS website, <a href="https://dds.georgia.gov/" target="_blank">www.dds.ga.gov</a>.</td>
				</tr>
				<tr>
					<td style="padding:0;">
						<table width="25%">
							<tr>
								<td style="text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: normal; padding: 30px 0 0 0;">'.$outputvalue['petitioner_name'].'</td>
								
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="padding:0;">
						<table width="25%">
							<tr>
								
								<td style="text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: normal; padding: 0px ;">'.$outputvalue['Address1'].'</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: normal; padding: 30px 0 0 0;"><span>Drivers License Number:</span> <u style="font-weight: bold;">'.$outputvalue['agencyrefnumber'].'</u></td>
				</tr>
				<tr>
					<td style="text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: normal; padding: 10px 0 0 0;"><span>Date Of Birth:</span> <u style="font-weight: bold;">'.date('m-d-y', strtotime($outputvalue['dob'])).'</u></td>
				</tr>
				<tr>
					<td style="text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: normal; padding: 10px 0 0 0;"><span>Extension Issue Date:</span> <u style="font-weight: bold;">'.date('m-d-y', strtotime($outputvalue['effective_date'])).'</u></td>
				</tr>
				<tr>
					<td style="text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: normal; padding: 10px 0 0 0;"><span>Permit Expiration Date:</span> <u style="font-weight: bold;">'.date('m-d-y', strtotime($outputvalue['expiry_date'])).'</u></td>
				</tr>
				<tr>
					<td style="text-align: left; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: normal; padding: 10px 0 0 0;"><span>Incident Date:</span> <u style="font-weight: bold;">'.date('m-d-y', strtotime($outputvalue['incident_date'])).'</u></td>
				</tr>
				<tr>
					<td style="padding:0;">
						<table width="50%" align="right">
							<tr>
								<td style="text-align: right; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; padding: 10px 0 0 0; width: 100px; display: inline-block;">Spencer R. Moore, Deputy Commissioner Georgia Department Of Driver Services</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="text-align: center; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: normal; padding: 20px 0 0 0;">www.dds.ga.gov</td>
				</tr>
			</table>
		</div>';				
				}
				$pdf_name = 'TempPermits.pdf';
			
				$add_folder = "/temp/TempPermits/";
				
					$this->generateTempPermitsPDF($bodyhtml);
					$retGeneratePermitValue = array(
						'flag'=>1,
						'tmp_path'=>$add_folder.$pdf_name
					);
					print_r(json_encode($retGeneratePermitValue));
					exit;
				}else{
					echo '0';
					exit;
				}
			
			}
			}else{
					echo '0';
					exit;
			}

		}
		
		public function generateTempPermitsPDF($bodyhtml){
	
			$pdf_name = 'TempPermits.pdf';
			$add_folder = $_SERVER['DOCUMENT_ROOT']."/temp/TempPermits";
			//$css_folder =  $_SERVER['DOCUMENT_ROOT']."/css/mpdf.css";
					
				//unlink($add_folder.$pdf_name,0);
				chown($add_folder."/".$pdf_name, 0755); 
				array_map('unlink', glob("$add_folder/*.pdf"));		
				$mpdf = new mPDF('utf-8','P'); 
				//$stylesheet = file_get_contents($css_folder); // external css
				//$mpdf->WriteHTML($stylesheet,1);
				//$mpdf->WriteHTML($bodyhtml,2);
				$mpdf->WriteHTML($bodyhtml);
			  // $mpdf->Output('TempPermits.pdf','F'); 
				$mpdf->Output($add_folder."/".$pdf_name,'F');
			   //return $pdf_name;
			
		}
		
}

