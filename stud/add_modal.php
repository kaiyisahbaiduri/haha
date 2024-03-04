<!-- Add New -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Add New</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="add.php">
				<div class="row form-group">
				<div class="col-md-10 col-sm-12">
										<div class="form-group">
											<label>Degree Subject:</label>
											<select name="firstname" class="custom-select form-control" autocomplete="off">
												<option value="">Select Subject</option>
												<option value="MES3023">MES3023</option>
												<option value="MTS3033">MTS3033</option>
												<option value="MES3043">MES3043</option>
											</select>
										</div>
									</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-10">
						<label class="control-label modal-label">Diploma Subject:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="lastname" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-10">
						<label class="control-label modal-label">Diploma Subject:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="address" required>
					</div>
				</div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
			</form>
            </div>

        </div>
    </div>
</div>