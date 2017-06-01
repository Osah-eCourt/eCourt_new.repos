<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Osahform for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
 //Osah Controller updated by Neha

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
use DateTimeZone;
use mPDF;
//use Zend\View\Model\ViewModel;
//require_once '\PHPWord.php';

//require_once 'PHPWord\PHPWord.php';


use PHPWord;
use PHPWord_IOFactory;

//include "module\Osahform\src\Osahform\model\OsahDbFunctions.php";
//include "\..\..\..\..\..\OsahDbFunctions.php";
//use PHPWord\PHPWord_IOFactory;
//use PHPWord_DocumentProperties;
//use PHPWord\PHPWord;
//use PHPWord_Autoloader;
//use PHPW//
	
class OsahformController extends AbstractActionController
{
	
    protected $agencyTable;
    public $db;
    
   public function isSessionActive()
    {
        //SESSION CODE STARTS HERE
        $session = new Container('base');
    
           if(!$session->offsetExists('username'))
                {
    	           return $this->redirect()->toUrl('/Osahform/validatein');
                }
        //SESSION CODE ENDS HERE
    }
    
    
    
public function nohdocsfuncAction()
   {
        
        $db=$this->serviceLocator->get('db1');
        // echo "hello";
        $t= 1610366;
       /* $filepathn=mysql_real_escape_string($this->params()->fromQuery('filepathn'));*/
       $filepathn="D:/wamp/www/osahnewloc/public/upload/".$t."/NoticeofHearing/Noticeofhearing_154545455455.docx";

        /*$folderdatename=mysql_real_escape_string($this->params()->fromQuery('folderdatename'));*/
         $folderdatename=date(Ymd);
        $dirname=$t;
        
        $doctype="NoticeofHearing";
       
        $filedir = 'D:/wamp/www/osahnewloc/public/';
        
        if (file_exists("D:/wamp/www/osahnewloc/public/upload/".$dirname)) {
             
            $upload_path = $filedir . "upload/".$dirname . "/"; // where image will be uploaded, relative to this file
            $download_path = "upload/" .$dirname . "/"; // same folder as above, but relative to the HTML file
            //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname . "/";
        } else {
            $upload_path = $filedir . "upload/".$dirname; // where image will be uploaded, relative to this file
            $download_path = "upload/" . $dirname . "/";
            //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname;
        //  echo $upload_path;
            mkdir($upload_path,0777);
             
            $upload_path=$upload_path . "/";
        }
         
        if (file_exists($upload_path.$doctype)) {
             
            $upload_path = $upload_path . $doctype . "/"; // where image will be uploaded, relative to this file
            $download_path = $upload_path .$doctype . "/"; // same folder as above, but relative to the HTML file
            //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname . "/";
        } else {
            $upload_path = $upload_path . $doctype; // where image will be uploaded, relative to this file
            $download_path = $upload_path . $doctype . "/";
            //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname;
            mkdir($upload_path,0777); 
            $upload_path=$upload_path . "/";
        }
         
        if (file_exists($upload_path.$folderdatename)) {
             
            $upload_path = $upload_path. $folderdatename . "/"; // where image will be uploaded, relative to this file
            $download_path = $upload_path . $folderdatename . "/"; // same folder as above, but relative to the HTML file
            //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname . "/";
        } else {
            $upload_path = $upload_path . $folderdatename; // where image will be uploaded, relative to this file
            $download_path = $upload_path . $folderdatename . "/";
            //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname;
            mkdir($upload_path,0777);
             
            $upload_path=$upload_path . "/";
        }
        
        
        /*$file1='c:/iti/tmp/test5.txt';
        $person="\n runningt the program";
        file_put_contents($file1, $person, FILE_APPEND);*/
        //$doclist= $this->params()->fromQuery('doclist');
        $OsahDb=New OsahDbFunctions();
        $testP=$OsahDb->getPetitioner($db, $t);
        
        $Petitioneremails=$OsahDb->getPetitionerEmailAddr($db, $t);
        //$testP="hello";
                
        $Respondentfirstname=$OsahDb->getRespondent($db, $t);

        $petresphoneno=$OsahDb->getPetitionerPhone($db, $t);
         // echo "Hererererer"; exit;
        
        //THIS FUNCTION WILL GET IF EMAIL ADDRESS IS AVAILABLE.
        $respondentemails=$OsahDb->getRespondentEmailAddr($db, $t);
         
        $sql='SELECT * FROM docket where caseid=' . $t;
        $statement=$db->createStatement($sql);
        $result = $statement->execute();
        $arraylist="";
         
        /*$JudgeAssistantID="";
         $Judgeid="";
        $courtlocationid="";
        $hearingtime="";*/
        $post_data="";
         
        $docketnumber = "";
        $docketclerk  = "";
        $hearingreqby  = "";
        $status  = "";
        $daterequested  ="";
        $datereceivedbyOSAH  = "";
        $refagency  = "";
        $casetype  = "";
        $casefiletype  = "";
        $county  = "";
        $agencyrefnumber  = "";
        $hearingmode  = "";
        $hearingsite  = "";
        $hearingdate  = "";
        $hearingtime  = "";
        $judge  = "";
        $judgeassistant  = "";
        $hearingrequesteddate  = "";
        $others  = "";
    
         
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
                    $docketnumber = $row->docketnumber;
                    $docketclerk  = $row->docketclerk;
                    $hearingreqby  = $row->hearingreqby;
                    $status  = $row->status;
                    $daterequested  = $row->daterequested;
                    $datereceivedbyOSAH  = $row->datereceivedbyOSAH;
                    $refagency  = $row->refagency;
                    $casetype  = $row->casetype;
                    $casefiletype  = $row->casefiletype;
                    $county  = $row->county;
                    $agencyrefnumber  = $row->agencyrefnumber;
                    $hearingmode  = $row->hearingmode;
                    $hearingsite  = $row->hearingsite;
                    $hearingdate  = $row->hearingdate;
                    $hearingtime  = $row->hearingtime;
                    $judge  = $row->judge;
                    $judgeassistant  = $row->judgeassistant;
                    $hearingrequesteddate  = $row->hearingrequesteddate;
                    $others  = $row->others;
                //  $casetype  = htmlspecialchars($casetype);
                    //$post_data = json_encode($post_data);
                    //    $arraylist="1 : '". $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }" ;
                }
                $i = $i +1;
            }// end of for loop
            //  $arraylist = $arraylist + "]";
            //return $post_data;
        }//end of if loop
        /*$file1='c:/iti/tmp/test5.txt';
        $person="\n casetype" . $casetype ;
        file_put_contents($file1, $person, FILE_APPEND);*/
        
            $Agencyid=$OsahDb->getAgencyId($db,$refagency);
            $Castypeid=$OsahDb->getCaseTypeId($db, $Agencyid, $casetype);
    
   /* $file1='c:/iti/tmp/test5.txt';
    $person="\n casetype ID" . $casetype ;
    file_put_contents($file1, $person, FILE_APPEND);*/
        //IF PETITIONER IS NOT AVAILABLE, IT WILL LOOK FOR CASETYPESTYLING TABLE FOR THE PETITIONER.
        if ($testP == "")
        {
            
            
            $testP=htmlspecialchars($OsahDb->getCasestyle($db, $Agencyid, $Castypeid, "petitioner"));
        }
         
        //IF RESPONDENT IS NOT AVAILABLE, IT WILL LOOK FOR CASETYPESTYLING TABLE FOR THE RESPONDENT.
        if ($Respondentfirstname == "")
        {
        $Respondentfirstname=htmlspecialchars($OsahDb->getCasestyle($db, $Agencyid, $Castypeid, "respondent"));
        }
        
        
        
        $hearingdateup=date("F j, Y", strtotime($hearingdate));
        $today = date("m-j-Y");
        $pos=stripos($judgeassistant, " ");
        $firstn=substr($judgeassistant,$pos);
        $pos1=strlen($judgeassistant)-$pos;
        $lasttn=substr($judgeassistant,0,-$pos1);
        $cmafullname=$firstn . " " . $lasttn;
        $pos=stripos($judge, " ");
        $judgefirstn=substr($judge,$pos);
        $pos1=strlen($judge)-$pos;
        $judgelasttn=substr($judge,0,-$pos1);
        $judgefullname=$judgefirstn . " " . $judgelasttn;
        $Notes="";
        $Notes=$OsahDb->getNotes($db,$refagency,$casetype);
        
        $Noteslist=explode("+", $Notes);
        
        $notesstring="";
        
        $notescount=count($Noteslist);
        if ($Noteslist[0] != "")
        {
            //$text = str_replace(' ', '_', $text);
        $notesstring="<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[0] . "</w:t></w:r>"
        . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . " " . str_replace('&', '&amp;', $Noteslist[1]) . "</w:t></w:r></w:p>";
            //<w:rFonts w:ascii='Times New Roman Bold' w:eastAsia='Times New Roman' w:hAnsi='Times New Roman Bold' w:cs='Times New Roman'/>
    //  <w:rStyle w:val="SubtleReference"/>
        //<w:r w:rsidRPr="00A71F5D"><w:rPr><w:rFonts w:ascii="Times New Roman Bold" w:eastAsia="Times New Roman" w:hAnsi="Times New Roman Bold" w:cs="Times New Roman"/><w:smallCaps/><w:u w:val="single"/></w:rPr><w:t>Purpose Of Hearing:</w:t></w:r>
        //<w:smallCaps/><w:u w:val='single'/>rr
        
        //<w:r><w:rPr><w:rFonts w:ascii="Times New Roman" w:eastAsia="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/></w:rPr><w:t xml:space="preserve">  Visit </w:t></w:r>
        //<w:r w:rsidRPr="00C36201"><w:rPr><w:rStyle w:val="SubtleReference"/><w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/><w:b/><w:color w:val="auto"/></w:rPr><w:t>Purpose Of Hearing:</w:t></w:r>

        if ($notescount >=3)
        {
        $notesstring= $notesstring .  "<w:br/><w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[2] . "</w:t></w:r>"
                    . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . " " . str_replace('&', '&amp;', $Noteslist[3]) . "</w:t></w:r></w:p>";
            
        }
        
        if ($notescount >=5)
        {
            
            //$noteslist5str=str_replace('&', '&amp;', $Noteslist[5]);
            
             $notesstring= $notesstring .  "<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t>" . $Noteslist[4] . "</w:t></w:r>"
                    . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:val=\"single\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . " " .   str_replace('&', '&amp;', $Noteslist[5]) . "</w:t></w:r></w:p>";
             
        }
            
        
        
        
    /*  if ($notescount >7)
        {
            $notesstring= $notesstring .  "<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[6] . "</w:t></w:r>"
                    . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/></w:rPr><w:t xml:space=\"preserve\">" . " " . str_replace('&', '&amp;', $Noteslist[7]) . "</w:t></w:r></w:p>";
             
        }  */ 
        
                }
        
        
        
        $JudgeFax=$OsahDb->getJudgeFax($db, trim($judgefirstn));
         //$t has the docket number .
        $mailinglist=$OsahDb->getMailinglist($db, $t);
        $hearingsiteaddr=$OsahDb->getHearingSiteAddr($db, $hearingsite);
        $hearingsite=$hearingsite;
        //$paragraphs=$OsahDb->getParagraph($db, $refagency );
        
        $arrghearingsiteaddr=explode("+", $hearingsiteaddr); 
        
        
        
        $gcma=$OsahDb->getCma($db, trim($firstn));
        $pos=stripos($gcma, "+");
        $gcman=substr($gcma,$pos);
        
        $arrgcma=explode("+", $gcma);
        
        
        //$gcman=substr($gcma,$pos);
        
        
        $doclist="1 NOH Generic.docx";
        $PHPWord = new PHPWord();
        $doclist="ALS NOH.docx";
        
        $filenamepath="D:/wamp/www/osahnewloc/data/templates/" . $doclist;
        //      $filenamepath="C:\mplates\Template.docx";
        //$document = $PHPWord->loadTemplate("C:\mplates\Template.docx");
         
        $document = $PHPWord->loadTemplate($filenamepath);
        //echo "temp" . $filenamepath;
        $filedocname='Noticeofhearing_' . $dirname . ".docx";
    //  $filename = 'C:\mplates\Solarsystem.docx';
        $filename = $upload_path . $filedocname;
        
        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
        //$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
         
        //$document->setValue('Name',$doclist);
        $document->setValue('Values1', $testP);
        $document->setValue('Value12', $Respondentfirstname);
        $document->setValue('Value2', $docketnumber);
    //  
        $document->setValue('Value29', $mailinglist);
        if ($arrghearingsiteaddr[1] !="")
        {
        $addr2=trim($arrghearingsiteaddr[0]) . "<w:br/>    " .  trim($arrghearingsiteaddr[1]);
        }
        else
        {
        $addr2=trim($arrghearingsiteaddr[0]);
        }
        //$newtext = wordwrap($addr2, 5, "\n");
        //$document->setValue('Value11', $agencyrefnumber);
        $document->setValue('Values2',$today);    //  Todays Date
        
        $document->setValue('Value16',$hearingdateup); // $hearingdateup
        
        
        $hearingtimesmallcaps= strtolower($hearingtime);
        $document->setValue('Value5',$hearingtimesmallcaps);   //$hearingtime
        
        $hearingsitesmallcaps= strtolower($hearingsite);
        $hearingsitesmallcaps1=ucwords($hearingsitesmallcaps);
        $document->setValue('Value6', $hearingsitesmallcaps1);
        
        $addr2smallcaps=ucwords(strtolower($addr2));
        $document->setValue('Value14', $addr2smallcaps);
        //$document->setValue('Value13', $arrghearingsiteaddr[1]);
        
        $arrghearingsiteaddrsmallcaps=ucwords(strtolower($arrghearingsiteaddr[2]));
        $document->setValue('City',$arrghearingsiteaddrsmallcaps );
        
        //  $document->setValue('Value4', $hearingdate);
        //  $document->setValue('Value5', $hearingtime);
        //  $document->setValue('Value6', $hearingsite);
        //$document->setValue('Value5','true3');
        
    //  $document->setValue('Notes12', $Notes);
         
         
        //$document->setValue('Value50','true3');
        
        
        $phonelast4=substr($arrgcma[1], -4);
        
        $phonesecond3= substr($arrgcma[1], 3, 3);
        
        $phonefirst3= substr($arrgcma[1], 0, 3);
        
        $phone = $phonefirst3 . "-". $phonesecond3 . "-" . $phonelast4;
        
        
   //   $JudgeFax
        
        $Faxlast4=substr($JudgeFax, -4);
         
        $Faxsecond3= substr($JudgeFax, 3, 3);
         
        $Faxfirst3= substr($JudgeFax, 0, 3);
         
        $JudgeFax = $Faxfirst3 . "-". $Faxsecond3 . "-" . $Faxlast4;
        
        $document->setValue('Value7', $firstn);  //First Name - Judge Assistant Name
        $document->setValue('Value8', $lasttn);  // Last Name - Judge Assistant Name 
        $document->setValue('Value19', $agencyrefnumber);
        $document->setValue('Value11', $arrgcma[2]); //Email
        
        $document->setValue('Value9', $phone);  //Telephone Address
        
        $document->setValue('Value10', $JudgeFax);  //Fax
        $document->setValue('Value15', $notesstring); // Footer
        
        $document->setValue('ADDRESS2', $JudgeFax);
        //$document->setValue('Value18', $judgefullname);
    //  $section = $PHPWord->createSection();
    /*  $section->addPageBreak();
        $section->addText(
                htmlspecialchars(
                        '"The greatest accomplishment is not in never falling, '
                        . 'but in rising again after you fall." '
                        . '(Vince Lombardi)'
                ),
                $fontStyleName
        );*/
        //$document = $PHPWord->loadTemplate($filenamepath);
        //$document->setValue('Value7', $firstn);
        //FOOTER
        //$row->judgeassistantlue
        
    //  echo "i may be used" . $temp_file;
    //  echo "no more use " . $filename;
        $document->save($temp_file);
        copy($temp_file, $filename);
    //  readfile($temp_file);
    //  unlink($temp_file);
   //   $sql="";
        $sql="<script> window.close();</script>";
        
        
        //EMAILING FUNCTIONALITY IS BELOW 
        
    /*  $to = "gkambala@osah.ga.gov";
        $subject = "This is subject";
        $message = "This is simple text message.";
        $header = "From:gkambala@gkambala.ga.gov \r\n";
        $retval = mail ($to,$subject,$message,$header); */
        
        
        $response = $this->getResponse();
        $response->setStatusCode(200);
        //  $response->setContent(json_encode($data));
        $response->setContent($sql);
         
    //  $headers = $response->getHeaders();
    //  $headers->addHeaderLine('Content-Type', 'application/text');
         
        return $response;
         
    }
	/* Author Name:  
	S
     * Date Created :  Sept-2016
     * Date Modified : 
     * Function Description: Function "templateloadAction()" this function will  dynamicakly load the templet or
	 * view from view folder
     */
	public function templateloadAction(){
		
		$templatename = $_REQUEST['name'];
        $view = new ViewModel();
		$view->setTerminal(true);
		$view->setTemplate('osahform/osahform/'.$templatename);
        return $view;
	}
    
    /* 
        Name : Amol S
        Date Created : 12-12-2016
        Date Modifyed : 21-01-2017
        Description : Function attachdocsfuncAction is used to Attach and print the mailerlists in Document template.
    */
    
    public function attachdocsfuncAction(){
        $param= json_decode(file_get_contents('php://input'),true);
        $doctype='';
        $db=$this->serviceLocator->get('db1');
        //$length1= $this->params()->fromQuery('length1');   
         $length1= 3;      
       
        $OsahDb=New OsahDbFunctions();
        $t =  $param['docketNo']; //Get The Docket No 
         $selectedPartyDetails= $param['partytypes'];   //All Party Involed in docket
        $length=0;
        $length= count($selectedPartyDetails);
        $sk=1;
       
        if($selectedPartyDetails != ""){
            $typeofcontactidaddr=$selectedPartyDetails;
         }
        else{  $typeofcontactidaddr=""; }
           /*File Write Function*/ 
        
        //$filepathn="D:/wamp/www/osahnewloc/public/upload/".$t."/NoticeofHearing/Noticeofhearing_154545455455.docx";
       
        $folderdatename=date('mdYHis');    
        
         

        /*File Write Function*/ 
        // $this->filewrite("document_tamplate.txt","documents ",$filepathn);
         $dirname=$t;
         /* Get the document Type and create folere according to it*/
            $document_id=$param['document_id'];
            $condition="id=".$document_id;
            $templatedocument = $OsahDb->getData($db,'casetypedocuments',$condition,0);

            if($templatedocument[0]['documenttype']!=''||$templatedocument[0]['documenttype']!=null)
                $doctype=$templatedocument[0]['documenttype'];
            else   
                $doctype = 'Document';
			$casetype_documentname = $templatedocument[0]['documentname'];

          
             /* Get The Documnet Name Here*/
              $doclist= $t."_".$templatedocument[0]['documentname'];

                $filepathn = $doclist;

            
            $filedir = $_SERVER['DOCUMENT_ROOT']."/";
           
             
            $filedir2 = $_SERVER['DOCUMENT_ROOT'];//ALS Order Vacating Default_no response with NOH.docx
           
    if (file_exists($filedir."upload/".$dirname)) {
             
            $upload_path = $filedir . "upload/".$dirname . "/"; // where image will be uploaded, relative to this file
            $download_path = "upload/" .$dirname . "/"; // same folder as above, but relative to the HTML file
            
        } else {
            $upload_path = $filedir . "upload/".$dirname; // where image will be uploaded, relative to this file
            $download_path = "upload/" . $dirname . "/";
            
            mkdir($upload_path,0777);
             
            $upload_path=$upload_path . "/";
        }
       
        if (file_exists($upload_path.$doctype)) {
             
            $upload_path = $upload_path . $doctype . "/"; // where image will be uploaded, relative to this file
            $download_path = $download_path .$doctype . "/"; // same folder as above, but relative to the HTML file
            
        } else {
            $upload_path = $upload_path . $doctype; // where image will be uploaded, relative to this file
            $download_path = $download_path . $doctype . "/";
            mkdir($upload_path,0777);
            $upload_path=$upload_path . "/";
        }
         
        if (file_exists($upload_path.$folderdatename)) {
             
            $upload_path = $upload_path. $folderdatename . "/"; // where image will be uploaded, relative to this file
            $download_path = $download_path . $folderdatename . "/"; // same folder as above, but relative to the HTML file
            
        } else {
            $upload_path = $upload_path . $folderdatename; // where image will be uploaded, relative to this file
            $download_path = $download_path . $folderdatename . "/";
            mkdir($upload_path,0777);
            $upload_path=$upload_path . "/";
        }
        
        
        $testP=$OsahDb->getPetitioner($db, $t);
            
        $testP=trim($testP, " ");
        $Petitioneremails=$OsahDb->getPetitionerEmailAddr($db, $t);
        
        $Respondentfirstname=$OsahDb->getRespondent($db, $t);
        $Respondentfirstname=trim($Respondentfirstname, " ");
        $petresphoneno=$OsahDb->getPetitionerPhone($db, $t);
               
        //THIS FUNCTION WILL GET IF EMAIL ADDRESS IS AVAILABLE.
        $respondentemails=$OsahDb->getRespondentEmailAddr($db, $t);
         
        
        $condition="caseid=".$t;
        $docketDetailsResultset = $OsahDb->getData($db,'docket',$condition,0);
       
        $arraylist="";
         
        
        $post_data="";
         
        $docketnumber = "";
        $docketclerk  = "";
        $hearingreqby  = "";
        $status  = "";
        $daterequested  ="";
        $datereceivedbyOSAH  = "";
        $refagency  = "";
        $casetype  = "";
        $casefiletype  = "";
        $county  = "";
        $agencyrefnumber  = "";
        $hearingmode  = "";
        $hearingsite  = "";
        $hearingdate  = "";
        $hearingtime  = "";
        $judge  = "";
        $judgeassistant  = "";
        $hearingrequesteddate  = "";
        $others  = "";
       /* echo "<pre>";
        print_r($docketDetailsResultset);
        echo count($docketDetailsResultset); exit;*/
          
        if (count($docketDetailsResultset)>0 && $docketDetailsResultset!=''){
            
            $i=0;
            foreach ($docketDetailsResultset as $row) {
                
                if($i == 0){
                    $docketnumber          = $row['docketnumber'];
                    $caseid                = $row['caseid'];
                    $docketclerk           = $row['docketclerk'];
                    $hearingreqby          = $row['hearingreqby'];
                    $status                = $row['status'];
                    $daterequested         = $row['daterequested'];
                    $datereceivedbyOSAH    = $row['datereceivedbyOSAH'];
                    $refagency             = $row['refagency'];
                    $casetype              = $row['casetype'];
                    $casefiletype          = $row['casefiletype'];
                    $county                = $row['county'];
                    $agencyrefnumber       = $row['agencyrefnumber'];
                    $hearingmode           = $row['hearingmode'];
                    $hearingsite           = $row['hearingsite'];
                    $hearingdate           = $row['hearingdate'];
                    $hearingtime           = $row['hearingtime'];
                    $judge                 = $row['judge'];
                    $judgeassistant        = $row['judgeassistant'];
                    $hearingrequesteddate  = $row['hearingrequesteddate'];
                    $others                = $row['others'];
                        
                    
                }
                $i = $i +1;
            }// end of for loop
            //  $arraylist = $arraylist + "]";
            //return $post_data;
        }//end of if loop
        
        
        if ($agencyrefnumber == ""){
            $agencyrefnumber=$caseid;
        }
        
        /* Get The Agency code Here */
        $condition="Agencycode='{$refagency}'";
        $agencyDetailsResultset = $OsahDb->getData($db,'agency',$condition,0);
        $Agencyid=($agencyDetailsResultset[0]['AgencyID']!='')? $agencyDetailsResultset[0]['AgencyID']:"";
    
        //$Agencyid=$OsahDb->getAgencyId($db,$refagency);
        /* Get The Casetypeid */

        
        //Get The Casetype Deytails
         $condition="CaseCode='{$casetype}' and AgencyID=".$Agencyid;
         $casetypeDetailsResultset = $OsahDb->getData($db,'casetypes',$condition,0);
         $Castypeid=(count($casetypeDetailsResultset[0]['Casetypeid'])>0)? $casetypeDetailsResultset[0]['Casetypeid']:"";

             //$Castypeid=$OsahDb->getCaseTypeId($db, $Agencyid, $casetype);

   
              $condition="Casetypeid='{$Castypeid}' and AgencyID=".$Agencyid ;
              $casetypestylingDeailResultset = $OsahDb->getData($db,'casetypestyling',$condition,0);

   
        //IF PETITIONER IS NOT AVAILABLE, IT WILL LOOK FOR CASETYPESTYLING TABLE FOR THE PETITIONER.
        if ($testP == ""){
             //$testP=$OsahDb->getCasestyle($db, $Agencyid, $Castypeid, "petitioner");
            $testP=$casetypestylingDeailResultset[0]['petitioner'];
        }


        $testP=htmlspecialchars(strtoupper($testP));
        
        //IF RESPONDENT IS NOT AVAILABLE, IT WILL LOOK FOR CASETYPESTYLING TABLE FOR THE RESPONDENT.
        if ($Respondentfirstname == ""){
            // $Respondentfirstname=$OsahDb->getCasestyle($db, $Agencyid, $Castypeid, "respondent");
             $Respondentfirstname=$casetypestylingDeailResultset[0]['respondent'];
        }
        
        $Respondentfirstname=htmlspecialchars(strtoupper($Respondentfirstname));
        
    if(isset($hearingdate))
        {
            $hearingdateup=date("F j, Y", strtotime($hearingdate));
        }
        else 
        {
            $hearingdateup="";
        }
        
        
        $hearingdateday=date("jS ");  //Todays date
        
        $hearingdatemmyyyy=date("F, Y"); //Todays date
        $today = date("m-d-Y");
        $pos=stripos($judgeassistant, " ");
        $firstn=substr($judgeassistant,$pos);
        $pos1=strlen($judgeassistant)-$pos;
        $lasttn=substr($judgeassistant,0,-$pos1);
        $cmafullname=$firstn . " " . $lasttn;
        $pos=stripos($judge, " ");
        $judgefirstn=substr($judge,$pos);
        $pos1=strlen($judge)-$pos;
        $judgelasttn=substr($judge,0,-$pos1);
        
         $sql="SELECT * FROM `judges` where FirstName like '%" . trim($judgefirstn) . "%' and LastName like '%" . trim($judgelasttn) . "%'";
         $result = $OsahDb->getDatabySql($db,$sql);
         $judgemiddlename=" " .$result[0]['MiddleInitial']." ";

       // $judgemiddlename=$OsahDb->getJudgeMiddleName($db, $judgefirstn, $judgelasttn);
        $judgefullname=$judgefirstn . $judgemiddlename . $judgelasttn;
        $judgelasttn=str_replace('\\', '', $judgelasttn);
        $judgefilename="Judge" . strtolower($judgelasttn) . ".png";
        $Notes="";
        
        $Notes=$OsahDb->getNotes($db,$refagency,$casetype);


    $appealsheetcontactinfo="";
    $contactinfo=$OsahDb->getContactInfo($db,$refagency,$casetype);
    $appealsheetcontactinfo=$OsahDb->getAppealsheetContactInfo($db,$refagency,$casetype);
        $Noteslist=explode("+", $Notes);
       
        $notesstring="";
        $notesstringpar1="";
        $notesstringpar2="";
        
        $notesstringpar3="";
        $notesstringpar4="";
        $notesstringpar111="";
        $notescount=count($Noteslist);
        //below code is to italic font.
        //. "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:i w:val=\"true\" /><w:smallCaps/></w:rPr><w:t>Hello  </w:t></w:r>"
       
    if ($Noteslist[0] != "")
        {
        
            $notesstringpar111=$Noteslist[0];
        //  $notesstringpar110=str_replace("'", "’", $Noteslist[1]);
            $notesstringpar112=str_replace('&', '&amp;', $Noteslist[1]);

            $notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
            
            $notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
            
            /*File Write Function*/ 
            $this->filewrite("document_tamplate.txt","documents ",$notesstringpar114);

            $notesstringpar1="<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $notesstringpar111 . "</w:t></w:r>"
            .   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"              
            . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " . $notesstringpar114  . "</w:t></w:r></w:p>";

           /* $person="\n documents12 ".$notesstringpar1;
            file_put_contents($file1, $person, FILE_APPEND);*/
            
            
       
        
         
        
        if ($Noteslist[2] != "")
        {
            
            $notesstringpar112=str_replace('&', '&amp;', $Noteslist[3]);
            $notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
            
           
            $notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
            
            
        $notesstringpar2= "<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[2] . "</w:t></w:r>" 
                .   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
                    . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " . $notesstringpar114 . "</w:t></w:r></w:p>";
            
        }
        
        if ($Noteslist[4] != "")
        {
            
            //$noteslist5str=str_replace('&', '&amp;', $Noteslist[5]);
            
            $notesstringpar112=str_replace('&', '&amp;', $Noteslist[5]);
            $notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
            
            
            $notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
            
            $notesstringpar3=   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t>" . $Noteslist[4] . "</w:t></w:r>"
                    .   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
                    . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:val=\"single\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " .  $notesstringpar114 . "</w:t></w:r>";
             
        }
        
        if ($Noteslist[6] != "")
        {
             
            //$noteslist5str=str_replace('&', '&amp;', $Noteslist[5]);
             
            $notesstringpar112=str_replace('&', '&amp;', $Noteslist[7]);
            $notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
             
           
            $notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
             
            $notesstringpar4=   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t>" . $Noteslist[6] . "</w:t></w:r>"
                    .   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
                            . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:val=\"single\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " .  $notesstringpar114 . "</w:t></w:r>";
             
        }
            
            }   
        
        
    /*  if ($notescount >7)
        {
            $notesstring= $notesstring .  "<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[6] . "</w:t></w:r>"
                    . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/></w:rPr><w:t xml:space=\"preserve\">" . " " . str_replace('&', '&amp;', $Noteslist[7]) . "</w:t></w:r></w:p>";
             
        }  */
        
            $AllMinors=$OsahDb->getMinorDetails($db, $t);
            $AllMinorsList=explode("++", $AllMinors);
            
        $JudgeFax=$OsahDb->getJudgeFax($db, trim($judgefirstn));
         //$t has the docket number .
        $mailinglist=$OsahDb->getMailinglist($db, $t);
        $AllAddress="";
       if($typeofcontactidaddr != "")
        {
            $AllAddress=$OsahDb->getMlist($db, $t, $typeofcontactidaddr);
             
        }
        
        
      
        
        /*File Write Function*/ 
        $this->filewrite("document_tamplate.txt","Address list ",$AllAddress);
         
        $AllAddressList=explode("++", $AllAddress);
         
        $hearingsiteaddr=$OsahDb->getHearingSiteAddr($db, $hearingsite);
        $hearingsite=htmlspecialchars($hearingsite);
       
        //$paragraphs=$OsahDb->getParagraph($db, $refagency );
        
        $arrghearingsiteaddr=explode("+", $hearingsiteaddr); 
        
        
       
        $gcma=$OsahDb->getCma($db, trim($firstn));
        $officerfullname=$OsahDb->getOfficerFullName($db,$caseid);
        $pos=stripos($gcma, "+");
        $gcman=substr($gcma,$pos);
        
        $arrgcma=explode("+", $gcma);
         
        
        //$gcman=substr($gcma,$pos);
        
        
        $doclist1=str_replace($t ."_", "",$doclist);
        $doclist2=str_replace("'", "", $doclist1);
        
        $PHPWord = new PHPWord();
        $filenamepath= $_SERVER['DOCUMENT_ROOT']."/../data/templates/" . $doclist2;
        
        $sigfile=$_SERVER['DOCUMENT_ROOT']."/../data/templates/sigfile/" . $judgefilename;
        
        $document = $PHPWord->loadTemplate($filenamepath);
        
        $filedocname= $dirname.'_' . $doctype ."_".$length. ".docx";
        $filename = $filepathn;
        
        
        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
       
        /*File Write Function*/ 
        $this->filewrite("document_tamplate.txt","documents ",$filename);
     
        $document->setValue('Values1', $testP);
    
        $document->setValue('Value12', $Respondentfirstname);
        $document->setValue('Value69', $petresphoneno);
        
        //$docketnumber
        $findcaseid=$caseid . "-";
        $Trdocketnumber=str_replace($findcaseid, "",$docketnumber);
        $Trdocketnumberfl=$caseid . "-OSAH-" . $Trdocketnumber;
        $document->setValue('Value2', $Trdocketnumberfl); // Full docket number
        $document->setValue('Value41', $caseid);  // Case id
        
        $document->setValue('Value55', $contactinfo);
        $document->setValue('Value56', $appealsheetcontactinfo);
        $document->setValue('Value41', $caseid);
        
    //  
        $document->setValue('Value29', $mailinglist);
        $daterequested1=date("m-d-Y",strtotime($daterequested));
        $document->setValue('Value71', $daterequested1);
        
        $AllAddressListcount=count($AllAddressList);
        $tk=0;
        
         
        
        if (isset($AllAddressList[$sk]))
            $document->setValue('Address1', $AllAddressList[$sk]);
        else
            $document->setValue('Address1', "");
        
        $rk=2;
        
        for($k=1;$k<=6;$k++)
        {
        if($k != $sk)
        {
         
        if (isset($AllAddressList[$k]))
            $document->setValue('Address' . $rk, $AllAddressList[$k]);
            else
                $document->setValue('Address' . $rk, "");
        
                $rk++;
        }
        
        }
        
        
        //  Minor names set and birth years.
        
        $Minorcount=1;
        
        if (isset($AllMinorsList[$Minorcount]))
        {
            $document->setValue('Minor1', $AllMinorsList[$Minorcount]);
            $document->setValue('Minoryear1', $AllMinorsList[$Minorcount+1]);
        }
        else
        {
            $document->setValue('Minor1', "");
            $document->setValue('Minoryear', "");
        }
        
        $rk=2;
        
        for($k=1;$k<=8;$k=$k+2)
        {
            if($k != $Minorcount)
            {
                 
                if (isset($AllMinorsList[$k]))
                {
                    $document->setValue('Minor' . $rk, $AllMinorsList[$k]);
                    $document->setValue('Minoryear' . $rk, $AllMinorsList[$k+1]);
                }
                else
                {
                    $document->setValue('Minor' . $rk, "");
                    $document->setValue('Minoryear' . $rk, "");
                }
        
                $rk++;
            }
             
        }
        
        
        
        if ($arrghearingsiteaddr[1] !="")
        {
        $addr2=$arrghearingsiteaddr[0] . "<w:cr/>" .  $arrghearingsiteaddr[1];
        }
        else
        {
        $addr2=$arrghearingsiteaddr[0];
        }
        //$newtext = wordwrap($addr2, 5, "\n");
        //$document->setValue('Value11', $agencyrefnumber);
        $document->setValue('Values2',$today);    //  Todays Date
        
        $document->setValue('Value16',$hearingdateup); // $hearingdateup
        
        $document->setValue('Value42',$hearingdateday); // $hearingdate day (number)
        
        
        $document->setValue('Value43',$hearingdatemmyyyy); // $hearingdate month and year
        
    $judgefullname=str_replace("\'","'",$judgefullname);
    
    
    $document->setValue('Value60',$officerfullname);
        $document->setValue('Value91',$judgefullname);
        
        $label=$testP . "<w:br/>" .  $docketnumber . "<w:br/>" . $county . "<w:tab/><w:tab/> " . $testP . "<w:br/>" .  $docketnumber . "<w:br/>" . $county;
        $document->setValue('Value99',$label);   // Single label

    
        $hearingtimesmallcaps= strtolower($hearingtime);
        $document->setValue('Value5',$hearingtimesmallcaps);   //$hearingtime
        
        $hearingsitesmallcaps= $hearingsite;
        $hearingsitesmallcaps1=$hearingsitesmallcaps;
        $document->setValue('Value6', $hearingsitesmallcaps1);
        
        $addr2smallcaps=$addr2;
        $document->setValue('Value14', $addr2smallcaps);
        //$document->setValue('Value13', $arrghearingsiteaddr[1]);
        
        $arrghearingsiteaddrsmallcaps=$arrghearingsiteaddr[2];
        $document->setValue('City',$arrghearingsiteaddrsmallcaps );
        
        //  $document->setValue('Value4', $hearingdate);
        //  $document->setValue('Value5', $hearingtime);
        //  $document->setValue('Value6', $hearingsite);
        //$document->setValue('Value5','true3');
        
    //  $document->setValue('Notes12', $Notes);
         
         
        //$document->setValue('Value50','true3');
        
        
        $phonelast4=substr($arrgcma[1], -4);
        
        $phonesecond3= substr($arrgcma[1], 3, 3);
        
        $phonefirst3= substr($arrgcma[1], 0, 3);
        
        $phone = $phonefirst3 . "-". $phonesecond3 . "-" . $phonelast4;
        
        
            //   $JudgeFax
        
        $Faxlast4=substr($JudgeFax, -4);
         
        $Faxsecond3= substr($JudgeFax, 3, 3);
         
        $Faxfirst3= substr($JudgeFax, 0, 3);
         
        $JudgeFax = $Faxfirst3 . "-". $Faxsecond3 . "-" . $Faxlast4;
        
        $document->setValue('Value7', $firstn);  //First Name - Judge Assistant Name
        $document->setValue('Value8', $lasttn);  // Last Name - Judge Assistant Name 
        $document->setValue('Value19', $agencyrefnumber);
        $document->setValue('Value11', $arrgcma[2]); //Email
        
        $document->setValue('Value9', $phone);  //Telephone Address
        
        $document->setValue('Value10', $JudgeFax);  //Fax
        $document->setValue('Value15', $notesstringpar1); // Footer
        $document->setValue('Value25', $notesstringpar2);
    
        if (file_exists($sigfile))
        {
                $document->replaceStrToImg('Value39', $sigfile);
        }
        else
        {
            $document->setValue('Value39', '');
        }
         //Attachement replacement.
        $document->setValue('Value35', $notesstringpar3);
        $document->setValue('Value36', $notesstringpar4);
        
        $document->setValue('ADDRESS2', $JudgeFax);
        $filedir1= $upload_path.$filedocname;

        $document->save($temp_file);
            
        copy($temp_file, $filedir1);
        $filedir2=str_replace('docx', 'pdf', $filedir1);
        $filename2=str_replace('docx', 'pdf', $filename);
        $pdf_file=str_replace('docx', 'pdf', $filedocname);
        $pdf_path=$upload_path.str_replace('docx', 'pdf', $filedocname);
        $exe_location=$_SERVER['DOCUMENT_ROOT'].'/../data/filewrite/pdf/OfficeToPDF.exe ';
        // passthru($exe_location . '"' . $filedir1 .'" ' . '"' . $pdf_path .'"');
        //passthru($_SERVER['DOCUMENT_ROOT'].'/../data/filewrite/pdf/OfficeToPDF.exe' . ' "' . $filedir1 .'" ' . '"' . $pdf_path .'"');
        /*File Write Function*/ 
        $this->filewrite("document_tamplate.txt","File Paths ","Temp File:  " . $temp_file."\n File Dir1: ".$filedir1);
    
         /*Make Entery in Documentstable table  And Attachment path too*/

          $filedocname= ($param['pdf_doc_flage']==1)? $filedocname:$pdf_file;
    
         // echo $filedocname; exit;
    /* doc_file_flage 0  this flage is used for Documnet templates  and 1 for Documnets*/
            //echo $sql; 
        $fileData =array(
                    'Caseid'       =>$t,
                    'DocumentType' =>$doctype,
                    'DateRequested'=>date('Y-m-d'),
                    'Description'  =>$param['description'],
                    'DocumentName' =>$filedocname,
                    'Docket_caseid'=>$t,
                    'doc_file_flage'=> 0,
                    'casetype_doc_id'=> $document_id

                    );
        if($param['doc_stable_id']==0){
            //Insert Data in documentstable and attachment path
                if($param['pdf_doc_flage']!=1){       
                   
                    $fileData['created_date']= date('Y-m-d H:i:s');
                    $document_id_last_id = $OsahDb->insertData($db,"documentstable",$fileData,1);
                    $data = array(
                        'documentid'=>$document_id_last_id,
                        'attachmentpath'=>"/".$download_path."/".$filedocname
                    );
                    $result = $OsahDb->insertData($db,"attachmentpaths",$data);
                }

        }else{
            // Update Data in documentstable and attachment path
            if($param['pdf_doc_flage']!=1){
                $condition = array('documentid' => $param['doc_stable_id']);
                $fileData['modified_date']= date('Y-m-d H:i:s');
                $OsahDb->updateData($db,"documentstable",$fileData,$condition);
                 

                $data = array(
                            'attachmentpath'=>"/".$download_path."/".$filedocname
                        );
                $OsahDb->updateData($db,"attachmentpaths",$data,$condition);
            }
        }
        echo  ($param['pdf_doc_flage']==1)? $download_path.$filedocname : $download_path."/".$pdf_file;
        
        exit;
      
    }
    
    
public function printdocsfuncAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	
    	$t= $this->params()->fromQuery('docketno');
    	$test=0;
    	$doclist= $this->params()->fromQuery('doclist');
    	$textype= $this->params()->fromQuery('textype');
    	
    	$length1= $this->params()->fromQuery('length1');
    	$sk=1;
    	
    	if($textype != "")
    	{
    		
    	
    	$typeofcontactidaddr=explode("+", $textype);
    	
    	$length=count($typeofcontactidaddr);
    	}
    	else
    	{
    		$typeofcontactidaddr="";
    	}
    	//$doclist= $this->params()->fromQuery('doclist');
    	$OsahDb=New OsahDbFunctions();
    	$testP=$OsahDb->getPetitioner($db, $t);
    	
    	$Petitioneremails=$OsahDb->getPetitionerEmailAddr($db, $t);
    	//$testP="hello";
    	$Respondentfirstname=$OsahDb->getRespondent($db, $t);

    	$petresphoneno=$OsahDb->getPetitionerPhone($db, $t);
    	    	
    	//THIS FUNCTION WILL GET IF EMAIL ADDRESS IS AVAILABLE.
    	$respondentemails=$OsahDb->getRespondentEmailAddr($db, $t);
    	 
    	$sql='SELECT * FROM docket where caseid=' . $t;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	 
    	/*$JudgeAssistantID="";
    	 $Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";*/
    	$post_data="";
    	 
    	$docketnumber = "";
    	$docketclerk  = "";
    	$hearingreqby  = "";
    	$status  = "";
    	$daterequested  ="";
    	$datereceivedbyOSAH  = "";
    	$refagency  = "";
    	$casetype  = "";
    	$casefiletype  = "";
    	$county  = "";
    	$agencyrefnumber  = "";
    	$hearingmode  = "";
    	$hearingsite  = "";
    	$hearingdate  = "";
    	$hearingtime  = "";
    	$judge  = "";
    	$judgeassistant  = "";
    	$hearingrequesteddate  = "";
    	$others  = "";
    
    	 
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
    				$docketnumber = $row->docketnumber;
    				$caseid = $row->caseid;
    				$docketclerk  = $row->docketclerk;
    				$hearingreqby  = $row->hearingreqby;
    				$status  = $row->status;
    				$daterequested  = $row->daterequested;
    				$datereceivedbyOSAH  = $row->datereceivedbyOSAH;
    				$refagency  = $row->refagency;
    				$casetype  =  $row->casetype;
    				$casefiletype  = $row->casefiletype;
    				$county  = $row->county;
    				$agencyrefnumber  = $row->agencyrefnumber;
    				$hearingmode  = $row->hearingmode;
    				$hearingsite  = $row->hearingsite;
    				$hearingdate  = $row->hearingdate;
    				$hearingtime  = $row->hearingtime;
    				$judge  = mysql_real_escape_string($row->judge);
    				$judgeassistant  = $row->judgeassistant;
    				$hearingrequesteddate  = $row->hearingrequesteddate;
    				$others  = $row->others;
    					
    				//$post_data = json_encode($post_data);
    				//    $arraylist="1 : '". $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }" ;
    			}
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		//return $post_data;
    	}//end of if loop
    	$docketnumber=str_replace('&', '&amp;', $docketnumber);
    	
    	if ($agencyrefnumber == "")
    	{
    		$agencyrefnumber=$caseid;
    	}
    	
    //	$casetype=$casetype1;
   	$Agencyid=$OsahDb->getAgencyId($db,$refagency);
  	$Castypeid=$OsahDb->getCaseTypeId($db, $Agencyid, $casetype);
  	
  	$file1='c:/iti/tmp/test1.txt';
  	$person="\n Petitioner " . $testP;
  	file_put_contents($file1, $person, FILE_APPEND);
    	//IF PETITIONER IS NOT AVAILABLE, IT WILL LOOK FOR CASETYPESTYLING TABLE FOR THE PETITIONER.
    	if ($testP == "")
    	{
   	$testP=htmlspecialchars($OsahDb->getCasestyle($db, $Agencyid, $Castypeid, "petitioner"));
    	}
    	 
    	//IF RESPONDENT IS NOT AVAILABLE, IT WILL LOOK FOR CASETYPESTYLING TABLE FOR THE RESPONDENT.
    	if ($Respondentfirstname == "")
    	{
    	$Respondentfirstname=htmlspecialchars($OsahDb->getCasestyle($db, $Agencyid, $Castypeid, "respondent"));
    	}
    	
    	$file1='c:/iti/tmp/test1.txt';
    	$person="\n Petitioner " . $textype;
    	file_put_contents($file1, $person, FILE_APPEND);
    
    	if(isset($hearingdate))
    	{
    		$hearingdateup=date("F j, Y", strtotime($hearingdate));
    	}
    	else 
    	{
    		$hearingdateup="";
    	}
    	
    	
    	$hearingdateday=date("jS ");  //Todays date
    	
    	$hearingdatemmyyyy=date("F, Y"); //Todays date
    	$today = date("m-d-Y");
    	$pos=stripos($judgeassistant, " ");
    	$firstn=substr($judgeassistant,$pos);
    	$pos1=strlen($judgeassistant)-$pos;
    	$lasttn=substr($judgeassistant,0,-$pos1);
    	$cmafullname=$firstn . " " . $lasttn;
    	$pos=stripos($judge, " ");
    	$judgefirstn=substr($judge,$pos);
    	$pos1=strlen($judge)-$pos;
    	$judgelasttn=substr($judge,0,-$pos1);
    	$judgemiddlename=$OsahDb->getJudgeMiddleName($db, $judgefirstn, $judgelasttn);
    	$judgefullname=$judgefirstn . $judgemiddlename . $judgelasttn;
    	
    	$judgefilename="Judge" . strtolower($judgelasttn) . ".png";
    	$Notes="";
   		$Notes=$OsahDb->getNotes($db,$refagency,$casetype);
    	$contactinfo="";
    	$appealsheetcontactinfo="";
   		$contactinfo=$OsahDb->getContactInfo($db,$refagency,$casetype);
   		$appealsheetcontactinfo=$OsahDb->getAppealsheetContactInfo($db,$refagency,$casetype);
    	$Noteslist=explode("+", $Notes);
    	
    	$notesstring="";
    	$notesstringpar1="";
    	$notesstringpar2="";
    	
    	$notesstringpar3="";
    	$notesstringpar4="";
    	$notesstringpar111="";
    	$notescount=count($Noteslist);
    	//below code is to italic font.
    	//.	"<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:i w:val=\"true\" /><w:smallCaps/></w:rPr><w:t>Hello  </w:t></w:r>"
   	
   	if ($Noteslist[0] != "")
    	{
    	
    		
    	//	$notesstringpar110=str_replace("'", "�", $Noteslist[1]);
    		
    		$notesstringpar110=$Noteslist[1];
    		$notesstringpar111=mysql_real_escape_string($Noteslist[0]);
    		//$notesstringpar111=mysql_real_escape_string($notesstringpar110);
    		
    		$notesstringpar112=str_replace('&', '&amp;', $notesstringpar110);
//� '�
    		$notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
    		
    		//$notesstringpar113=str_replace("ita1", "ti", $notesstringpar112);
    		$notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
    		//str_replace('&', '&amp;', $Noteslist[1])
    		//$text = str_replace(' ', '_', $text);
    		
    		
    		$notesstringpar1="<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $notesstringpar111 . "</w:t></w:r>"
    	    .	"<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"      		
    		. "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " . $notesstringpar114  . "</w:t></w:r></w:p>";

    		
    		
    		
    	//<w:rPr><w:b w:val="true"/></w:rPr>
    	//<w:u w:val="single"/>
    	
    	 
    	//<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>
    		//<w:rFonts w:ascii='Times New Roman Bold' w:eastAsia='Times New Roman' w:hAnsi='Times New Roman Bold' w:cs='Times New Roman'/>
    //	<w:rStyle w:val="SubtleReference"/>
    	//<w:r w:rsidRPr="00A71F5D"><w:rPr><w:rFonts w:ascii="Times New Roman Bold" w:eastAsia="Times New Roman" w:hAnsi="Times New Roman Bold" w:cs="Times New Roman"/><w:smallCaps/><w:u w:val="single"/></w:rPr><w:t>Purpose Of Hearing:</w:t></w:r>
    	//<w:smallCaps/><w:u w:val='single'/>rr
    	
    	//<w:r><w:rPr><w:rFonts w:ascii="Times New Roman" w:eastAsia="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/></w:rPr><w:t xml:space="preserve">  Visit </w:t></w:r>
    	//<w:r w:rsidRPr="00C36201"><w:rPr><w:rStyle w:val="SubtleReference"/><w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/><w:b/><w:color w:val="auto"/></w:rPr><w:t>Purpose Of Hearing:</w:t></w:r>
    	
    	if ($Noteslist[2] != "")
    	{
    		
    		$notesstringpar112=str_replace('&', '&amp;', $Noteslist[3]);
    		$notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
    		
    		//$notesstringpar113=str_replace("ita1", "ti", $notesstringpar112);
    		$notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
    		
    		
    	$notesstringpar2= "<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[2] . "</w:t></w:r>" 
    			.	"<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
    				. "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " . $notesstringpar114 . "</w:t></w:r></w:p>";
    		
    	}
    	
    	if ($Noteslist[4] != "")
    	{
    		
    		//$noteslist5str=str_replace('&', '&amp;', $Noteslist[5]);
    		
    		$notesstringpar112=str_replace('&', '&amp;', $Noteslist[5]);
    		$notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
    		
    		//$notesstringpar113=str_replace("ita1", "ti", $notesstringpar112);
    		$notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
    		
    		$notesstringpar3=   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t>" . $Noteslist[4] . "</w:t></w:r>"
    		 		.	"<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
    				. "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:val=\"single\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " .  $notesstringpar114 . "</w:t></w:r></w:p>";
    		 
    	}
    	
    	
    	if ($Noteslist[6] != "")
    	{
    	
    		//$noteslist5str=str_replace('&', '&amp;', $Noteslist[5]);
    	
    		$notesstringpar112=str_replace('&', '&amp;', $Noteslist[7]);
    		$notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
    	
    		//$notesstringpar113=str_replace("ita1", "ti", $notesstringpar112);
    		$notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
    	
    		$notesstringpar4=   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t>" . $Noteslist[6] . "</w:t></w:r>"
    				.	"<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
    						. "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:val=\"single\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " .  $notesstringpar114 . "</w:t></w:r>";
    		 
    	}
    		
    	  	}  	
    	
    	
   /*	if ($notescount >7)
    	{
    		$notesstring= $notesstring .  "<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[6] . "</w:t></w:r>"
    				. "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/></w:rPr><w:t xml:space=\"preserve\">" . " " . str_replace('&', '&amp;', $Noteslist[7]) . "</w:t></w:r></w:p>";
    		 
    	}  */
    	
    	$AllMinors=$OsahDb->getMinorDetails($db, $t);	
    	$AllMinorsList=explode("++", $AllMinors);
    	
    	
    	$JudgeFax=$OsahDb->getJudgeFax($db, trim($judgefirstn));
    	 //$t has the docket number .
        $mailinglist=$OsahDb->getMailinglist($db, $t);
        $AllAddress="";
        if(isset($typeofcontactidaddr))
        		{
         			$AllAddress=$OsahDb->getMlist($db, $t, $typeofcontactidaddr);
         			
        		}
        		$AllAddressList=explode("++", $AllAddress);
        
    	$hearingsiteaddr=$OsahDb->getHearingSiteAddr($db, $hearingsite);
    	$hearingsite=htmlspecialchars($hearingsite);
    	
    	//$paragraphs=$OsahDb->getParagraph($db, $refagency );
    	
    	$arrghearingsiteaddr=explode("+", $hearingsiteaddr); 
    	
    	
    	
    	$gcma=$OsahDb->getCma($db, trim($firstn));
    	$officerfullname=$OsahDb->getOfficerFullName($db,$caseid);
    	$pos=stripos($gcma, "+");
    	$gcman=substr($gcma,$pos);
    	
    	$arrgcma=explode("+", $gcma);
    	
    	
    	//$gcman=substr($gcma,$pos);
    	
    	
    	//$doclist="1 NOH Generic.docx";
    	$PHPWord = new PHPWord();
    	 
    	$filenamepath="C:\mplates\\" . $doclist;
    	
    	$sigfile="C:\mplates\sigfile\\" . $judgefilename;
    	//   	$filenamepath="C:\mplates\Template.docx";
    	//$document = $PHPWord->loadTemplate("C:\mplates\Template.docx");
    	$dirname="";
    	$document = $PHPWord->loadTemplate($filenamepath);
    	//echo "temp" . $filenamepath;
    	$filedocname='Noticeofhearing_' . $dirname . ".docx";
    //	$filename = 'C:\mplates\Solarsystem.docx';
    	$filename = $filedocname;
    	
    	$filename = tempnam(sys_get_temp_dir(), 'PHPWord');
    	//$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
    	 
    	//$document->setValue('Name',$doclist);
    	$document->setValue('Values1', strtoupper($testP));
    	$document->setValue('Value12', strtoupper($Respondentfirstname));
    	$document->setValue('Value69', $petresphoneno);
    	
    	
    	//$docketnumber
    	$findcaseid=$caseid . "-";
    	$Trdocketnumber=str_replace($findcaseid, "",$docketnumber);
    	$Trdocketnumberfl=$caseid . "-OSAH-" . $Trdocketnumber;
    	$document->setValue('Value2', $Trdocketnumberfl); // Full docket number
    	$document->setValue('Value41', $caseid);  // Case id
    	
    	$document->setValue('Value55', $contactinfo);
    	$document->setValue('Value56', $appealsheetcontactinfo);
    	
    	$document->setValue('Value41', $caseid);
    	
    //	
    	$document->setValue('Value29', $mailinglist);
    	$daterequested1=date("m-d-Y",strtotime($daterequested));
    	$document->setValue('Value71', $daterequested1);
    	$AllAddressListcount=count($AllAddressList);
    	$tk=0;
    	//for($ji=1; $ji<$AllAddressListcount;$ji++)
    //	{
    
/*    	if (isset($AllAddressList[1])) 
    		$document->setValue('Address1', $AllAddressList[1]);
    	else
    		$document->setValue('Address1', "");

    	if (isset($AllAddressList[2]))
    		$document->setValue('Address2', $AllAddressList[2]);
    	else
    		$document->setValue('Address2', "");
    	 
    	if (isset($AllAddressList[3]))
    		$document->setValue('Address3', $AllAddressList[3]);
    	else
    		$document->setValue('Address3', "");
    	 
    	if (isset($AllAddressList[4]))
    		$document->setValue('Address4', $AllAddressList[4]);
    	else
    		$document->setValue('Address4', "");
    	 
    	if (isset($AllAddressList[5]))
    		$document->setValue('Address5', $AllAddressList[5]);
    	else
    		$document->setValue('Address5', "");
    	 
    	if (isset($AllAddressList[6]))
    		$document->setValue('Address6', $AllAddressList[6]);
    	else
    		$document->setValue('Address6', "");
    		
    	//	$tk=$ji;*/
    	
    	//}
    /*	if($tk>6)
    	{
    		for($sk=0;$tk<7;$tk++)
    			{
    				$document->setValue('Address' . $tk, "");
    			}
    	}*/
    		
    	
    	if (isset($AllAddressList[$sk]))
    		$document->setValue('Address1', $AllAddressList[$sk]);
    	else
    		$document->setValue('Address1', "");
    	 
    	$rk=2;
    	 
    	for($k=1;$k<=6;$k++)
    	{
    	if($k != $sk)
    	{
    	
    	if (isset($AllAddressList[$k]))
    		$document->setValue('Address' . $rk, $AllAddressList[$k]);
    				else
    		$document->setValue('Address' . $rk, "");
    		 
    		$rk++;
    	}
    	 
    	}
    	
    	
    	//  Minor names set and birth years.
    	
    	$Minorcount=1;
    	
    	if (isset($AllMinorsList[$Minorcount]))
    	{
    		$document->setValue('Minor1', $AllMinorsList[$Minorcount]);
    	    $document->setValue('Minoryear1', $AllMinorsList[$Minorcount+1]);
    	}
    	else
    	{
    		$document->setValue('Minor1', "");
    	$document->setValue('Minoryear', "");
    	}
    	
    	$rk=2;
    	
    	for($k=1;$k<=8;$k=$k+2)
    	{
    	if($k != $Minorcount)
    	{
    	 
    	if (isset($AllMinorsList[$k]))
    	{
    		$document->setValue('Minor' . $rk, $AllMinorsList[$k]);
    	$document->setValue('Minoryear' . $rk, $AllMinorsList[$k+1]);
    	}
    		else
    		{
    		$document->setValue('Minor' . $rk, "");
    		$document->setValue('Minoryear' . $rk, "");
    		}
    		 
    		$rk++;
    	}
    	
    	}
    	
    	
    	
    	
    	
    	if ($arrghearingsiteaddr[1] !="")
    	{
   		$addr2=$arrghearingsiteaddr[0] . "<w:cr/>" .  $arrghearingsiteaddr[1];
    	}
    	else
    	{
    	$addr2=$arrghearingsiteaddr[0];
    	}
   		//$newtext = wordwrap($addr2, 5, "\n");
    	//$document->setValue('Value11', $agencyrefnumber);
    	$document->setValue('Values2',$today);    //  Todays Date
    	
    	$document->setValue('Value16',$hearingdateup); // $hearingdateup
    	
    	$document->setValue('Value42',$hearingdateday); // $hearingdate day (number)
    	
    	
    	$document->setValue('Value43',$hearingdatemmyyyy); // $hearingdate month and year
    	
    $judgefullname=str_replace("\'","'",$judgefullname);
    
    
    $document->setValue('Value60',$officerfullname);
    	$document->setValue('Value91',$judgefullname);
    	
    	$label=$testP . "<w:br/>" .  $docketnumber . "<w:br/>" . $county . "<w:tab/><w:tab/> " . $testP . "<w:br/>" .  $docketnumber . "<w:br/>" . $county;
    	$document->setValue('Value99',$label);   // Single label

    /*	<w:pPr><w:tabs><w:tab w:val="start" pos="2160"/><w:tab w:val="start" pos="5040"/></w:tabs></w:pPr>
    	*/ 
    	$hearingtimesmallcaps= strtolower($hearingtime);
    	$document->setValue('Value5',$hearingtimesmallcaps);   //$hearingtime
    	
    	$hearingsitesmallcaps= $hearingsite;
    	$hearingsitesmallcaps1=$hearingsitesmallcaps;
    	$document->setValue('Value6', $hearingsitesmallcaps1);
    	
    	//$addr2smallcaps=ucwords(strtolower($addr2));
    	$addr2smallcaps=$addr2;
    	$document->setValue('Value14', $addr2smallcaps);
    	//$document->setValue('Value13', $arrghearingsiteaddr[1]);
    	
    //	$arrghearingsiteaddrsmallcaps=ucwords(strtolower($arrghearingsiteaddr[2]));
    	$arrghearingsiteaddrsmallcaps=$arrghearingsiteaddr[2];
    	$document->setValue('City',$arrghearingsiteaddrsmallcaps );
    	
    	//	$document->setValue('Value4', $hearingdate);
    	//	$document->setValue('Value5', $hearingtime);
    	//	$document->setValue('Value6', $hearingsite);
    	//$document->setValue('Value5','true3');
    	
    //	$document->setValue('Notes12', $Notes);
    	 
    	 
    	//$document->setValue('Value50','true3');
    	
    	
    	$phonelast4=substr($arrgcma[1], -4);
    	
    	$phonesecond3= substr($arrgcma[1], 3, 3);
    	
    	$phonefirst3= substr($arrgcma[1], 0, 3);
    	
    	$phone = $phonefirst3 . "-". $phonesecond3 . "-" . $phonelast4;
    	
    	
   // 	$JudgeFax
    	
    	$Faxlast4=substr($JudgeFax, -4);
    	 
    	$Faxsecond3= substr($JudgeFax, 3, 3);
    	 
    	$Faxfirst3= substr($JudgeFax, 0, 3);
    	 
    	$JudgeFax = $Faxfirst3 . "-". $Faxsecond3 . "-" . $Faxlast4;
    	
    	$document->setValue('Value7', $firstn);  //First Name - Judge Assistant Name
    	$document->setValue('Value8', $lasttn);  // Last Name - Judge Assistant Name 
    	$document->setValue('Value19', $agencyrefnumber);
    	$document->setValue('Value11', $arrgcma[2]); //Email
    	
    	$document->setValue('Value9', $phone);  //Telephone Address
    	
    	$document->setValue('Value10', $JudgeFax);  //Fax
    	$document->setValue('Value15', $notesstringpar1); // Footer
   		$document->setValue('Value25', $notesstringpar2);
    	
    if (file_exists($sigfile))
    	{
    			$document->replaceStrToImg('Value39', $sigfile);
    	}
    	else
    	{
    		$document->setValue('Value39', '');
    	}  //Attachement replacement.
    	$document->setValue('Value35', $notesstringpar3);
    	$document->setValue('Value36', $notesstringpar4);
    	/*$document->replaceStrToImg('AreaImg', $arrImagenes);
    	 $documentName = 'Concepto_Tecnico_' . date('Ymd_His') . '.docx';
    	$document->save( $documentName);*/
    	$document->setValue('ADDRESS2', $JudgeFax);
    	    	
    	
    	//$tablestr=(string)$table;
  // 	$document->setValue('Value15', $tablestr);
    
   //	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
   // 	$objWriter->save('testTable.docx');
    	$document->save($filename);
    	
  // 	header("Content-disposition: attachment; filename=". $filename . ";");
   	$filename12="";
   	$filenamepath = "C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/temp/";
   	
   	
   //	$filename122 =$caseid. "_Osahdocument". "_".date("Y-m-d_H-is",time()).  ".docx";
   	$firtpartfilename=chop($doclist, ".docx");
   	$filename122 =$caseid. "_".$firtpartfilename . "_" . date("Y-m-d_H-is",time()). ".docx";
   	
   	
  $filename12= 	$filenamepath.$filename122;
   	copy($filename, $filename12);
   	$file1='c:/iti/tmp/test1.txt';
   	$person="\n documents ".$filename12;
   	file_put_contents($file1, $person, FILE_APPEND);
   // 	readfile($filename); 
    // 	unlink($filename);
   	$sql="/temp/".$filename122;
     
     	
     	$path = "C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/temp/";
     	if ($handle = opendir($path)) {
     		while (false !== ($file = readdir($handle))) {
     			if ((time()-filectime($path.$file)) > 86400) {
     				if (preg_match('/\.docx$/i', $file)) {
     					unlink($path.$file);
     				}
     			}
     		}
     	}
     //	$document->save($temp_file);
     //	copy($temp_file, $filename);
     	//	readfile($temp_file);
     	//	unlink($temp_file);
     	// 	$sql="";
     	//$sql="<script> window.close();</script>";
     	
     	$response = $this->getResponse();
     	$response->setStatusCode(200);
     	//  $response->setContent(json_encode($data));
     	$response->setContent($sql);
     	 
     	$headers = $response->getHeaders();
     	$headers->addHeaderLine('Content-Type', 'application/text');
     	 
     	return $response;
   
   
   
    }
    
    /* 
      Name : Amol S
      Date Created : 24-02-2017
      Description : ExportdocsfuncAction this function will Generate Bulk Documents 
      
     */
    
      public function exportdocsfuncAction()
    {
        
         $param= json_decode(file_get_contents('php://input'),true);
       
        $refagency=$param['docketinfo']['refagency'];
        $refagency_id=$param['docketinfo']['refagency'];
        $casetypeId=$param['docketinfo']['casetype'];
         $agencyName='';  $documentName=''; $caseName='';
        switch ($param['docketinfo']['refagency']) {
            case '7':
                # agencyName=> CSS case Type=> EST documentName=> CSS-EST NOH.docx
                 $agencyName='CSS'; $caseName='EST'; $documentName='CSS-EST NOH.docx';
                break;

            case '199':
                   # agencyName=> DDS case Type=> ALS documentName=> ALS NOH.docx /ALS_91-day letter.docx
                $agencyName='DDS'; $caseName='ALS';
                     $documentName=($param['docketinfo']['documentid']==81)?'ALS NOH.docx':'ALS_91-day letter.docx';
                break;

            case '125':
                # agencyName=> DPS case Type=> ALS documentName=> ALS NOH.docx

                $agencyName='DPS'; $caseName='ALS'; $documentName='ALS NOH.docx';
                break; 

            case '237':
                     # agencyName=> OIG case Type=> EBTFSF documentName=> EBT_NOH.docx
                $agencyName='OIG'; $caseName='EBTFSF'; $documentName='EBT_NOH.docx';    
                break;
                
                      
            default:
                return false;
                break;
        }



         
        $db=$this->serviceLocator->get('db1'); 
        //$t= $this->params()->fromQuery('docketno');
        $test=0;
        
        $doclist= $documentName;
        $refagency= $agencyName;
        $casetype= $caseName;
        $datere=  $param['docketinfo']['date_received'];

        $textype= $param['docketinfo']['mailer_contact'].=($param['docketinfo']['party_contact']!='')?"+".$param['docketinfo']['party_contact']:'';
        $nocounty= $param['docketinfo']['nintyoneday'];
        $lenmailerlist=$param['docketinfo']['mailer_count'];

        
        $sql="";
        $length=0;
        if($textype != ""){
            $typeofcontactidaddr=explode("+", $textype);             
            $length=count($typeofcontactidaddr);
        }else{
            $typeofcontactidaddr="";
            $length=0;
        }
        
        //echo  $length; exit;
        
        $flder=date("Y-m-d_H-is",time());
        $clrflder=date("Y-m-d_H-is",time());

         

        $flder= $_SERVER['DOCUMENT_ROOT']."/../data/docs/Bulkdocs/" . $flder;
        $Clerkflder= $_SERVER['DOCUMENT_ROOT']."/../data/docs/Clerkdocs/" . $clrflder;
        //echo   $flder
        mkdir($flder,0777);
        mkdir($Clerkflder,0777);
      
        //date("Y-m-d_H-is",time())
        
        $sql1="select * from docket where county not like '%No County%' and `status`!='Closed' and refagency='" . $refagency ."' and casetype='" . $casetype . "' and datereceivedbyOSAH='" . $datere . "'";
        if($nocounty == 'yes'){
            //$sql1="select * from docket where county like '%No County%' and `status`!='Closed' refagency='" . $refagency ."' and casetype='" . $casetype . "' and datereceivedbyOSAH='" . $datere . "'";
            $sql1="select docket.*, DATEDIFF(CURRENT_DATE(), docket.datereceivedbyOSAH) AS `nine_one_day` FROM docket WHERE county LIKE '%No County%' AND `status`!='Closed' and refagency='" . $refagency ."' and casetype='" . $casetype . "' AND datereceivedbyOSAH='" . $datere . "' AND DATEDIFF(CURRENT_DATE(), docket.docket_createddate) >91";
        }
       // echo $sql1; exit;
       
        $OsahDb=New OsahDbFunctions();
        $docketResultset= $OsahDb->getDatabySql($db,$sql1);
        // echo count($docketResultset); exit;
        //echo "<pre>"; print_r($docketResultset);exit;
        if(count($docketResultset)>0){
             
            $i=0;
            foreach ($docketResultset as $row12) {
                $t=$row12['caseid'];
                /* Disposition insertion code starts here */
                 
                if($nocounty == "yes"){
                     
                    $today1 = date("Y-m-d");
                
                    //$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
                    $docketdispositionArray= array(
                        'caseid'=>$t,
                        'dispositioncode'=>'Closed-91-Day Letter','dispositiondate'=>$today1,'signedbyjudge'=>$today1,'mailedddate'=>$today1,'hearingyesno'=>'No'
                        );
                    //$sqldisp="INSERT INTO  (`caseid`, `dispositioncode`, `dispositiondate`, `signedbyjudge`, `mailedddate`, `hearingyesno`) VALUES (" . $t .", 'Closed-61-Day Letter','". $today1 ."', '" . $today1 . "', '".  $today1 . "', 'No')";
                    $OsahDb->insertData($db,'docketdisposition',$docketdispositionArray); # Added Entery in to docketdisposition table 
                     
                    //$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
                   /* $statementdisp=$db->createStatement($sqldisp);
                    $resultdisp = $statementdisp->execute();*/
                    
                    $statuscl="Closed";

                    // $docketupdate = ( $row12['refagency']=='DDS' && $row12['casetype']=='ALS')?array( 'status'=>'Closed','county'=>'No County','hearingmode'=>'Desk Review','hearingtime'=>'09:00:00','hearingtime_id'=>4,'judge'=>'Malihi Michael','judgeassistant'=>'Griffin Kacie','hearingsite'=>'OSAH - Office of State Administrative Hearings'):array( 'status'=>$statuscl);
                     $docketupdate = array('status'=>$statuscl);
                     $update_condition = array( 'caseid'=>$t);
            //echo '<pre>'; print_r($docketupdate); exit;
                    $OsahDb->updateData($db,'docket',$docketupdate,$update_condition);

                    /*$sqlcl="update docket set status='" . $statuscl . "' where caseid = '" . $t . "'";
                    
                    $statement2cl=$db->createStatement($sqlcl);
                    $result2cl = $statement2cl->execute();*/

                     
                }
                 
                /*******
                 *
                *
                *
                * Disposition insertion code ends here
                *
                *
                *
                *
                */
              
                
                
        /*
                $file1='c:/iti/tmp/test99.txt';
                $person="\n Petitioner " . $t;
                file_put_contents($file1, $person, FILE_APPEND);*/
                
       // $OsahDb=New OsahDbFunctions();
        $testP=$OsahDb->getPetitioner($db, $t);
         
        $Petitioneremails=$OsahDb->getPetitionerEmailAddr($db, $t);
        //$testP="hello";
        $Respondentfirstname=$OsahDb->getRespondent($db, $t);
    
    
    
        //THIS FUNCTION WILL GET IF EMAIL ADDRESS IS AVAILABLE.
        $respondentemails=$OsahDb->getRespondentEmailAddr($db, $t);
    
        $sql="select * from docket where caseid=".$t;
       /* $file1='c:/iti/tmp/test99.txt';
        $person="\n Petitioner " . $sql;
        file_put_contents($file1, $person, FILE_APPEND);*/
    
        $result= $OsahDb->getDatabySql($db,$sql);

        /*$statement=$db->createStatement($sql);
        $result = $statement->execute();*/
        $arraylist="";
    
        /*$JudgeAssistantID="";
         $Judgeid="";
        $courtlocationid="";
        $hearingtime="";*/
        $post_data="";
    
        $docketnumber = "";
        $docketclerk  = "";
        $hearingreqby  = "";
        $status  = "";
        $daterequested  ="";
        $datereceivedbyOSAH  = "";
        $refagency  = "";
        $casetype  = "";
        $casefiletype  = "";
        $county  = "";
        $agencyrefnumber  = "";
        $hearingmode  = "";
        $hearingsite  = "";
        $hearingdate  = "";
        $hearingtime  = "";
        $judge  = "";
        $judgeassistant  = "";
        $hearingrequesteddate  = "";
        $others  = "";
        
        //if ($result instanceof ResultInterface && $result->isQueryResult())
        if (count($result)>0){
            /*$resultSet = new ResultSet;
            $resultSet->initialize($result);*/
            //type : 'options', value : 1, text : 'Aaaaa, Aaa'
            $i=0;
            foreach ($result as $row) {
    
                //$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
                // /Osahform/newform
                //$caseid11="<a href=\'/Osahform/newform?docketno=\"" . $row->caseid . "\"\'>" . $row->caseid . "</a>";
                //$caseid11="";
                if($i == 0)
                {
                    $docketnumber           = $row['docketnumber'];
                    $caseid                 = $row['caseid'];
                    $docketclerk            = $row['docketclerk'];
                    $hearingreqby           = $row['hearingreqby'];
                    $status                 = $row['status'];
                    $daterequested          = $row['daterequested'];
                    $datereceivedbyOSAH     = $row['datereceivedbyOSAH'];
                    $refagency              = $row['refagency'];
                    $casetype               = $row['casetype'];
                    $casefiletype           = $row['casefiletype'];
                    $county                 = $row['county'];
                    $agencyrefnumber        = $row['agencyrefnumber'];
                    $hearingmode            = $row['hearingmode'];
                    $hearingsite            = $row['hearingsite'];
                    $hearingdate            = $row['hearingdate'];
                    $hearingtime            = $row['hearingtime'];
                    $judge                  = $row['judge'];
                    $judgeassistant         = $row['judgeassistant'];
                    $hearingrequesteddate   = $row['hearingrequesteddate'];
                    $others                 = $row['others'];
                        
                    //$post_data = json_encode($post_data);
                    //    $arraylist="1 : '". $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }" ;
                }
                $i = $i +1;
            }// end of for loop
            //  $arraylist = $arraylist + "]";
            //return $post_data;
        }//end of if loop
         
        if ($agencyrefnumber == "")
        {
            $agencyrefnumber=$caseid;
        }
         
         
        //$Agencyid=$OsahDb->getAgencyId($db,$refagency);
        $Agencyid = $refagency_id;
        //$Castypeid=$OsahDb->getCaseTypeId($db, $Agencyid, $casetype);
        $Castypeid = $casetypeId;
        /*$file1='c:/iti/tmp/test99.txt';
        $person="\n Petitioner " . $testP;
        file_put_contents($file1, $person, FILE_APPEND);*/
        //IF PETITIONER IS NOT AVAILABLE, IT WILL LOOK FOR CASETYPESTYLING TABLE FOR THE PETITIONER.
        if ($testP == "")
        {
            $testP=htmlspecialchars($OsahDb->getCasestyle($db, $Agencyid, $Castypeid, "petitioner"));
        }
    
        //IF RESPONDENT IS NOT AVAILABLE, IT WILL LOOK FOR CASETYPESTYLING TABLE FOR THE RESPONDENT.
        if ($Respondentfirstname == "")
        {
            $Respondentfirstname=htmlspecialchars($OsahDb->getCasestyle($db, $Agencyid, $Castypeid, "respondent"));
        }
          
        /*$file1='c:/iti/tmp/test99.txt';
        $person="\n respondent " . $Respondentfirstname;
        file_put_contents($file1, $person, FILE_APPEND);*/
    
         
        $hearingdateup=date("F j, Y", strtotime($hearingdate));
         
        $hearingdateday=date("jS ");  //Todays date

       /* $file1='c:/iti/tmp/test99.txt';
        $person="\n before judge full name " . $t;
        file_put_contents($file1, $person, FILE_APPEND);*/
        
        $hearingdatemmyyyy=date("F, Y"); //Todays date
        $today = date("m-d-Y");
        $pos=stripos($judgeassistant, " ");
        $firstn=substr($judgeassistant,$pos);
        $pos1=strlen($judgeassistant)-$pos;
        $lasttn=substr($judgeassistant,0,-$pos1);
        $cmafullname=$firstn . " " . $lasttn;
        $pos=stripos($judge, " ");
        $judgefirstn=substr($judge,$pos);
        $pos1=strlen($judge)-$pos;
        $judgelasttn=substr($judge,0,-$pos1);
        $judgemiddlename=$OsahDb->getJudgeMiddleName($db, $judgefirstn, $judgelasttn);
        $judgefullname=$judgefirstn . $judgemiddlename . $judgelasttn;
         
        /*$file1='c:/iti/tmp/test99.txt';
        $person="\n after judge full name " . $t;
        file_put_contents($file1, $person, FILE_APPEND);*/
        
        $judgefilename="Judge" . strtolower($judgelasttn) . ".png";
        $Notes="";
        $Notes=$OsahDb->getNotes($db,$refagency,$casetype);
        $contactinfo=$OsahDb->getContactInfo($db,$refagency,$casetype);
        $Noteslist=explode("+", $Notes);
      
        /*$file1='c:/iti/tmp/test99.txt';
        $person="\n after get notes " . $t;
        file_put_contents($file1, $person, FILE_APPEND);*/
        
        $notesstring="";
        $notesstringpar1="";
        $notesstringpar2="";
         
        $notesstringpar3="";
        $notesstringpar4="";
        $notesstringpar111="";
        $notescount=count($Noteslist);
        //below code is to italic font.
        //. "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:i w:val=\"true\" /><w:smallCaps/></w:rPr><w:t>Hello  </w:t></w:r>"
        
        if ($Noteslist[0] != "")
        {
             
    
            //  $notesstringpar110=str_replace("'", "’", $Noteslist[1]);
    
            $notesstringpar110=$Noteslist[1];
            $notesstringpar111=$Noteslist[0];
            //$notesstringpar111=mysql_real_escape_string($notesstringpar110);
    
            $notesstringpar112=str_replace('&', '&amp;', $notesstringpar110);
            //’ '’
            $notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
    
            //$notesstringpar113=str_replace("ita1", "ti", $notesstringpar112);
            $notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
            //str_replace('&', '&amp;', $Noteslist[1])
            //$text = str_replace(' ', '_', $text);
    
    
            $notesstringpar1="<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $notesstringpar111 . "</w:t></w:r>"
                    .   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
                            . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " . $notesstringpar114  . "</w:t></w:r></w:p>";
    
    
    
    
            //<w:rPr><w:b w:val="true"/></w:rPr>
            //<w:u w:val="single"/>
             
    
            //<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>
            //<w:rFonts w:ascii='Times New Roman Bold' w:eastAsia='Times New Roman' w:hAnsi='Times New Roman Bold' w:cs='Times New Roman'/>
            //  <w:rStyle w:val="SubtleReference"/>
            //<w:r w:rsidRPr="00A71F5D"><w:rPr><w:rFonts w:ascii="Times New Roman Bold" w:eastAsia="Times New Roman" w:hAnsi="Times New Roman Bold" w:cs="Times New Roman"/><w:smallCaps/><w:u w:val="single"/></w:rPr><w:t>Purpose Of Hearing:</w:t></w:r>
            //<w:smallCaps/><w:u w:val='single'/>rr
             
            //<w:r><w:rPr><w:rFonts w:ascii="Times New Roman" w:eastAsia="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/></w:rPr><w:t xml:space="preserve">  Visit </w:t></w:r>
            //<w:r w:rsidRPr="00C36201"><w:rPr><w:rStyle w:val="SubtleReference"/><w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/><w:b/><w:color w:val="auto"/></w:rPr><w:t>Purpose Of Hearing:</w:t></w:r>
             
            if ($Noteslist[2] != "")
            {
    
                $notesstringpar112=str_replace('&', '&amp;', $Noteslist[3]);
                $notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
    
                //$notesstringpar113=str_replace("ita1", "ti", $notesstringpar112);
                $notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
    
    
                $notesstringpar2= "<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[2] . "</w:t></w:r>"
                        .   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
                                . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " . $notesstringpar114 . "</w:t></w:r></w:p>";
    
            }
             
            if ($Noteslist[4] != "")
            {
    
                //$noteslist5str=str_replace('&', '&amp;', $Noteslist[5]);
    
                $notesstringpar112=str_replace('&', '&amp;', $Noteslist[5]);
                $notesstringpar113=str_replace("ita1", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:i/></w:rPr><w:t>", $notesstringpar112);
    
                //$notesstringpar113=str_replace("ita1", "ti", $notesstringpar112);
                $notesstringpar114=str_replace("ita2", "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">", $notesstringpar113);
    
                $notesstringpar3=   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t>" . $Noteslist[4] . "</w:t></w:r>"
                        .   "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/></w:rPr><w:t>:  </w:t></w:r>"
                                . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:val=\"single\" w:cs=\"Times New Roman\"/><w:jc w:val=\"distribute\"/></w:rPr><w:t xml:space=\"preserve\">" . "  " .  $notesstringpar114 . "</w:t></w:r>";
                 
            }
    
        }
        /*$file1='c:/iti/tmp/test99.txt';
        $person="\n after notes string " . $t;
        file_put_contents($file1, $person, FILE_APPEND);*/
         
        /*  if ($notescount >7)
         {
        $notesstring= $notesstring .  "<w:p><w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:hAnsi=\"Times New Roman\" /><w:b/><w:smallCaps/><w:u w:val=\"single\"/></w:rPr><w:t>" . $Noteslist[6] . "</w:t></w:r>"
        . "<w:r><w:rPr><w:rFonts w:ascii=\"Times New Roman\" w:eastAsia=\"Times New Roman\" w:hAnsi=\"Times New Roman\" w:cs=\"Times New Roman\"/></w:rPr><w:t xml:space=\"preserve\">" . " " . str_replace('&', '&amp;', $Noteslist[7]) . "</w:t></w:r></w:p>";
         
        }  */
          
         
        $AllMinors=$OsahDb->getMinorDetails($db, $t);  
        $AllMinorsList=explode("++", $AllMinors);
          
        $JudgeFax=$OsahDb->getJudgeFax($db, trim($judgefirstn));
         
        $Faxlast4=substr($JudgeFax, -4);
        
        $Faxsecond3= substr($JudgeFax, 3, 3);
        
        $Faxfirst3= substr($JudgeFax, 0, 3);
        
        $JudgeFax = $Faxfirst3 . "-". $Faxsecond3 . "-" . $Faxlast4;
                
        //$t has the docket number .
        
        /*$file1='c:/iti/tmp/test99.txt';
        $person="\n near mailing list "; 
        file_put_contents($file1, $person, FILE_APPEND); */
        
        $mailinglist=$OsahDb->getMailinglist($db, $t);
        $AllAddress="";
       
        if(isset($typeofcontactidaddr))
        {
            $AllAddress=$OsahDb->getMlistdocs($db, $t, $typeofcontactidaddr);
            //echo'kjgsjgbsjg<pre>'; print_r($AllAddress); exit;
            /*$file1='c:/iti/tmp/test99.txt';
            $person="\n all addresses list. gireesh" . $AllAddress;
            file_put_contents($file1, $person, FILE_APPEND);*/
        }
        $AllAddressList=explode("++", $AllAddress);
       
        $hearingsiteaddr=$OsahDb->getHearingSiteAddr($db, $hearingsite);
        $hearingsite=htmlspecialchars($hearingsite);
         
        //$paragraphs=$OsahDb->getParagraph($db, $refagency );
        unset($arrghearingsiteaddr);
        //$foo = array();
        $arrghearingsiteaddr=explode("+", $hearingsiteaddr);
         
        /*$file1='c:/iti/tmp/test99.txt';
        $person="\n after hearing site " . count($arrghearingsiteaddr);
        file_put_contents($file1, $person, FILE_APPEND);*/
          
        $gcma=$OsahDb->getCma($db, trim($firstn));
        $officerfullname=$OsahDb->getOfficerFullName($db,$caseid);
        $pos=stripos($gcma, "+");
        $gcman=substr($gcma,$pos);
         
        $arrgcma=explode("+", $gcma);
         
         
        //$gcman=substr($gcma,$pos);
         
       /* $file1='c:/iti/tmp/test99.txt';
        $person="\n before signature " . $t;
        file_put_contents($file1, $person, FILE_APPEND);*/
        
        
        
        //CODE NEEDS TO BE WRITTER HERE TO GENERATE MULTIPLE DOCUMENTS. 
        
       
        
        for($sk=1;$sk<=$lenmailerlist;$sk++)
        {       
                    
       //echo '<pre>'; print_r($AllAddressList); exit;
            $AllAddressListcount=count($AllAddressList); //echo  $AllAddressListcount; exit;
            
            if ($sk < $AllAddressListcount)
            {
                    //echo'<pre>'; print_r($lenmailerlist); exit;
            $PHPWord = new PHPWord();
        
        //$filenamepath="C:\mplates\\" . $doclist;
        $filenamepath=$_SERVER['DOCUMENT_ROOT']."/../data/templates/". $doclist; 
        //$sigfile="C:\mplates\sigfile\\" . $judgefilename;
        $sigfile=$_SERVER['DOCUMENT_ROOT']."/../data/templates/sigfile/" . $judgefilename;
        //$filenamepath="C:\mplates\Template.docx";
        //$document = $PHPWord->loadTemplate("C:\mplates\Template.docx");
        $dirname="";
        $document = $PHPWord->loadTemplate($filenamepath);
        //echo "temp" . $filenamepath;
        $filedocname='Noticeofhearing_' . $dirname .  $sk .  ".docx";
        //  $filename = 'C:\mplates\Solarsystem.docx';
        
        $filename = $filedocname;
       /* $file1='c:/iti/tmp/test99.txt';
        $person="\n after signature " . $t;
        file_put_contents($file1, $person, FILE_APPEND);*/
        
        
        $filename = tempnam(sys_get_temp_dir(), 'PHPWord');
        //$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
       
        //$document->setValue('Name',$doclist);
        $document->setValue('Values1', strtoupper($testP));
        $document->setValue('Value12', strtoupper($Respondentfirstname));
         
        //$docketnumber
        $findcaseid=$caseid . "-";
        $Trdocketnumber=str_replace($findcaseid, "",$docketnumber);
        $Trdocketnumberfl=$caseid . "-OSAH-" . $Trdocketnumber;
        $document->setValue('Value2', $Trdocketnumberfl); // Full docket number
        $document->setValue('Value41', $caseid);  // Case id
         
        $document->setValue('Value55', $contactinfo);
        $document->setValue('Value41', $caseid);
         
        //
        $document->setValue('Value29', $mailinglist);
        $daterequested1=date("m-d-Y",strtotime($daterequested));
        $document->setValue('Value71', $daterequested1);
         
        
        $tk=0;
        //for($ji=1; $ji<$AllAddressListcount;$ji++)
        //  {
 //   $sk=1;
    if (isset($AllAddressList[$sk]))
            $document->setValue('Address1', $AllAddressList[$sk]);
        else
            $document->setValue('Address1', "");
        
        $rk=2;
        
        for($k=1;$k<=6;$k++)
        {
            if($k != $sk)
            {

                if (isset($AllAddressList[$k]))
                    $document->setValue('Address' . $rk, $AllAddressList[$k]);
                else
                    $document->setValue('Address' . $rk, ""); 

                    $rk++;
            }
        
        }
        
        
        
        //  Minor names set and birth years.
         
        $Minorcount=1;
         
        if (isset($AllMinorsList[$Minorcount]))
        {
            $document->setValue('Minor1', $AllMinorsList[$Minorcount]);
            $document->setValue('Minoryear1', $AllMinorsList[$Minorcount+1]);
        }
        else
        {
            $document->setValue('Minor1', "");
            $document->setValue('Minoryear', "");
        }
         
        $rk=2;
         
        for($k=1;$k<=8;$k=$k+2)
        {
            if($k != $Minorcount)
            {
        
                if (isset($AllMinorsList[$k]))
                {
                    $document->setValue('Minor' . $rk, $AllMinorsList[$k]);
                    $document->setValue('Minoryear' . $rk, $AllMinorsList[$k+1]);
                }
                else
                {
                    $document->setValue('Minor' . $rk, "");
                    $document->setValue('Minoryear' . $rk, "");
                }
                 
                $rk++;
            }
             
        }
         
                //if (isset($_FILES['file']))
     
    if (isset($arrghearingsiteaddr[1]))
    {
        
        if($arrghearingsiteaddr[1]!="")
        {
    $addr2=$arrghearingsiteaddr[0] . "<w:cr/>" .  $arrghearingsiteaddr[1];
        }
        else 
        {
            $addr2=$arrghearingsiteaddr[0];
        }
    }
    else
    {
    $addr2=$arrghearingsiteaddr[0];
    }
    
    /*$file1='c:/iti/tmp/test1.txt';
    $person="\n before insterting values " . $sql1;
    file_put_contents($file1, $person, FILE_APPEND);*/
    //$newtext = wordwrap($addr2, 5, "\n");
    //$document->setValue('Value11', $agencyrefnumber);
            $document->setValue('Values2',$today);    //  Todays Date
         
        $document->setValue('Value16',$hearingdateup); // $hearingdateup
         
        $document->setValue('Value42',$hearingdateday); // $hearingdate day (number)
         
         
        $document->setValue('Value43',$hearingdatemmyyyy); // $hearingdate month and year
                 
        $judgefullname=str_replace("\'","'",$judgefullname);
    
    
        $document->setValue('Value60',$officerfullname);
        $document->setValue('Value91',$judgefullname);
         
        $label=$testP . "<w:br/>" .  $docketnumber . "<w:br/>" . $county . "<w:tab/><w:tab/> " . $testP . "<w:br/>" .  $docketnumber . "<w:br/>" . $county;
        $document->setValue('Value99',$label);   // Single label
    
        /*  <w:pPr><w:tabs><w:tab w:val="start" pos="2160"/><w:tab w:val="start" pos="5040"/></w:tabs></w:pPr>
        */
        $hearingtimesmallcaps= strtolower($hearingtime);
        $document->setValue('Value5',$hearingtimesmallcaps);   //$hearingtime
         
        $hearingsitesmallcaps= $hearingsite;
        $hearingsitesmallcaps1=$hearingsitesmallcaps;
        $document->setValue('Value6', $hearingsitesmallcaps1);
         
        //$addr2smallcaps=ucwords(strtolower($addr2));
        $addr2smallcaps=$addr2;
                $document->setValue('Value14', $addr2smallcaps);
        //$document->setValue('Value13', $arrghearingsiteaddr[1]);
         
        //  $arrghearingsiteaddrsmallcaps=ucwords(strtolower($arrghearingsiteaddr[2]));
                $arrghearingsiteaddrsmallcaps="";
                if(isset($arrghearingsiteaddr[2]))
                {
                    $arrghearingsiteaddrsmallcaps=$arrghearingsiteaddr[2];
                }
        //$arrghearingsiteaddrsmallcaps=$arrghearingsiteaddr[2];
        $document->setValue('City',$arrghearingsiteaddrsmallcaps );
         
        //  $document->setValue('Value4', $hearingdate);
        //  $document->setValue('Value5', $hearingtime);
        //  $document->setValue('Value6', $hearingsite);
        //$document->setValue('Value5','true3');
         
        //  $document->setValue('Notes12', $Notes);
    
    
        //$document->setValue('Value50','true3');
         
         
        $phonelast4=substr(@$arrgcma[1], -4);
         
        $phonesecond3= substr(@$arrgcma[1], 3, 3);
         
        $phonefirst3= substr(@$arrgcma[1], 0, 3);
         
        $phone = $phonefirst3 . "-". $phonesecond3 . "-" . $phonelast4;
         
         
        //  $JudgeFax
         
    
         
        $document->setValue('Value7', $firstn);  //First Name - Judge Assistant Name
        $document->setValue('Value8', $lasttn);  // Last Name - Judge Assistant Name
                $document->setValue('Value19', $agencyrefnumber);
        $document->setValue('Value11', @$arrgcma[2]); //Email
         
        $document->setValue('Value9', $phone);  //Telephone Address
         
        $document->setValue('Value10', $JudgeFax);  //Fax
        $document->setValue('Value15', $notesstringpar1); // Footer
        $document->setValue('Value25', $notesstringpar2);
         
        $document->replaceStrToImg('Value39', $sigfile);  //Attachement replacement.
        $document->setValue('Value35', $notesstringpar3);
        /*$document->replaceStrToImg('AreaImg', $arrImagenes);
        $documentName = 'Concepto_Tecnico_' . date('Ymd_His') . '.docx';
        $document->save( $documentName);*/
        $document->setValue('ADDRESS2', $JudgeFax);
    
         
        //$tablestr=(string)$table;
                //  $document->setValue('Value15', $tablestr);
    
                //  $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
                //  $objWriter->save('testTable.docx');
                $document->save($filename);
                 
                //  header("Content-disposition: attachment; filename=". $filename . ";");
                $filename12="";
                //$filenamepath = "C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/temp/temp/";
                $filenamepath =   $_SERVER['DOCUMENT_ROOT']."/temp/temp/";
                //echo   $filenamepath; exit;
                //  $filename122 =$caseid. "_Osahdocument". "_".date("Y-m-d_H-is",time()).  ".docx";
                $firtpartfilename=chop($doclist, ".docx");
                $filename122 =$caseid. "_".$firtpartfilename . "_" . date("Y-m-d_H-is",time()).  $sk . ".docx";
    
    
                $filename12=    $filenamepath.$filename122;
                copy($filename, $filename12);
                
                $flder=$flder."\\";
                $Clerkflder1=$Clerkflder . "\\";
               
              //copy($filename12, $flder.$filename122);  //Copy the file in share drive for clerks to send it to vendor.
                //copy($temp_file, $filedir1);
                $bulkdrive=$flder.$filename122;
                $Clerkflder2=$Clerkflder1.$filename122;
                $filename122=str_replace('docx', 'pdf', $filename122);
                //$filedir2=str_replace('docx', 'pdf', $filename12);
                $bulkdrive=str_replace('docx', 'pdf', $bulkdrive);
                $Clerkflder3=str_replace('docx', 'pdf', $Clerkflder2);
               
               // passthru('D:/wamp/www/osahnewloc/data/filewrite/pdf/OfficeToPDF.exe ' . '"' . $filename12 .'" ' . '"' . $bulkdrive .'"');
                passthru($_SERVER['DOCUMENT_ROOT'].'/../data/filewrite/pdf/OfficeToPDF.exe ' . '"' . $filename12 .'" ' . '"' . $bulkdrive .'"');
                
                //echo "Hererere NIrankar"; exit;
                 
            //  passthru('c:/iti/pdf/OfficeToPDF.exe ' . '"' . $filedir1 .'" ' . '"' . $filedir2 .'"');
                //unlink($filename12);
                
               /* $file1='c:/iti/tmp/test1.txt';
                $person="\n documents ".$filename12;
                file_put_contents($file1, $person, FILE_APPEND);*/
                //  readfile($filename);
     
    $sql="/temp/".$filename122;
    
    $documenttypecon="";
   
    
    
        $sql="select * from casetypedocuments where documentname like '%" . $doclist . "%'";
        $resultSet=$OsahDb->getDatabySql($db,$sql);
        /* $statement=$db->createStatement($sql);
        
        $result = $statement->execute(); */
        $arraylist="";
        if (count($resultSet)>0)
        {
            /* $resultSet = new ResultSet;
            $resultSet->initialize($result); */
            //type : 'options', value : 1, text : 'Aaaaa, Aaa'
            $i=0;
            foreach ($resultSet as $row) {
    
                $documenttypecon=$row['documenttype'];
    
            }// end of for loop
    
             
        }//end of if loop
        
    if ($sk==1)
    {
    
    $dirname=$t;
    $doctype1=$documenttypecon;
    $doctype=$documenttypecon;
    $folderdatename=date("Ymdms");
   /* $file1='c:/iti/tmp/test1.txt';
    $person="\n upload path no creation ".$folderdatename;
    file_put_contents($file1, $person, FILE_APPEND);*/
    
    //###################################################  code for creating folder.
    
    //$_SERVER['DOCUMENT_ROOT']."/upload/".$dirname;
    //if (file_exists("C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/upload/".$dirname)) {
    if (file_exists($_SERVER['DOCUMENT_ROOT']."/upload/".$dirname)) {
        $upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/".$dirname. "/"; // where image will be uploaded, relative to this file
        
        $databaseupload_path = "/upload/".$dirname . "/"; // where image will be uploaded, relative to this file
        
        $download_path = $_SERVER['DOCUMENT_ROOT']."/upload/".$dirname . "/"; // same folder as above, but relative to the HTML file
        
        $uploadpath=$_SERVER['DOCUMENT_ROOT']."/upload/".$dirname;
         
       /* $file1='c:/iti/tmp/test1.txt';
        $person="\n upload path no creation ".$upload_path;
        file_put_contents($file1, $person, FILE_APPEND);*/
       
    } else {
        $upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/".$dirname; // where image will be uploaded, relative to this file
        $databaseupload_path ="/upload/".$dirname; 
        $download_path = $_SERVER['DOCUMENT_ROOT']."/upload/".$dirname . "/";
        //$uploadpath="C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/upload/".$dirname;
       /* $file1='c:/iti/tmp/test1.txt';
        $person="\n upload path ".$upload_path;
        file_put_contents($file1, $person, FILE_APPEND);*/
        mkdir($upload_path);
    
        $upload_path=$upload_path . "/";
        $databaseupload_path =$databaseupload_path . "/";
    }
    
    if (file_exists($upload_path.$doctype)) {
    
        $upload_path =$upload_path . $doctype . "/"; // where image will be uploaded, relative to this file
        $databaseupload_path  = $databaseupload_path  . $doctype . "/";
        $download_path = $upload_path .$doctype . "/"; // same folder as above, but relative to the HTML file
        //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname . "/";
    } else {
        $upload_path = $upload_path . $doctype; // where image will be uploaded, relative to this file
        $databaseupload_path  = $databaseupload_path  . $doctype;
        $download_path = $upload_path . $doctype . "/";
        //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname;
        //C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/upload/1bold006
         
        /*$file1='c:/iti/tmp/test1.txt';
        $person="\n upload path docket directory creation ".$upload_path;
        file_put_contents($file1, $person, FILE_APPEND);*/
        mkdir($upload_path,0777);
    
        $upload_path=$upload_path . "/";
        $databaseupload_path  = $databaseupload_path  . "/";
    }
     
    if (file_exists($upload_path.$folderdatename)) {
    
        $upload_path = $upload_path. $folderdatename . "/"; // where image will be uploaded, relative to this file
        
        $databaseupload_path= $databaseupload_path. $folderdatename . "/"; 
        $download_path = $upload_path . $folderdatename . "/"; // same folder as above, but relative to the HTML file
        //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname . "/";
    } else {
        $upload_path = $upload_path . $folderdatename; // where image will be uploaded, relative to this file
        $databaseupload_path=$databaseupload_path . $folderdatename;
        $download_path = $upload_path . $folderdatename . "/";
        //$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname;
        
       /* $file1='c:/iti/tmp/test1.txt';
        $person="\n upload path ".$upload_path;
        file_put_contents($file1, $person, FILE_APPEND);*/
        mkdir($upload_path);
    
        $upload_path=$upload_path . "/";
        $databaseupload_path=$databaseupload_path . "/";
    }
    
    
   //   $doctype1= $this->params()->fromQuery('doctype1');
    $granted12= "";
    $datereq12= date("Y-m-d");
    //$myarea1= $this->params()->fromQuery('myarea1');
    $myarea1= "";
    $filepath12= $upload_path;
    $caseid= $t;
    $filename1= $filename122;
    
    //$filearray=explode("?@?",$filepath12);
    
    $filepath13="";
     $docstabledata= array(
        'Caseid'=>$t,
        'DocumentType'=>$doctype1,'Granted'=>$granted12,'DateRequested'=>$datereq12,'Description'=> $myarea1,'Attachmentfilepaths'=>$filepath13,'DocumentName'=>$filename1,'Docket_caseid'=>$caseid,'doc_file_flage'=>0,'roc_flag'=>0,'casetype_doc_id'=>0,'created_date'=>date('Y-m-d H:i:s'),'modified_date'=>date('Y-m-d H:i:s')
        ); 
      /*   $docstabledata= array(
        'Caseid'=>$t,
        'DocumentType'=>$doctype1,'Granted'=>$granted12,'DateRequested'=>$datereq12,'Description'=> $myarea1,'Attachmentfilepaths'=>$filepath13,'DocumentName'=>$filename1,'Docket_caseid'=>$caseid,'doc_file_flage'=>0
        );*/
    /*$sql= "INSERT INTO `documentstable` (`Caseid`, `DocumentType`, `Granted`, `DateRequested`, `Description`, `Attachmentfilepaths`, `DocumentName`, `Docket_caseid`)
            VALUES ('" . $t . "', '" . $doctype1 . "', '" . $granted12 . "', '" . $datereq12 . "', '" . $myarea1 ."', '" . $filepath13 . "', '" . $filename1 . "', '" . $caseid . "')";
    
    $statement=$db->createStatement($sql);
    $result = $statement->execute();*/

    $last_instered_id = $OsahDb->insertData($db,"documentstable",$docstabledata,1);
    
//echo "hererer Nirankar"; exit; 
     
    /*$sql1="SELECT LAST_INSERT_ID() as new_id";
    $statement1=$db->createStatement($sql1);
    $result1 = $statement1->execute();
    $docket="t";*/
    $docket=$last_instered_id;
    //$t1=$db->lastInsertId();
    //$docket = $db->lastInsertValue;
    /*if ($result1 instanceof ResultInterface && $result1->isQueryResult())
    {
        $resultSet1 = new ResultSet;
        $resultSet1->initialize($result1);
         
        $i=0;
        foreach ($resultSet1 as $row) {
             
            $docket=$row->new_id;
             
            //          $arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
             
        }// end of for loop
        // console.log("i am here... do i");
        //$docket="test";
    }*/
    
    //$len=count($filearray);
 //$fullfilename=$filepath12 .$filename1;
 
    //foreach(tr$filearray as $filenm)
    //{           
    /*$sql2= "INSERT INTO `attachmentpaths` (`documentid`, `attachmentpath`)
            VALUES (" . $docket . ", '" . $databaseupload_path .$filename1 . "')";*/
       $doc_attachment_pathdata= array(
        'documentid'=>$docket,
        'attachmentpath'=>$databaseupload_path .$filename1
        );
        $OsahDb->insertData($db,"attachmentpaths",$doc_attachment_pathdata);

       /* $file1='c:/iti/tmp/test1.txt';
        $person="\n upload path " . $sql2;
        file_put_contents($file1, $person, FILE_APPEND);*/
        
        /*$statement3=$db->createStatement($sql2);
        $result3 = $statement3->execute();*/
   // }
    
   /* $file1='c:/iti/tmp/test1.txt';
    $person="\n copy file from  " . $filename12;
     
    file_put_contents($file1, $person, FILE_APPEND);
    
    $file1='c:/iti/tmp/test1.txt';
    $person="\n to file   " . $filepath12 .$filename1;
     
    file_put_contents($file1, $person, FILE_APPEND);*/
    
        //      Bulkdoc_Folder
    copy($bulkdrive, $filepath12 .$filename1);
     
        //      $Clerkflder
    copy($bulkdrive, $Clerkflder3);
    
    
   //   $flder
   //$moved = move_uploaded_file($filename12, $filepath12 .$filename1);
    
    
    //############################################# code for creating folder ends here.
    
    
    
    }  // if loop... for $sk 
   
            } // if loop... for Addresslist count
    
        }  // end of for loop for mailer list 
    
    

            } // end of for loop    Main Loop
        }  // end of if loop.. Recod Count
    else{
        /*
          If the no record found or empty resulct the this will exicute
         */
        echo 0; exit;
        
    }
     

        //$path = "C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/temp/temp/";
        $path = $_SERVER['DOCUMENT_ROOT']."/temp/temp/";
         if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ((time()-filectime($path.$file)) > 86400) {
                    if (preg_match('/\.docx$/i', $file)) {
                        unlink($path.$file);
                    }
                }
            }
        }
        
        
    //  $document->save($temp_file);
            //  copy($temp_file, $filename);
            //  readfile($temp_file);
            //  unlink($temp_file);
            //  $sql="";
            //$sql="<script> window.close();</script>";
    
            $response = $this->getResponse();
            $response->setStatusCode(200);
        //  $response->setContent(json_encode($data));
            $response->setContent($sql);
             
            $headers = $response->getHeaders();
            $headers->addHeaderLine('Content-Type', 'application/text');
             
            return $response;
  
        echo 1; exit;
  
    }
    
    
    
    public function caseworkerlistaddrAction()
    {
    
    	$db=$this->getServiceLocator()->get('db1');
    	$attrid= $this->params()->fromQuery('attrid');
    	//$casetypeid= $this->params()->fromQuery('casetypeid');
    
    	//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    
    	$sql="SELECT * FROM `agencycaseworkercontact` where `Contactid`= " .  $attrid;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    
    	$lastname="";
    	$firstname="";
    	$middlename="";
    	//	$attorneybar="";
    	$title="";
    	$company="";
    	$address1="";
    	$address2="";
    	$city="";
    	$state="";
    	$zip="";
    	$email="";
    	$phone="";
    	$fax="";
    
    
    
    
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			$lastname=$row->LastName;
    			$firstname=$row->FirstName;
    			$middlename=$row->MiddleName;
    			//	$attorneybar=$row->AttorneyBar;
    			$title=$row->Title;
    			$company=$row->Company;
    			$address1=$row->Address1;
    			$address2=$row->Address2;
    			$city=$row->City;
    			$state=$row->State;
    			$zip=$row->Zip;
    			$email=$row->email;
    			$phone=$row->phone;
    			$fax=$row->fax;
    			$i = $i +1;
    		}// end of for loop
    		 
    		//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    		 
    		 
    	}//end of if loop
    
    	//return $sql;
    
    
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//	$response->setContent($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    	//  $tester=array($JudgeAssistantID, $Judgeid);
    	//$response->setContent($tester);
    
    
    	$post_data = array('lastname' => $lastname,
    			'firstname' => $firstname,
    			'middlename' => $middlename,
    			'title' => $title,
    			'company' => $company,
    			'address1' => $address1,
    			'address2' => $address2,
    			'city' => $city,
    			'state' => $state,
    			'zip' => $zip,
    			'email' => $email,
    			'phone' => $phone);
    
    	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    
    	return $response;
    
    
    
    }
    
    public function ofclistaddrAction()
    {
    	 
    	$db=$this->getServiceLocator()->get('db1');
    	$attrid= $this->params()->fromQuery('attrid');
    	//$casetypeid= $this->params()->fromQuery('casetypeid');
    	 
    	//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    
    	$sql="SELECT * FROM `officerdetails` where `officerrid`= " .  $attrid;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	 
    	$lastname="";
    	$firstname="";
    	$middlename="";
    	$attorneybar="";
    	$title="";
    	$company="";
    	$address1="";
    	$address2="";
    	$city="";
    	$state="";
    	$zip="";
    	$email="";
    	$phone="";
    	$fax="";
    	 
    
    
    
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			$lastname=$row->Lastname;
    			$firstname=$row->Firstname;
    			$middlename=$row->Middlename;
    			//	$attorneybar=$row->AttorneyBar;
    			$title=$row->Title;
    			$company=$row->Company;
    			$address1=$row->Address1;
    			$address2=$row->Address2;
    			$city=$row->City;
    			$state=$row->State;
    			$zip=$row->Zip;
    			$email=$row->Email;
    			$phone=$row->Phone;
    			//	$fax=$row->Fax;
    			$i = $i +1;
    		}// end of for loop
    		 
    		//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    		 
    		 
    	}//end of if loop
    	 
    	//return $sql;
    	 
    	 
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//	$response->setContent($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    	//  $tester=array($JudgeAssistantID, $Judgeid);
    	//$response->setContent($tester);
    	 
    
    	$post_data = array('lastname' => $lastname,
    			'firstname' => $firstname,
    			'middlename' => $middlename,
    			'title' => $title,
    			'company' => $company,
    			'address1' => $address1,
    			'address2' => $address2,
    			'city' => $city,
    			'state' => $state,
    			'zip' => $zip,
    			'email' => $email,
    			'phone' => $phone);
    	 
    	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    	 
    	return $response;
    	 
    	 
    	 
    }
    
    public function attorneylistaddrAction()
    {
    
    	$db=$this->getServiceLocator()->get('db1');
    	$attrid= $this->params()->fromQuery('attrid');
    	//$casetypeid= $this->params()->fromQuery('casetypeid');
    	 
    	//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    	
    	$sql="SELECT * FROM `attorney` where `Attorneyid`= " .  $attrid;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    
    	$lastname="";
    	$firstname="";
    	$middlename="";
    	$attorneybar="";
    	$title="";
    	$company="";
    	$address1="";
    	$address2="";
    	$city="";
    	$state="";
    	$zip="";
    	$email="";
    	$phone="";
    	$fax="";
    	 
    	
    	
    	
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    			
    			$lastname=$row->Lastname;
    			$firstname=$row->Firstname;
    			$middlename=$row->Middlename;
    			$attorneybar=$row->AttorneyBar;
    			$title=$row->Title;
    			$company=$row->Company;
    			$address1=$row->Address1;
    			$address2=$row->Address2;
    			$city=$row->City;
    			$state=$row->State;
    			$zip=$row->Zip;
    			$email=$row->Email;
    			$phone=$row->Phone;
    			$fax=$row->Fax;
    			$i = $i +1;
    		}// end of for loop
    
    		//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    
    
    	}//end of if loop
    
    	//return $sql;
    	 
    	 
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//	$response->setContent($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    	//  $tester=array($JudgeAssistantID, $Judgeid);
    	//$response->setContent($tester);
    		     	
    	
    		$post_data = array('lastname' => $lastname,
    		'firstname' => $firstname,
    		'middlename' => $middlename,    				
    		'attorneybar' => $attorneybar,
    		'title' => $title,
    		'company' => $company,
    		'address1' => $address1,
    		'address2' => $address2,
    		'city' => $city,
    		'state' => $state,
    		'zip' => $zip,
    		'email' => $email,
    		'phone' => $phone,
    		'fax' => $fax);
    	 
    	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    
    	return $response;
    }
    
    //END OF PULL FIELDS FOR ATTORNEY LIST.
    public function testjsonAction()
    {
    
    	$db=$this->getServiceLocator()->get('db1');
    	//$countyid= $this->params()->fromQuery('countyid');
    	$Judgeid="test scussfull";
    	$post_data = array('Judgeid' => $Judgeid);
    	 
    	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    	
    	return $response;
    }
    
    public function judgeMapplingchangecountyAction(){
    	$db=$this->getServiceLocator()->get('db1');
    	$countyid= $this->params()->fromQuery('countyid');
    	$casetypeid= $this->params()->fromQuery('casetypeid');
    	$agencycode= $this->params()->fromQuery('agencyid');
    	$post_data = "";//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    	$OsahDb=New OsahDbFunctions();
    	$agencyid=$OsahDb->getAgencyId($db, $agencycode);
    	$casecode=$OsahDb->getCaseTypeId($db, $agencyid, $casetypeid);
    	$countydesc=$OsahDb->getCountyId($db, $countyid);
    	
    	$post_data = array('Countydesc' => $countydesc, 'Casecode' =>$casecode );
    	
    	
    	//$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    	
    	return $response;
    	 
    }
 public function judgeMapplingAction()
    {
    
    	$db=$this->getServiceLocator()->get('db1');
    	$countyid= $this->params()->fromQuery('countyid');
    	$casetypeid= $this->params()->fromQuery('casetypeid');
    	
    	//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    	$OsahDb=New OsahDbFunctions();
    	$casecode=$OsahDb->getCaseTypeCodeDesc($db,$casetypeid);
    	$countydesc=$OsahDb->getCountyCode($db,$countyid);
    	$hearingdateskipflag=$OsahDb->getHearingdateskip($db, $casetypeid);
    	$sql="SELECT * FROM `judgescountymaping` where `Casetypeid`= " .  $casetypeid . " and `CountyID`= " . $countyid;
    	$statement=$db->createStatement($sql);
     	$result = $statement->execute();
    	$arraylist="";
    	$rawflag=0;
    	$JudgeAssistantID="";
    	$Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";
    	$Hearingdate="";
    	$post_data="";
    	$file1='c:/iti/tmp/test1.txt';
    	$person="\n Export cases".$sql;
    	file_put_contents($file1, $person, FILE_APPEND);
    if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		
    		
    		
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    			$rawflag=1;
    		    $JudgeAssistantID=$row->JudgeAssistantID;
    		    $Judgeid=$row->Judgeid;
    		    $courtlocationid=$row->courtlocationid;
    		    $hearingtime=$row->hearingtime;
    		    $file1='c:/iti/tmp/test1.txt';
    		    $person="\n inside for loop";
    			$i = $i +1;
    		}// end of for loop
    		
    		$file1='c:/iti/tmp/test1.txt';
    		$person="\n inside the query". $JudgeAssistantID;
    		file_put_contents($file1, $person, FILE_APPEND);
    	//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    		
    		if($rawflag != 0)
    		{
   

    	//return $sql;
    	
    	
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    //	$response->setContent($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
  //  $tester=array($JudgeAssistantID, $Judgeid);
    	//$response->setContent($tester);
    	
    	
    	//  HEARIND DATE CODE -  MODULE  BEGIN HERE
    //	SELECT * FROM test.unified_cases where casetypeid=510;
    	$sql3="SELECT * FROM `unified_cases` where `casetypeid`= " .  $casetypeid;
    	$statement3=$db->createStatement($sql3);
    	$result3 = $statement3->execute();
    	  	$casetypegroup1="";
    	if ($result3 instanceof ResultInterface && $result3->isQueryResult())
    	{
    		$resultSet3 = new ResultSet;
    		$resultSet3->initialize($result3);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet3 as $row) {
    			 
    			$casetypegroup[$i]=$row->casetypegroup;    			    	
    			$i = $i +1;
    		}// end of for loop
    		$casetypegroup1= $casetypegroup[0];
    	}//end of if loop
    	
   	$Judgefullname="";
    	$JudgeAssistantfullname="";
    	$Courtlocationname="";
    	
    	// JUDGE NAME CODE 
    	$sql4="SELECT * FROM `judges` where `Judgeid`= " .  $Judgeid;
    	$statement4=$db->createStatement($sql4);
    	$result4 = $statement4->execute();
    	
    	if ($result4 instanceof ResultInterface && $result4->isQueryResult())
    	{
    		$resultSet4 = new ResultSet;
    		$resultSet4->initialize($result4);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet4 as $row) {
    	
    			$Judgefullname=mysql_real_escape_string($row->LastName) . " " . mysql_real_escape_string($row->FirstName);
    			$i = $i +1;
    		}// end of for loop
    		 
    	}//end of if loop
    	   
    	
    	// JUDGE ASSISTANT NAME CODE
    	$sql5="SELECT * FROM `judgeassistant` where `JudgeAssistantID`= " .  $JudgeAssistantID;
    	$statement5=$db->createStatement($sql5);
    	$result5 = $statement5->execute();
    	 
    	if ($result5 instanceof ResultInterface && $result5->isQueryResult())
    	{
    		$resultSet5 = new ResultSet;
    		$resultSet5->initialize($result5);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet5 as $row) {
    			 
    			$JudgeAssistantfullname=mysql_real_escape_string($row->LastName) . " " . mysql_real_escape_string($row->FirstName);
    			$i = $i +1;
    		}// end of for loop
    		 
    	}//end of if loop
    	$file1='c:/iti/tmp/test.txt';
    	$person="\n Judge FULL NAME **** " . $Judgefullname;
    	file_put_contents($file1, $person, FILE_APPEND);
    	// COURT LOCATION NAME
    	$sql6="SELECT * FROM `courtlocations` where `courtlocationid`= " .  $courtlocationid;
    	$statement6=$db->createStatement($sql6);
    	$result6 = $statement6->execute();
    	
    	if ($result6 instanceof ResultInterface && $result6->isQueryResult())
    	{
    		$resultSet6 = new ResultSet;
    		$resultSet6->initialize($result6);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet6 as $row) {
    	
    			$Courtlocationname=mysql_real_escape_string($row->Locationname);
    			$i = $i +1;
    		}// end of for loop
    		 
    	}//end of if loop
    	$file1='c:/iti/tmp/test.txt';
    	$person="\n Judge mapping table";
    	file_put_contents($file1, $person, FILE_APPEND);
    	//SELECT * FROM test.calendarform;
    	
    	//SELECT * FROM test.calendarform where Judge ="malihi Michael" and Judgassistant="Parker Larry" and Hearingsite Like "OSAH%" and Hearingtime="1:00 AM";
    	
    	// COURT LOCATION NAME
    	$i=0;
    	$length = count($casetypegroup);
    	$Calendarid[0]="";
    	$noofcases[0]=0;
    	for($i2=0;$i2 < $length; $i2++)
    	{
    		
    		$casetypegrp=preg_replace( "/\r|\n/", "", $casetypegroup[$i2]);
    		$htime=preg_replace( "/\r|\n/", "", $hearingtime );
    		$sql7="SELECT * FROM calendarform where Judge='" .  $Judgefullname . "' and Hearingtime='" . $htime . "' and judgassistant='" . $JudgeAssistantfullname . "' and hearingsite = '" . $Courtlocationname . "' and Castypegroup like '%" . $casetypegrp . "%'";
    		
    		
    		$person="\n Judge mapping table".$sql7 . $Judgefullname ;
    		file_put_contents($file1, $person, FILE_APPEND);
    		$statement7=$db->createStatement($sql7);
    		$result7= $statement7->execute();
    		
    		if ($result7 instanceof ResultInterface && $result7->isQueryResult())
    		{
    			$resultSet7 = new ResultSet;
    			$resultSet7->initialize($result7);
    			//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    			$i=0;
    			foreach ($resultSet7 as $row) {
    		
    				$Calendarid[$i]=$row->Calendarid;
    				$noofcases[$i]=$row->noofcases;
    				
    				goto ab;
    			//	$i = $i +1;
    			}// end of for loop
    			 
    		}//end of if loop
    		   
    		
    	}
    	//$sql7="SELECT * FROM `calendarform` where `Judge`= '" .  $Judgefullname . "' and `Judgassistant`='" . $JudgeAssistantfullname . "' and `Hearingsite`='" . $Courtlocationname . "' and `Hearingtime`='" . $hearingtime . "' and Castypegroup = '" . $casetypegroup[0] . "'";
    //	$countofcases=0;
    ab:
    	$dateflag=0;
    	$cutoffnoofdays=0;
	do 
	{ 
    		
    		if ($dateflag==0)
    		{
    		//	SELECT * FROM test.cuttoffdate where casetypeid=612;
    			$sql91="SELECT * FROM `cuttoffdate` where `casetypeid`= " .  $casetypeid;
    			 
    			//$sql8="SELECT * FROM `schedule` where `Calendarid`= '" .  $Calendarid . "' and `cutoffdate` > = CURDATE()";
    			 
    			$statement91=$db->createStatement($sql91);
    			$result91= $statement91->execute();
    			 
    			if ($result91 instanceof ResultInterface && $result91->isQueryResult())
    			{
    				$resultSet91 = new ResultSet;
    				$resultSet91->initialize($result91);
    				//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    			//	$i=0;
    				foreach ($resultSet91 as $row) {
    					 
    					$cutoffnoofdays=$row->numberofdays;
    				//	$i = $i +1;
    				}// end of for loop
    				 
    			}//end of if loop
    		/*	$Date = "2010-09-17";
    			echo date('Y-m-d', strtotime($Date. ' + 1 days'));
    			echo date('Y-m-d', strtotime($Date. ' + 2 days'));  */
    			
   			$strdate=date("Y-m-d");
    		$Cutoffdate=date('Y-m-d', strtotime($strdate . ' + ' . $cutoffnoofdays . ' days'));
    		
    		
    		//	$Cutoffdate="2015-05-01";
    		} 
    		else
    		{
    			$Cutoffdate=$Hearingdate;
    		}
    		
    		$dateflag=$dateflag+1;
    		
    	//SELECT MIN(hearingdate) as earliestdate FROM test.schedule where Calendarid=55 and cutoffdate >= CURDATE();
    	
    	$sql8="SELECT MIN(hearingdate) as 'earliestdate12' FROM `schedule` where `Calendarid`= '" .  $Calendarid[0] . "' and `cutoffdate` >='" . $Cutoffdate . "'";
    	
    	$person="\n Judge mapping table".$sql8;
    	file_put_contents($file1, $person, FILE_APPEND);
    	//$sql8="SELECT * FROM `schedule` where `Calendarid`= '" .  $Calendarid . "' and `cutoffdate` > = CURDATE()";
    	
    	$statement8=$db->createStatement($sql8);
    	$result8= $statement8->execute();
    	
    	if ($result8 instanceof ResultInterface && $result8->isQueryResult())
    	{
    		$resultSet8 = new ResultSet;
    		$resultSet8->initialize($result8);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet8 as $row) {
    	
    			$Hearingdate=$row->earliestdate12;
    			$i = $i +1;
    		}// end of for loop
    		 
    	}//end of if loop
    	
   	$sql18="SELECT count(*) as countofcases FROM docket where judge='" .  $Judgefullname . "' and hearingtime='" . $htime . "' and Judgeassistant='" . $JudgeAssistantfullname . "' and Hearingsite='" . $Courtlocationname . "' and casetype = '" . $casecode . "' and county = '" .  mysql_real_escape_string($countydesc) . "' and hearingdate='". $Hearingdate . "'";
    	
    	$statement18=$db->createStatement($sql18);
  	$result18= $statement18->execute();
  	
  
  	
    if ($result18 instanceof ResultInterface && $result18->isQueryResult())
    	{
    		$resultSet18 = new ResultSet;
    		$resultSet18->initialize($result18);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet18 as $row) {
    			 
    			$countofcases=$row->countofcases;
    			$i = $i +1;
    		}// end of for loop
    		 
    	  }//end of if loop 
    	  
    	  $person="\n count of cases ". $noofcases[0] . " count of cases." . $countofcases ;
    	  file_put_contents($file1, $person, FILE_APPEND);
    	  
    	} while(($countofcases > $noofcases[0]) && ($noofcases[0]!=0)); 
    	 
    	
   /*	$sql18="SELECT count(*) as 'countofcases' FROM `docket` where `hearingdate` = '" . $Hearingdate . "' ";
    	
    	//$sql8="SELECT * FROM `schedule` where `Calendarid`= '" .  $Calendarid . "' and `cutoffdate` > = CURDATE()";
    	
    	$statement8=$db->createStatement($sql18);
    	$result8= $statement8->execute();
    	
    	if ($result8 instanceof ResultInterface && $result8->isQueryResult())
    	{
    		$resultSet8 = new ResultSet;
    		$resultSet8->initialize($result8);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet8 as $row) {
    	
    			$Hearingdate=$row->earliestdate12;
    			$i = $i +1;
    		}// end of for loop
    		 
    	}//end of if
    	*/
    	
    	
    	
    	
    	
    	
    	//  HEARIND DATE CODE -  MODULE  ENDS HERE
    	//$casetypegroup1="test";

    	$post_data = array('Judgeid' => $Judgeid,
    			'JudgeAssistantID' => $JudgeAssistantID,
    	    'courtlocationid' => $courtlocationid,
    	    'hearingtime' => $hearingtime,
    			'hearingdateskipflag' => $hearingdateskipflag,
    			'hearingdate' => $Hearingdate);
    //	'hearingdate' => $Hearingdate );
    		}  //$rawflag  loop ending
    		
    		else
    		{
    		
    			$file1='c:/iti/tmp/test1.txt';
    			$person="\n In Else statement";
    			file_put_contents($file1, $person, FILE_APPEND);
    			$post_data=array('Judgeid' => '', 'hearingdateskipflag' => $hearingdateskipflag);
    		}
    	}//end of if loop
    	
    	
    	
    	
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	$post_data = json_encode($post_data);
    	$file1='c:/iti/tmp/test5.txt';
    //	$person="\n post data".$Judgeid. $JudgeAssistantID . $courtlocationid . $hearingtime . $Hearingdate . $hearingdateskipflag;
    	$person="\n post data". $post_data;
    	file_put_contents($file1, $person, FILE_APPEND);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    	$person="\n post data". $response;
    	file_put_contents($file1, $person, FILE_APPEND);
    	$response->setContent($post_data);
    	return $response;
    }
  
 public function calendarRetInfoAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$caseid= $this->params()->fromQuery('caseid');
    	
    	 
    	$sql='SELECT * FROM calendarform where Calendarid=' . $caseid;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	
    	$post_data="";
    	 
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    			
    			if($i == 0)
    			{
    				$post_data = array('Judge' => $row->Judge,
    						'Judgeassistant' => $row->Judgassistant,
    						'Hearingsite' => $row->Hearingsite,
    						'Castypegroup' => $row->Castypegroup,
    						'Hearingtime' => $row->Hearingtime,    						
    						'noofcases'=>$row->noofcases
    						);
    	
    			}
    				
    	
    	
    			$i = $i +1;
    		}// end of for loop
    	
    	}//end of if loop
    	
    	
    	
    	
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	
    	
    	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    	
    	return $response;
    }
    
    public function getdocumentlistInfoAction()
    {

    	$db=$this->getServiceLocator()->get('db1');
    //	$caseid= $this->params()->fromQuery('caseid');
    	$refagency= $this->params()->fromQuery('refagency');
    	$casetype= $this->params()->fromQuery('casetype');
    	//$casetypeid= $this->params()->fromQuery('casetypeid');
    	
    	//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    	
    	//$sql="SELECT * FROM `judgescountymaping` where `Casetypeid`= " .  $casetypeid . " and `CountyID`= " . $countyid;
    	$OsahDb=New OsahDbFunctions();
    	 
    	$sql="SELECT * FROM casetypedocuments where casetype='" . $casetype . "' and agency='" . $refagency . "'";
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	$hearingdateskipflag="";
    	/*$JudgeAssistantID="";
    	 $Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";*/
    	$post_data="";
    	 
    	//$OsahDb
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{ 
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=1000;
    		foreach ($resultSet as $row) {
    	
    			//$caseid11="<a onclick=\'docketinfo(" . $row->caseid . ")\';>" . $row->caseid . "</a>";
    			// /Osahform/newform
    			//$caseid11="<a href=\'/Osahform/newform?docketno=\"" . $row->caseid . "\"\'>" . $row->caseid . "</a>";
    			//$caseid11="";
    		if($i == 1000)
    			{   
    				$post_data=mysql_real_escape_string($row->documentname);
    			}
    		else
    			{
    		  		$post_data=$post_data . "+" . mysql_real_escape_string($row->documentname);
    			
    					
    			
    			}
    				
    	
    	
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		//return $post_data;
    	}//end of if loop
    	
    	//return $sql;
    	
    	
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//	$response->setContent($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    	//  $tester=array($JudgeAssistantID, $Judgeid);
    	//$response->setContent($tester);
    	
    	
    	
    	/*	$post_data = array('Judgeid' => $Judgeid,
    	 'JudgeAssistantID' => $JudgeAssistantID,
    			'courtlocationid' => $courtlocationid,
    			'hearingtime' => $hearingtime);*/
    	
//	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    	
    	return $response;
    }
    public function docketRetInfoAction()
    {
    
    	$db=$this->getServiceLocator()->get('db1');
    	$caseid= $this->params()->fromQuery('caseid');
    	//$casetypeid= $this->params()->fromQuery('casetypeid');
    	 
    	//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    	 
    	//$sql="SELECT * FROM `judgescountymaping` where `Casetypeid`= " .  $casetypeid . " and `CountyID`= " . $countyid;
    	$OsahDb=New OsahDbFunctions();
    	
    	$sql='SELECT * FROM docket where caseid=' . $caseid;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	$hearingdateskipflag="";
    	/*$JudgeAssistantID="";
    	$Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";*/
    	$post_data="";
    	
    	//$OsahDb
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
  				
  				$Agencyid=$OsahDb->getAgencyId($db,$row->refagency);
  				$Casetypeid=$OsahDb->getCaseTypeId($db,$Agencyid,$row->casetype);
  				$Countyid=$OsahDb->getCountyId($db,$row->county);
  				$hearingdateskipflag="";
  				$hearingdateskipflag=$OsahDb->getHearingdateskip($db, $Casetypeid);
  				
  			    $post_data = array('docketnumber' => $row->docketnumber,
  			    		'docketclerk' => $row->docketclerk,
  			    		'hearingreqby' => $row->hearingreqby,
  			    		'status' => $row->status,
  			            'daterequested' => $row->daterequested,
  			    		'datereceivedbyOSAH' => $row->datereceivedbyOSAH,
  			    		'refagency' => $row->refagency,
  			    		'agencyid' => $Agencyid,
  			            'casetype' => $row->casetype,
  			    		'casetypeid' => $Casetypeid,
  			    		'casefiletype' => $row->casefiletype,
  			    		'county' => $row->county,
  			    		'countyid' => $Countyid,  			    		
  			            'agencyrefnumber' => $row->agencyrefnumber,
  			    		'hearingmode' => $row->hearingmode,
  			            'hearingsite' => $row->hearingsite,
  			    		'hearingdate' => $row->hearingdate,
  			    		'hearingtime' => $row->hearingtime,
  			             'judge' => $row->judge,
  			            'judgeassistant' => $row->judgeassistant,
  			    		'hearingdateskipflag' => $hearingdateskipflag,
  			    		'hearingrequesteddate' => $row->hearingrequesteddate,
  			    		'others' => $row->others);
  			    
  			    //$post_data = json_encode($post_data);
  			//    $arraylist="1 : '". $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }" ;
  
  			}
  			
  
  			 
  			$i = $i +1;
  		}// end of for loop
  		//	$arraylist = $arraylist + "]";
  		//return $post_data;
  	}//end of if loop
    
    	//return $sql;
    	 
    	 
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//	$response->setContent($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    	//  $tester=array($JudgeAssistantID, $Judgeid);
    	//$response->setContent($tester);
    	 
    	 
    	 
    /*	$post_data = array('Judgeid' => $Judgeid,
    			'JudgeAssistantID' => $JudgeAssistantID,
    			'courtlocationid' => $courtlocationid,
    			'hearingtime' => $hearingtime);*/
    	 
    	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    
    	return $response;
    }
    

    
    public function dispositionRetInfoAction()
    {
    
    	$db=$this->getServiceLocator()->get('db1');
    	$caseid= $this->params()->fromQuery('caseid');
    	//$casetypeid= $this->params()->fromQuery('casetypeid');
    
    	//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    
    	//$sql="SELECT * FROM `judgescountymaping` where `Casetypeid`= " .  $casetypeid . " and `CountyID`= " . $countyid;
    
    	$sql='SELECT * FROM docketdisposition where caseid=' . $caseid;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    
    	/*$JudgeAssistantID="";
    	 $Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";*/
    	$post_data="";
    
    
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
    				$post_data = array('dispositioncode' => $row->dispositioncode,
    						'dispositiondate' => $row->dispositiondate,
    						'signedbyjudge' => $row->signedbyjudge,
    						'mailedddate' => $row->mailedddate
    				);
    					
    				//$post_data = json_encode($post_data);
    				//    $arraylist="1 : '". $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }" ;
    
    			}
    			 
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		//return $post_data;
    	}//end of if loop
    
    
    	$sql2=" i am the tester";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    
    	 
    	$post_data = json_encode($post_data);
    	$response->setContent($post_data);
    	//$response->setContent($JudgeAssistantID);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    
    	return $response;
    }
    
    
 public function removePeopleDetailsAction()
   {
       
       $db=$this->getServiceLocator()->get('db1');
       $typeofcontact= $this->params()->fromQuery('typeofcontact');
       $partyid= $this->params()->fromQuery('partyid1');
       $sql="";
       if ($typeofcontact == "Minor/children")
       {
           $sql="delete from minordetails where Minorid=". $partyid;
       }
       else if ($typeofcontact == "Respondent" ||  $typeofcontact == "Petitioner" || $typeofcontact == "Others")
       {
           $sql="delete from peopledetails where peopleid=". $partyid;
       }
       
       else if ($typeofcontact == "Agency Attorney" || $typeofcontact == "Other Attorney" || $typeofcontact == "Respondent Attorney" || $typeofcontact == "Petitioner Attorney")
       {
           $sql="delete from attorneybycase where sno=". $partyid;
       }
       
       else if ($typeofcontact == "Officer" || $typeofcontact == "Investigator" || $typeofcontact == "Case Worker" || $typeofcontact == "Hearing Coordinator")
       {
       	$sql="delete from agencycaseworkerbycase where sno=". $partyid;
       }
       
       $statement=$db->createStatement($sql);
       $result = $statement->execute();
       $done="done";
       $response = $this->getResponse();
       $response->setStatusCode(200);
       //  $response->setContent(json_encode($data));
       $response->setContent($sql);
       
       $headers = $response->getHeaders();
       $headers->addHeaderLine('Content-Type', 'application/text');
       
       return $response;
       
   }
     
    public function removeNotesAction()
    {
    	 
    	$db=$this->getServiceLocator()->get('db1');
    	//	$typeofcontact= $this->params()->fromQuery('typeofcontact');
    	$partyid= $this->params()->fromQuery('partyid1');
    	 
    
    	$sql="delete from summarytable where id=". $partyid;
    	 
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$done="done";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($sql);
    	 
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    	 
    	return $response;
    	 
    }
     
     
    public function peopleInfoDetAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$docketno=$this->params()->fromQuery('caseid');
    	 
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	//$sql='SELECT * FROM `docket`';
    	$sql='SELECT * FROM `peopledetails` where `caseid`='.$docketno;
    	// 	$sql='SELECT * FROM docket where caseid='1normal001'';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	$post_data="";
    	$post_data1="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			if($i == 0)
    			{
    				 
    				 
    				$arraylist="{col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "', col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}" ;
    				//id : ". $row->peopleid . ",
    				//	$post_data="'gri1". $i .  "' : " . $arraylist;
    				//$arraylist="tewe";
    			}
    
    			else
    			{
    				$arraylist= $arraylist . ", {col0 : '" . $row->typeofcontact . "', col1 : '" . $row->Firstname . "', col2: '" . $row->Middlename . "', col3: '" . $row->Lastname . "',col9: '" . $row->Phone . "', col10: '" . $row->Email . "', col11: '" . $row->fax . "', col12: '" . $row->mailtoreceive . "," . $row->mailtoreceive1  . "', col13: '" . $row->Company . "', col14: '" . $row->Title . "', col15: '" . $row->Address1 . "', col16: '" . $row->Address2 . "', col17: '" . $row->Address2 . "', col18: '" . $row->State . "', col19: '" . $row->City . "', col20: '" . $row->Zip . "'}";
    				 
    				//$post_data=$post_data . "," . "'gri1" . $i . "' : " . $arraylist;
    			}
    			$i = $i +1;
    		}// end of for loop
    	}//end of if loop
    	 
    	// $post_data1=array($post_data);
    	/*     $post_data = array('Judgeid' => $Judgeid,
    	 'JudgeAssistantID' => $JudgeAssistantID,
    			'courtlocationid' => $courtlocationid,
    			'hearingtime' => $hearingtime); */
    	 
    	//$post_data1 = json_encode($arraylist);
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//  $response->setContent($post_data1);
    	$response->setContent($arraylist);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    }
    
    public function updateTypeofContactAction()
    {
    
       $db=$this->getServiceLocator()->get('db1');
       // $OsahDb=New OsahDbFunctions();
        $partyid2=$this->params()->fromQuery('partyid2');
        
        //$typeofcontact   -- orinianal value. 
        $typeofcontact= $this->params()->fromQuery('typeofcontactoriginal1');
        $typeofcontactoriginal1=$this->params()->fromQuery('typeofcontact');  // Modified value
        $docketnum=$this->params()->fromQuery('docketnum');
        $partyid=0;
   
        
        
        
        //
        
        if ($typeofcontact != "Case Worker" && $typeofcontact != "Hearing Coordinator" && $typeofcontact != "Investigator" && $typeofcontact != "Officer" && $typeofcontact != "Minor/children" && $typeofcontact != "Agency Attorney" && $typeofcontact != "Other Attorney" && $typeofcontact != "Respondent Attorney" && $typeofcontact != "Petitioner Attorney")
        //else if ($typeofcontact == "Respondent" ||  $typeofcontact == "Petitioner" || $typeofcontact == "Others"  || $typeofcontact == "Custodial Parent")
        {

        	if ($typeofcontactoriginal1 != "Case Worker" && $typeofcontactoriginal1 != "Hearing Coordinator" && $typeofcontactoriginal1 != "Investigator" && $typeofcontactoriginal1 != "Officer" && $typeofcontactoriginal1 != "Minor/children" && $typeofcontactoriginal1 != "Agency Attorney" && $typeofcontactoriginal1 != "Other Attorney" && $typeofcontactoriginal1 != "Respondent Attorney" && $typeofcontactoriginal1 != "Petitioner Attorney")
        		//else if ($typeofcontact == "Respondent" ||  $typeofcontact == "Petitioner" || $typeofcontact == "Others"  || $typeofcontact == "Custodial Parent")
        	{
                $sql="update `peopledetails` set  `typeofcontact`  = '" . $typeofcontactoriginal1 . "' where  `peopleid`='".$partyid2 ."'";
            $statement=$db->createStatement($sql);
              $result = $statement->execute();
                $partyid=$partyid2;
        	}
            
        }
        
        else if ($typeofcontact == "Case Worker" || $typeofcontact == "Investigator" || $typeofcontact == "Officer" || $typeofcontact == "Hearing Coordinator")
        {
             
             // NEED TO WORK UPDATING AGENCY DETAILS.
             //
        	if ($typeofcontactoriginal1 == "Case Worker" || $typeofcontactoriginal1 == "Investigator" || $typeofcontactoriginal1 == "Officer" || $typeofcontactoriginal1 == "Hearing Coordinator")
        	{
         	$sql2=" update `agencycaseworkerbycase` set  `typeofcontact`  = '" . $typeofcontactoriginal1 . "' where sno=" . $partyid2;
             // 

            // 
             $statement2=$db->createStatement($sql2);
             $result2 = $statement2->execute();
             
            	$partyid=$partyid2;
        	}
        }        
        else if ($typeofcontact == "Agency Attorney" || $typeofcontact == "Other Attorney" || $typeofcontact == "Respondent Attorney" || $typeofcontact == "Petitioner Attorney")
        {
        	
        	if ($typeofcontactoriginal1 == "Agency Attorney" || $typeofcontactoriginal1 == "Other Attorney" || $typeofcontactoriginal1 == "Respondent Attorney" || $typeofcontactoriginal1 == "Petitioner Attorney")
        	{
            $sql=" update `attorneybycase` set `typeofcontact`  = '" . $typeofcontactoriginal1 ."' where sno=" . $partyid2;
            
            //$sql="update `peopledetails` set  `Lastname`  = '" . $lastname . "', set `Firstname` = '" . $firstname . "', set  `Middlename` = '" . $middlename . "', set `Address1`='" . $address1 ."' , set `Address2`='" . $address2 . "', set `City`='" . $city ."', set `State`='" . $state . "', set `Zip`='" . $zip . "', set `Email` = '" . $emailt . "', set `Phone` = '" . $phonet . "',set `fax` ='" . $faxt . "',set `mailtoreceive`='" . $mailtoreceive  ."',set `mailtoreceive1`= '" . $mailtoreceive1 . "', set `Title`='" . $pttitle . "',set `Company`= '" . $ptcompany ."' where  `Minorid`='".$partyid2 . "'";
            $statement=$db->createStatement($sql);
            $result = $statement->execute();
            $partyid=$partyid2;
        	}
       }
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	//$docket="doneinserting";
    	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($partyid);
    	 
    	//$response->setContent($sql4);
    	
    	 
    	//	$response->setContent($sql);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    	
    	return $response;
    	
    	//return $docket;
    	   
    }
public function insertPeopleDetailsAction()
    {
        
        $db=$this->getServiceLocator()->get('db1');
       // $OsahDb=New OsahDbFunctions();
        $partyid2=$this->params()->fromQuery('partyid2');
        
       
       $firstname=$this->params()->fromQuery('firstname');        
       $middlename=$this->params()->fromQuery('middlename');           
        $lastname=$this->params()->fromQuery('lastname');      
        $address1=$this->params()->fromQuery('address1');        
        $address2=$this->params()->fromQuery('address2');        
        $city= $this->params()->fromQuery('city'); 
        $state= $this->params()->fromQuery('state');
        $zip= $this->params()->fromQuery('zip');
        $typeofcontact= $this->params()->fromQuery('typeofcontact');
        $docketnum=$this->params()->fromQuery('docketnum');
        $partyid=0;
    if ($typeofcontact == "Minor/children")
        {
            
            $docketnum=$this->params()->fromQuery('docketnum');
            $dob=$this->params()->fromQuery('dob');
            
           
            if ( $partyid2== "")
            {
            
            	if ($dob == "" )
            	{
            		  $sql="INSERT INTO `minordetails` (`caseid`, `Lastname`, `Firstname`, `Middlename`, `dobyear`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Docket_caseid`) VALUES (" . $docketnum . ", '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', null , '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', " . $docketnum . ")";
            	}
            	else
            	{
            		$sql="INSERT INTO `minordetails` (`caseid`, `Lastname`, `Firstname`, `Middlename`, `dobyear`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Docket_caseid`) VALUES (" . $docketnum . ", '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $dob . "', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', " . $docketnum . ")";
            	}
          
            
            $statement=$db->createStatement($sql);
            $result = $statement->execute();
            
            
            $sql1="SELECT LAST_INSERT_ID() as new_id";
            
            $statement1=$db->createStatement($sql1);
            $result1 = $statement1->execute();
            $attorneyid="test";
            //$t1=$db->lastInsertId();
            //$docket = $db->lastInsertValue;
            if ($result1 instanceof ResultInterface && $result1->isQueryResult())
            {
            	$resultSet1 = new ResultSet;
            	$resultSet1->initialize($result1);
            
            	$i=0;
            	foreach ($resultSet1 as $row) {
            		$minorid=$row->new_id;
            	}
            }
            $partyid=$minorid;
           }

           else {
               
           if ($dob == "" )
           	{
           		$sql="UPDATE `minordetails` set `Lastname`  = '" . $lastname . "', `Firstname` = '" . $firstname . "',  `Middlename` = '" . $middlename . "', `dob` = null,  `Address1` ='" . $address1 ."' ,  `Address2`='" . $address2 . "',  `City`='" . $city ."', `State`='" . $state . "', `Zip`='" . $zip .  "' where  `Minorid`='".$partyid2 . "'"; "', " . $docketnum . ")";
           	}
           	else
           	{
           		$sql="UPDATE `minordetails` set `Lastname`  = '" . $lastname . "', `Firstname` = '" . $firstname . "',  `Middlename` = '" . $middlename . "', `dobyear` = '" . $dob . "',  `Address1` ='" . $address1 ."' ,  `Address2`='" . $address2 . "',  `City`='" . $city ."', `State`='" . $state . "', `Zip`='" . $zip .  "' where  `Minorid`='".$partyid2 . "'";
           	}

           	$statement=$db->createStatement($sql);
               $result = $statement->execute();
               $partyid=$partyid2;
           }
               
            
        }
        
        //
        
        else if ($typeofcontact != "Case Worker" && $typeofcontact != "Hearing Coordinator" && $typeofcontact != "Investigator" && $typeofcontact != "Officer" && $typeofcontact != "Minor/children" && $typeofcontact != "Agency Attorney" && $typeofcontact != "Other Attorney" && $typeofcontact != "Respondent Attorney" && $typeofcontact != "Petitioner Attorney")
        //else if ($typeofcontact == "Respondent" ||  $typeofcontact == "Petitioner" || $typeofcontact == "Others"  || $typeofcontact == "Custodial Parent")
        {
            $phonet=$this->params()->fromQuery('phonet');
            $emailt=$this->params()->fromQuery('emailt');
            $faxt=  $this->params()->fromQuery('faxt');
            $ptcompany=$this->params()->fromQuery('ptcompany');
            $pttitle=$this->params()->fromQuery('pttitle');            
            $mailtoreceive=$this->params()->fromQuery('mailtoreceive');
            $mailtoreceive1=$this->params()->fromQuery('mailtoreceive1');
           
            if ( $partyid2== "")
            {
            
                  
            //$sql="INSERT INTO `docket` (`docketnumber`, `docketclerk`, `hearingreqby`, `status`, `daterequested`, `datereceivedbyOSAH`, `refagency`, `casetype`, `casefiletype`, `county`, `agencyrefnumber`, `hearingmode`, `hearingsite`, `hearingdate`, `hearingtime`, `judge`, `judgeassistant`, `hearingrequesteddate`, `others`) VALUES ('2222', 'gkambala','". $hearingreqby ."', 'new','".  $daterequested . "','" . $datereceivedbyosah. "','" . $refagency. "','" . $casetype. "', '','" . $county. "','" . '2323232'. "','" . $hearingmode. "','" . $hearingsite. "','" . $hearingdate. "','" . $hearingtime. "','" . $judge. "','" . $judgeassistant. "','" . $hearingreqdate. "','" . $others. "')";
            $sql=" INSERT INTO `peopledetails` (`typeofcontact`, `caseid`, `Lastname`, `Firstname`, `Middlename`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Phone`, `Docket_caseid`, `fax`, `mailtoreceive`,`mailtoreceive1`,`Title`,`Company`  ) VALUES ('" . $typeofcontact . "', '". $docketnum . "', '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $phonet . "', '" . $docketnum . "', '" . $faxt . "', '" . $mailtoreceive  ."', '" . $mailtoreceive1 . "', '" . $ptcompany ."', '" . $pttitle . "')";
            $statement=$db->createStatement($sql);
            $result = $statement->execute();
            
            
            $sql1="SELECT LAST_INSERT_ID() as new_id";
            
            $statement1=$db->createStatement($sql1);
            $result1 = $statement1->execute();
            $attorneyid="test";
            //$t1=$db->lastInsertId();
            //$docket = $db->lastInsertValue;
            if ($result1 instanceof ResultInterface && $result1->isQueryResult())
            {
            	$resultSet1 = new ResultSet;
            	$resultSet1->initialize($result1);
            
            	$i=0;
            	foreach ($resultSet1 as $row) {
            		$peopleid=$row->new_id;
            	}
            }
          $partyid=$peopleid;          
            }
            
            else {
               // $sql=" INSERT INTO `peopledetails` (`typeofcontact`, `caseid`, `Lastname`, `Firstname`, `Middlename`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Phone`, `Docket_caseid`, `fax`, `mailtoreceive`,`mailtoreceive1`,`Title`,`Company`  ) VALUES ('" . $typeofcontact . "', '". $docketnum . "', '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $phonet . "', '" . $docketnum . "', '" . $faxt . "', '" . $mailtoreceive  ."', '" . $mailtoreceive1 . "', '" . $ptcompany ."', '" . $pttitle . "')";
                //NEED TO WORK ON THIS. PLEASE COMPLETE THIS.
                $sql="update `peopledetails` set  `Lastname`  = '" . $lastname . "', `Firstname` = '" . $firstname . "',  `Middlename` = '" . $middlename . "',  `Address1`='" . $address1 ."' ,  `Address2`='" . $address2 . "', `City`='" . $city ."', `State`='" . $state . "', `Zip`='" . $zip . "', `Email` = '" . $emailt . "', `Phone` = '" . $phonet . "', `fax` ='" . $faxt . "', `mailtoreceive`='" . $mailtoreceive  ."', `mailtoreceive1`= '" . $mailtoreceive1 . "', `Title`='" . $pttitle . "', `Company`= '" . $ptcompany ."' where  `peopleid`='".$partyid2 ."'";
            $statement=$db->createStatement($sql);
              $result = $statement->execute();
                $partyid=$partyid2;
            }
            
            
        }
        
        else if ($typeofcontact == "Case Worker" || $typeofcontact == "Investigator" || $typeofcontact == "Officer" || $typeofcontact == "Hearing Coordinator")
        {
            $phonet=$this->params()->fromQuery('phonet');
            $emailt=$this->params()->fromQuery('emailt');
            $county=$this->params()->fromQuery('county');
            $refagency=$this->params()->fromQuery('refagency');
            $faxt=$this->params()->fromQuery('faxt');
            $ptcompany=$this->params()->fromQuery('ptcompany');
            $pttitle=$this->params()->fromQuery('pttitle');
            $mailtoreceive=$this->params()->fromQuery('mailtoreceive');
            $mailtoreceive1=$this->params()->fromQuery('mailtoreceive1');
            $attrflag=$this->params()->fromQuery('attrflag');
          if ( $partyid2== "")
            {           
            
            	//$sql="INSERT INTO `docket` (`docketnumber`, `docketclerk`, `hearingreqby`, `status`, `daterequested`, `datereceivedbyOSAH`, `refagency`, `casetype`, `casefiletype`, `county`, `agencyrefnumber`, `hearingmode`, `hearingsite`, `hearingdate`, `hearingtime`, `judge`, `judgeassistant`, `hearingrequesteddate`, `others`) VALUES ('2222', 'gkambala','". $hearingreqby ."', 'new','".  $daterequested . "','" . $datereceivedbyosah. "','" . $refagency. "','" . $casetype. "', '','" . $county. "','" . '2323232'. "','" . $hearingmode. "','" . $hearingsite. "','" . $hearingdate. "','" . $hearingtime. "','" . $judge. "','" . $judgeassistant. "','" . $hearingreqdate. "','" . $others. "')";
            	//$sql=" INSERT INTO `peopledetails` (`typeofcontact`, `caseid`, `Lastname`, `Firstname`, `Middlename`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Phone`, `Docket_caseid`, `fax`, `mailtoreceive`,`mailtoreceive1`,`Title`,`Company`  ) VALUES ('" . $typeofcontact . "', '". $docketnum . "', '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $phonet . "', '" . $docketnum . "', '" . $faxt . "', '" . $mailtoreceive  ."', '" . $mailtoreceive1 . "', '" . $ptcompany ."', '" . $pttitle . "')";
        //    	$sql="INSERT INTO `agencylocations` (`AgencyID`, `CountyID`, `Mailaddress1`, `Mailaddress2`, `Streetaddress1`, `Streetaddress2`, `Officecity`, `Officezip`, `Officephone`, `Officefax`, `Agency_AgencyID`, `County_CountyID`) VALUES ('" . $refagency . "', '". $county . "','" . $address1 ."', '" . $address2 . "', '" . $address1 ."', '" . $address2 . "', '" . $city  . "', '" . $zip . "', '" . $phonet . "','" . $faxt . "', '" . $refagency . "', '". $county . "')";
            	if ($attrflag=="0")
            	{
            	if ($typeofcontact != "Officer")
            	{
            	$sql=" INSERT INTO `agencycaseworkercontact` (`Lastname`, `Firstname`, `Middlename`, `Title`, `Company`, `Address1`, `Address2`, `City`, `State`, `Zip`, `email`, `fax`, `phone`) VALUES ('" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $pttitle ."','" . $ptcompany ."', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $faxt . "', '" . $phonet . "')";
            	//$sql="INSERT INTO `agencylocations` (`AgencyID`, `CountyID`, `Mailaddress1`, `Mailaddress2`, `Streetaddress1`, `Streetaddress2`, `Officecity`, `Officezip`, `Officephone`, `Officefax`, `Agency_AgencyID`, `County_CountyID`) VALUES ('" . $refagency . "', '". $county . "','" . $address1 ."', '" . $address2 . "', '" . $address1 ."', '" . $address2 . "', '" . $city  . "', '" . $zip . "', '" . $phonet . "','" . $faxt . "', '" . $refagency . "', '". $county . "')";
            	}
            	else 
            	{
            		
            		$sql=" INSERT INTO `officerdetails` (`Lastname`, `Firstname`, `Middlename`, `Title`, `Company`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `fax`, `Phone`) VALUES ('" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $pttitle ."','" . $ptcompany ."', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $faxt . "', '" . $phonet . "')";
            	}
            	
            	$statement=$db->createStatement($sql);
                $result = $statement->execute();
            
            
            	$sql1="SELECT LAST_INSERT_ID() as new_id";
            
            	$statement1=$db->createStatement($sql1);
                $result1 = $statement1->execute();
            
            	//$t1=$db->lastInsertId();
            	//$docket = $db->lastInsertValue;
             	$locationid="";
            	if ($result1 instanceof ResultInterface && $result1->isQueryResult())
            	{
            		$resultSet1 = new ResultSet;
            		$resultSet1->initialize($result1);
            
            		$i=0;
            		foreach ($resultSet1 as $row) {
            			$locationid=$row->new_id;
            		}
            	  }
            		
            //	$locationid=2;  //need to comment this
            	}
            	else
            	{
            		$locationid=$attrflag;
            	}
            	
            	$partyid=$locationid;
            
          
             /* 	$sql2= "INSERT INTO `agencycaseworkercontact` (`OfficeLocationID`, `Title`, `FirstName`, `LastName`, `MiddleName`, `phone`, `email`, `fax`, `Agencylocations_OfficeLocationID`) VALUES ('" . $locationid . "', '". $pttitle . "','" . $firstname ."', '" . $lastname . "', '" . $middlename . "', '" . $phonet . "','" . $emailt . "', '" . $faxt . "', '". $locationid . "')";
            	$statement2=$db->createStatement($sql2);
            	$result2 = $statement2->execute();
            	
            
            	$sql3="SELECT LAST_INSERT_ID() as new_id1";
            	
            	$statement3=$db->createStatement($sql3);
          	$result3 = $statement3->execute();
            	
            	//$t1=$db->lastInsertId();
            	//$docket = $db->lastInsertValue;
            	$contactid1="";
            	if ($result3 instanceof ResultInterface && $result3->isQueryResult())
            	{
            		$resultSet3 = new ResultSet;
            		$resultSet3->initialize($result3);
            	
            		$i=0;
            		foreach ($resultSet3 as $row1) {
            			$contactid1=$row1->new_id1;
            		}
            		
            		//$partyid=$contactid1;
            	}
            	
            	
            	
            	
            	
            //	$sql4= "INSERT INTO `test`.`agencycaseworkercontact` (`OfficeLocationID`, `Title`, `FirstName`, `LastName`, `MiddleName`, `phone`, `email`, `fax`, `Agencylocations_OfficeLocationID`) VALUES ('" . $locationid . "', '". $pttitle . "','" . $firstname ."', '" . $lastname . "', '" . $middlename . "', '" . $phonet . "','" . $phonet . "', '" . $faxt . "', '". $locationid . "')";
             */
            	
            	$sql4= "INSERT INTO `agencycaseworkerbycase` (`caseid`, `typeofcontact`,`contactid`,`Docket_caseid`,`mailtoreceive`,`mailtoreceive1`, `Lastname`, `Firstname`, `Middlename`, `Title`, `Company`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Fax`, `Phone`) VALUES
        (" . $docketnum . ", '". $typeofcontact . "', " . $locationid . ", " . $docketnum . ",'" . $mailtoreceive  ."','" . $mailtoreceive1  ."', '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $pttitle ."','" . $ptcompany ."', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $faxt . "', '" . $phonet . "')";
            	 
            	
          //  $sql4= "INSERT INTO `agencycaseworkerbycase` (`caseid`, `typeofcontact`,`contactid`,`Docket_caseid`,`AgencycaseworkerContact_Contactid`) VALUES (" . $docketnum . ", '". $typeofcontact . "', " . $contactid1 . ", " . $docketnum . "," . $contactid1  ." )";
            	 
         	$statement4=$db->createStatement($sql4);
        	   $result4 = $statement4->execute();
            	            	
        	   
        	   $sql5="SELECT LAST_INSERT_ID() as new_id2";
        	    
        	   $statement5=$db->createStatement($sql5);
        	   $result5 = $statement5->execute();
        	   $contactid1="";
        	   if ($result5 instanceof ResultInterface && $result5->isQueryResult())
        	   {
        	   	$resultSet5 = new ResultSet;
        	   	$resultSet5->initialize($result5);
        	   	 
        	   	$i=0;
        	   	foreach ($resultSet5 as $row1) {
        	   		$attorneybycaseid=$row1->new_id2;
        	   	}
        	   
        	   	$partyid=$attorneybycaseid;
        	   }
        	   
            }
            
         else
         {
             
             // NEED TO WORK UPDATING AGENCY DETAILS.
             //
             
         	$sql2=" update `agencycaseworkerbycase` set  `Lastname`  = '" . $lastname . "', `Firstname` = '" . $firstname . "',  `Middlename` = '" . $middlename . "',  `Address1`='" . $address1 ."' ,  `Address2`='" . $address2 . "',  `City`='" . $city ."', `State`='" . $state . "',  `Zip`='" . $zip . "',  `Email` = '" . $emailt . "', `Phone` = '" . $phonet . "', `fax` ='" . $faxt . "', `Title`='" . $pttitle . "', `Company`= '" . $ptcompany ."' where sno=" . $partyid2 . " AND caseid = " . $docketnum . "";
             //$sql2= "UPDATE `agencycaseworkercontact` set `Title` = '" . $pttitle . "', `FirstName` = '". $firstname . "', `LastName` = '" . $lastname ."', `MiddleName` = '". $middlename . "', `phone` = '" . $phonet . "', `email` = '". $emailt ."', `fax` = '" .  $faxt ."' where `Contactid`= " . $partyid2 . ""; 

            //     VALUES ('" . $locationid . "', '". $pttitle . "','" . $firstname ."', '" . $lastname . "', '" . $middlename . "', '" . $phonet . "','" . $phonet . "', '" . $faxt . "', '". $locationid . "')";
             $statement2=$db->createStatement($sql2);
             $result2 = $statement2->execute();
             
             
             
            	// $sql=" INSERT INTO `peopledetails` (`typeofcontact`, `caseid`, `Lastname`, `Firstname`, `Middlename`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Phone`, `Docket_caseid`, `fax`, `mailtoreceive`,`mailtoreceive1`,`Title`,`Company`  ) VALUES ('" . $typeofcontact . "', '". $docketnum . "', '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $phonet . "', '" . $docketnum . "', '" . $faxt . "', '" . $mailtoreceive  ."', '" . $mailtoreceive1 . "', '" . $ptcompany ."', '" . $pttitle . "')";
            	//NEED TO WORK ON THIS. PLEASE COMPLETE THIS.
           // 	$sql="update `peopledetails` set  `Lastname`  = '" . $lastname . "', `Firstname` = '" . $firstname . "',  `Middlename` = '" . $middlename . "',  `Address1`='" . $address1 ."' ,  `Address2`='" . $address2 . "', `City`='" . $city ."', `State`='" . $state . "', `Zip`='" . $zip . "', `Email` = '" . $emailt . "', `Phone` = '" . $phonet . "', `fax` ='" . $faxt . "', `mailtoreceive`='" . $mailtoreceive  ."', `mailtoreceive1`= '" . $mailtoreceive1 . "', `Title`='" . $pttitle . "', `Company`= '" . $ptcompany ."' where  `peopleid`='".$partyid2 ."'";
            	//   $statement=$db->createStatement($sql);
            	//   $result = $statement->execute();
            	$partyid=$partyid2;
            }
           
            
        //    $sql="done";
            
        }        
        else if ($typeofcontact == "Agency Attorney" || $typeofcontact == "Other Attorney" || $typeofcontact == "Respondent Attorney" || $typeofcontact == "Petitioner Attorney")
        {

            $phonet=$this->params()->fromQuery('phonet');
            $emailt=$this->params()->fromQuery('emailt');
            $faxt=  $this->params()->fromQuery('faxt');
            $ptcompany=$this->params()->fromQuery('ptcompany');
            $pttitle=$this->params()->fromQuery('pttitle');
            $attrattorneybarno=$this->params()->fromQuery('attrattorneybarno');
            $mailtoreceive=$this->params()->fromQuery('mailtoreceive');
            $mailtoreceive1=$this->params()->fromQuery('mailtoreceive1');
            $attrflag=$this->params()->fromQuery('attrflag');
            
            if ( $partyid2== "")
            {
            
            
            //INSERT INTO `test`.`attorney` (`Lastname`, `Firstname`, `Middlename`, `AttorneyBar`, `Title`, `Company`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Fax`)
            
            	if($attrflag =="0")
            	{
            $sql=" INSERT INTO `attorney` (`Lastname`, `Firstname`, `Middlename`, `AttorneyBar`, `Title`, `Company`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Fax`, `Phone`) VALUES ('" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $attrattorneybarno . "', '" . $pttitle ."','" . $ptcompany ."', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $faxt . "', '" . $phonet . "')";
            	
            $statement=$db->createStatement($sql);
            $result = $statement->execute();
            
            $sql1="SELECT LAST_INSERT_ID() as new_id";
            
            $statement1=$db->createStatement($sql1);
            $result1 = $statement1->execute();
            $attorneyid="test";
            //$t1=$db->lastInsertId();
            //$docket = $db->lastInsertValue;
            if ($result1 instanceof ResultInterface && $result1->isQueryResult())
            {
            	$resultSet1 = new ResultSet;
            	$resultSet1->initialize($result1);
            
            	$i=0;
            	foreach ($resultSet1 as $row) {
            		$attorneyid=$row->new_id;	
            	}
            }
         }  
          else
          {
          	$attorneyid=$attrflag;
          //}//Attorney flag code ends here. 
          }
            $partyid = $attorneyid;
            
            $sql2= "INSERT INTO `attorneybycase` (`caseid`, `typeofcontact`,`attorneyid`,`Docket_caseid`,`mailtoreceive`,`mailtoreceive1`, `Lastname`, `Firstname`, `Middlename`, `AttorneyBar`, `Title`, `Company`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Fax`, `Phone`) VALUES
        (" . $docketnum . ", '". $typeofcontact . "', " . $attorneyid . ", " . $docketnum . ",'" . $mailtoreceive  ."','" . $mailtoreceive1  ."', '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $attrattorneybarno . "', '" . $pttitle ."','" . $ptcompany ."', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $faxt . "', '" . $phonet . "')";
             
          $statement2=$db->createStatement($sql2);
            $result2 = $statement2->execute();
            
                        
            $sql5="SELECT LAST_INSERT_ID() as new_id2";
             
            $statement5=$db->createStatement($sql5);
            $result5 = $statement5->execute();
           // $contactid1="";
            if ($result5 instanceof ResultInterface && $result5->isQueryResult())
            {
            	$resultSet5 = new ResultSet;
            	$resultSet5->initialize($result5);
            
            	$i=0;
            	foreach ($resultSet5 as $row1) {
            		$attorneybycaseid=$row1->new_id2;
            	}
            
            	$partyid=$attorneybycaseid;
            }
           
             
            }
            else
            {
                
            $sql=" update `attorneybycase` set  `Lastname`  = '" . $lastname . "', `Firstname` = '" . $firstname . "',  `Middlename` = '" . $middlename . "',  `Address1`='" . $address1 ."' ,  `Address2`='" . $address2 . "',  `City`='" . $city ."', `State`='" . $state . "',  `Zip`='" . $zip . "',  `Email` = '" . $emailt . "', `Phone` = '" . $phonet . "', `fax` ='" . $faxt . "', `Title`='" . $pttitle . "', `Company`= '" . $ptcompany ."',  `AttorneyBar` = '" . $attrattorneybarno . "' where sno=" . $partyid2 . " AND caseid = " . $docketnum . "";
            
            //$sql="update `peopledetails` set  `Lastname`  = '" . $lastname . "', set `Firstname` = '" . $firstname . "', set  `Middlename` = '" . $middlename . "', set `Address1`='" . $address1 ."' , set `Address2`='" . $address2 . "', set `City`='" . $city ."', set `State`='" . $state . "', set `Zip`='" . $zip . "', set `Email` = '" . $emailt . "', set `Phone` = '" . $phonet . "',set `fax` ='" . $faxt . "',set `mailtoreceive`='" . $mailtoreceive  ."',set `mailtoreceive1`= '" . $mailtoreceive1 . "', set `Title`='" . $pttitle . "',set `Company`= '" . $ptcompany ."' where  `Minorid`='".$partyid2 . "'";
            $statement=$db->createStatement($sql);
            $result = $statement->execute();
            $partyid=$partyid2;
            

            }
                 
                
        }    
        
   
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
        //$docket="doneinserting";
    	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
   	  
	    $response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($partyid);
    	
	//$response->setContent($sql4);
    	
    	
    //	$response->setContent($sql);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');   
    	 
        return $response;
    
        //return $docket;   	 
    	
    }
    
    public function insertCalendarHistoryAction()
    {
    	 
    	$sql="";
    	$db=$this->getServiceLocator()->get('db1');
    
    	$summary= $this->params()->fromQuery('description');
    	$username= $this->params()->fromQuery('username');
    	$datereq12= $this->params()->fromQuery('datereq12');
    	$caseid= $this->params()->fromQuery('caseid');
    	$sql= "INSERT INTO `calendarhistory` (`Date`, `Description`, `Modifiedby`, `Calendarid`) VALUES ('" . $datereq12 . "', '" . $summary . "', '" . $username . "', " . $caseid .")";
    
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    
    
    	 
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//$response->setContent($docket);
    	$response->setContent($sql);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    	 
    }
    
    
    
    public function removeCaledarEntryAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$partyid= $this->params()->fromQuery('partyid1');
    
    	 
    	$sql="delete from schedule where idSchedule=". $partyid;
    
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$done="done";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($sql);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    }
    
    public function selectcaseworkerValuesAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$partyid= $this->params()->fromQuery('keypressvalue');
    	$partyidval=$partyid . "%";
    	//where Lastname like 'M%' or Firstname like 'W%'
    	//$sql='SELECT * FROM `attorney`  ORDER BY Lastname ASC';
    	$sql="SELECT * FROM `agencycaseworkercontact` where LastName like '". $partyidval."' or FirstName like '" . $partyidval . "' ORDER BY LastName ASC";
    	//$sql="SELECT * FROM `attorney` ORDER BY Lastname DESC";
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
    			$concat=$row->LastName . ", " . $row->FirstName . "  -  " . $row->Address1 ;
    			if($i == 0)
    			{
    					
    				$arraylist="{id:".$row->Contactid .", name : '". $concat . "'}+" ;
    					
    			}
    			else
    			{
    				$arraylist=$arraylist."{id :".$row->Contactid .", name : '". $concat . "'}+" ;
    					
    			}
    
    			$i = $i +1;
    		}// end of for loop
    		 
    		//	return $arraylist;
    	}//end of if loop
    
    	$done="done";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($arraylist);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    }
    
    public function selectOfcValuesAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$partyid= $this->params()->fromQuery('keypressvalue');
    	$partyidval=$partyid . "%";
    	//where Lastname like 'M%' or Firstname like 'W%'
    	//$sql='SELECT * FROM `attorney`  ORDER BY Lastname ASC';
    	$sql="SELECT * FROM `officerdetails` where Lastname like '". $partyidval."' or Firstname like '" . $partyidval . "' ORDER BY Lastname ASC";
    	//$sql="SELECT * FROM `attorney` ORDER BY Lastname DESC";
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
    					
    				$arraylist="{id:".$row->officerrid .", name : '". $concat . "'}+" ;
    					
    			}
    			else
    			{
    				$arraylist=$arraylist."{id :".$row->officerrid .", name : '". $concat . "'}+" ;
    					
    			}
    
    			$i = $i +1;
    		}// end of for loop
    		 
    		//	return $arraylist;
    	}//end of if loop
    
    	$done="done";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($arraylist);
    	 
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    	 
    	return $response;
    }
    public function selectAttrValuesAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$partyid= $this->params()->fromQuery('keypressvalue');
    	$partyidval=$partyid . "%";
    	//where Lastname like 'M%' or Firstname like 'W%'
    	//$sql='SELECT * FROM `attorney`  ORDER BY Lastname ASC';
    	$sql="SELECT * FROM `attorney` where Lastname like '". $partyidval."' or Firstname like '" . $partyidval . "' ORDER BY Lastname ASC";
    	//$sql="SELECT * FROM `attorney` ORDER BY Lastname DESC";
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
    				 
    				$arraylist="{id:".$row->Attorneyid .", name : '". $concat . "'}+" ;
    				 
    			}
    			else
    			{
    				$arraylist=$arraylist."{id :".$row->Attorneyid .", name : '". $concat . "'}+" ;
    				 
    			}
    			 
    			$i = $i +1;
    		}// end of for loop
    		 
    		//	return $arraylist;
    	}//end of if loop
    	 
    	$done="done";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($arraylist);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    }
    
    
    
    
    
    
    
    public function insertHistoryAction()
    {
    	 
    	$sql="";
    	$db=$this->getServiceLocator()->get('db1');
    	 
    $summary= mysql_real_escape_string($this->params()->fromQuery('description'));
    	$username= mysql_real_escape_string($this->params()->fromQuery('username'));
    	$datereq12= $this->params()->fromQuery('datereq12');
    	$caseid= $this->params()->fromQuery('caseid');
    	$sql= "INSERT INTO `history` (`caseid`, `date`, `Description`, `Modifiedby`, `Docket_caseid`) VALUES (" . $caseid . ", '" . $datereq12 . "', '" . $summary . "', '" . $username . "', " . $caseid .")";
    	 
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	 
    	 
    
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//$response->setContent($docket);
    	$response->setContent($sql);
    	 
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    	 
    	return $response;
    
    }
    
    
    public function insertsummaryAction()
    {
		/* description: summary,
    	 username: username1,
    	datereq12: datetime,
    	caseid: dojo.byId('docketnum12').value  */
    	$sql="";
    	$db=$this->getServiceLocator()->get('db1');
    
    	$summary= $this->params()->fromQuery('description');
    	$username= $this->params()->fromQuery('username');
    	$datereq12= $this->params()->fromQuery('datereq12');
    	$caseid= $this->params()->fromQuery('caseid');
    	$sql= "INSERT INTO `summarytable` (`caseid`, `date`, `summarynotes`, `updatedby`, `Docket_caseid`) VALUES (" . $caseid . ", '" . $datereq12 . "', '" . $summary . "', '" . $username . "', " . $caseid .")";
    
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    
    
    
    	$sql1="SELECT LAST_INSERT_ID() as new_id";
    
    	$statement1=$db->createStatement($sql1);
    	$result1 = $statement1->execute();
    	$attorneyid="test";
    	//$t1=$db->lastInsertId();
    	//$docket = $db->lastInsertValue;
    	if ($result1 instanceof ResultInterface && $result1->isQueryResult())
    	{
    		$resultSet1 = new ResultSet;
    		$resultSet1->initialize($result1);
    
    		$i=0;
    		foreach ($resultSet1 as $row) {
    			$attorneyid=$row->new_id;
    		}
    	}
    
    	$partyid = $attorneyid;
    
    
    	 
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//$response->setContent($docket);
    	$response->setContent($partyid);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    
    
    }

	public function uploadattachmentDetailsAction()
	{
		$db=$this->getServiceLocator()->get('db1');
		$num_files=0;
		//$form= $this->params()->fromQuery('form');
		
		$t="file has been uploaded successfully";
		$dirname=$_POST["docketnum12"];
		
		if (file_exists("C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/upload/".$dirname)) {
			$uploadpath="C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/upload/".$dirname . "/";
		} else {
			 
			$uploadpath="C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/upload/".$dirname;
			mkdir($uploadpath);
		
			$uploadpath=$uploadpath . "/";
		}
		
		//echo "<script type='text/javascript'>alert('hello whsdfasdfsdf');</script>";
	//	$granted12= $this->params()->fromQuery('granted12');
	//if (isset($_FILES['file']))
		{		
			$num_files = count($_FILES["file"]["name"]);
			if ($num_files <=1 )
			{
			$t1=$_FILES["file"]["name"];
			
			//  if (file_exists( $uploadpath . $t1))
			//  {
			// $t=$_FILES["file"]["name"] . " already exists. ";
			// return $t;
			// }
			// else
			
				move_uploaded_file($_FILES["file"]["tmp_name"],
				$uploadpath . $t1);
				//  echo "Stored in: " . "upload/" . $_FILES["uploadedfile1"]["name"];
			
			$t="/upload/" .$dirname . "/" . $t1;
			
			
			} 			
		
		}		
			
		$response = $this->getResponse();
		$response->setStatusCode(200);
		//  $response->setContent(json_encode($data));
		//$response->setContent($docket);
		$response->setContent($num_files);
		
		$headers = $response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/text');
		
		return $response;
	}

public function updateSupportDocumentsDescriptionAction()
	{
		$db=$this->getServiceLocator()->get('db1');
		
		$myarea1= $this->params()->fromQuery('attrflag');
		$partyid2= $this->params()->fromQuery('partyid2');
		
	//	$sql= "INSERT INTO `documentstable` (`Caseid`, `DocumentType`, `Granted`, `DateRequested`, `Description`, `Attachmentfilepaths`, `DocumentName`, `Docket_caseid`)
     //       VALUES ('" . $caseid . "', '" . $doctype1 . "', '" . $granted12 . "', '" . $datereq12 . "', '" . $myarea1 ."', '" . $filepath13 . "', '" . $filename1 . "', '" . $caseid . "')";
		
		$sql="UPDATE documentstable set `Description` = '". $myarea1 ."' where documentid = " . $partyid2;  
		
		
		$statement=$db->createStatement($sql);
		$result = $statement->execute();
		
		
		$response = $this->getResponse();
		$response->setStatusCode(200);
		//  $response->setContent(json_encode($data));
		//$response->setContent($docket);
		$response->setContent($sql);
		
		$headers = $response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/text');
		
		return $response;
	}
	
	public function removeAttachDetailsAction()
	{
		$db=$this->getServiceLocator()->get('db1');
		
		$docid1= $this->params()->fromQuery('docid1');
		
		$sql="delete FROM documentstable where documentid=" . $docid1;
		
		$statement=$db->createStatement($sql);
		$result = $statement->execute();
		
		
		$sql2= "insert into deletedattachmentpaths SELECT * FROM test.attachmentpaths where documentid=" . $docid1;
		
		$statement3=$db->createStatement($sql2);
		$result3 = $statement3->execute();
		$filepath4="";
	
		$sql5="SELECT * FROM `Attachmentpaths` where `documentid`=" . $docid1;
		$statement5=$db->createStatement($sql5);
		$result5 = $statement5->execute();
		//$stt=$stt . $sql2;
		if ($result5 instanceof ResultInterface && $result5->isQueryResult())
		{
			$resultSet2 = new ResultSet;
			$resultSet2->initialize($result5);
			$filepath4="<ol>";
			foreach ($resultSet2 as $row2) {
				$filepath2= $row2->attachmentpath;
				//	$filepath4="sdfsdf" . $row2->attachmentpath;
				$pos1=strripos($filepath2, "/");
				$filepath1 = substr($filepath2, $pos1);
				$filepath1 = ltrim($filepath1, "/");
				$filepath4=$filepath4 . "<li><a href=\\\\\\'" .  $filepath2 . "\\\\\\' target=\\\\\\'_new\\\\\\'>" .  $filepath1  .  "</a></li>";
		
			}
			$filepath4=$filepath4 . "</ol>";
		}
		
		
		
		$sql1="delete from `Attachmentpaths` where `documentid`=". $docid1;
		
		$statement1=$db->createStatement($sql1);
		$result1 = $statement1->execute();
		
		
		$done="done";
		$response = $this->getResponse();
		$response->setStatusCode(200);
		//  $response->setContent(json_encode($data));
		$response->setContent($filepath4);
		 
		$headers = $response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/text');
		 
		return $response;
	}
	
	public function insertattachmentDetailsAction()
    {
        $db=$this->getServiceLocator()->get('db1');
        
        $doctype1= $this->params()->fromQuery('doctype1');
        $granted12= $this->params()->fromQuery('granted12');
        $datereq12= $this->params()->fromQuery('datereq12');
        $myarea1= $this->params()->fromQuery('myarea1');
        $filepath12= $this->params()->fromQuery('filepath12');
        $caseid= $this->params()->fromQuery('caseid');
        $filename1= $this->params()->fromQuery('filename1');        

        $filearray=explode("?@?",$filepath12);

        $filepath13="";
        
    $sql= "INSERT INTO `documentstable` (`Caseid`, `DocumentType`, `Granted`, `DateRequested`, `Description`, `Attachmentfilepaths`, `DocumentName`, `Docket_caseid`)
            VALUES ('" . $caseid . "', '" . $doctype1 . "', '" . $granted12 . "', '" . $datereq12 . "', '" . $myarea1 ."', '" . $filepath13 . "', '" . $filename1 . "', '" . $caseid . "')";
        
   $statement=$db->createStatement($sql);
    $result = $statement->execute();
       
    $sql1="SELECT LAST_INSERT_ID() as new_id";
      $statement1=$db->createStatement($sql1);
     $result1 = $statement1->execute();
       $docket="t";
       //$t1=$db->lastInsertId();
       //$docket = $db->lastInsertValue;
       if ($result1 instanceof ResultInterface && $result1->isQueryResult())
       {
       	$resultSet1 = new ResultSet;
       	$resultSet1->initialize($result1);
       
       	$i=0;
       	foreach ($resultSet1 as $row) {
       
       		$docket=$row->new_id;
       
       		//			$arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
       
       	}// end of for loop
       	// console.log("i am here... do i");
       	//$docket="test";
       } 
            
       $len=count($filearray);
       
       foreach($filearray as $filenm)
       {
       	
      /* 	$sql3="Select * from `attachmentpaths` where `attachmentpath`='" . $filenm . "'";
       	$statement4=$db->createStatement($sql3);
       	$result4 = $statement4->execute();
       	
       	if ($result1 instanceof ResultInterface && $result1->isQueryResult())
       	{
       		$resultSet1 = new ResultSet;
       		$resultSet1->initialize($result1);
       		 
       		$i=0;
       		foreach ($resultSet1 as $row) {
       			 
       			$docket=$row->new_id;
       			 
       			//			$arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
       			 
       		}// end of for loop
       		// console.log("i am here... do i");
       		//$docket="test";
       	}*/
       	
       	
       	
      // 	if (file_exists( $uploadpath . $t1))
       		//  {
       		// $t=$_FILES["file"]["name"] . " already exists. ";
       		// return $t;
       		// }
       	
       	$sql2= "INSERT INTO `attachmentpaths` (`documentid`, `attachmentpath`)
            VALUES (" . $docket . ", '" . $filenm . "')";
       	
       	$statement3=$db->createStatement($sql2);
       	$result3 = $statement3->execute();
       }
       
       
           //$sql="done";
        
       $response = $this->getResponse();
       $response->setStatusCode(200);
       //  $response->setContent(json_encode($data));
       //$response->setContent($docket);
       $response->setContent($docket);
        
       $headers = $response->getHeaders();
       $headers->addHeaderLine('Content-Type', 'application/text');
        
       return $response;
    }
    
    
    
    
    
   /* public function fetchcaseidsAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    
    	$doctype1= $this->params()->fromQuery('tablename');
    	$granted12= $this->params()->fromQuery('strquery');
    	
    
    		$sql= "INSERT INTO `documentstable` (`Caseid`, `DocumentType`, `Granted`, `DateRequested`, `Description`, `Attachmentfilepaths`, `DocumentName`, `Docket_caseid`)
            VALUES ('" . $caseid . "', '" . $doctype1 . "', '" . $granted12 . "', '" . $datereq12 . "', '" . $myarea1 ."', '" . $filepath13 . "', '" . $filename1 . "', '" . $caseid . "')";
    
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	 
    	$sql='SELECT * FROM docket where caseid=' . $t;
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
    			 
    		
    				$docketnumber = $row->docketnumber;
    				$docketclerk  = $row->docketclerk;
    				$hearingreqby  = $row->hearingreqby;
    		
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		//return $post_data;
    	}//end of i
    	 
    	 
    	//$sql="done";
    
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//$response->setContent($docket);
    	$response->setContent($docket);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    }
    */     
    
    
    public function updateDocketCase1234Action()
    {
    //	$db=$this->getServiceLocator()->get('db1');
    //	$OsahDb=New OsahDbFunctions();
    	//$others= $this->params()->fromQuery('others');
    	$hearingreqdate= $this->params()->fromQuery('hearingreqdate');
    	$t=0/121;
    /*	$judgeassistant= $this->params()->fromQuery('judgeassistant');
    	$judge= $this->params()->fromQuery('judge');
    	$hearingtime= $this->params()->fromQuery('hearingtime');
    	$hearingsite= $this->params()->fromQuery('hearingsite');
    	$hearingmode= $this->params()->fromQuery('hearingmode');
    	//$county= $this->params()->fromQuery('county');
    	//$casetype= $this->params()->fromQuery('casetype');
    	//$refagency= $this->params()->fromQuery('refagency');
    	$datereceivedbyosah= $this->params()->fromQuery('datereceivedbyosah');
    	$agencyrefnumber= $this->params()->fromQuery('agencyrefnumber');
    	$hearingreqby= $this->params()->fromQuery('hearingreqby');
    	$daterequested=$this->params()->fromQuery('daterequested');
    	$hearingdate=$this->params()->fromQuery('hearingdate');
    	//$docketclerk=$this->params()->fromQuery('docketclerk');
    	$agencyrefnumber=$this->params()->fromQuery('agencyrefnumber');
    
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	//$sql="INSERT INTO `docket` (`docketnumber`, `docketclerk`, `hearingreqby`, `status`, `daterequested`, `datereceivedbyOSAH`, `refagency`, `casetype`, `casefiletype`, `county`, `agencyrefnumber`, `hearingmode`, `hearingsite`, `hearingdate`, `hearingtime`, `judge`, `judgeassistant`, `hearingrequesteddate`, `others`) VALUES
    	//	('2222', '" . $docketclerk . "','". $hearingreqby ."', 'new','".  $daterequested . "','" . $datereceivedbyosah. "','" . $refagency. "','" . $casetype. "', '','" . $county. "','" . $agencyrefnumber . "','" . $hearingmode. "','" . $hearingsite. "','" . $hearingdate. "','" . $hearingtime. "','" . $judge. "','" . $judgeassistant. "','" . $hearingreqdate. "','" . $others. "')";
    	 
    	$sql="UPDATE docket set `hearingreqby` = '". $hearingreqby ."' , `daterequested` = '".  $daterequested . "', `datereceivedbyOSAH` = '" . $datereceivedbyosah. "', `refagency`='" . $refagency. "', `agencyrefnumber`='" . $agencyrefnumber . "', `hearingmode`='" . $hearingmode. "', `hearingsite`='" . $hearingsite. "', `hearingdate`='" . $hearingdate. "', `hearingtime`='" . $hearingtime. "', `judge`='" . $judge. "', `judgeassistant`='" . $judgeassistant. "', `hearingrequesteddate`='" . $hearingreqdate. "', `others`='" . $others. "'";
    	 
    	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    
    	$docket="t";*/
    	 
    	//   $arrayliststr=$OsahDb->getCaseTypes($db, $t);
    	//  $jsonResponse = json_encode($arrayliststr);
    	
    	$sql="done";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($sql);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    
    }
    
public function UpdateDocketCaseAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$OsahDb=New OsahDbFunctions();
    	$others= $this->params()->fromQuery('others');
    	$hearingreqdate= $this->params()->fromQuery('hearingreqdate');
    	$judgeassistant= mysql_real_escape_string($this->params()->fromQuery('judgeassistant'));
    	$judge= mysql_real_escape_string($this->params()->fromQuery('judge'));
    	$hearingtime= $this->params()->fromQuery('hearingtime');
    	$hearingsite= mysql_real_escape_string($this->params()->fromQuery('hearingsite'));
    	$hearingmode= $this->params()->fromQuery('hearingmode');
    	$docketno=$this->params()->fromQuery('docketnumber');
    	$status=$this->params()->fromQuery('status');
    	$docketnumber12=$this->params()->fromQuery('docketnumber12');
    	    	
    	$county= $this->params()->fromQuery('county');
    	$OsahDb=New OsahDbFunctions();
    	$Countyid=$OsahDb->getCountyId($db,$county);
    	//$casetype= $this->params()->fromQuery('casetype');
    	//$refagency= $this->params()->fromQuery('refagency');
    	$datereceivedbyosah= $this->params()->fromQuery('datereceivedbyosah');
    	$agencyrefnumber= $this->params()->fromQuery('agencyrefnumber');
    	$hearingreqby= $this->params()->fromQuery('hearingreqby');
    	$daterequested=$this->params()->fromQuery('daterequested');
    	$hearingdate=$this->params()->fromQuery('hearingdate');
    	//$docketclerk=$this->params()->fromQuery('docketclerk');
    	//$agencyrefnumber=$this->params()->fromQuery('agencyrefnumber');
    
    	//$statement=$db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	//$sql="INSERT INTO `docket` (`docketnumber`, `docketclerk`, `hearingreqby`, `status`, `daterequested`, `datereceivedbyOSAH`, `refagency`, `casetype`, `casefiletype`, `county`, `agencyrefnumber`, `hearingmode`, `hearingsite`, `hearingdate`, `hearingtime`, `judge`, `judgeassistant`, `hearingrequesteddate`, `others`) VALUES 
    		//	('2222', '" . $docketclerk . "','". $hearingreqby ."', 'new','".  $daterequested . "','" . $datereceivedbyosah. "','" . $refagency. "','" . $casetype. "', '','" . $county. "','" . $agencyrefnumber . "','" . $hearingmode. "','" . $hearingsite. "','" . $hearingdate. "','" . $hearingtime. "','" . $judge. "','" . $judgeassistant. "','" . $hearingreqdate. "','" . $others. "')";
    		
    	if($hearingdate == "")
    	{
    		$hearingdate=null;
    	}
    	
    	$docketnumbertext=explode("-", $docketnumber12);
    	$judgename=explode(" ", $judge);
 	$dockettext1 = $docketnumbertext[0] . "-" . $docketnumbertext[1] . "-" . $docketnumbertext[2] . "-" . $Countyid . "-" .$judgename[0];
 	
 	if ($hearingdate==null)
 	{
    	$sql="UPDATE docket set county='" . $county . "',`docketnumber` = '". $dockettext1 ."' ,`hearingreqby` = '". $hearingreqby ."' , `daterequested` = '".  $daterequested . "', `datereceivedbyOSAH` = '" . $datereceivedbyosah. "', `agencyrefnumber`='" . $agencyrefnumber . "', `status`='" . $status. "', `hearingmode`='" . $hearingmode. "', `hearingsite`='" . $hearingsite. "', `hearingdate`= null, `hearingtime`='" . $hearingtime. "', `judge`='" . $judge. "', `judgeassistant`='" . $judgeassistant. "', `hearingrequesteddate`='" . $hearingreqdate. "', `others`='" . $others. "' where caseid = '" . $docketno . "'";
 	}
 	else
 	{
 		$sql="UPDATE docket set county='" . $county . "', `docketnumber` = '". $dockettext1 ."' ,`hearingreqby` = '". $hearingreqby ."' , `daterequested` = '".  $daterequested . "', `datereceivedbyOSAH` = '" . $datereceivedbyosah. "', `agencyrefnumber`='" . $agencyrefnumber . "', `status`='" . $status. "', `hearingmode`='" . $hearingmode. "', `hearingsite`='" . $hearingsite. "', `hearingdate`='" . $hearingdate. "', `hearingtime`='" . $hearingtime. "', `judge`='" . $judge. "', `judgeassistant`='" . $judgeassistant. "', `hearingrequesteddate`='" . $hearingreqdate. "', `others`='" . $others. "' where caseid = '" . $docketno . "'";
 	}	
    	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    		
    	$docket="t";
    	
    	//   $arrayliststr=$OsahDb->getCaseTypes($db, $t);
    	//  $jsonResponse = json_encode($arrayliststr);
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($dockettext1);
    	 
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    	 
    	return $response;    
    }
    
     public function UpdateHearingDateStatusAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$OsahDb=New OsahDbFunctions();
    	
    	$docketno=$this->params()->fromQuery('docketnumber');
    	$status="Stayed";
    	
    	$sql="UPDATE docket set `hearingdate`= null, `status`='" . $status . "' where caseid = '" . $docketno . "'";
    	 
    	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    
    	//$docket="t";
    	 
    	//   $arrayliststr=$OsahDb->getCaseTypes($db, $t);
    	//  $jsonResponse = json_encode($arrayliststr);
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($docketno);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    
    	return $response;
    }

    public function insertDispositionDataAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$OsahDb=New OsahDbFunctions();
    	$dispositiondate= $this->params()->fromQuery('dispositiondate');
    	$signedbyjudge= $this->params()->fromQuery('signedbyjudge');
    	$maileddate= $this->params()->fromQuery('maileddate');
    	$dispositioncode= $this->params()->fromQuery('dispositioncode');
    	$caseid= $this->params()->fromQuery('caseid');
    	$hearingyesno= $this->params()->fromQuery('hearingyesno');
    	
      	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql="INSERT INTO `docketdisposition` (`caseid`, `dispositioncode`, `dispositiondate`, `signedbyjudge`, `mailedddate`, `hearingyesno`) VALUES (" . $caseid .", '" . $dispositioncode . "','". $dispositiondate ."', '" . $signedbyjudge . "', '".  $maileddate . "', '" . $hearingyesno . "')";
    	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    
        $sql1='SELECT * FROM documentstable where DocumentType like "Decision%" and Caseid=' . $caseid;
    	//$sql='SELECT * FROM docket where caseid=' . $caseid;
    	$statement1=$db->createStatement($sql1);
    	$result1 = $statement1->execute();
    	//$arraylist="";
    	
    	/*$JudgeAssistantID="";
    	 $Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";*/
    	//$post_data="";
    	 
    	$flag="0";
    	if ($result1 instanceof ResultInterface && $result1->isQueryResult())
    	{
    		$resultSet1 = new ResultSet;
    		$resultSet1->initialize($result1);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet1 as $row) {
    	
    			 $flag="1";
    			}// end of for loop
    		
    	}//end of if loop
    	
    	if ($flag == "1")
    	{
    		$status="Closed";
    		
    		$sql2="update docket set status='" . $status . "' where caseid = '" . $caseid . "'";
    		//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    		$statement2=$db->createStatement($sql2);
    		$result2 = $statement2->execute();
    	}
    	
    	else 
    	{
    		$status="Awaiting Judge Decision";
    		
    		$sql2="update docket set status='" . $status . "' where caseid = '" . $caseid . "'";
    		//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    		$statement2=$db->createStatement($sql2);
    		$result2 = $statement2->execute();
    	}
    	//return $sql;
    	    	    	
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($status);    	
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');    	
    	return $response;
    }		
    	
 public function updateDispositionDataAction()
    {
    	$db=$this->getServiceLocator()->get('db1');
    	$OsahDb=New OsahDbFunctions();
    	$dispositiondate= $this->params()->fromQuery('dispositiondate');
    	$signedbyjudge= $this->params()->fromQuery('signedbyjudge');
    	$maileddate= $this->params()->fromQuery('maileddate');
    	$dispositioncode= $this->params()->fromQuery('dispositioncode');
    	$hearingyesno= $this->params()->fromQuery('hearingyesno');
    	$caseid= $this->params()->fromQuery('caseid');
    	 
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql="update docketdisposition set `dispositioncode`='" . $dispositioncode . "', `dispositiondate` = '". $dispositiondate ."', `signedbyjudge`='" . $signedbyjudge . "', `hearingyesno`='".  $hearingyesno . "' , `mailedddate`='".  $maileddate . "' where `caseid`=" . $caseid ;
    	
    	//,
    	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	 $statement=$db->createStatement($sql);
    	 $result = $statement->execute();
    
    	 
    	 $sql1='SELECT * FROM documentstable where DocumentType like "Decision%" and Caseid=' . $caseid;
    	 //$sql='SELECT * FROM docket where caseid=' . $caseid;
    	 $statement1=$db->createStatement($sql1);
    	 $result1 = $statement1->execute();
    	 //$arraylist="";
    	  
    	 /*$JudgeAssistantID="";
    	  $Judgeid="";
    	 $courtlocationid="";
    	 $hearingtime="";*/
    	 //$post_data="";
    	 
    	 $flag="0";
    	 if ($result1 instanceof ResultInterface && $result1->isQueryResult())
    	 {
    	 	$resultSet1 = new ResultSet;
    	 	$resultSet1->initialize($result1);
    	 	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    	 	$i=0;
    	 	
    	 	foreach ($resultSet1 as $row) {
    	 		 
    	 		$flag="1";
    	 	}// end of for loop
    	 	
    	 
    	 }//end of if loop
    	  
    	 if ($flag == "1")
    	 {
    	 	$status="Closed";
    	 
    	 	$sql2="update docket set status='" . $status . "' where caseid = '" . $caseid . "'";
    	 	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	 	$statement2=$db->createStatement($sql2);
    	 	$result2 = $statement2->execute();
    	 }
    	  
    	 else if ($flag == "0")
    	 {
    	 	$status="Awaiting Judge Decision";
    	 
    	 	$sql2="update docket set status='" . $status . "' where caseid = '" . $caseid . "'";
    	 	//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    	 	$statement2=$db->createStatement($sql2);
    	 	$result2 = $statement2->execute();
    	 }
    	 
    	 
    
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($status);
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    	return $response;
    }
     
    
    
public function getDocketNumberAction()
	 {
	     $db=$this->getServiceLocator()->get('db1');
	     $OsahDb=New OsahDbFunctions();
$others= $this->params()->fromQuery('others');
$hearingreqdate= $this->params()->fromQuery('hearingreqdate');
$judgeassistant= mysql_real_escape_string($this->params()->fromQuery('judgeassistant'));
$judge= mysql_real_escape_string($this->params()->fromQuery('judge'));
$status= $this->params()->fromQuery('status');
$hearingtime= $this->params()->fromQuery('hearingtime');
$hearingsite= mysql_real_escape_string($this->params()->fromQuery('hearingsite'));
$hearingmode= $this->params()->fromQuery('hearingmode');
$county= $this->params()->fromQuery('county');
$countyno= $this->params()->fromQuery('countyno');
$casetype= $this->params()->fromQuery('casetype');
$refagency= $this->params()->fromQuery('refagency');
$datereceivedbyosah= $this->params()->fromQuery('datereceivedbyosah');
$agencyrefnumber= $this->params()->fromQuery('agencyrefnumber');
$hearingreqby= $this->params()->fromQuery('hearingreqby');
$daterequested=$this->params()->fromQuery('daterequested');
$hearingdate=$this->params()->fromQuery('hearingdate');    
$docketclerk=mysql_real_escape_string($this->params()->fromQuery('docketclerk')); 
$agencyrefnumber=$this->params()->fromQuery('agencyrefnumber');
if($hearingdate == "")
{
	$hearingdate=null;
}
$file1='c:/iti/tmp/test1.txt';
$person="\n inside get docket number";
file_put_contents($file1, $person, FILE_APPEND);

if ($hearingdate== null)
{

	$sql="INSERT INTO `docket` (`docketnumber`, `docketclerk`, `hearingreqby`, `status`, `daterequested`, `datereceivedbyOSAH`, `refagency`, `casetype`, `casefiletype`, `county`, `agencyrefnumber`, `hearingmode`, `hearingsite`, `hearingdate`, `hearingtime`, `judge`, `judgeassistant`, `hearingrequesteddate`, `others`) VALUES ('2222', '" . $docketclerk . "','". $hearingreqby ."', '" . $status . "', '".  $daterequested . "','" . $datereceivedbyosah. "','" . $refagency. "','" . $casetype. "', '','" . $county. "','" . $agencyrefnumber . "','" . $hearingmode. "','" . $hearingsite. "', null ,'" . $hearingtime. "','" . $judge. "','" . $judgeassistant. "','" . $hearingreqdate. "','" . $others. "')";
}
else
{
	$sql="INSERT INTO `docket` (`docketnumber`, `docketclerk`, `hearingreqby`, `status`, `daterequested`, `datereceivedbyOSAH`, `refagency`, `casetype`, `casefiletype`, `county`, `agencyrefnumber`, `hearingmode`, `hearingsite`, `hearingdate`, `hearingtime`, `judge`, `judgeassistant`, `hearingrequesteddate`, `others`) VALUES ('2222', '" . $docketclerk . "','". $hearingreqby ."', '" . $status . "', '".  $daterequested . "','" . $datereceivedbyosah. "','" . $refagency. "','" . $casetype. "', '','" . $county. "','" . $agencyrefnumber . "','" . $hearingmode. "','" . $hearingsite. "','" . $hearingdate. "','" . $hearingtime. "','" . $judge. "','" . $judgeassistant. "','" . $hearingreqdate. "','" . $others. "')";
}
//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');

//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
$statement=$db->createStatement($sql);
$result = $statement->execute();

$sql1="SELECT LAST_INSERT_ID() as new_id";
$statement1=$db->createStatement($sql1);
$result1 = $statement1->execute();
$docket="t";
//$t1=$db->lastInsertId();
//$docket = $db->lastInsertValue;
 if ($result1 instanceof ResultInterface && $result1->isQueryResult())
{
	$resultSet1 = new ResultSet;
	$resultSet1->initialize($result1);
	 
	$i=0;
	foreach ($resultSet1 as $row) {
		
			$docket=$row->new_id;
				
//			$arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
	}// end of for loop
	// console.log("i am here... do i");
	//$docket="test";
	
	
} 

/*var judgefullname=dijit.byId('judge').get('displayedValue');
judgelastname=judgefullname.substr(0, judgefullname.indexOf(' '));
dockettext=dijit.byId('refagency').get('displayedValue') + "-" + dijit.byId('casetype').get('displayedValue') + "-" + t + "-" + dijit.byId('county').get('value') + "-" + judgelastname;
dojo.byId("availabilityNode").value="done" + dockettext ;
document.getElementById("docketinfo").innerHTML=dockettext; */
//update test.docket set docketnumber="test" where caseid = '1normal001';
$judgename=explode(" ", $judge);
$dockettext1 = $refagency . "-" . $casetype . "-" . $docket . "-" . $countyno . "-" . mysql_real_escape_string($judgename[0]);

//$dockettext1="test";

$sql2="update docket set docketnumber='" . $dockettext1 . "' where caseid = '" . $docket . "'";
//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
$statement2=$db->createStatement($sql2);
$result2 = $statement2->execute(); 

	     	  //   $arrayliststr=$OsahDb->getCaseTypes($db, $t);
	     //  $jsonResponse = json_encode($arrayliststr);
	     $response = $this->getResponse();
	     $response->setStatusCode(200);
	     //  $response->setContent(json_encode($data));
	     $response->setContent($docket);
	    // $docket
	     $headers = $response->getHeaders();
	     $headers->addHeaderLine('Content-Type', 'application/text');
	      
	     return $response;
	    

	}
	public function AddCalendarEntryAction()
	{
		$db=$this->getServiceLocator()->get('db1');
		
		$calendarid= $this->params()->fromQuery('calendarid');
		$hearingdate= $this->params()->fromQuery('hearingdate');		
		$cutoffdate= $this->params()->fromQuery('cutoffdate');
		$username= $this->params()->fromQuery('username');
		$partyid= $this->params()->fromQuery('partyid');
		
		//INSERT INTO `test`.`schedule` (`hearingdate`, `cutoffdate`, `Calendarid`) VALUES ('2013-1-1', '2013-1-1', '20');
		if ($partyid == "" )
		{		
		$sql="INSERT INTO `schedule` (`hearingdate`, `cutoffdate`, `Calendarid`) VALUES ('" . $hearingdate . "','". $cutoffdate ."', ".  $calendarid .")";
		//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
		$statement=$db->createStatement($sql);
		$result = $statement->execute();
		$calendarentryid="";
		$sql1="SELECT LAST_INSERT_ID() as new_id";
		$statement1=$db->createStatement($sql1);
		$result1 = $statement1->execute();
		//	$docket="t";
		//$t1=$db->lastInsertId();
		//$docket = $db->lastInsertValue;
		if ($result1 instanceof ResultInterface && $result1->isQueryResult())
		{
			$resultSet1 = new ResultSet;
			$resultSet1->initialize($result1);
		
			$i=0;
			foreach ($resultSet1 as $row) {
		
				$calendarentryid=$row->new_id;
		
				//			$arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
		
			}// end of for loop		
		  }
		}
	else
		{
			$sql="UPDATE `schedule` set `hearingdate` = '" . $hearingdate . "', `cutoffdate` = '". $cutoffdate ."' where `idSchedule` = " . $partyid; 
			//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
			$statement=$db->createStatement($sql);
			$result = $statement->execute();
			
			$calendarentryid="";
		}
					
		$response = $this->getResponse();
		$response->setStatusCode(200);
		//  $response->setContent(json_encode($data));
		$response->setContent($calendarentryid);
			
		$headers = $response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/text');
			
		return $response;
	}
	
	public function getCalendarNumberAction()
	{
		$db=$this->getServiceLocator()->get('db1');
		//$OsahDb=New OsahDbFunctions();
		
		$docketno= $this->params()->fromQuery('docketno');
		
		$judgeassistant= $this->params()->fromQuery('judgeassistant');
		$judgeassistantcode= $this->params()->fromQuery('judgeassistantcode');
		
		$judge= $this->params()->fromQuery('judge');
		$judgecode= $this->params()->fromQuery('judgecode');
		
		$hearingtime= $this->params()->fromQuery('hearingtime');
		
		$hearingsite= $this->params()->fromQuery('hearingsite');		
		$hearingsitecode= $this->params()->fromQuery('hearingsitecode');
		
		$casetype= $this->params()->fromQuery('casetype');
		
		$username=$this->params()->fromQuery('username');
		
		$noofcases=$this->params()->fromQuery('noofcases');
		
		$noofcases1=$this->params()->fromQuery('noofcases1');
		
		
		$sql2="select * from `calendarform` where `Judge`= '" .  $judge . "' and `Judgassistant`= '" . $judgeassistant . "' and `Hearingsite`= '" . $hearingsite . "' and `Hearingtime`= '" . $hearingtime . "' and `Castypegroup`='" . $casetype . "'";
		
		//and noofcases=" . $noofcases
		$statement2=$db->createStatement($sql2);
		$result2 = $statement2->execute();
		$docket=1;
		
		if ($result2 instanceof ResultInterface && $result2->isQueryResult())
		{
			$resultSet2 = new ResultSet;
			$resultSet2->initialize($result2);
			$i=0;
			foreach ($resultSet2 as $row) {
				
				$noofcasestbl=$row->noofcases;
				//if($noofcases1 == $noofcases)
			//	{
			//	$docket=0;
			//	}
				
					$docket=0;
				
			}// end of for loop
		}
		
		if(($noofcases1 != $noofcases) && $docket==0 && $docketno != 13 )  // This will make sure , it is existing calendar
		{
			$docket=1;
		}
		
		
		if( $docket == 1 ) 
		{
		//INSERT INTO `test`.`calendarform` (`Judge`, `Judgassistant`, `Hearingsite`, `Castypegroup`, `Hearingtime`) VALUES ('23', '234', '234', 'teste', '1.00');
		//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
		
			if ($docketno == 13)
			{
			
			
		$sql="INSERT INTO `calendarform` (`Judge`, `Judgassistant`, `Hearingsite`, `Castypegroup`, `Hearingtime`, `noofcases`) VALUES ('" . $judge . "','". $judgeassistant ."', '".  $hearingsite . "','" . $casetype . "','" . $hearingtime . "', " . $noofcases . " )";
		//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
	    $statement=$db->createStatement($sql);
		$result = $statement->execute();
	
		$sql1="SELECT LAST_INSERT_ID() as new_id";
		$statement1=$db->createStatement($sql1);
		$result1 = $statement1->execute();
	//	$docket="t";
		//$t1=$db->lastInsertId();
		//$docket = $db->lastInsertValue;
		if ($result1 instanceof ResultInterface && $result1->isQueryResult())
		{
			$resultSet1 = new ResultSet;
			$resultSet1->initialize($result1);
	
			$i=0;
			foreach ($resultSet1 as $row) {
	
				$docket=$row->new_id;
	
				//			$arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
	
							}// end of for loop
	
		 }
		
		
		}
			
		else 
			{
 					
				$sql="UPDATE `calendarform` set `Judge`='" . $judge . "', `Judgassistant` = '" . $judgeassistant . "', `Hearingsite` = '".  $hearingsite . "', `Castypegroup` = '" . $casetype . "', `Hearingtime` = '" . $hearingtime . "', noofcases=" . $noofcases . " where Calendarid = '" . $docketno . "'";
				//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
				$statement=$db->createStatement($sql);
				$result = $statement->execute();
				$docket=$docketno;
				
			}
		//$sql2="SELECT * FROM `judgescountymaping` where `Judgeid`= " .  $judgecode . " and `JudgeAssistantID`= " . $judgeassistantcode . " and `courtlocationid`= " . $hearingsitecode . " and `hearingtime`= '" . $hearingtime . "'";
		//SELECT * FROM calendarform where judge="Baxter Amanda" and Judgassistant="Ruff Valerie" and Hearingsite = "Gwinnett Courthouse Annex" and Castypegroup="Unified Cases" and Hearingtime="9:00 AM";
		
		//$sql4="SELECT * FROM `judgescountymaping` where where `Judgeid`= " .  $judgecode . " and `JudgeAssistantID`= " . $judgeassistantcode . " and `courtlocationid`= " . $hearingsitecode . " and `hearingtime`= '" . $hearingtime . "'";
	/*	$sql3="SELECT * FROM `unified_cases` where `Flag`='Y' and casetypegroup='" . $casetype . "'";
		$statement3=$db->createStatement($sql3);
		$result3 = $statement3->execute();
		$casetypes=Array();
		 if ($result3 instanceof ResultInterface && $result3->isQueryResult())
		 {
		$resultSet3 = new ResultSet;
		$resultSet3->initialize($result3);
		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
		$i=0;
		foreach ($resultSet3 as $row) {
			
			$casetypes[$i]=$row->casetypeid;
			$i = $i +1;
			
		}// end of for loop		
				//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
	} */
		}	
/*	$sql2="SELECT * FROM `judgescountymaping` where `Judgeid`= " .  $judgecode . " and `calendaridentification`=" . $docket .   " and `JudgeAssistantID`= " . $judgeassistantcode . " and `courtlocationid`= " . $hearingsitecode . " and `hearingtime`= '" . $hearingtime . "' and `Casetypeid` IN (" . implode(",", $casetypes) .")";
	
	$statement2=$db->createStatement($sql2);
	$result2 = $statement2->execute();
	if ($result2 instanceof ResultInterface && $result2->isQueryResult())
	{
		$resultSet2 = new ResultSet;
		$resultSet2->initialize($result2);
		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
		$i=0;
	/*	foreach ($resultSet2 as $row) {
				
			$casetypes[]=$row->casetypeid;
			$i = $i +1;
				
		} */
		// end of for loop
		//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
		
	//	$docket=0;
//	}
	//else 
//	{
		//$sql4="UPDATE `judgescountymaping` set `calendaridentification`=" . $docket . "  where `Judgeid`= " .  $judgecode . " and `JudgeAssistantID`= " . $judgeassistantcode . " and `courtlocationid`= " . $hearingsitecode . " and `hearingtime`= '" . $hearingtime . "' and `Casetypeid` IN (" . implode(",", $casetypes) .")";
		
	//	$statement4=$db->createStatement($sql4);
		
	//	$result4 = $statement4->execute();
		//update test.docket set docketnumber="test" where caseid = '1normal001';
	//}  
		
	//	$statement2=$db->createStatement($sql2);
	//	$result2 = $statement2->execute();
		$arraylist="";
		
	//	$JudgeAssistantID="";
	//	$Judgeid="";
	//	$courtlocationid="";
	//	$hearingtime="";
		 
		/* if ($result instanceof ResultInterface && $result->isQueryResult())
		{
			$resultSet = new ResultSet;
			$resultSet->initialize($result);
			//type : 'options', value : 1, text : 'Aaaaa, Aaa'
			$i=0;
			foreach ($resultSet as $row) {
				 
				$JudgeAssistantID=$row->JudgeAssistantID;
				$Judgeid=$row->Judgeid;
				$courtlocationid=$row->courtlocationid;
				$hearingtime=$row->hearingtime;
		
				$i = $i +1;
			}// end of for loop
		
			//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
		
		
		}//end of if loop
		*/
		
		
		 
	
		/*var judgefullname=dijit.byId('judge').get('displayedValue');
		 judgelastname=judgefullname.substr(0, judgefullname.indexOf(' '));
		dockettext=dijit.byId('refagency').get('displayedValue') + "-" + dijit.byId('casetype').get('displayedValue') + "-" + t + "-" + dijit.byId('county').get('value') + "-" + judgelastname;
		dojo.byId("availabilityNode").value="done" + dockettext ;
		document.getElementById("docketinfo").innerHTML=dockettext; */
		//update test.docket set docketnumber="test" where caseid = '1normal001';
		/*
		$judgename=explode(" ", $judge);
		$dockettext1 = $refagency . "-" . $casetype . "-" . $docket . "-" . $county . "-" . $judgename[0];
	
		//$dockettext1="test";
	
		$sql2="update docket set docketnumber='" . $dockettext1 . "' where caseid = '" . $docket . "'";
		//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
		$statement2=$db->createStatement($sql2);
		$result2 = $statement2->execute();
	*/
		//   $arrayliststr=$OsahDb->getCaseTypes($db, $t);
		//  $jsonResponse = json_encode($arrayliststr);
		$response = $this->getResponse();
		$response->setStatusCode(200);
		//  $response->setContent(json_encode($data));
		$response->setContent($docket);
		
		//
		$headers = $response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/text');
		 
		return $response;

	}
	
    
    public function checkdojoAction()
	{
		
	   // $this->params()->fromPost('paramname');   // From POST
	  //  $this->params()->fromQuery('paramname');  // From GET
	  //  $this->params()->fromRoute('paramname');  // From RouteMatch
	   // $this->params()->fromHeader('paramname'); // From header
	   // $this->params()->fromFiles('paramname');  // From file being uploaded	    	  
	   //$t=$_GET['refagency'];
	   
	  /*  $dbGroup = new dbGroups();
	    $groupDetails = $dbGroup -> groups($getGroupId);
	    $jsonResponse = json_encode($groupDetails);
	    print_r($jsonResponse);
	  */
	    $db=$this->getServiceLocator()->get('db1');
	    $OsahDb=New OsahDbFunctions();
	    $t= $this->params()->fromQuery('refagency');
	   $arrayliststr=$OsahDb->getCaseTypes($db, $t);
	  //  $jsonResponse = json_encode($arrayliststr);ocs
	  
	   
	    $response = $this->getResponse();
	    $response->setStatusCode(200);
	  //  $response->setContent(json_encode($data));
	    $response->setContent($arrayliststr);
	    
	    $headers = $response->getHeaders();
	    $headers->addHeaderLine('Content-Type', 'application/text');
	    
	    return $response;
	    
	}


    
    public function indexAction()
    {
        $this->isSessionActive();
        
        $db=$this->getServiceLocator()->get('db1');
        //   $sm=new dbconnect();
        //  $db= $sm->getAdapter();
        $statement= $db->query('SELECT * FROM `items` WHERE `id` = 1');
        //var_dump($statement); // this also empty
        
        $isconnected = $db->getDriver()->getConnection()->isConnected();
        if($isconnected){
        	//$message = 'connected';
        	//$vm = new ViewModel();
        	//$vm->setTemplate('/Osahform');
        	//return $vm->setVariables(array('test1'=>$message));
        } else {
        	$message = 'not Valid data field';
        	 
        	/*$vm = new ViewModel();
        	$vm->setTemplate('/Osahform');
        	return $vm->setVariables(array('test1'=>$message));*/
        	
        }
        //  DATABASE CONNECTION CODE   ENDS HERE
          
        
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /osahform/osahform/foo
        return array();
    }
    
    
    public function allcasesAction()
    {
        $this->isSessionActive();
        
        $db=$this->serviceLocator->get('db1');
        
        $vm = new ViewModel();
        $vm->setTemplate('Osahform/Osahform/allcases.phtml');
        //   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
        return $vm->setVariables(array('db'=>$db));
    }
    
    public function allcases1Action()
    {
    	$this->isSessionActive();
    
    	$db=$this->serviceLocator->get('db1');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/allcases1.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    }
    
    
    public function testdatabaseupdateAction()
    {
    	$this->isSessionActive();
    
    	$db2=$this->serviceLocator->get('db1');
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/testdatabaseupdate.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db2));
    }
    public function testdatabaseconAction()
    {
    	$this->isSessionActive();
    
    	$db2=$this->serviceLocator->get('db1');
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/testdatabasecon.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db2));
    }
    public function ExportcasestoOldCMS12Action()
    {
    	$this->isSessionActive();
    
    	$db2=$this->serviceLocator->get('db1');
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/ExportcasestoOldCMS12.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db2));
    
    }
    
    public function ExportcasestoOldCMSAction()
    {
    	$this->isSessionActive();
    
    	$db2=$this->serviceLocator->get('db1');
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/ExportcasestoOldCMS.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db2));
    	 
    }
    
    public function ExportbulkdocsAction()
    {
    	$this->isSessionActive();
    
    	$db2=$this->serviceLocator->get('db1');
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/Exportbulkdocs.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db2));
    
    }
    // this controller is used to update docket clerk and judge assistant id only.
public function  duplicatedExportupdatetempCasesAction()
    {
    	$serverName = "167.192.83.19";
    	//$connectionOptions = array("Database"=>"DDSCms");
    	$connectionOptions = array( "Database"=>"decision_library_v2", "UID"=>"KambalaG", "PWD"=>"itcontractor");
    	/* Connect using Windows Authentication. */
    	$conn = sqlsrv_connect( $serverName, $connectionOptions);
    	if( $conn === false )
    		die( FormatErrors( sqlsrv_errors() ) );
    
    
    	$db=$this->getServiceLocator()->get('db1');
    
    	$file1='c:/iti/tmp/test3.txt';
    	$person="\n Export cases";
    	file_put_contents($file1, $person, FILE_APPEND);
    
    
    	$grtdocket=1613769;
    
    	$OsahDb=New OsahDbFunctions();
    	$sql="SELECT * FROM docket where caseid >= " . $grtdocket . " and caseid <= 1613906";
    //	$sql="SELECT * FROM docket where caseid = 1610167";
    	//$sql="SELECT * FROM docket where caseid  1600084";
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    
    	/*$JudgeAssistantID="";
    	 $Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";*/
    	$post_data="";
    	 
    	//$OsahDb
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
    
    			$Agencyid=$OsahDb->getAgencyId($db,$row->refagency);
    			$Casetypeid=$OsahDb->getCaseTypeId($db,$Agencyid,$row->casetype);
    			$Countyid=$OsahDb->getCountyId($db,$row->county);
    			 
    			$judgeassistant=$row->judgeassistant;
    			 
    			//JUDGE ASSISTNAT FULLNAME HAS BEEN SEPERATED AS FIRST NAME AND LAST NAME AND GETTING ID
    			$pos=stripos($judgeassistant, " ");
    			$firstn=substr($judgeassistant,$pos);
    			$pos1=strlen($judgeassistant)-$pos;
    			$lasttn=substr($judgeassistant,0,-$pos1);
    			//$cmafullname=$firstn . " " . $lasttn;
    
    
    			//JUDGE FULLNAME HAS BEEN SEPERATED AS FIRST NAME AND LAST NAME AND GETTING ID
    			$judge=$row->judge;
    			$pos=stripos($judge, " ");
    			$judgefirstn=substr($judge,$pos);
    			$pos1=strlen($judge)-$pos;
    			$judgelasttn=substr($judge,0,-$pos1);
    			//	$judgefullname=$judgefirstn . " " . $judgelasttn;
    
    			$judgeid=$OsahDb->getJudgesID($db, $judgelasttn, $judgefirstn);
    			
    			$judgeassistantid=$OsahDb->getJudgesAssistantID($db, $lasttn, $firstn);
    			
    			//$person="\n judge assistant id". $judgeassistantid;
    		//	file_put_contents($file1, $person, FILE_APPEND);
    			//$person="\n Export cases". $lasttn  . $firstn ;
    		//	file_put_contents($file1, $person, FILE_APPEND);
    			$docketclerk=$row->docketclerk;
    			$docketclerkid=$OsahDb->getClerkID($db, $docketclerk);
    
    			$caseid=$row->caseid;
    			$petitionernameinfo=$OsahDb->getPetitionerName($db, $caseid);
    
    			$casename=$petitionernameinfo[2];
    			$hearingtime=$row->hearingtime;
    			$hearingsite=$row->hearingsite;
    
    			if ($casename=="")
    			{
    				$petitionernameinfo1=$OsahDb->getRespondentName($db, $caseid);
    				
    				$casename=$petitionernameinfo1[2];
    			}
    			
    			$hearingsiteid=$OsahDb->getCourtLocationsid($db, $hearingsite);
    			$hearingreqby=$row->hearingreqby;
    			$hearingdate=$row->hearingdate;
    			$datereceivedbyOSAH=$row->datereceivedbyOSAH;
    			$daterequested=$row->daterequested;
    			$hearingmode=$row->hearingmode;
    			$agencyrefnumber=$row->agencyrefnumber;
    			$hearingmodeid=$OsahDb->getHearingModeID($db, $hearingmode);
    
    			$SrchLastName=$petitionernameinfo[1];
    			$SrchFirstName=$petitionernameinfo[0];
    			
    			$AgencyAttorneyid=$OsahDb->getAgencyAttorney($db, $caseid, $conn, $file1 );

    			// Case worker data insertion
    			$Hearingcoordinatorlst=$OsahDb->getHearingcoordinatorName($db, $caseid, $conn, $file1, $Countyid, $Agencyid );
    			
    			
    			// Case worker data insertion
    			$CaseworkerNamelst=$OsahDb->getCaseWorkerName($db, $caseid, $conn, $file1, $Countyid, $Agencyid );
    			   
    			// Investigator data insertion   
    			$InvestigatorNamelst=$OsahDb->getInvestigatorName($db, $caseid, $conn, $file1, $Countyid, $Agencyid );
    			
    			
    			$OfficerNamelst=$OsahDb->getOfficerName($db, $caseid, $conn, $file1, $Countyid, $Agencyid );   // Officer data insertion
    			$hearingcode=$hearingmodeid;
    			
    			$Hearingcoordinatorflag=0;
    			
    			
    			$investigatoravailableflag=0;
    			$office2flag=0;
    			$Official2Name="";
    			$EnforcementOffice2="";
    			
    			
    			$OfficerName=$OfficerNamelst[0];
    			if ($OfficerName!="")
    			{
    				//$OfficerName=$OfficerName;
    				$investigatoravailableflag=1;
    			
    			
    			
    				$CaseworkerName=$CaseworkerNamelst[0];
    				if ($CaseworkerName!="")
    				{
    					$Official2Name=$CaseworkerName;
    				}
    			
    				
    				//$Officerlocation=$OfficerNamelst[1];
    				
    					$EnforcementOffice=$OfficerNamelst[1];
    					$investigatoravailableflag=1;
    					 
    					$caseworkerlocation=$CaseworkerNamelst[1];
    					if($caseworkerlocation != "")
    					{
    						$EnforcementOffice2=$CaseworkerNamelst[1];
    				    }
    				
    				
    			}
    			//$OfficerName=$OfficerNamelst[0];
    			
    			
    			$InvestigatorName=$InvestigatorNamelst[0];
    			if ($InvestigatorName!="")
    			{
    				$OfficerName=$InvestigatorName;
    				$investigatoravailableflag=1;
    				
    				
    				
    				$CaseworkerName=$CaseworkerNamelst[0];
    				if ($CaseworkerName!="")
    				{
    					$office2flag=1;
    					$Official2Name=$CaseworkerName;
    				}
    				
    			//	$Investigatorlocation=$InvestigatorNamelst[1];
    				
    					$EnforcementOffice=$InvestigatorNamelst[1];
    					$investigatoravailableflag=1;
    				
    					$caseworkerlocation=$CaseworkerNamelst[1];
    					if($caseworkerlocation != "")
    					{
    						$office2flag=1;
    						$EnforcementOffice2=$CaseworkerNamelst[1];
    					}
    			
    				
    				
    			}
    			
    			
    			
    			$HearingcoordinatorName=$Hearingcoordinatorlst[0];
    			if ($InvestigatorName!="")
    			{
    				$OfficerName=$HearingcoordinatorName;
    				$investigatoravailableflag=1;
    			
    			
    			
    				$CaseworkerName=$CaseworkerNamelst[0];
    				if ($CaseworkerName!="")
    				{
    					$office2flag=1;
    					$Official2Name=$CaseworkerName;
    				}
    			
    				//	$Investigatorlocation=$InvestigatorNamelst[1];
    			
    				$EnforcementOffice=$Hearingcoordinatorlst[1];
    				$investigatoravailableflag=1;
    			
    				$caseworkerlocation=$CaseworkerNamelst[1];
    				if($caseworkerlocation != "")
    				{
    					$office2flag=1;
    					$EnforcementOffice2=$CaseworkerNamelst[1];
    				}
    				 
    			
    			
    			}
    			
    			//$OfficerName=$OfficerNamelst[0];
    		
    			
    			
    			
    			//  If investigator is available, case worker will be stored in enforcementoffice2 field. 
    			//If investigator is not available, case worker will be stored in Enforcementofficer field same as "Officer".
    			$CaseworkerName=$CaseworkerNamelst[0];
    			if ($CaseworkerName!="" && $investigatoravailableflag==0)
    			{
    				$OfficerName=$CaseworkerName;
    			}
    			//$OfficerName=$OfficerNamelst[0];
    			
    			$caseworkerlocation=$CaseworkerNamelst[1];
    			if($caseworkerlocation != ""  && $investigatoravailableflag==0)
    			{
    				$EnforcementOffice=$CaseworkerNamelst[1];
    			}
    			
    			
    			
    			
    			
    			
    			$cases="Agency Id: " . $OfficerName . "Casetypeid: " .  $SrchFirstName . "County: " . $casename;
    		//	$sql2="INSERT INTO [osah2k1].dbo.tblCaseDetail([Case ID], [Initial Operator],[Agency ID],[Case Type ID],[County],
	//	[Case Name],[Judge ID],[Hearing Time],[Hearing Site],[Hearing Code ID],[Clerk ID],[Case Requested By],
	//	[hearing dt],[Dt Request Rcvd], [ReqDtRev], [SrchLastName],[SrchFirstName],[OfficerName],[EnforcementOffice],[RevHearingTime],
	//	[DataEntryDate]) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    			$docketclerk=trim($docketclerk);
    			//$sql3="Update [osah2k1].dbo.tblCaseDetail set [Initial Operator]='" . $docketclerk  . "', [Clerk ID]=" . $judgeassistantid . " where [Case ID]=" . $caseid;
    			
    			
    			/*  #################################################
    			BELOW QUERY IS ONLY FOR UPDATING CASE NAME. THIS HAS BEEN TAKEN CARE WHEN UPDATING THE NEW CASES ITSELF.
    			$sql3="Update [osah2k1].dbo.tblCaseDetail set [Case Name]='" . $casename  . "' where [Case ID]=" . $caseid . " and [Case Name]=''";
    			//$sql2 ="Update [osah2k1].dbo.tblCaseDetail set [Initial Operator]=(?), [Clerk ID]=(?) where [Case ID]=(?)";
    			
    			$sql2 ="Update [osah2k1].dbo.tblCaseDetail set [Case Name]=(?) where [Case ID]=(?) and [Case Name]=''";
    			$params = array($casename, $caseid);
    			
    			*###################################################  */
    	
    	
    	
    	
    			
    			
    			/*  #################################################   
    			    BELOW QUERY IS FOR UPDATEING CASE WORKER DATA, INVESTIGATOR DATA, AGENCY CONTACT AND AGENCY ATTORNEY
    			    */
    		//	,[OfficerName]
      //,[EnforcementOffice]      
      //,[EnforcementOffice2],
//[Official2Name]  

    			if($office2flag == 1)   //Second officer is also being updated.
    			{
    				
    				$sql3="Update [osah2k1].dbo.tblCaseDetail set [Ref Agency Attorney ID]='". $AgencyAttorneyid ."', [OfficerName]='" . $OfficerName  . "',[EnforcementOffice]='" . $EnforcementOffice . "', [Official2Name]='" . $Official2Name  . "', [EnforcementOffice2]='" . $EnforcementOffice2 . "' where [Case ID]=" . $caseid;
    				//$sql2 ="Update [osah2k1].dbo.tblCaseDetail set [Initial Operator]=(?), [Clerk ID]=(?) where [Case ID]=(?)";
    				
    				$sql2 ="Update [osah2k1].dbo.tblCaseDetail set [Ref Agency Attorney ID]=(?), [OfficerName]=(?),[EnforcementOffice]=(?),[Official2Name]=(?),[EnforcementOffice2]=(?) where [Case ID]=(?)";
    				
    				$params = array($AgencyAttorneyid, $OfficerName, $EnforcementOffice, $Official2Name, $EnforcementOffice2, $caseid);
    			}
    			else  // Only officer or case worker or investigator is being updated
    			{

    				$sql3="Update [osah2k1].dbo.tblCaseDetail set [Ref Agency Attorney ID]='". $AgencyAttorneyid ."', [OfficerName]='" . $OfficerName  . "',[EnforcementOffice]='" . $EnforcementOffice . "' where [Case ID]=" . $caseid;
    				//$sql2 ="Update [osah2k1].dbo.tblCaseDetail set [Initial Operator]=(?), [Clerk ID]=(?) where [Case ID]=(?)";
    				
    				$sql2 ="Update [osah2k1].dbo.tblCaseDetail set [Ref Agency Attorney ID]=(?), [OfficerName]=(?),[EnforcementOffice]=(?)  where [Case ID]=(?)";
    				$params = array($AgencyAttorneyid, $OfficerName, $EnforcementOffice, $caseid);
    			}
    			
    			
    			 
    			/*###################################################  */
    			
    			$person="\n sql" . $sql3;
    			file_put_contents($file1, $person, FILE_APPEND);
    			//$params = array($docketclerk, $judgeassistantid, $caseid);
    			//$params = array($casename, $caseid);
    			$getProducts=sqlsrv_query($conn, $sql2, $params);
    			//		TransmittedToOSAH
    			//	1205Rcvd
    			//$getProducts = sqlsrv_query( $conn, $query);
    			if ( $getProducts === false)
    			{
    				die(	$this->FormatErrors( sqlsrv_errors()));
    
    			}
    		 
    			
    
    			 
    			 
    
    
    			$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		//return $post_data;
    	}//end of if loop
    
    	//return $sql;
    
    
    
    
    
    
    
    	//	$cases="done";
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($i);
    
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    	 
    	return $response;
    }
    
    
    
    public function  ExportupdatetempCasesbackupAction()
    {
    	$serverName = "167.192.83.19";
    	//$connectionOptions = array("Database"=>"DDSCms");
    	$connectionOptions = array( "Database"=>"decision_library_v2", "UID"=>"KambalaG", "PWD"=>"itcontractor");
    	/* Connect using Windows Authentication. */
    	$conn = sqlsrv_connect( $serverName, $connectionOptions);
    	if( $conn === false )
    		die( FormatErrors( sqlsrv_errors() ) );
    
    
    	$db=$this->getServiceLocator()->get('db1');
    
    	$file1='c:/iti/tmp/test3.txt';
    	$person="\n Export cases";
    	file_put_contents($file1, $person, FILE_APPEND);
    
    
    	$grtdocket=1613769;
    
    	$OsahDb=New OsahDbFunctions();
    	$sql="SELECT * FROM test.attorneybycase where typeofcontact like '%Agency Attorney%'";
    	//	$sql="SELECT * FROM docket where caseid = 1610167";
    	//$sql="SELECT * FROM docket where caseid  1600084";
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    
    	/*$JudgeAssistantID="";
    	 $Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";*/
    	$post_data="";
    
    	//$OsahDb
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    
    			
    			$caseid=$row->caseid;
    			
    			$AgencyAttorneyid=$OsahDb->getAgencyAttorney($db, $caseid, $conn, $file1 );
    			 
    			
    
    			$sql3="Update [osah2k1].dbo.tblCaseDetail set [Ref Agency Attorney ID]='". $AgencyAttorneyid ."' where [Case ID]=" . $caseid;
    			//$sql2 ="Update [osah2k1].dbo.tblCaseDetail set [Initial Operator]=(?), [Clerk ID]=(?) where [Case ID]=(?)";
    
    			$sql2 ="Update [osah2k1].dbo.tblCaseDetail set [Ref Agency Attorney ID]=(?) where [Case ID]=(?)";
    
    				$params = array($AgencyAttorneyid, $caseid);
    			
    
    
    
        			/*###################################################  */
        			 
        			$person="\n sql" . $sql3;
        			file_put_contents($file1, $person, FILE_APPEND);
        			 //$params = array($docketclerk, $judgeassistantid, $caseid);
        			//$params = array($casename, $caseid);
        			$getProducts=sqlsrv_query($conn, $sql2, $params);
        			//		TransmittedToOSAH
        			//	1205Rcvd
        			//$getProducts = sqlsrv_query( $conn, $query);
        			if ( $getProducts === false)
    			{
    			die(	$this->FormatErrors( sqlsrv_errors()));
    
    		}
    		 
    		 
    
    
    
    
    
    		$i = $i +1;
    		}// end of for loop
    		//	$arraylist = $arraylist + "]";
    		//return $post_data;
    		}//end of if loop
    
    		//return $sql;
    
    
    
    
    
    
    
    		//	$cases="done";
    		$response = $this->getResponse();
    		$response->setStatusCode(200);
    			//  $response->setContent(json_encode($data));
    			$response->setContent($i);
    
    			$headers = $response->getHeaders();
        			$headers->addHeaderLine('Content-Type', 'application/text');
    
        			return $response;
    }
    
 public function  ExportCasesbackupAction()
     {
     	$serverName = "167.192.83.19";
     	//$connectionOptions = array("Database"=>"DDSCms");
     	$connectionOptions = array( "Database"=>"decision_library_v2", "UID"=>"KambalaG", "PWD"=>"itcontractor");
     	/* Connect using Windows Authentication. */
     	$conn = sqlsrv_connect( $serverName, $connectionOptions);
     	if( $conn === false )
     		die( FormatErrors( sqlsrv_errors() ) );
     	
     	
     	$db=$this->getServiceLocator()->get('db1');
     	
     	$file1='c:/iti/tmp/test1.txt';
     	$person="\n Export cases";
     	file_put_contents($file1, $person, FILE_APPEND);
     	
     	
        $sql8="SELECT max(Docketid) as docketid from exportreport";
        $statement8=$db->createStatement($sql8);
        $result8 = $statement8->execute();
        $grtdocket=9000000; //works until 2089 year 
        //$t1=$db->lastInsertId();
        //$docket = $db->lastInsertValue;
        if ($result8 instanceof ResultInterface && $result8->isQueryResult())
        {
        	$resultSet8 = new ResultSet;
        	$resultSet8->initialize($result8);
        
        	$i=0;
        	foreach ($resultSet8 as $row) {
        
        		$grtdocket=$row->docketid;
        
        		//			$arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
        	}// end of for loop
        	// console.log("i am here... do i");
        	//$docket="test";
        }
        
     	$OsahDb=New OsahDbFunctions();
     	$sql="SELECT * FROM docket where caseid > " . $grtdocket;
     	//$sql="SELECT * FROM docket where caseid  1600084";
     	$statement=$db->createStatement($sql);
     	$result = $statement->execute();
     	$arraylist="";
     	
     	/*$JudgeAssistantID="";
     	 $Judgeid="";
     	$courtlocationid="";
     	$hearingtime="";*/
     	$post_data="";
     	 
     	//$OsahDb
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
     			
     				$Agencyid=$OsahDb->getAgencyId($db,$row->refagency);
     				$Casetypeid=$OsahDb->getCaseTypeId($db,$Agencyid,$row->casetype);
     				$Countyid=$OsahDb->getCountyId($db,$row->county);
     				
     				$judgeassistant=$row->judgeassistant;
     				
     				//JUDGE ASSISTNAT FULLNAME HAS BEEN SEPERATED AS FIRST NAME AND LAST NAME AND GETTING ID
     				$pos=stripos($judgeassistant, " ");
    				$firstn=substr($judgeassistant,$pos);
    				$pos1=strlen($judgeassistant)-$pos;
    				$lasttn=substr($judgeassistant,0,-$pos1);
				    	//$cmafullname=$firstn . " " . $lasttn;
    				
    				
    				//JUDGE FULLNAME HAS BEEN SEPERATED AS FIRST NAME AND LAST NAME AND GETTING ID
    				$judge=$row->judge;
    				$pos=stripos($judge, " ");
    				$judgefirstn=substr($judge,$pos);
    				$pos1=strlen($judge)-$pos;
    				$judgelasttn=substr($judge,0,-$pos1);
			    	//	$judgefullname=$judgefirstn . " " . $judgelasttn;
			    	
    				$judgeid=$OsahDb->getJudgesID($db, $judgelasttn, $judgefirstn);
    				
    				$judgeassistantid=$OsahDb->getJudgesAssistantID($db, $lasttn, $firstn);
    				$docketclerk=$row->docketclerk;
    				
    				$docketclerk=trim($docketclerk);
    				$docketclerkid=$OsahDb->getClerkID($db, $docketclerk);
    				    				
    				$caseid=$row->caseid;
    				$petitionernameinfo=$OsahDb->getPetitionerName($db, $caseid);
    				
    				$casename=$petitionernameinfo[2];   
    				$hearingtime=$row->hearingtime;
    				$hearingsite=$row->hearingsite;
    				
    				if ($casename=="")
    				{
    					$petitionernameinfo1=$OsahDb->getRespondentName($db, $caseid);
    				
    					$casename=$petitionernameinfo1[2];
    				}
    				
    				
    				$hearingsiteid=$OsahDb->getCourtLocationsid($db, $hearingsite);
    				$hearingreqby=$row->hearingreqby;
    				$hearingdate=$row->hearingdate;
    				$datereceivedbyOSAH=$row->datereceivedbyOSAH;
    				$daterequested=$row->daterequested;  
    				$hearingmode=$row->hearingmode;
    				$agencyrefnumber=$row->agencyrefnumber;
    				$hearingmodeid=$OsahDb->getHearingModeID($db, $hearingmode);
    				
    				$SrchLastName=$petitionernameinfo[1];  
    				$SrchFirstName=$petitionernameinfo[0]; 
    				$OfficerNamelst=$OsahDb->getOfficerName($db, $caseid, $conn, $file1, $Countyid, $Agencyid );   // Need to write code   			
    				$OfficerName=$OfficerNamelst[0];
    				$hearingcode=$hearingmodeid;  
    				$EnforcementOffice=$OfficerNamelst[1];
    				$cases="Agency Id: " . $OfficerName . "Casetypeid: " .  $SrchFirstName . "County: " . $casename;
	$sql2="INSERT INTO [osah2k1].dbo.tblCaseDetail([Case ID], [Initial Operator],[Agency ID],[Case Type ID],[County], 
		[Case Name],[Judge ID],[Hearing Time],[Hearing Site],[Hearing Code ID],[Clerk ID],[Case Requested By],
		[hearing dt],[Dt Request Rcvd], [ReqDtRev], [SrchLastName],[SrchFirstName],[OfficerName],[EnforcementOffice],[RevHearingTime],
		[DataEntryDate]) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

	$sql3="INSERT INTO [osah2k1].dbo.tblCaseDetail([Case ID], [Initial Operator],[Agency ID],[Case Type ID],[County],
		[Case Name],[Judge ID],[Hearing Time],[Hearing Site],[Hearing Code ID],[Clerk ID],[Case Requested By],
		[hearing dt],[Dt Request Rcvd], [ReqDtRev], [SrchLastName],[SrchFirstName],[OfficerName],[EnforcementOffice],[RevHearingTime],
		[DataEntryDate]) VALUES ('" . $caseid  . "','" . $docketclerk . "'," . $Agencyid . "," . $Casetypeid . "," . $Countyid . ",'" . $casename .
	 "'," . $judgeid . ",'" . $hearingtime . "','" . $hearingsiteid . "','" . $hearingcode . "'," . $judgeassistantid . ",'" . $hearingreqby . "','" . 
	$hearingdate . "','" . $datereceivedbyOSAH . "','" . $daterequested . "','" . $SrchLastName . "','" . $SrchFirstName . "','" . $OfficerName . "', '" . $EnforcementOffice ."', '" . $hearingtime . "','" . $datereceivedbyOSAH . "')";
	
	
/*'hearingreqby' => $row->hearingreqby,
'daterequested' => $row->daterequested, 
'datereceivedbyOSAH' => $row->datereceivedbyOSAH,
'refagency' => $row->refagency,
'agencyrefnumber' => $row->agencyrefnumber,
'hearingmode' => $row->hearingmode,
'hearingsite' => $row->hearingsite,
'hearingdate' => $row->hearingdate,
'hearingtime' => $row->hearingtime,
'hearingrequesteddate' => $row->hearingrequesteddate,
'others' => $row->others  */
	$person="\n sql" . $sql3;
	file_put_contents($file1, $person, FILE_APPEND);
	$params = array($caseid, $docketclerk, $Agencyid,$Casetypeid,$Countyid, $casename, $judgeid, $hearingtime, $hearingsiteid, $hearingcode, $judgeassistantid, $hearingreqby, $hearingdate, $datereceivedbyOSAH, $daterequested, $SrchLastName, $SrchFirstName, $OfficerName, $EnforcementOffice, $hearingtime, $datereceivedbyOSAH);
	$getProducts=sqlsrv_query($conn, $sql2, $params);
//		TransmittedToOSAH
//	1205Rcvd
//$getProducts = sqlsrv_query( $conn, $query);
	if ( $getProducts === false)
		{
	die(	$this->FormatErrors( sqlsrv_errors()));

	}
	$osahtodaydt=date("Y-m-d");
	$sql5="INSERT INTO `exportreport` (`Docketid`, `date`) VALUES ('" . $caseid  . "', '" . $osahtodaydt . "')";
	$statement=$db->createStatement($sql5);
	$result = $statement->execute();
	
	if ($result instanceof ResultInterface && $result->isQueryResult())
	{
		$resultSet = new ResultSet;
		$resultSet->initialize($result);
		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
	
		$ids=""; 
		foreach ($resultSet as $row) {
			
		}
	}
	
	if ($Agencyid!= 7 && $Agencyid!=237)   //DDS cases and all other agencies data will be moved. 
	{
		$person="\n inside agency." . $Agencyid;
		file_put_contents($file1, $person, FILE_APPEND);
		$sql4=$OsahDb->getAllPetRes($db, $caseid, $agencyrefnumber, $conn, $file1);
	}else if ($Agencyid==237 )  // OIG Cases...
	{
		$sql4=$OsahDb->getAllPetResOIG($db, $caseid, $agencyrefnumber, $conn, $file1);
	}else if ($Agencyid==7 ) // CSS Cases. 
	{
		$sql4=$OsahDb->getAllPetResCSS($db, $caseid, $agencyrefnumber, $conn, $file1);
	}

	$cases=$sql4;
    				
     		/*-		$post_data = array('docketnumber' => $row->docketnumber,
     						'docketclerk' => $row->docketclerk,
     						'hearingreqby' => $row->hearingreqby,
     						'status' => $row->status,
     						'daterequested' => $row->daterequested,
     						'datereceivedbyOSAH' => $row->datereceivedbyOSAH,
     						'refagency' => $row->refagency,
     						'agencyid' => $Agencyid,
     						'casetype' => $row->casetype,
     						'casetypeid' => $Casetypeid,
     						'casefiletype' => $row->casefiletype,
     						'county' => $row->county,
     						'countyid' => $Countyid,
     						'agencyrefnumber' => $row->agencyrefnumber,
     						'hearingmode' => $row->hearingmode,
     						'hearingsite' => $row->hearingsite,
     						'hearingdate' => $row->hearingdate,
     						'hearingtime' => $row->hearingtime,
     						'judge' => $row->judge,
     						'judgeassistant' => $row->judgeassistant,
     						'hearingrequesteddate' => $row->hearingrequesteddate,
     						'others' => $row->others);
     					*/
     				//$post_data = json_encode($post_data);
     				//    $arraylist="1 : '". $caseid11 . "', col2 : '" . $row->refagency . "', col3 : '" . $row->casetype . "', col4: '" . $row->county . "', col5: '" . $row->judge . "' }" ;
     	
     		
     				
     	
     	
     			$i = $i +1;
     		}// end of for loop
     		//	$arraylist = $arraylist + "]";
     		//return $post_data;
     	}//end of if loop
     	
     	//return $sql;
     	
     	
     	
     	
     	
     	
     	
     //	$cases="done";
     	$response = $this->getResponse();
     	$response->setStatusCode(200);
     	//  $response->setContent(json_encode($data));
     	$response->setContent($i);     	

     	$headers = $response->getHeaders();
     	$headers->addHeaderLine('Content-Type', 'application/text');
     	 
     	return $response;
     }
    
    public function FormatErrors( $errors )
     {
     	/* Display errors. */
     	echo "Error information: <br/>";
     
     	foreach ( $errors as $error )
     	{
     		echo "SQLSTATE: ".$error['SQLSTATE']."<br/>";
     		echo "Code: ".$error['code']."<br/>";
     		echo "Message: ".$error['message']."<br/>";
     	}
     }
public function ImportDDSRecordsbackupAction()
    {
    
 	   $serverName = "167.192.83.19";
//$connectionOptions = array("Database"=>"DDSCms");
			$connectionOptions = array( "Database"=>"DDSCms", "UID"=>"KambalaG", "PWD"=>"itcontractor");
			
    	
    	  /* $serverName = "167.192.83.39";
    	 //$connectionOptions = array("Database"=>"DDSCms");
    	$connectionOptions = array( "Database"=>"mydds", "UID"=>"sa", "PWD"=>"Episode3");*/
    	
/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionOptions);
			if( $conn === false )
				die($this->FormatErrors( sqlsrv_errors() ) );

			//	echo 'Connection Succssfull';

//[DDSCms].[dbo].[DriverInfo]

//$query = "SELECT top 10 count(*) as 'earlist' FROM DDSCms.dbo.DriverInfo";

		//$query = "SELECT * FROM DDSCms.dbo.DriverInfo where (([1205Rcvd]=1 and PostmarkDt is not null) or ([1205Rcvd]=0 and PostmarkDt <= DATEADD(day, -90, GETDATE()))) and (HearingReqRcvd=1) and (TransmittedToOSAH=0)";
		
		
		$query = "SELECT * FROM [DMVS Data Transfer].dbo.DriverInfo where (([1205Rcvd]=1 and PostmarkDt is not null and Officerlastname is not null) or ([1205Rcvd]=0 and PostmarkDt <= DATEADD(day, -91, GETDATE()) and Officerlastname is null) )
		and (HearingReqRcvd=1) and (TransmittedToOSAH=0) and
		((([LicenseeAttnyAddr1] is not null) and ([LicenseeAttnyCity] is not null) and ([LicenseeAttnyState] is not null) and
				([LicenseeAttnyZip] is not null)) or
				(([DriverAddress1] is not null) and ([DriverCity] is not null) and ([DriverSt] is not null) and ([DriverZip] is not null)))";
		
		$getProducts = sqlsrv_query( $conn, $query);
		$lastname="";
		$CountyID="";
		$earlist="";
		$cases=0;
		
		if ( $getProducts === false)

			{ die( FormatErrors( sqlsrv_errors() ) ); }

				if(sqlsrv_has_rows($getProducts))
						{
							//echo 'Connection Succssfull2';
							$rowCount = sqlsrv_num_rows($getProducts);
								//	BeginProductsTable($rowCount);
							while( $row = sqlsrv_fetch_array( $getProducts, SQLSRV_FETCH_ASSOC))
								{	
   																											
									$CountyID=$row['CountyID'];
									if($CountyID == 60)
									{

										$OfficerCity=$strtolower($row['OfficerCity']);

										if (strpos($OfficerCity,"alpha") !=False)
										{
											$CountyID=603;
										}
										else if (strpos($OfficerCity,"sandy") !=False)
										{
											$CountyID=602;
										}
										else if (strpos($OfficerCity,"Johns") !=False && strpos($OfficerCity,"creek") !=False)
										{
											$CountyID=604;
										}
										else if (strpos($OfficerCity,"milton") !=False)
										{
											$CountyID=605;
										}
										else if (strpos($OfficerCity,"roswe") !=False)
										{
											$CountyID=601;
										}
										
									}
									
								
									
   										$Casetype=$row['CaseType'];
   										$OfficerAddress1=strtolower($row['OfficerAddress1']);
   										if ($Casetype=== NULL)
   										{
   											$Casetype="";
   										}
   										
   								if ($OfficerAddress1 !== NULL)
   									{
   										$OfficerAddress1 = strtoupper($OfficerAddress1);
   										if (strpos($OfficerAddress1,'GEORGIA STATE PATROL') !== false) {
   											$ddsdps="DPS";
   											$Casetype=605;
   											/*  Dee Brophy
   											Legal Service
   											Dept of Public Safety
   											
   											Atlanta  GA 30371   */
   											
   										  
   										}
   										else
   										{
   											$ddsdps="DDS";
   											$Casetype=612;
   										}
   									}
   								else
   								   {
   								   	$ddsdps="DDS";
   								   	$Casetype=612;
   								   }	
   										
   									
   										
   								//		$ddsdps="DDS";
								//	$earlist=$row['RecordID'];
   										$PostmarkDt=$row['PostmarkDt'];   										
   										$DLNo=$row['DLNo'];
   										if ($DLNo=== NULL)
   										{
   											$DLNo="";
   										}
   										$countyid= $CountyID;
   										$casetypeid= $Casetype;
   										$RecordID=$row['RecordID'];
   										

   										/*
   										 *                                      DriverLastName	Y	tblpeopledetails.lastname
   										DriverFirstName	Y	tblpeopledetails.Firstname
   										DriverMiddleName	Y	tblpeopledetails.Middlename
   										DtOfBirth	N
   										DriverAddress1	Y	tblpeopledetails.Address1
   										DriverAddress2	Y	tblpeopledetails.Address2
   										DriverCity	Y	tblpeopledetails.City
   										DriverSt	Y	tblpeopledetails.State
   										DriverZip	Y	tblpeopledetails.Zip
   										DriverPhone	Y	tblpeopledetails.Phone
   										DriverFax	Y	tblpeopledetails.Fax
   										DLNo	Y	tbldocket.agencyrefnumber
   											
   										tblpeopledetails.lastname
   										tblpeopledetails.Firstname
   										tblpeopledetails.Middlename
   										
   										tblpeopledetails.Address1
   										tblpeopledetails.Address2
   										tblpeopledetails.City
   										tblpeopledetails.State
   										tblpeopledetails.Zip
   										tblpeopledetails.Phone
   										tblpeopledetails.Fax
   										tbldocket.agencyrefnumber
   										
   											
   										*/
   										   				
   										
   										//  PETITIONER DETAILS - BEGIN HERE
   										
   										$DriverLastName= $row['DriverLastName'];
   										$DriverFirstName=$row['DriverFirstName'];
   										$DriverMiddleName=$row['DriverMiddleName'];
   										//   										$DtOfBirth=$row['DtOfBirth'];
   										$DriverAddress1=$row['DriverAddress1'];
   										$DriverAddress2=$row['DriverAddress2'];
   										$DriverCity=$row['DriverCity'];
   										$DriverSt=$row['DriverSt'];
   										$DriverZip=$row['DriverZip'];
   										$DriverPhone=$row['DriverPhone'];
   										$DriverFax=$row['DriverFax'];
   										$DriverEmailAddress=$row['DriverEmailAddress'];
   										
   															
   										if ($DriverEmailAddress=== NULL)
   										{
   											$DriverEmailAddress="";
   										}
   										
   										
   										
   										$file1='c:/iti/tmp/test.txt';
   										// The new person to add to the file
   										$person = $RecordID;
   										// Write the contents to the file,
   										// using the FILE_APPEND flag to append the content to the end of the file
   										// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
   									//	file_put_contents($file1, $person, FILE_APPEND);
   											
   										
   									
   										$db=$this->getServiceLocator()->get('db1');   									
   									
   										$countyid= $CountyID;
   										$casetypeid= $Casetype;
   										
   										//$person="before testidid function";
   										
   										//file_put_contents($file1, $person, FILE_APPEND);
   										$username= $this->params()->fromQuery('username');
   										$docketR=$this->testidi($CountyID, $Casetype, $PostmarkDt, $DLNo, $ddsdps, $username);
   										$person="\n after testidid function" . $RecordID . " docketno " . $docketR;
   										file_put_contents($file1, $person, FILE_APPEND);
   										$this->updateSqlDDS($docketR, $RecordID, $conn);
   										$cases=$cases+1;
   										$person="\n after updatesqlDDSn" . $RecordID . " docketno " . $docketR;
   										file_put_contents($file1, $person, FILE_APPEND);

   										//  Adding petitioner details to the database  - Begin
   										$db=$this->getServiceLocator()->get('db1');  //
   										$sql=" INSERT INTO `peopledetails` (`typeofcontact`, `caseid`, `Lastname`, `Firstname`, `Middlename`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Phone`, `Docket_caseid`, `fax`, `mailtoreceive`,`mailtoreceive1`,`Title`,`Company`  ) VALUES ('petitioner', '". $docketR . "', '" . $DriverLastName . "', '" . $DriverFirstName . "', '" . $DriverMiddleName . "', '" . $DriverAddress1 ."', '" . $DriverAddress2 . "', '" . $DriverCity ."', '" . $DriverSt . "', '" . $DriverZip . "', '" . $DriverEmailAddress . "', '" . $DriverPhone . "', '" . $docketR . "', '" . $DriverFax . "', '', '', '', '')";
   												//	$sql=" INSERT INTO `peopledetails` (`typeofcontact`, `caseid`, `Lastname`, `Firstname`, `Middlename`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Phone`, `Docket_caseid`, `fax`, `mailtoreceive`,`mailtoreceive1`,`Title`,`Company`  ) VALUES ('petitionerntact . "', '". $docketnum . "', '" . $lastname . "', '" . $firstname . "', '" . $middlename . "', '" . $address1 ."', '" . $address2 . "', '" . $city ."', '" . $state . "', '" . $zip . "', '" . $emailt . "', '" . $phonet . "', '" . $docketnum . "', '" . $faxt . "', '" . $mailtoreceive  ."', '" . $mailtoreceive1 . "', '" . $ptcompany ."', '" . $pttitle . "')";
   										$statement=$db->createStatement($sql);
   										$result = $statement->execute();
   											
   										$person="\n after people data is inserted" . $RecordID . " docketno " . $docketR;
   										file_put_contents($file1, $person, FILE_APPEND);
   										
   										/*
   										OfficerLastName	Y	tblofficerdetails.lastname
   										OfficerFirstName	Y	tblofficerdetails.firstname
   										OfficerMiddleName	Y	tblofficerdetails.middlename
   										OfficerPhone	Y	tblofficerdetails.phone
   										OfficerFax	Y	tblofficerdetails.fax
   										OfficerAddress1	Y	tblofficerdetails.Address1
   										OfficerAddress2	Y	tblofficerdetails.Address2
   										OfficerCity	Y	tblofficerdetails.City
   										OfficerSt	Y	tblofficerdetails.State
   										OfficerZip	Y	tblofficerdetails.Zip
   											*/

   										
   										//  OFFICER DETAILS - BEGIN HERE
   										$OfficerLastName=$row['OfficerLastName'];
   										$OfficerFirstName=$row['OfficerFirstName'];
   										$OfficerMiddleName=$row['OfficerMiddleName'];
   										//   										$DtOfBirth=$row['DtOfBirth'];
   										$OfficerAddress1=$row['OfficerAddress1'];
   										$OfficerAddress2=$row['OfficerAddress2'];
   										$OfficerCity=$row['OfficerCity'];
   										$OfficerSt=$row['OfficerSt'];
   										$OfficerZip=$row['OfficerZip'];
   										$OfficerPhone=$row['OfficerPhone'];
   										$OfficerFax=$row['OfficerFax'];
   										$OfficerEmail=$row['OfficerEmail'];
   										
   										if ($OfficerEmail=== NULL)
   										{
   											$OfficerEmail="";
   										}
   											
   										
   										$sql1= "INSERT INTO `agencycaseworkerbycase` (`caseid`, `typeofcontact`,`Docket_caseid`,`Lastname`, `Firstname`, `Middlename`,`Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Fax`, `Phone`) VALUES (" . $docketR . ", 'Officer', " . $docketR . ",'" . $OfficerLastName . "', '" . $OfficerFirstName . "', '" . $OfficerMiddleName . "', '" . str_replace("'","\'",$OfficerAddress1)  ."', '" .str_replace("'","\'",$OfficerAddress2)  . "', '" . $OfficerCity ."', '" . $OfficerSt . "', '" . $OfficerZip . "', '" . $OfficerEmail . "', '" . $OfficerFax . "', '" . $OfficerPhone . "')";
   									//	$sql1=" INSERT INTO `officerdetails` (`Lastname`, `Firstname`, `Middlename`, `Title`, `Company`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `fax`, `Phone`) VALUES ('" . $OfficerLastName. "', '" . $OfficerFirstName. "', '" . $OfficerMiddleName. "', '','', '" . $OfficerAddress1 . "', '" . $OfficerAddress2 . "', '" . $OfficerCity ."', '" . $OfficerSt . "', '" . $OfficerZip . "', '" . $OfficerEmail . "', '" . $OfficerFax . "', '" . $OfficerPhone . "')";
   										
   										$person="\n Officer by case" . $sql1;
   										file_put_contents($file1, $person, FILE_APPEND);
   											
   										$statement1=$db->createStatement($sql1);
   										$result1 = $statement1->execute();
   										
   										
   										
   										if($ddsdps == "DPS")
   										{
   											$LicenseeAttnyID=$row['LicenseeAttnyID'];
   											$LicenseeAttnyBar=$row['LicenseeAttnyBar'];
   											$LicenseeAttnyAddr1="Legal Service, Dept of Public Safety";
   											// $DtOfBirth=$row['DtOfBirth'];
   											$LicenseeAttnyCity="Atlanta";
   											$LicenseeAttnyState="GA";
   											$LicenseeAttnyAddr2="PO Box 1456";
   											$LicenseeAttnyZip="30371";
   											$LicenseeAttnyPhone="(404) 624-7424";
   											$LicenseeAttnyFax="";
   											$LicenseeAttnyEmail="";
   											$LicenseeAttnyName="Dee Brophy";
   											
   											if ($LicenseeAttnyBar=== NULL)
   											{
   												$LicenseeAttnyBar=0;
   											}
   												

   											
   												$AttorneyFirstName="Dee";
   												$AttorneyLastName="Brophy";
   											
   											
							$sql16="INSERT INTO `attorneybycase` (`caseid`, `typeofcontact`,`Docket_caseid`, `Lastname`, `Firstname`, `AttorneyBar`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Fax`, `Phone`) VALUES
        (" . $docketR  . ", 'Respondent Attorney', " . $docketR  . ",'" . $AttorneyLastName . "', '" . $AttorneyFirstName . "', '" . $LicenseeAttnyBar . "', '" . str_replace("'","\'",$LicenseeAttnyAddr1)  ."', '" . str_replace("'","\'",$LicenseeAttnyAddr2) . "', '" . $LicenseeAttnyCity ."', '" . $LicenseeAttnyState . "', '" . $LicenseeAttnyZip . "', '" . $LicenseeAttnyEmail . "', '" . $LicenseeAttnyFax . "', '" . $LicenseeAttnyPhone . "')";
   											$person="\n Respondent attornyby case" . $sql16;
   											file_put_contents($file1, $person, FILE_APPEND);
   												
   											$statement16=$db->createStatement($sql16);
   											$result16 = $statement16->execute();
   										
   										}
   											
   										
   										
   										
   										$LicenseeAttnyID=$row['LicenseeAttnyID'];
   										$LicenseeAttnyBar=$row['LicenseeAttnyBar'];
   										$LicenseeAttnyAddr1=$row['LicenseeAttnyAddr1'];
   										// $DtOfBirth=$row['DtOfBirth'];
   										$LicenseeAttnyCity=$row['LicenseeAttnyCity'];
   										$LicenseeAttnyState=$row['LicenseeAttnyState'];
   										$LicenseeAttnyAddr2=$row['LicenseeAttnyAddr2'];
   										$LicenseeAttnyZip=$row['LicenseeAttnyZip'];
   										$LicenseeAttnyPhone=$row['LicenseeAttnyPhone'];
   										$LicenseeAttnyFax=$row['LicenseeAttnyFax'];
   										$LicenseeAttnyEmail=$row['LicenseeAttnyEmail'];
   										$LicenseeAttnyName=$row['LicenseeAttnyName'];
   										
   										
   										if ($LicenseeAttnyBar=== NULL)
   										{
   											$LicenseeAttnyBar=0;
   										}
   										
   										if ($LicenseeAttnyEmail=== NULL)
   										{
   											$LicenseeAttnyEmail="";
   										}
   									/*		
   									 * LicenseeAttnyID
   										LicenseeAttnyBar
   										LicenseeAttnyAddr1
   										LicenseeAttnyAddr2
   										LicenseeAttnyCity
   										LicenseeAttnyState
   										LicenseeAttnyZip
   										LicenseeAttnyPhone
   										LicenseeAttnyFax
   										LicenseeAttnyEmail
   										LicenseeAttnyName
   											*/
   									   										
   										
   										$names=explode(',',$LicenseeAttnyName);
   										
   										if (!strcasecmp($names[0], 'no') == 0) {
   											//If there is no attorney specified...
   											if ( ! isset($names[1])) {
   												$names[1] = "";
   											}
   											
   											$AttorneyFirstName=$names[0];
   											$AttorneyLastName=$names[1];
   									
   										//	$LicenseeAttnyAddr2=str_replace("'","\'",$LicenseeAttnyAddr2);
   										//	$LicenseeAttnyAddr1=str_replace("'","\'",$LicenseeAttnyAddr1);
   										$sql2= "INSERT INTO `attorneybycase` (`caseid`, `typeofcontact`,`Docket_caseid`, `Lastname`, `Firstname`, `AttorneyBar`, `Address1`, `Address2`, `City`, `State`, `Zip`, `Email`, `Fax`, `Phone`) VALUES
        (" . $docketR  . ", 'Petitioner Attorney', " . $docketR  . ",'" . $names[0] . "', '" . $names[1] . "', '" . $LicenseeAttnyBar . "', '" . str_replace("'","\'",$LicenseeAttnyAddr1)  ."', '" . str_replace("'","\'",$LicenseeAttnyAddr2) . "', '" . $LicenseeAttnyCity ."', '" . $LicenseeAttnyState . "', '" . $LicenseeAttnyZip . "', '" . $LicenseeAttnyEmail . "', '" . $LicenseeAttnyFax . "', '" . $LicenseeAttnyPhone . "')";
   										$person="\n Attorney by case" . $sql2;
   										file_put_contents($file1, $person, FILE_APPEND);
   											
   										
   										$statement2=$db->createStatement($sql2);
   										$result2 = $statement2->execute();
   										
   											}
   										
   									/*	$sql2="SELECT * FROM attorney where Attorneyid=". $LicenseeAttnyID ;
   										//$sql="SELECT * FROM `judgescountymaping` where `Casetypeid`= " .  $casetypeid . " and `CountyID`= " . $countyid;
   										$statement2=$db->createStatement($sql2);
   										$result2 = $statement2->execute();
   										$flag=0;
   										 
   										if ($result instanceof ResultInterface && $result->isQueryResult())
   										{
   											$resultSet = new ResultSet;
   											$resultSet->initialize($result);
   											//type : 'options', value : 1, text : 'Aaaaa, Aaa'
   											foreach ($resultSet as $row) {
   												 $flag=1; 												   												 
														}// end of for loop
   											 
   										}//end of if loop
   										
   										*/
   										
   										
   										//  Adding petitioner details to the database  - End
   										$person="after attorney data is insterted" . $docketR;
   										file_put_contents($file1, $person, FILE_APPEND);
   									//	$this->insertImportTbl($docketR, $RecordID, $conn );
   										
   										$osahaccepteddt=date("Y-m-d");
   										//INSERT INTO `test`.`report` (`RecordID`, `Docketnumber`, `date`, `status`) VALUES ('1', '1', '15-6-6', 'Imported');
   										
   										$query ="INSERT INTO report (`RecordID`, `Docketnumber`, `date`, `status`) VALUES (" . $RecordID . ", " . $docketR . ", '" . $osahaccepteddt . "','Imported')";
   										
   										$person="before import table data is insterted \n\n" . $query;
   										file_put_contents($file1, $person, FILE_APPEND);
   										
   										$statement=$db->createStatement($query);
   										$result = $statement->execute();
   										
   										$person="after import table data is insterted \n\n";
   										file_put_contents($file1, $person, FILE_APPEND);
   											//$this->insertCalendarHistoryDDS($docketR, $RecordID);

   										$summary= "Record has been imported from DDS database. New docket number is " . $docketR . " and record id from DDS database is " . $RecordID;
   										$username= $this->params()->fromQuery('username');
   										$datereq12= date("Y-m-d");
   										$caseid= $docketR;
   										$sql= "INSERT INTO `history` (`caseid`,`Date`, `Description`, `Modifiedby`, `Docket_caseid`) VALUES (" . $docketR .  ",'" . $datereq12 . "', '" . $summary . "', '" . $username . "', " . $docketR .")";
   										$person="before cablendar table data is insterted \n\n" . $sql;
   										file_put_contents($file1, $person, FILE_APPEND);
   										$statement=$db->createStatement($sql);
   										$result = $statement->execute();
   										
   										
   											$person="after calendar function";
   										
   									
   										file_put_contents($file1, $person, FILE_APPEND);
   										$message=$docketR;
									}

						}							
	    

    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	$response->setContent($cases);
    	
    	//
    	$headers = $response->getHeaders();
    	$headers->addHeaderLine('Content-Type', 'application/text');
    		
    	return $response;
    
    }
    
    public function insertCalendarHistoryDDS($docketR, $RecordID)
    {
    
    	$sql="";
    	$db=$this->getServiceLocator()->get('db1');
    
    	$summary= "Record has been imported from DDS database. New docket number is " . $docketR . " and record id from DDS database is " . $docketR;
    	$username= $this->params()->fromQuery('username');
    	$datereq12= date("Y-m-d");
    	$caseid= $docketR;
    	$sql= "INSERT INTO `calendarhistory` (`Date`, `Description`, `Modifiedby`, `Calendarid`) VALUES ('" . $datereq12 . "', '" . $summary . "', '" . $username . "', " . $caseid .")";
    
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    
    	 
    	 
    	return true;
    
    }
    public function insertImportTbl($docketR, $RecordID, $conn )
    {
    	$db=$this->getServiceLocator()->get('db1');
    	 
    	$osahaccepteddt=date("Y-m-d");
    	//INSERT INTO `test`.`report` (`RecordID`, `Docketnumber`, `date`, `status`) VALUES ('1', '1', '15-6-6', 'Imported');
    
    	$query ="INSERT INTO report (`RecordID`, `Docketnumber`, `date`, `status`) VALUES (" . $RecordID . ", " . $docketR . ", " . $osahaccepteddt . ",'Imported')";
    	//		Update
    	//		OSAHAcceptedDt
    	//$sql = "update tblAddressBook set name=(?), addr1=(?), addr2=(?),..."
    	//$person="after import table data is insterted". $query;
    	//file_put_contents($file1, $person, FILE_APPEND);
    	$statement=$db->createStatement($query);
    	$result = $statement->execute();
    
    	//$params = array($RecordID, $docketR, $osahaccepteddt);
    	//	$getProducts=sqlsrv_query($conn, $query, $params);
    	//		TransmittedToOSAH
    	//	1205Rcvd
    	//$getProducts = sqlsrv_query( $conn, $query);
    	/*	if ( $getProducts === false)
    	 { } */
    	 
    }
    
    Public function updateSqlDDS($docketR, $RecordID, $conn)
    {
    
    	//$query = "SELECT * FROM DDSCms.dbo.DriverInfo where ([1205Rcvd]=-1 or ([1205Rcvd]=0 and PostmarkDt <= DATEADD(day, -90, GETDATE()))) and (HearingReqRcvd=1) and (TransmittedToOSAH=0)";
    
    	$osahaccepteddt=date("Y-m-d");
    
    	//INSERT INTO `test`.`report` (`RecordID`, `Docketnumber`, `date`, `status`) VALUES ('1', '1', '15-6-6', 'Imported');
    	$query ="Update [DMVS Data Transfer].dbo.DriverInfo set TransmittedToOSAH=1, [Update]=(?), OSAHAcceptedDt=(?) where RecordID=(?)";
    	//		Update
    	//		OSAHAcceptedDt
    	//$sql = "update tblAddressBook set name=(?), addr1=(?), addr2=(?),..."
    	$params = array($docketR, $osahaccepteddt, $RecordID);
    	$getProducts=sqlsrv_query($conn, $query, $params);
    	//		TransmittedToOSAH
    	//	1205Rcvd
    	//$getProducts = sqlsrv_query( $conn, $query);
    	if ( $getProducts === false)
    	{
    
    
    	}
    
    }
     
    public function testidi($CountyID, $Casetype, $PostmarkDt, $DLNo, $ddsdps, $username)
    {
    
    	$db=$this->getServiceLocator()->get('db1');
    	$countyid= intval($CountyID);
    	$casetypeid= intval($Casetype);
    	 
    	//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
    	$OsahDb=New OsahDbFunctions();
    	$casecode=$OsahDb->getCaseTypeCodeDesc($db,$casetypeid);
    	$countydesc=$OsahDb->getCountyCode($db,$countyid);
    	 
    	$sql="SELECT * FROM `judgescountymaping` where Casetypeid=". $casetypeid . " and `CountyID`= " . $countyid;
    	//$sql="SELECT * FROM `judgescountymaping` where `Casetypeid`= " .  $casetypeid . " and `CountyID`= " . $countyid;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	 
    	$JudgeAssistantID="";
    	$Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";
    	$Hearingdate="";
    	 
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet as $row) {
    			 
    			$JudgeAssistantID=$row->JudgeAssistantID;
    			$Judgeid=$row->Judgeid;
    			$courtlocationid=$row->courtlocationid;
    			$hearingtime=$row->hearingtime;
    			 
    			$i = $i +1;
    		}// end of for loop
    		 
    		//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    		 
    		 
    	}//end of if loop
    	$OsahDb=New OsahDbFunctions();
    	$casecode=$OsahDb->getCaseTypeCodeDesc($db,$casetypeid);
    	$countydesc=$OsahDb->getCountyCode($db,$countyid);
    	 
    	//  HEARIND DATE CODE -  MODULE  BEGIN HERE
    	//	SELECT * FROM test.unified_cases where casetypeid=510;
    	$sql3="SELECT * FROM `unified_cases` where `casetypeid`= " .  $casetypeid;
    	$statement3=$db->createStatement($sql3);
    	$result3 = $statement3->execute();
    	$casetypegroup1="";
    	if ($result3 instanceof ResultInterface && $result3->isQueryResult())
    	{
    		$resultSet3 = new ResultSet;
    		$resultSet3->initialize($result3);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet3 as $row) {
    			 
    			$casetypegroup[$i]=$row->casetypegroup;
    			$i = $i +1;
    		}// end of for loop
    		$casetypegroup1= $casetypegroup[0];
    	}//end of if loop
    	 
    	$Judgefullname="";
    	$JudgeAssistantfullname="";
    	$Courtlocationname="";
    	 
    	// JUDGE NAME CODE
    	$sql4="SELECT * FROM `judges` where `Judgeid`= " .   intval($Judgeid);
    	$statement4=$db->createStatement($sql4);
    	$result4 = $statement4->execute();
    	 
    	if ($result4 instanceof ResultInterface && $result4->isQueryResult())
    	{
    		$resultSet4 = new ResultSet;
    		$resultSet4->initialize($result4);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet4 as $row) {
    			 
    			$Judgefullname=$row->LastName . " " . $row->FirstName;
    			$i = $i +1;
    		}// end of for loop
    		 
    	}//end of if loop
    	 
    	 
    	// JUDGE ASSISTANT NAME CODE
    	$sql5="SELECT * FROM `judgeassistant` where `JudgeAssistantID`= " .  intval($JudgeAssistantID);
    	$statement5=$db->createStatement($sql5);
    	$result5 = $statement5->execute();
    	 
    	if ($result5 instanceof ResultInterface && $result5->isQueryResult())
    	{
    		$resultSet5 = new ResultSet;
    		$resultSet5->initialize($result5);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet5 as $row) {
    			 
    			$JudgeAssistantfullname=$row->LastName . " " . $row->FirstName;
    			$i = $i +1;
    		}// end of for loop
    		 
    	}//end of if loop
    	 
    	 
    	// COURT LOCATION NAME
    	$sql6="SELECT * FROM `courtlocations` where `courtlocationid`= " .  intval($courtlocationid);
    	$statement6=$db->createStatement($sql6);
    	$result6 = $statement6->execute();
    	 
    	if ($result6 instanceof ResultInterface && $result6->isQueryResult())
    	{
    		$resultSet6 = new ResultSet;
    		$resultSet6->initialize($result6);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet6 as $row) {
    			 
    			$Courtlocationname=$row->Locationname;
    			$i = $i +1;
    		}// end of for loop
    		 
    	}//end of if loop
    	 
    	//SELECT * FROM test.calendarform;
    	 
    	//SELECT * FROM test.calendarform where Judge ="malihi Michael" and Judgassistant="Parker Larry" and Hearingsite Like "OSAH%" and Hearingtime="1:00 AM";
    	 
    	// COURT LOCATION NAME
    	$i=0;
    	$length = count($casetypegroup);
    	$Calendarid[0]="";
    	$noofcases[0]=0;
    	for($i2=0;$i2 < $length; $i2++)
    	{
    	 
    	$casetypegrp=preg_replace( "/\r|\n/", "", $casetypegroup[$i2]);
    	$htime=preg_replace( "/\r|\n/", "", $hearingtime );
    	$sql7="SELECT * FROM calendarform where Judge='" .  $Judgefullname . "' and Hearingtime='" . $htime . "' and judgassistant='" . $JudgeAssistantfullname . "' and hearingsite='" . $Courtlocationname . "' and Castypegroup = '" . $casetypegrp . "'";
    	 
    	 
    	 
    	$statement7=$db->createStatement($sql7);
    	$result7= $statement7->execute();
    	 
    	if ($result7 instanceof ResultInterface && $result7->isQueryResult())
    	{
    	$resultSet7 = new ResultSet;
    	$resultSet7->initialize($result7);
    	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    	$i=0;
    	foreach ($resultSet7 as $row) {
    	 
    	$Calendarid[$i]=$row->Calendarid;
    	$noofcases[$i]=$row->noofcases;
    		//	$i = $i +1;
    	}// end of for loop
    		 
    	}//end of if loop
    	 
    	 
    	}
    	//$sql7="SELECT * FROM `calendarform` where `Judge`= '" .  $Judgefullname . "' and `Judgassistant`='" . $JudgeAssistantfullname . "' and `Hearingsite`='" . $Courtlocationname . "' and `Hearingtime`='" . $hearingtime . "' and Castypegroup = '" . $casetypegroup[0] . "'";
    	//	$countofcases=0;
    	$dateflag=0;
    	$cutoffnoofdays=0;
    	 
    	do
    	{
    
    	if ($dateflag==0)
    	{
    	//	SELECT * FROM test.cuttoffdate where casetypeid=612;
    	$sql91="SELECT * FROM `cuttoffdate` where `casetypeid`= " .  $casetypeid;
    
    	//$sql8="SELECT * FROM `schedule` where `Calendarid`= '" .  $Calendarid . "' and `cutoffdate` > = CURDATE()";
    
    				$statement91=$db->createStatement($sql91);
        				$result91= $statement91->execute();
    
        				if ($result91 instanceof ResultInterface && $result91->isQueryResult())
        				{
        				$resultSet91 = new ResultSet;
        				$resultSet91->initialize($result91);
        				//type : 'options', value : 1, text : 'Aaaaa, Aaa'
        				//	$i=0;
        				foreach ($resultSet91 as $row) {
    
        					$cutoffnoofdays=$row->numberofdays;
        					//	$i = $i +1;
        				}// end of for loop
    
        				}//end of if loop
        				/*	$Date = "2010-09-17";
        				echo date('Y-m-d', strtotime($Date. ' + 1 days'));
        				echo date('Y-m-d', strtotime($Date. ' + 2 days'));  */
        					
        				$strdate=date("Y-m-d");
        				$Cutoffdate=date('Y-m-d', strtotime($strdate . ' + ' . $cutoffnoofdays . ' days'));
    
    
        				//	$Cutoffdate="2015-05-01";
        				}
        				else
        				{
        				$Cutoffdate=$Hearingdate;
    	}
    
    			$dateflag=$dateflag+1;
    
    			//SELECT MIN(hearingdate) as earliestdate FROM test.schedule where Calendarid=55 and cutoffdate >= CURDATE();
    
    	$sql8="SELECT MIN(hearingdate) as 'earliestdate12' FROM `schedule` where `Calendarid`= '" .  $Calendarid[0] . "' and `cutoffdate` >='" . $Cutoffdate . "'";
    
    	//$sql8="SELECT * FROM `schedule` where `Calendarid`= '" .  $Calendarid . "' and `cutoffdate` > = CURDATE()";
    
    	$statement8=$db->createStatement($sql8);
    			$result8= $statement8->execute();
    
        			if ($result8 instanceof ResultInterface && $result8->isQueryResult())
        			{
        			$resultSet8 = new ResultSet;
        			$resultSet8->initialize($result8);
        			//type : 'options', value : 1, text : 'Aaaaa, Aaa'
        			$i=0;
        			foreach ($resultSet8 as $row) {
    
        			$Hearingdate=$row->earliestdate12;
        			$i = $i +1;
    	}// end of for loop
    		
    	}//end of if loop
    
    	$sql18="SELECT count(*) as countofcases FROM docket where judge='" .  $Judgefullname . "' and hearingtime='" . $htime . "' and Judgeassistant='" . $JudgeAssistantfullname . "' and Hearingsite='" . $Courtlocationname . "' and casetype = '" . $casecode . "' and county = '" .  $countydesc . "' and hearingdate='". $Hearingdate . "'";
    
        			$statement18=$db->createStatement($sql18);
    			$result18= $statement18->execute();
    
    			if ($result18 instanceof ResultInterface && $result18->isQueryResult())
        				{
    				$resultSet18 = new ResultSet;
    				$resultSet18->initialize($result18);
        						//type : 'options', value : 1, text : 'Aaaaa, Aaa'
        						$i=0;
        						foreach ($resultSet18 as $row) {
    
        						$countofcases=$row->countofcases;
        						$i = $i +1;
    }// end of for loop
    	
    }//end of if loop
    
    } while(($countofcases > $noofcases[0]) and ($noofcases[0]!=0));
    
    
    
    /*	$post_data = array('Judgeid' => $Judgeid,
    'JudgeAssistantID' => $JudgeAssistantID,
    'courtlocationid' => $courtlocationid,
    'hearingtime' => $hearingtime,
    'hearingdate' => $Hearingdate );  */
    
    	// DOCKET NUMBER GENERATION....
    
    	//	$db=$this->getServiceLocator()->get('db1');
    	$OsahDb=New OsahDbFunctions();
    	$others= "";
    	$hearingreqdate="";  // $this->params()->fromQuery('hearingreqdate');
    	$judgeassistant= $JudgeAssistantfullname;
    	 $judge= $Judgefullname;
    	$status= "Imported";
    	$hearingtime= $htime;
    	$hearingsite= $Courtlocationname;
    	$hearingmode= "In Person";
    	$county= $countydesc;
    	$countyno= $CountyID;
    	$casetype= $casecode;
    	$refagency= $ddsdps;  //$this->params()->fromQuery('refagency');
    	$datereceivedbyosah= date("Y-m-d");
    	$agencyrefnumber= $DLNo; //$this->params()->fromQuery('agencyrefnumber');
    	$hearingreqby= "Referring Agency";
    	$daterequested=date_format($PostmarkDt,"Y-m-d");
    	$hearingdate=$Hearingdate;
    	$docketclerk=trim($username);
    
    			if ($hearingdate == "")
    			{
    
    			$sql="INSERT INTO `docket` (`docketnumber`, `docketclerk`, `hearingreqby`, `status`, `daterequested`, `datereceivedbyOSAH`, `refagency`, `casetype`, `casefiletype`, `county`, `agencyrefnumber`, `hearingmode`, `hearingsite`, `hearingdate`, `hearingtime`, `judge`, `judgeassistant`, `hearingrequesteddate`, `others`) VALUES ('2222', '" . $docketclerk . "','". $hearingreqby ."', '" . $status . "', '".  $daterequested . "','" . $datereceivedbyosah. "','" . $refagency. "','" . $casetype. "', '','" . $county. "','" . $agencyrefnumber . "','" . $hearingmode. "','" . $hearingsite. "', NULL  ,'" . $hearingtime. "','" . $judge. "','" . $judgeassistant. "','" . $hearingreqdate. "','" . $others. "')";
    
    		}
    		else
    		{
    			$sql="INSERT INTO `docket` (`docketnumber`, `docketclerk`, `hearingreqby`, `status`, `daterequested`, `datereceivedbyOSAH`, `refagency`, `casetype`, `casefiletype`, `county`, `agencyrefnumber`, `hearingmode`, `hearingsite`, `hearingdate`, `hearingtime`, `judge`, `judgeassistant`, `hearingrequesteddate`, `others`) VALUES ('2222', '" . $docketclerk . "','". $hearingreqby ."', '" . $status . "', '".  $daterequested . "','" . $datereceivedbyosah. "','" . $refagency. "','" . $casetype. "', '','" . $county. "','" . $agencyrefnumber . "','" . $hearingmode. "','" . $hearingsite. "','" . $hearingdate. "','" . $hearingtime. "','" . $judge. "','" . $judgeassistant. "','" . $hearingreqdate. "','" . $others. "')";
    		}
    			//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    
    			//$sql='SELECT * FROM `casetypes` where `AgencyID`='.$id;
    			$statement=$db->createStatement($sql);
    			$result = $statement->execute();
    
        					$sql1="SELECT LAST_INSERT_ID() as new_id";
        					$statement1=$db->createStatement($sql1);
        					$result1 = $statement1->execute();
        					$docket="t";
        					//$t1=$db->lastInsertId();
        					//$docket = $db->lastInsertValue;
        					if ($result1 instanceof ResultInterface && $result1->isQueryResult())
        					{
        					$resultSet1 = new ResultSet;
    			$resultSet1->initialize($result1);
    
    			$i=0;
    			foreach ($resultSet1 as $row) {
    
    			$docket=$row->new_id;
    
    			//			$arraylist=$arraylist."{id :".$row->Casetypeid .", name : '". $row->CaseCode . "'}+" ;
    }// end of for loop
    			// console.log("i am here... do i");
    				//$docket="test";
    
    
    }
    
    /*var judgefullname=dijit.byId('judge').get('displayedValue');
    judgelastname=judgefullname.substr(0, judgefullname.indexOf(' '));
    	dockettext=dijit.byId('refagency').get('displayedValue') + "-" + dijit.byId('casetype').get('displayedValue') + "-" + t + "-" + dijit.byId('county').get('value') + "-" + judgelastname;
    	dojo.byId("availabilityNode").value="done" + dockettext ;
    	document.getElementById("docketinfo").innerHTML=dockettext; */
    	//update test.docket set docketnumber="test" where caseid = '1normal001';
        				$judgename=explode(" ", $judge);
        				$dockettext1 = $refagency . "-" . $casetype . "-" . $docket . "-" . $countyno . "-" . $judgename[0];
    
        				//$dockettext1="test";
    
        				$sql2="update docket set docketnumber='" . $dockettext1 . "' where caseid = '" . $docket . "'";
        				 
        				$statement2=$db->createStatement($sql2);
        				$result2 = $statement2->execute();
    
        				//   $arrayliststr=$OsahDb->getCaseTypes($db, $t);
        				//  $jsonResponse = json_encode($arrayliststr);
        				//	$response = $this->getResponse();
        				//	$response->setStatusCode(200);
        				//  $response->setContent(json_encode($data));
        				//	$response->setContent($docket);
    
        				//	$headers = $response->getHeaders();
        						//	$headers->addHeaderLine('Content-Type', 'application/text');
    
        						 
    
        						// DOCKET NUMBER GENERATION - CODE END....
    
    
        						return $docket;
    }
    
    public function ImportDDSMapping($CountyID, $Casetype)
    {
    
        		$db=$this->getServiceLocator()->get('db1');
        		$countyid= intval($CountyID);
        		$casetypeid= intval($Casetype);
    
        		//SELECT * FROM judgescountymaping where Casetypeid=561 and CountyID=67;
        		$OsahDb=New OsahDbFunctions();
    	$casecode=$OsahDb->getCaseTypeCodeDesc($db,$casetypeid);
    	$countydesc=$OsahDb->getCountyCode($db,$countyid);
    
    	$sql="SELECT * FROM `judgescountymaping` where `Casetypeid`= " .  $casetypeid . " and `CountyID`= " . $countyid;
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    
    	$JudgeAssistantID="";
    	$Judgeid="";
    	$courtlocationid="";
    	$hearingtime="";
    	$Hearingdate="";
    
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    	$resultSet = new ResultSet;
    	$resultSet->initialize($result);
    //type : 'options', value : 1, text : 'Aaaaa, Aaa'
    $i=0;
    foreach ($resultSet as $row) {
    
    $JudgeAssistantID=$row->JudgeAssistantID;
    $Judgeid=$row->Judgeid;
    $courtlocationid=$row->courtlocationid;
    $hearingtime=$row->hearingtime;
    
    $i = $i +1;
    	}// end of for loop
    
    	//	return array($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    
    
    	}//end of if loop
    
    			//return $sql;
    
    
    			$sql2=" i am the tester";
    			$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//  $response->setContent(json_encode($data));
    	//	$response->setContent($JudgeAssistantID, $Judgeid, $courtlocationid, $hearingtime);
    	//  $tester=array($JudgeAssistantID, $Judgeid);
    	//$response->setContent($tester);
    
    
    	//  HEARIND DATE CODE -  MODULE  BEGIN HERE
    	//	SELECT * FROM test.unified_cases where casetypeid=510;
    	$sql3="SELECT * FROM `unified_cases` where `casetypeid`= " .  $casetypeid;
    	$statement3=$db->createStatement($sql3);
    	$result3 = $statement3->execute();
    	$casetypegroup1="";
    	if ($result3 instanceof ResultInterface && $result3->isQueryResult())
    	{
    	$resultSet3 = new ResultSet;
    	$resultSet3->initialize($result3);
    	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    	$i=0;
    	foreach ($resultSet3 as $row) {
    
    	$casetypegroup[$i]=$row->casetypegroup;
    	$i = $i +1;
    	}// end of for loop
    	$casetypegroup1= $casetypegroup[0];
    	}//end of if loop
    
    	$Judgefullname="";
    	$JudgeAssistantfullname="";
    	$Courtlocationname="";
    
    	// JUDGE NAME CODE
    	$sql4="SELECT * FROM `judges` where `Judgeid`= " .  $Judgeid;
    	$statement4=$db->createStatement($sql4);
    	$result4 = $statement4->execute();
    
    	if ($result4 instanceof ResultInterface && $result4->isQueryResult())
    	{
    	$resultSet4 = new ResultSet;
    	$resultSet4->initialize($result4);
    	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet4 as $row) {
    
        		$Judgefullname=$row->LastName . " " . $row->FirstName;
        		$i = $i +1;
    	}// end of for loop
    	 
    	}//end of if loop
    
    
    	// JUDGE ASSISTANT NAME CODE
    	$sql5="SELECT * FROM `judgeassistant` where `JudgeAssistantID`= " .  $JudgeAssistantID;
    	$statement5=$db->createStatement($sql5);
    	$result5 = $statement5->execute();
    
    	if ($result5 instanceof ResultInterface && $result5->isQueryResult())
    	{
    	$resultSet5 = new ResultSet;
    	$resultSet5->initialize($result5);
    //type : 'options', value : 1, text : 'Aaaaa, Aaa'
    $i=0;
    foreach ($resultSet5 as $row) {
    
    $JudgeAssistantfullname=$row->LastName . " " . $row->FirstName;
    $i = $i +1;
    	}// end of for loop
    	 
    	}//end of if loop
    
    
    	// COURT LOCATION NAME
        	$sql6="SELECT * FROM `courtlocations` where `courtlocationid`= " .  $courtlocationid;
        	$statement6=$db->createStatement($sql6);
        	$result6 = $statement6->execute();
    
        	if ($result6 instanceof ResultInterface && $result6->isQueryResult())
        	{
        	$resultSet6 = new ResultSet;
        	$resultSet6->initialize($result6);
        	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
        	$i=0;
        	foreach ($resultSet6 as $row) {
    
        	$Courtlocationname=$row->Locationname;
        	$i = $i +1;
    	}// end of for loop
    	 
    	}//end of if loop
    
    	//SELECT * FROM test.calendarform;
    
    	//SELECT * FROM test.calendarform where Judge ="malihi Michael" and Judgassistant="Parker Larry" and Hearingsite Like "OSAH%" and Hearingtime="1:00 AM";
    
    	// COURT LOCATION NAME
    	$i=0;
    	$length = count($casetypegroup);
    	$Calendarid[0]="";
    		$noofcases[0]=0;
    		for($i2=0;$i2 < $length; $i2++)
    		{
    
    		$casetypegrp=preg_replace( "/\r|\n/", "", $casetypegroup[$i2]);
    		$htime=preg_replace( "/\r|\n/", "", $hearingtime );
    		$sql7="SELECT * FROM calendarform where Judge='" .  $Judgefullname . "' and Hearingtime='" . $htime . "' and judgassistant='" . $JudgeAssistantfullname . "' and hearingsite='" . $Courtlocationname . "' and Castypegroup = '" . $casetypegrp . "'";
    
    
    
    			$statement7=$db->createStatement($sql7);
    		$result7= $statement7->execute();
    
    		if ($result7 instanceof ResultInterface && $result7->isQueryResult())
    		{
    		$resultSet7 = new ResultSet;
    		$resultSet7->initialize($result7);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet7 as $row) {
    
    		$Calendarid[$i]=$row->Calendarid;
    		$noofcases[$i]=$row->noofcases;
    			//	$i = $i +1;
    		}// end of for loop
    
    		}//end of if loop
    
    
    		}
    		//$sql7="SELECT * FROM `calendarform` where `Judge`= '" .  $Judgefullname . "' and `Judgassistant`='" . $JudgeAssistantfullname . "' and `Hearingsite`='" . $Courtlocationname . "' and `Hearingtime`='" . $hearingtime . "' and Castypegroup = '" . $casetypegroup[0] . "'";
    		//	$countofcases=0;
    		$dateflag=0;
    		$cutoffnoofdays=0;
    		do
    		{
    
    		if ($dateflag==0)
    		{
    		//	SELECT * FROM test.cuttoffdate where casetypeid=612;
    		$sql91="SELECT * FROM `cuttoffdate` where `casetypeid`= " .  $casetypeid;
    
    		//$sql8="SELECT * FROM `schedule` where `Calendarid`= '" .  $Calendarid . "' and `cutoffdate` > = CURDATE()";
    
    		$statement91=$db->createStatement($sql91);
    				$result91= $statement91->execute();
    
        				if ($result91 instanceof ResultInterface && $result91->isQueryResult())
    		{
    		$resultSet91 = new ResultSet;
    		$resultSet91->initialize($result91);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		//	$i=0;
    		foreach ($resultSet91 as $row) {
    
    			$cutoffnoofdays=$row->numberofdays;
    			//	$i = $i +1;
    			}// end of for loop
    			 
    			}//end of if loop
    			/*	$Date = "2010-09-17";
    		echo date('Y-m-d', strtotime($Date. ' + 1 days'));
    		echo date('Y-m-d', strtotime($Date. ' + 2 days'));  */
    		 
    		$strdate=date("Y-m-d");
    		$Cutoffdate=date('Y-m-d', strtotime($strdate . ' + ' . $cutoffnoofdays . ' days'));
    
    
    		//	$Cutoffdate="2015-05-01";
    	}
    	else
    	{
    	$Cutoffdate=$Hearingdate;
    	}
    
    	$dateflag=$dateflag+1;
    
    	//SELECT MIN(hearingdate) as earliestdate FROM test.schedule where Calendarid=55 and cutoffdate >= CURDATE();
    		
    	$sql8="SELECT MIN(hearingdate) as 'earliestdate12' FROM `schedule` where `Calendarid`= '" .  $Calendarid[0] . "' and `cutoffdate` >='" . $Cutoffdate . "'";
    		
    	//$sql8="SELECT * FROM `schedule` where `Calendarid`= '" .  $Calendarid . "' and `cutoffdate` > = CURDATE()";
    			
    		$statement8=$db->createStatement($sql8);
    				$result8= $statement8->execute();
    			
    		if ($result8 instanceof ResultInterface && $result8->isQueryResult())
    		{
    		$resultSet8 = new ResultSet;
    		$resultSet8->initialize($result8);
    		//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    		$i=0;
    		foreach ($resultSet8 as $row) {
    
    		$Hearingdate=$row->earliestdate12;
    		$i = $i +1;
    		}// end of for loop
    		 
    		}//end of if loop
    
    		$sql18="SELECT count(*) as countofcases FROM docket where judge='" .  $Judgefullname . "' and hearingtime='" . $htime . "' and Judgeassistant='" . $JudgeAssistantfullname . "' and Hearingsite='" . $Courtlocationname . "' and casetype = '" . $casecode . "' and county = '" .  $countydesc . "' and hearingdate='". $Hearingdate . "'";
    
    		$statement18=$db->createStatement($sql18);
    		$result18= $statement18->execute();
    		 
    		if ($result18 instanceof ResultInterface && $result18->isQueryResult())
    		{
    			$resultSet18 = new ResultSet;
    			$resultSet18->initialize($result18);
    			//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    				$i=0;
    				foreach ($resultSet18 as $row) {
    
    				$countofcases=$row->countofcases;
    				$i = $i +1;
    	}// end of for loop
    	 
    	}//end of if loop
    	 
    	} while($countofcases > $noofcases[0]);
    
    	 
    	/*	$sql18="SELECT count(*) as 'countofcases' FROM `docket` where `hearingdate` = '" . $Hearingdate . "' ";
    			 
    	//$sql8="SELECT * FROM `schedule` where `Calendarid`= '" .  $Calendarid . "' and `cutoffdate` > = CURDATE()";
    
    	$statement8=$db->createStatement($sql18);
    	$result8= $statement8->execute();
    
    	if ($result8 instanceof ResultInterface && $result8->isQueryResult())
    	{
    	$resultSet8 = new ResultSet;
    	$resultSet8->initialize($result8);
    	//type : 'options', value : 1, text : 'Aaaaa, Aaa'
    	$i=0;
    		foreach ($resultSet8 as $row) {
    		 
    		$Hearingdate=$row->earliestdate12;
    		$i = $i +1;
    	}// end of for loop
    	 
    	}//end of if
    	*/
    	 
    	 
    	 
    	 
    	 
    	 
    	//  HEARIND DATE CODE -  MODULE  ENDS HERE
    		//$casetypegroup1="test";
    		 
    		/* 		$post_data = array('Judgeid' => $Judgeid,
    		'JudgeAssistantID' => $JudgeAssistantID,
    		'courtlocationid' => $courtlocationid,
        				'hearingtime' => $hearingtime,
            				'hearingdate' => $Hearingdate );
            				//	'hearingdate' => $Hearingdate );
            				 
        		$post_data = json_encode($post_data);
            				$response->setContent($post_data); */
            				//$response->setContent($JudgeAssistantID);
            				//   	$headers = $response->getHeaders();
            				// 	$headers->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
    
    
            				$response = $this->getResponse();
            					$response->setStatusCode(200);
            					//  $response->setContent(json_encode($data));
    		$response->setContent($Hearingdate);
    		 
    		//
    		$headers = $response->getHeaders();
    		$headers->addHeaderLine('Content-Type', 'application/text');
    
    		return $response;
            				}
            				
    
    public function mycasesAction()
    {
    	$this->isSessionActive();
    
    	$db=$this->serviceLocator->get('db1');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/mycases.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    }
    
    Public function searchcasesbyjudgeAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    	 
    	//	$vm = new ViewModel();
    	//	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	//	return $vm->setVariables(array('db'=>$db));
    	 
    	$t= $this->params()->fromQuery('judge');
    	 
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/searchcasesbyjudge.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 'judge'=>$t));
    }
    
    Public function searchcasesbyjudgeassistantAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	//	$vm = new ViewModel();
    	//	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	//	return $vm->setVariables(array('db'=>$db));
    
    	$t= $this->params()->fromQuery('judge');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/searchcasesbyjudgeassistant.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 'judge'=>$t));
    }
    
    
    Public function searchcasesbyvalueAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	//	$vm = new ViewModel();
    	//	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	//	return $vm->setVariables(array('db'=>$db));
    
    	$t= $this->params()->fromQuery('judge');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/searchcasesbyvalue.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 'judge'=>$t));
    }
    
    Public function searchcalendarbyjudgeAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    	
    //	$vm = new ViewModel();
    //	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    //	return $vm->setVariables(array('db'=>$db));
    	
    	$t= $this->params()->fromQuery('judge');
    	
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/searchcalendarbyjudge.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 'judge'=>$t));
    	
    }
    public function calendarbyjudgesAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    	 
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    	 
    }
    
    public function casesbyjudgesAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/casesbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    
    }
    
    public function casesbyjudgeassistantAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/casesbyjudgeassistant.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    }
    
    public function calendarreviewAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/calendarreview.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    }
    
    public function printlabelsAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/printlabels.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    }
    
public function CasesExportReportsAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/CasesExportReports.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));    
    }

     
 Public function CasesExportreportlistAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	//	$vm = new ViewModel();
    	//	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	//	return $vm->setVariables(array('db'=>$db));
    
    	$t= $this->params()->fromQuery('judge');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/CasesExportreportlist.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 'judge'=>$t));
    }
     public function DDSimportReportsAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/DDSimportReports.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));    
    }
    
    
    Public function DDSimportreportlistAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	//	$vm = new ViewModel();
    	//	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	//	return $vm->setVariables(array('db'=>$db));
    
    	$t= $this->params()->fromQuery('judge');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/DDSimportreportlist.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 'judge'=>$t));
    }
    Public function calendarreviewcasesAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	//	$vm = new ViewModel();
    	//	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	//	return $vm->setVariables(array('db'=>$db));
    
    	$t= $this->params()->fromQuery('judge');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/calendarreviewcases.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 'judge'=>$t));
    }


    /*  Name            : AMol s
        Date Created    : 2017-03-08
        Description     : printLabelesReviewAction To print the label
    */
    Public function printlabelsdocketAction(){
    	
        $param= json_decode(file_get_contents('php://input'),true);
         
        /* echo '<pre>';
        print_r($param); exit; */
        $this->isSessionActive();
        $db=$this->serviceLocator->get('db1');
        
        $OsahDb=New OsahDbFunctions();
    
        //$t= $param['printlbl_info']['caseid'];
             
        if(isset($param['printlbl_info']['labelnumber']) && $param['printlbl_info']['labelnumber']!='' && $param['printlbl_info']['labelnumber']!= '-1' )
            $numberid1=$param['printlbl_info']['labelnumber'];
        
        //Get The Clerk data
        $clerkdata ='';
        $main_condition="county != 'No County' and status !='Closed' and telv_o_five= '1'";
        if(isset($param['printlbl_info']['clerk_id']) && $param['printlbl_info']['clerk_id']!='' && $param['printlbl_info']['clerk_id']!= '0'){
            $condition="user_id=".$param['printlbl_info']['clerk_id'];
            $clerkdata = $OsahDb->getData($db,'judge_assistant_clerk',$condition,0);
            $clerk_name= substr($clerkdata[0]['FirstName'],0,1). $clerkdata[0]['LastName'];
            $clerk_name= strtolower($clerk_name);
            $main_condition.=" and docketclerk like '%{$clerk_name}%'"; 
        }
        if(isset($param['printlbl_info']['caseid']) && $param['printlbl_info']['caseid']!=''){
            $main_condition.=" and caseid=".$param['printlbl_info']['caseid'];   
        }
        if(isset($param['printlbl_info']['dateReceived']) && $param['printlbl_info']['dateReceived']!=''){
             
            $datereceivedbyOSAH= $param['printlbl_info']['dateReceived'];
            $main_condition.=" and datereceivedbyOSAH='{$datereceivedbyOSAH}'"; 
        }   
        
        
        
        /*echo '<pre>';
        //print_r($clerkdata);
        echo  $main_condition;
         exit;*/ 
        
        
        
        
        //THIS FUNCTION WILL GET IF EMAIL ADDRESS IS AVAILABLE.
    //  $respondentemails=$OsahDb->getRespondentEmailAddr($db, $t);
        
        
        $arraylist="";
        

        $post_data="";
        
        $docketnumber = "";
        $docketclerk  = "";
        $hearingreqby  = "";
        $status  = "";
        $daterequested  ="";
        $datereceivedbyOSAH  = "";
        $refagency  = "";
        $casetype  = "";
        $casefiletype  = "";
        $county  = "";
        $agencyrefnumber  = "";
        $hearingmode  = "";
        $hearingsite  = "";
        $hearingdate  = "";
        $hearingtime  = "";
        $judge  = "";
        $judgeassistant  = "";
        $hearingrequesteddate  = "";
        $others  = "";
        $PHPWord = new PHPWord();
        
        $filenamepath= $_SERVER['DOCUMENT_ROOT']."/../data/templates/labels.docx";
        
        $dirname="";
        $document = $PHPWord->loadTemplate($filenamepath);
        //echo "temp" . $filenamepath;
        $filedocname='labels.docx';
   
        $filename = $filedocname;
        
        $filename = tempnam(sys_get_temp_dir(), 'PHPWord');
       // echo $filename; exit;
       
       
        /* $sql='SELECT * FROM docket where ' . $t;
        $statement=$db->createStatement($sql);
        $result  = $statement->execute(); */
        
        $condition=$main_condition;
        $result_docket = $OsahDb->getData($db,'docket',$condition,0);
        $text12='';
        if(count($result_docket)> 0 && $result_docket!=''){
            /* $resultSet = new ResultSet;
            $resultSet->initialize($result); */
            //type : 'options', value : 1, text : 'Aaaaa, Aaa'
            $i=0;
            
            
            // Add row
            //$table->addRow(900);
            $text12="<w:tbl><w:tblPr><w:tblStyle w:val=\"TableGrid\"/><w:tblW w:w=\"0\" w:type=\"auto\"/>" .
            "<w:tblBorders><w:top w:val=\"none\" w:sz=\"0\" w:space=\"0\" w:color=\"auto\"/>" .
            "<w:left w:val=\"none\" w:sz=\"0\" w:space=\"0\" w:color=\"auto\"/>" .
            "<w:bottom w:val=\"none\" w:sz=\"0\" w:space=\"0\" w:color=\"auto\"/>" .
            "<w:right w:val=\"none\" w:sz=\"0\" w:space=\"0\" w:color=\"auto\"/>" .
            "<w:insideH w:val=\"none\" w:sz=\"0\" w:space=\"0\" w:color=\"auto\"/>" .
            "<w:insideV w:val=\"none\" w:sz=\"0\" w:space=\"0\" w:color=\"auto\"/></w:tblBorders>".             
            "<w:tblLayout w:type=\"fixed\"/><w:tblCellMar><w:left w:w=\"15\" w:type=\"dxa\"/>" .
            "<w:right w:w=\"15\" w:type=\"dxa\"/></w:tblCellMar>" .
            "<w:tblLook w:val=\"0000\" w:firstRow=\"0\" w:lastRow=\"0\" w:firstColumn=\"0\" w:lastColumn=\"0\" w:noHBand=\"0\" w:noVBand=\"0\"/></w:tblPr>" .

            "<w:tblGrid><w:gridCol w:w=\"3880\"/><w:gridCol w:w=\"180\"/><w:gridCol w:w=\"3880\"/><w:gridCol w:w=\"180\"/><w:gridCol w:w=\"3880\"/>" .
            "</w:tblGrid><w:tr><w:trPr><w:trHeight w:val=\"1440\"/></w:trPr>";
            if( $numberid1 != 0){
                $i=0; $jk=0;
                for($ik=0; $ik<$numberid1; $ik++){
                    if ( ($ik%3) == 0){
                        if($ik!=0){
                            $text12 = $text12 ."</w:tr><w:tr><w:trPr><w:trHeight w:val=\"1440\"/></w:trPr>";
                            $jk=0;
                        }
                    
                    }
                    $text12 = $text12 . "<w:tc><w:tcPr><w:tcW w:w=\"3880\" w:type=\"dxa\"/></w:tcPr><w:p><w:r>" .
                        "<w:t><w:br/></w:t></w:r></w:p></w:tc>";
                 
                    if($jk !=2){
                        $text12 = $text12 . "<w:tc><w:tcPr><w:tcW w:w=\"180\" w:type=\"dxa\"/></w:tcPr><w:p><w:pPr><w:spacing w:before=\"111\"/><w:ind w:left=\"95\" w:right=\"95\"/></w:pPr><w:r>" .
                            "<w:t></w:t></w:r></w:p></w:tc>";
                    }
                    $jk=$jk +1;
                }
                
                if ( ($jk%3) == 0){
                    if($jk!=0){
                        $text12= $text12 ."</w:tr><w:tr><w:trPr><w:trHeight w:val=\"1440\"/></w:trPr>";
                        $jk=0;
                    }
                }
                else{
                    
                    if ( ($jk%3) == 1){ $jk=1;}
                    else if (($jk%3) == 2){ $jk=2; }
                    $i=$ik;
                }
                
            }
            $jk=0;
    
            foreach ($result_docket as $row) {
                
                $caseid = $row['caseid'];
                $testP=$OsahDb->getPetitionerLabel($db, $caseid);
                if ( ($i%3) == 0){
                    if($i!=0){
                        $text12= $text12 ."</w:tr><w:tr><w:trPr><w:trHeight w:val=\"1440\"/></w:trPr>";
                        $jk=0;
                    }
                    else{
                        
                    
                    }
                    //  $table->addRow();
                }
                
                $Respondentfirstname=$OsahDb->getRespondentLabel($db, $caseid);
                
                $docnumdetail=explode('-',$row['docketnumber']);
                $docketnumber =  $docnumdetail[2].'-'.$docnumdetail[0].'-'.$docnumdetail[1].'-'.$docnumdetail[3].'-'.$docnumdetail[4];
                
                $docketclerk  = $row['docketclerk'];
                $county  = $row['county'];
                    
                if ($testP == ""){
                    $testP=$Respondentfirstname;
                }
                    
                $text1=strtoupper($testP) . "<w:br/>" . str_replace("\\","",$docketnumber) . "<w:br/>" . $county;
            
                $text12 = $text12 . "<w:tc><w:tcPr><w:tcW w:w=\"3880\" w:type=\"dxa\"/></w:tcPr><w:p><w:r>" .
                "<w:t>" .  $text1 . "</w:t></w:r></w:p></w:tc>";
                
                if($jk !=2){
                    $text12 = $text12 . "<w:tc><w:tcPr><w:tcW w:w=\"180\" w:type=\"dxa\"/></w:tcPr><w:p><w:pPr><w:spacing w:before=\"111\"/><w:ind w:left=\"95\" w:right=\"95\"/></w:pPr><w:r>" .
                        "<w:t></w:t></w:r></w:p></w:tc>";
                }
                    
                $i = $i +1;
                $jk=$jk +1;
                $testP="";
                $Respondentfirstname="";
            }// end of for loop
            
        }//end of if loop
        else{

            $return_array['status_doc']='2';
            echo json_encode($return_array);
            exit();
        } 
        $text12 = $text12 . "</w:tr></w:tbl>";
        //echo "<pre>";
        //    echo  $text12; exit;
        $document->setValue('Value905', $text12);
        
        
        $document->save($filename);
        
     
        $filename_withPath="";
        $file_path = $_SERVER['DOCUMENT_ROOT']."/../data/printlabels/"; 
        //$file_path = "D:/wamp/www/osahnewloc/data/printlabels/"; 
        $filename_final ="labels_" . date("Y-m-d_H-is",time()). ".docx";
        $str = str_replace("-","amo",$filename_final);
        $passfile_name = str_replace(".","shr",$str);
        $filename_withPath = $file_path.$filename_final;
        copy($filename, $filename_withPath);
            
            if(file_exists($filename_withPath)){
                
             $return_array['filenames']=$passfile_name; 
             $return_array['status_doc']='1'; 
             echo json_encode($return_array);
                exit();
            }else{
                $return_array['status_doc']='0';
                echo json_encode($return_array);
                exit();
            }
                             
        /*    
        
        $path = $_SERVER['DOCUMENT_ROOT']."/../data/templates/printlabels/";
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ((time()-filectime($path.$file)) > 86400) {
                    if (preg_match('/\.docx$/i', $file)) {
                        unlink($path.$file);
                    }
                }
            }
        }*/
       
         
    }
    
    /*  Name            : AMol s
        Date Created    : 2017-04-21
        Description     : Download the print lable created file
    */
    public function downloadprintlabelfileAction(){

        $id = $this->params()->fromRoute('id'); 
        $str = str_replace("amo","-",$id);
        $filename_final = str_replace("shr",".",$str);

        $path = $_SERVER['DOCUMENT_ROOT']."/../data/printlabels/";
        /*if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ((time()-filectime($path.$file)) > 86400) {
                    if (preg_match('/\.docx$/i', $file)) {
                        unlink($path.$file);
                    }
                }

                $filename_final=$file;
            }
        }*/
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header('Content-Disposition: inline; filename="' . basename($filename_final) . '"');
        header("Content-Description: File Transfer");
        header("Content-Transfer-Encoding: binary");
        header("Content-type: application/octet-stream");
        ob_end_flush();
        @readfile($_SERVER['DOCUMENT_ROOT']."/../data/printlabels/".$filename_final);

        
         
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ((time()-filectime($path.$file)) > 86400) {
                    if (preg_match('/\.docx$/i', $file)) {
                        unlink($path.$file);
                    }
                }

            }
        }
        exit;
    }


    
    //calendarreviewcases
    
    public function searchAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/search.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    
    }
    
    Public function searchcalendarbyjudgeassistantAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    	 
    	//	$vm = new ViewModel();
    	//	$vm->setTemplate('Osahform/Osahform/calendarbyjudges.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	//	return $vm->setVariables(array('db'=>$db));
    	 
    	$t= $this->params()->fromQuery('judgeassistant');
    	 
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/searchcalendarbyjudgeassistant.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 'judgeassistant'=>$t));
    	 
    }
    
    public function calendarbyjudgeassistantsAction()
    {
    	$this->isSessionActive();
    	$db=$this->serviceLocator->get('db1');
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/calendarbyjudgeassistants.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db));
    
    }
    
    public function allcalendarformsAction()
     {
     	$this->isSessionActive();
     	$db=$this->serviceLocator->get('db1');
     	
     	$vm = new ViewModel();
     	$vm->setTemplate('Osahform/Osahform/allcalendarforms.phtml');
     	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
     	return $vm->setVariables(array('db'=>$db));
     	
     }
    public function newcalendarAction()
    {
    	$this->isSessionActive();
    	
    	$db=$this->serviceLocator->get('db1');
    	
    	$t= $this->params()->fromQuery('docketno');
    	//$t="13";
    	$ldapcon= new OsahLdapCon();
    	
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/newcalendar.phtml');
    	
    	return $vm->setVariables(array('db'=>$db, 't1234'=>$t));
    	
    }
    
    public function calendaronlyAction()
    {
    
    	$this->isSessionActive();
    
    	// AGENCY CODE LIST: BEGIN
    
    	$db=$this->serviceLocator->get('db1');
    	
    	$t="13";
    
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/newcalendar.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 't1234'=>$t));
    
    	
    }
    public function newformAction()
    {
        
        $this->isSessionActive();
        
        // AGENCY CODE LIST: BEGIN
        
        $db=$this->serviceLocator->get('db1');
    /*   return new ViewModel(array(
        		'agencycode' => $this->getAgencyTable()->fetchAll(),
        ));*/
        
        $t= $this->params()->fromQuery('docketno');
        // $t="13";
      /*  if( $t == null )
        {
            $t="";
        }*/
  //     $db=$this->getServiceLocator()->get('db1');
        $ldapcon= new OsahLdapCon();
     //   $obj=new OsahDbFun();
      //  $arraylist=$obj->getAgencyCode();
     //   $arraylist=$ldapcon->getAgencyCode($db);
       // $resultSet1=$this->getAgencyCode();
       // $arraylist="";
        //$resultSet1
      //  $i=0;
        
      //  $arraylist=  "<option value=". $i .">".  $i . "</option>" ;
     /* do  {
                
            $row=$resultSet1->current();
            $arraylist=  "<option value=".$row['AgencyId'] .">". $row['Agencycode'] . "</option>" ;
            $resultSet1->next();
            $i=$i+1;
        }While($resultSet1->valid()); */
        
       
        /* foreach ($resultSet as $row) {
        if($i == 0)
        {
        $arraylist=  "<option value=".$row->AgencyId .">". $row->Agencycode . "</option>" ;
        }
        else
        {
        $arraylist= $arraylist."," . "<option value=".$row->AgencyId .">". $row->Agencycode . "</option>" ;
        }
        $i = $i +1; 
        }// end of for loop */
        
        
        // AGENCY CODE LIST: ENDS
       // $ldapcon= new OsahLdapCon();
        
       //$obj=new OsahDbFunctions();
      //  $arraylist="";
  // $agencylist="<option>test3434</option>";
  //$agencylist="testeriam";
       $vm = new ViewModel();
        $vm->setTemplate('Osahform/Osahform/newform.phtml');
   //   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
        return $vm->setVariables(array('db'=>$db, 't1234'=>$t));
        
    //    return $vm->setVariables(array ('agencylist'=>$arraylist));
    	// This shows the :controller and :action parameters in default route
    	// are working when you browse to /osahform/osahform/foo
    	//return array();
    }
    
    
    public function onlyformAction()
    {
    
    	$this->isSessionActive();
    
    	// AGENCY CODE LIST: BEGIN
    
    	$db=$this->serviceLocator->get('db1');
    	/*   return new ViewModel(array(
    	 'agencycode' => $this->getAgencyTable()->fetchAll(),
    	));*/
    
    	//$t= $this->params()->fromQuery('docketno');
    	// $t="13";
    	/*  if( $t == null )
    	 {
    	$t="";
    	}*/
    	//     $db=$this->getServiceLocator()->get('db1');
    	$ldapcon= new OsahLdapCon();
    	//   $obj=new OsahDbFun();
    	//  $arraylist=$obj->getAgencyCode();
    	//   $arraylist=$ldapcon->getAgencyCode($db);
    	// $resultSet1=$this->getAgencyCode();
    	// $arraylist="";
    	//$resultSet1
    	//  $i=0;
    
    	//  $arraylist=  "<option value=". $i .">".  $i . "</option>" ;
    	/* do  {
    
    	$row=$resultSet1->current();
    	$arraylist=  "<option value=".$row['AgencyId'] .">". $row['Agencycode'] . "</option>" ;
    	$resultSet1->next();
    	$i=$i+1;
    	}While($resultSet1->valid()); */
    
      
    	/* foreach ($resultSet as $row) {
    	 if($i == 0)
    	 {
    	$arraylist=  "<option value=".$row->AgencyId .">". $row->Agencycode . "</option>" ;
    	}
    	else
    	{
    	$arraylist= $arraylist."," . "<option value=".$row->AgencyId .">". $row->Agencycode . "</option>" ;
    	}
    	$i = $i +1;
    	}// end of for loop */
    
    $t="13";
    	// AGENCY CODE LIST: ENDS
    	// $ldapcon= new OsahLdapCon();
    
    	//$obj=new OsahDbFunctions();
    	//  $arraylist="";
    	// $agencylist="<option>test3434</option>";
    	//$agencylist="testeriam";
    	$vm = new ViewModel();
    	$vm->setTemplate('Osahform/Osahform/newform.phtml');
    	//   return $vm->setVariables(array('agencylist'=>$arraylist, 'db1'=>$db));
    	return $vm->setVariables(array('db'=>$db, 't1234'=>$t));
    
    	//    return $vm->setVariables(array ('agencylist'=>$arraylist));
    	// This shows the :controller and :action parameters in default route
    	// are working when you browse to /osahform/osahform/foo
    	//return array();
    }
    
    
    public function infologinAction()
    {
    	// This shows the :controller and :action parameters in default route
    	// are working when you browse to /osahform/osahform/foo
    	return array();
    }
    
    public function infologin1Action()
    {
    	// This shows the :controller and :action parameters in default route
    	// are working when you browse to /osahform/osahform/foo
    	return array();
    }
    
   public function validateinAction(){
     //// Code By Neha Start here
        $session = new Container('base');
        $param= json_decode(file_get_contents('php://input'),true); 
	  $uname = $param['username'];
 	    
	    $db=$this->serviceLocator->get('db1');
//	    foreach($array_data as $key=>$info ){
//		if($uname == $array_data[$key]['username']){
//		    $email_id = $array_data[$key]['email'];
//		}
//	    } 
	    $OsahDb=New OsahDbFunctions();
	    $condition="email = '$uname@osah.ga.gov'";
	    $result = $OsahDb->getData($db,'judge_assistant_clerk',$condition,0);
	    if($result!='' && !empty($result) && isset($result)){
		$session->FirstName = $result['0']["FirstName"];
		$session->LastName = $result['0']["LastName"];
		$session->email = $result['0']["email"];
		$session->user_type = $result['0']["user_type"];
		$session->user_name = $uname;
        unset($result['0']["phone"]); unset($result['0']["Fax"]);  unset($result['0']["email"]); 
        unset($result['0']["title"]); unset($result['0']["initials"]);
       

		//echo $session->user_type;
        echo json_encode($result);
	    }else{
		echo "false";
	    } 
	    exit;
   // Neha code ends Herer
    //Girish  code start here
  /**      
  if ($param){
               // echo "this is post request";

            // $username = $this->getRequest()->getPost('username');
            // $password = $this->getRequest()->getPost('password');
   // print_r($username);
   // print_r($password);exit;
   $uname = $param['username'];
   $pwd = $param['password'];
           $username ="gkambala";
           $password="Information1pwd23";
    
     if($uname==$username && $pwd==$password)
     {
            $ldapcon= new OsahLdapCon();
    
             $result=  $ldapcon->validateLogin($uname,$pwd);
        //test="something";
           $xy= $result->getMessages();
         //  $xt=$result['baseDn'][0];
           $xt=$result->getIdentity();//$result->getBaseDn();
           
         //  $_SESSION['username']=$result->getIdentity();
           
           
           
             if ($result->isValid())
                 {
                  $session = new Container('base');
                  $session->offsetSet('username', $xt);
                     $vm = new ViewModel();
                     $vm->setTemplate('Osahform/Osahform/index.phtml');
                     return $vm->setVariables(array('test'=>$xt));
             
                    //return $this->redirect()->toRoute('Osahform');
                  }else{
                    
    
                    $vm = new ViewModel(); 
                    $vm->setTemplate('Osahform/Osahform/index.phtml');
                     return $vm->setVariables(array('test'=>$xy[0]));
             
                    //return $this->redirect()->toRoute('Osahform&message=$test1');
                }
        }else{
           // return array();
	    echo"false";exit;
        }
	}
	**/
	
//Girish  code End here	    
    }
    
    public function validateLoginAction(){
      
   return array();
      // return new ViewModel(array(
        //   'results1' => $test,
         //));
      // $_SESSION['results1']= $result;
     /* If($result)
      {
            return $this->redirect()->toRoute('Osahform');
      }
      else
      {
     return $this->redirect()->toRoute('Osahform/infologin');
      }*/
        
    }
	
	
/*  
	Created By : Irfan S.
	Created on : Sep 27, 2016
	Modified On: Nov 3, 2016
	
	Purpose: Api Request for Osah website

	#####Starts Here

 */
	
	public function getjudgesAction(){
  
		  error_reporting(0);
		  $isValid = $this->validatetoken();
		  
		  if($isValid == "true"){
			  
			  $ldapcon1= new OsahDbFunctions();
			  
			  $db=$this->serviceLocator->get('db1');
			   $result = $ldapcon1->getData($db,'judges','Judgeid!=0 order by LastName ASC',0);
			   //echo "on Judges"; exit;
			  echo json_encode($result);
		  }
		  else{
			http_response_code(404);
			$arrError = array("Error" => "Something went wrong! Please check the token or values supplied.");
			echo json_encode($arrError);
		}
		  $this->_helper->viewRenderer->setNoRender(true);
		  $this->_helper->layout->disableLayout();
  
    }
 
    public function getcountiesAction(){
		
		error_reporting(0);
		$isValid = $this->validatetoken();
		if($isValid == "true"){
			$ldapcon1= new OsahDbFunctions();
			$db=$this->serviceLocator->get('db1');
			$counties=$ldapcon1->getData($db,'county','CountyID!=0',0);

			echo json_encode($counties);
		}
		else{
			http_response_code(404);
			$arrError = array("Error" => "Something went wrong! Please check the token or values supplied.");
			echo json_encode($arrError);
		}
		
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
	
   }
 
     public function getagenciesAction(){
    
	    error_reporting(0);
		
		$isValid = $this->validatetoken();
		if($isValid == "true"){
			
			$ldapcon1 = new OsahDbFunctions();
			$db=$this->serviceLocator->get('db1');
			
			$agencies=$ldapcon1->getData($db,'agency','AgencyID!=0 order by Agencycode ASC',0);
			
			echo json_encode($agencies);
			
		}
		else{
			http_response_code(404);
			$arrError = array("Error" => "Something went wrong! Please check the token or values supplied.");
			echo json_encode($arrError);
		}
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
	}
	
    public function getdocketinfoAction(){
        //error_reporting(1);
        ///echo "hererer"; exit;
        $docketdata = array();
        $output=array();
        $Record_count='';
        $isValid = $this->validatetoken();
        if($isValid == "true"){
        //if(1==1){


            $ldapcon1 = new OsahDbFunctions();
            $db=$this->serviceLocator->get('db1');
            
            $docketnumber       = $this->getRequest()->getPost('docketno');
            $fname              = $this->getRequest()->getPost('fname');
            $lname              = $this->getRequest()->getPost('lname');
            $hearingdateFrom    = $this->getRequest()->getPost('hearingdateFrom');
            $hearingdateTo      = $this->getRequest()->getPost('hearingdateTo');
            $county             = $this->getRequest()->getPost('county');
            $judge              = $this->getRequest()->getPost('judge');
            $agency             = $this->getRequest()->getPost('agency');

            /*$docketnumber       = "";
            $fname              = "BARRY";
            $lname              = "COKER";
            $hearingdateFrom    = "";
            $hearingdateTo      = "";
            $county             = "";
            $judge              = "";
            $agency             = "";*/

            $order=$this->getRequest()->getPost('order'); //asc-desc
            $orderBy=$this->getRequest()->getPost('orderby'); //field name
            $start=$this->getRequest()->getPost('start');  //ofset or limit or starting record no
            $perpage=$this->getRequest()->getPost('perpage');//Per Page Resords
            $order=($order=='')?'asc':$order;
            $orderBy=( $orderBy=='')?0:$orderBy;
            //echo "Herererere".$order."/".$orderBy."/".$start."/".$perpage; exit;
            // If the docket# was supplied it should return single record
            if(isset($docketnumber) && $docketnumber!='' ){
                $sqlJoin="select doc.caseid,doc.docketnumber,doc.docketclerk,doc.hearingreqby,REPLACE(doc.status,'Hearing Re-scheduled','Rescheduled') AS status,
                doc.daterequested,doc.datereceivedbyOSAH,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,doc.refagency,doc.casetype,doc.casefiletype,doc.county,doc.agencyrefnumber,doc.hearingmode,doc.hearingsite,doc.hearingdate,
                DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,doc.hearingtime,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.judge,doc.judgeassistant,doc.hearingrequesteddate,doc.others,doc.docket_createddate from
                docket as doc  where CONCAT(doc.refagency,'-',doc.casetype) NOT IN(SELECT CONCAT(agencycode,'-',casecode) AS pacs FROM pacases WHERE display='N') and doc.caseid={$docketnumber}";

                  $docket_data = $ldapcon1->getDatabySql($db,$sqlJoin);
                 
                  $caseids = $docket_data[0]['caseid'];
                
                $sql_peopledetail="select caseid,typeofcontact,Lastname,Firstname,peopleid,Middlename,Address1,Address2,City,State,Zip,Email,Phone,fax,Title,Company from peopledetails where caseid IN({$caseids})";

                $people_data = $ldapcon1->getDatabySql($db,$sql_peopledetail);

                $sql_agencyWorker="select caseid,Lastname as SR_LastName,Firstname as SR_Firstname from agencycaseworkerbycase where caseid IN({$caseids})";

                $agency_data = $ldapcon1->getDatabySql($db,$sql_agencyWorker);

                $sql_atorny="select caseid,Lastname as AT_LastName,Firstname as AT_Firstname from attorneybycase where caseid IN({$caseids})";

                $atorny_data = $ldapcon1->getDatabySql($db,$sql_atorny);
                 $judgassistant='';
                 $i=0;
                foreach ( $docket_data as $docketdata) {
                    foreach ($people_data as $peopleData) {
                        
                        if($peopleData['caseid']==$docketdata['caseid'] && $peopleData['caseid']!='' && $docketdata['caseid']!=''){
                         
                                $docketdata['typeofcontact']=$peopleData['typeofcontact'];
                                $docketdata['Lastname']=$peopleData['Lastname'];
                                $docketdata['Firstname']=$peopleData['Firstname'];
                                $docketdata['peopleid']=$peopleData['peopleid'];
                                $docketdata['Middlename']=$peopleData['Middlename'];
                                $docketdata['Address1']=$peopleData['Address1'];
                                $docketdata['Address2']=$peopleData['Address2'];
                                $docketdata['City']=$peopleData['City'];
                                $docketdata['State']=$peopleData['State'];
                                $docketdata['Zip']=$peopleData['Zip'];
                                $docketdata['Email']=$peopleData['Email'];
                                $docketdata['Phone']=$peopleData['Phone'];
                                $docketdata['fax']=$peopleData['fax'];
                                $docketdata['Title']=$peopleData['Title'];
                                $docketdata['Company']=$peopleData['Company'];
                        }
                         

                         
                    }
                    foreach ($agency_data as $agencyData) {

                        if($agencyData['caseid']==$docketdata['caseid'] && $agencyData['caseid']!='' && $docketdata['caseid']!=''){
                         
                                $docketdata['SR_LastName']=$agencyData['SR_LastName'];
                                $docketdata['SR_Firstname']=$agencyData['SR_Firstname'];
                                                       
                        }


                    }
                    foreach ($atorny_data as $atornyData) {
                        if($atornyData['caseid']==$docketdata['caseid'] && $atornyData['caseid']!='' && $docketdata['caseid']!=''){
                         
                                $docketdata['AT_Firstname']=$atornyData['AT_Firstname'];
                                $docketdata['AT_LastName']=$atornyData['AT_LastName'];
                                                       
                        }
                    }
                     $judgassistant= $docketdata['judgeassistant'];
            $i++;
                                          
                                $output['docketdata'][]=$docketdata; 
                               // var_dump($docketdata); exit;
                }
                $sql_judgeass="select * FROM `judgeassistant` WHERE CONCAT(LastName,' ',FirstName) ='{$judgassistant}'";
                //echo $sql_judgeass; exit;
                 $output['judgassistant'][]= $ldapcon1->getDatabySql($db,$sql_judgeass); 

                $output['recnt']['record_counts']=(count($docket_data)>0)?1:0;
                $docketInfo = $output;

            }else{
                // If the docket# was NOT supplied it should check for other parameters and return single/multiple record(s)

                $filter = array();
                $condition="";
                $filter_name = array();

                if ($hearingdateFrom != '')
                { $filter[] = 'hearingdate >= "'.$hearingdateFrom.'"';}
                if ($hearingdateTo != '')
                { $filter[] = 'hearingdate <= "'.$hearingdateTo.'"';}
                if ($county != '')
                { $filter[] = 'county = "'.$county.'"';}
                if ($judge != '')
                { $filter[] = 'judge = "'.$judge.'"';}
                if ($agency != '')
                { $filter[] = 'refagency = "'.$agency.'"';}
                                
                $clause_others = implode(' AND ', $filter);

                 $clause_others =($clause_others!='')?$clause_others:"";
                  // echo $clause_others; exit;

                
                if ($fname != '')
                { $filter_name[] = 'FirstName = "'.$fname.'"';}
                if ($lname != '')
                { $filter_name[] = 'LastName = "'.$lname.'"';}
                 $clause = implode(' AND ', $filter_name);
                   // echo $clause; exit;
                if($clause!=''){
                    
                    $pagination=($orderBy==0)?" ORDER BY caseid {$order}":"";
                    $sql="select * from agencycaseworkerbycase where ".$clause." AND (typeofcontact='Case Worker' or typeofcontact='Officer') {$pagination}"." LIMIT {$perpage} OFFSET {$start}";
                    //echo $sql; exit;
                    $sqlcount="select COUNT(*)AS reccont from agencycaseworkerbycase where ".$clause." AND (typeofcontact='Case Worker' or typeofcontact='Officer')";
                    $Record_count= $ldapcon1->getDatabySql($db,$sqlcount); 
                    $Record_count=$Record_count[0]['reccont'];
                    $details_people = $ldapcon1->getDatabySql($db,$sql);
                    $officer_caseworker_petitioner="";
                    if(count($details_people)>0){
                         $officer_caseworker_petitioner = $details_people;

                    }else{
                        $pagination=($orderBy==0)?" ORDER BY caseid {$order}":"";
                        $filter_name[] = 'typeofcontact = "Petitioner"';
                        $clause = implode(' AND ', $filter_name);   
                        $sql="select * from peopledetails where ".$clause.$pagination." LIMIT {$perpage} OFFSET {$start}";
                        $officer_caseworker_petitioner = $ldapcon1->getDatabySql($db,$sql); 
                        $sqlcount="select COUNT(*)AS reccont from peopledetails where ".$clause;
                        $Record_count= $ldapcon1->getDatabySql($db,$sqlcount); 
                        $Record_count=$Record_count[0]['reccont'];

                    }
                    $caseids="";

                    $condition="";
                    //echo count($officer_caseworker_petitioner); exit;
                    if(count($officer_caseworker_petitioner)>0){

                        $i=0;
                        foreach ( $officer_caseworker_petitioner as $data) {
                            $caseids.=($i==0)?$data['caseid']:','.$data['caseid'];

                        $i++;
                        }
                       $condition =" caseid IN($caseids)"; 
                     } 

                } 

                    $clause_others=($condition!='' && $clause_others!='')?" And ". $clause_others: $clause_others;
                        $clause_pagination="";
                        if($clause==''){
                            switch($orderBy){
                                case 0:
                                    $clause_pagination= " ORDER BY caseid {$order} LIMIT {$perpage} OFFSET {$start}";
                                break;
                                
                                case 2:
                                    $clause_pagination= " ORDER BY hearingdate {$order} LIMIT {$perpage} OFFSET {$start}";
                                break;

                                case 5:
                                  $clause_pagination= " ORDER BY casetype {$order} LIMIT {$perpage} OFFSET {$start}";
                                break;
                            }   
                        }
                        $sqlJoin="select caseid,docketnumber,docketclerk,hearingreqby,REPLACE(status,'Hearing Re-scheduled','Rescheduled') AS status,
                        daterequested,datereceivedbyOSAH,DATE_FORMAT(datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,refagency,casetype,casefiletype,county,agencyrefnumber,hearingmode,hearingsite,hearingdate,
                        DATE_FORMAT(hearingdate,'%m-%d-%Y') AS hearingdateDisplay,hearingtime,TIME_FORMAT(hearingtime, '%h:%i %p')as hearingtimeDisplay,judge,judgeassistant,hearingrequesteddate,others,docket_createddate from
                        docket where CONCAT(refagency,'-',casetype) NOT IN(SELECT CONCAT(agencycode,'-',casecode) AS pacs FROM pacases WHERE display='N') and $condition".$clause_others.$clause_pagination;
                          //echo $sqlJoin; exit;
                        $docket_data = $ldapcon1->getDatabySql($db,$sqlJoin);
                        $caseids='';

                        $subquery="select caseid from docket where $condition".$clause_others;
                        //echo $subquery; exit;
                        if($Record_count==''){
                         $sqlcount="select COUNT(*)AS reccont from docket where CONCAT(refagency,'-',casetype) NOT IN(SELECT CONCAT(agencycode,'-',casecode) AS pacs FROM pacases WHERE display='N') and $condition".$clause_others;
                         $Record_count= $ldapcon1->getDatabySql($db,$sqlcount); 
                         $Record_count=$Record_count[0]['reccont'];
                        }

                      
                   ///echo "<pre>"; print_r($docket_data); exit;
                        $peopledetails_pagination="";
                        $peopledetails_pagination=($orderBy==1)?" ORDER BY Lastname {$order}":"";

                        $sql_peopledetail="select caseid,typeofcontact,Lastname,Firstname,peopleid,Middlename,Address1,Address2,City,State,Zip,Email,Phone,fax,Title,Company from peopledetails where caseid IN({$subquery}) and typeofcontact='Petitioner'".$peopledetails_pagination;//." LIMIT {$perpage} OFFSET {$start}"
                        
                        $people_data = $ldapcon1->getDatabySql($db,$sql_peopledetail);

                        $agencydetails_pagination="";
                        $agencydetails_pagination=($orderBy==3)?" ORDER BY SR_LastName {$order}":"";

                        $sql_agencyWorker="select caseid,Lastname as SR_LastName,Firstname as SR_Firstname from agencycaseworkerbycase where caseid IN({$subquery})".$agencydetails_pagination;//." LIMIT {$perpage} OFFSET {$start}"
                         //echo $sql_agencyWorker; exit;
                        $agency_data = $ldapcon1->getDatabySql($db,$sql_agencyWorker);
                       
                        $atornydetails_pagination="";
                        $atornydetails_pagination=($orderBy==4)?" ORDER BY AT_LastName {$order}":"";

                        $sql_atorny="select caseid,Lastname as AT_LastName,Firstname as AT_Firstname from attorneybycase where caseid IN({$subquery}) and typeofcontact = 'Petitioner Attorney'".$atornydetails_pagination;//." LIMIT {$perpage} OFFSET {$start}"
                        //echo $sql_atorny; exit;
                        $atorny_data = $ldapcon1->getDatabySql($db,$sql_atorny);

                         
                         foreach ( $docket_data as $docketdata) { 
                             foreach ($people_data as $peopleData) {
                        
                             if($peopleData['caseid']==$docketdata['caseid'] && $peopleData['caseid']!='' && $docketdata['caseid']!=''){
                         
                                $docketdata['typeofcontact']=$peopleData['typeofcontact'];
                                $docketdata['Lastname']=$peopleData['Lastname'];
                                $docketdata['Firstname']=$peopleData['Firstname'];
                                $docketdata['peopleid']=$peopleData['peopleid'];
                                $docketdata['Middlename']=$peopleData['Middlename'];
                                $docketdata['Address1']=$peopleData['Address1'];
                                $docketdata['Address2']=$peopleData['Address2'];
                                $docketdata['City']=$peopleData['City'];
                                $docketdata['State']=$peopleData['State'];
                                $docketdata['Zip']=$peopleData['Zip'];
                                $docketdata['Email']=$peopleData['Email'];
                                $docketdata['Phone']=$peopleData['Phone'];
                                $docketdata['fax']=$peopleData['fax'];
                                $docketdata['Title']=$peopleData['Title'];
                                $docketdata['Company']=$peopleData['Company'];
                        }
                         

                         
                    }
                    foreach ($agency_data as $agencyData) {

                        if($agencyData['caseid']==$docketdata['caseid'] && $agencyData['caseid']!='' && $docketdata['caseid']!=''){
                         
                                $docketdata['SR_LastName']=$agencyData['SR_LastName'];
                                $docketdata['SR_Firstname']=$agencyData['SR_Firstname'];
                                                       
                        }


                    }
                    foreach ($atorny_data as $atornyData) {
                        if($atornyData['caseid']==$docketdata['caseid'] && $atornyData['caseid']!='' && $docketdata['caseid']!=''){
                         
                                $docketdata['AT_Firstname']=$atornyData['AT_Firstname'];
                                $docketdata['AT_LastName']=$atornyData['AT_LastName'];
                                                       
                        }
                    }

                $i++;
                                        
                        $output['docketdata'][]=$docketdata; 
                                //var_dump($docketdata); exit;
                }// Main Foreach Loop
                 
                 
                $output['recnt']['record_counts']=$Record_count;

                $docketInfo = $output;   
            }       
                
                if($orderBy==1 || $orderBy==3 || $orderBy==4){

                    switch($orderBy){
                        case 1:
                            if($order=='asc'){
                                usort($docketInfo['docketdata'], function($a, $b) {
                                 return strcmp($a['Lastname'], $b['Lastname']);
                                });
                            }else{
                               usort($docketInfo['docketdata'], function($a, $b) {
                                 return strcmp($b['Lastname'], $a['Lastname']);
                                }); 
                            }
                            
                        break;

                        case 3:
                            if($order=='asc'){
                                usort($docketInfo['docketdata'], function($a, $b) {
                                 return strcmp($a['AT_LastName'], $b['AT_LastName']);
                                });
                            }else{
                               usort($docketInfo['docketdata'], function($a, $b) {
                                 return strcmp($b['AT_LastName'], $a['AT_LastName']);
                                }); 
                            }

                        break;

                        case 4:
                            if($order=='asc'){
                                usort($docketInfo['docketdata'], function($a, $b) {
                                 return strcmp($a['SR_LastName'], $b['SR_LastName']);
                                });
                            }else{
								
                               usort($docketInfo['docketdata'], function($a, $b) {
                                 return strcmp($b['SR_LastName'], $a['SR_LastName']);
                                }); 
                            }

                        break;


                    }

                }
              
              
            echo json_encode($docketInfo); exit;
        }else{
            http_response_code(404);
            $arrError = array("Error" => "Something went wrong! Please check the token or values supplied.");
            echo json_encode($arrError);
        }

         /*$this->_helper->viewRenderer->setNoRender(true);
         $this->_helper->layout->disableLayout();*/

    }
	
	 public function getdocketdecisionAction(){
	    
		error_reporting(0);
		
		$isValid = $this->validatetoken();
		if($isValid == "true"){
			
			$ldapcon1 = new OsahDbFunctions();
			$db=$this->serviceLocator->get('db1');
			
			
			$docketnumber = $this->params()->fromPost('docketno');
			$zipcode = $this->params()->fromPost('zipcode');
			$attorney = $this->params()->fromPost('attorney');
			
			// Added HOST key to support attachment path download
			
			$host = $_SERVER['HTTP_HOST'];
			 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			 $url =  $protocol.$host;
						
			$tableName = 'attorneybycase';
			$condition = 'caseid ='.$docketnumber;
			
			if($attorney == 'y'){
				
				//Check if attorney record is present or not
				$attorneyResult = $ldapcon1->getData($db,$tableName,$condition,0);
				
				if(count($attorneyResult) > 0){
					
					$docketInfo=$ldapcon1->getDocketDisposition($db,$docketnumber,$zipcode, 'y');
					if(count($docketInfo) > 0 )$docketInfo[0]['host'] =  $url;
					
					echo json_encode($docketInfo);
				}
				
				else{
				
				$docketInfo=$ldapcon1->getDocketDisposition($db,$docketnumber,$zipcode, 'n');
				if(count($docketInfo) > 0 )$docketInfo[0]['host'] =  $url;
				echo json_encode($docketInfo);
				}
			}			
			else{
				
				$docketInfo=$ldapcon1->getDocketDisposition($db,$docketnumber,$zipcode, 'n');
				if(count($docketInfo) > 0 )$docketInfo[0]['host'] =  $url;
				echo json_encode($docketInfo);
			}
			
		}
		else{
			http_response_code(404);
			$arrError = array("Error" => "Something went wrong! Please check the token or values supplied.");
			echo json_encode($arrError);
		}
		
	    $this->_helper->viewRenderer->setNoRender(true);
	    $this->_helper->layout->disableLayout();
  
	}
	
	 public function validatetoken(){
	    //error_reporting(0);
			
			$response = "";
			$headers = apache_request_headers();
			
			if(isset($headers['token'])){
				if($headers['token'] == "OGOVhrihHVQZ43srht6Pb9binzpid7US")
					$response = "true";
				else
					$response = "false";
			}
			else{
				$response = "false";
			}
			
		return $response;
		
	}
	
	
	/* 
			###### Api Request functions Ends Here
		
	*/
	
	
	
	
	/* 
  Name : Neha
  Date Created : 26-09-2016
  Description : Function is used to fetch data search by docket number.
 */
// public function searchbydocketAction(){
//	
//  $db=$this->serviceLocator->get('db1');
//  $param= json_decode(file_get_contents('php://input'),true); 
//  $docketno = $param['docketno'];
//  $OsahDb=New OsahDbFunctions();
//    //$result=$OsahDb->getCaseBySearch($db,$docketno);
//    $condition="caseid=$docketno";
//    $result = $OsahDb->getData($db,'docketsearch',$condition,0);
//    echo json_encode($result);
//    exit;
// }
 
 /* 
  Name : Amol S
  Date Created : 09-10-2016
  Description : Function searchdatabywhereAction  is used to fetch data
  *  from table based on paramiter like tbale and where condition.
 */
 public function searchdatabywhereAction(){
	
  $db=$this->serviceLocator->get('db1');
  $param= json_decode(file_get_contents('php://input'),true); 
  $tableName = $param['tableName'];
  $condition = $param['condition'];
  $OsahDb=New OsahDbFunctions();
  $result = $OsahDb->getData($db,$tableName,$condition,0);
   echo json_encode($result);
    exit;
 }
 
 
 
 /* 
  Name : Neha
  Date Created : 29-09-2016
  Description : Function is used to fetch the 5 upcoming calendars filter by user type.
 */
 public function upcomingcalendarAction(){
    $session = new Container('base');
    $user_type = '';
     $today_date = date("Y-m-d");
    $db=$this->serviceLocator->get('db1');
    $param= json_decode(file_get_contents('php://input'),true); 
    $OsahDb=New OsahDbFunctions();
    switch ($session->user_type){
	case 'judge':
	      $user_type = " and judge = '$session->LastName, $session->FirstName'";
		break;
	case 'cma':
		$user_type = " and assistant = '$session->LastName, $session->FirstName'";
		break;
	
//	    case 'sa':
//	    
//		break;
//	    
//	    case 'it':
//	    
//		break;
//	    
//	    case 'finance':
	    
//		break;
	    
	    default :
		 $user_type = '';
		break;
		
	
    }
    
    $condition="hearingdate >= '$today_date' $user_type order by hearingdate ASC";
	$result = $OsahDb->getData($db,'upcomingcalendars',$condition,0);

     echo json_encode(array('result'=>$result, 'user_type'=>$session->user_type));
     // echo json_encode($result,$session->user_type);
	  exit;
 }
 
 /* 
  Name : Neha
  Date Created : 04-10-2016
  Description : Function is used to fetch the docket data filter by date/loggedin user/user type.
 */
// public function searchbyvalueAction(){
//    $db = $this->serviceLocator->get('db1');
//    $param = json_decode(file_get_contents('php://input'),true); 
//    $hearing_date = $param['searchvalue'];
//    $OsahDb=New OsahDbFunctions();
//    $condition= "hearingdate = '$hearing_date'";
//    $result = $OsahDb->getData($db,'docketsearch',$condition,0);
//       echo json_encode($result);
//	  exit;
//}
 
 	/* 
  Name : Amol
  Date Created : 29-09-2016
  Date Modified:   
  Description : Function is used to fetch data search by docket number.
 */
 public function getdatadynamicAction(){
	
  $db=$this->serviceLocator->get('db1');
  $param= json_decode(file_get_contents('php://input'),true); 
  //$docketno = $param['docketno'];
   $tbl_name = $param['tblNm'];
   $field_nm = $param['field_nm'];
   $field_val= $param['field_val'];
   $condition_type = $param['cond_type'];
     
$condition_type_symbol='';
switch ($condition_type) {
    case '1':
       $condition_type_symbol = "=";
        break;
    case "2":
	    $condition_type_symbol = "!=";
        break;
    case "3":
        $condition_type_symbol = "<";
        break;
    case "4":
        $condition_type_symbol = ">";
        break;
    case "5":
        $condition_type_symbol = "<=";
        break;
    case "6":
        $condition_type_symbol = ">=";
        break;
    
    
    default:
       echo "Parameters not provided properly";
	exit;  
}
 
  $OsahDb=New OsahDbFunctions();
 
    //$result=$OsahDb->getCaseBySearch($db,$docketno);
    $condition="$field_nm $condition_type_symbol $field_val";
    $result = $OsahDb->getData($db,$tbl_name,$condition,0);
    echo json_encode($result);
    exit;
 }
 
    /* 
	Name : Amol
	Date Created : 10-10-2016
	Date Modified:   
	Description : Function will check the user is loged or not.
    */
    public function isuserlogedAction(){
	$param= json_decode(file_get_contents('php://input'),true); 
	$session = new Container('base');
	if(isset($param['username'])&& $param['username']!=''){
	     $condition =$param['username']."@osah.ga.gov";
	     $result = ($session->email == $condition)?'1':'2';
	     echo $result;  
	}else{
	    echo 2;
	}

	exit;  
   }
   
   /* 
	Name : Amol
	Date Created : 14-10-2016
	Date Modified:   
	Description : Function will distory all session value.
    */
    public function logoutAction(){
	   
	   $session = new Container('base');
       $session->getManager()->destroy();
       echo 1;
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
	   $db=$this->serviceLocator->get('db1');
	   $param= json_decode(file_get_contents('php://input'),true);
	   $OsahDb=New OsahDbFunctions();
	   $contact_type = $param['partydetails']['contactType'];
	   $docketnum = $param['partydetails']['docket_number'];
	   $lastname = $param['partydetails']['last_name'];
	   $firstname = $param['partydetails']['first_name'];
	   
	   if(isset($param['partydetails']['middle_name'])){
			$middlename = $param['partydetails']['middle_name'];
		}else{
			$middlename = '';
		}
		if(isset($param['partydetails']['dobyear'])){
			$dobyear =  $param['partydetails']['dobyear'];
		}else{
			$dobyear = '';
		}
		if(isset($param['partydetails']['attorney'])){
			$attorney =  $param['partydetails']['attorney'];
		}else{
			$attorney = '';
		}
		if(isset($param['partydetails']['title'])){
			$title =  $param['partydetails']['title'];
		}else{
			$title = '';
		}
		if(isset($param['partydetails']['company_name'])){
			$company_name =  $param['partydetails']['company_name'];
		}else{
			$company_name = '';
		}
		if(isset($param['partydetails']['address2'])){
			$address2 =  $param['partydetails']['address2'];
		}else{
			$address2 = '';
		}
		if(isset($param['partydetails']['phone'])){
			$phone =  $param['partydetails']['phone'];
		}else{
			$phone = '';
		}
		if(isset($param['partydetails']['email'])){
			$email =  $param['partydetails']['email'];
		}else{
			$email = '';
		}
		if(isset($param['partydetails']['fax'])){
			$fax =  $param['partydetails']['fax'];
		}else{
			$fax = '';
		}
	   $mailtoreceive1 = '';
	   $mailtoreceive = '';
	   $current_datetime = date("Y-m-d H:i:s");
	   if($contact_type=='Minor/children')
	    {
		   $add_minortable_data = array(
				'Lastname'=>$lastname,
				'Firstname'=>$firstname,
				'Middlename'=>$middlename,
				'dobyear'=>$dobyear,
				'Docket_caseid'=>$docketnum,
				'caseid'=>$docketnum,
				'created_date'=>$current_datetime,
				'modified_date'=>$current_datetime
			);
	    }else{
				$data = array(
					'Lastname'=>$lastname,
					'Firstname'=>$firstname,
					'Middlename'=>$middlename,
					'Title'=>$title,
					'Company'=>$company_name,
					'Address1'=>$param['partydetails']['address1'],
					'Address2'=>$address2,
					'City'=>$param['partydetails']['city'],
					'State'=>$param['partydetails']['state'],
					'Zip'=>$param['partydetails']['zip_code'],
					'created_date'=>$current_datetime,
					'modified_date'=>$current_datetime
				);
			}
	   switch ($contact_type){
		   case 'Minor/children':
				$condition = "caseid = '".$docketnum."' and Lastname = '".$lastname."' and Firstname = '".$firstname."'";
				$result = $OsahDb->getData($db,"minordetails",$condition,0);
				if(!empty($result))
				{
					echo "0";exit;
				}else{
					$result = $OsahDb->insertData($db,"minordetails",$add_minortable_data);
				}
				echo "true";exit;
			break;
			
			case 'Petitioner':
			case 'Respondent':
			case 'Others':
			case 'Custodial Parent':
			case 'Head of Household':
			case 'Representative':
			case 'CPAFirm':
			
			$condition = "caseid = '".$docketnum."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
			$result = $OsahDb->getData($db,"peopledetails",$condition,0);
			if(!empty($result))
			{
				echo "0";exit;
			}else{
					$new_data = array(
						'Phone'=>$phone,
						'Email'=>$email,
						'fax'=>$fax,
						'Docket_caseid'=>$docketnum,
						'caseid'=>$docketnum,
						'typeofcontact'=>$contact_type
					);
					$parent_data = array_merge($data,$new_data);
                    $result = $OsahDb->insertData($db,"peopledetails",$parent_data);
				}
					echo "true";exit;
			
			break;
			
			case 'Case Worker':
			case 'Investigator':
			case 'Hearing Coordinator':
			case 'Agency Contact':
			case 'Employer':
			case 'School District':
			case 'Candidate':
			case 'Probate Judge':
			case 'Administrator':
			
			$condition = "caseid = '".$docketnum."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
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
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'Docket_caseid'=>$docketnum,
							'caseid'=>$docketnum,
							'typeofcontact'=>$contact_type,
							'contactid'=>$result
						);
					$parent_data = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"agencycaseworkerbycase",$parent_data);
			}
				echo "true";exit;
			break;
			
			case 'Officer':
			
			
			
			$condition = "caseid = '".$docketnum."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
			$result = $OsahDb->getData($db,"agencycaseworkerbycase",$condition,0);
			if(!empty($result))
			{
				echo "0";exit;
			}else{
				$new_data = array(
							'Phone'=>$phone,
							'Email'=>$email,
							'fax'=>$fax
						);
				$parent_data = array_merge($data,$new_data);
				$result = $OsahDb->insertData($db,"officerdetails",$parent_data,1);
				$new_data = array(
						'Phone'=>$phone,
						'Email'=>$email,
						'Fax'=>$fax,
						'typeofcontact'=>$contact_type,
						'Docket_caseid'=>$docketnum,
						'caseid'=>$docketnum,
						'contactid'=>$result
					);
				$parent_data = array_merge($data,$new_data);
				$result = $OsahDb->insertData($db,"agencycaseworkerbycase",$parent_data);
			}
			echo "true";exit;
				
			break;
			
			case 'Agency Attorney':
			case 'Other Attorney':
			case 'Respondent Attorney':
			case 'Petitioner Attorney':
			
			$condition = "caseid = '".$docketnum."' and Lastname = '".$lastname."' and Firstname = '".$firstname."' and typeofcontact = '".$contact_type."'";
			$result = $OsahDb->getData($db,"attorneybycase",$condition,0);
			if(!empty($result))
			{
				echo "0";exit;
			}else{
				$new_data = array(
								'Phone'=>$phone,
								'Email'=>$email,
								'Fax'=>$fax,
								'AttorneyBar'=>$attorney,	
								);
				$parent_data = array_merge($data,$new_data);
				$result = $OsahDb->insertData($db,"attorney",$parent_data,1);
				$new_data = array(
							'AttorneyBar'=>$attorney,
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'Docket_caseid'=>$docketnum,
							'caseid'=>$docketnum,
								'typeofcontact'=>$contact_type,
								'attorneyid'=>$result
						);
				$parent_data = array_merge($data,$new_data);
				$result = $OsahDb->insertData($db,"attorneybycase",$parent_data);
			}
				echo "true";exit;
			break;
			
			default :
				echo "true";exit;
			break;	
		}
	}

	/* 
	Name : Amol
	Date Created : 20-10-2016
	Date Modified:   
	Description : Function updatedocketAction will updata the general information of docket.
    */

   public function updatedocketAction(){
       
        
        $db=$this->serviceLocator->get('db1');
        $OsahDb=New OsahDbFunctions();
        $param= json_decode(file_get_contents('php://input'),true);
		// print_r($param);exit;
            $condition = array('caseid' => $param['dockeid']);
			$document_condition = array('Caseid'=>$param['dockeid'],'DocumentType'=>'Decision');
			$roc_flag = array('roc_flag'=>1);
            $result = $OsahDb->updateData($db,"docket",$param['docketInfo'],$condition);
			$refagency = $param['docketInfo']['refagency'];
			$casetype = $param['docketInfo']['casetype'];
			if(isset($param['location_id']['location_id']))
			{
				$location_id = $param['location_id']['location_id'];
			}else{
				$location_id = 'UNASSIGNED';
			}
			
			$judge = $param['docketInfo']['judge'];
			$split_judgename = explode(" ", $judge);
			$judge_firstname = $split_judgename[0];
			
			$docketnumber = $refagency.'-'.$casetype.'-'.$param['dockeid'].'-'.$location_id.'-'.$judge_firstname;
				$condition = array('caseid' => $param['dockeid']);
						$data = array(
								'docketnumber'=>$docketnumber
						);
				$result = $OsahDb->updateData($db,"docket",$data,$condition);
			
			 $status = $param['docketInfo']['status'];
			 if($status=='Rescheduled')
			 {
				$disposition_condition = "caseid=".$param['dockeid'];
				$getresult = $OsahDb->getData($db,"docketdisposition",$disposition_condition,0);
				if(!empty($getresult)){
					$result = $OsahDb->deleteData($db,"docketdisposition",$condition);
					$result = $OsahDb->updateData($db,"documentstable",$roc_flag,$document_condition);
				}
			 }
            echo $result;
            exit;

    }


   
   /* 
    Name : Neha
    Date Created : 21-10-2016
    Date Modified: 10-01-2017
    Modified By;Amol S.
    Description : getpartydetailsAction Function will get the all party details from diffrent tables.
    */
    public function getpartydetailsAction(){
       
		  $db=$this->serviceLocator->get('db1');
          $param= json_decode(file_get_contents('php://input'),true); 
          $docket_id=  $param['docket_no'];  
          $session = new Container('base');
          $OsahDb  = New OsahDbFunctions();
          $result  = $OsahDb->getPartyDetails($db,$docket_id);
          echo json_encode($result);exit;

    }
	
	 /* 
    Name : Neha
    Date Created : 25-10-2016
    Date Modified:   
    Description : deletepartyAction Function is used to delete the party based on contact type.
    */
	 public function deletepartyAction(){
		 $db=$this->serviceLocator->get('db1');
        $param= json_decode(file_get_contents('php://input'),true);
		$OsahDb=New OsahDbFunctions();
		$typeofcontact = $param['typeofcontact'];
		 switch ($typeofcontact){
			 
			case 'Petitioner':
			case 'Respondent':
			case 'Others':
			case 'Custodial Parent':
			case 'Head of Household':
			case 'Representative':
			case 'CPAFirm':
			
			$condition = array('peopleid' => $param['people_id']);
            $result = $OsahDb->deleteData($db,"peopledetails",$condition);
			echo $result;exit;
			
			break;
			
			case 'Minor/Children':
			$condition = array('Minorid' => $param['minor_id']);
            $result = $OsahDb->deleteData($db,"minordetails",$condition);
			echo $result;exit;
			
			break;
			 
			case 'Agency Attorney':
			case 'Other Attorney':
			case 'Respondent Attorney':
			case 'Petitioner Attorney':
			
			$condition = array('attorneyid' => $param['attorney_id']);
            $result = $OsahDb->deleteData($db,"attorneybycase",$condition);
			echo $result;exit;
			break;
			
			case 'Case Worker':
			case 'Investigator':
			case 'Hearing Coordinator':
			case 'Officer':
			case 'Agency Contact':
			case 'Employer':
			case 'School District':
			case 'Candidate':
			case 'Probate Judge':
			case 'Administrator':
			
			$condition = array('contactid' => $param['contact_id'],'typeofcontact' => $typeofcontact);
            $result = $OsahDb->deleteData($db,"agencycaseworkerbycase",$condition);
			echo $result;exit;
			break;
			
			default :
				echo "true";exit;
			break;
			
		 }
	}
		/* 
		Author Name : Faisal
		Description : Function is used to add Notes details regarding docket number.
		Created Date : 08-11-2016
		*/
		public function addNotesAction()
		{
			error_reporting(E_WARNING);
			
			$session = new Container('base');
			$param= json_decode(file_get_contents('php://input'),true);
			$db=$this->getServiceLocator()->get('db1');
			if(isset($param['summarynotes'])&&isset($param['caseid'])){
				$values = array(
					'caseid'=> $param['caseid'],
					'Docket_caseid'=> $param['caseid'],
					'date'=> date("Y-m-d"),
					'summarynotes'=> $param['summarynotes'],
					'updatedby'=> $session->user_name
				);
				$OsahDb=New OsahDbFunctions();
				echo $OsahDb->addNotes($db, $values);
			}
			exit;
		}
		
	/* 
    Name : Neha
    Date Created : 08-11-2016
    Date Modified:   
    Description : deleteNotesAction Function is used to delete the notes.
    */
	 public function deletenotesAction(){
		$db=$this->serviceLocator->get('db1');
        $param= json_decode(file_get_contents('php://input'),true);
		$notes_id=  $param['notes_id'];
		$OsahDb=New OsahDbFunctions();
		$condition = array('id' => $notes_id);
		$result = $OsahDb->deleteData($db,"summarytable",$condition);
		echo $result;exit;
		}
		
	/* 
    Name : Affan
    Date Created : 08-11-2016
    Date Modified:   
    Description : downloaddocumentAction Function is used to download document.
    */	
		
	public function downloaddocumentAction(){ 
		$id = $this->params()->fromRoute('id');
		$db=$this->serviceLocator->get('db1');
		$peopleDetailsqlDownload = "select attachmentpath from attachmentpaths where documentid =$id";
		$peopleDetailsqlDownload1 = $db->createStatement($peopleDetailsqlDownload);
		$peopleDetailresult = $peopleDetailsqlDownload1->execute(); 
		$resultSet = new ResultSet;
		$resultSet->initialize($peopleDetailresult);
		$peopleDetails = $resultSet->toArray();
			if(file_exists($_SERVER['DOCUMENT_ROOT']."/".$peopleDetails[0]['attachmentpath'])){
			   header("Pragma: public");
			   header("Expires: 0");
			   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			   header("Cache-Control: public");
			   header('Content-Disposition: inline; filename="' . basename($peopleDetails[0]['attachmentpath']) . '"');
			   header("Content-Description: File Transfer");
			   header("Content-Transfer-Encoding: binary");
			   header("Content-type: application/octet-stream");
			   ob_end_flush();
			   @readfile($_SERVER['DOCUMENT_ROOT']."/".$peopleDetails[0]['attachmentpath']); 
			   echo "1";
			   exit();
			}else{
				echo "0";
			}

  }
  /* 
    Name : Affan
    Date Created : 08-11-2016
    Date Modified:   
    Description : checkdocumentfileExistAction Function is used to check if file exist.
    */	
	
  public function checkdocumentfileExistAction(){   
  //$id = $this->params()->fromRoute('id');
    $param= json_decode(file_get_contents('php://input'),true); 
	$add_folder = $_SERVER['DOCUMENT_ROOT']."/temp/";
	if(file_exists($add_folder.$param['file'])){
		echo "1";
	}
	else{
		echo "0";
	}
	exit;
	//print_r($param);
	}
  
  /* 
    Name : Affan
    Date Created : 08-11-2016
    Date Modified:   
    Description : deleteTempDocumentAction Function is used to check if file exist in temp folder and download.
    */	
  
  public function deleteTempDocumentAction(){   
  //$id = $this->params()->fromRoute('id');
    //$param= json_decode(file_get_contents('php://input'),true); 

	$add_folder = $_SERVER['DOCUMENT_ROOT']."/temp/";
		if(file_exists($add_folder.$_POST['file'])){
			header("Pragma: public");
		   header("Expires: 0");
		   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		   header("Cache-Control: public");
		  header('Content-Disposition: inline; filename="' . $_POST['file'] . '"');
		   header("Content-Description: File Transfer");
		   header("Content-Transfer-Encoding: binary");
		   header("Content-type: application/octet-stream");
		   ob_end_flush();
		   @readfile($add_folder.$_POST['file']); 
		   echo "1";
		   exit();
		}else{
			echo "0";
		}
		exit;
	//print_r($param);
	}
	
	
	/* 
    Name : Affan
    Date Created : 08-11-2016
    Date Modified:   
    Description : checkdocumentAction Function is used to check if file exist in temp folder.
    */	
	
	public function checkdocumentAction(){   
	  //$id = $this->params()->fromRoute('id');
		$param= json_decode(file_get_contents('php://input'),true); 
		$db=$this->serviceLocator->get('db1');
		$peopleDetailsqlDownload = "select attachmentpath from attachmentpaths where documentid = ".$param['id'];
		$peopleDetailsqlDownload1 = $db->createStatement($peopleDetailsqlDownload);
		$peopleDetailresult = $peopleDetailsqlDownload1->execute(); 
		$resultSet = new ResultSet;
		$resultSet->initialize($peopleDetailresult);
		$peopleDetails = $resultSet->toArray();
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/".$peopleDetails[0]['attachmentpath'])){
		   echo "1";
		   exit();
		}else{
		echo "0";
		exit();
		}
	}
	
	/* 
		Author Name : Neha
		Description : Function is used to update Notes details regarding docket number.
		Created Date : 08-11-2016
		*/
		public function updatenotesAction()
		{
			
			$db=$this->serviceLocator->get('db1');
			$session = new Container('base');
			$param= json_decode(file_get_contents('php://input'),true);
			$summarynotes = array('summarynotes' => $param['summarynotes']);
			$condition = array('id' => $param['notesId']);
			$OsahDb=New OsahDbFunctions();
            $result = $OsahDb->updateData($db,"summarytable",$summarynotes,$condition);
            echo $result;exit;
		}
		
		/* 
    Name : Neha
    Date Created : 10-11-2016
    Date Modified:   
    Description : deleteNotesAction Function is used to delete the documents/files against docket number.
    */
	public function deletedocumentAction(){
		$db=$this->serviceLocator->get('db1');
        $param= json_decode(file_get_contents('php://input'),true);
		$document_id=  $param['document_id'];
		$OsahDb=New OsahDbFunctions();
		$deletecondition = array('documentid' => $document_id);
		$condition ='documentid = "'.$document_id.'"';
		$getdata = $OsahDb->getData($db,"documentstable",$condition,0);
		// print_r($getdata);exit;
		$imagename = $getdata[0]['DocumentName'];
		$result = $OsahDb->deleteData($db,"documentstable",$deletecondition);
		$getpath = $OsahDb->getData($db,"attachmentpaths",$condition,0);
		if(!empty($getpath))
		{
			$data = array(
					'documentid' => $getpath[0]['documentid'],
					'deletedattachmentpathscol' => $getpath[0]['attachmentpath'],
				);
				
			$attachedpath = $_SERVER['DOCUMENT_ROOT'].$getpath[0]['attachmentpath'];
			$attachedPatharray = explode('/',$attachedpath);
			$attachedPatharray = array_filter($attachedPatharray); 
			array_pop($attachedPatharray);
			$removePath = implode('/',$attachedPatharray);
			$add_folder = $_SERVER['DOCUMENT_ROOT']."/temp/";
		if (!file_exists($add_folder)) {
				mkdir($add_folder,0777);
			}
			copy($attachedpath, $add_folder."/".$imagename);
			if (file_exists($attachedpath)) {
				unlink($attachedpath);
				rmdir($removePath);
			}
			$deleted_result = $OsahDb->insertData($db,"deletedattachmentpaths",$data);
			$result = $OsahDb->deleteData($db,"attachmentpaths",$deletecondition);
		}
		echo json_encode(array('result'=>$result,'temp_path'=>$add_folder.$imagename));exit;
		// echo $result;exit;
	}
		
	 /* 
    Name : Neha
    Date Created : 11-11-2016
    Date Modified:   
    Description : getdispositiontypeAction Function will get the all disposition type from disposition table.
    */
    public function getdispositiontypeAction(){
		  $db=$this->serviceLocator->get('db1');
           $OsahDb=New OsahDbFunctions();
		   $condition = "";
		
        $result = $OsahDb->getData($db,"disposition",$condition,0);
        echo json_encode($result);exit;

    }




     /* 
      Name : Amol S
      Date Created : 11-11-2016
      Description : Get data for auto complect field while adding part in daocket
      
     */
     public function autopopulateAction(){
             $param= json_decode(file_get_contents('php://input'),true); 
			 // print_r($param);exit;
			 $contact_type = $param['contact_type'];
          $db=$this->serviceLocator->get('db1');
          // $param= json_decode(file_get_contents('php://input'),true); 
          // $tableName = $param['tableName'];
          // $condition = $param['condition'];
          $OsahDb=New OsahDbFunctions();
          $result = $OsahDb->getAutocomplectData($db,$contact_type);
          $condition="id!=0";
           echo json_encode($result);
            exit;
     }

     /* 
      Name : Amol S
      Date Created : 11-11-2016
      Date Modified : 02-12-2016
      Description : getpartyinformationAction this function will get the party information (autopopulate the data)
      
     */
     public function getpartyinformationAction(){
         $db=$this->serviceLocator->get('db1');
          $param= json_decode(file_get_contents('php://input'),true); 
          if(!empty($param)){
              $party_id = $param['pid'];
          
              $OsahDb=New OsahDbFunctions();
              $result = $OsahDb->getpartyinformationData($db,$party_id);
                echo json_encode($result);
           }     
                exit;   
     }
     

		public function addHistoryAction()
		{
			error_reporting(E_WARNING);
			$session = new Container('base');
			$param= json_decode(file_get_contents('php://input'),true);
				$db=$this->getServiceLocator()->get('db1');
				$values = array(
					'caseid'=> $param['caseid'],
					'date'=> date("Y-m-d"),
					'Description'=> $param['message'],
					'Modifiedby'=> $session->user_name,
					'Docket_caseid'=>$param['caseid']

				);
				$OsahDb=New OsahDbFunctions();
				echo $OsahDb->addHistory($db, $values,"history");

			exit;
		}
	/* 
		Name : Neha
		Date Created : 14-11-2016
		Date Modified:   
		Description : adddispositionAction Function is used to add disposition data in docketdisposition table.
	*/
	
	public function adddispositionAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true);
		// print_r($param);exit;
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->insertData($db,"docketdisposition",$param['dispositiondata']);
		if($result=='true')
		{
			$status = array('status' => 'Closed');
			$condition = array('caseid' => $param['dispositiondata']['caseid']);
            $result = $OsahDb->updateData($db,"docket",$status,$condition);
		}
		echo $result;exit;
	}
	
	/* 
		Name : Neha
		Date Created : 14-11-2016
		Date Modified:   
		Description : getDispositionAction Function is used to list disposition data from docketdisposition table.
	*/
	
	public function getDispositionAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true);
		$OsahDb=New OsahDbFunctions();
		$condition = "";
        $result = $OsahDb->getData($db,"docketdisposition",$condition,0);
        echo json_encode($result);exit;
	}
	
	/* 

		Name : Neha
		Date Created : 16-11-2016
		DEscription : Function is used to get party details to update.

        Name Amol s
        Date Modified: 24-11-2016
        DEscription : Code Optimized
	*/
	
	public function getpartyAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true);
		$OsahDb=New OsahDbFunctions();
		$typeofcontact = $param['typeofcontact'];
		$caseid = $param['caseid'];
        $condition='';
        $table_name='';
		 switch ($typeofcontact){
			 
			case 'Petitioner':
			case 'Respondent':
			case 'Others':
			case 'Custodial Parent':
			case 'Head of Household':
			case 'Representative':
			case 'CPAFirm':
			
				$condition = 'peopleid ="'.$param['people_id'].'" and caseid = "'.$caseid.'"';
				$table_name="peopledetails";
			break;
			
			case 'Minor/Children':
			
				$condition = "Minorid =".$param['minor_id'];
				$table_name="minordetails";
			break;
			 
			case 'Agency Attorney':
			case 'Other Attorney':
			case 'Respondent Attorney':
			case 'Petitioner Attorney':
			
				$condition = 'attorneyid ="'.$param['attorney_id'].'" and caseid = "'.$caseid.'"';
				$table_name="attorneybycase";
			break;
			
			case 'Case Worker':
			case 'Investigator':
			case 'Hearing Coordinator':
			case 'Agency Contact':
			case 'Employer':
			case 'School District':
			case 'Candidate':
			case 'Probate Judge':
			case 'Administrator':
			
				$condition = 'contactid ="'.$param['contact_id'].'" and caseid = "'.$caseid.'"';
				$table_name="agencycaseworkerbycase";
			break;
			
			case 'Officer':
			
				$condition = 'contactid ="'.$param['contact_id'].'" and caseid = "'.$caseid.'"';
				$table_name="agencycaseworkerbycase";

			break;
			default :
				echo "true";exit;
			break;
	   }
            $result = $OsahDb->getData($db,$table_name,$condition,0);
            echo json_encode($result);exit;
	}

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
			case 'Respondent':
			case 'Others':
			case 'Custodial Parent':
			case 'Head of Household':
			case 'Representative':
			case 'CPAFirm':
			
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
			case 'Other Attorney':
			case 'Respondent Attorney':
			case 'Petitioner Attorney':
		
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
						$result = $OsahDb->updateData($db,"attorney",$attorney_parentdata,$condition);
						if($result=="1")
						{
							$condition = array('attorneyid' => $param['editpartydetails']['attorney_id'],'caseid'=>$caseid);
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
							'Phone'=>$phone,
							'Email'=>$email,
							'fax'=>$fax
						);
						$parent_data = array_merge($data,$new_data);
						$result = $OsahDb->updateData($db,"officerdetails",$parent_data,$condition);
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
							'Phone'=>$phone,
							'Email'=>$email,
							'fax'=>$fax
						);
					$parent_data = array_merge($data,$new_data);
					$result = $OsahDb->insertData($db,"officerdetails",$parent_data,1);
					$new_data = array(
							'Phone'=>$phone,
							'Email'=>$email,
							'Fax'=>$fax,
							'typeofcontact'=>$contact_type,
							'Docket_caseid'=>$caseid,
							'caseid'=>$caseid,
							'contactid'=>$result
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
			
			case 'Case Worker':
			case 'Investigator':
			case 'Hearing Coordinator':
			case 'Officer':
			case 'Agency Contact':
			case 'Employer':
			case 'School District':
			case 'Candidate':
			case 'Probate Judge':
			case 'Administrator':
			
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
      Name : Amol S
      Date Created : 17-11-2016
      Description : getdocketstatuslistAction this function will get status list of docket 
      
     */
     public function getdocketstatuslistAction(){
            
          $db=$this->serviceLocator->get('db1');
          
            $sql="select id,REPLACE(statuslist,'Hearing Re-Scheduled','Rescheduled') AS statuslist from statuslist";
              $OsahDb=New OsahDbFunctions();
              $result = $OsahDb->getDatabySql($db,$sql);
                echo json_encode($result);
          
                exit;
     }

    /* 
      Name : Amol S
      Date Created : 17-11-2016
      Description : gethearingtimelistAction this function will get Hearing tiem list of docket 
      
     */
     public function gethearingtimelistAction(){
            
        $db=$this->serviceLocator->get('db1');
        // $sql="select DISTINCT hearingtime from judgescountymaping ORDER BY hearingtime DESC";
        $sql="select * FROM hearingtime";
        $OsahDb=New OsahDbFunctions();
        $result = $OsahDb->getDatabySql($db,$sql);
        echo json_encode($result);
        exit;
     }
	 
	 
	 
	 /* 
		Name : Neha Agrawal
		Date Created : 21-11-2016
		Description : Function is used to export the data in CSV Format
	 */
	 
	public function exportdataAction()
	{
		$db=$this->serviceLocator->get('db1');
		$condition = json_decode($_POST['condition'],true);
		$OsahDb=New OsahDbFunctions();
		$flag = json_decode($_POST['flag'],true);
		$result_arr = array();
		$export_arr = array();
		$final_result = array();
		if($flag =='2') // fetch open cases 
		{
			$master_condition="";
			if(isset($condition['agencyrefnumber']) && $condition['agencyrefnumber']!=''){
					$master_condition .=( $master_condition=='')?"doc.agencyrefnumber='".$condition['agencyrefnumber']."'":"doc.agencyrefnumber='".$condition['agencyrefnumber']."'";
			}
			$master_condition .=( $master_condition=='')?"doc.telv_o_five='1'":"doc.telv_o_five='1'";
			if(isset($condition['county']) && $condition['county']!=''){
					$master_condition .=( $master_condition=='')?"doc.county='".$condition['county']."'":" && doc.county='".$condition['county']."'";
			}        

			if(isset($condition['status']) && $condition['status']!=''){
					if($condition['status']=='NA'){
						$master_condition .=( $master_condition=='')?"doc.status!='Closed'":" && doc.status!='Closed'";
					}else if($condition['status']=='All'){
						$master_condition.=( $master_condition=='')?"doc.status!=''":" && doc.status!=''";
					}else{
						$master_condition .=( $master_condition=='')?"doc.status='".$condition['status']."'":" && doc.status='".$condition['status']."'";
					}  
				   
			}

			if(isset($condition['refagency']) && $condition['refagency']!=''){
					$master_condition .=( $master_condition=='')?"doc.refagency='".$condition['refagency']."'":" && doc.refagency='".$condition['refagency']."'";
			}

			if(isset($condition['casetype']) && $condition['casetype']!=''){
					$master_condition .=( $master_condition=='')?"doc.casetype='".$condition['casetype']."'":" && doc.casetype='".$condition['casetype']."'";
			}
			
			if(isset($condition['judge']) && $condition['judge']!=''){
					$master_condition .=( $master_condition=='')?"doc.judge='".$condition['judge']."'":" && doc.judge='".$condition['judge']."'";
			}

			if(isset($condition['judgeassistant']) && $condition['judgeassistant']!=''){
					$master_condition .=( $master_condition=='')?"doc.judgeassistant='".$condition['judgeassistant']."'":" && doc.judgeassistant='".$condition['judgeassistant']."'";
			}

			if(isset($condition['hearingsite']) && $condition['hearingsite']!=''){
					$master_condition .=( $master_condition=='')?"doc.hearingsite='".$condition['hearingsite']."'":" && doc.hearingsite='".$condition['hearingsite']."'";
			}

			if(isset($condition['hearingdate_From']) && $condition['hearingdate_From']!=''){
					$master_condition .=( $master_condition=='')?"doc.hearingdate >='".$condition['hearingdate_From']."'":" && doc.hearingdate >='".$condition['hearingdate_From']."'";
			}

			if(isset($condition['hearingdate_To']) && $condition['hearingdate_To']!=''){
					$master_condition .=( $master_condition=='')?"doc.hearingdate <='".$condition['hearingdate_To']."'":" && doc.hearingdate <='".$condition['hearingdate_To']."'";
			}

			if(isset($condition['datereceivedbyOSAH_From']) && $condition['datereceivedbyOSAH_From']!=''){
					$master_condition .=( $master_condition=='')?"doc.datereceivedbyOSAH >='".$condition['datereceivedbyOSAH_From']."'":" && doc.datereceivedbyOSAH >='".$condition['datereceivedbyOSAH_From']."'";
			}

			if(isset($condition['datereceivedbyOSAH_To']) && $condition['datereceivedbyOSAH_To']!=''){
					$master_condition .=( $master_condition=='')?"doc.datereceivedbyOSAH <='".$condition['datereceivedbyOSAH_To']."'":" && doc.datereceivedbyOSAH <='".$condition['datereceivedbyOSAH_To']."'";
			}

			if(isset($condition['hearingtime']) && $condition['hearingtime']!=''){
					$master_condition .=( $master_condition=='')?"doc.hearingtime='".$condition['hearingtime']."'":" && doc.hearingtime='".$condition['hearingtime']."'";
			}
			 /*Check the First Name and last name is there or not*/
		  
				 $name_Flage=0;
				 $name_condition="";
				if(isset($condition['Lastname']) && $condition['Lastname']!=''){
					$lname=$condition['Lastname'];
					$name_Flage=1;
					 $name_condition .=( $name_condition=='')?"dyn.Lastname='".$condition['Lastname']."'":" && dyn.Lastname='".$condition['Lastname']."'";
				}
			   
				if(isset($condition['Firstname']) && $condition['Firstname']!=''){
					$fname=$condition['Firstname'];
					$name_Flage=1;
					$name_condition .=( $name_condition=='')?"dyn.Firstname='".$condition['Firstname']."'":" && dyn.Firstname='".$condition['Firstname']."'";
				}
		 

			/*Check The Contact type is selected or not*/
			
			$contact_Type='';
			$fname='';
			$lname='';
			if(isset($condition['typeofcontact']) && $condition['typeofcontact']!=''){
			   
				$contact_Type=$condition['typeofcontact'];
				 
					$detailTable='';
					$master_Table="";
					$swithvalue=$contact_Type;
					switch($swithvalue){
					case 'Custodial Parent':
					case 'Head of Household':
					case 'Others':
					case 'Petitioner':
					case 'Representative':
					case 'Respondent':
					case 'CPAFirm':
							$detailTable="peopledetails"; 
						break;

						case 'Case Worker':
						case 'Hearing Coordinator':
						case 'Investigator':
						case 'Agency Contact':
						case 'Employer':
						case 'School District':
						case 'Candidate':
						case 'Probate Judge':
						case 'Administrator':
							$detailTable="agencycaseworkerbycase"; 
							$master_Table="agencycaseworkercontact";
						break;

						case 'Minor/children':
								$detailTable="minordetails";
						break;
						case 'Officer':
								 $detailTable="agencycaseworkerbycase";    
								 $master_Table="officerdetails";
						break;
						case 'Other Attorney':
						case 'Petitioner Attorney':
						case 'Respondent Attorney':
						case 'Agency Attorney':
							$detailTable="attorneybycase";
							$master_Table="attorney";       
						break;
				}
				$condition=''; $joincondition='';
				if($fname!='' && $lname!=''){
					 if($master_condition!='')
						$joincondition=" and dyn.typeofcontact='{$contact_Type}' and dyn.Firstname='{$fname}' and dyn.Lastname='{$lname}'";
					 else
						$joincondition="dyn.typeofcontact='{$contact_Type}' and dyn.Firstname='{$fname}' and dyn.Lastname='{$lname}'";  
					}
				if($fname!='' && $lname==''){
					if($master_condition!='')
						$joincondition=" and dyn.typeofcontact='{$contact_Type}' and dyn.Firstname='{$fname}'";
					else
						$joincondition=" dyn.typeofcontact='{$contact_Type}' and dyn.Firstname='{$fname}'";
				}
				if($lname!='' && $fname==''){
					if($master_condition!='')  
						$joincondition=" && dyn.typeofcontact='{$contact_Type}' and dyn.Lastname='{$lname}'";
					 else
						$joincondition=" dyn.typeofcontact='{$contact_Type}' and dyn.Lastname='{$lname}'";
				}

				$sqlJoin="select doc.caseid,doc.casetype,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.hearingsite,REPLACE(doc.status,'Hearing Re-scheduled','Rescheduled') AS status,doc.judge from
				docket as doc inner join {$detailTable} as dyn on doc.caseid=dyn.caseid where {$master_condition}{$joincondition}";
				$result= $docket_resultset = $OsahDb->getDatabySql($db,$sqlJoin);
				$caseids="";
				$i=0;
				foreach ( $result as $data) {
					$caseids.=($i==0)?$data['caseid']:','.$data['caseid'];
					$i++;
				}

				$sql="select CONCAT(Lastname,' ',Firstname) as name,caseid,Lastname,Firstname,typeofcontact from peopledetails where  caseid IN({$caseids})";
				$casename_resultset = $OsahDb->getDatabySql($db,$sql);
				$docket_resultset = $this->sortingdataall($docket_resultset,$casename_resultset);
				foreach($docket_resultset as $result)
				{
					unset($result['Lastname'],  $result['Firstname']);
					array_push($final_result,$result);
				}
			}else if($name_Flage==1){
				/*If Contact type is not selected */
				$sqlJoin="select doc.caseid,doc.casetype,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.hearingsite,REPLACE(doc.status,'Hearing Re-scheduled','Rescheduled') AS status,doc.judge from
				docket as doc inner join peopledetails as dyn on doc.caseid=dyn.caseid where {$master_condition} && dyn.typeofcontact='petitioner' && {$name_condition}";
				$result= $docket_resultset = $OsahDb->getDatabySql($db,$sqlJoin);
				$caseids="";
				$i=0;
				foreach ( $result as $data) {
					$caseids.=($i==0)?$data['caseid']:','.$data['caseid'];
					$i++;
				}
				$sql="select caseid,Lastname,Firstname,typeofcontact from peopledetails where  caseid IN({$caseids})";
				$casename_resultset = $OsahDb->getDatabySql($db,$sql);
				$docket_resultset = $this->sortingdataall($docket_resultset,$casename_resultset); 
				foreach($docket_resultset as $result)
				{
					unset($result['Lastname'],  $result['Firstname']);
					array_push($final_result,$result);
				}
			}else{
				$sqlJoin="select doc.caseid,doc.casetype,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.hearingsite,REPLACE(doc.status,'Hearing Re-scheduled','Rescheduled') AS status,doc.judge from
				docket as doc where {$master_condition}";
				$result= $docket_resultset = $OsahDb->getDatabySql($db,$sqlJoin);
				$caseids="";
				$i=0;
				foreach ( $result as $data) {
					$caseids.=($i==0)?$data['caseid']:','.$data['caseid'];
					$i++;
				}
				$sql="select CONCAT(Lastname,' ',Firstname) as name,caseid,Lastname,Firstname,typeofcontact from peopledetails where  caseid IN({$caseids})";
				$casename_resultset = $OsahDb->getDatabySql($db,$sql);
				$i=0;
				$docket_resultset = $this->sortingdataall($docket_resultset,$casename_resultset);
				foreach($docket_resultset as $result)
				{
					unset($result['Lastname'],  $result['Firstname']);
					array_push($final_result,$result);
				}
			}
			
			
			foreach($final_result as $key => $value)
			{
				$result_arr['caseid'] = $value['caseid'];
				if(array_key_exists("name",$value))
				{
					$name = $value['name'];
				}else{
					$name = '';
				}
				$result_arr['name'] = $name;
				$result_arr['casetype'] = $value['casetype'];
				$result_arr['datereceiveddisplay'] = $value['datereceiveddisplay'];
				$result_arr['hearingdateDisplay'] = $value['hearingdateDisplay'];
				$result_arr['hearingtimeDisplay'] = $value['hearingtimeDisplay'];
				$result_arr['hearingsite'] = $value['hearingsite'];
				$result_arr['status'] = $value['status'];
				$result_arr['judge'] = $value['judge'];
				
				array_push($export_arr,$result_arr);
			}
		}else{ //fetch closed cases
		
		
		$from_date = $condition['dcfrom'];
		$to_date = $condition['dcto'];
		
		if(isset($condition['boxno']) && $condition['boxno']!='')
		{
			$boxno = "and boxno ='".$condition['boxno']."'";
		}else{
			$boxno = '';
		}
		if(isset($condition['judge']) && $condition['judge']!='')
		{
			$judge =  "and judge ='".$condition['judge']."'";
		}else{
			$judge = '';
		}
		if(isset($condition['agency']) && $condition['agency']!='')
		{
			$agency = "and refagency ='".$condition['agency']."'";
		}else{
			$agency = '';
		}
		if(isset($condition['casetype']) && $condition['casetype']!='')
		{
			$casetype = "and casetype ='". $condition['casetype']."'";
		}else{
			$casetype = '';
		}
		if(isset($condition['county']) && $condition['county']!='')
		{
			$county = "and county ='".$condition['county']."'";
		}else{
			$county = '';
		}
		$sqlJoin ="SELECT doc.caseid,doc.docketnumber,doc.docketclerk,doc.hearingreqby, doc.daterequested,doc.status,doc.datereceivedbyOSAH,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,doc.refagency,doc.casetype,doc.casefiletype,doc.county,doc.agencyrefnumber,doc.hearingmode,doc.hearingsite,doc.hearingdate,
      DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,doc.hearingtime,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.judge,doc.judgeassistant,doc.hearingrequesteddate,doc.others,doc.docket_createddate FROM docket as doc WHERE caseid in (Select caseid from docketdisposition where dispositiondate between '".$from_date."' and '".$to_date."' $boxno )$judge $agency $county $casetype order by hearingdate desc";
            $result= $docket_resultset = $OsahDb->getDatabySql($db,$sqlJoin);
            $caseids="";
            $i=0;
            foreach ( $result as $data) {
                $caseids.=($i==0)?$data['caseid']:','.$data['caseid'];

                $i++;
            }

             $sql="select CONCAT(Lastname,' ',Firstname) as name,caseid,Lastname,Firstname,typeofcontact from peopledetails where  caseid IN({$caseids})";
             $casename_resultset = $OsahDb->getDatabySql($db,$sql);
             $i=0;

            $docket_resultset = $this->sortingdataall($docket_resultset,$casename_resultset);
				foreach($docket_resultset as $result)
				{
					unset($result['Lastname'],  $result['Firstname']);
					array_push($final_result,$result);
				}
			// print_r($final_result);exit;
			foreach($final_result as $key => $value)
			{
				$result_arr['caseid'] = $value['caseid'];
				if(array_key_exists("name",$value))
				{
					$name = $value['name'];
				}else{
					// $value['name'] = "scdc";
					$name = '';
				}
				$result_arr['name'] = $name;
				$result_arr['casetype'] = $value['casetype'];
				$result_arr['datereceiveddisplay'] = $value['datereceiveddisplay'];
				$result_arr['hearingdateDisplay'] = $value['hearingdateDisplay'];
				$result_arr['hearingtimeDisplay'] = $value['hearingtimeDisplay'];
				$result_arr['hearingsite'] = $value['hearingsite'];
				$result_arr['status'] = $value['status'];
				$result_arr['judge'] = $value['judge'];
				array_push($export_arr,$result_arr);
		
		}
	}
		// uasort($export_arr, function($a) {
				// return (is_null($a['name']) OR $a['name'] == "") ? 1 : -1;
			// });
		usort($export_arr, function($a, $b) {
			return strcmp($a['name'], $b['name']);
		});
		$header = array(
					'Docket',
					'Case Name',
					'Case Type',
					'Date Received',
					'Hearing Date',
					'Hearing Time',
					'Hearing Location',
					'Status',
					'Judge'
					
				);
		
		return $this->csvExport('excelsheet'. date('Y-m-d').'.csv', $header, $export_arr);
	}
	
	/*  Name : FaisalK
	  Date Created : 16-11-2016
	  Description : search result pagination
	*/
	public function searchResultAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true);
    //$passed_data=explode("/",$param['condition']);  

    // echo "<pre>"; print_r($param['condition']['status']); exit;
    $master_condition="";

    if(isset($param['condition']['agencyrefnumber']) && $param['condition']['agencyrefnumber']!=''){
            $master_condition .=( $master_condition=='')?"doc.agencyrefnumber='".$param['condition']['agencyrefnumber']."'":"doc.agencyrefnumber='".$param['condition']['agencyrefnumber']."'";
    }

    $master_condition .=( $master_condition=='')?"doc.telv_o_five='1'":"doc.telv_o_five='1'";



    if(isset($param['condition']['county']) && $param['condition']['county']!=''){
            $master_condition .=( $master_condition=='')?"doc.county='".$param['condition']['county']."'":" && doc.county='".$param['condition']['county']."'";
    }        

    if(isset($param['condition']['status']) && $param['condition']['status']!=''){
             if($param['condition']['status']=='NA'){
                 $master_condition .=( $master_condition=='')?"doc.status!='Closed'":" && doc.status!='Closed'";
             } else if($param['condition']['status']=='All'){
				$master_condition.=( $master_condition=='')?"doc.status!=''":" && doc.status!=''";
			 } 
			 else{
                 $master_condition .=( $master_condition=='')?"doc.status='".$param['condition']['status']."'":" && doc.status='".$param['condition']['status']."'";
             }  

    }

    if(isset($param['condition']['refagency']) && $param['condition']['refagency']!=''){
            $master_condition .=( $master_condition=='')?"doc.refagency='".$param['condition']['refagency']."'":" && doc.refagency='".$param['condition']['refagency']."'";
    }

    if(isset($param['condition']['casetype']) && $param['condition']['casetype']!=''){
            $master_condition .=( $master_condition=='')?"doc.casetype='".$param['condition']['casetype']."'":" && doc.casetype='".$param['condition']['casetype']."'";
    }

    if(isset($param['condition']['judge']) && $param['condition']['judge']!=''){
            $master_condition .=( $master_condition=='')?"doc.judge='".$param['condition']['judge']."'":" && doc.judge='".$param['condition']['judge']."'";
    }

    if(isset($param['condition']['judgeassistant']) && $param['condition']['judgeassistant']!=''){
            $master_condition .=( $master_condition=='')?"doc.judgeassistant='".$param['condition']['judgeassistant']."'":" && doc.judgeassistant='".$param['condition']['judgeassistant']."'";
    }

    if(isset($param['condition']['hearingsite']) && $param['condition']['hearingsite']!=''){
            $master_condition .=( $master_condition=='')?"doc.hearingsite='".$param['condition']['hearingsite']."'":" && doc.hearingsite='".$param['condition']['hearingsite']."'";
    }

    if(isset($param['condition']['hearingdate_From']) && $param['condition']['hearingdate_From']!=''){
            $master_condition .=( $master_condition=='')?"doc.hearingdate >='".$param['condition']['hearingdate_From']."'":" && doc.hearingdate >='".$param['condition']['hearingdate_From']."'";
    }

    if(isset($param['condition']['hearingdate_To']) && $param['condition']['hearingdate_To']!=''){
            $master_condition .=( $master_condition=='')?"doc.hearingdate <='".$param['condition']['hearingdate_To']."'":" && doc.hearingdate <='".$param['condition']['hearingdate_To']."'";
    }
	
	if(isset($param['condition']['calendarhearingdate']) && $param['condition']['calendarhearingdate']!=''){
            $master_condition .=( $master_condition=='')?"doc.hearingdate ='".$param['condition']['calendarhearingdate']."'":" && doc.hearingdate ='".$param['condition']['calendarhearingdate']."'";
    }

    if(isset($param['condition']['datereceivedbyOSAH_From']) && $param['condition']['datereceivedbyOSAH_From']!=''){
            $master_condition .=( $master_condition=='')?"doc.datereceivedbyOSAH >='".$param['condition']['datereceivedbyOSAH_From']."'":" && doc.datereceivedbyOSAH >='".$param['condition']['datereceivedbyOSAH_From']."'";
    }

    if(isset($param['condition']['datereceivedbyOSAH_To']) && $param['condition']['datereceivedbyOSAH_To']!=''){
            $master_condition .=( $master_condition=='')?"doc.datereceivedbyOSAH <='".$param['condition']['datereceivedbyOSAH_To']."'":" && doc.datereceivedbyOSAH <='".$param['condition']['datereceivedbyOSAH_To']."'";
    }

    if(isset($param['condition']['hearingtime']) && $param['condition']['hearingtime']!=''){
            $master_condition .=( $master_condition=='')?"doc.hearingtime='".$param['condition']['hearingtime']."'":" && doc.hearingtime='".$param['condition']['hearingtime']."'";
    }
	// echo $master_condition;exit;
     //(isset($param['condition']['status']) && $param['condition']['status']=='NA')?'!=Closed':$param['condition']['status'];

    $contact_Type='';
    $fname='';
    $lname='';

     $qry_string=$param['condition'];
     $qry_string2=$param['condition'];

     /*To Set the Pagination and sorting order Start Here*/
     $limit=$param['addtional_condition']['length'];
     $order_by=$param['addtional_condition']['orderby'].' '.($param['addtional_condition']['order']?'desc':'');
     $offset= $param['addtional_condition']['start'];
    /*To Set the Pagination and sorting order End Here*/

    /*Check the First Name and last name is there or not*/

         $name_Flage=0;
         $name_condition="";
        if(isset($param['condition']['Lastname']) && $param['condition']['Lastname']!=''){
            $lname=$param['condition']['Lastname'];
            $name_Flage=1;
             $name_condition .=( $name_condition=='')?"dyn.Lastname='".$param['condition']['Lastname']."'":" && dyn.Lastname='".$param['condition']['Lastname']."'";
        }

        if(isset($param['condition']['Firstname']) && $param['condition']['Firstname']!=''){
            $fname=$param['condition']['Firstname'];
            $name_Flage=1;
            $name_condition .=( $name_condition=='')?"dyn.Firstname='".$param['condition']['Firstname']."'":" && dyn.Firstname='".$param['condition']['Firstname']."'";
        }


    /*Check The Contact type is selected or not*/
    /*echo strpos($param['condition'],"Custodial");*/
    $OsahDb=New OsahDbFunctions();


    if(isset($param['condition']['typeofcontact']) && $param['condition']['typeofcontact']!=''){

        $contact_Type=$param['condition']['typeofcontact'];

            $detailTable='';
            $master_Table="";


                $swithvalue=$contact_Type;
                  //echo $swithvalue; exit();

            switch($swithvalue){


                case 'Custodial Parent':
                case 'Head of Household':
                case 'Others':
                case 'Petitioner':
                case 'Representative':
                case 'Respondent':
				case 'CPAFirm':
				
                    $detailTable="peopledetails"; 
                break;

                case 'Case Worker':
                case 'Hearing Coordinator':
                case 'Investigator':
				case 'Agency Contact':
				case 'Employer':
				case 'School District':
				case 'Candidate':
				case 'Probate Judge':
				case 'Administrator':
				
                    $detailTable="agencycaseworkerbycase"; 
                    $master_Table="agencycaseworkercontact";
                break;

                case 'Minor/children':
                        $detailTable="minordetails";
                break;



                case 'Officer':
                         $detailTable="agencycaseworkerbycase";    
                         $master_Table="officerdetails";

                break;



                case 'Other Attorney':
                case 'Petitioner Attorney':
                case 'Respondent Attorney':
                case 'Agency Attorney':
                        $detailTable="attorneybycase";
                        $master_Table="attorney";

                break;
                /*default:
                        $detailTable="attorneybycase";

                break;*/





      }
       //echo "Table Name ".$detailTable; exit;






//$result = $OsahDb->searchResult($db,$tableName,$condition,$addtionalCondition,0);
     $condition=''; $joincondition='';
        if($fname!='' && $lname!=''){
            //$sql="select caseid from {$detailTable} where typeofcontact = $contact_Type and Firstname=$fname and Lastname=$lname";
             if($master_condition!='')
                    $joincondition=" and dyn.typeofcontact='{$contact_Type}' and dyn.Firstname='{$fname}' and dyn.Lastname='{$lname}'";
             else
                     $joincondition="dyn.typeofcontact='{$contact_Type}' and dyn.Firstname='{$fname}' and dyn.Lastname='{$lname}'";  
        }
        if($fname!='' && $lname==''){
            //$sql="select caseid from {$detailTable} where typeofcontact = $contact_Type and Firstname=$fname";
            if($master_condition!='')
                $joincondition=" and dyn.typeofcontact='{$contact_Type}' and dyn.Firstname='{$fname}'";
            else
                $joincondition=" dyn.typeofcontact='{$contact_Type}' and dyn.Firstname='{$fname}'";
        }
        if($lname!='' && $fname==''){
            //$sql="select caseid from {$detailTable} where typeofcontact = $contact_Type and Lastname=$lname";
               if($master_condition!='')  
                    $joincondition=" && dyn.typeofcontact='{$contact_Type}' and dyn.Lastname='{$lname}'";
                else
                    $joincondition=" dyn.typeofcontact='{$contact_Type}' and dyn.Lastname='{$lname}'";
        }

     $sqlJoin="select doc.caseid,doc.docketnumber,doc.docketclerk,doc.hearingreqby,REPLACE(doc.status,'Hearing Re-scheduled','Rescheduled') AS status,
      doc.daterequested,doc.datereceivedbyOSAH,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,doc.refagency,doc.casetype,doc.casefiletype,doc.county,doc.agencyrefnumber,doc.hearingmode,doc.hearingsite,doc.hearingdate,
      DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,doc.hearingtime,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.judge,doc.judgeassistant,doc.hearingrequesteddate,doc.others,doc.docket_createddate from
      docket as doc inner join {$detailTable} as dyn on doc.caseid=dyn.caseid where {$master_condition}{$joincondition}";
	   
             //if(isset($passed_data[3]) && $passed_data[3]!=''){ $condition .=" and ".$passed_data[3]; }

            //if(isset($passed_data[4]) && $passed_data[4]!=''){ $condition .=" and ".$passed_data[4]; }

        // echo $sqlJoin; exit;
        $return_array= array(
                'total' => $OsahDb->getDatabySql($db,$sqlJoin,1)
        );












         //$extcond=" ORDER BY {$order_by} LIMIT {$limit} OFFSET {$offset}";
                // $case_cond="select doc.caseid from docket AS doc inner join {$detailTable} as dyn on doc.caseid=dyn.caseid where {$master_condition}{$joincondition}";
				if($return_array['total']>0)
				{
                $sqlJoin .=($param['addtional_condition']['orderby']!='Lastname')?" ORDER BY {$order_by}":"";
                $sqlJoin .=" LIMIT {$limit} OFFSET {$offset}";
                // $case_cond .=($param['addtional_condition']['orderby']!='Lastname')?" ORDER BY {$order_by}":"";
                // $case_cond .=" LIMIT {$limit} OFFSET {$offset}";

            //$condition2=$condition="caseid in({$caseids})";

            //if(isset($passed_data[3]) && $passed_data[3]!=''){ $condition .=" and ".$passed_data[3]; }

            //if(isset($passed_data[4]) && $passed_data[4]!=''){ $condition .=" and ".$passed_data[4]; }
             // $sql="select caseid,docketnumber,docketclerk,hearingreqby,REPLACE(status,'Hearing Re-scheduled','Rescheduled') AS status,daterequested,datereceivedbyOSAH,DATE_FORMAT(datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,refagency,casetype,casefiletype,county,agencyrefnumber,hearingmode,hearingsite,hearingdate,DATE_FORMAT(hearingdate,'%m-%d-%Y') AS hearingdateDisplay,hearingtime,TIME_FORMAT(hearingtime, '%h:%i %p')as hearingtimeDisplay,judge,judgeassistant,hearingrequesteddate,others,docket_createddate from docket where ";
             // echo $sql.$condition.$extcond; exit;
             $result= $docket_resultset = $OsahDb->getDatabySql($db,$sqlJoin);
             $caseids="";
             $i=0;
			foreach ( $result as $data) {
				$caseids.=($i==0)?$data['caseid']:','.$data['caseid'];
				$i++;
			}


             $extcond=($param['addtional_condition']['orderby']=='Lastname')?" ORDER BY {$order_by}":"";

             $sql="select caseid,Lastname,Firstname,typeofcontact from peopledetails where  caseid IN({$caseids})";
             $casename_resultset = $OsahDb->getDatabySql($db,$sql);
                $i=0;

             if($param['addtional_condition']['orderby']=='Lastname'){
                 $docket_resultset = $this->sortingdatacasename($casename_resultset,$docket_resultset);

            }else{

                 $docket_resultset = $this->sortingdataall($docket_resultset,$casename_resultset);
            }     

            /*if($param['addtional_condition']['orderby']=='Lastname'){

                foreach ($casename_resultset as $data_casename) {
                    $party_fname=$party_lname='';
                        foreach ( $docket_resultset as $data_docket) {
                            if($data_docket['caseid']==$data_casename['caseid']){
                                if($data_casename['typeofcontact']=='petitioner'){
                                    $docket_resultset[$i]['Lastname']=$data_casename['Lastname'];
                                    $docket_resultset[$i]['Firstname']=$data_casename['Firstname'];
                                }else if($data_casename['typeofcontact']=='Respondent'){
                                    $docket_resultset[$i]['Lastname']=$data_casename['Lastname'];
                                    $docket_resultset[$i]['Firstname']=$data_casename['Firstname'];
                                }   
                            }
                        }
                    $i++;
                }
            }else{

                foreach ($docket_resultset as $data_docket) {
                    $party_fname=$party_lname='';
                    foreach ($casename_resultset as $data_casename) {
                        if($data_docket['caseid']==$data_casename['caseid']){
                            if($data_casename['typeofcontact']=='petitioner'){
                                $docket_resultset[$i]['Lastname']=$data_casename['Lastname'];
                                $docket_resultset[$i]['Firstname']=$data_casename['Firstname'];
                            }else if($data_casename['typeofcontact']=='Respondent'){
                                $docket_resultset[$i]['Lastname']=$data_casename['Lastname'];
                                $docket_resultset[$i]['Firstname']=$data_casename['Firstname'];
                            }   
                        }
                    }
                    $i++;
                }

            }*/    





			$return_array['data']=$docket_resultset;
			echo json_encode($return_array);
			exit;
		}else{
			echo json_encode($return_array);
			exit;
		}

    }else if($name_Flage==1){
        /*If Contact type is not selected */

        $sqlJoin="select doc.caseid,doc.docketnumber,doc.docketclerk,doc.hearingreqby,REPLACE(doc.status,'Hearing Re-scheduled','Rescheduled') AS status,
      doc.daterequested,doc.datereceivedbyOSAH,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,doc.refagency,doc.casetype,doc.casefiletype,doc.county,doc.agencyrefnumber,doc.hearingmode,doc.hearingsite,doc.hearingdate,
      DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,doc.hearingtime,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.judge,doc.judgeassistant,doc.hearingrequesteddate,doc.others,doc.docket_createddate from
      docket as doc inner join peopledetails as dyn on doc.caseid=dyn.caseid where {$master_condition} && dyn.typeofcontact='petitioner' && {$name_condition}";
        $return_array= array(
                'total' => $OsahDb->getDatabySql($db,$sqlJoin,1)
        );
		if($return_array['total']>0)
		{
			$sqlJoin .=($param['addtional_condition']['orderby']!='Lastname')?" ORDER BY {$order_by}":"";
			$sqlJoin .=" LIMIT {$limit} OFFSET {$offset}";

            $result= $docket_resultset = $OsahDb->getDatabySql($db,$sqlJoin);

            $caseids="";
            $i=0;
            foreach ( $result as $data) {
                $caseids.=($i==0)?$data['caseid']:','.$data['caseid'];

                $i++;
            }

            $extcond=($param['addtional_condition']['orderby']=='Lastname')?" ORDER BY {$order_by}":"";

             $sql="select caseid,Lastname,Firstname,typeofcontact from peopledetails where  caseid IN({$caseids})";
              // echo $sql; exit;
             $casename_resultset = $OsahDb->getDatabySql($db,$sql);

            if($param['addtional_condition']['orderby']=='Lastname'){
                 $docket_resultset = $this->sortingdatacasename($casename_resultset,$docket_resultset);

            }else{

                 $docket_resultset = $this->sortingdataall($docket_resultset,$casename_resultset);
            }      

			$return_array['data']=$docket_resultset;
			echo json_encode($return_array);
			exit;
		}else{
			echo json_encode($return_array);
			exit;
		}


    }else{


        $sqlJoin="select doc.caseid,doc.docketnumber,doc.docketclerk,doc.hearingreqby,REPLACE(doc.status,'Hearing Re-scheduled','Rescheduled') AS status,
      doc.daterequested,doc.datereceivedbyOSAH,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,doc.refagency,doc.casetype,doc.casefiletype,doc.county,doc.agencyrefnumber,doc.hearingmode,doc.hearingsite,doc.hearingdate,
      DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,doc.hearingtime,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.judge,doc.judgeassistant,doc.hearingrequesteddate,doc.others,doc.docket_createddate from
      docket as doc where {$master_condition}";
        $return_array= array(
                'total' => $OsahDb->getDatabySql($db,$sqlJoin,1)
        );
		if($return_array['total']>0)
		{
			$sqlJoin .=($param['addtional_condition']['orderby']!='Lastname')?" ORDER BY {$order_by}":"";
			$sqlJoin .=" LIMIT {$limit} OFFSET {$offset}";
			
            $result= $docket_resultset = $OsahDb->getDatabySql($db,$sqlJoin);
			
            $caseids="";
            $i=0;
			foreach ( $result as $data) {
				$caseids.=($i==0)?$data['caseid']:','.$data['caseid'];

				$i++;
			}
            $extcond=($param['addtional_condition']['orderby']=='Lastname')?" ORDER BY {$order_by}":"";

             $sql="select caseid,Lastname,Firstname,typeofcontact from peopledetails where  caseid IN({$caseids})";
             $casename_resultset = $OsahDb->getDatabySql($db,$sql);
			$i=0;
            if($param['addtional_condition']['orderby']=='Lastname'){
                 $docket_resultset = $this->sortingdatacasename($casename_resultset,$docket_resultset);
			}else{
				$docket_resultset = $this->sortingdataall($docket_resultset,$casename_resultset);
            }
			$return_array['data']=$docket_resultset;
			echo json_encode($return_array);
			exit;
		}else{
			echo json_encode($return_array);
			exit;
		}
         



    }

    /*$tableName = $param['tableName'];
    $condition = $param['condition'];
    $addtionalCondition = $param['addtional_condition'];
    $OsahDb=New OsahDbFunctions();
    $result = $OsahDb->searchResult($db,$tableName,$condition,$addtionalCondition,0);
    echo json_encode($result);
    exit;*/
}


    /*  Name : Amol S
      Date Created : 07-02-2017
      Description : This is supporting function for  Advance search
    */
    public function sortingdataall($docket_resultset= array(),$casename_resultset = array() ){
            $i=0; 
            foreach ($docket_resultset as $data_docket) {
                        $party_fname=$party_lname='';
                        foreach ($casename_resultset as $data_casename) {
                                if(@$data_docket['caseid']==@$data_casename['caseid'] && @$data_docket['caseid']!='' && @$data_casename['caseid']!=''){
                               if(ucfirst($data_casename['typeofcontact'])=='Petitioner'){
                                    $docket_resultset[$i]['Lastname']=$data_casename['Lastname'];
                                    $docket_resultset[$i]['Firstname']=$data_casename['Firstname'];
									$docket_resultset[$i]['name'] = $data_casename['Lastname'].','.$data_casename['Firstname'];
                                }else if($data_casename['typeofcontact']=='Respondent'){
                                    $docket_resultset[$i]['Lastname']=$data_casename['Lastname'];
                                    $docket_resultset[$i]['Firstname']=$data_casename['Firstname'];
									$docket_resultset[$i]['name'] = $data_casename['Lastname'].','.$data_casename['Firstname'];
                                }   
                            }
                        }
                        $i++;
                    }

        return  $docket_resultset;
    }

    /*  Name : Amol S
      Date Created : 07-02-2017
      Description : This is supporting function for  Advance search
    */
    public function sortingdatacasename($casename_resultset = array(), $docket_resultset = array() ){
            



            $i=0; 
            foreach ($casename_resultset as $data_casename) {
                        $party_fname=$party_lname='';
                        foreach ( $docket_resultset as $data_docket) {
                            if(@$data_docket['caseid']==@$data_casename['caseid'] && @$data_docket['caseid']!='' && @$data_casename['caseid']!=''){
                                if($data_casename['typeofcontact']=='petitioner'){
                                    $docket_resultset[$i]['Lastname']=$data_casename['Lastname'];
                                    $docket_resultset[$i]['Firstname']=$data_casename['Firstname'];
                                }else if($data_casename['typeofcontact']=='Respondent'){
                                    $docket_resultset[$i]['Lastname']=$data_casename['Lastname'];
                                    $docket_resultset[$i]['Firstname']=$data_casename['Firstname'];
                                }   
                            }
                        }
                $i++;
            }   
           /* echo "<pre>";
            print_r($docket_resultset); exit;*/
        return  $docket_resultset;
    }





	/*  Name : FaisalK
	  Date Created : 29-11-2016
	  Description : calendar management
	*/
	public function calendarManagementAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		$tableName = 'calendar_view';//$param['tableName'];
		$condition = $param;
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->calendarManagement($db,$tableName,$condition,0);
		
		echo json_encode($result);
		exit;
	}
	 /* 
    Name : Neha
    Date Created : 29-11-2016
    Date Modified:   
    Description : getdocumenttypesAction Function will get the all document types from documenttypes table.
    */
    public function getdocumenttypesAction(){
		  $db=$this->serviceLocator->get('db1');
           $OsahDb=New OsahDbFunctions();
		   $condition = "";
		
        $result = $OsahDb->getData($db,"documenttypes",$condition,0);
        echo json_encode($result);exit;

    }
	
	/* 

	*/
	public function adddocumentAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true);
		// print_r($param);exit;
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->insertData($db,"documentstable",$param['documentdata']);
		echo $result;exit;
	}
	/*  Name : Affan Shaikhj
	  Date Created : 29-11-2016
	  Description : Get Casetype groups
	*/
	public function getcasetypegrouplistAction(){
            
        $db=$this->serviceLocator->get('db1');
        $sql="select casetypegroup,id from casetypegroups ORDER BY casetypegroup DESC";
        $OsahDb=New OsahDbFunctions();
        $result = $OsahDb->getDatabySql($db,$sql);
        echo json_encode($result);
        exit;
     }
	 
	 /* 
		Author Name : Affan
		Description : Function is used to add Notes details regarding docket number.
		Created Date : 08-11-2016
		*/
		public function insertcalendardataAction()
		{
			error_reporting(E_WARNING);
			
			//$session = new Container('base');
			$param= json_decode(file_get_contents('php://input'),true);
			$db=$this->getServiceLocator()->get('db1');
			if(isset($param)){		
				$OsahDb=New OsahDbFunctions();
				$result = $OsahDb->insertData($db,'calendarform', $param,1);
				// print_r($result);exit;
				if($result){
					 echo json_encode(array('result'=>"1",'calendarid'=>$result));
				}
			}
			exit;

		}
	/* 
		Name : FaisalK
		Date Created : 2016-12-05
		Date Modified:   
		Description : deleteCalendarAction Function is used to delete the calendar.
    */
	public function deleteCalendarAction(){
		$db=$this->serviceLocator->get('db1');
        $param= json_decode(file_get_contents('php://input'),true);
		$OsahDb=New OsahDbFunctions();
		// $result = $OsahDb->deleteData($db,"calendarhistory",$param);
		$result = $OsahDb->deleteData($db,"schedule",$param);
		$result = $OsahDb->deleteData($db,"calendarform",$param);
		echo ($result)?1:0;exit;
	}
	/* 
		Name : FaisalK
		Date Created : 2016-12-05
		Date Modified:   
		Description : Function is used to update Calendar.
	*/
	public function updateCalendarAction()
	{
		
		$db=$this->serviceLocator->get('db1');
		$session = new Container('base');
		$param= json_decode(file_get_contents('php://input'),true);
		$condition = array('Calendarid' => $param['Calendarid']);
		unset($param['Calendarid']);
		if($param['noofcases']=='') $param['noofcases']=null;
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->updateData($db,"calendarform",$param,$condition);
		echo $result;exit;
	}

    /* 
  Name : Amol S
  Date Created : 30-11-2016
  Description : Function is used to get the upcomming calanders Data User Wise.
 */
 public function getupcomingcalendardataAction(){
    $session = new Container('base');
    $user_type = '';
    $fieldName="";
     $today_date = date("Y-m-d");
    $db=$this->serviceLocator->get('db1');
    $param= json_decode(file_get_contents('php://input'),true); 
    //$param['searchFlage']==1 is for Get the data as per search fields
    if(isset($param['searchFlage']) && $param['searchFlage']==1 && $param['condition']!=''){
		$condition=$param['condition']; 
		if(stripos($condition,'hearingdate'))
		{
			$condition; 
		}else{
			$condition = "$condition && hearingdate >= '$today_date'";
		}
    }else{
            if($session->user_type=='judge'){
                $fieldName="judge";
            }
            if($session->user_type=='cma'){
                 $fieldName="assistant";
            }
        $username=$session->LastName.", ".$session->FirstName;
        $user_type = " and ".$fieldName."='$username'";
        $condition="hearingdate >= '$today_date' $user_type order by hearingdate ASC";
        //$condition="hearingdate > '2015-06-09' $user_type order by hearingdate ASC";
    }

    $OsahDb=New OsahDbFunctions();
       
    $final_result = array();
    $result = $OsahDb->getData($db,'upcomingcalendars',$condition,0);
		foreach ($result as $value) {
			
			$hdate = $value['hearingdate'];
			$judge_name = $value['judgevalue'];
			$assist_name = $value['assistantvalue'];
			$hearing_site = $value['locationname'];
			$hearing_time = $value['heringtimestored'];
			 $sql="select count(*) as total from docket where hearingdate = '$hdate' and judge = '$judge_name' and judgeassistant = '$assist_name' and hearingtime = '$hearing_time' and hearingsite = '$hearing_site' and status!='Closed'";
			$total_count = $OsahDb->getDatabySql($db,$sql);
			$total = $total_count[0]['total'];
			$value['total'] = $total;
			array_push($final_result, $value);
		}
		
     echo json_encode($final_result);
      exit;
 }

  /* 
  Name : Amol S
  Date Created : 01-12-2016
  Description : Function is used to get the upcomming calanders Data User Wise.
 */
 public function getupcomingcalendarjudgeslistAction(){
    $session = new Container('base');
    $user_type = '';
    $fieldName="";
     
    $db=$this->serviceLocator->get('db1');
    $param= json_decode(file_get_contents('php://input'),true); 
    //$param['searchFlage']==1 is for Get the data as per search fields
    if(isset($param['searchFlage']) && $param['searchFlage']==1 && $param['condition']!=''){
         
         $condition=$param['condition'];   
    }else{
            if($session->user_type=='judge'){
                $fieldName="judge";
            }
            if($session->user_type=='cma'){
                 $fieldName="assistant";
            }
        $username=$session->LastName.", ".$session->FirstName;
        $user_type = $fieldName."='$username'";
        //$condition="hearingdate > '$today_date' $user_type order by hearingdate ASC";
        $condition="$user_type";
    }

    $OsahDb=New OsahDbFunctions();
    $sql="select judge from upcomingcalendars where ".$condition."group by judge_id";
	// print_r($sql);exit;
    $result = $OsahDb->getDatabySql($db,$sql);

     echo json_encode($result);
    
      exit;
 }
	/* 
		Name : Neha Agrawal
		Description : Function is used to add the docket number
		Created On : 05-12-2016
		Modified Date : 02-01-2017
	*/
		public function adddocketAction()
		{
			$db=$this->serviceLocator->get('db1');
			$param= json_decode(file_get_contents('php://input'),true);
			// print_r($param);exit;
			$OsahDb=New OsahDbFunctions();
			$today_date = date("m-d");
			$fiscal_date = "07-01";
			if($today_date == $fiscal_date)
			{
				$current_year = date("y");
				$caseid = $current_year.'00001';
			}else{
				$caseid="";
			}
			$agency = $param['docketdetails']['refagency'];
			$case_type = $param['docketdetails']['casetype'];
			if(isset($param['location_id']['location_id']))
			{
				$location_id = $param['location_id']['location_id'];
			}else{
				$location_id = 'UNASSIGNED';
			}
			
			$judge = $param['docketdetails']['judge'];
			$split_judgename = explode(" ", $judge);
			$judge_firstname = $split_judgename[0];
			if($caseid!='')
			{
				$searchCondition = 'caseid ="'.$caseid.'"';
				$result = $OsahDb->getData($db,'docket',$searchCondition,0);
				if(empty($result))
				{
					$addCaseid = array(
							'caseid'=>$caseid
						);
					$updatedData = array_merge($param['docketdetails'],$addCaseid);
					$docketid = $OsahDb->insertData($db,"docket",$updatedData,1);
				}else{
					$docketid = $OsahDb->insertData($db,"docket",$param['docketdetails'],1);
				}
			}else{
                $docketid = $OsahDb->insertData($db,"docket",$param['docketdetails'],1);
			}
				if($docketid==0 || $docketid=='' || $docketid==null)
				{
					$docketid = $caseid;
				}
				$docketnumber = $agency.'-'.$case_type.'-'.$docketid.'-'.$location_id.'-'.$judge_firstname;
				$condition = array('caseid' => $docketid);
						$data = array(
								'docketnumber'=>$docketnumber
						);
				$result = $OsahDb->updateData($db,"docket",$data,$condition);
				$final_result = array('docket_id'=>$docketid,'status'=>'true');
				echo json_encode($final_result);exit;
		}

        

        /* 
  Name : Amol S
  Date Created : 01-12-2016
  Description : Function documenttemplatelistAction is used to get the Document template list.
 */
 public function documenttemplatelistAction(){
     $mainArray = $decision = $non_decision =  array();
    $db=$this->serviceLocator->get('db1');
  $param= json_decode(file_get_contents('php://input'),true); 
     
    if(isset($param['casetype']) && isset($param['agency'])){
        
        $condition="casetype='{$param['casetype']}' && agency='{$param['agency']}'";
        //$condition="casetype='ALS' && agency='DDS'";
        $OsahDb=New OsahDbFunctions();


        $result = $OsahDb->getData($db,'casetypedocuments',$condition,0);
        foreach ($result as  $value) {
            if($value['documenttype']=='Decision')
                array_push($decision, $value);
            else
             array_push($non_decision, $value);
        }


        array_push($mainArray,$decision);
        array_push($mainArray,$non_decision);
        echo json_encode($mainArray);
    }

    exit;
 }


        /* 
  Name : Amol S
  Date Created : 18-05-2016
  Description : Function documenttemplatelistallAction is used to get the All Document template list.
 */
 public function documenttemplatelistallAction(){
     $mainArray = $decision = $non_decision =  array();
    $db=$this->serviceLocator->get('db1');
  $param= json_decode(file_get_contents('php://input'),true); 
     
     
        $condition="1=1  GROUP BY documentname";
        
        $OsahDb=New OsahDbFunctions();


        $result = $OsahDb->getData($db,'casetypedocuments',$condition,0);
        


        
        echo json_encode($result);
   

    exit;
 }



  /* 
	Name : Neha 
	Description : function is used to add image in server folder.
	Date Created : 16-12-2016
  */
	public function postimageuploadAction() {
		$file_folder = $_SERVER['DOCUMENT_ROOT']."/tempfiles/";
		if (!file_exists($file_folder)) {
			mkdir($file_folder,0777,true);
		}
		move_uploaded_file($_FILES['file']['tmp_name'], $file_folder . $_FILES['file']['name']); 
		echo json_encode($_FILES);exit;
	}
	
	/* 
	Name : Neha Agrawal
	Description : Function is used to attach files and saved in the database.
	Date Created : 14-12-2016
	*/
	
	public function addfileAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true);
		$OsahDb=New OsahDbFunctions();
		if(isset($param['file_data']['Description'])){
			$description = $param['file_data']['Description'];
		}else{
			$description='';
		}
		$file_path = $_SERVER['DOCUMENT_ROOT']."/tempfiles/".$param['file_data']['DocumentName'];
		$fileData =array(
					'Caseid'=>$param['file_data']['Caseid'],
					'DocumentType'=>$param['file_data']['DocumentType'],
					'DateRequested'=>$param['file_data']['date_filed'],
					'Description'=>$description,
					'DocumentName'=>$param['file_data']['DocumentName'],
					'Docket_caseid'=>$param['file_data']['Docket_caseid'],
					'doc_file_flage'=>'1'
					);
		$t=time();
		$add_folder = $_SERVER['DOCUMENT_ROOT']."/upload/".$param['file_data']['Caseid']."/".$param['file_data']['DocumentType']."/".$t."/";
		$attachment_path = "/upload/".$param['file_data']['Caseid']."/".$param['file_data']['DocumentType']."/".$t."/".$param['file_data']['DocumentName'];
		if (!file_exists($add_folder)) {
			mkdir($add_folder,0777,true);
		}
		copy($file_path, $add_folder."/".$param['file_data']['DocumentName']);
		if(file_exists($file_path))
		{
			unlink($file_path);
		}
		$result = $OsahDb->insertData($db,"documentstable",$fileData,1);
				$data = array(
							'documentid'=>$result,
							'attachmentpath'=>$attachment_path
					);
		$result = $OsahDb->insertData($db,"attachmentpaths",$data); 
		echo json_encode(array('result'=>"true", 'file_link'=>$attachment_path));exit;
	}
	/*  Name : FaisalK
	  Date Created : 2016-12-15
	  Description : get calendar dates
	*/
	public function getCalendarDatesAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		$tableName = 'schedule';
		$condition = $param;
		// print_r($condition);exit;
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->getCalendarDates($db,$tableName,$condition,0);
		
		echo json_encode($result);
		exit;
	}
	/*  Name : FaisalK
	  Date Created : 2016-12-19
	  Description : update calendar dates
	*/
	public function updateCalendarDatesAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->updateCalendarDates($db,$param);
		
		echo json_encode($result);
		exit;
	}
	/* 
		Name : FaisalK
		Date Created : 2016-12-19
		Date Modified:   
		Description : deleteCalendarDatesAction Function is used to delete the calendar dates.
    */
	public function deleteCalendarDatesAction(){
		$db=$this->serviceLocator->get('db1');
        $param= json_decode(file_get_contents('php://input'),true);
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->deleteData($db,"schedule",$param);
		echo ($result)?1:0;exit;
	}

	public function checktempfileexistAction(){		
 	 $path = $_SERVER['DOCUMENT_ROOT']."/temp/";
     if ($handle = opendir($path))
		{
		  while (false !== ($file = readdir($handle))) {
		   /*  changed by Faisal Khan	@Description: for testing US 378 @Created on 	: 2017-02-03*/
		   //need to remove in future
		   //if ((time()-filectime($path.$file)) >= 60 * 60 * 24 * 2) {
		   if ((time()-filectime($path.$file)) >= 60 * 5) {
			if (preg_match('/\.docx$/i', $file)) {
			 unlink($path.$file);
			}
		   }
		  } 
		 
	 }
	  //mail("affan.shaikh@azularc.com","My subject","Test");
	  exit;
	}

	/* 
		Name : Neha Agrawal
		Date Created : 27-12-2016
		Description : This function is used to fetch files data as per docket number and document id.
	
	*/
	
	public function getfileAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true);
		$OsahDb=New OsahDbFunctions();
		$caseid = $param['docket_number'];
		$doc_id = $param['doc_id'];
		$condition = 'documentid ="'.$doc_id.'" and Caseid = "'.$caseid.'"';
		$path_condition = 'documentid ="'.$doc_id.'"';
		$result = $OsahDb->getData($db,"documentstable",$condition,0);
		// $attached_data = $OsahDb->getData($db,"attachmentpaths",$path_condition,0);
		
		// $attached_path = $attached_data[0]['attachmentpath'];
       // echo json_encode(array('result'=>$result, 'file_link'=>$attached_path));exit;
       echo json_encode(array('result'=>$result));exit;
	}
	/*	Name 			: FaisalK
		Date Created 	: 2016-12-29
		Description 	: get docket 
	*/
	public function getConfidentialCaseTypeAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		// print_r($param['condition']);exit;
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->getConfidentialCaseType($db,$param['condition'],0);
		echo $result;
		exit;
	}
	
	/* 
		Name : Neha Agrawal
		Date Created : 06-01-2017
		Description : Function is used to reopen the closed case.
	*/
	
	public function reopencaseAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		$OsahDb=New OsahDbFunctions();
		$condition = array('caseid' => $param['casedata']['caseid']);
		$result = $OsahDb->updateData($db,"docket",$param['casedata'],$condition);
		$result = $OsahDb->deleteData($db,"docketdisposition",$condition);
		echo "true";exit;
	}
	
	/* 
		Name : Neha Agrawal
		Date Created : 13-01-2016
		Description : Function is used to update files.
	*/
	
	public function updatefileAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		// print_r($param);exit;
		$OsahDb=New OsahDbFunctions();
		/* $t=time();
		$attached_path = $_SERVER['DOCUMENT_ROOT'].$param['data']['attached_path'];
		
		$file_path = $_SERVER['DOCUMENT_ROOT']."/tempfiles/".$param['file_info']['DocumentName'];
		
		$add_folder = $_SERVER['DOCUMENT_ROOT']."/upload/".$param['file_info']['Caseid']."/".$param['file_info']['DocumentType']."/".$t."/";
		
		$attachment_path = "/upload/".$param['file_info']['Caseid']."/".$param['file_info']['DocumentType']."/".$t."/".$param['file_info']['DocumentName'];
		mkdir($add_folder,0777,true);
		if(file_exists($file_path)){
			copy($file_path,$add_folder."/".$param['file_info']['DocumentName']);
		}else{
			copy($attached_path, $add_folder."/".$param['file_info']['DocumentName']);
		}
		if(file_exists($attached_path))
		{
			unlink($attached_path);
		}
		if(file_exists($file_path))
		{
			unlink($file_path);
		} */
		
		$condition = array('documentid' => $param['data']['updatedoc_id']);
		$result = $OsahDb->updateData($db,"documentstable",$param['file_info'],$condition);
		/* $result = $OsahDb->deleteData($db,"attachmentpaths",$condition);
		$data = array(
							'documentid'=>$param['data']['updatedoc_id'],
							'attachmentpath'=>$attachment_path
					);
		$result = $OsahDb->insertData($db,"attachmentpaths",$data); 
		
		echo json_encode(array('result'=>"true", 'file_link'=>$attachment_path));exit; */
		echo json_encode(array('result'=>"true"));exit;
		
	}


    

    /* 
  Name : Amol S
  Date Created : 19-01-2017
  Description : Function searchdocketinfoAction  is used to get the docket information 
  *  from table based on paramiter like tbale and where condition.
 */
 
    /* 
  Name : Neha Agrawal
  DateModified : 20-02-2017
  Description : Function searchdocketinfoAction  is used to get the docket information 
  *  from table based on paramiter like tbale and where condition.
  * Modified Function description : Function is used to check that docket have met the 1205 or 90 days condition.
 */
 public function searchdocketinfoAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		$condition = $param['condition'];
		$OsahDb=New OsahDbFunctions();
		$result_docket = $OsahDb->getData($db,"docket",$condition,0);
		// if($result_docket[0]['casetype']=='ALS')
		// {
			if($result_docket[0]['telv_o_five']=='0')
			{
				if($result_docket[0]['status']=='Closed')
				{
				$docket_data = $result_docket;
				$result_people = $OsahDb->getData($db,"peopledetails",$condition,0);
			}else{
				$docket_data = '';
				$result_people = '';
			}
			// $sql = "select count(*) as total from form1205offence where flag_1205 = '1' and $condition";
			
			// $result_flag_1 = $OsahDb->getDatabySql($db,$sql);
			// if($result_flag_1[0]['total'] > 0)
			// {
				// $docket_data = $result_docket;
				// $result_people = $OsahDb->getData($db,"peopledetails",$condition,0);
			// }
			// $sql = "select * from form1205offence where flag_1205 = '0' and $condition";
			// $result_flag_0 = $OsahDb->getDatabySql($db,$sql);
			// if(!empty($result_flag_0))
			// {
				// $created_date = $result_flag_0[0]['date_created'];
				// $converted_date = date("Y-m-d", strtotime($created_date));
				// $compare_date = date('Y-m-d', strtotime($converted_date. ' + 91 days'));
				// $today_date = date("Y-m-d");
				// if($compare_date == $today_date)
				// {
					// $docket_data = $result_docket;
					// $result_people = $OsahDb->getData($db,"peopledetails",$condition,0);
				// }else{
					// $docket_data = '';
					// $result_people = '';
				// }
			// }
		// }
		}else{
			$docket_data = $result_docket;
			$result_people = $OsahDb->getData($db,"peopledetails",$condition,0);
		}
     echo json_encode(array('docketData'=>$docket_data, 'peopleData'=>$result_people));
     exit;
  
 }
    /* 
  Name : Amol S
  Date Created : 19-01-2017
  Description : Function filewriteAction  is used to writr message in txt file which is stored in 
data folder   .
 */
 public function filewrite($fileName,$caption,$writeMessage){
    $filePath=$_SERVER['DOCUMENT_ROOT']."/../data/filewrite/".$fileName;
    $content="\n $caption ".$writeMessage."\t".date('m-d-Y H:i:s');
    file_put_contents($filePath, $content, FILE_APPEND);
 }
 /* 
	Name : Neha Agrawal
	Date Created : 14-02-2017
	Description : Function is used to print the search result page in pdf.
 */
	public function printresultAction()
	{	
		$db=$this->serviceLocator->get('db1');
		$condition = json_decode($_POST['condition'],true);
		$OsahDb=New OsahDbFunctions();
		$judge = $condition['judge'];
		$arr_judge = explode(" ",$judge);
		$judge_name = $arr_judge[0].', '.$arr_judge[1];
		$assistant = $condition['judgeassistant'];
		$arr_assistant = explode(" ",$assistant);
		$assistant_name = $arr_assistant[0].', '.$arr_assistant[1];
		$hearingsite = $condition['hearingsite']; 
		$hearingdate = $condition['calendarhearingdate'];
		$updated_hearingdate = date("m-d-Y", strtotime($hearingdate));
		$htime = $condition['hearingtime'];
		$hearingtime =  date('g:i A', strtotime($htime));
		$final_result = array();
		
		$sql ="SELECT docket.* FROM docket WHERE docket.hearingdate = '$hearingdate' AND docket.judge = '$judge' AND docket.judgeassistant = '$assistant' AND docket.hearingtime = '$htime' AND docket.hearingsite = '$hearingsite' and status!='Closed' GROUP BY caseid";
		$result= $OsahDb->getDatabySql($db,$sql);
		foreach($result as $data)
		{
			$caseid = $data['caseid'];
			$sql = "Select concat(Lastname,', ',Firstname) as name,Lastname from peopledetails where caseid = '$caseid ' and (typeofcontact = 'Petitioner' OR typeofcontact='Respondent')";
			$result = $OsahDb->getDatabySql($db,$sql);
			if(empty($result))
			{
				$data['name'] = "";
			}
			foreach($result as $casename_data)
			{
				$data['name'] = $casename_data['name'];
			}
			 $sql = "Select concat(Lastname,', ',Firstname) as attorneyname from attorneybycase where caseid = '$caseid ' and typeofcontact = 'Petitioner Attorney'";
			$result = $OsahDb->getDatabySql($db,$sql);
			foreach($result as $attorney_data)
			{
				$data['attorneyname'] = $attorney_data['attorneyname'];
			}
			if($data['casetype'] == 'ALS')
			{
				$sql = "Select concat(Lastname,' ,',Firstname) as caseofficial from agencycaseworkerbycase where caseid = '$caseid ' and typeofcontact = 'officer'";
			}
			else if($data['refagency'] == 'CSS')
			{
				$sql = "Select concat(Lastname,' ,',Firstname) as caseofficial from agencycaseworkerbycase where caseid = '$caseid ' and typeofcontact = 'Case Worker'";
			}
			else if($data['refagency'] == 'OIG')
			{
				$sql = "Select concat(Lastname,' ,',Firstname) as caseofficial from agencycaseworkerbycase where caseid = '$caseid ' and typeofcontact = 'Investigator'";
			}
			else{
				$sql = "Select concat(Lastname,' ,',Firstname) as caseofficial from agencycaseworkerbycase where caseid = '$caseid '";
			}
			$result = $OsahDb->getDatabySql($db,$sql);
			foreach($result as $official_data)
			{
				$data['caseofficial'] = $official_data['caseofficial'];
			} 
			 array_push($final_result,$data); 
			
		}
		uasort($final_result, function($a) {
			return (is_null($a['name']) OR $a['name'] == "") ? 1 : -1;
		});
			
		$bodyhtml= "";
		$bodyhtml .= '
		<html>
			<body>
			<style>
					.print-table td{padding: 5px; border: 1px solid #000;}
					.print-table .heading td{font-weight: bold;}
					.top-block span{font-size: 10px; font-weight: bold; line-height: 10px;}
					.top-block td{border: none;}
					.breakAfter{ 
						page-break-after: always; 
					} 
				
				</style>
				
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td align="left" class="text-align: left; line-height: 12px;">
							<table>
								<tr>
									<td style="line-height: 12px; margin: 0;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">Judge:</span>
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">'?> <?php $bodyhtml .= $judge_name.'</span>
									</td>
								</tr>
								<tr>
									<td style="line-height: 12px; margin: 0;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">Assistant:</span>
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">'?> <?php $bodyhtml .= $assistant_name.'</span>
									</td>
								</tr>
							</table>
						</td>
						<td align="right" class="text-align: right; line-height: 12px;">
							<table>
								<tr>
									<td style="line-height: 12px; margin: 0;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">Hearing Location:</span>
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">'?> <?php $bodyhtml .= $hearingsite.'</span>
									</td>
								</tr>
								<tr>
									<td style="line-height: 12px; margin: 0;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">Hearing Date:</span>
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">'?> <?php $bodyhtml .= $updated_hearingdate.'</span>
									</td>
								</tr>
								<tr>
									<td style="line-height: 12px; margin: 0;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">Hearing Time:</span>
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; line-height: 10px;">'?> <?php $bodyhtml .= $hearingtime.'</span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<br>
				<table class="print-table" cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed !important; width:100% !important;   overflow:auto;  display:table-header-group;">
					<tr class="heading">
						<td width="5%" style="text-align:center; font-family: \'Roboto\', sans-serif; font-size: 12px;" >S.No</td>
						<td width="8%"  style="text-align:center; font-family: \'Roboto\', sans-serif; font-size: 12px;">Docket Number</td>
						<td width="10%" style="font-family: \'Roboto\', sans-serif; font-size: 12px;">Petitioner / Respondent</td>
						<td width="10%" style="font-family: \'Roboto\', sans-serif; font-size: 12px;">Petitioner Attorney</td>
						<td width="5%" style="text-align:center;font-family: \'Roboto\', sans-serif; font-size: 12px;">Case Desc</td>
						<td width="10%" style="font-family: \'Roboto\', sans-serif; font-size: 12px;">Case Official</td>
						<td width="5%" style="text-align:center; font-family: \'Roboto\', sans-serif; font-size: 12px;">Agency Ref #</td>
						<td width="30%" style="font-family: \'Roboto\', sans-serif; font-size: 12px;">Notes</td>
					</tr> 
					'?> <?php $pagecount = 8;
					$i = 1; foreach($final_result as $key => $value)
					{?>
					<?php $bodyhtml .= '<tr>'?>
					<?php 
						
						 $bodyhtml .= '<td style="text-align:center;" width="5%">'.$i.'</td>';
						 $bodyhtml .= '<td width="8%" style="text-align:center; font-family: \'Roboto\', sans-serif; font-size: 12px; line-height:50px;">'.$value['caseid'].'</td>';
						 $bodyhtml .= '<td width="10%" style="font-family: \'Roboto\', sans-serif; font-size: 12px; line-height:50px;">'.($value['name']!='' ? ucfirst($value['name']) : '-').'</td>';
						 $bodyhtml .= '<td width="10%" style="font-family: \'Roboto\', sans-serif; font-size: 12px; line-height:50px;">'.(array_key_exists('attorneyname', $value) ? $value['attorneyname'] : '-').'</td>';
						 $bodyhtml .= '<td width="5%" style="text-align:center; font-family: \'Roboto\', sans-serif; font-size: 12px; line-height:50px;">'.$value['casetype'].'</td>';
						 $bodyhtml .= '<td width="10%" style="font-family: \'Roboto\', sans-serif; font-size: 12px; line-height:50px;">'.(array_key_exists('caseofficial', $value) ? $value['caseofficial'] : '-').'</td>';
						 $bodyhtml .= '<td width="5%" style="text-align:center; font-family: \'Roboto\', sans-serif; font-size: 12px; line-height:50px;">'.($value['agencyrefnumber']=='' ? '-' : $value['agencyrefnumber']).'</td>';
						$bodyhtml .='<td width="30%" style="font-family: \'Roboto\', sans-serif; font-size: 12px; line-height:50px;"></td>'?>
				
				
					<?php	  $bodyhtml .= '</tr>'; 
					
					/* if($i==$pagecount)
					{
						 $bodyhtml .='<tr class="heading">
							<td>S.No</td>
							<td width="100px">Docket Number</td>
							<td width="100px">Petitioner / Respondent</td>
							<td width="100px">Petitioner Attorney</td>
							<td>Case Desc</td>
							<td width="100px">Case Official</td>
							<td>Hearing Site</td>
							<td>Hearing Time</td>
							<td width="100px">Agency Ref #</td>
							<td width="250px">Notes</td>
						</tr>';
						$pagecount = $pagecount * 2;
						$pagecount++;
					} */
					$i++;
					} ?>
					<?php $bodyhtml .= '
				</table>
			</body>
		</html>';
		// $mpdf = new mPDF('utf-8', 'A4-L');
		$mpdf = new mPDF('utf-8','A4-L','','','15','15','21','15'); 
		$mpdf->WriteHTML($bodyhtml);
		$mpdf->Output($judge.'Calendar.pdf','D');
	}
 	/*	Name 			: FaisalK
		Date Created 	: 2017-01-30
		Description 	: hearingDateAutomation
	*/
	public function hearingDateAutomationAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		//print_r($param['condition']);
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->hearingDateAutomation($db,$param['condition'],0);
		echo json_encode($result);
		exit;
	}
	
 	/*	Name 			: FaisalK
		Date Created 	: 2017-03-29
		Description 	: hearingDateManual
	*/
	public function hearingDateManualAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		//print_r($param['condition']);
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->hearingDateManual($db,$param['condition'],0);
		echo json_encode($result);
		exit;
	}
	
	/* 
		Name : Neha Agrawal
		Date Created : 17-02-2017
		Description : Function is used to export the data coming from upcoming calendar
	*/
	
	public function calendarexportdataAction()
	{
		$db=$this->serviceLocator->get('db1');
		$condition = json_decode($_POST['condition'],true);
		$OsahDb=New OsahDbFunctions();
		$judge = $condition['judge'];
		$assistant = $condition['judgeassistant'];
		$hearingsite = $condition['hearingsite'];
		$hearingdate = $condition['calendarhearingdate'];
		$htime = $condition['hearingtime'];
		$hearingtime =  date('g:i A', strtotime($htime));
		$final_result = array();
		
		$sql ="SELECT docket.caseid,docket.casetype,docket.hearingsite,docket.hearingtime,docket.agencyrefnumber,docket.refagency FROM docket WHERE docket.hearingdate = '$hearingdate' AND docket.judge = '$judge' AND docket.judgeassistant = '$assistant' AND docket.hearingtime = '$htime' AND docket.hearingsite = '$hearingsite' and status!='Closed' GROUP BY caseid";
		
		$result = $OsahDb->getDatabySql($db,$sql);
		foreach($result as $data)
		{
			
			$caseid = $data['caseid'];
			$sql = "Select concat(Lastname,' ,',Firstname) as name from peopledetails where caseid = '$caseid ' and (typeofcontact = 'Petitioner' OR typeofcontact='Respondent') order by Lastname";
			$result = $OsahDb->getDatabySql($db,$sql);
			if(empty($result))
			{
				$data['name'] = "";
			}
			foreach($result as $casename_data)
			{
				$data['name'] = $casename_data['name'];
			}
			
			$sql = "Select concat(Lastname,' ,',Firstname) as attorneyname from attorneybycase where caseid = '$caseid ' and typeofcontact = 'Petitioner Attorney'";
			$result = $OsahDb->getDatabySql($db,$sql);
			foreach($result as $attorney_data)
			{
				$data['attorneyname'] = $attorney_data['attorneyname'];
			}
			if($data['casetype'] == 'ALS')
			{
				$sql = "Select concat(Lastname,' ,',Firstname) as caseofficial from agencycaseworkerbycase where caseid = '$caseid ' and typeofcontact = 'officer'";
			}
			else if($data['refagency'] == 'CSS')
			{
				$sql = "Select concat(Lastname,' ,',Firstname) as caseofficial from agencycaseworkerbycase where caseid = '$caseid ' and typeofcontact = 'Case Worker'";
			}
			else if($data['refagency'] == 'OIG')
			{
				$sql = "Select concat(Lastname,' ,',Firstname) as caseofficial from agencycaseworkerbycase where caseid = '$caseid ' and typeofcontact = 'Investigator'";
			}
			else{
				$sql = "Select concat(Lastname,' ,',Firstname) as caseofficial from agencycaseworkerbycase where caseid = '$caseid '";
			}
			$result = $OsahDb->getDatabySql($db,$sql);
			foreach($result as $official_data)
			{
				$data['caseofficial'] = $official_data['caseofficial'];
			}
			array_push($final_result,$data);
		}
		uasort($final_result, function($a) {
			return (is_null($a['name']) OR $a['name'] == "") ? 1 : -1;
		});
		 $header = array(
				'S.No',
				'Docket Number',
				'Petitioner / Respondent',
				'Petitioner Attorney',
				'Case Desc',
				'Case Official',
				'Hearing Site',
				'Hearing Time',
				'Agency Ref #',
				'Notes',
			);
			
		$result_arr = array();
		$calendar_arr = array();
		$i=1;
		foreach($final_result as $key => $value)
		{
			$result_arr['sno'] = $i;
			$result_arr['caseid'] = $value['caseid'];
			if($value['name']!='')
			{
				$name = $value['name'];
			}else{
				$name = '-';
			}
			if(array_key_exists("attorneyname",$value))
			{
				$attorneyname = $value['attorneyname'];
			}else{
				$attorneyname = '-';
			}
			if(array_key_exists("caseofficial",$value))
			{
				$caseofficial = $value['caseofficial'];
			}else{
				$caseofficial = '-';
			}
			$result_arr['name'] = ucfirst($name);
			$result_arr['attorneyname'] = $attorneyname;
			$result_arr['casetype'] = $value['casetype'];
			$result_arr['caseofficial'] = $caseofficial;
			$result_arr['hearingsite'] = $value['hearingsite'];
			$hearingtime =  date('g:i A', strtotime($value['hearingtime']));
			$result_arr['hearingtime'] = $hearingtime;
			$result_arr['agencyrefnumber'] = $value['agencyrefnumber'];
			array_push($calendar_arr,$result_arr);
			$i++;
		}
		return $this->csvExport('excelsheet'. date('Y-m-d').'.csv', $header, $calendar_arr);
	}
	
	/* 
		Name : Neha Agrawal
		Description : Function is used to search the closed cases.
		Date Created : 06-02-2017
	*/
	
	public function closecasesearchAction()
	{
		$db=$this->serviceLocator->get('db1');
		$OsahDb=New OsahDbFunctions();
		$param= json_decode(file_get_contents('php://input'),true);
		// print_r($param);exit;
		$from_date = $param['condition']['dcfrom'];
		$to_date = $param['condition']['dcto'];
		
		if(isset($param['condition']['boxno']) && $param['condition']['boxno']!='')
		{
			$boxno = "and boxno ='".$param['condition']['boxno']."'";
		}else{
			$boxno = '';
		}
		if(isset($param['condition']['judge']) && $param['condition']['judge']!='')
		{
			$judge =  "and judge ='".$param['condition']['judge']."'";
		}else{
			$judge = '';
		}
		if(isset($param['condition']['agency']) && $param['condition']['agency']!='')
		{
			$agency = "and refagency ='".$param['condition']['agency']."'";
		}else{
			$agency = '';
		}
		if(isset($param['condition']['casetype']) && $param['condition']['casetype']!='')
		{
			$casetype = "and casetype ='". $param['condition']['casetype']."'";
		}else{
			$casetype = '';
		}
		if(isset($param['condition']['county']) && $param['condition']['county']!='')
		{
			$county = "and county ='".$param['condition']['county']."'";
		}else{
			$county = '';
		}
		/*To Set the Pagination and sorting order Start Here*/
     $limit=$param['addtional_condition']['length'];
     $order_by=$param['addtional_condition']['orderby'].' '.($param['addtional_condition']['order']?'desc':'');
     $offset= $param['addtional_condition']['start'];
    /*To Set the Pagination and sorting order End Here*/
		
		$sqlJoin ="SELECT doc.caseid,doc.docketnumber,doc.docketclerk,doc.hearingreqby, doc.daterequested,doc.status,doc.datereceivedbyOSAH,DATE_FORMAT(doc.datereceivedbyOSAH,'%m-%d-%Y') AS datereceiveddisplay,doc.refagency,doc.casetype,doc.casefiletype,doc.county,doc.agencyrefnumber,doc.hearingmode,doc.hearingsite,doc.hearingdate,
      DATE_FORMAT(doc.hearingdate,'%m-%d-%Y') AS hearingdateDisplay,doc.hearingtime,TIME_FORMAT(doc.hearingtime, '%h:%i %p')as hearingtimeDisplay,doc.judge,doc.judgeassistant,doc.hearingrequesteddate,doc.others,doc.docket_createddate FROM docket as doc WHERE caseid in (Select caseid from docketdisposition where dispositiondate between '".$from_date."' and '".$to_date."' $boxno ) $judge $agency $county $casetype";
	  
		$return_array= array(
                'total' => $OsahDb->getDatabySql($db,$sqlJoin,1)
        );
		if($return_array['total']>0)
		{
			$sqlJoin .=($param['addtional_condition']['orderby']!='Lastname')?" ORDER BY {$order_by}":"";
                $sqlJoin .=" LIMIT {$limit} OFFSET {$offset}";
            $result= $docket_resultset = $OsahDb->getDatabySql($db,$sqlJoin);
            $caseids="";
            $i=0;
            foreach ( $result as $data) {
                $caseids.=($i==0)?$data['caseid']:','.$data['caseid'];

                $i++;
            }
            $extcond=($param['addtional_condition']['orderby']=='Lastname')?" ORDER BY {$order_by}":"";

             $sql="select caseid,Lastname,Firstname,typeofcontact from peopledetails where  caseid IN({$caseids})";
             $casename_resultset = $OsahDb->getDatabySql($db,$sql);
             $i=0;
            if($param['addtional_condition']['orderby']=='Lastname'){
                 $docket_resultset = $this->sortingdatacasename($casename_resultset,$docket_resultset);

            }else{

                 $docket_resultset = $this->sortingdataall($docket_resultset,$casename_resultset);
            }    
         $return_array['data']=$docket_resultset;
         echo json_encode($return_array);
         exit;
		}else{
			echo json_encode($return_array);
			exit;
		}
	}


    

    /*  Name            : AMol s
        Date Created    : 2017-03-08
        Description     : getclerklistAction To get the list of clerk
    */
    public function getclerklistAction(){
        $db=$this->serviceLocator->get('db1');
        
        $OsahDb=New OsahDbFunctions();
        $sql="select * from judge_assistant_clerk where user_type='clerk'";
        $result = $OsahDb->getDatabySql($db,$sql);
        echo json_encode($result);
        exit;
    }

    /*  Name            : AMol s
        Date Created    : 2017-03-14
        Description     : partylistAction To get the list of party
    */
    public function partylistAction(){
        $db=$this->serviceLocator->get('db1');
        $OsahDb=New OsahDbFunctions();
        $sql="select * from typeofcontact where partycontact!='Minor/children' ORDER BY partycontact";
        $result = $OsahDb->getDatabySql($db,$sql);
        echo json_encode($result);
        exit;
    }
	/*  
	Name : FaisalK
	Date Created : 2017-03-16
	Description : validate calendar
	*/
	public function validateCalendarAction(){
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		$tableName = 'calendar_view';//$param['tableName'];
		$condition = $param;
		$OsahDb=New OsahDbFunctions();
		$result = $OsahDb->validateCalendar($db,$tableName,$condition,0);
		
		echo json_encode($result);
		exit;
	}
	
	/* 
		Name : Neha Agrawal
		Date created : 2017-03-22
		Description : Function is used to maintain the history for calendars.
	*/
	
	public function updateCalendarHistoryAction()
	{
		$db=$this->serviceLocator->get('db1');
		$session = new Container('base');
		$param= json_decode(file_get_contents('php://input'),true);
		// print_r($param);exit;
		if(isset($param['Calendarid']) && $param['Calendarid']!='')
		{
			$values = array(
				'date'=> date("Y-m-d"),
				'Description'=> $param['data'],
				'Modifiedby'=> $session->user_name,
				'Calendarid'=>$param['Calendarid']
			);
				$OsahDb=New OsahDbFunctions();
				$result =  $OsahDb->addHistory($db, $values,"calendarhistory");
				echo "1";exit;
		}else{
			echo "false";exit;
		}
	}
	
	public function getcalendarhistoryAction()
	{
		$db=$this->serviceLocator->get('db1');
        $OsahDb=New OsahDbFunctions();
		$session = new Container('base');
		$username = $session->user_name;
		// print_r($username);exit;
		// $condition = "Modifiedby = '".$username."'";
        // $result = $OsahDb->getData($db,"calendarhistory",$condition,0);
		$sql = "select * from calendarhistory";
        $result = $OsahDb->getDatabySql($db,$sql);
        echo json_encode($result);
        exit;
	}
	
	/* 
		Name : Neha Agrawal
		Date Created : 24-03-2017
		Description : Function is used to return the old calendar's date which are updated.
	*/
	public function getupdatedatesAction()
	{
		$arr =  array();
		$db=$this->serviceLocator->get('db1');
        $OsahDb=New OsahDbFunctions();
		$param= json_decode(file_get_contents('php://input'),true);
		$new_values = $param['newvalue'];
		$old_values = $param['oldvalue'];
		$new_array = array();
		foreach($old_values as $key=>$value)
		{
			$value['hearingdate'] = date('m-d-Y', strtotime($value['hearingdate']));
			array_push($new_array,$value);
		}
		$old_calendardates = $this->arraydiffassocrecursive($new_array, $new_values);
		if($old_calendardates!='')
		{
			foreach ($new_values as $k1 => $v1) {
				foreach ($old_calendardates as $k2 => $v2) {
					if ($k1 === $k2) {
						$arr[$k1] = $v1;
						$arr[$k2]['hearingdate2'] = $v2;
					}
				}
			}
		}
		echo json_encode(array('updated_dates'=>$arr));exit;
		
		
	}
	/* 
		Name : Neha Agrawal
		Date Created : 24-03-2017
		Description : Function is used to compare the two multidimensial array values.
	*/
	public function arraydiffassocrecursive($array1, $array2)
	{
		foreach($array1 as $key => $value)
		{
			if(is_array($value))
			{
				if(!isset($array2[$key]))
				{
					$difference[$key] = $value;
				}
				elseif(!is_array($array2[$key]))
				{
					$difference[$key] = $value;
				}
				else
				{
					$new_diff = $this->arraydiffassocrecursive($value, $array2[$key]);
					if($new_diff != FALSE)
					{
						$difference[$key] = $new_diff;
					}
				}
			}
			elseif(!isset($array2[$key]) || $array2[$key] != $value)
			{
				$difference[$key] = $value;
			}
		}
		return !isset($difference) ? 0 : $difference;
	}

	/* 
		Name : Neha Agrawal
		Created Date : 18-04-2017
		Description : Function is used to generate OSAH form 1.
	*/
	
	public function printosahformAction()
	{
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		$OsahDb=New OsahDbFunctions();
		$Lastname = "-";
		$Firstname = "-";
		$Middlename = "-";
		$Address1 = "-";
		$Address2 = "-";
		$City = "-";
		$State = "-";
		$Zip = "-";
		$Email = "-";
		$Phone = "-";
		$fax = "-";
		$gender = "-";
		if(isset($param['data']['datereceivedbyOSAH']) && $param['data']['datereceivedbyOSAH']!='')
		{
			$datereceivedbyOSAH = "and datereceivedbyOSAH ='".$param['data']['datereceivedbyOSAH']."'";
		}else{
			$datereceivedbyOSAH = '';
		}
		if(isset($param['data']['caseid']) && $param['data']['caseid']!='')
		{
			$caseid = "and fo.caseid ='".$param['data']['caseid']."'";
		}else{
			$caseid = '';
		}
		if(isset($param['data']['refagency']) && $param['data']['refagency']!='')
		{
			$agency = "and refagency ='".$param['data']['refagency']."'";
		}else{
			$agency = '';
		}
		$sql = "SELECT fo.*,docket.*,permit.effective_date,permit.eligibility,
			agencycaseworkerbycase.*,
			abc.typeofcontact as abctypeofcontact,
			abc.Lastname as abcLastname,
			abc.Firstname as abcFirstname,
			abc.Middlename as abcMiddlename,
			abc.Address1 as abcAddress1,
			abc.Address2 as abcAddress2,
			abc.City as abcCity,
			abc.State as abcState,
			abc.Zip as abcZip,
			abc.Email as abcEmail,
			abc.Phone as abcPhone,
			abc.fax as abcfax,
			abc.AttorneyBar,
			driverrequest.options
			FROM form1205offence as fo
			INNER JOIN docket ON fo.caseid = docket.caseid
			LEFT JOIN permit_eligibility_effectivedate as permit ON fo.caseid = permit.caseid
			LEFT JOIN agencycaseworkerbycase ON fo.caseid = agencycaseworkerbycase.caseid 
			INNER JOIN driverrequest ON driverrequest.id = fo.driver_request
			LEFT JOIN attorneybycase as abc ON fo.caseid = abc.caseid AND abc.typeofcontact = 'Petitioner Attorney' where casetype = 'ALS' and agencycaseworkerbycase.typeofcontact = 'Officer' and docket.status!='Closed'  $datereceivedbyOSAH $agency $caseid";
		$result = $OsahDb->getDatabySql($db,$sql);
		$bodyhtml= "";
		
		if(count($result)>0)
		{
			foreach($result as $data)
			{
				
				$petitioner_flg = 0;
				$respondent_flg = 0;
				$sql = "SELECT * FROM peopledetails WHERE caseid = '".$data['caseid']."' AND (typeofcontact = 'Petitioner' OR typeofcontact ='Respondent')";
				$peopledetail_result = $OsahDb->getDatabySql($db,$sql);
				foreach($peopledetail_result as $newdata)
				{
					if($newdata['typeofcontact']=='Petitioner')
					{
						$petitioner_flg = 1;
						$Lastname = $newdata['Lastname'];
						$Firstname = $newdata['Firstname'];
						$petitioner_name = $newdata['Lastname'].', '.$newdata['Firstname'];
						$Middlename = $newdata['Middlename'];
						$Address1 = $newdata['Address1'];
						$Address2 = $newdata['Address2'];
						$City = $newdata['City'];
						$State = $newdata['State'];
						$Zip = $newdata['Zip'];
						$Email = $newdata['Email'];
						$Phone = $newdata['Phone'];
						$fax = $newdata['fax'];
					}else{
						$respondent_flg = 1;
						$respondent_ln = $newdata['Lastname'];
						$respondent_fn = $newdata['Firstname'];
						$respondent_name = $newdata['Lastname'].', '.$newdata['Firstname'];
					}
				}
				if($petitioner_flg == 0)
					{
						$sql = "SELECT * FROM casetypestyling WHERE AgencyId = '199' AND Casetypeid = '612'";
						$petitioner_result = $OsahDb->getDatabySql($db,$sql);
						$petitioner_name = $petitioner_result[0]['petitioner'];
					}
				if($respondent_flg == 0)
				{
					$sql = "SELECT * FROM casetypestyling WHERE AgencyId = '199' AND Casetypeid = '612'";
					$respondent_result = $OsahDb->getDatabySql($db,$sql);
					$respondent_name = $respondent_result[0]['respondent'];
				}
				if($data['incident_date']!='' && $data['incident_date']!='undefined' && $data['incident_date']!='0000-00-00')
				{
					$incident_date = date('m-d-Y', strtotime($data['incident_date']));
				}else{
					$incident_date = '-';
				}
				
				if($data['dob']!='' && $data['dob']!='undefined' && $data['dob']!='0000-00-00')
				{
					$dob = date('m-d-Y', strtotime($data['dob']));
				}else{
					$dob = '-';
				}
				
				if($data['daterequested']!='' && $data['daterequested']!='undefined' && $data['daterequested']!='0000-00-00')
				{
					$daterequested = date('m-d-Y', strtotime($data['daterequested']));
				}else{
					$daterequested = '-';
				}
				
				if($data['datereceivedbyOSAH']!='' && $data['datereceivedbyOSAH']!='undefined' && $data['datereceivedbyOSAH']!='0000-00-00')
				{
					$datereceivedbyOSAH = date('m-d-Y', strtotime($data['datereceivedbyOSAH']));
				}else{
					$datereceivedbyOSAH = '-';
				}
				
				if($data['hearingdate']!='' && $data['hearingdate']!='undefined' && $data['hearingdate']!='0000-00-00')
				{
					$hearingdate = date('m-d-Y', strtotime($data['hearingdate']));
				}else{
					$hearingdate = '-';
				}
				
				if($data['effective_date']!='' && $data['effective_date']!='undefined' && $data['effective_date']!='0000-00-00')
				{
					$effective_date = date('m-d-Y', strtotime($data['effective_date']));
				}else{
					$effective_date = '-';
				}
				// print_r($data['height']);exit;
				if($data['height']!='')
				{
					$height = explode(".",$data['height']); 
					$feet = $height[0];
					$inches = $height[1];
				}
				
				$incident_time =  gmdate('h:iA', strtotime($data['incident_time']));
				
				if($data['gender']!='' && $data['gender']=='1')
				{
					$gender = 'Female';
				}else{
					$gender = 'Male';
				}
				if($data['commercial_vehicle']=='1')
				{
					$commercial_vehicle='Yes';
				}else{
					$commercial_vehicle='No';
				}
				
				if($data['hazourdous_vehicle']=='1')
				{
					$hazourdous_vehicle='Yes';
				}else{
					$hazourdous_vehicle='No';
				}
				if($data['eligibility']=='1')
				{
					$eligibility = 'Yes';
				}else{
					$eligibility = 'No';
				}
				if($data['is_new_officer']=='1')
				{
					$is_new_officer='Yes';
				}else{
					$is_new_officer='No';
				}if($data['is_new_attorney']=='1')
				{
					$is_new_attorney='Yes';
				}else{
					$is_new_attorney='No';
				}
				$bodyhtml= "";
				$bodyhtml .= '
				<html>
				<head>
					<title>DDS Print Form</title>
				</head>
				<body>
					<div style="margin: 0 auto; width: 1024px; display: table;">
						<div style="display: table; width: 100%;">
							<div style="width: 25%; float: left;">
								<div style="padding: 0 5px;">
									<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0; display: table; width: 100%;">Docket Number</span>
									<h3 style="font-family:  \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0 0 10px 0; display: table; width: 100%; padding: 0;">'.$data['docketnumber'].'</h3>
								</div>
							</div>
							<div style="width: 25%; float: left;">
								<div style="padding: 0 5px;">
									<span style="font-family:  \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0; display: table; width: 100%;">Petitioner</span>
									<h3 style="font-family:  \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0 0 10px 0; display: table; width: 100%; padding: 0;">'.$petitioner_name.'</h3>
								</div>
							</div>
							<div style="width: 25%; float: left;">
								<div style="padding: 0 5px;">
									<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0; display: table; width: 100%;">Respondent</span>
									<h3 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0 0 10px 0; display: table; width: 100%; padding: 0;">'.$respondent_name.'</h3>
								</div>
							</div>
							<div style="width: 25%; float: left;">
								<div style="padding: 0 5px;">
									<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0; display: table; width: 100%;">Created By:</span>
									<h3 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0 0 10px 0; display: table; width: 100%; padding: 0;">'.$data['docketclerk'].'</h3>
								</div>
							</div>
						</div>
						<hr/>
						<div style="margin: 0 0 20px 0; display: table; width: 100%;">
							<h3 style="font-family: \'Roboto\', sans-serif; font-size: 16px; font-weight: bold; margin: 10px 0 5px 0; padding: 0 5px; display: table; width: 100%;">Docket Information</h3>
							<div style="display: table; width: 100%; margin: 0;">
								<div style="float: left; width: 20%; margin: 0 30px 0 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; width: 100%;">Agency Code</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['refagency'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 20%; margin: 0 30px 0 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Case Type</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['casetype'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 20%; margin: 0 30px 0 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">County</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['county'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 20%; margin: 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Status</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['status'].'</h4>
									</div>
								</div>
							</div>
						</div>
						<hr/>
						<div>
							<h3 style="font-family: \'Roboto\', sans-serif; font-size: 16px; font-weight: bold; margin: 20px 0 5px 0; padding: 0 5px;  display: table; width: 100%;">Additional Information</h3>
							<div style="display: table; width: 100%; margin: 0;">
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Date Requested</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$daterequested.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Date Received</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$datereceivedbyOSAH.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Agency Reference Number</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['agencyrefnumber'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Hearing Type</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['hearingmode']!='' ? $data['hearingmode'] : '-').'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Date Entered</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$hearingdate.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Eligible for a Permit?</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$eligibility.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Permit Effective Date</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$effective_date.'</h4>
									</div>
								</div>
							</div>
						</div>
						<hr/>
						<div>
							<h3 style="font-family: \'Roboto\', sans-serif; font-size: 16px; font-weight: bold; margin: 20px 0 15px 0; padding: 0 5px; display: table; width: 100%;">Incident Information</h3>
							<div style="display: table; width: 100%; margin: 0;">
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Citation #</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['citiation'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">County of Occurrance</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['county_of_occurences'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Incident Date</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$incident_date.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Incident time</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$incident_time.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Officer Badge Number</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['officer_badge_number'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Commercial Vehical?</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$commercial_vehicle.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Hazardous Materials?</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$hazourdous_vehicle.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">State of Issue</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['state_of_issue'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Licence Class</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['license_class_id'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Date of Birth</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$dob.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Restrictions</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['restrictions'].'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Gender</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$gender.'</h4>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Height</span>
										<div style="width: 50%; float: left;">
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0 5px 0 0; float: left; width: 50px;">'.$feet.'</h4>
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0; float: left; width: 50px;">Feet</span>
										</div>
										<div style="width: 50%; float: left;">
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0 5px 0 0; float: left; width: 50px;">'.$inches.'</h4>
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0; float: left; width: 50px;">Inches</span>
										</div>
									</div>
								</div>
								<div style="float: left; width: 25%; margin: 0 0 10px 0;">
									<div style="padding: 0 5px;">
										<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Weight</span>
										<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['weight'].'</h4>
									</div>
								</div>
							</div>
							<div style="display: table; width: 100%; padding: 0 5px;">
								<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Driver was requested to submit to test and:</span>
								<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['options'].'</h4>
							</div>
						</div>
						<hr/>
						<div>
							<h3 style="font-family: \'Roboto\', sans-serif; font-size: 16px; font-weight: bold; margin: 20px 0 5px 0; padding: 0 5px; display: table; width: 100%;">Petitioner Information</h3>
							<div style="display: table; width: 100%; margin: 0;">
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Last Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$Lastname.'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">First Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$Firstname.'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Middle Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$Middlename.'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Licence Number</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['agencyrefnumber'].'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 50%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Address Line 1</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$Address1.'</h4>
										</div>
									</div>
									<div style="float: left; width: 50%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Address Line 2</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$Address2.'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">City</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$City.'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">State</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$State.'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Zip Code</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$Zip.'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Phone</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$Phone.'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Email</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$Email.'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Fax</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$fax.'</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr/>
						<div>
							<h3 style="font-family: \'Roboto\', sans-serif; font-size: 16px; font-weight: bold; margin: 20px 0 5px 0; padding: 0 5px; display: table; width: 100%;">Petitioner Attorney Information</h3>
							<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 10px 0 10px 0; padding: 0 5px; display: table; width: 100%;">Is this a new party or new address? <span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 0 10px;">'.$is_new_attorney.'</span></h4>
							<div style="display: table; width: 100%; margin: 0;">
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Last Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcLastname']!='' ? $data['abcLastname'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">First Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcFirstname']!='' ? $data['abcFirstname'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Middle Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcMiddlename']!='' ? $data['abcMiddlename'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">GA Bar #</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['AttorneyBar']!='' ? $data['AttorneyBar'] : '-').'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 50%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Address Line 1</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcAddress1']!='' ? $data['abcAddress1'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 50%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Address Line 2</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcAddress2']!='' ? $data['abcAddress2'] : '-').'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">City</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcCity']!='' ? $data['abcCity'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">State</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcState']!='' ? $data['abcState'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Zip Code</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcZip']!='' ? $data['abcZip'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Phone</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcPhone']!='' ? $data['abcPhone'] : '-').'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Email</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcEmail']!='' ? $data['abcEmail'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Fax</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['abcfax']!= '' ? $data['abcfax'] : '-').'</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr/>
						<div>
							<h3 style="font-family: \'Roboto\', sans-serif; font-size: 16px; font-weight: bold; margin: 20px 0 5px 0; padding: 0 5px; display: table; width: 100%;">Officer Information</h3>
							<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 10px 0 10px 0; padding: 0 5px; display: table; width: 100%;">Is this a new party or new address? <span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 0 10px;">'.$is_new_officer.'</span></h4>
							<div style="display: table; width: 100%; margin: 0;">
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Last Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['Lastname'].'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">First Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['Firstname'].'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Middle Name</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['Middlename']!='' ? $data['Middlename'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Title</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['Title'].'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 50%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Address Line 1</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['Address1'].'</h4>
										</div>
									</div>
									<div style="float: left; width: 50%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Address Line 2</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['Address2'].'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">City</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['City'].'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">State</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.$data['State'].'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Zip Code</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['Zip']!='' ? $data['Zip'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Phone</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['Phone']!='' ? $data['Phone'] : '-').'</h4>
										</div>
									</div>
								</div>
								<div style="display: table; width: 100%; margin: 0;">
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Email</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['Email']!='' ? $data['Email'] : '-').'</h4>
										</div>
									</div>
									<div style="float: left; width: 25%; margin: 0 0 10px 0;">
										<div style="padding: 0 5px;">
											<span style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: normal; margin: 0 0 10px 0; display: table; width: 100%;">Fax</span>
											<h4 style="font-family: \'Roboto\', sans-serif; font-size: 12px; font-weight: bold; margin: 0; width: 100%;">'.($data['Fax']!='' ? $data['Fax'] : '-').'</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</body>
			</html>';
				
			$this->printpdfmultipletimes($bodyhtml,$data['caseid']);
			}
			echo"true";exit;
		}else{
			echo"false";exit;
		}
	} 
	/* 
		Name : Neha Agrawal
		Created Date : 21-04-2017
		Description : Function is used to print OSAH form 1 as a pdf.
	*/
	public function printpdfmultipletimes($data,$caseid)
	{
		$session = new Container('base');
		$t=time();
		$db=$this->serviceLocator->get('db1');
		$param= json_decode(file_get_contents('php://input'),true); 
		$OsahDb=New OsahDbFunctions();
		$date = date('Y-m-d');
		$pdf_name = $caseid.'_ddsform1';
		$mpdf = new mPDF('utf-8','A4');
		$mpdf->WriteHTML($data);
		// echo($_SERVER['DOCUMENT_ROOT']."/../data");exit;
		
		$add_folder = $_SERVER['DOCUMENT_ROOT']."/upload/Clerk Docs/DDS Form 1/".$t."/";
		// $attachment_path = "/data/Clerk Docs/DDS Form 1/".$t."/".$param['file_data']['DocumentName'];
		if (!file_exists($add_folder)) {
			mkdir($add_folder,0777,true);
		}
		
		$mpdf->Output($add_folder.$pdf_name.'.pdf','F');
			$fileData =array(
						'Caseid'=>$caseid,
						'DocumentType'=>'OSAHForm1-initialdocs',
						'DateRequested'=>$date,
						'DocumentName'=>$pdf_name.'.pdf',
						'Docket_caseid'=>$caseid,
						'doc_file_flage'=>'1'
						);
			$result = $OsahDb->insertData($db,"documentstable",$fileData,1);
			$attachment_path = "/upload/Clerk Docs/DDS Form 1/".$t."/".$pdf_name.'.pdf';
					$data = array(
								'documentid'=>$result,
								'attachmentpath'=>$attachment_path
						);
			$result = $OsahDb->insertData($db,"attachmentpaths",$data); 
			$date_filed = date('m-d-Y');
			$message = '<p class="history-title">A file has been added.</p><p><span class="history-label">File Attachment Name:</span><span class="history-data">'.$pdf_name.'.pdf </p><p><span class="history-label">Document Type:</span><span class="history-data">OSAHForm1-initialdocs</p></span></p><p><span class="history-label">Date Filed:</span><span class="history-data">'.$date_filed.'</p>';
			$values = array(
						'caseid'=> $caseid,
						'date'=> $date,
						'Description'=> $message,
						'Modifiedby'=> $session->user_name,
						'Docket_caseid'=>$caseid

					);
			$OsahDb=New OsahDbFunctions();
			$OsahDb->addHistory($db, $values,"history"); 
			
	}

}
