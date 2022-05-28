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
		$this->db->select('id_type_contract, name_type_contract');
		$this->db->order_by('id_type_contract', 'asc');
		$query = $this->db->get('rme_param_type_contract');
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
	 * Truck by id
	 * @since 19/04/2022
	 */
	public function get_truck_by_id($id)
	{
		$this->db->select('oil_change, rent_status');
		$this->db->where('id_vehicle', $id);
		$query = $this->db->get('param_vehicle');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	/**
	 * Max rent by id
	 * @since 25/04/2022
	 */
	public function get_rent_by_truck($id)
	{
		$fechaActual = date("Y-m-d");
		$this->db->select('param_client_name, start_date, finish_date');
		$this->db->join('rme_param_client C', 'C.id_param_client = R.fk_id_client', 'INNER');
		$this->db->where('fk_id_equipment', $id);
		$this->db->where("finish_date > '" . $fechaActual . "'");
		$this->db->order_by('id_rent', 'asc');
		$query = $this->db->get('rme_rent R');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Hours type of contract
	 * @since 19/04/2022
	 */
	public function get_hours_contract($id)
	{
		$this->db->select('hours_type_contract');
		$this->db->where('id_type_contract', $id);
		$query = $this->db->get('rme_param_type_contract');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	/**
	 * List of users
	 * @since 14/05/2022
	 */
	public function get_list_users()
	{
		$this->db->where('state', 1);
		$this->db->order_by('first_name','last_name', 'asc');
		$query = $this->db->get('user');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Rent status historical
	 * @since 27/05/2022
	 */
	public function get_statusHistorical($idRent)
	{
		$this->db->select('H.*, T.name_type_contract, P.param_description, CONCAT(U.first_name, " ", U.last_name) name');
		$this->db->join('rme_param_type_contract T', 'T.id_type_contract = H.fk_id_type_contract', 'INNER');
		$this->db->join('rme_param P', 'P.param_value = H.fk_id_fuel AND P.param_code = '. ID_PARAM_CURRENT_FUEL, 'LEFT');
		$this->db->join('user U', 'U.id_user = H.fk_id_user', 'INNER');
		$this->db->where('fk_id_rent', $idRent);
		$this->db->order_by('id_rent_historical', 'desc');
		$query = $this->db->get('rme_rent_historical H');
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
		$fuel = $this->input->post('fuel');
		$clean = $this->input->post('clean');
		$cleaning_date = $this->input->post('cleaning_date');
		$next_cleaning_date = $this->input->post('next_cleaning_date');
		$damage = $this->input->post('damage');
		$damage_observation = $this->input->post('damage_observation');

		if (empty($fuel)){
			$fuel = NULL;
		}
		if ($clean == 1) {
			$next_cleaning_date = NULL;
		} else if ($clean == 2) {
			$cleaning_date = NULL;
		}
		else {
			$clean = NULL;
			$cleaning_date = NULL;
			$next_cleaning_date = NULL;
		}
		if ($damage != 1) {
			$damage_observation = NULL;
			if (empty($damage)){
				$damage = NULL;
			}
		}
		
		$data = array(
			'start_date' => $this->input->post('start_date'),
			'finish_date' => $this->input->post('finish_date'),
			'fk_id_fuel' => $fuel,
			'clean' => $clean,
			'cleaning_date' => $cleaning_date,
			'next_cleaning_date' => $next_cleaning_date,
			'damage' => $damage,
			'damage_observation' => $damage_observation,
			'fk_id_type_contract' => $this->input->post('type_contract'),
			'current_hours' => $this->input->post('current_hours'),
			'fk_id_user' => $this->input->post('responsible'),
			'observations' => $this->input->post('observations'),
		);
		$arrHist = array(
			'start_date' => $this->input->post('start_date'),
			'finish_date' => $this->input->post('finish_date'),
			'fk_id_fuel' => $fuel,
			'clean' => $clean,
			'cleaning_date' => $cleaning_date,
			'next_cleaning_date' => $next_cleaning_date,
			'damage' => $damage,
			'damage_observation' => $damage_observation,
			'fk_id_type_contract' => $this->input->post('type_contract'),
			'current_hours' => $this->input->post('current_hours'),
			'fk_id_user' => $this->input->post('responsible'),
			'observations' => $this->input->post('observations')
		);
		//revisar si es para adicionar o editar
		if ($idRent == 'x') {
			$data['fk_id_client'] = $this->input->post('id_client');
			$data['fk_id_equipment'] = $this->input->post('truck');
			$data['fk_id_status'] = 1;
			$data['last_message'] = $this->input->post('last_message');
			$query = $this->db->insert('rme_rent', $data);
			$idRent = $this->db->insert_id();
			$arrHist['fk_id_rent'] = $idRent;
			$arrParam = array(
				'fk_id_rent' => $idRent,
				'fk_id_user' => $this->session->userdata("idUser"),
				'date_issue' => date("Y-m-d H:i:s"),
				'observation' => $data['last_message'],
				'fk_id_status' => $data['fk_id_status']
			);
			$this->saveRentStatus($arrParam);
			$this->saveWORent($arrParam);
			$this->saveRentStatusHistorical($arrHist);
			$this->updateVehicle($this->input->post('truck'));
		} else {
			if ($this->input->post('start_date') != $this->input->post('hddStartDate') || $this->input->post('finish_date') != $this->input->post('hddFinishDate') || $this->input->post('fuel') != $this->input->post('hddFuel') || $this->input->post('clean') != $this->input->post('hddClean') || $this->input->post('cleaning_date') != $this->input->post('hddCleaningDate') || $this->input->post('next_cleaning_date') != $this->input->post('hddNextCleaningDate') || $this->input->post('damage') != $this->input->post('hddDamage') || $this->input->post('damage_observation') != $this->input->post('hddDamageObservation') || $this->input->post('type_contract') != $this->input->post('hddTypeContract') || $this->input->post('current_hours') != $this->input->post('hddCurrentHours') || $this->input->post('responsible') != $this->input->post('hddResponsible') || $this->input->post('observations') != $this->input->post('hddObservations')) {
				$this->db->where('id_rent', $idRent);
				$query = $this->db->update('rme_rent', $data);
				$arrHist['fk_id_rent'] = $idRent;
				$this->saveRentStatusHistorical($arrHist);
			} else {
				return true;
			}
		}
		if ($query) {
			return $idRent;
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

	/**
	 * Save rent status historical
	 * @since 27/05/2022
	 */
	public function saveRentStatusHistorical($arrParam)
	{
		$data = array(
			'fk_id_rent' => $arrParam['fk_id_rent'],
			'start_date' => $arrParam['start_date'],
			'finish_date' => $arrParam['finish_date'],
			'fk_id_fuel' => $arrParam['fk_id_fuel'],
			'clean' => $arrParam['clean'],
			'cleaning_date' => $arrParam['cleaning_date'],
			'next_cleaning_date' => $arrParam['next_cleaning_date'],
			'damage' => $arrParam['damage'],
			'damage_observation' => $arrParam['damage_observation'],
			'fk_id_type_contract' => $arrParam['fk_id_type_contract'],
			'current_hours' => $arrParam['current_hours'],
			'fk_id_user' => $arrParam['fk_id_user'],
			'observations' => $arrParam['observations'],
			'date_issue' => date("Y-m-d H:i:s")
		);
		$query = $this->db->insert('rme_rent_historical', $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Save current condition
	 * @since 15/05/2022
	 */
	public function saveCurrentCondition() 
	{
		$idRent = $this->input->post('hddId');
		$clean = $this->input->post('clean');
		$cleaning_date = $this->input->post('cleaning_date');
		$next_cleaning_date = $this->input->post('next_cleaning_date');
		$damage = $this->input->post('damage');
		$damage_observation = $this->input->post('damage_observation');

		if ($clean == 1) {
			$next_cleaning_date = NULL;
		} else if ($clean == 2) {
			$cleaning_date = NULL;
		}
		if ($damage != 1) {
			$damage_observation = NULL;
		}
		
		$data = array(
			'fk_id_fuel' => $this->input->post('fuel'),
			'clean' => $clean,
			'cleaning_date' => $cleaning_date,
			'next_cleaning_date' => $next_cleaning_date,
			'damage' => $damage,
			'damage_observation' => $damage_observation,
		);
		$this->db->where('id_rent', $idRent);
		$query = $this->db->update('rme_rent', $data);
		if ($query) {
			$arrParam = array(
				'fk_id_rent' => $idRent,
				'fk_id_user' => $this->session->userdata("idUser"),
				'date_issue' => date("Y-m-d H:i:s"),
				'observation' => $this->input->post('last_message'),
				'fk_id_status' => 6
			);
			$this->saveRentStatus($arrParam);
			$arrHist = array(
				'fk_id_rent' => $idRent,
				'start_date' => $this->input->post('hddStartDate'),
				'finish_date' => $this->input->post('hddFinishDate'),
				'fk_id_fuel' => $this->input->post('fuel'),
				'clean' => $clean,
				'cleaning_date' => $cleaning_date,
				'next_cleaning_date' => $next_cleaning_date,
				'damage' => $damage,
				'damage_observation' => $damage_observation,
				'fk_id_type_contract' => $this->input->post('hddTypeContract'),
				'current_hours' => $this->input->post('hddCurrentHours'),
				'fk_id_user' => $this->input->post('hddResponsible'),
				'observations' => $this->input->post('hddObservations'),
				'date_issue' => date("Y-m-d H:i:s"),
			);
			if ($this->input->post('fuel') != $this->input->post('hddFuel') || $this->input->post('clean') != $this->input->post('hddClean') || $this->input->post('cleaning_date') != $this->input->post('hddCleaningDate') || $this->input->post('next_cleaning_date') != $this->input->post('hddNextCleaningDate') || $this->input->post('damage') != $this->input->post('hddDamage') || $this->input->post('damage_observation') != $this->input->post('hddDamageObservation')) {
				$this->saveRentStatusHistorical($arrHist);
				return $idRent;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * Save WO rent
	 * @since 1/04/2022
	 */
	public function saveWORent($arrParam)
	{
		$data = array(
			'fk_id_user' => $arrParam['fk_id_user'],
			'fk_id_rent' => $arrParam['fk_id_rent'],
			'date_issue' => $arrParam['date_issue'],
			'date' => date("Y-m-d"),
			'observation' => $arrParam['observation'],
			'status' => 0,
			'last_message' => $arrParam['observation']
		);
		$query = $this->db->insert('rme_workorder', $data);
		$idWO = $this->db->insert_id();
		if ($query) {
			$datos = array(
				'fk_id_workorder' => $idWO,
				'fk_id_user' => $arrParam['fk_id_user'],
				'date_issue' => $arrParam['date_issue'],
				'observation' => $arrParam['observation'],
				'status' => 0
			);
			$this->db->insert('rme_workorder_status', $datos);
		} else {
			return false;
		}
	}

	/**
	 * Update rent status vehicle
	 * @since 22/04/2022
	 */
	public function updateVehicle($id)
	{
		$data = array(
			'rent_status' => 1
		);
		$this->db->where('id_vehicle', $id);
		$query = $this->db->update('param_vehicle', $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Add fotos
	 * @since 14/12/2020
	 */
	public function add_photos($path) 
	{							
			$idUser = $this->session->userdata("idUser");

			$data = array(
				'fk_id_rent' => $this->input->post('hddId'),
				'fk_id_user' => $idUser,
				'fk_id_type' => $this->input->post('type'),
				'equipment_photo' => $path,
				'date' => date("Y-m-d"),
				'description' => 'Photo before rent',
			);			

			$query = $this->db->insert('rme_rent_photos', $data);

			if ($query) {
				return true;
			} else {
				return false;
			}
	}

	/**
	 * Save attachement
	 * @since 8/05/2022
	 */
	public function saveAttachement()
	{
		$data = array(
			'fk_id_rent' => $this->input->post('hddId'),
			'fk_id_user' => $this->session->userdata("idUser"),
			'fk_id_attachement' => $this->input->post('attachement'),
			'date' =>date("Y-m-d"),
			'attachement_description' => $this->input->post('attachement_description')
		);
		$query = $this->db->insert('rme_rent_attachements ', $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
}