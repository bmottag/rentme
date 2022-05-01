<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("report_model");
    }
		
	/**
	 * Generate Workorder Report in PDF
	 * @param int $idWorkorder
     * @since 1/05/2022
     * @author BMOTTAG
	 */
	public function generaWorkorderPDF($idWorkorder)
	{
			$this->load->library('Pdf');
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('PayrollClick');
			$pdf->SetTitle('Invoice');
			$pdf->SetSubject('TCPDF Tutorial');

			// set default header data
			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			$pdf->setPrintFooter(false); //no imprime el pie ni la linea 

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 8);

			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
		
			$this->load->model("general_model");
			$data['infoWorkOrder'] = $this->general_model->get_workordes_by_idUser($arrParam);
			$data['WODetails'] = $this->general_model->get_wo_details($arrParam);
			$arrParam = array('idRent' =>$data['infoWorkOrder'][0]["fk_id_rent"]);
			$data['infoRent'] = $this->general_model->get_rents($arrParam);

					

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Print a table
				
			// add a page
			$pdf->AddPage();

			$html = $this->load->view("invoice_report", $data, true);

			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');

			// Print some HTML Cells

			// reset pointer to the last page
			$pdf->lastPage();


			//Close and output PDF document
			$pdf->Output('invoice_no_' . $data['info'][0]['invoice_number']. '.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		
	}
	

	
}