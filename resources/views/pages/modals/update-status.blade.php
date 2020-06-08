
<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="small mb-1" for="inputEmailAddress">Booking status</label>
                        <select v-model="selected" class="form-control" @change="updateSelection">
                            <option value="pending">Pending</option>
                            <option value="accepted">Accept</option>
                            <option value="declined">Decline</option>
                            <option value="rescheduled">Reschedule</option>
                        </select>
                    </div>
                    <div  :class="selected=='rescheduled' ? '' : 'd-none'">
                        <div class="form-group"> <!-- Date input -->
                            <label class="control-label" for="date">Date</label>
                            <input autocomplete="off" v-model="booking.date" class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
                        </div>

                        <label class="control-label" for="date">Time</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input  id="timepicker1" type="text" class="form-control input-small">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" @click="updateStatus" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
