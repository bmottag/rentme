<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class External extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("external_model");
        $this->load->model("general_model");
		$this->load->helper('form');
    }

	/**
	 * Send SMS to client
     * @since 8/5/2022
     * @author BMOTTAG
	 */
	public function sendSMSClient($idRent)
	{	
		$this->send_emailClient($idRent);
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
		$information = $this->general_model->get_rents($arrParam);//search the last 5 records

		$mensaje = "";
		$mensaje .= "RentMeAll";
		$mensaje .= "\nFollow the link, review the rent information and sign.";
		$mensaje .= "\n";
		$mensaje .= "\n";
		$mensaje .= base_url("external/review_rent/" . $idRent);

		$to = '+1' . $information[0]['param_client_movil'];	
		$client->messages->create(
			$to,
			array(
				'from' => $phone,
				'body' => $mensaje
			)
		);

		$data['linkBack'] = "jobs/review_excavation/" . $idRent;
		$data['titulo'] = "<i class='fa fa-pied-piper-alt'></i>Rent Information - SMS";
		
		$data['clase'] = "alert-info";
		$data['msj'] = "You have send the SMS to the client";

		$data["view"] = 'template/answer';
		$this->load->view("layout", $data);
	}

	/**
	 * Form rent details
     * @since 19/04/2022
     * @author BMOTTAG
	 */
	public function review_rent($idRent)
	{
		$arrParam["idRent"] = $idRent;
		$data['pageHeaderTitle'] = "RENT INFORMATION";
		$data['info'] = $this->general_model->get_rents($arrParam);
		$data['rentPhotos'] = $this->general_model->get_photos_rent($arrParam);
		$data['rentAttachement'] = $this->general_model->get_attachements_rent($arrParam);
		$data["view"] = 'rent_details';
		$this->load->view("layout", $data);
	}

	/**
	 * Signature
	 * param $typo: supervisor / worker
	 * param $idExcavation: llave principal del formulario
	 * param $idWorker: llave principal del trabajador
     * @since 14/8/2021
     * @author BMOTTAG
	 */
	public function add_client_signature($typo, $idRent, $idWorker = 'x')
	{
		if (empty($idRent)) {
			show_error('ERROR!!! - You are in the wrong place.');
		}
	
		if($_POST){
			
			$data['linkBack'] = 'jobs/review_excavation/' . $idRent;
			$data['titulo'] = "<i class='fa fa-life-saver fa-fw'></i>SIGNATURE";
			$msj = "Good job, you have save your signature.";	

			$name = "images/signature/rent/client_" . $idRent . ".png";
			
			$arrParam = array(
				"table" => "rme_rent",
				"primaryKey" => "id_rent",
				"id" => $idRent,
				"column" => "client_signature",
				"value" => $name
			);

			$data_uri = $this->input->post("image");
			$encoded_image = explode(",", $data_uri)[1];
			$decoded_image = base64_decode($encoded_image);
			file_put_contents($name, $decoded_image);
			
			if ($this->general_model->updateRecord($arrParam)) {
				//$this->session->set_flashdata('retornoExito', 'You just save your signature!!!');
				
				$data['clase'] = "alert-success";
				$data['msj'] = $msj;	
			} else {
				//$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				
				$data['clase'] = "alert-danger";
				$data['msj'] = "Ask for help.";
			}
			
			$data["view"] = 'template/answer';
			$this->load->view("layout", $data);
		}else{			
			$this->load->view('template/make_signature');
		}
	}

	/**
	 * Send email client
     * @since 23/05/2022
     * @author BMOTTAG
	 */
	public function send_emailClient($id)
	{
		$arrParam = array(
			"idRent" => $id
		);
		$info = $this->general_model->get_rents($arrParam);

		$subjet = "Rentme All";
		$user = $info[0]['param_client_contact'];
		$to = $info[0]['param_client_email'];
		$client = $info[0]['param_client_name'];
		$type = $info[0]['type_2'];
		$equipment = $info[0]['unit_number'] .' -----> '. $info[0]['description'];
		$current_hours = $info[0]['current_hours'];
		if ($info[0]['fk_id_fuel'] != '') {
			$current_fuel = $info[0]['param_description'];
		} else {
			$current_fuel = '';
		}
		if ($info[0]['clean'] == 1) {
			$clean = 'Clean';
		} else if ($info[0]['clean'] == 2) {
			$clean = 'To be clean';
		} else {
			$clean = '';
		}
		$type_rent = $info[0]['name_type_contract'];
		$status = $info[0]['name_status'];
		$start_date = $info[0]['start_date'];
		$finish_date = $info[0]['finish_date'];
		if ($info[0]['damage'] == 1) {
			$damage = 'Yes';
			$damage_observation = $info[0]['damage_observation'];
		} else if ($info[0]['damage'] == 2) {
			$damage = 'No';
			$damage_observation = '';
		} else {
			$damage = '';
			$damage_observation = '';
		}
		$observations = $info[0]['observations'];

		$mensaje = "<html>
		<head>
		  <title> $subjet </title>
		</head>
		<body>
			<p>Dear	$user:</p>
			<p>RENT INFORMATION</p>
			<p>Rent: $id</p>
			<p>Client: $client</p>
			<p>Type of equipment: $type</p>
			<p>Equipment: $equipment</p>
			<p>Current unit hours: $current_hours</p>
			<p>Current Fuel: $current_fuel</p>
			<p>Current equipment condition: $clean</p>
			<p>Type of rent: $type_rent</p>
			<p>Actual status: $status</p>
			<p>From: $start_date - Until: $finish_date</p>
			<p>Does the unit has any damage?: $damage</p>
			<p>Damage observation: $damage_observation</p>
			<p>Observations: $observations</p>
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
	 * Save form signature
     * @since 25/05/2022
     * @author BMOTTAG
	 */
	public function save_form_signature()
	{
		header('Content-Type: application/json');
		$data = array();
		$signature = $this->input->post('hddSignature');
		$msj = "form signed correctly!";
		if (!empty($signature)) {
			if ($this->external_model->save_formSignature()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
		} else {
			$data["result"] = "false";
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> You must sign the form.');
		}
		echo json_encode($data);
    }
	
}