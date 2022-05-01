<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Report_model extends CI_Model {
	    
		/**
		 * Workorder details
		 * @since 1/4/2022
		 */
		public function get_total_invoice($arrData) 
		{			
			$this->db->select('I.invoice_number, I.invoice_date, I.terms, I.terms, S.service, S.description, S.quantity, S.rate, S.value, C.param_client_name, C.param_client_contact, C.param_client_movil, C.param_client_email, C.param_client_address, A.*');
			$this->db->join('invoice I', 'I.id_invoice = S.fk_id_invoice', 'INNER');
			$this->db->join('param_client C', 'C.id_param_client = I.fk_id_param_client_i', 'INNER');
			$this->db->join('app_company A', 'A.id_company = C.fk_id_app_company', 'INNER');
			$this->db->where('fk_id_app_company', $this->session->idCompany);
			$this->db->where('invoice_service_status', 1);
			if (array_key_exists("idInvoice", $arrData)) {
				$this->db->where('S.fk_id_invoice', $arrData["idInvoice"]);
			}
			if (array_key_exists("idInvoiceService", $arrData)) {
				$this->db->where('S.id_invoice_service', $arrData["idInvoiceService"]);
			}
			$this->db->order_by("id_invoice_service", "ASC");
			$query = $this->db->get("invoice_services S");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			}else{
				return false;
			}
		}

		/**
		 * Taxes list
		 * @since 20/7/2021
		 */
		public function get_taxes($arrData) 
		{			
			$this->db->select();
			$this->db->where('fk_id_app_company_t ', $this->session->idCompany);
			if (array_key_exists("idTax", $arrData)) {
				$this->db->where('id_param_company_taxes', $arrData["idTax"]);
			}
			$this->db->order_by("taxes_description", "ASC");
			$query = $this->db->get("param_company_taxes T");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else{
				return false;
			}
		}
		
		
	}