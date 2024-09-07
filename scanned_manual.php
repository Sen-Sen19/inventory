<?php include 'tools/navbar_manual.php'; ?>
<style>
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .custom-modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .custom-close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .custom-close:hover,
    .custom-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }


    @media screen and (max-width: 768px) {
        .custom-modal-content {
            width: 95%;
            margin: 10% auto;
        }

        .custom-close {
            font-size: 24px;/
        }
    }

    @media screen and (max-width: 480px) {
        .custom-modal-content {
            width: 100%;
            margin: 15% auto;
        }

        .custom-close {
            font-size: 20px;
        }
    }
</style>
<aside class="main-sidebar sidebar-dark-info elevation-4">
    <a href="#" class="brand-link" id="sidebarToggle">
        <img src="dist/img/logo.ico" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Inventory (Manual)</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="parts.php" class="nav-link">
                        <i class="fa fa-barcode"></i>
                        <p>Parts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="scanned_manual.php" class="nav-link active">
                        <i class="fas fa-user-cog"></i>
                        <p>List of Scanned</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Menu</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="col-sm-12">
            <div class="card card-gray-dark card-outline">
                <div class="card-header">
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 col-sm-3">
                                    <label style="font-weight: bold;">Search Partcode</label>
                                    <input id="spartname" class="form-control" name="shift" type="text"
                                        placeholder="Enter Parts Code..." style="height: 31px; font-size: 14px;">
                                </div>
                                <div class="col-6 col-sm-2">
                                    <label style="visibility:hidden;">Search</label>
                                    <button class="btn btn-primary btn-block btn-sm" id="searchBtn">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-bordered" style="border-collapse: collapse;">
                            <thead
                                style="position: sticky; top: 0; background-color:#696a6a; color: white; z-index: 10;">
                                <tr>
                                    <th>#</th>
                                    <th>Part Code</th>
                                    <th>Part Name</th>
                                    <th>Scan Date/Time</th>
                                    <th>Inventory Type</th>
                                    <th>Section</th>
                                    <th>Location</th>
                                    <th>Verified Qty</th>
                                </tr>
                            </thead>
                            <tbody id="data-table-body">
                                <?php include 'process/manual_fetch.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="customModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close">&times;</span>

        <form id="modalForm">
            <div class="mb-3">
                <label for="partName" class="form-label"><strong>Part Name:</strong></label>
                <p id="modalPartName" class="form-control-plaintext"></p>
            </div>
            <div class="mb-3">
                <label for="partCode" class="form-label"><strong>Part Code:</strong></label>
                <p id="modalPartCode" class="form-control-plaintext"></p>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label"><strong>Location:</strong></label>
                <p id="modalLocation" class="form-control-plaintext"></p>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label"><strong>Quantity:</strong></label>
                <input type="number" class="form-control" id="modalQuantity" min="0" step="1">
            </div>
        </form>
        <button type="button" class="btn btn-success" id="saveChanges">Update</button>
        <button type="button" class="btn btn-secondary" id="closeModal">Cancel</button>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableBody = document.getElementById('data-table-body');
        const modal = document.getElementById('customModal');
        const closeModalBtn = document.getElementById('closeModal');
        const saveChangesBtn = document.getElementById('saveChanges');
        tableBody.addEventListener('click', function (event) {
            const clickedRow = event.target.closest('tr');
            if (clickedRow) {
                const partName = clickedRow.cells[2].textContent;
                const partCode = clickedRow.cells[1].textContent;
                const location = clickedRow.cells[6].textContent;
                const quantity = clickedRow.cells[7].textContent;
                document.getElementById('modalPartName').textContent = partName;
                document.getElementById('modalPartCode').textContent = partCode;
                document.getElementById('modalLocation').textContent = location;
                document.getElementById('modalQuantity').value = quantity;
                modal.style.display = 'block';
                window.clickedRow = clickedRow;
            }
        });
        closeModalBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });
        saveChangesBtn.addEventListener('click', function () {

            const partCode = document.getElementById('modalPartCode').textContent;
            const newQuantity = document.getElementById('modalQuantity').value;


            if (newQuantity === '' || newQuantity < 0) {
                Swal.fire({
                    title: 'Invalid Input',
                    text: 'Please enter a valid quantity.',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 500
                });
                return;
            }
            fetch('process/manual_update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    partCode: partCode,
                    quantity: newQuantity,
                    location: document.getElementById('modalLocation').textContent,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {

                        Swal.fire({
                            title: 'Success',
                            text: 'Quantity updated successfully!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {

                            if (window.clickedRow) {
                                window.clickedRow.cells[7].textContent = newQuantity;
                            }
                            modal.style.display = 'none';
                            // window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed',
                            text: 'Failed to update the quantity. Please try again.',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'An unexpected error occurred.',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
        });
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    });
</script>



<?php include 'tools/manual_scanned_footer.php'; ?>