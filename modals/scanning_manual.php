User
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
  function handleKeyPress(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      const partCode = document.getElementById('part-code').value;
      if (partCode) {
        fetchPartData(partCode);
        $('#part-name').prop('disabled', true);
      }
    }
  }

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
          validateForm(); // Check if form is valid to enable save button
        } else {
          $('#part-name').val('');
          $('#quantity').val('');
          validateForm(); // Check if form is valid to enable save button
          alert('Part not found!');
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        alert('Error fetching part data.');
      }
    });
  }

  function validateForm() {
    const partName = $('#part-name').val().trim();
    const quantity = $('#quantity').val().trim();
    const inventoryType = $('#inventory_type').val();
    const section = $('#section_initial2').val();
    const location = $('#location_name_initial2').val();

    // Check if any required field is empty
    if (partName !== '' && quantity !== '' && inventoryType !== '' && section !== '' && location !== '') {
      $('#save-btn').prop('disabled', false);
    } else {
      $('#save-btn').prop('disabled', true);
    }
  }
  $(document).ready(function () {
    // Disable save button initially
    $('#save-btn').prop('disabled', true);
    $('#part-code').prop('disabled', true); // Disable part code initially

    $('#location_name_initial2').change(function () {
      const locationSelected = $(this).val();
      if (locationSelected) {
        $('#part-code').prop('disabled', false); // Enable part code if location is selected
        validateForm(); // Validate form on location change
      } else {
        $('#part-code').prop('disabled', true); // Disable part code if no location is selected
        $('#save-btn').prop('disabled', true); // Disable save button if no location is selected
      }
    });

    $('#part-name, #quantity').on('input', validateForm); // Check form validity on input change

    $('#save-btn').click(function () {
      const partCode = document.getElementById('part-code').value;
      const partName = document.getElementById('part-name').value;
      const newQuantity = document.getElementById('quantity').value;

      const inventoryType = $('#inventory_type').val();
      const section = $('#section_initial2').val();
      const location = $('#location_name_initial2').val();

      const pcname = $('#pcname').val();
      const ip = $('#ip').val();

      // Get current date and time
      const now = new Date();
      const formattedDateTime = now.toLocaleString(); // Format the date and time

      // Simulate updating the table directly without database update
      Swal.fire({
        icon: 'success',
        title: 'Successfully Recorded',
        showConfirmButton: false,
        timer: 1500
      }).then(() => {
        // Update the table
        const newRow = `<tr data-part-code="${partCode}">
                  <td>${partCode}</td>
                  <td>${partName}</td>
                  <td>${newQuantity}</td>
                  <td>${inventoryType}</td>
                  <td>${section}</td>
                  <td>${location}</td>
                  <td>${pcname}</td>
                  <td>${ip}</td>
                  <td>${formattedDateTime}</td>
               </tr>`;
        $(`#saved-data tr[data-part-code="${partCode}"]`).remove();
        $('#saved-data').prepend(newRow);
      });
    });

    $('#clear-btn').click(function () {
      // Clear the input fields
      $('#part-code').val('');
      $('#part-name').val('');
      $('#quantity').val('');

      // Reset the section and location dropdowns to their default values
      $('#section_initial2').val('');
      $('#location_name_initial2').val('');

      // Clear the table content
      $('#saved-data').empty();

      // Ensure that Inventory Type and Part Name remain enabled
      $('#inventory_type').prop('disabled', false);
      $('#part-name').prop('disabled', false);

      // Validate the form after clearing
      validateForm();
    });
  });

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-Kmcd4Hzh9EDCXzftf8witAW1M32jOl4l/UfDl+s9dQI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleKeyPress(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
    const partCode = document.getElementById('part-code').value;
    if (partCode) {
      fetchPartData(partCode);
      }
    }
  }

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
            validateForm(); // Check if form is valid to enable save button
          } else {
            $('#part-name').val('');
            $('#quantity').val('');
            validateForm(); // Check if form is valid to enable save button
            alert('Part not found!');
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          alert('Error fetching part data.');
        }
      });
  }

    function validateForm() {
    const partName = $('#part-name').val().trim();
    const quantity = $('#quantity').val().trim();
    const inventoryType = $('#inventory_type').val();
    const section = $('#section_initial2').val();
    const location = $('#location_name_initial2').val();

    // Check if any required field is empty
    if (partName !== '' && quantity !== '' && inventoryType !== '' && section !== '' && location !== '') {
      $('#save-btn').prop('disabled', false);
    } else {
      $('#save-btn').prop('disabled', true);
    }
  }

    $(document).ready(function () {
      // Disable save button initially
      $('#save-btn').prop('disabled', true);
    $('#part-code').prop('disabled', true); // Disable part code initially

    $('#location_name_initial2').change(function () {
      const locationSelected = $(this).val();
    if (locationSelected) {
      $('#part-code').prop('disabled', false); // Enable part code if location is selected
    validateForm(); // Validate form on location change
      } else {
      $('#part-code').prop('disabled', true); // Disable part code if no location is selected
    $('#save-btn').prop('disabled', true); // Disable save button if no location is selected
      }
    });

    $('#part-name, #quantity').on('input', validateForm); // Check form validity on input change

    $('#save-btn').click(function () {
    const partCode = document.getElementById('part-code').value;
    const partName = document.getElementById('part-name').value;
    const newQuantity = document.getElementById('quantity').value;

    const inventoryType = $('#inventory_type').val();
    const section = $('#section_initial2').val();
    const location = $('#location_name_initial2').val();

    const pcname = $('#pcname').val();
    const ip = $('#ip').val();

    const now = new Date();
    const formattedDateTime = now.toLocaleString();

    // Send data to PHP script using AJAX
    $.ajax({
      url: 'process/save_to_database.php', // Path to your PHP script
    method: 'POST',
    data: {
      partCode: partCode,
    partName: partName,
    newQuantity: newQuantity,
    inventoryType: inventoryType,
    section: section,
    location: location,
    pcname: pcname,
    ip: ip,
    formattedDateTime: formattedDateTime
            },
    success: function (response) {
      // Handle success response
      console.log(response); // Log response for debugging

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
      <td>${pcname}</td>
      <td>${ip}</td>
      <td>${formattedDateTime}</td>
    </tr>`;
    $(`#saved-data tr[data-part-code="${partCode}"]`).remove();
    $('#saved-data').prepend(newRow);
                });
            },
    error: function (xhr, status, error) {
      // Handle error
      console.error(xhr.responseText);
    alert('Error saving data to database.');
            }
        });
});


    $('#clear-btn').click(function () {
      // Clear the input fields
      $('#part-code').val('');
    $('#part-name').val('');
    $('#quantity').val('');

    // Reset the inventory dropdown to the default option
    $('#inventory_type').val('');

    // Reset the section and location dropdowns to their default values
    $('#section_initial2').val('');
    $('#location_name_initial2').val('');

    // Clear the table content
    $('#saved-data').empty();

    // Ensure that Inventory Type and Part Name remain enabled
    $('#inventory_type').prop('disabled', false);
    $('#part-name').prop('disabled', false);

    // Validate the form after clearing
    validateForm();
});
  });
</script>