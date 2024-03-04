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
    </style>
  
</head>
<?php include('../includes/config.php'); ?>

<?php include('../includes/session.php')?>
<?php
if(isset($_POST['new_update']))
{
	$empid=$session_id;
	$fname=$_POST['fname'];
	$lname=$_POST['lastname'];   
	$email=$_POST['email'];  
	$dob=$_POST['dob']; 
	$password=$_POST['password']; 
	$department=$_POST['department']; 
	$address=$_POST['address']; 
	$gender=$_POST['gender'];  
	$phonenumber=$_POST['phonenumber'];

    $result = mysqli_query($conn,"update tblemployees set FirstName='$fname', LastName='$lname', EmailId='$email', Gender='$gender', Dob='$dob', Password='$password', Department='$department', Address='$address', Phonenumber='$phonenumber' where emp_id='$session_id'         
		")or die(mysqli_error());
    if ($result) {
     	echo "<script>alert('Your records Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'my_profile.php'; </script>";
	} else{
	  die(mysqli_error());
   }

}

if (isset($_POST["update_image"])) {

	$image = $_FILES['image']['name'];

	if(!empty($image)){
		move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$image);
		$location = $image;	
	}
	else {
		echo "<script>alert('Please Select Picture to Update');</script>";
	}

    $result = mysqli_query($conn,"update tblemployees set location='$location' where emp_id='$session_id'         
		")or die(mysqli_error());
    if ($result) {
     	echo "<script>alert('Profile Picture Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'my_profile.php'; </script>";
	} else{
	  die(mysqli_error());
   }
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

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="title">
								<h4>Profile</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
						<div class="pd-20 card-box height-100-p">

							<?php $query= mysqli_query($conn,"select * from tblemployees LEFT JOIN tbldepartments ON tblemployees.Department = tbldepartments.DepartmentShortName where emp_id = '$session_id'")or die(mysqli_error());
								$row = mysqli_fetch_array($query);
							?>

							<div class="profile-photo">
								<a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
								<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" alt="" class="avatar-photo">
								<form method="post" enctype="multipart/form-data">
									<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="weight-500 col-md-12 pd-5">
													<div class="form-group">
														<div class="custom-file">
															<input name="image" id="file" type="file" class="custom-file-input" accept="image/*" onchange="validateImage('file')">
															<label class="custom-file-label" for="file" id="selector">Choose file</label>		
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<input type="submit" name="update_image" value="Update" class="btn btn-primary">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<h5 class="text-center h5 mb-0"><?php echo $row['FirstName']. " " .$row['LastName']; ?></h5>
							<p class="text-center text-muted font-14"><?php echo $row['DepartmentName']; ?></p>
							<div class="profile-info">
								<h5 class="mb-20 h5 text-blue">Contact Information</h5>
								<ul>
									<li>
										<span>Email Address:</span>
										<?php echo $row['EmailId']; ?>
									</li>
									<li>
										<span>Phone Number:</span>
										<?php echo $row['Phonenumber']; ?>
									</li>
									<li>
										<span>Position:</span>
										<?php echo $row['Position_Staff']; ?>
									</li>
									<li>
										<span>Address:</span>
										<?php echo $row['Address']; ?>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
						<div class="card-box height-100-p overflow-hidden">
							<div class="profile-tab height-100-p">
								<div class="tab height-100-p">
									<ul class="nav nav-tabs customtab" role="tablist">
										
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#set" role="tab">Forms</a>
										</li>
                                        <li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#setting" role="tab">Settings</a>
										</li>
									</ul>
									<div class="tab-content">
                                        <!-- Setting Tab start -->
                                                <?php
													$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id' ")or die(mysqli_error());
													$row = mysqli_fetch_array($query);
												?>
										<div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
											<div class="profile-setting">
												<form method="POST" enctype="multipart/form-data">
													<div class="profile-edit-list row">
														<div class="col-md-12"><h4 class="text-blue h5 mb-20">Edit Your Personal Setting</h4></div>

														
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>First Name</label>
																<input name="fname" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $row['FirstName']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>Last Name</label>
																<input name="lastname" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['LastName']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>Email Address</label>
																<input name="email" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['EmailId']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>Phone Number</label>
																<input name="phonenumber" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['Phonenumber']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>Date Of Birth</label>
																<input name="dob" class="form-control form-control-lg date-picker" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['Dob']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>Gender</label>
																<select name="gender" class="custom-select form-control" required="true" autocomplete="off">
																<option value="<?php echo $row['Gender']; ?>"><?php echo $row['Gender']; ?></option>
																	<option value="male">Male</option>
																	<option value="female">Female</option>
																</select>
															</div>
														</div>
														<div class="weight-500 col-md-6">
															
															<div class="form-group">
																<label>Address</label>
																<input name="address" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['Address']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>Department</label>
																<select name="department" class="custom-select form-control" required="true" autocomplete="off">
																	<?php
																		$query_staff = mysqli_query($conn,"select * from tblemployees join  tbldepartments where emp_id = '$session_id'")or die(mysqli_error());
																		$row_staff = mysqli_fetch_array($query_staff);
																		
																	 ?>
																	<option value="<?php echo $row_staff['DepartmentShortName']; ?>"><?php echo $row_staff['DepartmentName']; ?></option>
																		<?php
																		$query = mysqli_query($conn,"select * from tbldepartments");
																		while($row = mysqli_fetch_array($query)){
																		
																		?>
																		<option value="<?php echo $row['DepartmentShortName']; ?>"><?php echo $row['DepartmentName']; ?></option>
																		<?php } ?>
																</select>
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<?php
																$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id' ")or die(mysqli_error());
																$row = mysqli_fetch_array($query);
															?>
															<div class="form-group">
																<label>Password</label>
																<input name="password" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['Password']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label></label>
																<div class="modal-footer justify-content-center">
																	<button class="btn btn-primary" name="new_update" id="new_update" data-toggle="modal">Save & &nbsp;Update</button>
																</div>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- Setting Tab End -->
										<!-- Timeline Tab start -->
										<div class="tab-pane fade height-100-p" id="set" role="tabpanel">
											<div class="profile-setting">
												<form method="POST" enctype="multipart/form-data">
													<div class="profile-edit-list row">
														<div class="col-md-12"><h4 class="text-blue h5 mb-20">Apply Application</h4></div>

														<?php
														$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id' ")or die(mysqli_error());
														$row = mysqli_fetch_array($query);
														?>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label>Fullname</label>
																<input name="fname" class="form-control form-control-lg" type="text" required="true" autocomplete="off" readonly value="<?php echo $row['FirstName']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label >IC Number </label>
                                                                <input name="password" type="text"  class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Password']; ?>">
                                                            </div>
														</div>
														<div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Student ID</label>
                                                                <input name="staff_id" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Staff_ID']; ?>">
                                                            </div>
														</div>
														<div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Programme</label>
                                                                <input name="postion_staff" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Position_Staff']; ?>">
                                                            </div>
														</div>
														<div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                            <label>Previous IPT</label>
                                                            <input id="lastname" name="lastname" type="text" class="form-control" required="true" autocomplete="off">
                                                        </div>
														</div>
														<div class="weight-500 col-md-6">
                                                        <div class="form-group">
                                                            <label>Student Level :</label>
                                                            <select name="leave_type" id="leave_type" class="custom-select form-control" required="true" autocomplete="off">
                                                            <option value="">Select student level...</option>
                                                            <?php $sql = "SELECT  LeaveType from tblleavetype";
                                                            $query = $dbh -> prepare($sql);
                                                            $query->execute();
                                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                            $cnt=1;
                                                            if($query->rowCount() > 0)
                                                            {
                                                            foreach($results as $result)
                                                            {   ?>                                            
                                                            <option value="<?php echo htmlentities($result->LeaveType);?>"><?php echo htmlentities($result->LeaveType);?></option>
                                                            <?php }} ?>
                                                            </select>
                                                        </div>
														</div>
														<div class="col-md-4 col-sm-12">
															
                                                            <div class="form-group">
                                                                <label>Work to be covered by </label>
                                                                <input id="work_cover" name="work_cover" type="text" class="form-control" required="true" autocomplete="off" value="">
                                                            </div>
														</div>
														<div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                            <label>Signature </label>
                                                            <div id="sig" ></div>
                                                             <br/>
                                                             <textarea id="signature64" name="signed" required="true"></textarea>
                                                            <p style="clear: both;" class="btn btn-group">
                                                
                                                             </p>
                                                            <div class="dropdown">
                                                            <button class="btn btn-outline-danger" id="clear">Clear Signature</button>
                                                            </div>
                                                            <br/>
                                                            
                                                            </div>
														</div>
														<div class="weight-500 col-md-6">
															<?php
																$query = mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id' ")or die(mysqli_error());
																$row = mysqli_fetch_array($query);
															?>
															<div class="form-group">
																<label>Password</label>
																<input name="password" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['Password']; ?>">
															</div>
														</div>
														<div class="weight-500 col-md-6">
															<div class="form-group">
																<label></label>
																<div class="modal-footer justify-content-center">
																	<button class="btn btn-primary" name="new_update" id="new_update" data-toggle="modal">Save & &nbsp;Update</button>
																</div>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- Timeline Tab End -->
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<?php include('includes/scripts.php')?>

	<script type="text/javascript">
		var loader = function(e) {
			let file = e.target.files;

			let show = "<span>Selected file : </span>" + file[0].name;
			let output = document.getElementById("selector");
			output.innerHTML = show;
			output.classList.add("active");
		};

		let fileInput = document.getElementById("file");
		fileInput.addEventListener("change", loader);
	</script>
	<script type="text/javascript">
		 function validateImage(id) {
		    var formData = new FormData();
		    var file = document.getElementById(id).files[0];
		    formData.append("Filedata", file);
		    var t = file.type.split('/').pop().toLowerCase();
		    if (t != "jpeg" && t != "jpg" && t != "png") {
		        alert('Please select a valid image file');
		        document.getElementById(id).value = '';
		        return false;
		    }
		    if (file.size > 1050000) {
		        alert('Max Upload size is 1MB only');
		        document.getElementById(id).value = '';
		        return false;
		    }

		    return true;
		}
	</script>
</body>
</html>