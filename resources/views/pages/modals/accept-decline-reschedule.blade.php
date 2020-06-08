
<!-- Modal -->
<div class="modal fade" id="acceptDeclineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="small mb-1" for="inputEmailAddress">Booking status</label>
                    <select v-model="selected" class="form-control" >
                        <option value="accepted">Accept</option>
                        <option value="declined">Decline</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" @click="updateBooking" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
