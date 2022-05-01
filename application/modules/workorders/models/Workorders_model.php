<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workorders_model extends CI_Model {

			
	/**
	 * Add/Edit Workorder SERVICE
	 * @since 1/5/2022
	 */
	public function saveWorkorderService() 
	{				
			$idWorkorder = $this->input->post('hddIdWorkorder');
			$idWorkorderService = '';//$this->input->post('hddIdInvoice');
			$rate = $this->input->post('rate');
			$quantity = $this->input->post('quantity');

			$value = $rate * $quantity;
			
			$data = array(
				'fk_id_workorder' => $this->input->post('hddIdWorkorder'),
				'description' => $this->input->post('description'),
				'quantity' => $quantity,
				'rate' => $rate,
				'value' => $value
			);			

			//revisar si es para adicionar o editar
			if ($idWorkorderService == '') {
				$query = $this->db->insert('rme_workorder_details', $data);
			} else {
				$this->db->where('id_invoice', $idWorkorderService);
				$query = $this->db->update('rme_workorder_details', $data);
			}
			if ($query) {
				return true;
			} else {
				return false;
			}
	}







	
		
	    
}