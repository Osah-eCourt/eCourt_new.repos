<?php
namespace Osahform\Model;


use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Ldap as AuthAdapter;

use Zend\Config\Reader\Ini as ConfigReader;
use Zend\Config\Config;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as LogWriter;
use Zend\Log\Filter\Priority as LogFilter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;


Class OsahLdapCon
{
    
    
    
    
    Public function validateLogin($username,$password)
    {
		echo "true";exit;
        
      /*  Array Options
        (
        		[server2] => Array
        		(
        				[host] => dc1.w.net
        				[useStartTls] => 1
        				[accountDomainName] => w.net
        				[accountDomainNameShort] => W
        				[accountCanonicalForm] => 3
        				[baseDn] => CN=Users,DC=w,DC=net
        		)
        		 
        		[server1] => Array
        		(
        				[host] => s0.foo.net
        				[accountDomainName] => foo.net
        				[accountDomainNameShort] => FOO
        				[accountCanonicalForm] => 3
        				[username] => CN=user1,DC=foo,DC=net
        				[password] => pass1
        				[baseDn] => OU=Sales,DC=foo,DC=net
        				[bindRequiresDn] => 1
        		)
        		 
        ) */
     /*   $options=array(        	
            'host' => 'osah.ga.gov',
            'accountDomainName' => 'osah.ga.gov',
            'accountDomainNameShort' => 'osah',
            'accountCanonicalForm' => '2',
            'baseDn' => 'dc=osah,dc=ga,dc=gov',
            'bindRequiresDn' => '0',
        );*/
        
        $auth = new AuthenticationService();
         
        $configReader = new ConfigReader();
        $configData = $configReader->fromFile('C:\iti\ldap-config.ini');
		
        $config = new Config($configData, true);
       
      $log_path = "c:/iti/tmp/ldap.log";
	
    $options = $config->production->ldap->toArray();
        unset($options['log_path']);
        
        $adapter = new AuthAdapter($options,
        		$username,
        		$password);
       // $options = array(/* ... */);
//      echo "<pre>";
		
        $result = $auth->authenticate($adapter);
//       print_r($result); exit;
   //     $ldap = new Zend\Ldap\Ldap($options);
     //   $ldap->bind();
       // $searchusrad='cn=' . $result->getIdentity() . ',ou=People,dc=my,dc=local';
        
       
        //		$hm = $ldap->getEntry('cn=Hugo M�ller,ou=People,dc=my,dc=local');
        if ($log_path) {
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
        		
        }   
        
        return $result;
        
    }
    
    
    
    public function getAgencyCode($db)
    {
    
    	// $db=$this->serviceLocator->get('test');
    
    	
    	//$statement= $db->query('SELECT `AgencyID`,`Agencycode` FROM `agency`');
    	$sql='SELECT * FROM `agency`';
    	$statement=$db->createStatement($sql);
    	$result = $statement->execute();
    	$arraylist="";
    	if ($result instanceof ResultInterface && $result->isQueryResult())
    	{
    		$resultSet = new ResultSet;
    		$resultSet->initialize($result);
    		 
    		$i=0;
    		foreach ($resultSet as $row) {
    			if($i == 0)
    			{
    				$arraylist=  "<option value=".$row->AgencyID .">". $row->Agencycode . "</option>" ;
    			}
    			else
    			{
    				$arraylist= $arraylist. "<option value=".$row->AgencyID .">". $row->Agencycode . "</option>" ;
    			}
    			$i = $i +1;
    		}// end of for loop
    			
    		return $arraylist;
    	}//end of if loop
    
    
    	// return "nothinghere";
    }//
    
  
    
  
    
}
