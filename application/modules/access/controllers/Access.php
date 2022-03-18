<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("access_model");
        $this->load->model("general_model");
		$this->load->helper('form');
    }
	
	/**
	 * Listado Menu
     * @since 30/3/2020
     * @author BMOTTAG
	 */
	public function menu()
	{
			$arrParam = array();
			$data['info'] = $this->general_model->get_menu($arrParam);
			$data['pageHeaderTitle'] = "Manage System Access - Menu Links";
			$data['footer'] = True;

			$data["view"] = 'menu';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario menu
     * @since 30/3/2020
     */
    public function cargarModalMenu() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idMenu"] = $this->input->post("idMenu");	
			
			if ($data["idMenu"] != 'x') {
				$arrParam = array("idMenu" => $data["idMenu"]);
				$data['information'] = $this->general_model->get_menu($arrParam);
			}
			
			$this->load->view("menu_modal", $data);
    }
	
	/**
	 * Update Menu
     * @since 30/3/2020
     * @author BMOTTAG
	 */
	public function save_menu()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idEnlace = $this->input->post('hddId');
			
			$msj = "A new Menu was added!";
			if ($idEnlace != '') {
				$msj = "The Menu was updated!";
			}

			if ($this->access_model->saveMenu()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Links list
     * @since 31/3/2020
     * @author BMOTTAG
	 */
	public function links()
	{
			$arrParam = array();
			$data['info'] = $this->general_model->get_links($arrParam);
			$data['pageHeaderTitle'] = "Manage System Access - Submenu Links";
			$data['footer'] = True;
			
			$data["view"] = 'links';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario link
     * @since 31/3/2020
     */
    public function cargarModalLink() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idLink"] = $this->input->post("idLink");	
			
			$arrParam = array("columnOrder" => "menu_name");
			$data['menuList'] = $this->general_model->get_menu($arrParam);
			
			if ($data["idLink"] != 'x') {
				$arrParam = array("idLink" => $data["idLink"]);
				$data['information'] = $this->general_model->get_links($arrParam);
			}
			
			$this->load->view("links_modal", $data);
    }
	
	/**
	 * Update link
     * @since 31/3/2020
     * @author BMOTTAG
	 */
	public function save_link()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idLink = $this->input->post('hddId');
			
			$msj = "A new Submenu was added!";
			if ($idLink != '') {
				$msj = "The Submenu was updated!";
			}

			if ($this->access_model->saveLink()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}

			echo json_encode($data);
    }
	
	/**
	 * Access list
     * @since 31/3/2020
     * @author BMOTTAG
	 */
	public function role_access()
	{
			$arrParam = array();
			$data['info'] = $this->general_model->get_role_access($arrParam);
			$data['pageHeaderTitle'] = "Manage System Access - Role Access";
			$data['footer'] = True;

			$data["view"] = 'role_access';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario Acesss
     * @since 31/3/2020
     */
    public function cargarModalRoleAccess() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data['linkList'] = FALSE;
			$data["idPermiso"] = $this->input->post("idPermiso");	
			
			$arrParam = array(
				"columnOrder" => "menu_name",
				"menuStatus" => 1
			);
			$data['menuList'] = $this->general_model->get_menu($arrParam);
			
			$arrParam = array();
			$data['roles'] = $this->general_model->get_roles($arrParam);
			
			if ($data["idPermiso"] != 'x') {
				$arrParam = array("idPermiso" => $data["idPermiso"]);
				$data['information'] = $this->general_model->get_role_access($arrParam);
		
				//busca lista de links para el menu guardado
				$arrParam = array("idMenu" => $data['information'][0]['fk_id_menu']);
				$data['linkList'] = $this->general_model->get_links($arrParam);
			}
			
			$this->load->view("role_access_modal", $data);
    }
	
	/**
	 * Update access
     * @since 31/3/2020
     * @author BMOTTAG
	 */
	public function save_role_access()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idPermiso = $this->input->post('hddId');
			
			$msj = "The new access was added!";
			if ($idPermiso != '') {
				$msj = "Access was updated!";
			}
			
			//para verificar si ya existe este permiso
			$result_access = FALSE;

			$arrParam = array(
				"idMenu" => $this->input->post('id_menu'),
				"idLink" => $this->input->post('id_link'),
				"idRole" => $this->input->post('id_role')
			);
			$result_access = $this->general_model->get_role_access($arrParam);
			
			if ($result_access) {
				$data["result"] = "error";
				$data["mensaje"] = " Error. The access already exist.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> The access already exist.');
			} else {
				if ($this->access_model->saveRoleAccess()) {
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
				} else {
					$data["result"] = "error";
					$data["mensaje"] = " Error. Ask for help.";
					$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
				}
			}
			
			echo json_encode($data);
    }

	/**
	 * Link list by menu
     * @since 1/4/2020
     * @author BMOTTAG
	 */
    public function linkListInfo() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $idMenu = $this->input->post('idMenu');
				
		//busco listado de links activos para un menu
		$arrParam = array(
			"idMenu" => $idMenu,
			"linkStatus" => 1
		);
		$linkList = $this->general_model->get_links($arrParam);

        echo "<option value=''>Seleccione...</option>";
        if ($linkList) {
            foreach ($linkList as $fila) {
                echo "<option value='" . $fila["id_link"] . "' >" . $fila["link_name"] . "</option>";
            }
        }
    }	
	
	/**
	 * Delete link acces
     * @since 1/4/2020
	 */
	public function delete_role_access()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idPermiso = $this->input->post('identificador');
			
			$arrParam = array(
				"table" => "param_menu_access",
				"primaryKey" => "id_access",
				"id" => $idPermiso
			);
			
			if ($this->general_model->deleteRecord($arrParam)) 
			{
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> Role Access was removed.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }

	/**
	 * Companies List
     * @since 12/6/2021
     * @author BMOTTAG
	 */
	public function companies($status=1)
	{			
			$data['status'] = $status;
			
			$arrParam = array("status" => $status);			
			$data['info'] = $this->general_model->get_app_company($arrParam);
			$data['pageHeaderTitle'] = "Manage System Access - APP Companies";

			$data["view"] = 'companies';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario Companies
     * @since 12/6/2021
     */
    public function cargarModalCompanies() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idCompany"] = $this->input->post("idCompany");	
			
			$arrParam = array();
			$data['infoCountries'] = $this->general_model->get_countries($arrParam);

			if ($data["idCompany"] != 'x') {
				$arrParam = array(
					"idCompany" => $data["idCompany"]
				);
				$data['information'] = $this->general_model->get_app_company($arrParam);

				//busca lista de links para el menu guardado
				$arrParam = array("idCountry" => $data['information'][0]['fk_id_contry']);
				$data['citiesList'] = $this->general_model->get_cities($arrParam);
			}
			
			$this->load->view("companies_modal", $data);
    }
	
	/**
	 * Update Company
     * @since 12/6/2021
     * @author BMOTTAG
	 */
	public function save_company()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idCompany = $this->input->post('hddId');

			$msj = "The Company was added!";
			$data["status"] = 1;
			if ($idCompany != '') {
				$msj = "The Company was updated!";
				$data["status"] = $this->input->post('status');
			}			

			if ($this->access_model->saveCompany()) {
				$data["result"] = true;					
				$this->session->set_flashdata('retornoExito', '<strong>Right!</strong> ' . $msj);
			} else {
				$data["result"] = "error";					
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
			echo json_encode($data);
    }
	
	/**
	 * Cities list by country
     * @since 6/7/2021
     * @author BMOTTAG
	 */
    public function citiesListInfo() {
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
        $idCountry = $this->input->post('idCountry');
				
		//busco listado de links activos para un menu
		$arrParam = array(
			"idCountry" => $idCountry
		);
		$citiesList = $this->general_model->get_cities($arrParam);

        echo "<option value=''>Seleccione...</option>";
        if ($citiesList) {
            foreach ($citiesList as $fila) {
                echo "<option value='" . $fila["id_city"] . "' >" . $fila["city"] . "</option>";
            }
        }
    }	

	
}