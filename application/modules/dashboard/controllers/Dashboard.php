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
				"table" => "rme_param_client",
				"order" => "param_client_name",
				"column" => "param_client_type",
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

		$arrParam = array(
			"table" => "rme_param",
			"order" => "param_value",
			"column" => "param_code",
			"id" => ID_PARAM_TYPE_PHOTO
		);
		$data['photosType'] = $this->general_model->get_basic_search($arrParam);
		$data['rentStatus'] = $this->dashboard_model->get_rent_status($arrParam);
		$data['rentPhotos'] = $this->general_model->get_photos_rent($arrParam);
		$data['rentAttachement'] = $this->general_model->get_attachements_rent($arrParam);

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

    /**
	 * Alert maintenance
     * @since 19/04/2022
     * @author BMOTTAG
	 */
	public function alert_maintenance()
	{
		header('Content-Type: application/json');
		$data = array();
		$nextChange = $this->dashboard_model->get_truck_by_id($this->input->post('truck'));
		$hoursContract = $this->dashboard_model->get_hours_contract($this->input->post('type_contract'));
		$currentHours = $this->input->post('current_hours');

		if ($currentHours + $hoursContract['hours_type_contract'] >= $nextChange['oil_change']) {
			$data["result"] = true;
			$data["bandera"] = true;
			$data["msj2"] = "The next maintenance will be at <b>" . $nextChange['oil_change'] . " hours/km</b>. It's expired or about to expire.";
		} else {
			$data["result"] = true;
			$data["bandera"] = false;
		}
		echo json_encode($data);
    }

    /**
	 * Alert rent vehicle
     * @since 25/04/2022
     * @author BMOTTAG
	 */
	public function alert_rentVehicle()
	{
		header('Content-Type: application/json');
		$data = array();
		$rentVehicle = $this->dashboard_model->get_truck_by_id($this->input->post('truck'));

		if ($rentVehicle['rent_status'] == 1) {
			$fecha = $this->dashboard_model->get_rent_by_truck($this->input->post('truck'));
			$data["result"] = true;
			$data["bandera"] = true;
			$data["msj"] = "This equipment has a scheduled rental date. This equipment is available after <b>" . $fecha['finish_date'] . "</b>.";
		} else {
			$data["result"] = true;
			$data["bandera"] = false;
		}
		echo json_encode($data);
    }

	/**
	 * Subir Foto del equipo
	 * @since 12/12/2020
     * @author BMOTTAG
	 */
    function do_upload_photos() 
	{
		$config['upload_path'] = './images/rent/';
        $config['overwrite'] = false;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '3200';
        $config['max_height'] = '2400';
		$idRent = $this->input->post('hddId');

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            pr($error); exit;
			$this->foto($idEquipo, $error);
        } else {
            $file_info = $this->upload->data();//subimos la imagen
			
			$data = array('upload_data' => $this->upload->data());
			$imagen = $file_info['file_name'];
			$path = "images/rent/" . $imagen;
			
			//insertar datos
			if($this->dashboard_model->add_photos($path))
			{
				$this->session->set_flashdata('retornoExito', 'Equipment photo uploaded.');
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
						
			redirect('dashboard/rent_details/' . $idRent);
        }
    }

	/**
	 * Save attachement
     * @since 8/5/2022
     * @author BMOTTAG
	 */
	public function save_attachement()
	{			
		header('Content-Type: application/json');
		$data = array();
		$msj = "The attachement was added!";
		if ($this->dashboard_model->saveAttachement()) {
			$data["result"] = true;		
			$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
		} else {
			$data["result"] = "error";
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}
		echo json_encode($data);
    }


}