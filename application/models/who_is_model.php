<?php
class Who_is_model extends CI_Model {
	public function who_is_search_result($dn) {
		$sql = "SELECT * FROM domain_whois dw WHERE dw.domain_name LIKE ?";
		$query = $this->db->query($sql, array($dn.'%')); 
		foreach ($query->result_array() as $row) {
			return $row;
		}
	}
	public function insert_whois_result($data) {
		$result = $this->db->insert('domain_whois', $data);
		return $result;
	}
	public function update_whois_result($new_data, $old_data, $id) {
		$result = $this->db->update('domain_whois', $new_data, array('domain_id' => $id));
		$old_data['domain_id'] = $id;
		$result = $this->db->insert('domain_whois_history', $old_data);
		return $result;
	}
	public function search_history($dn) {
		$sql = "SELECT * FROM domain_whois_history dw WHERE dw.domain_name LIKE ? LIMIT 1";
		$query = $this->db->query($sql, array($dn.'%')); 
		if($query->num_rows > 0){
			foreach ($query->result_array() as $row) {
				return $row;
			}
		}
		else {
			return array();
		}
	}
	function getData($term) {
		$sql = $this->db->query('select * from countries where name like "'. mysql_real_escape_string($term) .'%" order by name asc limit 0,10');
		return $sql->result();
	}
	public function is_os_exist($domain) {
		return $this->db->get_where('domain_os_headers', array('domainname' => $domain));
	}
	public function dns_result($domain) {
		$query = $this->db->get_where('domain_dns', array('dnsofdomain' => $domain));
		return $query->row_array();
	}
}
?>