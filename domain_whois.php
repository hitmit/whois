<?php 
$con = mysql_connect("localhost", "root", "");
$db_selected = mysql_select_db("ciwho",$con);

	$domain = $argv[1];
	
	

	if(!empty($domain)){
	
	function get_between_1($input, $start, $end){
		  
		  $exploded = explode("\n",trim($input));
		  
		  $count=count($exploded);
		  if($count > 5) $count=5;
		  $versions=array();
		  
		  for($i=0;$i < $count;$i++){
			//echo $start." = ".$exploded[$i]." <hr /> ";
			if(stristr($exploded[$i], $start)){
				$versions[] = substr($exploded[$i],7,7);
				//return $substr = substr($input, strlen($start)+strpos($input, $start), (strlen($input) - strpos($input, $end))*(-1));
			}
		  }
		  if(!empty($versions[0])){
			$ver=explode(',',$versions[0]);
			$v=explode(" ",$ver[0]);
			return $v[0]; 
		  }else return false;
	}

	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if($ini === false) return false;
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}	

$basepath='/var/www/html/whois/';

$whoisfile=$basepath.'domain_whois_fetched.txt'; 
$protectedfile=$basepath.'domain_whois_protected.txt';
$dnsfile=$basepath.'domain_dns_fetched.txt';
$osfile=$basepath.'domain_os_fetched.txt';

$mod_path = $basepath.'sites/all/modules/who_is/phpwhois';
	/*Start: Domain Whois Process*/

	include_once($mod_path .'/whois.main.php');
    include_once($mod_path . '/whois.utils.php');
    include_once($mod_path . '/ipwhois.php');
    include_once($mod_path . '/iplookup.php');
		
	$whois = new Whois();
	
		
		
	try {
		$result = $whois->Lookup($domain);
	} catch (Exception $e) {
		print 'Caught exception at whois lookup: '.  $e->getMessage(). "\n";
	}	
	
	
	if(!empty($result['regrinfo']['owner']['address'])){
		$address=implode('<br>',$result['regrinfo']['owner']['address']);
	}
			
			$ns=array();
			$nsip=array();
			if(!empty($result['regrinfo']['domain']['nserver'])){
				foreach($result['regrinfo']['domain']['nserver'] as $key=>$ip){
					$ns[]=$key;
					$nsip[]=$ip;
				}
			}
			
			$registrar=$result['regyinfo']['registrar'];
			$referrer=$result['regyinfo']['referrer'];
			$phone='Owner:'.$result['regrinfo']['owner']['phone'].', Admin:'.$result['regrinfo']['admin']['phone'].', Tech:'.$result['regrinfo']['tech']['phone'];
			
			$rawdata = '';
			if(!empty($result['rawdata'])) $rawdata = str_replace('|',' , ',implode('*',$result['rawdata']));
			
			$ips = gethostbynamel($domain);
			if(!empty($ips[0])){
				$domain_ip = implode(",",$ips);
			}else $domain_ip = gethostbyname($domain);
			
			$responce = array();
			$domainip = gethostbyname($domain);
			if($domainip) {
				if(ValidateIP($domainip)) {					
					try {
						$responce = LookupIP($domainip);
					} catch (Exception $e) {
						print 'Caught exception at IP lookup: '.  $e->getMessage(). "\n";						
					}					
				}
			}
			
			$domainInfo = array('',
				addslashes($domain_ip),
				addslashes($domain),
				addslashes($ns[0]),
				addslashes($ns[1]),
				addslashes($ns[2]),
				addslashes($ns[3]),
				addslashes($nsip[0]),
				addslashes($nsip[1]),
				addslashes($nsip[2]),
				addslashes($nsip[3]),
				addslashes($responce['netname']),
				addslashes($result['regrinfo']['owner']['email']),
				addslashes($result['regrinfo']['admin']['email']),
				addslashes($result['regrinfo']['tech']['email']),
				addslashes($responce['orgname']),
				addslashes($result['regrinfo']['owner']['name']),
				addslashes($phone),
				addslashes($result['regrinfo']['domain']['sponsor']),
				addslashes($address),
				addslashes($result['regrinfo']['domain']['created']),
				addslashes($result['regrinfo']['domain']['expires']),
				addslashes($result['regrinfo']['domain']['status'][0]),
				addslashes($registrar),
				addslashes($referrer),
				addslashes($responce['country']),
				time(),
				addslashes($rawdata),
				addslashes($responce['addr']),
				addslashes($result['regrinfo']['domain']['changed']),
			);
			
			if(!empty($domainInfo)){
				$gotosite=false;				
				$whoisrec=implode("|",$domainInfo)."\n";
				$fnew = fopen($whoisfile, 'w');
				fputs($fnew,$whoisrec);
				@fclose($fnew);
				
				if(!empty($result['regrinfo']['owner']['email']) || !empty($result['regrinfo']['admin']['email']) || !empty($result['regrinfo']['tech']['email']) ){
					$owneremail='';
					$adminemail='';
					$techemail='';
					
					$chkemail=array();
					
					if(!empty($result['regrinfo']['owner']['email'])){
						$pos=stripos($result['regrinfo']['owner']['email'],"privac");
						$pos1=stripos($result['regrinfo']['owner']['email'],"protect");
						$pos2=stripos($result['regrinfo']['owner']['email'],"private");
						$pos3=stripos($result['regrinfo']['owner']['email'],"o-w-o.info");
						$pos4=stripos($result['regrinfo']['owner']['email'],"register.com");
						$pos5=stripos($result['regrinfo']['owner']['email'],"whoisguard.com");
						$pos6=stripos($result['regrinfo']['owner']['email'],"domaindiscreet.com");
						$pos7=stripos($result['regrinfo']['owner']['email'],"proxy");						
						if( $pos !== false || $pos1 !== false || $pos2 !== false || $pos3 !== false || $pos4 !== false || $pos5 !== false || $pos6 !== false || $pos7 !== false ){
							$gotosite=true;
						}else{
							$chkemail[]=$result['regrinfo']['owner']['email'];
						}
					}
					if(!empty($result['regrinfo']['admin']['email'])){
						$pos=stripos($result['regrinfo']['admin']['email'],"privac");
						$pos1=stripos($result['regrinfo']['admin']['email'],"protect");
						$pos2=stripos($result['regrinfo']['admin']['email'],"private");
						$pos3=stripos($result['regrinfo']['admin']['email'],"o-w-o.info");
						$pos4=stripos($result['regrinfo']['admin']['email'],"register.com");
						$pos5=stripos($result['regrinfo']['admin']['email'],"whoisguard.com");
						$pos6=stripos($result['regrinfo']['admin']['email'],"domaindiscreet.com");
						$pos7=stripos($result['regrinfo']['admin']['email'],"proxy");
						if( $pos !== false || $pos1 !== false || $pos2 !== false || $pos3 !== false || $pos4 !== false || $pos5 !== false || $pos6 !== false || $pos7 !== false ){
							$gotosite=true;
						}else{
							$chkemail[]=$result['regrinfo']['admin']['email'];
						}
					}
					if(!empty($result['regrinfo']['tech']['email'])){
						$pos=stripos($result['regrinfo']['tech']['email'],"privac");
						$pos1=stripos($result['regrinfo']['tech']['email'],"protect");
						$pos2=stripos($result['regrinfo']['tech']['email'],"private");
						$pos3=stripos($result['regrinfo']['tech']['email'],"o-w-o.info");
						$pos4=stripos($result['regrinfo']['tech']['email'],"register.com");
						$pos5=stripos($result['regrinfo']['tech']['email'],"whoisguard.com");
						$pos6=stripos($result['regrinfo']['tech']['email'],"domaindiscreet.com");
						$pos7=stripos($result['regrinfo']['tech']['email'],"proxy");
						if( $pos !== false || $pos1 !== false || $pos2 !== false || $pos3 !== false || $pos4 !== false || $pos5 !== false || $pos6 !== false || $pos7 !== false ){
							$gotosite=true;
						}else{
							$chkemail[]=$result['regrinfo']['tech']['email'];
						}
					}
					if(!empty($chkemail)){
						print '#6'."\n";
						$chkemail=array_unique($chkemail);
						
						if(!empty($chkemail[0]) && !in_array($chkemail[0],$emails)){
							$emails[]=$chkemail[0];
							$owneremail=$chkemail[0];
						}
						if(!empty($chkemail[1]) && !in_array($chkemail[1],$emails)){
							$emails[]=$chkemail[1];
							$adminemail=$chkemail[1];
						}
						if(!empty($chkemail[2]) && !in_array($chkemail[2],$emails)){
							$emails[]=$chkemail[2];
							$techemail=$chkemail[2];
						}
					}
					//}
				}
				
				if($gotosite){
					print '#7'."\n";
					$fc=fopen($protectedfile, 'w');
					$csvtxt='|'.$domain.'||0'."\n";
					fputs($fc,$csvtxt);
					@fclose($fc);
				}//end of if($gotosite)
			
			$getDomain=mysql_query("SELECT domain_id, domain_name, updatedon FROM domain_whois WHERE domain_name = '".$domain."‎'") or print(mysql_error());
			if(mysql_num_rows($getDomain)>0){
				if(!empty($getDomain[0]['updatedon']) && !empty($result['regrinfo']['domain']['changed']) && $result['regrinfo']['domain']['changed'] != $getDomain[0]['updatedon']){
					$qry = "INSERT INTO domain_whois_history SELECT * FROM domain_whois WHERE domain_id='".$getDomain[0]['domain_id']."'";
					mysql_query($qry) or print $qry.' # '.mysql_error();

					$query = "DELETE FROM domain_whois WHERE domain_id = '".$getDomain[0]['domain_id']."'";
					mysql_query($query) or print $query.' # '.mysql_error();
				}
			}
			
			mysql_query("LOAD DATA LOCAL INFILE '".$whoisfile."' INTO TABLE whois.domain_whois FIELDS TERMINATED BY '|'  LINES TERMINATED BY '\n'") or print("\n".mysql_error());
			
			mysql_query("LOAD DATA LOCAL INFILE '".$protectedfile."' INTO TABLE whois.protecteddomains FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n'") or print("\n".mysql_error());
			
			/*End of Domain Whois Process*/
			
			
			/*Start: Update DNS Record*/
			$dns_type=array('A','NS','MX','SOA','AAAA','TXT');
			$txt_info = $txt = '';
			foreach($dns_type as $tp){
				$command = "dig ".$tp." ".$domain;
				$info = shell_exec($command);
				$txt = get_string_between($info, ';; ANSWER SECTION:',';; Query time:');
				if($txt === false){
					$txt = get_string_between($info, ';; AUTHORITY SECTION:',';; Query time:');
					if($tp!='SOA'){
						$issoa = strpos($txt,'SOA');
						if($issoa !== false ) $txt = 'empty';
					}
				}
				$txt = str_replace("\n",'*',$txt);
				$txt = str_replace("\r",'*',$txt);
				$txt = str_replace("**",' * ',$txt);
				$txt = str_replace("  ",' ',$txt);
				$txt = trim($txt);
				$txt_info .= '|'.$txt;
			}
			if($txt != '' && !empty($txt)){
					$txt = '|'.$domain.str_replace("  ",' ',trim($txt_info))."|".$time."\n";
					$fn=fopen($dnsfile, 'w');
					fputs($fn,$txt);
					@fclose($fn);
					
					$query = "DELETE FROM domain_dns WHERE dnsofdomain = '".$domain."'";
					mysql_query($query) or print $query.' # '.mysql_error();
			}
			mysql_query("LOAD DATA LOCAL INFILE '".$dnsfile."' INTO TABLE whois.domain_dns FIELDS TERMINATED BY '|'  LINES TERMINATED BY '\n'") or print("\n".mysql_error());
			
			/*End of DNS Process*/
			
			
			/*Start: Domain Technologies Fetching*/
			
			$opensources=array('drupal','joomla','wordpress');
			$headerinfo=array('Server:','X-Powered-By:','Set-Cookie:','Vary:','Transfer-Encoding:','Content-Type:');
			
			$getDomain=mysql_query("SELECT * FROM domain_os_headers WHERE domainname = '".$domain."'") or print(mysql_error());
			if(mysql_num_rows($getDomain)<=0){
				
				$morescan=true;
				$value='';
				print '#0';
				
				// Get cURL resource
				$curl = curl_init();
				// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_VERBOSE => 1,						
					CURLOPT_TIMEOUT => 20,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_MAXREDIRS => 3,
					CURLOPT_URL => 'http://www.'.$domain,
					CURLOPT_USERAGENT => 'SEO ROBOT'
				));
				// Send the request & save response to $resp				
				$html = curl_exec($curl);
				// Close request to clear up some resources
				$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
				curl_close($curl);				
				
				$oldtime = $time;
				$time = time();
				$timediff = $time - $oldtime;
				print '('.$timediff.'Secs)';
				
				if(!empty($html) && $httpCode != '302' && $httpCode !='404' && $httpCode != '501' ){
				
				$hrd = http_head('http://'.$domain, array('timeout' => 10, 'redirect'=> 2), $info);
				$hrd = str_replace("\n",'|',$hrd);				
				$hrd = str_replace("\r",'|',$hrd);
				$header_array = explode("|",$hrd);
				
				foreach($headerinfo as $hinfo){
					$var = strtolower(str_replace('-','_',str_replace(':','',$hinfo)));
					$$var = '';
					$hrmatched=false;
					foreach($header_array as $hrdata){
						$ishr=stripos($hrdata,$hinfo);
						if($ishr!==false){
							$headinfo=explode(":",$hrdata);
							$$var = str_replace('|',' ',trim($headinfo[1]));
						}
					}
				}
				
				$domainheader = addslashes($server).'|'.addslashes($x_powered_by).'|'.addslashes($set_cookie).'|'.addslashes($vary).'|'.addslashes($transfer_encoding).'|'.addslashes($content_type);
								
				print '#1';
				$oldtime = $time;
				$time = time();
				$timediff = $time - $oldtime;
				print '('.$timediff.'Secs)';
				
				$dom = new DOMDocument;
				@$dom->loadHTML($html);
				$os ='';
				foreach($dom->getElementsByTagName('meta') as $meta ){
				  
				  $iscontact=false;
				  
				  $property= $meta->getAttribute('name');
				  $generator=stripos($property,'generator');
				  
				  if($generator !== false){
					$os ='';
					$os = $meta->getAttribute('content');
					$v = preg_replace("/[^0-9.]/","",$os);
					if(!empty($v)){
						$v = $v.'0';
						if( $version < $v ){
							$version = $v;
						}
					}
					$isdrupal=stripos($os,'drupal');
					if($isdrupal === false){
						$morescan = false;
					}else{
						$os='drupal';
					}
				  }
				}
				
				if(empty($os)){
					$isdrupal=stripos($html,'drupal');
					if($isdrupal !== false){
						$os='drupal';
					}
				}
				
				print '#2';
				$oldtime = $time;
				$time = time();
				$timediff = $time - $oldtime;
				print '('.$timediff.'Secs)';
				
				if($morescan){
					
					if($os=='drupal'){
					
						$logfile = '/CHANGELOG.txt';
					
						$url='http://www.'.$domain.$logfile;
						// Get cURL resource
						
						$request=array(						
							CURLOPT_VERBOSE => true,
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_TIMEOUT => 10,
							CURLOPT_URL => $url,
							CURLOPT_USERAGENT => 'SEO ROBOT'
						);
						
						$curl = curl_init();
						// Set some options - we are passing in a useragent too here
							curl_setopt_array($curl, $request);
						// Send the request & save response to $resp
						$resp = curl_exec($curl);
						// Close request to clear up some resources				
						print $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

						curl_close($curl);
						
						if(!empty($resp) && $httpCode == '200' ){
							$os ='drupal';
							$v = get_between($resp,"Drupal",",");
							if(is_numeric($v) && !empty($v)){
								$version = $v;
							}
						}
					}
					
					if(empty($v) && empty($os)){
						
						mysql_query("INSERT INTO old_domains SET domain_name ='".$domain."'") or print(mysql_error());

					}else{
						$value = '|'.$domain.'|'.str_replace('|',' ',addslashes($os)).'|'.$domainheader.'|'.time().'|'.$version.'|'.addslashes($x_powered_by).'|0'."\n";
						print '#10';
						$fn=fopen($osfile, 'w');									
						fputs($fn,$value);
						@fclose($fn);
					}					
				}else{
					$value = '|'.$domain.'|'.str_replace('|',' ',addslashes($os)).'|'.$domainheader.'|'.time().'|'.$version.'|'.addslashes($x_powered_by).'|0'."\n";
					print '#11';
					$fn=fopen($osfile, 'w');									
					fputs($fn,$value);
					@fclose($fn);
				}
				
				}//end of if(!empty($html) && $httpCode != '302' && $httpCode !='404' && $httpCode != '501' )
				

				//die('end!!');

				
				print '#12';
				
				mysql_query("LOAD DATA LOCAL INFILE '".$osfile."' INTO TABLE whois.domain_os_headers FIELDS TERMINATED BY '|'  LINES TERMINATED BY '\n'") or print("\n".mysql_error());
				
			}//end of if(count($getDomain)<=0)
			else print 'm out!!';
				
			/*End of Domain Technologies Process*/
		
		}//end of if(!empty($domainInfo))	
		
	}//end of if(!empty($domain))

?>