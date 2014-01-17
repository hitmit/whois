<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('report_model');
		$this->load->library("pagination");
		$this->load->library('table');
	}
	
	public function dc_report($arg1 = NULL, $arg2 = NULL, $arg3 = NULL) {
		$data['arg'] = array($arg1, urldecode($arg2), urldecode($arg3));
	
		$this->output->enable_profiler(TRUE);
		$dcname = NULL;
		if ($this->input->post('dc_name')) {
			$arg1 = 'dc';
			$dcname =	$arg2 = $this->input->post('dc_name');
			 
		}
		$config = array();
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$config["base_url"] = site_url('report/dc_report');
		$config["total_rows"] = $this->report_model->dc_count($arg1, $arg2, $arg3);
		$this->pagination->initialize($config);
	 	 
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$dc_name =  $this->report_model->fetch_dc_report($config["per_page"], $page, $arg1, $arg2, $arg3);
		$data["links"] = $this->pagination->create_links();
		$this->table->set_heading('S.No', 'DC Name', 'Associated Host Companies', 'Associated Domains', 'Associated Ip\'s');
		$i = 1;
		foreach ($dc_name as $key => $value) {
			$this->table->add_row($i, anchor(site_url('report/dc_report').'/dc/'.$key, $key), $value['host_count'], $value['domain_count'], $value['ip_count']);
			$i++;
		} 
		$data['results'] = $this->table->generate(); 
		$data['dcname'] = $dcname; $data['dcname'] = $dcname; 
		$this->load->view('template/header');
		$this->load->view('template/dc_report', $data);
		$this->load->view('template/footer'); 
	}
	
	public function dc_report_autoComplete() {	
		$term = $this->input->post('term',TRUE);
	  $rows = $this->report_model->dc_count_auto(array('keyword' => $term));
	  $json_array = array();
	  foreach ($rows as $row) {
      array_push($json_array, $row->dc_name);
		}
	  echo json_encode($json_array);
	}
	
	public function domain_report() {	
		$domain = NULL;
		if ($this->input->post('domain')) {
			$domain = $this->input->post('domain');
		}
		$config = array();
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$config["base_url"] = site_url('report/domain_report');
		$config["total_rows"] = $this->report_model->domain_count($domain);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$results =  $this->report_model->fetch_domain_report($config["per_page"], $page, $domain);
		$data["links"] = $this->pagination->create_links();
		$this->table->set_heading('S.No', 'Domain Name', 'Host Company', 'Data Center', 'IP');
		$i = 1;
		foreach ($results as $key => $value) {
			$this->table->add_row($i, $value[0], $value[2], $value[1], $value[3]);
			$i++;
		} 
		$data['results'] = $this->table->generate(); 
		$data['domainname'] = $domain; 
		
		$this->load->view('template/header');
		$this->load->view('template/domain_report', $data);
		$this->load->view('template/footer');
	}
	
	public function domain_report_autoComplete() {	
		$term = $this->input->post('term',TRUE);
	  $rows = $this->report_model->domain_auto(array('keyword' => $term));
	  $json_array = array();
	  foreach ($rows as $row) {
      array_push($json_array, $row->domain_name);
		}
	  echo json_encode($json_array);
	}
	
	public function global_report() {	
		$country = NULL;
		if ($this->input->post('country')) {
			$country = $this->input->post('country');
		}
		$config = array();
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$config["base_url"] = site_url('report/global_report');
		$config["total_rows"] = $this->report_model->global_count($country);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$dc_name =  $this->report_model->fetch_global_report($config["per_page"], $page, $country);
		$data["links"] = $this->pagination->create_links();
		$this->table->set_heading('S.No', 'Country', 'Data Centers', 'Host Companies', 'Domains');
		$i = 1;
		foreach ($dc_name as $key => $value) {
			$this->table->add_row($i, $value[0], $value[1], $value[2], $value[3]);
			$i++;
		} 
		$data['results'] = $this->table->generate(); 
		$data['country'] = $country; 
		$this->load->view('template/header');
		$this->load->view('template/global_report', $data);
		$this->load->view('template/footer');
	}
	
	public function global_report_autoComplete() {	
		$term = $this->input->post('term',TRUE);
	  $rows = $this->report_model->global_auto(array('keyword' => $term));
	  $json_array = array();
	  foreach ($rows as $row) {
      $json_array[] = $row->countries_name;
		}
	  echo json_encode($json_array);
	}
	
	public function hc_report() {
		$config = array();
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$config["base_url"] = site_url('report/hc_report');
		$config["total_rows"] = $this->report_model->hc_count();
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$dc_name =  $this->report_model->fetch_hc_report($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		$this->table->set_heading('S.No', 'Host Compay', 'Data Centers', 'Associated Domains', 'Associated Name Servers', 'Associated IP\'s');
		$i = 1;
		foreach ($dc_name as $key => $value) {
			$this->table->add_row($i, $value[0], $value[1], $value[2], $value[3], $value[4]);
			$i++;
		} 
		$data['results'] = $this->table->generate(); 
		$this->load->view('template/header');
		$this->load->view('template/dc_report', $data);
		$this->load->view('template/footer');
	}
	
	public function ip_report() {
		$config = array();
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		$config["base_url"] = site_url('report/ip_report');
		$config["total_rows"] = $this->report_model->ip_count();
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$dc_name =  $this->report_model->fetch_ip_report($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		$this->table->set_heading('S.No', 'Domain IP', 'Domains', 'Data Center', 'Host Company', 'Name Server');
		$i = 1;
		foreach ($dc_name as $key => $value) {
			if(Count($value)>4) {
				$this->table->add_row($i, $key, $value[0], $value[1], $value[2], $value[3]);
				$i++;
				$this->table->add_row($i, $key, $value[4], $value[5], $value[6], $value[7]);
				$i++;
			}
			else {
				$this->table->add_row($i, $key, $value[0], $value[1], $value[2], $value[3]);
				$i++;
			}
		} 
		$data['results'] = $this->table->generate(); 
		$this->load->view('template/header');
		$this->load->view('template/dc_report', $data);
		$this->load->view('template/footer');
	}
	
	public function ns_report() {
		$config = array();
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		$config["base_url"] = site_url('report/ns_report');
		$config["total_rows"] = $this->report_model->ns_count();
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$dc_name =  $this->report_model->fetch_ns_report($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		$this->table->set_heading('S.No', 'Name Server', 'Domain Name', 'Name Server IP', 'Host Company', 'Data Center');
		$i = 1;
		foreach ($dc_name as $key => $value) {
			$this->table->add_row($i++, $key, $value[0], $value[1], $value[2], $value[3]);
		} 
		$data['results'] = $this->table->generate(); 
		$this->load->view('template/header');
		$this->load->view('template/dc_report', $data);
		$this->load->view('template/footer');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */