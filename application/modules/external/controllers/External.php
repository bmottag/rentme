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
		//pr($data['info']); exit;
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
				redirect(base_url("external/review_rent/" . $idRent));
			} else {
				//$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				
				$data['clase'] = "alert-danger";
				$data['msj'] = "Ask for help.";
			}
			$data["view"] = 'template/answer';
			$this->load->view("layout", $data);
		} else {
			$data["idRent"] = $idRent;
			$this->load->view('template/make_signature', $data);
		}
	}

	/**
<<<<<<< HEAD
	 * Form task control
     * @since 7/4/2020
     * @author BMOTTAG
	 */
	public function add_task_control($idJob, $idTaskControl = 'x')
	{
			$data['information'] = FALSE;
			
			//job info
			$arrParam = array(
				"table" => "param_jobs",
				"order" => "job_description",
				"column" => "id_job",
				"id" => $idJob
			);
			$data['jobInfo'] = $this->general_model->get_basic_search($arrParam);
			
			//company list
			$arrParam = array(
				"table" => "param_company",
				"order" => "company_name",
				"column" => "company_type",
				"id" => 2
			);
			$data['companyList'] = $this->general_model->get_basic_search($arrParam);//company list
			
			//si envio el id, entonces busco la informacion 
			if ($idTaskControl != 'x') {
				
				$arrParam = array("idTaskControl" => $idTaskControl);				
				$data['information'] = $this->external_model->get_task_control($arrParam);
				
				if (!$data['information']) { 
					show_error('ERROR!!! - You are in the wrong place.');	
				}
			}			

			$data["view"] = 'form_task_control';
			$this->load->view("layout", $data);
	}
	
	/**
	 * save _task_control
     * @since 7/4/2020
     * @author BMOTTAG
	 */
	public function save_task_control()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idRecord"] = $this->input->post('hddIdJob');

			if ($idTaskControl = $this->external_model->add_task_control()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "You have save the Task Assessment and Control, don't forget to sign..";
				$data["idTaskControl"] = $idTaskControl;
				$this->session->set_flashdata('retornoExito', "You have save the Task Assessment and Control, don't forget to sign.!!");
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$data["idTaskControl"] = "";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }
	
	/**
	 * Signature
	 * param $typo: supervisor / Superintendent
	 * param $idTaskControl: llave principal del formulario
	 * param $idJob: llave principal de trabajo
     * @since 8/4/2020
     * @author BMOTTAG
	 */
	public function add_signature_tac($typo, $idJob, $idTaskControl)
	{
			if (empty($typo) || empty($idJob) || empty($idTaskControl) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			if($_POST){
				
				//update signature with the name of the file
				$name = "images/signature/tac/" . $typo . "_" . $idTaskControl . ".png";
				
				$arrParam = array(
					"table" => "job_task_control",
					"primaryKey" => "id_job_task_control",
					"id" => $idTaskControl,
					"column" => $typo . "_signature",
					"value" => $name
				);
				//enlace para regresar al formulario
				$data['linkBack'] = "external/add_task_control/" . $idJob . "/" . $idTaskControl;
				
				$data_uri = $this->input->post("image");
				$encoded_image = explode(",", $data_uri)[1];
				$decoded_image = base64_decode($encoded_image);
				file_put_contents($name, $decoded_image);
				
				$data['titulo'] = "<i class='fa fa-life-saver fa-fw'></i> SIGNATURE";
				if ($this->general_model->updateRecord($arrParam)) {
					//$this->session->set_flashdata('retornoExito', 'You just save your signature!!!');
					
					$data['clase'] = "alert-success";
					$data['msj'] = "Good job, you have save your signature.";
				} else {
					//$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
					
					$data['clase'] = "alert-danger";
					$data['msj'] = "Ask for help.";
				}
				
				$data["view"] = 'template/answer';
				$this->load->view("layout", $data);

				//redirect("/safety/add_safety/" . $idSafety,'refresh');
			}else{			
				$this->load->view('template/make_signature');
			}
	}
	
	/**
	 * Envio de mensaje
     * @since 26/11/2020
     * @author BMOTTAG
	 */
	public function sendSMSWorker($idJob, $idTaskControl)
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
		
        $client = new Twilio\Rest\Client($dato1, $dato2);

		//task control info
		$arrParam = array("idTaskControl" => $idTaskControl);				
		$data['information'] = $this->external_model->get_task_control($arrParam);
		
		//job info
		$arrParam = array(
			"table" => "param_jobs",
			"order" => "job_description",
			"column" => "id_job",
			"id" => $idJob
		);
		$jobInfo = $this->general_model->get_basic_search($arrParam);
		
		$mensaje = "";
		
		//$mensaje .= date('F j, Y', strtotime($data['JSOInfo'][0]['date_issue_jso']));
		$mensaje .= "\n" . $jobInfo[0]['job_description'];
		$mensaje .= "\n";
		$mensaje .= "Click the following link to fill the COVID FORM.";
		$mensaje .= "\n";
		$mensaje .= "\n";
		$mensaje .= base_url("external/add_task_control/" . $idJob . "/" . $idTaskControl);

		$to = '+1' . $data['information'][0]['contact_phone_number'];
	
		// Use the client to do fun stuff like send text messages!
		$client->messages->create(
		// the number you'd like to send the message to
			$to,
			array(
				// A Twilio phone number you purchased at twilio.com/console
				'from' => '587 600 8948',
				'body' => $mensaje
			)
		);

		$data['linkBack'] = "more/task_control/" . $idJob;
		$data['titulo'] = "<i class='fa fa-list'></i> COVID-19";
		
		$data['clase'] = "alert-info";
		$data['msj'] = "We have send the SMS to the Worker to fill the COVID form.";

		$data["view"] = 'template/answer';
		$this->load->view("layout", $data);


	}
	
	/**
	 * Envio de mensaje para firmar FLHA
     * @since 14/4/2021
     * @author BMOTTAG
	 */
	public function sendSMSFLHAWorker($idSafety, $idSafetySubcontractor = 'x')
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
		
		
        $client = new Twilio\Rest\Client($dato1, $dato2);
		
		$data['informationWorker'] = FALSE;
		$data['idSafety'] = $idSafety;
														
		$arrParam = array(
			'idSafety' => $idSafety,
			'movilNumber' => true,
			'idSafetySubcontractor' => $idSafetySubcontractor
		);
		$data['infoSafety'] = $this->general_model->get_safety($arrParam);

		//lista de subcontratistas para este FLHA
		$data['informationWorker'] = $this->general_model->get_safety_subcontractors_workers($arrParam);//info safety workers

		$mensaje = "";
		$mensaje .= "VCI FLHA - " . date('F j, Y', strtotime($data['infoSafety'][0]['date']));
		$mensaje .= "\n" . $data['infoSafety'][0]['job_description'];
		$mensaje .= "\nFollow the link, read the FLHA and sign.";
		$mensaje .= "\n";
		$mensaje .= "\n";
		$mensaje .= base_url("safety/review_flha/" . $idSafety);

		if($data['informationWorker']){
			foreach ($data['informationWorker'] as $data):
				$to = '+1' . $data['worker_movil_number'];		
				$client->messages->create(
					$to,
					array(
						'from' => '587 600 8948',
						'body' => $mensaje
					)
				);
			endforeach;
		}
		$data['linkBack'] = "safety/review_flha/" . $idSafety;
		$data['titulo'] = "<i class='fa fa-list'></i>FLHA - SMS";
		
		$data['clase'] = "alert-info";
		$data['msj'] = "You have send the SMS to Subcontractors";

		$data["view"] = 'template/answer';
		$this->load->view("layout", $data);
	}



	/**
	 * Add and employye
     * @since 31/1/2022
     * @author BMOTTAG
	 */
	public function newEmployee($key)
	{
			$filtro = 'uiAqv828TZr';
			if($filtro != $key) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
					
			$data["view"] = "form_employee";
			$this->load->view("layout_calendar", $data);
	}

	/**
	 * Save new employee
     * @since 31/01/2022
     * @author BMOTTAG
	 */
	public function save_employee()
	{	
			header('Content-Type: application/json');
			$data = array();

			$log_user =  addslashes($this->security->xss_clean($this->input->post('user')));
			$social_insurance = addslashes($this->security->xss_clean($this->input->post('insuranceNumber')));
			$email = addslashes($this->security->xss_clean($this->input->post('email')));
			$firstName = addslashes($this->security->xss_clean($this->input->post('firstName')));
			
			$result_user = false;
			$result_email = false;

			//Verify if the user already exist by the user name
			$arrParam = array(
				"column" => "log_user",
				"value" => $log_user
			);
			$result_user = $this->general_model->verifyUser($arrParam);
			//Verify if the user already exist by the email
			$arrParam = array(
				"column" => "email",
				"value" => $email
			);
			$result_email = $this->general_model->verifyUser($arrParam);

			if($result_user || $result_email) 
			{
				$data["result"] = "error";
				if($result_user)
				{
					$data["mensaje"] = " Error. The user name already exist.";
				}
				if($result_email)
				{
					$data["mensaje"] = " Error. The email already exist.";
				}
				if($result_user && $result_email)
				{
					$data["mensaje"] = " Error. The user name an email already exist.";
				}
			}else{
				if ($this->external_model->saveEmployee()) {
					$newPassword = addslashes($this->security->xss_clean($this->input->post('inputPassword')));
					$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 

					$msj = "Thank you for registering, an email was sent with the access data to the system.";
					$msj .= "<br><br><strong>User name: </strong>" . $log_user;
					$msj .= "<br><strong>Password: </strong>" . $passwd;

					//Envio de correo
					$subjet = "Welcome to VCI";
					$user = $firstName;
					$to = $email;

					$link = base_url();
					$emailmsj = "<strong>APP Link: </strong><a href='" . $link . "'>VCI APP</a>";
					$emailmsj .= "<br><strong>User name: </strong>" . $log_user;
					$emailmsj .= "<br><strong>Password: </strong>" . $passwd;

					$mensaje = "<html>
					<head>
					  <title> $subjet </title>
					</head>
					<body>
						<p>Dear	$user:</p>
						<p>Thank you for registering, the following employees information is the access data to the system:</p>
						<p>$emailmsj</p>
						<p>Cordially,</p>
						<p><strong>V-CONTRACTING INC</strong></p>
					</body>
					</html>";		
	
					$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
					$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$cabeceras .= 'To: ' . $user . '<' . $to . '>' . "\r\n";
					$cabeceras .= 'From: VCI APP <info@v-contracting.ca>' . "\r\n";

					//enviar correo
					mail($to, $subjet, $mensaje, $cabeceras);
					//Fin envio de correo

					$data["result"] = true;					
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
				}
			}
			echo json_encode($data);
    }
	
	/**
=======
>>>>>>> 0002f3fcfbbb0409934dabef4685948491c56034
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