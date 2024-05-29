<div class="modal fade" id="scanning" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <div class="col-3"></div>
          <div class="col-3">          
            <span> Section:   </span>   
            <select id="section_name" class="form-control" onchange="section_check()">
              <option value="">Select Section</option>
            </select>          
          </div>
           <div class="col-3">
            <span> Location:   </span> 
             <select id="line_names" class="form-control" onclick="location_check_final()">
               <option value="">Select Location</option>
             </select>
          </div>
          <div class="col-3"></div>
        </div>
        <div class="row">
          <div class="col-12">
            <label>Scan:</label>
              <input type="password" id="kanban_no" class="form-control" style="height: 70%;" onchange="scanned()">
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
    <tbody style="text-align:center;" id="date_prev_scanned"></tbody>
    </table>
    </div>
      </div>
    </div>
  </div>
</div>