<?php error_reporting(0);?>
<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<style>
	input[type="text"]
	{
	    font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	.btn-outline:hover {
	  color: #fff;
	  background-color: #524d7d;
	  border-color: #524d7d; 
	}

	textarea { 
		font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	textarea.text_area{
        height: 8em;
        font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
      }

	</style>

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
		<div class="pd-ltr-20">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>APPLICATION STATUS</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Application Status</li>
								</ol>
							</nav>
						</div>

						
						<!--<div class="col-md-6 col-sm-12 text-right">
							<div class="dropdown show">
								<a class="btn btn-primary" href="report_pdf.php?leave_id=<?php echo $_GET['leaveid'] ?>">
									Generate Report
								</a>
							</div>
						</div>-->
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Application Status</h4>
							<p class="mb-20"></p>
						</div>
					</div>

					<form method="post" action="">

						<?php 
						if(!isset($_GET['edit']) && empty($_GET['edit'])){
							header('Location: index.php');
						}
						else {
						
						$lid=intval($_GET['edit']);
						$sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.RequestedDays,tblleave.PostingDate,tblleave.DaysOutstand,tblleave.Sign,tblleave.WorkCovered,tblleave.HodRemarks,tblleave.RegRemarks,tblleave.HodSign,tblleave.RegSign,tblleave.HodDate,tblleave.RegDate,tblleave.num_days from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where tblleave.id=:lid";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':lid',$lid,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $result)
						{         
						?>  
  
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Full Name</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->FirstName." ".$result->LastName);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Programme Code</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->Position_Staff);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Student ID</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->Staff_ID);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Phone Number</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->Phonenumber);?>">
								</div>
							</div>

							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Applied Date</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->PostingDate);?>">
								</div>
							</div>
						
								<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Email Address</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->EmailId);?>">
								</div>
							</div>
							</div>
			<div class="container">
			<div class="row">
			<?php
				if(isset($_SESSION['error'])){
					echo
					"
					<div class='alert alert-danger text-center'>
						<button class='close'>&times;</button>
						".$_SESSION['error']."
					</div>
					";
					unset($_SESSION['error']);
				}
				if(isset($_SESSION['success'])){
					echo
					"
					<div class='alert alert-success text-center'>
						<button class='close'>&times;</button>
						".$_SESSION['success']."
					</div>
					";
					unset($_SESSION['success']);
				}
			?>
			</div>
		
			<div class="row">
				<table id="myTable" class="table table-bordered table-striped">
					<thead>
						<th>ID</th>
						<th>Degree Subject</th>
						<th>Diploma Subject</th>
						<th>Diploma Subject</th>
						<th>Status</th>
					</thead>
					<tbody>
						
						<?php
							include_once('connection.php');
							$sql = "SELECT * FROM members";

							//use for MySQLi-OOP
							$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
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
								echo 
								"<tr>
									<td>".$row['id']."</td>
									<td>".$row['firstname']."</td>
									<td>".$row['lastname']."</td>
									<td>".$row['address']."</td>
									<td style='color: $statusColor;'>$statusText</td>
								</tr>";
								include('edit_delete_modal.php');
							}

						?>
					</tbody>
				</table>			
			</div>		
			</div>
						<div class="form-group row">
							<div class="col-md-6 col-sm-12">
							    <div class="form-group">
									<label style="font-size:16px;"><b>Coordinator's Approval</b></label>
									<?php
									if ($result->HodSign==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
									<?php else: ?>
									  <div class="avatar mr-2 flex-shrink-0">
										<img src="<?php echo '../signature/'.($result->HodSign);?>" width="100" height="40" alt="">
									  </div>
									<?php endif ?>
							    </div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Head of Department's Approval</b></label>
									<?php
									if ($result->RegSign==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA";?>">
									<?php else: ?>
									  <div class="avatar mr-2 flex-shrink-0">
										<img src="<?php echo '../signature/'.($result->RegSign);?>" width="100" height="40" alt="">
									  </div>
									<?php endif ?>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6 col-sm-12">
							    <div class="form-group">
									<label style="font-size:16px;"><b>Date For Coordinator's Action</b></label>
									<?php
									if ($result->HodDate==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
									<?php else: ?>
									  <div class="avatar mr-2 flex-shrink-0">
										<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->HodDate); ?>">
									  </div>
									<?php endif ?>
							    </div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Date For Head of Department's Action</b></label>
									<?php
									if ($result->RegDate==""): ?>
									  <input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "NA"; ?>">
									<?php else: ?>
									  <div class="avatar mr-2 flex-shrink-0">
										<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->RegDate); ?>">
									  </div>
									<?php endif ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label style="font-size:16px;"><b>Application Status From Coordinator</b></label>
									<?php $stats=$result->HodRemarks;?>
									<?php
									if ($stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Verified"; ?>">
									<?php
									 elseif ($stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Unverified"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label style="font-size:16px;"><b>Application Status From Head of Department</b></label>
									<?php $stats=$result->RegRemarks;?>
									<?php
									if ($stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
									<?php
									 elseif ($stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>

						</div>

						<?php $cnt++;} } }?>
					</form>
				</div>

			</div>
			
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>