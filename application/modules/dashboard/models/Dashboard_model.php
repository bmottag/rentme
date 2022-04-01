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
	 * Add/Edit ENLACE
	 * @since 2/4/2018
	 */
	public function saveRent() 
	{
		$idRent = $this->input->post('hddId');
		
		$data = array(
			'fk_id_client' => $this->input->post('id_client'),
			'fk_id_equipment' => $this->input->post('truck'),
			'start_date' => $this->input->post('start_date'),
			'finish_date' => $this->input->post('finish_date'),
			'fuel' => $this->input->post('fuel'),
			'clean' => $this->input->post('clean'),
			'damage' => $this->input->post('damage'),
			'type_contract' => $this->input->post('type_contract'),
			'maintenance' => $this->input->post('maintenance'),
			'observations' => $this->input->post('observations'),
			'rent_status' => 1,
		);
		
		//revisar si es para adicionar o editar
		if ($idRent == '') {
			$query = $this->db->insert('rme_rent', $data);			
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

}