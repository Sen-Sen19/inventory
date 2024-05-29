<div class="modal fade" id="edit_qty_initial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Update Quantity</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-3">
            <input type="hidden" id="id_update_qty_initial" class="form-control">
            <label>Location Code:</label>
            <input type="text" id="line_no_update_initial" class="form-control" readonly>
          </div>
          <div class="col-3">
            <label>Part Code:</label>
            <input type="text" id="parts_code_update_initial" class="form-control" readonly>
          </div>
          <div class="col-3">
            <label>Part Name:</label>
            <input type="text" id="parts_name_update_initial" class="form-control" readonly>
          </div>
          <div class="col-3">
            <label>Quantity:</label>
            <input type="number" id="qty_update_initial" class="form-control">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="update_qty_initial()">Save changes</button>
      </div>
    </div>
  </div>
</div>