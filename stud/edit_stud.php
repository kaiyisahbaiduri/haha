<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php
	if(isset($_POST['add_staff']))
	{
	
	$fname=$_POST['firstname'];
	$lname=$_POST['lastname'];   
	$email=$_POST['email'];  
	$gender=$_POST['gender']; 
	$dob=$_POST['dob']; 
	$department=$_POST['department']; 
	$address=$_POST['address']; 
	
	$user_role=$_POST['user_role']; 
	$phonenumber=$_POST['phonenumber']; 
	$position_staff=$_POST['position_staff']; 
	$staff_id=$_POST['staff_id']; 

	$result = mysqli_query($conn,"update tblemployees set FirstName='$fname', LastName='$lname', EmailId='$email', Gender='$gender', Dob='$dob', Department='$department', Address='$address', role='$user_role', Phonenumber='$phonenumber', Position_Staff='$position_staff', Staff_ID='$staff_id' where emp_id='$get_id'         
		"); 		
	if ($result) {
     	echo "<script>alert('Record Successfully Updated');</script>";
     	echo "<script type='text/javascript'> document.location = 'stud.php'; </script>";
	} else{
	  die(mysqli_error());
   }
		
}

?>

<body>
<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="../vendors/images/logoMCT.png" alt=""style = 'width:400px; height:150px;'></div>
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
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Apply Form</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
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
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
										<label >Full Name </label>
											<input name="firstname" type="text" class="form-control wizard-required" required="true" readonly autocomplete="off" value="<?php echo $row['FirstName']; ?>">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
										<label>IC Number</label>
											<input name="password" type="text"  class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Password']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
										<label >Position </label>
											<input name="postion_staff" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Position_Staff']; ?>">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group">
										<label >Student ID </label>
											<input name="staff_id" type="text" class="form-control" required="true" autocomplete="off" readonly value="<?php echo $row['Staff_ID']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                        <label>Degree Subject</label>
											<select name="subject" class="custom-select form-control" required="true" autocomplete="off">
												<option value="<?php echo $row['subject']; ?>"><?php echo $row['subject']; ?></option>	
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
                                            <input name="subject1" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['subject1']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 2</label>
                                            <input name="subject2" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['subject2']; ?>">
                                        </div>
                                    </div>			
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Add&nbsp;</button>
											</div>
										</div>
									</div>
							</div>
							<div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                        <label>Degree Subject</label>
											<select name="subject" class="custom-select form-control" required="true" autocomplete="off">
											<option value="<?php echo $row['subject']; ?>"><?php echo $row['subject']; ?></option>	
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
                                            <input name="subject1" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['subject1']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 2</label>
                                            <input name="subject2" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['subject2']; ?>">
                                        </div>
                                    </div>			
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Add&nbsp;</button>
											</div>
										</div>
									</div>
							</div>
							<div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                        <label>Degree Subject</label>
											<select name="subject" class="custom-select form-control" required="true" autocomplete="off">
											<option value="<?php echo $row['subject']; ?>"><?php echo $row['subject']; ?></option>	
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
                                            <input name="subject1" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['subject1']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Diploma Subject 2</label>
                                            <input name="subject2" type="text" class="form-control" required="true" autocomplete="off"value="<?php echo $row['subject2']; ?>">
                                        </div>
                                    </div>			
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Add&nbsp;</button>
											</div>
										</div>
									</div>
							</div>
							</section>
						</form>
					</div>
				</div>

			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<?php include('includes/scripts.php')?>
</body>
</html>