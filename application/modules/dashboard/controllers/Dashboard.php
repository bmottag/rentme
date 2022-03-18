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
			$data["idRent"] = $this->input->post("idRent");	

			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['clientList'] = $this->general_model->get_basic_search($arrParam);
//pr($data['clientList']);
			$data['equipmentList'] = $this->general_model->get_vehicles_to_rent($arrParam);
//pr($data['equipmentList']); exit;
			if ($data["idRent"] != 'x') {
				$arrParam = array(
					"idRent" => $data["idRent"]
				);
				$data['information'] = $this->general_model->get_rents($arrParam);
			}		
			$this->load->view("rent_modal", $data);
    }

	/**
	 * Guardar datos Catalogo
     * @since 15/11/2021
     * @author BMOTTAG
	 */
	public function save_catalogo()
	{			
			header('Content-Type: application/json');
			$data = array();
		
			$idCatalogo = $this->input->post('hddId');
			
			$msj = "Se adicionó con exito el nuevo registro!";
			if ($idCatalogo != '') {
				$msj = "Se actualizó con exito el registro!";
			}

			if ($idCatalogo = $this->control_model->saveCatalogo()) {
				$data["result"] = true;		
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	
}