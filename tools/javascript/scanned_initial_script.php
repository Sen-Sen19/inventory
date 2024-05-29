<script type="text/javascript">
$( document ).ready(function() {
    get_client_pc_info();
    get_section();
    get_location_name_initial();
});

// Revisions (Vince)
const get_client_pc_info =()=>{
    $.ajax({
        url: 'process/remote.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'get_client_pc_info'
        },success:function(data){
            console.log(data);
        }
    });
}

// Revisions (Vince)
const get_section =()=>{
    $.ajax({
        url: 'process/processor_initial.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'get_section'
        },success:function(data){
            console.log(data);
            $('#section_initial_search').html(data);
        }
    });
}

const get_location_name_initial =()=>{
    $.ajax({
        url: 'process/processor_initial.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'get_location_name_initial'
        },success:function(data){
            console.log(data);
            $('#location_name_initial_search').html(data);
        }
    });
}

const search_scanned_initial =()=>{
    $('#spinner').css('display','block');
    var location = document.getElementById('location_name_initial_search').value;
    var partscode = document.getElementById('parts_code_initial_search').value;
    var section = document.getElementById('section_initial_search').value;
    $.ajax({
        url:'process/processor_initial.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'fetch_scanned_initial',
            location:location,
            partscode:partscode,
            section:section
        },success:function(response) {
           document.getElementById('list_of_scanned_initial').innerHTML = response;
           $('#spinner').fadeOut();
        }
    });
}

const export_scanned_initial =()=>{
    var location = document.getElementById('location_name_initial_search').value;
    window.open('process/export_scanned_initial.php?location='+location);
}

const export_scanned_filtered =()=>{
    var partscode = document.getElementById('parts_code_initial_search').value;
    var location = document.getElementById('location_name_initial_search').value;
    if (location == '') {
         Swal.fire({
                      icon: 'info',
                      title: 'Please Select Location !!!',
                      text: 'Information',
                      showConfirmButton: false,
                      timer : 1000
                    });
    }else{
        window.open('process/export_scanned_initial.php?partscode='+partscode+'&&location='+location);
    }
}

const get_inventory_details_initial_verified =(param)=>{
    var string = param.split('~!~');
    var id = string[0];
    var line_number = string[1];
    var partscode = string[2];
    var partsname = string[3];
    var verified_qty = string[4];
document.getElementById('id_update_qty_initial_verified').value = id;
document.getElementById('line_no_update_initial_verified').value = line_number;
document.getElementById('parts_code_update_initial_verified').value = partscode;
document.getElementById('parts_name_update_initial_verified').value = partsname;
document.getElementById('qty_update_initial_verified').value = verified_qty;
}

const update_qty_initial_verified =()=>{
    var id = document.getElementById('id_update_qty_initial_verified').value;
    var qty = document.getElementById('qty_update_initial_verified').value;

    if (qty < 0) {
         Swal.fire({
                      icon: 'info',
                      title: 'Invalid Quantity!!!',
                      text: 'Information',
                      showConfirmButton: false,
                      timer : 1000
                    });
    }else{

    $.ajax({
        url:'process/processor_initial.php',
        type:'POST',
        cache:false,
        data:{
            method:'update_qty_initial_verified',
            id:id,
            qty:qty,
        },success:function(response){
            if (response == 'success') {
                Swal.fire({
                      icon: 'success',
                      title: 'Succesfully Updated!!!',
                      text: 'Success',
                      showConfirmButton: false,
                      timer : 1000
                    });
                search_scanned_initial();
                $('#edit_initial_verified_qty').modal('hide');
            }else{
                 Swal.fire({
                      icon: 'error',
                      title: 'Error !!!',
                      text: 'Error',
                      showConfirmButton: false,
                      timer : 1000
                    });
                search_scanned_initial();
                $('#edit_initial_verified_qty').modal('hide');
            }
        }
    });
    }
}

const section_scanned =()=>{
    var section = document.getElementById('section_initial_search').value;
    $.ajax({
            url: 'process/processor_initial.php',
            type: 'POST',
            cache: false,
            data:{
                method: 'get_location',
                section:section
            },success:function(data){
                $('#location_name_initial_search').html(data);
            }
        });
}
</script>