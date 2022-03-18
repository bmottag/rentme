<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("users_model");
        $this->load->model("general_model");
    }

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
			$idUser = $this->session->userdata("idUser");
									
			$arrParam = array(
				"idUser" => $idUser
			);
			$data['information'] = $this->general_model->get_user($arrParam);
			$data['pageHeaderTitle'] = "User - Change Password";

			$data["view"] = "form_password";
			$this->load->view("layout", $data);
	}
	

	/**
	 * Actulizar contraseña
	 */
	public function update_password()
	{
			$data = array();			
			
			$newPassword = $this->input->post("inputPassword");
			$confirm = $this->input->post("inputConfirm");
			$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
			$idUser = $this->input->post("hddId");
						
			if($newPassword == $confirm)
			{					
				if ($this->users_model->updatePassword()) {
					$msj = 'The password was updated';
					$msj .= "<br><strong>User name: </strong>" . $this->input->post("hddUser");
					$msj .= "<br><strong>Password: </strong>" . $passwd;
					$this->session->set_flashdata('retornoExito', $msj);
				}else{
						$data["msj"] = "<strong>Error!!!</strong> Ask for help.";
						$data["clase"] = "alert-danger";
				}
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Please enter the same value again.');
			}
			redirect(base_url('users'), 'refresh');
	}
	
	/**
	 * photo
	 */
	public function profile($error = '')
	{			
			$idUser = $this->session->userdata("idUser");
			
			//busco datos del usuario
			$arrParam = array(
				"idUser" => $idUser
			);
			$data['information'] = $this->general_model->get_user($arrParam);
			$data['pageHeaderTitle'] = "User - Profile";
			
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 
			$data["view"] = 'user_profile';
			$this->load->view("layout", $data);
	}
	
    //FUNCIÓN PARA SUBIR LA IMAGEN 
    function do_upload() 
	{
			$config['upload_path'] = './images/users/';
			$config['overwrite'] = true;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '3000';
			$config['max_width'] = '2024';
			$config['max_height'] = '2008';
			$idUser = $this->session->userdata("idUser");
			$config['file_name'] = $idUser;

			$this->load->library('upload', $config);
			//SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
			if (!$this->upload->do_upload()) {
				$error = $this->upload->display_errors();
pr($error);
pr($_FILES); exit;

				$this->profile($error);
			} else {
				$file_info = $this->upload->data();//subimos la imagen
				
				//USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
				//ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
				$this->_create_thumbnail($file_info['file_name']);
				$data = array('upload_data' => $this->upload->data());
				$imagen = $file_info['file_name'];
				$path = "images/users/thumbs/" . $imagen;
				
				//actualizamos el campo photo
				$arrParam = array(
					"table" => "user",
					"primaryKey" => "id_user",
					"id" => $idUser,
					"column" => "photo",
					"value" => $path
				);				
				if($this->general_model->updateRecord($arrParam))
				{
					$this->session->set_flashdata('retornoExito', '<strong>Nice!</strong> User photo updated');
				}else{
					$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
				}
				redirect('users/profile');
			}
    }
	
    //FUNCIÓN PARA CREAR LA MINIATURA A LA MEDIDA QUE LE DIGAMOS
    function _create_thumbnail($filename) 
	{
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = 'images/users/' . $filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image'] = 'images/users/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }

	
}
