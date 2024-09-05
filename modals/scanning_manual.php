<div class="modal fade" id="scanning_manual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Manual Scanning</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

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
                        <input type="input" id="part-code" class="form-control" style="height: 50%;">
                    </div>
                    <div class="col-4">
                        <label for="part-name">Part Name</label>
                        <input type="input" id="part-name" class="form-control" style="height: 50%;">
                    </div>
                    <div class="col-4">
                        <label for="quantity">Quantity</label>
                        <input type="input" id="quantity" class="form-control" style="height: 50%;">
                    </div>
                    <div class="col-2">
                        <label style="color: white; visibility: hidden;">Save</label>
                        <button type="button" id="save-btn" class="btn btn-success btn-block" style="height: 50%; margin-top: 0;">Save</button>
                    </div>
                    <div class="col-2">
                        <label style="color: white; visibility: hidden;">Refresh</label>
                        <button type="button" id="refresh-btn" class="btn btn-danger btn-block" style="height: 50%; margin-top: 0;">Refresh</button>
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
    $('#save-btn').prop('disabled', true);
    $('#part-code').prop('disabled', true);

    $('#location_name_initial2').change(function () {
        const locationSelected = $(this).val();
        $('#part-code').prop('disabled', !locationSelected);
        validateForm();
    });

    $('#part-code, #part-name, #quantity').on('input', validateForm);

    $('#save-btn').click(function () {
        const partCode = $('#part-code').val();
        const partName = $('#part-name').val();
        const newQuantity = $('#quantity').val();
        const inventoryType = $('#inventory_type').val();
        const section = $('#section_initial2').val();
        const location = $('#location_name_initial2').val();
        const ip = $('#ip').val();
        const now = new Date();
        const formattedDateTime = now.toLocaleString();

        if (isNaN(newQuantity) || newQuantity === '') {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Quantity',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        $.ajax({
            url: 'process/check_duplicate.php',
            method: 'POST',
            data: {
                partCode: partCode,
                location: location
            },
            success: function (response) {
                const result = JSON.parse(response);

                if (result.status === 'duplicate') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Entry',
                        text: 'This part code and location combination already exists.',
                        showConfirmButton: false,
                        timer: 2500
                    });
                } else if (result.status === 'not_duplicate') {
                    saveDataToDatabase(partCode, partName, newQuantity, inventoryType, section, location, ip, formattedDateTime);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error checking duplicate data.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });

    $('#refresh-btn').click(function () {
        location.reload();
    });

    $('#part-code').keypress(function (event) {
        if (event.which === 13) {
            event.preventDefault();
            const partCode = $('#part-code').val();
            if (partCode) {
                fetchPartData(partCode);
                $('#part-code').prop('disabled', true);
            }
        }
    });

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
                } else {
                    $('#part-name').val('');
                    $('#quantity').val('');
                    Swal.fire({
                        icon: 'info',
                        title: 'Part Code not found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                validateForm();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error fetching part data.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    function saveDataToDatabase(partCode, partName, newQuantity, inventoryType, section, location, ip, formattedDateTime) {
        $.ajax({
            url: 'process/save_to_database.php',
            method: 'POST',
            data: {
                partCode: partCode,
                partName: partName,
                newQuantity: newQuantity,
                inventoryType: inventoryType,
                section: section,
                location: location,
                ip: ip,
                formattedDateTime: formattedDateTime
            },
            success: function (response) {
                console.log(response);

                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Recorded',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    const newRow = `<tr data-part-code="${partCode}">
                        <td>${partCode}</td>
                        <td>${partName}</td>
                        <td>${newQuantity}</td>
                        <td>${inventoryType}</td>
                        <td>${section}</td>
                        <td>${location}</td>
                        <td>${ip}</td>
                        <td>${formattedDateTime}</td>
                    </tr>`;
                    $(`#saved-data tr[data-part-code="${partCode}"]`).remove();
                    $('#saved-data').prepend(newRow);

                    $('#part-code').val('');
                    $('#part-name').val('');
                    $('#quantity').val('');
                    $('#part-code').prop('disabled', false);

                    validateForm();
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error saving data to database.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    function validateForm() {
        const partCode = $('#part-code').val().trim();
        const partName = $('#part-name').val().trim();
        const quantity = $('#quantity').val().trim();
        const inventoryType = $('#inventory_type').val();
        const section = $('#section_initial2').val();
        const location = $('#location_name_initial2').val();

        if (partCode && partName && quantity && inventoryType && section && location) {
            $('#save-btn').prop('disabled', false);
        } else {
            $('#save-btn').prop('disabled', true);
        }
    }
});
</script>
