<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>MCT System</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
   
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../vendors/images/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../vendors/images/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../vendors/images/logo.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->

    <!-- jQuery UI Signature core CSS -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <link href="../assets/css/jquery.signature.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/jquery-steps/jquery.steps.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../vendors/styles/style.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>

    <link href="../src/css/jquery.signature.css" rel="stylesheet">
    <script src="../src/js/jquery.signature.js"></script>
  
    <style>
        .kbw-signature { width: 100%; height: 100px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
        .center {
  margin-left: auto;
  margin-right: auto;}

  table {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: center;
  padding: 16px;
  
}


    </style>
  
</head>

<?php include('../includes/config.php'); ?>
<?php include('../includes/session.php');?>

<?php
//index.php

$connect = new PDO("mysql:host=localhost;dbname=aci_leave", "root", "");
function fill_unit_select_box($connect)
{ 
 $output = '';
 $query = "SELECT * FROM tbl_unit ORDER BY unit_name ASC";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output .= '<option value="'.$row["unit_name"].'">'.$row["unit_name"].'</option>';
 }
 return $output;
}

?>

<?php 
    if(isset($_POST['upload']))
    {
        $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
        $row = mysqli_fetch_assoc($query);

        $firstname = $row['FirstName'];

        $cut = substr($firstname, 1, 2);

         $folderPath = "../signature/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
          
        $image_type = $image_type_aux[1];
          
        $image_base64 = base64_decode($image_parts[1]);
          
        $file = $folderPath ."sig_" .$cut. "_".$row['Phonenumber']. "_" .$session_id . '.'.$image_type;
          
        file_put_contents($file, $image_base64);

        $signature ="sig_" .$cut. "_".$row['Phonenumber']. "_" .$session_id . '.'.$image_type;

        $result = mysqli_query($conn,"update tblemployees set signature='$signature' where emp_id='$session_id'         
        ")or die(mysqli_error());
        if ($result) {
        echo "<script>alert('Signature Inserted successfully');</script>";
        } else{
          die(mysqli_error());
       }

}

?>

<?php
    include('../sendmail.php');

	if(isset($_POST['apply']))
	{
	$empid=$session_id;
	$leave_type=$_POST['leave_type'];
	//$fromdate=date('d-m-Y', strtotime($_POST['date_from']));
	//$todate=date('d-m-Y', strtotime($_POST['date_to']));
	//$requested_days=$_POST['requested_days'];  
	$hod_status=0;
	$reg_status=0;
	$isread=0;
	
	$work_cover=$_POST['work_cover'];
	$datePosting = date("Y-m-d");

	//$DF = date_create($_POST['date_from']);
	//$DT = date_create($_POST['date_to']);

	//$diff =  date_diff($DF , $DT );
	//$num_days = (1 + $diff->format("%a"));

	$query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
        $row = mysqli_fetch_assoc($query);

        $firstname = $row['FirstName'];

        $cut = substr($firstname, 1, 2);

         $folderPath = "../signature/";
  
        $image_parts = explode(";base64,", $_POST['signed']);
            
        $image_type_aux = explode("image/", $image_parts[0]);
          
        $image_type = $image_type_aux[1];
          
        $image_base64 = base64_decode($image_parts[1]);
          
        $file = $folderPath ."sig_" .$cut. "_".$row['Phonenumber']. "_" .$session_id . '.'.$image_type;
          
        file_put_contents($file, $image_base64);

        $signature ="sig_" .$cut. "_".$row['Phonenumber']. "_" .$session_id . '.'.$image_type;

	
            $staffQuery= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
            //getEmailStaff
            $staffRow = mysqli_fetch_assoc($staffQuery);
            $staffEmailId = $staffRow['EmailId'];
            $firstname = $staffRow['FirstName'];
            $password = $staffRow['Password'];
            //$lastname = $staffRow['LastName'];
            //$fullname = "".$firstname."  ".$lastname."";

            $hodQuery= mysqli_query($conn,"select * from tblemployees where tblemployees.role = 'Coordinator' and tblemployees.Department = '$session_depart'")or die(mysqli_error());
            //getEmail
            $row = mysqli_fetch_assoc($hodQuery);
            $hEmailId = $row['EmailId'];
            $firstName = $row['FirstName'];
            $lastName = $row['LastName'];
            $hodFullname = "".$firstName."  ".$lastName."";

            if (filter_var($staffEmailId, FILTER_VALIDATE_EMAIL)) {
                
                if (filter_var($hEmailId, FILTER_VALIDATE_EMAIL)) {
                    $sql="INSERT INTO tblleave(LeaveType,Sign,WorkCovered,HodRemarks,RegRemarks,IsRead,empid,PostingDate)	VALUES('$leave_type','$signature','$work_cover','$hod_status','$reg_status','$isread','$empid',  '$datePosting')";
                    $lastInsertId = mysqli_query($conn, $sql) or die(mysqli_error());
                    if($lastInsertId)
                    {
                        //echo "<script>alert('Number of Days: ".$requested_days."');</script>";
                        send_mail($fullname,$hEmailId, $leave_type, $hodFullname);
                    }
                    else 
                    {
                        echo "<script>alert('Something went wrong. Please try again');</script>";
                    }
                }
                else {
                    echo "<script>alert('COORDINATOR EMAIL IS INVALID. LEAVE APPLICATION FAILED');</script>";
                 }
            }
            else {
                echo "<script>alert('YOUR EMAIL IS INVALID. LEAVE APPLICATION FAILED');</script>";
            }
	}



?>

<body>
    <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="../vendors/images/logo.png" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>
    
    <?php include('includes/navbar.php')?>

    <?php include('includes/right_sidebar.php')?>

    <?php include('includes/left_sidebar.php')?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>View Course</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">View Course</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                 </div>
                 <div style="margin-left: 30px; margin-right: 30px;" class="pd-20 card-box mb-30">
                 <?php
$conn = mysqli_connect("localhost", "root", "", "aci_leave");
$rows = mysqli_query($conn, "SELECT * FROM demo");
?>

<table class="center" border = 1 cellpadding = 10>
  <tr>
    <th>No</th>
    <th>Course</th>
    <th>Grade</th>
  </tr>
  <?php $i = 1; ?>
  <?php foreach($rows as $row) : ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo $row["name"]; ?></td>
      <td><?php echo $row["phone"]; ?></td>
    </tr>
  <?php endforeach; ?>
</table>

                    
                </div>
            </div>
        </div>
    </div>
  
<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>

<script>
    const picker = document.getElementById('date_form');
    picker.addEventListener('input', function(e){
    var day = new Date(this.value).getUTCDay();
    if([6,0].includes(day)){
      e.preventDefault();
      this.value = '';
      alert('Weekends not allowed');
    } else {
        calc();
    }
   });

   const pickers = document.getElementById('date_to');
    pickers.addEventListener('input', function(e){
    var day = new Date(this.value).getUTCDay();
    if([6,0].includes(day)){
      e.preventDefault();
      this.value = '';
      alert('Weekends not allowed');
    }else {
        calc();
    }
   });

    // function calc_days(){
    //     const date_to = document.getElementById('date_to');
    //     const date_from = document.getElementById('date_form');
	// 	var days = 0;
	// 	if(date_to.value != ''){
	// 		var start = new Date(date_from.value);
	// 		var end = new Date(date_to.value);
	// 		var diffDate = (end - start) / (1000 * 60 * 60 * 24);
	// 		days = Math.round(diffDate);
    //        var work = document.getElementById("requested_days");
    //        work.value = days + 1;
	// 	}

	// }

    function calc() {
      const date_to = document.getElementById('date_to');
      const date_from = document.getElementById('date_form');
      result = getBusinessDateCount(new Date(date_from.value), new Date(date_to.value));
      var work = document.getElementById("requested_days");
      work.value = result;
}

    function getBusinessDateCount(startDate, endDate) {
        var elapsed, daysBeforeFirstSaturday, daysAfterLastSunday;
        var ifThen = function(a, b, c) {
            return a == b ? c : a;
        };

        elapsed = endDate - startDate;
        elapsed /= 86400000;

        daysBeforeFirstSunday = (7 - startDate.getDay()) % 7;
        daysAfterLastSunday = endDate.getDay();

        elapsed -= (daysBeforeFirstSunday + daysAfterLastSunday);
        elapsed = (elapsed / 7) * 5;
        elapsed += ifThen(daysBeforeFirstSunday - 1, -1, 0) + ifThen(daysAfterLastSunday, 6, 5);

        return Math.ceil(elapsed);
     }

    // function func(){
    //     var dropdown = document.getElementById("leave_type");
    //     var selection = dropdown.value;
    //     console.log(selection);
    //     var emailTextBox = document.getElementById("work_cover");
    //     // assign the email address here based on your need.
    //     emailTextBox.value = selection;
    //   }
</script>


    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
   
 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>