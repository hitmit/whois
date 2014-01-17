<?php
class Report_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function dc_count($arg1 = NULL, $arg2 = NULL, $arg3 = NULL) {
		$arg1 = urldecode($arg1);
		$arg2 = urldecode($arg2);
		$arg3 = urldecode($arg3);
		$where = "";
		if ($arg1 != NULL && strtolower($arg1) == 'country') {
			//$this->db->like('dc_country', $arg2);
			$where = "WHERE dc_country = " . $arg2;
		}
		if($arg1 != NULL && strtolower($arg1) == 'hc') {
			//$this->db->like('host_org', $arg2);
			$where = "WHERE host_org LIKE '".$arg2."'";
			if($arg3 != NULL) {
				//$this->db->like('dc_country', $arg3);
				$where .= "AND dc_country = " . $arg3;
			}
		}
		if($arg1 != NULL && strtolower($arg1) == 'dc') {
			//$this->db->like('dc_name', $arg2);
			$where = "WHERE dc_name LIKE '".$arg2."'";
			if($arg3 != NULL) {
			//	$this->db->like('dc_country', $arg3);
				$where .= "AND dc_country = " . $arg3;
			}
		}
		//$this->db->from('domain_whois');
		$query = "SELECT COUNT(DISTINCT dc_name) as cnt FROM domain_whois dw " . $where;
		$result = $this->db->query($query);
		$count = $result->row_array();
		/* $this->db->like('title', 'match');
$this->db->from('my_table');
echo $this->db->count_all_results(); */
		//$count = $this->db->count_all_results();
		return	$count['cnt'];
	}
	
	public function dc_count_auto($string = array()) {
		$sql = "SELECT DISTINCT dc_name FROM domain_whois dw WHERE dc_name LIKE '".$string['keyword']."%'";
	  $query = $this->db->query($sql);
	  return $query->result();
	}

	public function fetch_dc_report($limit, $start, $arg1 = NULL, $arg2 = NULL, $arg3 = NULL) {
		$arg1 = urldecode($arg1);
		$arg2 = urldecode($arg2);
		$arg3 = urldecode($arg3);
	/* 	$sql = "SELECT DISTINCT dc_name as dc_name FROM domain_whois dw LIMIT ".$start.", ".$limit;
		if($dc_name != NULL) {
			$sql = "SELECT DISTINCT dc_name as dc_name FROM domain_whois dw WHERE dc_name LIKE '".$dc_name ."' LIMIT ".$start.", ".$limit;
		} */
		
		if ($arg1 != NULL && strtolower($arg1) == 'country') {
			$this->db->where('dc_country', $arg2);
		}
		if($arg1 != NULL && strtolower($arg1) == 'hc') {
			$this->db->where('host_org', $arg2);
			if($arg3 != NULL) {
				$this->db->where('dc_country', $arg3);
			}
		}
		if($arg1 != NULL && strtolower($arg1) == 'dc') {
			$this->db->where('dc_name', $arg2);
			if($arg3 != NULL) {
				$this->db->where('dc_country', $arg3);
			}
		}
		$this->db->distinct('dc_name');
		$this->db->limit($limit, $start);
		$query = $this->db->get('domain_whois');
	//	return $query->result_array();
		//$query = $this->db->query($sql);
		$rows = array();
		foreach ($query->result_array() as $key => $value) {
			$sql1 = "SELECT COUNT(DISTINCT host_org) as cnt FROM domain_whois dw WHERE dc_name LIKE ?";	
			$query1 = $this->db->query($sql1, array($value['dc_name']));
			$row1 = $query1->row_array();
			$rows[$value['dc_name']]['host_count'] = $row1['cnt'];
			
			$sql2 = "SELECT COUNT(domain_name) as cnt FROM domain_whois dw WHERE dc_name LIKE ?";	
			$query2 = $this->db->query($sql2, array($value['dc_name']));
			$row2 = $query2->row_array();
			$rows[$value['dc_name']]['domain_count'] = $row2['cnt'];
			
			$sql3 = "SELECT COUNT(distinct(dw.domain_ip)) + COUNT(distinct(dw.nsip1)) + COUNT(distinct(dw.nsip2)) + COUNT(distinct(dw.nsip3)) + COUNT(distinct(dw.nsip4)) as cnt FROM domain_whois dw WHERE dw.dc_name LIKE ?";
			$query3 = $this->db->query($sql2, array($value['dc_name']));
			$row3 = $query3->row_array();
			$rows[$value['dc_name']]['ip_count'] = $row3['cnt'];
			
		}
		
		return $rows;
	}
	
	public function domain_auto($string = array()) {
		$sql = "SELECT domain_name FROM domain_whois dw WHERE domain_name LIKE '".$string['keyword']."%'";
	  $query = $this->db->query($sql);
	  return $query->result();
	}
	
	public function domain_count1($domain = NULL) {
	
$this->db->where('domain_name', $domain);
$this->db->from('domain_whois');
$query = $this->db->count_all_results();
			return $query;
	}
	public function domain_count($domain = NULL) {
		$sql = "SELECT COUNT(domain_name) as cnt FROM domain_whois dw";
		if($domain != NULL) {
			$sql = "SELECT COUNT(domain_name) as cnt FROM domain_whois dw WHERE domain_name LIKE '".$domain."'";
		}
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return	$row['cnt'];
	}

	public function fetch_domain_report($limit, $start, $domain = NULL) {
		$sql = "SELECT dw.host_org, dw.dc_name, dw.domain_name, dw.nsip1 FROM domain_whois dw LIMIT ".$start.", ".$limit;
		if($domain != NULL) {
			$sql = "SELECT dw.host_org, dw.dc_name, dw.domain_name, dw.nsip1 FROM domain_whois dw WHERE domain_name LIKE '".$domain."' LIMIT ".$start.", ".$limit;
		}
		$query = $this->db->query($sql);
		$i = 0;		
		foreach ($query->result_array() as $key => $value) {
			$rows[$i][] = $value['domain_name'];
			$rows[$i][] = $value['dc_name'];
			$rows[$i][] = $value['host_org'];
			$rows[$i][] = $value['nsip1'];
			$i++;
		}
		return $rows;
	}
	
	public function global_count($country = NULL) {
		$sql = "SELECT COUNT(DISTINCT c.countries_name) as cnt FROM countries c INNER JOIN domain_whois dw ON c.countries_iso_code_2 = dw.dc_country";
		if($country != NULL) {
			$sql = "SELECT COUNT(DISTINCT c.countries_name) as cnt FROM countries c INNER JOIN domain_whois dw ON c.countries_iso_code_2 = dw.dc_country WHERE c.countries_name LIKE '".$country."'";
		}
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return	$row['cnt'];
	}
	
	public function global_auto($string = array()) {
		$sql = "SELECT DISTINCT c.countries_name, c.countries_iso_code_2 FROM countries c INNER JOIN domain_whois dw ON c.countries_iso_code_2 = dw.dc_country WHERE c.countries_name LIKE '".$string['keyword']."%'";
	  $query = $this->db->query($sql);
	  return $query->result();
	}
	
	public function fetch_global_report($limit, $start, $country = NULL) {
	
		$sql = "SELECT DISTINCT c.countries_name, c.countries_iso_code_2 FROM countries c INNER JOIN domain_whois dw ON c.countries_iso_code_2 = dw.dc_country ORDER BY c.countries_name ASC LIMIT ".$start.", ".$limit;
		if($country != NULL) {
			$sql = "SELECT DISTINCT c.countries_name, c.countries_iso_code_2 FROM countries c INNER JOIN domain_whois dw ON c.countries_iso_code_2 = dw.dc_country WHERE c.countries_name LIKE '".$country."' ORDER BY c.countries_name ASC  LIMIT  ".$start.", ".$limit;
		}
		$query = $this->db->query($sql);
		$i = 0;		
		foreach ($query->result_array() as $key => $value) {
			$sql1 = "SELECT COUNT(DISTINCT dw.dc_name) as cnt FROM domain_whois dw WHERE dw.dc_country = '".$value['countries_iso_code_2']."'";
			$query1 = $this->db->query($sql1);
			$result1 = $query1->row_array();
			$count1= $result1['cnt'];	
			
			$sql2 = "SELECT COUNT(DISTINCT dw.host_org) as cnt FROM domain_whois dw WHERE dw.dc_country = '".$value['countries_iso_code_2']."'";
			$query2 = $this->db->query($sql2);
			$result2 = $query2->row_array();
			$count2= $result2['cnt'];	
			
			$sql3 = "SELECT COUNT(dw.domain_name) as cnt FROM domain_whois dw WHERE dw.dc_country = '".$value['countries_iso_code_2']."'";
			$query3 = $this->db->query($sql3);
			$result3 = $query3->row_array();
			$count3= $result3['cnt'];	
			$rows[$i][] = $value['countries_name'];
			$rows[$i][] = $count1;
			$rows[$i][] = $count2;
			$rows[$i][] = $count3;
			$i++;
		}
		return $rows;
	}
	
	public function hc_count() {
		$sql = "SELECT COUNT(DISTINCT dw.host_org) as cnt FROM domain_whois dw WHERE dw.host_org <> ''";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return	$row['cnt'];
	}
	
	public function fetch_hc_report($limit, $start) {
	
		$sql = "SELECT DISTINCT dw.host_org FROM domain_whois dw WHERE dw.host_org <> '' LIMIT ".$start.", ".$limit;
		$query = $this->db->query($sql);
		$i = 0;		
		foreach ($query->result_array() as $key => $value) {
			$sql1 = "SELECT COUNT(DISTINCT dw.dc_name) as cnt FROM domain_whois dw WHERE dw.host_org = '".$value['host_org']."'";
			$query1 = $this->db->query($sql1);
			$result1 = $query1->row_array();
			$count1= $result1['cnt'];	
			
			$sql2 = "SELECT COUNT(dw.domain_name) as cnt FROM domain_whois dw WHERE dw.host_org = '".$value['host_org']."'";
			$query2 = $this->db->query($sql2);
			$result2 = $query2->row_array();
			$count2= $result2['cnt'];	
			
			$sql3 = "SELECT COUNT(distinct(dw.ns1)) + COUNT(distinct(dw.ns2)) + COUNT(distinct(dw.ns3)) + COUNT(distinct(dw.ns4)) as cnt FROM domain_whois dw WHERE dw.host_org = '".$value['host_org']."'";
			$query3 = $this->db->query($sql3);
			$result3 = $query3->row_array();
			$count3 = $result3['cnt'];	
			
			$sql4 = "SELECT COUNT(distinct(dw.domain_ip)) + COUNT(distinct(dw.nsip1)) + COUNT(distinct(dw.nsip2)) + COUNT(distinct(dw.nsip3)) + COUNT(distinct(dw.nsip4)) as cnt FROM domain_whois dw WHERE dw.host_org = '".$value['host_org']."'";
			$query4 = $this->db->query($sql4);
			$result4 = $query4->row_array();
			$count4 = $result4['cnt'];	
			
			$rows[$i][] = $value['host_org'];
			$rows[$i][] = $count1;
			$rows[$i][] = $count2;
			$rows[$i][] = $count3;
			$rows[$i][] = $count4;
			$i++;
		}
		return $rows;
	}

	public function ip_count() {
		$sql = "SELECT COUNT(distinct(dw.domain_ip)) + COUNT(distinct(dw.nsip1)) + COUNT(distinct(dw.nsip2)) + COUNT(distinct(dw.nsip3)) + COUNT(distinct(dw.nsip4)) as cnt FROM domain_whois dw";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return	$row['cnt'];
	}
	
	public function fetch_ip_report($limit, $start) {
	
		$sql = "SELECT dc_name, host_org, ns1, domain_ip, nsip1, nsip2, nsip3, nsip4 FROM domain_whois dw LIMIT ".$start.", ".$limit;
		$query = $this->db->query($sql);
		$i = 0;		
		foreach ($query->result_array() as $key => $value) {
			if($value['domain_ip'] != '') {
				if (stripos($value['domain_ip'], ',') !== false) {
					$ips = explode(',', $value['domain_ip']);	
					foreach ($ips as $ip_searched) {
						$sql = "SELECT COUNT(domain_name) as domains FROM domain_whois dw WHERE dw.domain_ip LIKE '%".$ip_searched."%' OR dw.nsip1 LIKE '".$ip_searched."%' OR dw.nsip2 LIKE '".$ip_searched."%' OR dw.nsip3 LIKE '".$ip_searched."%' OR dw.nsip4 LIKE '".$ip_searched."%'";
						$result = $this->db->query($sql)->result_array();
						$rows[$ip_searched][] = $result[0]['domains'];
						$rows[$ip_searched][] = $value['dc_name'];
						$rows[$ip_searched][] = $value['host_org'];
						$rows[$ip_searched][] = $value['ns1'];
					}
				}
				else {
					$sql = "SELECT COUNT(domain_name) as domains FROM domain_whois dw WHERE dw.domain_ip LIKE '%".$value['domain_ip']."%' OR dw.nsip1 LIKE '".$value['domain_ip']."%' OR dw.nsip2 LIKE '".$value['domain_ip']."%' OR dw.nsip3 LIKE '".$value['domain_ip']."%' OR dw.nsip4 LIKE '".$value['domain_ip']."%'";
					$result = $this->db->query($sql)->result_array();
					$rows[$value['domain_ip']][] = $result[0]['domains'];
					$rows[$value['domain_ip']][] = $value['dc_name'];
					$rows[$value['domain_ip']][] = $value['host_org'];
					$rows[$value['domain_ip']][] = $value['ns1'];
				}
			}
			if($value['nsip1'] != '') {
				$sql = "SELECT COUNT(domain_name) as domains FROM domain_whois dw WHERE dw.domain_ip LIKE '%".$value['nsip1']."%' OR dw.nsip1 LIKE '".$value['nsip1']."%' OR dw.nsip2 LIKE '".$value['nsip1']."%' OR dw.nsip3 LIKE '".$value['nsip1']."%' OR dw.nsip4 LIKE '".$value['nsip1']."%'";
				$result = $this->db->query($sql)->result_array();
				$rows[$value['nsip1']][] = $result[0]['domains'];
				$rows[$value['nsip1']][] = $value['dc_name'];
				$rows[$value['nsip1']][] = $value['host_org'];
				$rows[$value['nsip1']][] = $value['ns1'];
			}
			if($value['nsip2'] != '') {
				$sql = "SELECT COUNT(domain_name) as domains FROM domain_whois dw WHERE dw.domain_ip LIKE '%".$value['nsip2']."%' OR dw.nsip1 LIKE '".$value['nsip2']."%' OR dw.nsip2 LIKE '".$value['nsip2']."%' OR dw.nsip3 LIKE '".$value['nsip2']."%' OR dw.nsip4 LIKE '".$value['nsip2']."%'";
				$result = $this->db->query($sql)->result_array();
				$rows[$value['nsip2']][] = $result[0]['domains'];
				$rows[$value['nsip2']][] = $value['dc_name'];
				$rows[$value['nsip2']][] = $value['host_org'];
				$rows[$value['nsip2']][] = $value['ns1'];
			}
			if($value['nsip3'] != '') {
				$sql = "SELECT COUNT(domain_name) as domains FROM domain_whois dw WHERE dw.domain_ip LIKE '%".$value['nsip3']."%' OR dw.nsip1 LIKE '".$value['nsip3']."%' OR dw.nsip2 LIKE '".$value['nsip3']."%' OR dw.nsip3 LIKE '".$value['nsip3']."%' OR dw.nsip4 LIKE '".$value['nsip3']."%'";
				$result = $this->db->query($sql)->result_array();
				$rows[$value['nsip3']][] = $result[0]['domains'];
				$rows[$value['nsip3']][] = $value['dc_name'];
				$rows[$value['nsip3']][] = $value['host_org'];
				$rows[$value['nsip3']][] = $value['ns1'];
			}
			if($value['nsip4'] != '') {
				$sql = "SELECT COUNT(domain_name) as domains FROM domain_whois dw WHERE dw.domain_ip LIKE '%".$value['nsip4']."%' OR dw.nsip1 LIKE '".$value['nsip4']."%' OR dw.nsip2 LIKE '".$value['nsip4']."%' OR dw.nsip3 LIKE '".$value['nsip4']."%' OR dw.nsip4 LIKE '".$value['nsip4']."%'";
				$result = $this->db->query($sql)->result_array();
				$rows[$value['nsip4']][] = $result[0]['domains'];
				$rows[$value['nsip4']][] = $value['dc_name'];
				$rows[$value['nsip4']][] = $value['host_org'];
				$rows[$value['nsip4']][] = $value['ns1'];
			}
		}
		return $rows;
	}
	
	public function ns_count() {
		$sql = "SELECT COUNT(distinct(dw.ns1)) + COUNT(distinct(dw.ns2)) + COUNT(distinct(dw.ns3)) + COUNT(distinct(dw.ns4)) as cnt FROM domain_whois dw";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return	$row['cnt'];
	}
	
	public function fetch_ns_report($limit, $start) {
		$sql = "SELECT dc_name, host_org, ns1, domain_name, nsip1, nsip2, nsip3, nsip4, ns1, ns2, ns3, ns4 FROM domain_whois dw LIMIT ".$start.", ".$limit;
		$query = $this->db->query($sql);
		$i = 0;	
		foreach ($query->result_array() as $key => $value) {
			if($value['ns1'] != '') {
				$rows[$value['ns1']][] = $value['domain_name'];
				$rows[$value['ns1']][] = $value['nsip1'];
				$rows[$value['ns1']][] = $value['host_org'];
				$rows[$value['ns1']][] = $value['dc_name'];
			}
			if($value['ns2'] != '') {
				$rows[$value['ns2']][] = $value['domain_name'];
				$rows[$value['ns2']][] = $value['nsip2'];
				$rows[$value['ns2']][] = $value['host_org'];
				$rows[$value['ns2']][] = $value['dc_name'];
			}
			if($value['ns3'] != '') {
				$rows[$value['ns3']][] = $value['domain_name'];
				$rows[$value['ns3']][] = $value['nsip3'];
				$rows[$value['ns3']][] = $value['host_org'];
				$rows[$value['ns3']][] = $value['dc_name'];
			}
			if($value['ns4'] != '') {
				$rows[$value['ns4']][] = $value['domain_name'];
				$rows[$value['ns4']][] = $value['nsip4'];
				$rows[$value['ns4']][] = $value['host_org'];
				$rows[$value['ns4']][] = $value['dc_name'];
			}
		}
		return $rows;
	}
}
?>