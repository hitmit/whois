<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Who_is {

public function domain_whois_fetched($domain, $first) {
	$this->who_is_load_phpwhois();
	$whois = new Whois();
  try {
		$result = $whois->Lookup($domain);
		$address = '';
		if(!empty($result['regrinfo']['owner']['address'])){
				$address=implode('<br>',$result['regrinfo']['owner']['address']);				
			}
		if ($address == '') {
			$address_cnt = 0;
			$flag = false;
			$p = 0;
			foreach ($result['rawdata'] as $rowdata) {
				if (strpos(strtolower($rowdata), 'contact') !== false || strpos(strtolower($rowdata), 'address') !== false || strpos(strtolower($rowdata), 'registrant') !== false) {
					if ($address_cnt == 1) {
						break;
					}
					$address_cnt++;
				}
				if ((strpos(strtolower($rowdata), 'contact') !== false || strpos(strtolower($rowdata), 'address') !== false || strpos(strtolower($rowdata), 'registrant') !== false || $flag == true) && $address_cnt == 1) {
					if($p == 5) {
						break;
					}
					$flag = true;
					$address .=$rowdata . '<br/>';
					$p++;
				}
			}
		}
			$ns=array();
			$nsip=array();
			if(!empty($result['regrinfo']['domain']['nserver'])){
				foreach($result['regrinfo']['domain']['nserver'] as $key=>$ip){
					$ns[]=$key;
					$nsip[]=$ip;
				}
			}
			
			$company='';
			if(!empty($ns[0])){
				$wh = explode('.',$ns[0]);	
				$comp = array_slice($wh, 1);	
				if(!empty($comp[0])){
					$company = implode(".",$comp);
				}else $company = $comp[0];
			}
			
			$registrar = !empty($result['regyinfo']['registrar']) ? $result['regyinfo']['registrar'] : '';
			$referrer = !empty($result['regyinfo']['referrer']) ? $result['regyinfo']['referrer'] : '';
			$owner = !empty($result['regrinfo']['owner']['phone']) ? $result['regrinfo']['owner']['phone'] : '';
			$admin = !empty($result['regrinfo']['admin']['phone']) ? $result['regrinfo']['admin']['phone'] : '';
			$tech = !empty($result['regrinfo']['tech']['phone']) ? $result['regrinfo']['tech']['phone'] : '';
			$phone = 'Owner:' . $owner . ', Admin:' . $admin . ', Tech:' . $tech;
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
					//	print 'Caught exception at IP lookup: '.  $e->getMessage(). "\n";						
					}
				}
			}
			if(is_array($result['regrinfo']['domain']['sponsor'])) {	
				$result['regrinfo']['domain']['sponsor'] = NULL;
			}
		
			$domainInfo = array(
				'domain_ip' => addslashes($domain_ip),
				'domain_name' => addslashes($domain),
				'ns1' => (isset($ns[0])) ? addslashes($ns[0]) : '',
				'ns2' => (isset($ns[1])) ? addslashes($ns[1]) : '',
				'ns3' => (isset($ns[2])) ? addslashes($ns[2]) : '',
				'ns4' => (isset($ns[3])) ? addslashes($ns[3]) : '',
				'nsip1' => (isset($nsip[0])) ? addslashes($nsip[0]) : '',
				'nsip2' => (isset($nsip[1])) ? addslashes($nsip[1]) : '',
				'nsip3' => (isset($nsip[2])) ? addslashes($nsip[2]) : '',
				'nsip4' => (isset($nsip[3])) ? addslashes($nsip[3]) : '',
				'dc_org' => !empty($responce['netname']) ? addslashes($responce['netname']) : NULL,
				'owneremail' => addslashes($owner),
				'adminemail' => addslashes($admin),
				'techemail' => addslashes($tech),
				'dc_name' => !empty($responce['orgname']) ? addslashes($responce['orgname']) : NULL,
				'ownername' => (isset($result['regrinfo']['owner']['name'])) ? $result['regrinfo']['owner']['name'] : '',
				'phonedetails' => addslashes($phone),
				'spensorname' => $result['regrinfo']['domain']['sponsor'],
				'address' => addslashes($address),
				'created' => addslashes($result['regrinfo']['domain']['created']),
				'expire' => addslashes($result['regrinfo']['domain']['expires']),
				'status_info' => addslashes($result['regrinfo']['domain']['status'][0]),
				'registrarname' => addslashes($registrar),
				'reffername' => addslashes($referrer),
				'dc_country' => addslashes($responce['country']),
				'adddate' => time(),
				'rawdata' => addslashes($rawdata),
				'dc_address' => addslashes($responce['addr']),
				'updatedon' => addslashes($result['regrinfo']['domain']['changed']),
				'host_org' => addslashes($company)
			);
		}
		catch (Exception $e) {
		$domainInfo = array();
	}
  return $domainInfo;
	}	
	function domain_os_fetched($domain) {
		$curtime = time() - (2 * 24 * 3600);
		$emails = array();
		$opensources = array('drupal', 'joomla', 'wordpress');
		$headerinfo = array('Server:', 'X-Powered-By:', 'Set-Cookie:', 'Vary:', 'Transfer-Encoding:', 'Content-Type:');
		$time = time();
		$v = $server = $os = $lang = $value = $version = $domainheader = $domainheader2 = '';
		if (!empty($domain)) {
			$morescan = true;
			$value = '';

			$hrd = http_head('http://' . $domain, array('timeout' => 10, 'redirect' => 2), $info);
			$hrd = str_replace("\n", '|', $hrd);
			$hrd = str_replace("\r", '|', $hrd);
			$header_array = explode("|", $hrd);

			foreach ($headerinfo as $hinfo) {
				$var = strtolower(str_replace('-', '_', str_replace(':', '', $hinfo)));
				$$var = '';
				$hrmatched = false;
				foreach ($header_array as $hrdata) {
					$ishr = stripos($hrdata, $hinfo);
					if ($ishr !== false) {
						$headinfo = explode(":", $hrdata);
						$$var = str_replace('|', ' ', trim($headinfo[1]));
					}
				}
			}

			$domainheader = addslashes($server) . '|' . addslashes($x_powered_by) . '|' . addslashes($set_cookie) . '|' . addslashes($vary) . '|' . addslashes($transfer_encoding) . '|' . addslashes($content_type);

			$domainheader2 = addslashes($x_powered_by) . '|' . addslashes($set_cookie) . '|' . addslashes($vary) . '|' . addslashes($transfer_encoding) . '|' . addslashes($content_type);

			$oldtime = $time;
			$time = time();
			$timediff = $time - $oldtime;

			// Get cURL resource
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_VERBOSE => 1,
				CURLOPT_TIMEOUT => 20,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_MAXREDIRS => 3,
				CURLOPT_URL => 'http://www.' . $domain,
				CURLOPT_USERAGENT => 'Simple cURL Request'
			));
			// Send the request & save response to $resp					
			$html = curl_exec($curl);
			// Close request to clear up some resources
			curl_close($curl);
			$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			$oldtime = $time;
			$time = time();
			$timediff = $time - $oldtime;

			$dom = new DOMDocument;
			@$dom->loadHTML($html);
			$array = array();
			$array[] = $html;
			$array[] = $httpCode;

			if (!empty($html) && $httpCode != '302' && $httpCode != '404' && $httpCode != '501') {
				foreach ($dom->getElementsByTagName('meta') as $meta) {
					$iscontact = false;
					$property = $meta->getAttribute('name');
					$generator = stripos($property, 'generator');
					if ($generator !== false) {
						$os = '';
						$os = $meta->getAttribute('content');
						$v = preg_replace("/[^0-9.]/", "", $os);
						if (!empty($v)) {
							$v = $v . '0';
							if ($version < $v) {
								$version = $v;
							}
						}
						$isdrupal = stripos($os, 'drupal');
						if ($isdrupal === false) {
							$morescan = false;
						}
					}
				}

				$oldtime = $time;
				$time = time();
				$timediff = $time - $oldtime;
				if ($morescan) {
					$logfile = '/CHANGELOG.txt';
					$url = 'http://www.' . $domain . $logfile;

					// Get cURL resource
					$request = array(
						CURLOPT_VERBOSE => true,
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_TIMEOUT => 10,
						CURLOPT_URL => $url,
						CURLOPT_USERAGENT => 'Simple cURL Request'
					);

					$curl = curl_init();
					// Set some options - we are passing in a useragent too here
					curl_setopt_array($curl, $request);
					// Send the request & save response to $resp
					$resp = curl_exec($curl);
					// Close request to clear up some resources				
					curl_close($curl);

					if (!empty($resp) && $httpCode == '200') {
						$os = 'drupal';
						$v = get_between($resp, "Drupal", ",");
						if (is_numeric($v) && !empty($v)) {
							$version = $v;
						}
					}
					if (empty($v)) {
						// Get cURL resource
						$curl = curl_init();
						// Set some options - we are passing in a useragent too here
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_VERBOSE => 1,
							CURLOPT_TIMEOUT => 10,
							CURLOPT_URL => 'http://guess.scritch.org/?referer=direct&url=www.' . $domain,
							CURLOPT_USERAGENT => 'Simple cURL Request'
						));
						// Send the request & save response to $resp
						$toolresp = curl_exec($curl);
						// Close request to clear up some resources

						$oldtime = $time;
						$time = time();
						$timediff = $time - $oldtime;
						$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
						curl_close($curl);

						$err = stripos($toolresp, 'error');
						$cto = stripos($toolresp, 'Connection Time Out');

						if (!empty($toolresp) && $httpCode != '302' && $httpCode != '404' && $httpCode != '501') {
							if ($err === false && $cto === false) {
								$usefulltext = get_string_between($toolresp, '<div class="tab-pane active" id="overview">', '<p class="well">');
								$usefulltext = str_replace('<div class="span9">', ':', $usefulltext);
								$usefulltext = str_replace('</b>', '|', $usefulltext);
								$usefulltext = str_replace('<div class="span3">', '|', $usefulltext);
								$usefulltext = nl2br($usefulltext);
								$usefulltext = strip_tags($usefulltext);
								$usefulltext = str_replace("  ", " ", $usefulltext);
								$usefulltext = str_replace("  ", " ", $usefulltext);
								$usefulltext = str_replace("\n", '', $usefulltext);
								$usefulltext = str_replace("\r", '', $usefulltext);
								$usefulltext = str_replace(":", '', $usefulltext);
								$usefulltext = str_replace(":", '', $usefulltext);
								$usefulltext = str_replace("Webserver", '', $usefulltext);
								$usefulltext = str_replace("Framework", '', $usefulltext);
								$usefulltext = str_replace("Language", '', $usefulltext);
								$usefulltext = str_replace('Perhaps just', '', $usefulltext);

								$usefulltext = explode("|", $usefulltext);

								$server = trim($usefulltext[2]);
								$st = stripos($server, '%');
								if ($st !== false)
									$server = substr($server, 0, -4);
								$unk = stripos($server, 'unknown');
								if ($unk !== false) {
									$fetch_header_for_server = true;
								}

								$os = trim($usefulltext[3]);
								$st = stripos($os, 'static');
								if ($st !== false) {
									$os = 'Static Site';
								} else {
									$st = stripos($os, '%');
									if ($st !== false)
										$os = substr($os, 0, -4);
								}
								$lang = trim($usefulltext[4]);
								$st = stripos($lang, '%');
								if ($st !== false)
									$lang = substr($lang, 0, -4);

								$php = stripos($lang, 'php');
								$unk = stripos($lang, 'unknown');
								if ($php !== false && $unk !== false) {
									$fetch_header_for_lang = true;
								}
								$usefulltext = $server . "|" . $os . "|" . $lang;
							}

							$oldtime = $time;
							$time = time();
							$timediff = $time - $oldtime;

							if (empty($server))
								$server = 'Unable to connect.';
							$value = '|' . $domain . '|' . str_replace('|', ' ', addslashes($os)) . '|' . str_replace('|', ' ', addslashes($server)) . '|' . $domainheader2 . '|' . time() . '||' . str_replace('|', ' ', $lang) . '|0' . "\n";
						}
					}else {
						$value = '|' . $domain . '|' . str_replace('|', ' ', addslashes($os)) . '|' . $domainheader . '|' . time() . '|' . $version . '|' . addslashes($x_powered_by) . '|0' . "\n";
					}
				}
			}//end of if(!empty($html) && $httpCode != '302' && $httpCode !='404' && $httpCode != '501' )
			$data2 = explode("|", $value);
			return $data2;
  }
}

	
	public function who_is_load_phpwhois() {
		include_once('phpwhois/whois.main.php');
    include_once('phpwhois/whois.utils.php');
    include_once('phpwhois/ipwhois.php');
	}
}

/* End of file Someclass.php */