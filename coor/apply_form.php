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
    <link rel="apple-touch-icon" sizes="180x180" href="../vendors/images/logoMCT.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../vendors/images/logoMCT.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../vendors/images/logoMCT.png">

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
                        //echo "<script>alert('Something went wrong. Please try again');</script>";
                    }
                }
                else {
                    //echo "<script>alert('COORDINATOR EMAIL IS INVALID. LEAVE APPLICATION FAILED');</script>";
                 }
            }
            else {
               // echo "<script>alert('YOUR EMAIL IS INVALID. LEAVE APPLICATION FAILED');</script>";
            }
	}



?>

<body>
    <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="../vendors/images/logoMCT.png" alt="" style = 'width:400px; height:150px;'></div>
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
                                <h4>Apply Form</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Apply Form</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                 </div>
      

                 <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Student Form</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>

                                <?php if ($role_id = 'Student'): ?>
                                <?php $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
                                    $row = mysqli_fetch_array($query);
                                ?>
                        
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label >Full Name </label>
                                            <input name="firstname" type="text" class="form-control wizard-required" required="true" readonly autocomplete="off" value="<?php echo $row['FirstName']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label >IC Number </label>
                                            <input name="password" type="text"  class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Password']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Position</label>
                                            <input name="postion_staff" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Position_Staff']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Student ID</label>
                                            <input name="staff_id" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Staff_ID']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                        <label>Degree Subject</label>
											<select name="subject" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select Subject</option>
												<option value="MES3023">MES3023</option>
												<option value="MTS3033">MTS3033</option>
												<option value="MES3093">MES3093</option>
											</select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 1</label>
                                            <input name="subject1" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 2</label>
                                            <input name="subject2" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:10px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="apply" id="apply" data-toggle="modal">Add&nbsp;Subject</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                        <label>Degree Subject</label>
											<select name="subject" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select Subject</option>
												<option value="MES3023">MES3023</option>
												<option value="MTS3033">MTS3033</option>
												<option value="MES3093">MES3093</option>
											</select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 1</label>
                                            <input name="subject1" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 2</label>
                                            <input name="subject2" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:10px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="apply" id="apply" data-toggle="modal">Add&nbsp;Subject</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                        <label>Degree Subject</label>
											<select name="subject" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select Subject</option>
												<option value="MES3023">MES3023</option>
												<option value="MTS3033">MTS3033</option>
												<option value="MES3093">MES3093</option>
											</select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 1</label>
                                            <input name="subject1" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 2</label>
                                            <input name="subject2" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:10px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="apply" id="apply" data-toggle="modal">Add&nbsp;Subject</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                        <label>Degree Subject</label>
											<select name="subject" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select Subject</option>
												<option value="MES3023">MES3023</option>
												<option value="MTS3033">MTS3033</option>
												<option value="MES3093">MES3093</option>
											</select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 1</label>
                                            <input name="subject1" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 2</label>
                                            <input name="subject2" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:10px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="apply" id="apply" data-toggle="modal">Add&nbsp;Subject</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <?php endif ?>
                                </div>
                            </section>
                        </form>
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

<script>
$(document).ready(function(){
 
 $(document).on('click', '.add', function(){
  var html = '';
  html += '<tr>';
  
  html += '<td><input type="text" name="course[]" class="form-control item_quantity" /></td>';
  html += '<td><select name="gred[]" class="form-control item_unit"><option value="">Select Gred</option><?php echo fill_unit_select_box($connect); ?></select></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
 });
 
 $('#insert_form').on('submit', function(event){
  event.preventDefault();
  var error = '';
  $('.course').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Course at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  
  
  
  $('.gred').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Gred at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  var form_data = $(this).serialize();
  if(error == '')
  {
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     if(data == 'ok')
     {
      $('#item_table').find("tr:gt(0)").remove();
      $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
     }
    }
   });
  }
  else
  {
   $('#error').html('<div class="alert alert-danger">'+error+'</div>');
  }
 });
 
});
</script>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
   
 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>