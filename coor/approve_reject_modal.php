
<div id="approve_<?php echo $row['id']; ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Verify Subject</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to verify this subject?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="approveRecord(<?php echo $row['id']; ?>)">Verify</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="reject_<?php echo $row['id']; ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reject Subject</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this subject?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="rejectRecord(<?php echo $row['id']; ?>)">Reject</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


