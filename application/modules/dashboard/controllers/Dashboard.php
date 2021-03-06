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
			$arrParam["limit"] = 30; //Limite de registros para la consulta
			$data['info'] = $this->general_model->get_rents($arrParam); //search the last 5 records
			$data['pageHeaderTitle'] = "Dashboard";
			$data['fechaActual'] = date("Y-m-d");
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
			$data['idRent'] = $this->input->post("idRent");
			if ($data['idRent'] != 'x') {
				$arrParam = array(
					"idRent" => $data['idRent']
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
			$data['equipmentList'] = $this->general_model->get_vehicles_to_rent();
			$arrParam = array(
				"table" => "param_vehicle_type_2",
				"order" => "type_2",
				"column" => "show_workorder",
				"id" => 1
			);
			$data['equipmentType'] = $this->general_model->get_basic_search($arrParam);
			$arrParam = array(
				"table" => "rme_param",
				"order" => "param_value",
				"column" => "param_code",
				"id" => ID_PARAM_CURRENT_FUEL
			);
			$data['currentFuelList'] = $this->general_model->get_basic_search($arrParam);
			$data['contractType'] = $this->dashboard_model->get_type_contract();
			$data['usersList'] = $this->dashboard_model->get_list_users();
			
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
		$msj = "The new record was added successfully!";
		if ($idRent != 'x') {
			$msj = "The registry was updated successfully!";
		}
		if ($idRentNew = $this->dashboard_model->saveRent()) {
			if ($idRent != 'x' && $this->input->post('clean') == 2) {
				//$this->send_email($idRentNew);
			}
			if ($idRent == 'x') {
				//$this->sendSMSResponsible($idRentNew);
			}
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
		$data['rentHistorical'] = $this->dashboard_model->get_statusHistorical($id);
		$data['status'] = $this->dashboard_model->get_status();
		$arrParamPhoto = array(
			"table" => "rme_param",
			"order" => "param_value",
			"column" => "param_code",
			"id" => ID_PARAM_TYPE_PHOTO
		);
		$data['photosType'] = $this->general_model->get_basic_search($arrParamPhoto);
		$arrParamAttachement = array(
			"table" => "rme_param",
			"order" => "param_value",
			"column" => "param_code",
			"id" => ID_PARAM_ATTACHEMENTS
		);
		$data['attachementList'] = $this->general_model->get_basic_search($arrParamAttachement);
		$data['rentStatus'] = $this->dashboard_model->get_rent_status($arrParam);
		$data['rentPhotos'] = $this->general_model->get_photos_rent($arrParam);
		$data['rentAttachement'] = $this->general_model->get_attachements_rent($arrParam);
		//pr($data['info']); exit;

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
		$msj = "The registry was updated successfully!";
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
     * Current condition modal 
     * @since 15/05/2022
     */
    public function cargarModalCondition()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$idRent = $this->input->post("idRent");
			$arrParam = array(
				"idRent" => $idRent
			);
			$data['info'] = $this->general_model->get_rents($arrParam);
			$arrParam = array(
				"table" => "rme_param",
				"order" => "param_value",
				"column" => "param_code",
				"id" => ID_PARAM_CURRENT_FUEL
			);
			$data['currentFuelList'] = $this->general_model->get_basic_search($arrParam);

			$this->load->view("condition_modal", $data);
    }

    /**
	 * Update condition rent
     * @since 15/05/2022
     * @author BMOTTAG
	 */
	public function update_currentCondition()
	{			
		header('Content-Type: application/json');
		$data = array();
		$msj = "The registry was updated successfully!";
		if ($this->dashboard_model->saveCurrentCondition()) {
			$data["result"] = true;		
			$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
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
		$idRent = $this->input->post('hddId');
		if ($idRent != 'x'){
			$nextChange = $this->dashboard_model->get_truck_by_id($this->input->post('hddTruck'));
		} else {
			$nextChange = $this->dashboard_model->get_truck_by_id($this->input->post('truck'));
		}
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
		$data["result"] = true;
		$data["bandera"] = false;
		if ($rentVehicle['rent_status'] == 1) {
			$fechas = $this->dashboard_model->get_rent_by_truck($this->input->post('truck'));
			if($fechas){
				$data["bandera"] = true;
				$data["msj"] = "This equipment has scheduled rental dates.";

					foreach ($fechas as $lista):
						$data["msj"] .= "<br>From: <b>" . $lista['start_date'] . "</b>. Until: <b>" . $lista['finish_date'] . "</b>. Client: <b>" . $lista['param_client_name'] . "</b>.";
					endforeach;
			}
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

    /**
	 * Send email
     * @since 9/5/2022
     * @author BMOTTAG
	 */
	public function send_email($id)
	{
		$arrParam = array(
			"idRent" => $id
		);
		$info = $this->general_model->get_rents($arrParam);
		
		$subjet = "Rentme All - Cleaning Machine";
		$user = $info[0]['param_client_contact'];
		$to = $info[0]['param_client_email'];
		$fecha = $info[0]['next_cleaning_date'];
		$equipment = $info[0]['unit_number'] .' -----> '. $info[0]['description'];
		$client = $info[0]['param_client_name'];
		$start_date = $info[0]['start_date'];
		$finish_date = $info[0]['finish_date'];

		$mensaje = "<html>
		<head>
		  <title> $subjet </title>
		</head>
		<body>
			<p>Dear	$user:</p>
			<p>Please clean the machine by this date: $fecha</p>
			<p>Equipment: $equipment</p>
			<p>Client: $client</p>
			<p>From: $start_date - Until: $finish_date</p>
			<p>Cordially,</p>
			<p><strong>RENTME ALL</strong></p>
		</body>
		</html>";

		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'To: ' . $user . '<' . $to . '>' . "\r\n";
		$cabeceras .= 'From: RENTME ALL <info@v-contracting.ca>' . "\r\n";

		//enviar correo
		//mail($to, $subjet, $mensaje, $cabeceras);
		return true;
    }

    /**
	 * Send SMS to responsible
     * @since 14/05/2022
     * @author BMOTTAG
	 */
	public function sendSMSResponsible($idRent)
	{			
		$this->load->library('encrypt');
		require 'vendor/Twilio/autoload.php';

		//busco datos parametricos twilio
		$arrParam = array(
			"table" => "parametric",
			"order" => "id_parametric",
			"id" => "x"
		);
		$parametric = $this->general_model->get_basic_search($arrParam);						
		$dato1 = $this->encrypt->decode($parametric[3]["value"]);
		$dato2 = $this->encrypt->decode($parametric[4]["value"]);
		$phone = $parametric[5]["value"];
		
        $client = new Twilio\Rest\Client($dato1, $dato2);														
		$arrParam = array('idRent' => $idRent);
		$information = $this->general_model->get_rents($arrParam); //search the last 5 records

		$mensaje = "";
		$mensaje .= "RentMe All - New Rent";
		$mensaje .= "\n" . $information[0]['first_name'] ." ". $information[0]['last_name'];
		$mensaje .= "\nThere is a new rent, please check the equipment and fill the current equipment condition information on the system.";
		$mensaje .= "\nEquipment: ". $information[0]['unit_number'] ."----->". $information[0]['description'] .".";
		$mensaje .= "\nType: ". $information[0]['type_2'] .".";
		$mensaje .= "\nRent No. ". $information[0]['id_rent'];

		$to = '+57' . $information[0]['movil'];	
		$client->messages->create(
			$to,
			array(
				'from' => $phone,
				'body' => $mensaje
			)
		);
		return true;
	}

}