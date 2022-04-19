<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("dashboard_model");
		$this->load->model("general_model");
    }
		
	/**
	 * ADMINISTRATO DASHBOARD
	 */
	public function super_admin()
	{
			$arrParam["limit"] = 30;//Limite de registros para la consulta
			$data['info'] = $this->general_model->get_rents($arrParam);//search the last 5 records
			$data['pageHeaderTitle'] = "Dashboard";
			//pr($data['info']);exit;

			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}

    /**
     * Rent modal 
     * @since 28/2/2022
     */
    public function cargarModalRent() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data['trucks']  = FALSE;
			$idRent = $this->input->post("idRent");

			if ($idRent != 'x') {
				$arrParam = array(
					"idRent" => $idRent
				);
				$data['information'] = $this->general_model->get_rents($arrParam);
				$company = 1;
				$type = $data['information'][0]["type_level_2"];
				$data['trucks'] = $this->dashboard_model->get_trucks_by_id2($company, $type);
			}

			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['clientList'] = $this->general_model->get_basic_search($arrParam);
			$data['equipmentList'] = $this->general_model->get_vehicles_to_rent($arrParam);

			$arrParam = array(
				"table" => "param_vehicle_type_2",
				"order" => "type_2",
				"column" => "show_workorder",
				"id" => 1
			);
			$data['equipmentType'] = $this->general_model->get_basic_search($arrParam);
			$data['contractType'] = $this->dashboard_model->get_type_contract();
			
			$this->load->view("rent_modal", $data);
    }

	/**
	 * Save Rent
     * @since 15/11/2021
     * @author BMOTTAG
	 */
	public function save_rent()
	{			
		header('Content-Type: application/json');
		$data = array();
		$idRent = $this->input->post('hddId');
		$msj = "Se adicionó con exito el nuevo registro!";
		if ($idRent != 'x') {
			$msj = "Se actualizó con exito el registro!";
		}
		if ($idRent = $this->dashboard_model->saveRent()) {
			$data["result"] = true;		
			$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
		} else {
			$data["result"] = "error";
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}
		echo json_encode($data);
    }

	/**
	 * Trucks list by company and type
     * @since 25/1/2017
     * @author BMOTTAG
	 */
    public function truckList() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $company = 1; //la empresa es VCI que el id es 1
		$type = $this->input->post('type');
		
		//si es igual a 8 es miscellaneous entonces la informacion la debe sacar de la tabla param_miscellaneous
		if($type == 8)
		{
			//miscellaneous list
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_miscellaneous",
				"order" => "miscellaneous",
				"id" => "x"
			);
			$lista = $this->general_model->get_basic_search($arrParam);//miscellaneous list

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["id_miscellaneous"] . "' >" . $fila["miscellaneous"] . "</option>";
				}
			}			
		} elseif($type == 9){
			$lista = $this->dashboard_model->get_trucks_by_id1();

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["id_truck"] . "' >" . $fila["unit_number"] . "</option>";
				}
			}
		} else{
			$lista = $this->dashboard_model->get_trucks_by_id2($company, $type);

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["id_truck"] . "' >" . $fila["unit_number"] . "</option>";
				}
			}
		}
    }
	
	/**
	 * Form rent details
     * @since 19/04/2022
     * @author BMOTTAG
	 */
	public function rent_details($id = 'x')
	{
		$arrParam["idRent"] = $id;
		$data['pageHeaderTitle'] = "Details";
		$data['info'] = $this->general_model->get_rents($arrParam);
		$data['status'] = $this->dashboard_model->get_status();
		$data['rentStatus'] = $this->dashboard_model->get_rent_status($arrParam);
		//pr($data['rentStatus']);exit;

		$data["view"] = 'form_details';
		$this->load->view("layout", $data);
	}

	/**
	 * Save rent status
     * @since 15/11/2021
     * @author BMOTTAG
	 */
	public function save_rent_status($id)
	{			
		header('Content-Type: application/json');
		$data = array();
		$idRent = $id;
		$arrParam = array(
			'fk_id_rent' => $idRent,
			'fk_id_user' => $this->session->userdata("idUser"),
			'date_issue' => date("Y-m-d H:i:s"),
			'observation' => $this->input->post('information'),
			'fk_id_status' => $this->input->post('status')
		);
		$msj = "Se actualizó con exito el registro!";
		if ($this->dashboard_model->saveRentStatus($arrParam)) {
			$data["result"] = true;		
			$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
		} else {
			$data["result"] = "error";
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}
		echo json_encode($data);
    }
}