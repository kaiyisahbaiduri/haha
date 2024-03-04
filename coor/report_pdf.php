<?php
	include('../includes/session.php');
	include('../includes/config.php');
	require_once('../TCPDF-main/tcpdf.php');

	$did=intval($_GET['leave_id']);
	$sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.PostingDate,tblleave.RequestedDays,tblleave.DaysOutstand,tblleave.Sign,tblleave.WorkCovered,tblleave.HodRemarks,tblleave.RegRemarks,tblleave.HodSign,tblleave.RegSign,tblleave.HodDate,tblleave.RegDate,tblleave.num_days from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where tblleave.id='$did'";
	$query = mysqli_query($conn, $sql) or die(mysqli_error());
	while ($row = mysqli_fetch_array($query)) {
		$firstname = $row['FirstName'];
		$lastname = $row['LastName'];
		$position = $row['Position_Staff']; 
	    $staff_id = $row['Staff_ID'];
		$posted = $row['PostingDate'];
		$hod_sign = $row['HodSign'];
		$hod_date = $row['HodDate'];
		$reg_sign = $row['RegSign'];
		$reg_date = $row['RegDate'];
	}

	class PDF extends TCPDF
	{
	    public function Header()
	    {
	    	$this->Ln(40);
			$imagePath = '../vendors/images/LogoUpsi.jpg'; // Change this to the path of your image
        	$this->Image($imagePath, 120, 10, 60, '', 'JPG');
	    	$this->SetFont('times','B', 14);
	    	$this->Cell(270, 0, 'UNIVERSITI PENDIDIKAN SULTAN IDRIS', 0, 1, 'C');
	    	$this->SetFont('times','B', 14);
	    	$this->Ln(2);
	    	$this->Cell(270,0, 'FACULTY OF COMPUTING AND META-TECHNOLOGY', 0, 1, 'C');
	    	$this->SetFont('times','B', 14);
	    	$this->Ln(2);
	    	$this->Cell(270,0, 'META CREDIT TRANSFER APPLICATION FORM', 0, 1, 'C');
	    }

	    public function Body($data)
    {
        // Your existing body code...
		$currentMargin = $this->lMargin;

    	// Calculate the center position for the table
    	$centerX = ($this->w - $this->lMargin - $this->rMargin) / 16 + $this->lMargin;

    	// Set a new left margin to center the table
    	$this->SetLeftMargin($centerX);
        $this->Ln(15);

        $this->SetFont('times', 'B', 11);

        // Table header
        $this->Cell(15, 10, 'ID', 1);
        $this->Cell(59, 10, 'Degree Subject', 1);
        $this->Cell(59, 10, 'Diploma Subject', 1);
        $this->Cell(59, 10, 'Diploma Subject', 1);
        $this->Cell(39, 10, 'Status', 1);
        $this->Ln();

        // Table data
        foreach ($data as $row) {
            $this->Cell(15, 10, $row['id'], 1);
            $this->Cell(59, 10, $row['firstname'], 1);
            $this->Cell(59, 10, $row['lastname'], 1);
            $this->Cell(59, 10, $row['address'], 1);
			$statusColor = ''; // Initialize variable to store status color
        	$statusText = '';  // Initialize variable to store status text

			// Determine status color and text based on the 'status' column in your database
        switch ($row['status']) {
            case 1:
                $statusColor = 'green';
                $statusText = 'Verified';
                break;
            case 2:
                $statusColor = 'red';
                $statusText = 'Rejected';
                break;
            default:
                $statusColor = 'blue';
                $statusText = 'Pending';
        }

			$this->SetFillColor($statusColor);
			$this->Cell(39, 10, $statusText, 1);
			$this->Ln();
            // Action buttons $row['coordinator_approval'],
           // $this->Cell(39, 10, '
            //<a href=\'#approve_' . $row['id'] . '\' class=\'btn btn-success btn-sm approve-btn\' data-toggle=\'modal\'><span class=\'glyphicon glyphicon-ok\'></span> Approve</a>
           // <a href=\'#reject_' . $row['id'] . '\' class=\'btn btn-danger btn-sm reject-btn\' data-toggle=\'modal\'><span class=\'glyphicon glyphicon-remove\'></span> Reject
        //', 1);

            
        }
		$this->SetLeftMargin($currentMargin);
        // Your existing body code...
    }

	public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('times', 'I', 12);
        $this->Cell(0, 10, 'Generated by a computer', 0, 0, 'C');
    }

	}
	$data = array();
	include_once('connection.php');
	$sql = "SELECT * FROM members";
	$query = $conn->query($sql);
	while ($row = $query->fetch_assoc()) {
		$data[] = $row;
	}
	// create new PDF document
	$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('META Credit Transfer');
	$pdf->SetTitle('META Credit Transfer');
	$pdf->SetSubject('');
	$pdf->SetKeywords('');

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
	$pdf->setFooterData(array(0,64,0), array(0,64,128));

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

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

	// set default font subsetting mode
	$pdf->setFontSubsetting(true);

	// Set font
	// dejavusans is a UTF-8 Unicode font, if you only need to
	// print standard ASCII chars, you can use core fonts like
	// helvetica or times to reduce file size.
	$pdf->SetFont('dejavusans', '', 14, '', true);

	// Add a page
	// This method has several options, check the source code documentation for more information.
	$pdf->AddPage();

	$pdf->Ln(53);
	$pdf->SetFont('times','B', 12);
	$pdf->Cell(130, 0, '               Full Name:    '.$firstname.' '.$lastname.'', 0, 0);
	$pdf->Cell(59, 0, '                        Programme Code:    '.$position.' ', 0, 0);

	$pdf->Ln(11);
	$pdf->SetFont('times','B', 12);
	$pdf->Cell(130, 0, '               Student ID:    '.$staff_id.' ', 0, 0);
	$pdf->Cell(59, 0, '                        Date Applied:    '.$posted.' ', 0, 0);
	
	// Call the Body method to include the table data
	$pdf->Body($data);

	$pdf->Ln(3);
	$pdf->Cell(59, 18, '                Verified By Coordinator: Muhammad Adrian   ', 0, 0);
	//$pdf->Ln(3);
	//$pdf->SetFont('times','B', 12);
	//$pdf->Cell(95, 18, '         Approved By Course Coordinator: '.$hod_sign.'', 0, 0);
	//$pdf->writeHTMLCell(35,30,'','', '', 0, 0);
	$pdf->Cell(59, 18, '                                                                                                     Approved By HoD: Kaiyisah Baiduri   ', 0, 1);
	$pdf->Ln(0);
	$pdf->Cell(59, 18, '                Date Verified By Coordinator:   '.$hod_date.'', 0, 0);
	//$pdf->SetFont('times','B', 12);
	//$pdf->Cell(75, 18, '         Verified By Head of Department: '.$reg_sign.'', 0, 0);
	//$pdf->writeHTMLCell(55,1,'','', '', 0, 0);
	$pdf->Cell(59, 18, '                                                                                                     Date Approved By HoD:   '.$reg_date.'', 0, 1);


	//$pdf->Ln(8);
	

// Output the PDF
$pdf->Output('aci_1.pdf', 'I');

?>
