<?php
	include 'includes/session.php';

	function generateRow($conn){
		$contents = '';
	 	
		$sql = "SELECT * FROM positions ORDER BY priority ASC";
        $query = $conn->query($sql);
        while($row = $query->fetch_assoc()){
        	$id = $row['id'];
        	$contents .= '
        		<tr>
        			<td colspan="2" align="center" style="font-size:15px;"><b>'.$row['description'].'</b></td>
        		</tr>
        		<tr>
        			<td width="80%"><b>Candidates</b></td>
        			<td width="20%"><b>Votes</b></td>
        		</tr>
        	';

        	$sql = "SELECT * FROM candidates WHERE position_id = '$id' ORDER BY lastname ASC";
    		$cquery = $conn->query($sql);
    		while($crow = $cquery->fetch_assoc()){
    			$sql = "SELECT * FROM votes WHERE candidate_id = '".$crow['id']."'";
      			$vquery = $conn->query($sql);
      			$votes = $vquery->num_rows;

      			$contents .= '
      				<tr>
      					<td>'.$crow['lastname'].", ".$crow['firstname'].'</td>
      					<td>'.$votes.'</td>
      				</tr>
      			';

    		}

        }

		return $contents;
	}

	// Get election title from config file
	$parse = parse_ini_file('config.ini', FALSE, INI_SCANNER_RAW);
    $title = $parse['election_title'];

	// Load TCPDF library
	require_once('../tcpdf/tcpdf.php');

	// Create TCPDF object
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Result: '.$title);  

    // Remove header and footer
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set font
    $pdf->SetFont('helvetica', '', 11);  

    // Add first page
    $pdf->AddPage();  

    // Generate HTML content
    $content = '<h2 align="center">'.$title.'</h2>';
    $content .= '<h4 align="center">Tally Result</h4>';
    $content .= '<table border="1" cellspacing="0" cellpadding="3">';  
   	$content .= generateRow($conn);  
    $content .= '</table>';  

    // Write HTML content to PDF
    $pdf->writeHTML($content);  

    // Output PDF to browser
    $pdf->Output('election_result.pdf', 'I');
?>
