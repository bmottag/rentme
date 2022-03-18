<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Settings_model extends CI_Model {

	    
		/**
		 * Verify if the user already exist by the social insurance number
		 * @author BMOTTAG
		 * @since  8/11/2016
		 * @review 10/12/2020
		 */
		public function verifyUser($arrData) 
		{
				if (array_key_exists("idUser", $arrData)) {
					$this->db->where('id_user !=', $arrData["idUser"]);
				}			

				$this->db->where($arrData["column"], $arrData["value"]);
				$query = $this->db->get("user");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Add/Edit USER
		 * @since 8/11/2016
		 */
		public function saveUser() 
		{
				$idUser = $this->input->post('hddId');
				
				$data = array(
					'first_name' => addslashes($this->security->xss_clean($this->input->post('firstName'))),
					'last_name' => addslashes($this->security->xss_clean($this->input->post('lastName'))),
					'log_user' => addslashes($this->security->xss_clean($this->input->post('user'))),
					'movil' => addslashes($this->security->xss_clean($this->input->post('movilNumber'))),
					'email' => addslashes($this->security->xss_clean($this->input->post('email'))),
					'fk_id_user_role' => $this->input->post('id_role')
				);	

				//revisar si es para adicionar o editar
				if ($idUser == '') 
				{
					$data['fk_id_app_company_u'] = $this->session->userdata("idCompany");
					$data['status'] = 0;//si es para adicionar se coloca estado inicial como usuario nuevo
					$data['password'] = 'e10adc3949ba59abbe56e057f20f883e';//123456
					$query = $this->db->insert('user', $data);
					$idUser = $this->db->insert_id();
				} else {
					$data['status'] = $this->input->post('status');
					$this->db->where('id_user', $idUser);
					$query = $this->db->update('user', $data);
				}
				if ($query) {
					return $idUser;
				} else {
					return false;
				}
		}
		
	    /**
	     * Reset user´s password
	     * @author BMOTTAG
	     * @since  11/1/2017
	     */
	    public function resetEmployeePassword($idUser)
		{
				$passwd = '123456';
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd,
					'status' => 0
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('usuarios', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }

	    /**
	     * Update user´s password
	     * @author BMOTTAG
	     * @since  8/11/2016
	     */
	    public function updatePassword()
		{
				$idUser = $this->input->post("hddId");
				$newPassword = $this->input->post("inputPassword");
				$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('user', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }
		
		/**
		 * Add/Edit JOB
		 * @since 10/11/2016
		 */
		public function saveJob() 
		{				
				$idJob = $this->input->post('hddId');
				
				$data = array(
					'fk_id_param_client' => $this->input->post('idClient'),
					'job_description' => addslashes($this->security->xss_clean($this->input->post('jobName')))
				);			

				//revisar si es para adicionar o editar
				if ($idJob == '') {
					$data['status'] = 1;
					$query = $this->db->insert('param_jobs', $data);
				} else {
					$data['status'] = $this->input->post('statusJob');
					$this->db->where('id_job', $idJob);
					$query = $this->db->update('param_jobs', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Update jobs status
		 * @since 12/1/2019
		 */
		public function updateJobsStatus($status) 
		{
			//if it comes from the active view, then inactive everything
			//else do nothing and continue with the activation
			if($status == 1){
				//update all status to inactive
				$sql = "UPDATE param_jobs J";
				$sql.= " INNER JOIN param_client C ON C.id_param_client = J.fk_id_param_client";
				$sql.= " SET status = 2";
				$sql.= " WHERE C.fk_id_app_company  = " . $this->session->userdata("idCompany");
				$query = $this->db->query($sql);
			}

			//update status
			$query = 1;
			if ($jobs = $this->input->post('job')) {
				$tot = count($jobs);
				for ($i = 0; $i < $tot; $i++) {
					$data['status'] = 1;
					$this->db->where('id_job', $jobs[$i]);
					$query = $this->db->update('param_jobs', $data);					
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}

		/**
		 * Add/Edit USER
		 * @since 4/7/2021
		 */
		public function saveParamClient() 
		{
				$idClient = $this->input->post('hddId');
				
				$data = array(
					'param_client_name' => addslashes($this->security->xss_clean($this->input->post('clientName'))),
					'param_client_contact' => addslashes($this->security->xss_clean($this->input->post('contact'))),
					'param_client_movil' => addslashes($this->security->xss_clean($this->input->post('movilNumber'))),
					'param_client_email' => addslashes($this->security->xss_clean($this->input->post('email'))),
					'param_client_address' => addslashes($this->security->xss_clean($this->input->post('address')))
				);	

				//revisar si es para adicionar o editar
				if ($idClient == '') {
					$data['fk_id_app_company'] = $this->session->userdata("idCompany");
					$data['param_client_status'] = 1;
					$data['date_issue'] = date("Y-m-d");
					$query = $this->db->insert('param_client', $data);
				}else{
					$data['param_client_status'] = $this->input->post('status');
					$this->db->where('id_param_client', $idClient);
					$query = $this->db->update('param_client', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Update company information
		 * @since 19/7/2021
		 */
		public function saveCompany() 
		{
				$idCompany = $this->input->post('hddId');
				
				$data = array(
					'company_name' => addslashes($this->security->xss_clean($this->input->post('companyName'))),
					'company_contact' => addslashes($this->security->xss_clean($this->input->post('contact'))),
					'company_movil' => addslashes($this->security->xss_clean($this->input->post('movilNumber'))),
					'company_address' => addslashes($this->security->xss_clean($this->input->post('address'))),
					'company_gst' => addslashes($this->security->xss_clean($this->input->post('gst'))),
					'fk_id_city' => $this->input->post('idCity')
				);	

				$this->db->where('id_company', $idCompany);
				$query = $this->db->update('app_company', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Update taxes
		 * @since 20/7/2021
		 */
		public function saveTax() 
		{
				$idTax = $this->input->post('hddId');
				
				$data = array(
					'taxes_description' => addslashes($this->security->xss_clean($this->input->post('taxes_description'))),
					'taxes_value' => addslashes($this->security->xss_clean($this->input->post('taxes_value')))
				);	

				if ($idTax == '') 
				{
					$data['fk_id_app_company_t'] = $this->session->userdata("idCompany");
					$query = $this->db->insert('param_company_taxes', $data);
				} else {
					$this->db->where('id_param_company_taxes', $idTax);
					$query = $this->db->update('param_company_taxes', $data);
				}

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		
	    
	}