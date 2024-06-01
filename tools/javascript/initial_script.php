<script type="text/javascript">
    $(document).ready(function () {
        get_client_pc_info();
        get_section();
        get_location_name_initial();
        $('#scanning_initial').modal('show');
        document.getElementById('kanban_no_initial').disabled = true;
        document.getElementById('location_name_initial').disabled = true;
    });

    // Revisions (Vince)
    const get_client_pc_info = () => {
        $.ajax({
            url: 'process/remote.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'get_client_pc_info'
            }, success: function (data) {
                console.log(data);
            }
        });
    }

    // Revisions (Vince)
    const get_section = () => {
        $.ajax({
            url: 'process/processor_initial.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'get_section'
            }, success: function (data) {
                console.log(data);
                $('#section_initial').html(data);
            }
        });
    }

    const get_location_name_initial = () => {
        $.ajax({
            url: 'process/processor_initial.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'get_location_name_initial'
            }, success: function (data) {
                console.log(data);
                $('#location_name_initial').html(data);
            }
        });
    }

    const section_check = () => {
        var section = document.getElementById('section_initial').value;
        if (section != '') {
            document.getElementById('location_name_initial').disabled = false;
            document.getElementById('section_initial').disabled = true;
            suggest_location();
        } else {
            document.getElementById('location_name_initial').disabled = true;
            document.getElementById('section_initial').disabled = false;
        }
    }

    const suggest_location = () => {
        var section = document.getElementById('section_initial').value;
        $.ajax({
            url: 'process/processor_initial.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'get_location',
                section: section
            }, success: function (data) {
                $('#location_name_initial').html(data);
            }
        });
    }

    const location_check = () => {
        var location = document.getElementById('location_name_initial').value;
        if (location != '') {
            document.getElementById('location_name_initial').disabled = true;
            document.getElementById('kanban_no_initial').disabled = false;
            document.getElementById('section_initial').disabled = true;
        } else {
            document.getElementById('location_name_initial').disabled = false;
            document.getElementById('kanban_no_initial').disabled = false;
            document.getElementById('section_initial').disabled = true;
        }
    }

    const scanned_initial = () => {
        var kanban_no = document.getElementById('kanban_no_initial').value;
        var location = document.getElementById('location_name_initial').value;
        //var ip = document.getElementById('ip_initial').value;
        //var pc_name = document.getElementById('pc_name_initial').value;
        var section = document.getElementById('section_initial').value;
        $.ajax({
            url: 'process/processor_initial.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'check_insert',
                kanban_no: kanban_no,
                location: location,
                section: section
            }, success: function (response) {
                console.log(response);
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    load_prev();
                    $("#kanban_no_initial").val('');
                } else if (response == '') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Invalid Qrcode !!!',
                        text: 'Information',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    load_prev();
                    $("#kanban_no_initial").val('');
                } else if (response == 'duplicate') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Scanned !!!',
                        text: 'Information',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    load_prev();
                    $("#kanban_no_initial").val('');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    load_prev();
                    $("#kanban_no_initial").val('');
                }
            }
        });
    }

    const load_prev = () => {
        var location = document.getElementById('location_name_initial').value;

        $.ajax({
            url: 'process/processor_initial.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'prev_scanned',
                location: location
            }, success: function (response) {
                $('#date_prev_scanned_initial').html(response);
            }
        });
    }

    const get_inventory_details_initial = (param) => {
        var string = param.split('~!~');
        var id = string[0];
        var line_number = string[1];
        var partscode = string[2];
        var partsname = string[3];
        var quantity = string[4];
        document.getElementById('id_update_qty_initial').value = id;
        document.getElementById('line_no_update_initial').value = line_number;
        document.getElementById('parts_code_update_initial').value = partscode;
        document.getElementById('parts_name_update_initial').value = partsname;
        document.getElementById('qty_update_initial').value = quantity;
    }

    const update_qty_initial = () => {
        var id = document.getElementById('id_update_qty_initial').value;
        var qty = document.getElementById('qty_update_initial').value;

        if (qty < 0) {
            Swal.fire({
                icon: 'info',
                title: 'Invalid Quantity!!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else {

            $.ajax({
                url: 'process/processor_initial.php',
                type: 'POST',
                cache: false,
                data: {
                    method: 'update_qty_initial',
                    id: id,
                    qty: qty,
                }, success: function (response) {
                    if (response == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Succesfully Updated!!!',
                            text: 'Success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        load_prev();
                        $('#edit_qty_initial').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!!',
                            text: 'Error',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        load_prev();
                        $('#edit_qty_initial').modal('hide');
                    }
                }
            });
        }
    }
</script>