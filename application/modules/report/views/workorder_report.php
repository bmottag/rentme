<?php	
	// create some HTML content
	$html = '<style>
				table {
					font-family: arial, sans-serif;
					border-collapse: collapse;
					width: 100%;
				}

				td, th {
					text-align: left;
					padding: 8px;
				}
				</style>
			<table border="0" cellspacing="0" cellpadding="5">	
				<tr>
					<th width="80%"><h1>RENTME ALL</h1></th>
					<th width="20%"><strong>Date: </strong>' . $infoWorkOrder[0]['date']. '</th>
				</tr>
			</table>';
			$html.= '<br><br><br>';
			$html.= '<table border="0" cellspacing="0" cellpadding="5">';
			$html.= '<tr>';
			$html.= '<th width="35%">From<br>';
			$html.= '<strong>Rentme All</strong>';
	        $html.= '</th>';

			$html.= '<th width="35%">Invoice To<br>';
			$html.= '<strong>' . $infoWorkOrder[0]['param_client_contact'] . '</strong><br>';
	        $html.= $infoWorkOrder[0]['param_client_name'] . '<br>';
	        $html.= $infoWorkOrder[0]['param_client_address'] . '<br>';
	        $html.= 'Phone: ' . $infoWorkOrder[0]['param_client_movil']. '<br>';
	        $html.= 'Email: ' . $infoWorkOrder[0]['param_client_email'];
	        $html.= '</th>';


	        $html.= '<th width="30%"><strong>Invoice No.: </strong>' . $infoWorkOrder[0]['invoice_number'] . '<br></th>';
			$html.= '</tr></table>';
echo $html; exit;
			$html.= '<br><br><br><br>';
			$html.= '<hr>';
			$html.= '<table border="0" cellspacing="0" cellpadding="5">';
			$html.= '<tr>
						<th width="5%" style="text-align:center;"><strong>Qty</strong></th>
						<th width="35%"><strong>Service</strong> </th>
						<th width="36%"><strong>Description</strong></th>
						<th width="12%" style="text-align:right;"><strong>Rate</strong></th>
						<th width="12%" style="text-align:right;"><strong>Subtotal</strong></th>
					</tr>';

            $subtotal = 0;
			foreach ($info as $services):
					$subtotal = $services['value'] + $subtotal;
					$html.= '<tr>';
					$html.= '<th style="text-align:center;">' . $services['quantity'] . '</th>';
					$html.= '<th>' . $services['service'] . '</th>';
					$html.= '<th>' . $services['description'] . '</th>';
					$html.= '<th style="text-align:right;">$ ' . $services['rate'] . '</th>';
					$html.= '<th style="text-align:right;">$ ' . $services['value'] . '</th>';
			        $html.= '</tr>';					
			endforeach;

			$html.= '</table>';


	$acomulado = 0;
	$html.= '<hr>';
	$html.= '<p><br><br><br></p>';
	$html.= '<table border="0" cellspacing="0" cellpadding="3">	
				<tr>
					<th width="60%"></th>
					<th width="40%" colspan=2 ><hr></th>
				</tr>
				<tr>
					<th width="60%"></th>
					<th width="20%">Subtotal:</th>
					<th width="20%" style="text-align:right;">$ ' . $subtotal . '</th>
				</tr>';

		if($taxInfo){
			foreach ($taxInfo as $lista): 
				$html.= '<tr>';
				$html.= '<th ></th>';
				$html.= "<th>" . $lista['taxes_description'] . " (" . $lista['taxes_value'] . "%)</th>";
				$gst = ($subtotal * $lista['taxes_value'] / 100);
				$acomulado = $gst + $acomulado;
				$html.= '<td style="text-align:right;">$ ' . $gst . '</td>';
				$html.= '</tr>';
			endforeach;
		}
		$total = $subtotal + $acomulado;
		$html.= '<tr>
					<th></th>
					<th>Total:</th>
					<th style="text-align:right;">$ ' . $total . '</th>
				</tr>
				<tr>
					<th width="60%"></th>
					<th width="40%" colspan=2 ><br><hr></th>
				</tr>';
	$html.= '</table>';

echo $html;
						
?>