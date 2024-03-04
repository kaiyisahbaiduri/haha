<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
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

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4 user-icon">
						<img src="../vendors/images/banner-img.png" alt="">
					</div>
					<div class="col-md-8">

						<?php $query= mysqli_query($conn,"select * from tblemployees where emp_id = '$session_id'")or die(mysqli_error());
								$row = mysqli_fetch_array($query);
						?>

						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome back <div class="weight-600 font-30 text-blue"><?php echo $row['FirstName']. " " .$row['LastName']; ?></div>
						</h4>
						<p class="font-18 max-width-600">To META Credit Transfer System </p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">Coordinator</div>
							
						</div>
						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees where role='Coordinator' and Department = '$session_depart' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
									<div class="name-avatar d-flex align-items-center pr-2">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
										</div>
										<div class="txt">
											<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $row['Department']; ?></span>
											<div class="font-14 weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
											<div class="font-12 weight-500" data-color="#b2b1b6"><?php echo $row['EmailId']; ?></div>
										</div>
									</div>
									<div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['Phonenumber']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Application Setup</div>
							
						</div>

						<div id="application-chart"></div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Student</div>
							
						</div>

						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees where role = 'Student' and Department = '$session_depart' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<li class="d-flex align-items-center justify-content-between">
									<div class="name-avatar d-flex align-items-center pr-2">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 box-shadow" width="50" height="50" alt="">
										</div>
										<div class="txt">
											<span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7"><?php echo $row['Department']; ?></span>
											<div class="font-14 weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
											<div class="font-12 weight-500" data-color="#b2b1b6"><?php echo $row['EmailId']; ?></div>
										</div>
									</div>
									<div class="font-12 weight-500" data-color="#17a2b8"><?php echo $row['Phonenumber']; ?></div>
								</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">STUDENT APPLICATIONS</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">STUDENT NAME</th>
								<th>APPLIED DATE</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<?php 
								$status=1;
								$sql = "SELECT tblleave.id as lid,tblemployees.FirstName,tblemployees.LastName,tblemployees.emp_id,tblemployees.Gender,tblemployees.Phonenumber,tblemployees.EmailId,tblemployees.Av_leave,tblemployees.Position_Staff,tblemployees.Staff_ID,tblleave.LeaveType,tblleave.ToDate,tblleave.FromDate,tblleave.PostingDate,tblleave.RequestedDays,tblleave.DaysOutstand,tblleave.Sign,tblleave.WorkCovered,tblleave.HodRemarks,tblleave.RegRemarks,tblleave.HodSign,tblleave.RegSign,tblleave.HodDate,tblleave.RegDate,tblleave.num_days from tblleave join tblemployees on tblleave.empid=tblemployees.emp_id where tblleave.HodRemarks= '$status' order by lid desc limit 5";
									$query = mysqli_query($conn, $sql) or die(mysqli_error());
									while ($row = mysqli_fetch_array($query)) {
									  $cnt=1;
								 ?>  

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="txt mr-2 flex-shrink-0">
											<b><?php echo htmlentities($cnt);?></b>
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['FirstName']." ".$row['LastName'];?></div>
										</div>
									</div>
								</td>
	                            <td><?php echo $row['PostingDate']; ?></td>
								
								<td>
										<div class="table-actions">
											<a title="View" href="app_details.php?leaveid=<?php echo $row['lid']; ?>"><i class="dw dw-eye"></i></a>
										</div>
									</div>
								</td>
							</tr>
							<?php $cnt++; }?>
						</tbody>
					</table>
			   </div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>