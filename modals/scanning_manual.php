<div class="modal fade" id="scanning_manual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Manual Scanning</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>

         <input type="hidden" name="pcname" id="pcname" value="<?= gethostbyaddr($_SERVER['REMOTE_ADDR']); ?>">
         <input type="hidden" name="ip" id="ip" value="<?= $_SERVER['REMOTE_ADDR']; ?>">

         <div class="modal-body">
            <div class="row">
               <div class="col-4">
                  <label>Inventory Type</label>
                  <select id="inventory_type" class="form-control" onchange="inventory_type_check()">
                     <option value="">Select Type</option>
                     <option value="Initial">Initial</option>
                     <option value="Final">Final</option>
                  </select>
               </div>
               <div class="col-4">
                  <label>Section:</label>
                  <select id="section_initial2" class="form-control" onchange="section_check()" disabled>
                     <option value="">Select Section</option>
                  </select>
               </div>
               <div class="col-4">
                  <label>Location:</label>
                  <select id="location_name_initial2" class="form-control" onchange="location_check()" disabled>
                     <option value="">Select Location</option>
                  </select>
               </div>
            </div>
            <div class="row">
               <div class="col-4">
                  <label for="part-code">Part code</label>
                  <input type="input" id="part-code" class="form-control" style="height: 50%;"
                     onkeypress="handleKeyPress(event)">
               </div>
               <div class="col-4">
                  <label for="part-name">Part Name</label>
                  <input type="input" id="part-name" class="form-control" style="height: 50%;"
                     onkeypress="handleKeyPress(event)">
               </div>
               <div class="col-4">
                  <label for="quantity">Quantity</label>
                  <input type="input" id="quantity" class="form-control" style="height: 50%;"
                     onkeypress="handleKeyPress(event)">
               </div>
               <div class="col-2">
                  <label style="color: white; visibility: hidden;">Save</label>
                  <button type="button" id="save-btn" class="btn btn-success btn-block"
                     style="height: 50%; margin-top: 0;">Save</button>
               </div>
               <div class="col-2">
                  <label style="color: white; visibility: hidden;">Clear</label>
                  <button type="button" id="clear-btn" class="btn btn-danger btn-block"
                     style="height: 50%; margin-top: 0;">Clear</button>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <div class="card-body table-responsive p-0" style="height: 400px;">
               <table class="table table-head-fixed text-nowrap table-hover">
                  <thead style="text-align:center;">
                     <tr>
                        <td>Part Code</td>
                        <td>Part Name</td>
                        <td>Verified QTY</td>
                        <td>Type</td>
                        <td>Section</td>
                        <td>Location</td>
                        <td>PC Name</td>
                        <td>IP Address</td>
                        <td>Time and Date</td>
                     </tr>
                  </thead>
                  <tbody style="text-align:center;" id="saved-data"></tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>



<script>
$(document).ready(function () {
    // Initialize save button as disabled
    $('#save-btn').prop('disabled', true);
    $('#part-code').prop('disabled', true);

    // Enable part-code input when location is selected
    $('#location_name_initial2').change(function () {
        const locationSelected = $(this).val();
        if (locationSelected) {
            $('#part-code').prop('disabled', false);
            validateForm();
        } else {
            $('#part-code').prop('disabled', true);
            $('#save-btn').prop('disabled', true);
        }
    });

    // Validate form on input change
    $('#part-name, #quantity').on('input', validateForm);

    // Handle save button click
    $('#save-btn').click(function () {
        const partCode = $('#part-code').val();
        const partName = $('#part-name').val();
        const newQuantity = $('#quantity').val();
        const inventoryType = $('#inventory_type').val();
        const section = $('#section_initial2').val();
        const location = $('#location_name_initial2').val();
        const pcname = $('#pcname').val();
        const ip = $('#ip').val();
        const now = new Date();
        const formattedDateTime = now.toLocaleString();

        // Validate quantity input
        if (isNaN(newQuantity) || newQuantity === '') {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Quantity',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        // Check if part code already exists in the database
        $.ajax({
            url: 'process/check_part_code.php',
            method: 'POST',
            data: { partCode: partCode },
            dataType: 'json',
            success: function (response) {
                if (response.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Part Code already exists',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: response.error,
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    // Save data if part code does not exist
                    savePartData({
                        partCode: partCode,
                        partName: partName,
                        newQuantity: newQuantity,
                        inventoryType: inventoryType,
                        section: section,
                        location: location,
                        pcname: pcname,
                        ip: ip,
                        formattedDateTime: formattedDateTime
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error checking part code.',
                    text: xhr.responseText,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });

    // Handle clear button click
    $('#clear-btn').click(function () {
        clearForm();
    });
});

// Save part data to the database
function savePartData(data) {
    $.ajax({
        url: 'process/save_to_database.php',
        method: 'POST',
        data: data,
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Successfully Recorded',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                const newRow = `<tr data-part-code="${data.partCode}">
                    <td>${data.partCode}</td>
                    <td>${data.partName}</td>
                    <td>${data.newQuantity}</td>
                    <td>${data.inventoryType}</td>
                    <td>${data.section}</td>
                    <td>${data.location}</td>
                    <td>${data.pcname}</td>
                    <td>${data.ip}</td>
                    <td>${data.formattedDateTime}</td>
                </tr>`;
                $(`#saved-data tr[data-part-code="${data.partCode}"]`).remove();
                $('#saved-data').prepend(newRow);

                clearForm();
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error saving data to database.',
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

// Clear form inputs
function clearForm() {
    $('#part-code').val('');
    $('#part-name').val('');
    $('#quantity').val('');
    $('#inventory_type').val('');
    $('#section_initial2').val('');
    $('#location_name_initial2').val('');
    $('#saved-data').empty();
    validateForm();
}

// Handle enter key press for part-code input
function handleKeyPress(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const partCode = document.getElementById('part-code').value;
        if (partCode) {
            fetchPartData(partCode);
        }
    }
}

// Fetch part data based on part code
function fetchPartData(partCode) {
    $.ajax({
        url: 'process/fetch_part_data.php',
        type: 'POST',
        data: { part_code: partCode },
        success: function (response) {
            const data = JSON.parse(response);
            if (data.length > 0) {
                const partName = data[0].parts_name;
                const quantity = data[0].quantity;
                $('#part-name').val(partName);
                $('#quantity').val(quantity);
                validateForm();
            } else {
                $('#part-name').val('');
                $('#quantity').val('');
                validateForm();
                Swal.fire({
                    icon: 'info',
                    title: 'Part Code not found!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error fetching part data.',
                text: xhr.responseText,
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

// Validate form fields
function validateForm() {
    const partName = $('#part-name').val().trim();
    const quantity = $('#quantity').val().trim();
    const inventoryType = $('#inventory_type').val();
    const section = $('#section_initial2').val();
    const location = $('#location_name_initial2').val();

    if (partName !== '' && quantity !== '' && inventoryType !== '' && section !== '' && location !== '') {
        $('#save-btn').prop('disabled', false);
    } else {
        $('#save-btn').prop('disabled', true);
    }
}

</script>








