<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
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
							Welcome back <div class="weight-600 font-30 text-blue"><?php echo $row['FirstName']. " " .$row['LastName']; ?>,</div>
						</h4>
						<p class="font-18 max-width-600">To META Credit Transfer System</p>
					</div>
				</div>
			</div>
			<div class="title pb-20">
				<h2 class="h3 mb-0">Data Information</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT emp_id from tblemployees";
						$query = $dbh -> prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$empcount=$query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($empcount);?></div>
								<div class="font-14 text-secondary weight-500">Overall Total </div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				
				
			
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">Head of Department</div>
							<div class="table-actions">
								<a title="VIEW" href="hod.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>
						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees where role='HOD' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
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
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">Coordinators</div>
							<div class="table-actions">
								<a title="VIEW" href="coor.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>
						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees where role='Coordinator' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
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
							<div class="h5 mb-0">Students</div>
							<div class="table-actions">
								<a title="VIEW" href="stud.php"><i class="icon-copy ion-disc" data-color="#17a2b8"></i></a>	
							</div>
						</div>

						<div class="user-list">
							<ul>
								<?php
		                         $query = mysqli_query($conn,"select * from tblemployees where role = 'Student' ORDER BY tblemployees.emp_id desc limit 4") or die(mysqli_error());
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

			

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>