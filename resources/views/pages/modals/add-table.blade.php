
<!-- Modal -->
<div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add table</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="small mb-1" for="inputEmailAddress">Table capacity</label>
                    <input v-model="capacity" class="form-control py-4" min="1" type="number" aria-describedby="emailHelp" placeholder="Enter table capacity" /></div>

                <div class="form-group">
                    <label class="small mb-1" for="inputEmailAddress">Table Availability</label>
                    <select v-model="selected" class="form-control" name="" id="">
                        <option value="Available">Available</option>
                        <option value="Occupied">Occupied</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button v-if="isUpdate==false" type="button" @click="save" class="btn btn-primary">Save</button>
                <button v-else type="button" @click="updateTable" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
