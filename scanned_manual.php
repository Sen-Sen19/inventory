<?php include 'tools/navbar_manual.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .main-sidebar {
            width: 250px; /* Default width */
            transition: width 0.3s;
        }

        .main-sidebar.minimized {
            width: 80px; /* Minimized width */
        }

        .content-wrapper {
            transition: margin-left 0.3s;
            margin-left: 250px; /* Default margin to accommodate the sidebar */
             /* Adjust the top margin */
        }

        .content-wrapper.minimized {
            margin-left: 80px; /* Adjusted margin for minimized sidebar */
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Additional styling */
        .brand-link, .nav-link, .card-body, .table {
            font-family: Arial, sans-serif;
        }
        #searchButton {
        background-color: #007bff; /* Blue color */
        color: #fff;
    }

    #searchButton:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }
    .thead-sticky {
            position: sticky;
            top: 0;
            z-index: 1; /* Ensure the header appears above the table content */
            background-color: #333; /* Background color for the sticky header */
            color: #fff; /* Text color for the sticky header */
        }
        .form1{

            background-color:#f8f8f8;
            padding:30px;
           
        }
        .form2{
            background-color: #17a2b8;
            padding-top:20px;
            
          

        }
        
    </style>
</head>
<body>
    <!-- Sidebar -->
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



    <!-- Content Wrapper -->
    <div class="form2">
    <div class="form1">
   
    <div class="content-wrapper">
    <div class="container mt-3">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by Part Code" id="searchInput">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="Search()" id="searchButton"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="#" class="btn btn-warning" onclick="refreshPage()">Refresh <i class="fas fa-undo"></i></a>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 70vh;">
    <table class="table table-striped table-bordered table-hover table-sm">
                <thead class="thead-dark text-center thead-sticky">
                    <tr>
                        <th>ID</th>
                        <th>Parts Code</th>
                        <th>Parts Name</th>
                        <th>Date and Time</th>
                        <th>Inventory Type</th>
                        <th>Section</th>
                        <th>Location</th>
                        <th>Verified Quantity</th>
                    </tr>
                </thead>
                <tbody id="list_of_scanned_admin" class="text-center">
                    <?php include 'process/admin_manual_fetch.php'; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">

                        <div class="form-group">
                            <label for="partCode">Part Code</label>
                            <input type="text" class="form-control" id="partCode" readonly>
                        </div>
                        <div class="form-group">
                            <label for="partName">Part Name</label>
                            <input type="text" class="form-control" id="partName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="quantity">location</label>
                            <input type="text" class="form-control" id="location" readonly>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Pagination -->



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize modal instance
    const modalElement = document.getElementById('myModal');
    const modal = new bootstrap.Modal(modalElement);

    // Function to clear modal content
    function clearModal() {
        document.getElementById('location').value = '';
        document.getElementById('partCode').value = '';
        document.getElementById('partName').value = '';
        document.getElementById('quantity').value = '';
    }

    // Function to fetch and update table data
    function updateTableData() {
        fetch('process/admin_manual_fetch.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('list_of_scanned_admin').innerHTML = data;
                attachRowClickEvent(); // Reattach event listeners after updating table data
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    // Function to attach click event to table rows
    function attachRowClickEvent() {
        const rows = document.querySelectorAll('#list_of_scanned_admin tr');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                const cells = row.getElementsByTagName('td');
                const location = cells[6].innerText;
                const partCode = cells[1].innerText;
                const partName = cells[2].innerText;
                document.getElementById('location').value = location;
                document.getElementById('partCode').value = partCode;
                document.getElementById('partName').value = partName;
                modal.show();
            });
        });
    }

    // Initial attachment of event listeners
    attachRowClickEvent();

    // Handle form submission
    const form = document.getElementById('updateForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
       
        const partCode = document.getElementById('partCode').value;
        const partName = document.getElementById('partName').value;
        const location = document.getElementById('location').value;
        const quantity = document.getElementById('quantity').value;
        fetch('process/update_record.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    location: location,
                    partCode: partCode,
                    partName: partName,
                    quantity: quantity,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Save',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        modal.hide();
                        clearModal();
                        updateTableData();
                    });
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Function to handle search
    const searchButton = document.getElementById('searchButton');
    searchButton.addEventListener('click', Search);

    // Function to refresh page
    const refreshButton = document.querySelector('.btn.btn-warning');
    refreshButton.addEventListener('click', refreshPage);

    // Function to handle search
    function Search() {
        var search = document.getElementById('searchInput').value.trim();
        $.ajax({
            type: "POST",
            url: "process/admin_manual_fetch.php",
            data: {
                method: "Search",
                search: search

            },

            success: function(response) {
                document.getElementById('list_of_scanned_admin').innerHTML = response;
                attachRowClickEvent(); // Reattach event listeners after updating table data
            }
        });
    }
});

function refreshPage() {
    location.reload();
}


</script>


</body>
</html>

<?php include 'tools/manual_scanned_footer.php'; ?>
