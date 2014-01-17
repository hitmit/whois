<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('who_is_model');
	}
	public function index()
	{
		//$this->load->view('welcome_message');
		$this->load->view('template/header');
		$this->load->view('template/body');
		$this->load->view('template/footer');
		
	}
	public function auto()
	{
		//$this->load->view('welcome_message');
		//$this->load->view('template/header');
		$this->load->view('auto/auto');
		//$this->load->view('template/footer');
		
	}
	public function searchwhois()
	{
		$this->load->library('who_is');
		$domain = $this->input->post('domain'); 
		$this->session->set_userdata('domain', $domain);
		$whois_fetched = $this->who_is_model->who_is_search_result($domain);
		$fetch_whois =  $this->who_is->domain_whois_fetched($domain,1); 
		if (count($whois_fetched) > 0) {
			if($whois_fetched['updatedon'] != $fetch_whois['updatedon']){
				$this->who_is_model->update_whois_result($fetch_whois, $whois_fetched, $whois_fetched['domain_id']); 
				$data['whois'] = $fetch_whois;
			}
			else {
				$data['whois'] = $fetch_whois;
			}
		}
		else{
			$result = $this->who_is_model->insert_whois_result($fetch_whois); 
			$data['whois'] = $fetch_whois;
		}
		//exec("D:\wamp\bin\php\php5.3.13\php.exe domain_whois.php ".$domain." > update_whois.txt &");
		$this->load->view('template/header');
		$this->load->view('template/whois', $data);
		$this->load->view('template/footer');
	}
	
	public function history()
	{
		$domain = $this->input->post('term',TRUE);
		$this->load->library('who_is');
		$result = $this->who_is_model->search_history($domain);
		if(!empty($result)) {
			$data['old'] = $result;
		}	
		else {
			$data['old'] = "No History Found";
		}
		$fetch_whois = $this->who_is_model->who_is_search_result($domain);
		$data['new'] = $fetch_whois;
		$this->load->view('template/history', $data);
	}
	public function web_info(){
	
		$this->load->library('who_is');
			$domain = $this->input->post('term',TRUE);
			$hostingtype = "";
  $contact_detail = array();
	$whois = $this->who_is_model->who_is_search_result($domain);
	$os_exist = $this->who_is_model->is_os_exist($domain);
	$domain_ip = '';
  $email = '';
  if ($os_exist->num_rows() > 0) {
		$row = $os_exist->row_array(); 
    $contact_detail['data'] = $row;
	}
  else {
    $detail = $this->who_is->domain_os_fetched($domain);
	  $contact_detail['data'] = $detail;
  }
  if (stripos($whois['domain_ip'], ",")) {
      $hostingtype = 'Cloud';
      $ip = explode(",", $whois['domain_ip']);
      $domain_ip = $ip[0];
	} else {
		$domain_ip = $whois['domain_ip'];
	}
    $contact_detail[] = $whois['ownername'];
    if ($whois['techemail'] != '') {
      $email = $whois['techemail'];
    }
    if ($whois['adminemail'] != '') {
      $email = $whois['adminemail'];
    }
    if ($whois['owneremail'] != '') {
      $email = $whois['owneremail'];
    }
    $contact_detail[] = $email;
    $contact_detail[] = $whois['address'];
  
  /* $query2 = db_select('domain_dns', 'dns')->fields('dns', array('mx_record'));
  $query2->condition('dns.dnsofdomain', db_like($domain) . '%', 'LIKE');
  $result2 = $query2->execute();
  foreach ($result2 as $value2) {
    $contact_detail['dns'] = $value2;
  }
  if ($hostingtype == "") {
    $query3 = db_select('domain_whois', 'dw');
    $query3->addExpression('COUNT(*)', 'cnt');
    $db_or = db_or();
    $db_or->condition('dw.domain_ip', '%' . $domain_ip . '%', 'LIKE');
    $db_or->condition('dw.nsip1', '%' . $domain_ip . '%', 'LIKE');
    $db_or->condition('dw.nsip2', '%' . $domain_ip . '%', 'LIKE');
    $db_or->condition('dw.nsip3', '%' . $domain_ip . '%', 'LIKE');
    $db_or->condition('dw.nsip4', '%' . $domain_ip . '%', 'LIKE');
    $query3->condition($db_or);
    $result3 = $query3->execute();
    foreach ($result3 as $value3) {
      if ($value3->cnt == 1) {
        $hostingtype = 'Dedicated';
      } elseif ($value3->cnt > 10) {
        $hostingtype = 'Shared';
      } else {
        $hostingtype = 'VPS';
      }
    }
  }
  $contact_detail[] = $hostingtype; */
  $data['web_info'] = $contact_detail;
		$this->load->view('template/header');
		$this->load->view('template/test1', $data);
		$this->load->view('template/footer');
	}
	
	public function suggestions()
	{
		// Search term from jQuery
		$term = $this->input->post('term');

		// Do mysql query or what ever
		$arr = array($term, 'item1', 'item2', 'item3');

		// Return data
		echo json_encode($arr);
	}
	public function dns_fetched() {
		$this->load->library('table');
		$domain = $this->input->post('domain',TRUE);
		$dns_result = $this->who_is_model->dns_result($domain);
	  $data['dns_result'] = $dns_result['soa_record'];
		$this->table->set_heading('Record', 'Type', 'TTL', 'Priority', 'Content');
		if(!empty($dns_result['ns_record'])) {
			$ns = explode("*", $dns_result['ns_record']); 
			foreach($ns as $nsrecord) {
				if(!empty($nsrecord)){
					$ns_record = str_replace("	","|",$nsrecord);
					$ns_record = str_replace(" ","|",$ns_record);
					$ns_record1 = explode("NS", $ns_record);
					$nsrecord1 = explode("|", $ns_record1[0]);
					if(count($ns_record1) > 1) {
						$this->table->add_row($nsrecord1[0], 'NS', $nsrecord1[1], '', str_replace("|", "", $ns_record1[1]));
					}
				} 
			}
		}   
		if(!empty($dns_result['mx_record'])) { 
			$mx = explode("*", $dns_result['mx_record']);
			foreach($mx as $mxrecord) {
				if(!empty($mxrecord)){ 
					$mx_record = str_replace("	","|",$mxrecord);
					$mx_record = str_replace(" ","|",$mx_record);
					$mx_record1 = explode("MX", $mx_record);
					$mxrecord1 = explode("|", $mx_record1[0]);
					if(count($mx_record1) > 1) {
						$this->table->add_row($mxrecord1[0], 'MX', $mxrecord1[1], '', str_replace("|", "", $mx_record1[1]));
					}
				}   
			}
		}
		if(!empty($dns_result['txt_record'])) { 
			$txt = explode("*", $dns_result['txt_record']);
			foreach($txt as $txtrecord) {
				if(!empty($txtrecord)){ 
					$txt_record = str_replace("	","|",$txtrecord);
					$txt_record = str_replace(" ","|",$txt_record);
					$txt_record1 = explode("txt", $txt_record);
					$txtrecord = explode("|", $txt_record1[0]);
					if(count($txt_record1) > 1) {
						$this->table->add_row($txtrecord[0], 'TXT', $txtrecord[1], '', str_replace("|", "", $txt_record1[1]));
					}
				}   
			}
		}
		if(!empty($dns_result['a_record'])) { 
			$a = explode("*", $dns_result['a_record']);
			foreach($a as $arecord) {
				if(!empty($arecord)){ 
					$a_record = str_replace("	","|",$arecord);
					$a_record = str_replace(" ","|",$a_record);
					$a_record1 = explode("A", $a_record);
					$arecord = explode("|", $a_record1[0]);
					if(count($a_record1) > 1) {
						$this->table->add_row($arecord[0], 'A', $arecord[1], '', str_replace("|", "", $a_record1[1]));
					}
				}   
			}
		}
		$data['results'] = $this->table->generate(); 
    //$data['dns_result'] = $domain;
		$this->load->view('template/dns', $data);
  }
	public function test() {
		$this->load->view('template/header');
		$this->load->view('template/test1');
		$this->load->view('template/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */