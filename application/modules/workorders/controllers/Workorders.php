<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workorders extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("workorders_model");
        $this->load->model("general_model");
    }

	/**
	 * Lista de workorders
     * @since 1/5/2021
     * @author BMOTTAG
	 */
	public function index()
	{				
			$arrParam = array();
			$data['pageHeaderTitle'] = "Work Orders";
			$userRol = $this->session->userdata("rol");
			$idUser = $this->session->userdata("id");
			//If it is a BASIC ROLE OR SAFETY&MAINTENACE ROLE, just show the records of the user session
			if($userRol == 7 || $userRol == 4){ 
				$arrParam["idEmployee"] = $this->session->userdata("id");
			}
			$data['workOrderInfo'] = $this->general_model->get_workordes_by_idUser($arrParam);

			//delete records for button go back from the search form
			$arrParam = array(
				"table" => "workorder_go_back",
				"primaryKey" => "fk_id_user",
				"id" => $idUser
			);
			$this->general_model->deleteRecord($arrParam);

			$data["view"] ='workorder';
			$this->load->view("layout", $data);
	}

	/**
	 * Detalle catalogo sistema
     * @since 22/11/2021
     * @author BMOTTAG
	 */
	public function details($idWorkOrder)
	{
			if (empty($idWorkOrder) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}else{
				$data['WODetails'] = FALSE;
				$arrParam = array('idWorkOrder' =>$idWorkOrder);
				$data['infoWorkOrder'] = $this->general_model->get_workordes_by_idUser($arrParam);
				$arrParam = array('idRent' =>$data['infoWorkOrder'][0]["fk_id_rent"]);
				$data['infoRent'] = $this->general_model->get_rents($arrParam);

				if(!$data['infoWorkOrder']){
					show_error('ERROR!!! - You are in the wrong place.');
				}else{
					$arrParam = array('idWorkOrder' =>$idWorkOrder);
					$data['WODetails'] = $this->general_model->get_wo_details($arrParam);//invoice details
					$data['pageHeaderTitle'] = "Work Order - Details";

					$data["view"] = 'workorder_details';
					$this->load->view("layout", $data);
				}
			}
	}

    /**
     * Cargo modal- formulario para editar las horas de los empleados
     * @since 1/5/2022
     */
    public function cargarModalWorkorderService() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			$data['idWorkorder'] = $this->input->post('idWorkorder');;
			$this->load->view("modal_workorder_service", $data);
    }

	/**
	 * Save workorder services
     * @since 1/5/2022
     * @author BMOTTAG
	 */
	public function save_workorder_service()
	{			
			header('Content-Type: application/json');
			$data = array();
						
			$data["idRecord"] = $idWorkorder = $this->input->post('hddIdWorkorder');

			$msj = "A new Service was added!";
			if ($idWorkorder != '') {
				$msj = "A Service was updated!";
			}

			if ($idWorkorder = $this->workorders_model->saveWorkorderService()) {
				$data["result"] = true;		
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }

	/**
	 * Delete programming
     * @since 5/7/2021
	 */
	public function delete_invoice_service()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$arrParam = array('idInvoiceService' =>$this->input->post('identificador'));
			$data['invoiceDetails'] = $this->general_model->get_invoice_details($arrParam);//invoice details
			$data["idRecord"] = $data['invoiceDetails'][0]['fk_id_invoice'];

			if ($this->invoice_model->inactiveInvoiceService()) 
			{				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> The record was deleted!');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}				

			echo json_encode($data);
    }







	
}