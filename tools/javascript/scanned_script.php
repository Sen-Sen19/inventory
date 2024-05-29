<script type="text/javascript">
$( document ).ready(function() {
    get_client_pc_info();
    get_section();
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
        url: 'process/processor.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'get_section_final'
        },success:function(data){
            console.log(data);
            $('#section_name_scanned_final').html(data);
        }
    });
}

const search_scanned =()=>{
    $('#spinner').css('display','block');
    var line_no = document.getElementById('section_name_scanned_final').value;
    var location = document.getElementById('line_names_scanned_final').value;
    var parts_code = document.getElementById('parts_code_search').value;
    $.ajax({
        url:'process/processor.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'fetch_scanned',
            line_no:line_no,
            location:location,
            parts_code:parts_code
        },success:function(response) {
           document.getElementById('list_of_scanned').innerHTML = response;
           $('#spinner').fadeOut();
        }
    });
}

const export_scanned =()=>{
    var line_no = document.getElementById('line_name_search').value;
    window.open('process/export_scanned.php?line_no='+line_no);
}

const export_scanned_filtered =()=>{
    var line_no = document.getElementById('line_name_search').value;
    var location = document.getElementById('location_name_search').value;
    if (line_no == '') {
         Swal.fire({
                      icon: 'info',
                      title: 'Please Select Line Number !!!',
                      text: 'Information',
                      showConfirmButton: false,
                      timer : 1000
                    });
    }else{
        window.open('process/export_scanned.php?line_no='+line_no+'&&location='+location);
    }
}

const get_inventory_details_final_verified =(param)=>{
    var string = param.split('~!~');
    var id = string[0];
    var line_number = string[1];
    var partscode = string[2];
    var partsname = string[3];
    var verified_qty = string[4];
document.getElementById('id_update_qty_final_verified').value = id;
document.getElementById('line_no_update_final_verified').value = line_number;
document.getElementById('parts_code_update_final_verified').value = partscode;
document.getElementById('parts_name_update_final_verified').value = partsname;
document.getElementById('qty_update_final_verified').value = verified_qty;
}

const update_qty_final_verified =()=>{
    var id = document.getElementById('id_update_qty_final_verified').value;
    var qty = document.getElementById('qty_update_final_verified').value;

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
        url:'process/processor.php',
        type:'POST',
        cache:false,
        data:{
            method:'update_qty_final_verified',
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
                search_scanned();
                $('#edit_final_verified_qty').modal('hide');
            }else{
                 Swal.fire({
                      icon: 'error',
                      title: 'Error !!!',
                      text: 'Error',
                      showConfirmButton: false,
                      timer : 1000
                    });
                search_scanned();
                $('#edit_final_verified_qty').modal('hide');
            }
        }
    });
    }
}


const section_check_scanned_final =()=>{
    var section = document.getElementById('section_name_scanned_final').value;
      $.ajax({
            url: 'process/processor.php',
            type: 'POST',
            cache: false,
            data:{
                method: 'get_location_final',
                section:section
            },success:function(data){
                console.log(data);
                $('#line_names_scanned_final').html(data);
            }
        });
}
</script>