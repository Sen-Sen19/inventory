<div class="modal fade" id="scanning_initial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Scanning of Barcode</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-2"></div>
            <div class="col-4">
            <span> Section:   </span> 
            <select id="section_initial" class="form-control" onchange="section_check()">
              <option value="">Select Section</option>
            </select>          
          </div>
           <div class="col-4">
            <span> Location:   </span> 
            <select id="location_name_initial" class="form-control" onchange="location_check()">
              <option value="">Select Location</option>
            </select>          
          </div>
          <div class="col-2"></div>
        </div>
        <div class="row">
          <div class="col-12">
            <label>Scan:</label>
              <input type="password" id="kanban_no_initial" class="form-control" style="height: 70%;" onchange="scanned_initial()">
          </div>
        </div>
      </div>
      <div class="modal-footer">
         <div class="card-body table-responsive p-0" style="height: 400px;">
       <table  class="table table-head-fixed text-nowrap table-hover" style="">
    <thead style="text-align:center;">
        <td>#</td>
        <td>Inventory Tag No</td>
        <td>Location Code</td>
        <td>Part Code</td>
        <td>Part Name</td>
        <td>Physical Count</td>
        <td>Verified QTY</td>   
        <td>Length</td>
    </thead>
    <tbody style="text-align:center;" id="date_prev_scanned_initial"></tbody>
    </table>
    </div>
      </div>
    </div>
  </div>
</div>