<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class External_model extends CI_Model {
		
	/**
	 * task control list
	 * @since 7/4/2020
	 */
	public function get_task_control($arrDatos) 
	{
		$this->db->select('T.*, CONCAT(U.first_name, " " , U.last_name) supervisor, J.id_job, J.job_description, C.company_name');
		$this->db->join('param_jobs J', 'J.id_job = T.fk_id_job', 'INNER');
		$this->db->join('param_company C', 'C.id_company = T.fk_id_company', 'LEFT');
		$this->db->join('user U', 'U.id_user = T.fk_id_user', 'INNER');
		
		if (array_key_exists("idJob", $arrDatos)) {
			$this->db->where('T.fk_id_job', $arrDatos["idJob"]);
		}
		if (array_key_exists("idTaskControl", $arrDatos)) {
			$this->db->where('T.id_job_task_control', $arrDatos["idTaskControl"]);
		}
		$query = $this->db->get('job_task_control T');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
			
	/**
	 * Add Task Control
	 * @since 8/4/2020
	 */
	public function add_task_control() 
	{
		$idUser = 1;
		$idTaskControl = $this->input->post('hddIdentificador');
	
		$data = array(
			'name' => $this->input->post('name'),
			'contact_phone_number' => $this->input->post('phone_number'),
			'superintendent' => $this->input->post('superintendent'),
			'fk_id_company' => $this->input->post('company'),
			'work_location' => $this->input->post('work_location'),
			'crew_size' => $this->input->post('crew_size'),
			'task' => $this->input->post('task'),
			'distancing' => $this->input->post('distancing'),
			'distancing_comments' => $this->input->post('distancing_comments'),
			'sharing_tools' => $this->input->post('sharing_tools'),
			'sharing_tools_comments' => $this->input->post('sharing_tools_comments'),
			'required_ppe' => $this->input->post('required_ppe'),
			'required_ppe_comments' => $this->input->post('required_ppe_comments'),
			'symptoms' => $this->input->post('symptoms'),
			'symptoms_comments' => $this->input->post('symptoms_comments'),
			'protocols' => $this->input->post('protocols'),
			'protocols_comments' => $this->input->post('protocols_comments')
		);
		
		//revisar si es para adicionar o editar
		if ($idTaskControl == '') {
			$data['fk_id_user'] = $idUser;
			$data['fk_id_job'] = $this->input->post('hddIdJob');
			$data['date_task_control'] = date("Y-m-d");
			$query = $this->db->insert('job_task_control', $data);	
			$idTaskControl = $this->db->insert_id();				
		} else {
			$this->db->where('id_job_task_control', $idTaskControl);
			$query = $this->db->update('job_task_control', $data);
		}
		
		if ($query) {
			return $idTaskControl;
		} else {
			return false;
		}
	}

	/**
	 * Add employee
	 * @since 31/01/2022
	 */
	public function saveEmployee() 
	{
		$newPassword = addslashes($this->security->xss_clean($this->input->post('inputPassword')));
		$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 

		$data = array(
			'first_name' => addslashes($this->security->xss_clean($this->input->post('firstName'))),
			'last_name' => addslashes($this->security->xss_clean($this->input->post('lastName'))),
			'log_user' => addslashes($this->security->xss_clean($this->input->post('user'))),
			'password' => md5($passwd),
			'social_insurance' => addslashes($this->security->xss_clean($this->input->post('insuranceNumber'))),
			'health_number' => addslashes($this->security->xss_clean($this->input->post('healthNumber'))),
			'birthdate' => addslashes($this->security->xss_clean($this->input->post('birth'))),
			'movil' => addslashes($this->security->xss_clean($this->input->post('movilNumber'))),
			'email' => addslashes($this->security->xss_clean($this->input->post('email'))),
			'address' => addslashes($this->security->xss_clean($this->input->post('address'))),
			'perfil' => 7,
			'state' => 1
		);	
		$query = $this->db->insert('user', $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Save form asignature
	 * @since 25/05/2022
	 */
	public function save_formSignature()
	{
		$idRent = $this->input->post('hddId');
		$date_issue = date("Y-m-d H:i:s");
		$id_user = $this->last_user($idRent);

		$data = array(
			'fk_id_rent' => $idRent,
			'fk_id_user' => $id_user['fk_id_user'],
			'date_issue' => $date_issue,
			'observation' => 'Equipment received by the client',
			'fk_id_status' => 3
		);
		$query = $this->db->insert('rme_rent_status', $data);
		if ($query) {
			$datos = array(
				'fk_id_status' => 3,
				'last_message' => 'Equipment received by the client',
				'comments' => $this->input->post('comments'),
				'conditions' => 1
			);
			$this->db->where('id_rent', $idRent);
			$query2 = $this->db->update('rme_rent', $datos);
			if ($query2) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Last user of rent 
	 * @since 25/05/2022
	 */
	public function last_user($id)
	{
		$this->db->select('MAX(id_rent_status), fk_id_user');
		$this->db->where('fk_id_rent', $id);
		$query = $this->db->get('rme_rent_status');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}

}