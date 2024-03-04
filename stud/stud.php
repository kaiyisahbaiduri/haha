<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'];
	$sql = "DELETE FROM tblemployees where emp_id = ".$delete;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "<script>alert('Student Deleted Successfully');</script>";
     	echo "<script type='text/javascript'> document.location = 'stud.php'; </script>";
		
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
								<h4>Update Form</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Update Form</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">ALL APPLICATION</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">FULL NAME</th>
								<th>EMAIL</th>
								<th>DEPARTMENT</th>
								<th>POSITION</th>
								
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								 <?php
		                         $teacher_query = mysqli_query($conn,"select * from tblemployees LEFT JOIN tbldepartments ON tblemployees.Department = tbldepartments.DepartmentShortName where role = 'Student' ORDER BY tblemployees.emp_id") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($teacher_query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
										</div>
									</div>
								</td>
								<td><?php echo $row['EmailId']; ?></td>
	                            <td><?php echo $row['DepartmentName']; ?></td>
								<td><?php echo $row['Position_Staff']; ?></td>
								
								<td>
									<div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="edit_stud.php?edit=<?php echo $row['emp_id'];?>"><i class="dw dw-edit2"></i> Edit</a>
											<a class="dropdown-item" href="stud.php?delete=<?php echo $row['emp_id'] ?>"><i class="dw dw-delete-3"></i> Delete</a>
										</div>
									</div>
								</td>
							</tr>
							<?php } ?>  
						</tbody>
					</table>
			   </div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
								 </div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>