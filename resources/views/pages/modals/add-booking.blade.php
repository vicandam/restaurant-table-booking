
<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Booking table</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="control-label" for="date">Select table</label>
                    <select id="select2" class="js-example-disabled-results" style="width: 100%;">
                        <option :value="table.id" :disabled="table.status==='Occupied'" v-for="table in tables">@{{  table.id +' - '+ table.status}} </option>
                    </select>

                </div>

                <div class="form-group">
                    <label class="control-label" for="date">Number of person</label>
                    <input v-model="booking.capacity" class="form-control py-4" id="inputEmailAddress" min="1" type="number" aria-describedby="emailHelp" placeholder="Enter number of person" />
                </div>

                <div class="form-group"> <!-- Date input -->
                    <label class="control-label" for="date">Date</label>
                    <input autocomplete="off" class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
                </div>

                <label class="control-label" for="date">Time</label>
                <div class="input-group bootstrap-timepicker timepicker">
                    <input  id="timepicker1" type="text" class="form-control input-small">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" @click.prevent="saveBooking" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
