<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Clase para consultas generales a una tabla
 */
class General_model extends CI_Model {

    /**
     * Consulta BASICA A UNA TABLA
     * @param $TABLA: nombre de la tabla
     * @param $ORDEN: orden por el que se quiere organizar los datos
     * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro (NO ES OBLIGATORIO)
     * @param $VALOR: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
     * @since 8/11/2016
     */
    public function get_basic_search($arrData) {
        if ($arrData["id"] != 'x')
            $this->db->where($arrData["column"], $arrData["id"]);
        $this->db->order_by($arrData["order"], "ASC");
        $query = $this->db->get($arrData["table"]);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }
	
	/**
	 * Delete Record
	 * @since 25/5/2017
	 */
	public function deleteRecord($arrDatos) 
	{
			$query = $this->db->delete($arrDatos ["table"], array($arrDatos ["primaryKey"] => $arrDatos ["id"]));
			if ($query) {
				return true;
			} else {
				return false;
			}
	}
	
	/**
	 * Update field in a table
	 * @since 11/12/2016
	 */
	public function updateRecord($arrDatos) {
		$data = array(
			$arrDatos ["column"] => $arrDatos ["value"]
		);
		$this->db->where($arrDatos ["primaryKey"], $arrDatos ["id"]);
		$query = $this->db->update($arrDatos ["table"], $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Lista de menu
	 * Modules: MENU
	 * @since 30/3/2020
	 */
	public function get_menu($arrData) 
	{		
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("menuStatus", $arrData)) {
			$this->db->where('menu_status', $arrData["menuStatus"]);
		}
		if (array_key_exists("columnOrder", $arrData)) {
			$this->db->order_by($arrData["columnOrder"], 'asc');
		}else{
			$this->db->order_by('menu_type, menu_order', 'asc');
		}
		
		$query = $this->db->get('rme_param_menu');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}	

	/**
	 * Lista de roles
	 * Modules: ROL
	 * @since 30/3/2020
	 */
	public function get_roles($arrData) 
	{		
		if (array_key_exists("filtro", $arrData)) {
			$this->db->where('id_role !=', 99);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('id_role', $arrData["idRole"]);
		}
		
		$this->db->order_by('role_name', 'asc');
		$query = $this->db->get('rme_param_role');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * User list
	 * @since 30/3/2020
	 */
	public function get_user($arrData) 
	{			
		$this->db->select();
		$this->db->join('rme_param_role R', 'R.id_role = U.fk_id_user_role', 'INNER');
		if (array_key_exists("status", $arrData)) {
			$this->db->where('U.status', $arrData["status"]);
		}
		
		//list without inactive users
		if (array_key_exists("filtroStatus", $arrData)) {
			$this->db->where('U.status !=', 2);
		}
		
		if (array_key_exists("idUser", $arrData)) {
			$this->db->where('U.id_user', $arrData["idUser"]);
		}
		if (array_key_exists("idCompany", $arrData)) {
			$this->db->where('U.fk_id_app_company_u', $arrData["idCompany"]);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('U.fk_id_user_role', $arrData["idRole"]);
		}

		$this->db->order_by("first_name, last_name", "ASC");
		$query = $this->db->get("user U");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		} else
			return false;
	}
	
	/**
	 * Lista de enlaces
	 * Modules: MENU
	 * @since 31/3/2020
	 */
	public function get_links($arrData) 
	{		
		$this->db->select();
		$this->db->join('rme_param_menu M', 'M.id_menu = L.fk_id_menu', 'INNER');
		
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('fk_id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("idLink", $arrData)) {
			$this->db->where('id_link', $arrData["idLink"]);
		}
		if (array_key_exists("linkType", $arrData)) {
			$this->db->where('link_type', $arrData["linkType"]);
		}			
		if (array_key_exists("linkStatus", $arrData)) {
			$this->db->where('link_status', $arrData["linkStatus"]);
		}
		
		$this->db->order_by('M.menu_order, L.order', 'asc');
		$query = $this->db->get('rme_param_menu_links L');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * Lista de permisos
	 * Modules: MENU
	 * @since 31/3/2020
	 */
	public function get_role_access($arrData) 
	{		
		$this->db->select('P.id_access, P.fk_id_menu, P.fk_id_link, P.fk_id_role, M.menu_name, M.menu_order, M.menu_type, L.link_name, L.link_url, L.order, L.link_icon, L.link_type, R.role_name, R.style');
		$this->db->join('rme_param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');
		$this->db->join('rme_param_menu_links L', 'L.id_link = P.fk_id_link', 'LEFT');
		$this->db->join('rme_param_role R', 'R.id_role = P.fk_id_role', 'INNER');
		
		if (array_key_exists("idPermiso", $arrData)) {
			$this->db->where('id_access', $arrData["idPermiso"]);
		}
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('P.fk_id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("idLink", $arrData)) {
			$this->db->where('P.fk_id_link', $arrData["idLink"]);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('P.fk_id_role', $arrData["idRole"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('M.menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("linkStatus", $arrData)) {
			$this->db->where('L.link_status', $arrData["linkStatus"]);
		}
		if (array_key_exists("menuURL", $arrData)) {
			$this->db->where('M.menu_url', $arrData["menuURL"]);
		}
		if (array_key_exists("linkURL", $arrData)) {
			$this->db->where('L.link_url', $arrData["linkURL"]);
		}		
		
		$this->db->order_by('R.id_role, M.menu_order, L.order', 'asc');
		$query = $this->db->get('rme_param_menu_access P');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * menu list for a role
	 * Modules: MENU
	 * @since 2/4/2020
	 */
	public function get_role_menu($arrData) 
	{		
		$this->db->select('distinct(fk_id_menu), menu_url,menu_icon,menu_name,menu_order');
		$this->db->join('rme_param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');

		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('P.fk_id_role', $arrData["idRole"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('M.menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("menuStatus", $arrData)) {
			$this->db->where('M.menu_status', $arrData["menuStatus"]);
		}
					
		//$this->db->group_by("P.fk_id_menu"); 
		$this->db->order_by('M.menu_order', 'asc');
		$query = $this->db->get('rme_param_menu_access P');

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
	public function get_rents($arrData) 
	{
		$this->db->select();
		$this->db->join('param_vehicle V', 'V.id_vehicle = R.fk_id_equipment', 'INNER');
		$this->db->join('rme_param_client C', 'C.id_param_client = R.fk_id_client', 'INNER');
		$this->db->join('param_vehicle_type_2 V2', 'V2.id_type_2 = V.type_level_2', 'INNER');
		$this->db->join('rme_param_status S', 'S.id_status = R.fk_id_status', 'INNER');
		$this->db->join('rme_param_type_contract T', 'T.id_type_contract = R.fk_id_type_contract', 'INNER');

		if (array_key_exists("idRent", $arrData)) {
			$this->db->where('id_rent', $arrData["idRent"]);
		}
		if (array_key_exists("idEquipment", $arrData)) {
			$this->db->where('fk_id_equipment', $arrData["idEquipment"]);
		}
		if (array_key_exists("idClient", $arrData)) {
			$this->db->where('fk_id_client', $arrData["idClient"]);
		}
		
		$this->db->order_by('id_rent', 'desc');
		$query = $this->db->get('rme_rent R');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Lista de vehiculos, para rentar
	 * @since 28/2/2022
	 */
	public function get_vehicles_to_rent()
	{
			$trucks = array();
			$sql = "SELECT id_vehicle, CONCAT(unit_number,' -----> ', description) as unit_description 
					FROM param_vehicle V 
					INNER JOIN param_vehicle_type_2 T ON T.id_type_2 = V.type_level_2 
					WHERE fk_id_company = 1 AND T.link_inspection != 'NA' AND V.id_vehicle NOT IN(41,42,43,44,61,62) AND V.state = 1
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
	 * Client list
	 * @since 12/6/2020
	 */
	public function get_param_clients($arrData) 
	{			
		$this->db->select();
		if (array_key_exists("status", $arrData)) {
			$this->db->where('C.param_client_status', $arrData["status"]);
		}
		if (array_key_exists("idParamClient", $arrData)) {
			$this->db->where('C.id_param_client', $arrData["idParamClient"]);
		}
		$this->db->order_by("param_client_name", "ASC");
		$query = $this->db->get("rme_param_client C");

		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}else{
			return false;
		}
	}

	/**
	 * Workorders´s list
	 * las 10 records
	 * @since 12/1/2017
	 */
	public function get_workordes_by_idUser($arrDatos) 
	{							
			$this->db->select('W.*, C.param_client_name, C.param_client_address, C.param_client_contact, C.param_client_movil, C.param_client_email, CONCAT(U.first_name, " ", U.last_name) name');
			$this->db->join('rme_rent R', 'R.id_rent = W.fk_id_rent', 'INNER');
			$this->db->join('user U', 'U.id_user = W.fk_id_user', 'INNER');
			$this->db->join('rme_param_client C', 'C.id_param_client = R.fk_id_client', 'INNER');

			if (array_key_exists("idWorkOrder", $arrDatos)) {
				$this->db->where('id_workorder', $arrDatos["idWorkOrder"]);
			}
			if (array_key_exists("idEmployee", $arrDatos)) {
				$this->db->where('fk_id_user', $arrDatos["idEmployee"]);
			}
			$this->db->order_by('id_workorder', 'desc');
			$query = $this->db->get('rme_workorder W', 50);

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
	}

	/**
	 * WO details
	 * @since 1/6/2022
	 */
	public function get_wo_details($arrData) 
	{			
			$this->db->select();
			if (array_key_exists("idWorkOrder", $arrData)) {
				$this->db->where('D.id_wo_detail', $arrData["idWorkOrder"]);
			}
			$this->db->order_by("id_wo_detail", "asc");
			$query = $this->db->get("rme_workorder_details D");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			}else{
				return false;
			}
	}

	/**
	 * Photos list
	 * @since 7/5/2022
	 */
	public function get_photos_rent($arrData) 
	{
		$this->db->select('P.*,  CONCAT(U.first_name, " ", U.last_name) name, R.param_description type');
		$this->db->join('user U', 'P.fk_id_user = U.id_user', 'INNER');
		$this->db->join('rme_param R', 'R.param_value = P.fk_id_type', 'INNER');
		$this->db->where('R.param_code', ID_PARAM_TYPE_PHOTO);

		if (array_key_exists("idRent", $arrData)) {
			$this->db->where('fk_id_rent', $arrData["idRent"]);
		}
				
		$this->db->order_by('id_photo', 'asc');
		$query = $this->db->get('rme_rent_photos  P');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Attachements list
	 * @since 8/5/2022
	 */
	public function get_attachements_rent($arrData) 
	{
		$this->db->select('A.*,  CONCAT(U.first_name, " ", U.last_name) name, R.param_description type');
		$this->db->join('user U', 'A.fk_id_user = U.id_user', 'INNER');
		$this->db->join('rme_param R', 'R.param_value = A.fk_id_attachement', 'INNER');
		$this->db->where('R.param_code', ID_PARAM_TYPE_PHOTO);

		if (array_key_exists("idRent", $arrData)) {
			$this->db->where('fk_id_rent', $arrData["idRent"]);
		}
				
		$this->db->order_by('id_attachement', 'asc');
		$query = $this->db->get('rme_rent_attachements A');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

}