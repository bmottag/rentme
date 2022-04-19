<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
    /**
	 * Trucks list by company and type2
	 * @since 25/1/2017
	 */
	public function get_trucks_by_id2($idCompany, $type)
	{
		$trucks = array();
		$sql = "SELECT id_vehicle, CONCAT(unit_number,' -----> ', description) as unit_description
			FROM param_vehicle 
			WHERE fk_id_company = $idCompany AND type_level_2 = $type AND state = 1
			ORDER BY unit_number";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$trucks[$i]["id_truck"] = $row->id_vehicle;
				$trucks[$i]["unit_number"] = $row->unit_description;
				$i++;
			}
		}
		$this->db->close();
		return $trucks;
	}

	/**
	 * Trucks list by type1 = rentals
	 * que esten activas
	 * @since 8/3/2017
	 */
	public function get_trucks_by_id1()
	{
		$trucks = array();
		$sql = "SELECT id_vehicle, CONCAT(unit_number,' -----> ', description) as unit_description
			FROM param_vehicle 
			WHERE type_level_1 = 2 AND state = 1
			ORDER BY unit_number";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$trucks[$i]["id_truck"] = $row->id_vehicle;
				$trucks[$i]["unit_number"] = $row->unit_description;
				$i++;
			}
		}
		$this->db->close();
		return $trucks;
	}

	/**
	 * List type of contract
	 * @since 12/04/2022
	 */
	public function get_type_contract()
	{
		$contracts = array();
		$sql = "SELECT id_type_contract, name_type_contract
			FROM rme_param_type_contract
			ORDER BY id_type_contract";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$contracts[$i]["id_type_contract"] = $row->id_type_contract;
				$contracts[$i]["name_type_contract"] = $row->name_type_contract;
				$i++;
			}
		}
		$this->db->close();
		return $contracts;
	}

	/**
	 * List of status
	 * @since 18/04/2022
	 */
	public function get_status() 
	{		
		$this->db->order_by('id_status', 'asc');
		$query = $this->db->get('rme_param_status');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Lista de quipos rentado
	 * @since 28/2/2022
	 */
	public function get_rent_status($arrData) 
	{
		$this->db->select();
		$this->db->join('rme_rent R', 'R.id_rent = RS.fk_id_rent', 'INNER');
		$this->db->join('user U', 'RS.fk_id_user = U.id_user', 'INNER');
		$this->db->join('rme_param_status S', 'S.id_status = RS.fk_id_status', 'INNER');

		if (array_key_exists("idRent", $arrData)) {
			$this->db->where('fk_id_rent', $arrData["idRent"]);
		}
				
		$this->db->order_by('id_rent_status', 'desc');
		$query = $this->db->get('rme_rent_status RS');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Save rent
	 * @since 2/4/2018
	 */
	public function saveRent() 
	{
		$idRent = $this->input->post('hddId');
		$damage = $this->input->post('damage');
		$damage_observation = $this->input->post('damage_observation');

		if ($damage == 2) {
			$damage_observation = '';
		}
		
		$data = array(
			'fk_id_client' => $this->input->post('id_client'),
			'fk_id_equipment' => $this->input->post('truck'),
			'start_date' => $this->input->post('start_date'),
			'finish_date' => $this->input->post('finish_date'),
			'fuel' => $this->input->post('fuel'),
			'clean' => $this->input->post('clean'),
			'damage' => $this->input->post('damage'),
			'damage_observation' => $damage_observation,
			'fk_id_type_contract' => $this->input->post('type_contract'),
			'current_hours' => $this->input->post('current_hours'),
			'observations' => $this->input->post('observations')
		);
		
		//revisar si es para adicionar o editar
		if ($idRent == 'x') {
			$data['fk_id_status'] = 1;
			$data['last_message'] = $this->input->post('last_message');
			$query = $this->db->insert('rme_rent', $data);
			$idRent = $this->db->insert_id();
			$arrParam = array(
				'fk_id_rent' => $idRent,
				'fk_id_user' => $this->session->userdata("idUser"),
				'date_issue' => date("Y-m-d H:i:s"),
				'observation' => $data['last_message'],
				'fk_id_status' => $data['fk_id_status']
			);
			$this->saveRentStatus($arrParam);
		} else {
			$this->db->where('id_rent', $idRent);
			$query = $this->db->update('rme_rent', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Save rent status
	 * @since 19/04/2022
	 */
	public function saveRentStatus($arrParam)
	{
		$data = array(
			'fk_id_rent' => $arrParam['fk_id_rent'],
			'fk_id_user' => $arrParam['fk_id_user'],
			'date_issue' => $arrParam['date_issue'],
			'observation' => $arrParam['observation'],
			'fk_id_status' => $arrParam['fk_id_status']
		);
		$query = $this->db->insert('rme_rent_status', $data);
		if ($query) {
			$datos = array(
				'fk_id_status' => $arrParam['fk_id_status'],
				'last_message' => $arrParam['observation']
			);
			$this->db->where('id_rent', $arrParam['fk_id_rent']);
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
}