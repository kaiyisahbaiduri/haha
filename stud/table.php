<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'];
	$sql = "DELETE FROM tblemployees where emp_id = ".$delete;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "<script>alert('Student Deleted Successfully');</script>";
     	echo "<script type='text/javascript'> document.location = 'app_history.php'; </script>";
		
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
		<div class="pd-ltr-20">

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">ALL MY APPLICATION</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
							<th>APPLIED DATE</th>
								
								<th>COORDINATOR STATUS</th>
								<th>HOD STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								
								 <?php 
                                    $sql = "SELECT * from tblleave where empid = '$session_id'";
                                    $query = $dbh -> prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0)
                                    {
                                    foreach($results as $result)
                                    {               ?>  

								  <td><?php echo htmlentities($result->PostingDate);?></td>
                                  
                                  <td><?php $stats=$result->HodRemarks;
                                       if($stats==1){
                                        ?>
                                           <span style="color: green">Verified</span>
                                            <?php } if($stats==2)  { ?>
                                           <span style="color: red">Unverified</span>
                                            <?php } if($stats==0)  { ?>
	                                       <span style="color: blue">Pending</span>
	                                       <?php } ?>

                                    </td>
                                    <td><?php $stats=$result->RegRemarks;
                                       if($stats==1){
                                        ?>
                                           <span style="color: green">Verified</span>
                                            <?php } if($stats==2)  { ?>
                                           <span style="color: red">Unverified</span>
                                            <?php } if($stats==0)  { ?>
	                                       <span style="color: blue">Pending</span>
	                                       <?php } ?>

                                    </td>
								   <td>
									  <div class="table-actions">
										<a title="VIEW" href="view_aaa.php?edit=<?php echo htmlentities($result->id);?>" data-color="#265ed7"><i class="icon-copy dw dw-eye"></i></a>
									  </div>
								   </td>
							</tr>
							<?php $cnt++;} }?>  
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