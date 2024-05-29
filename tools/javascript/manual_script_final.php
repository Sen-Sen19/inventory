<script type="text/javascript">
$( document ).ready(function() {
    get_client_pc_info();
    get_section();
    $('#scanning').modal('show');
    document.getElementById('kanban_no').disabled = true;
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
            $('#section_name').html(data);
        }
    });
}

const section_check =()=>{
    location_suggestion(); 
    var section = document.getElementById('section_name').value;
    if (section != '') {
        document.getElementById('kanban_no').disabled = true;
        document.getElementById('section_name').disabled = true;
    }else{
        document.getElementById('kanban_no').disabled = true;
        document.getElementById('section_name').disabled = false;
    }
}

const location_suggestion =()=>{
    var section = document.getElementById('section_name').value;
    console.log(section);
      $.ajax({
            url: 'process/processor.php',
            type: 'POST',
            cache: false,
            data:{
                method: 'get_location_final',
                section:section
            },success:function(data){
                console.log(data);
                $('#line_names').html(data);
            }
        });
}

const location_check_final =()=>{
	var section = document.getElementById('section_name').value;
    var location = document.getElementById('line_names').value;
	 if (section != '' && location != '') {
        document.getElementById('section_name').disabled = true;
        document.getElementById('line_names').disabled = true;
        document.getElementById('kanban_no').disabled = false;
    }else{
         document.getElementById('line_names').disabled = false;  
         document.getElementById('section_name').disabled = false; 
    }
}











const scanned =()=>{
	var line_no = document.getElementById('section_name').value;
	var kanban_no = document.getElementById('kanban_no').value;
    var location = document.getElementById('line_names').value;

	 $.ajax({
            url:'process/processor.php',
            type:'POST',
            cache:false,
            data:{
                method:'check_insert',
                line_no:line_no,
				kanban_no:kanban_no,
                location:location
            },success:function(response){    
                // console.log(response); 
                if (response == 'success') {
                    Swal.fire({
                      icon: 'success',
                      title: 'Succesfully Recorded!!!',
                      text: 'Success',
                      showConfirmButton: false,
                      timer : 1000
                    });
                    load_prev();
                    $("#kanban_no").val('');
                }else if(response == ''){
                     Swal.fire({
                      icon: 'info',
                      title: 'Invalid Qrcode !!!',
                      text: 'Information',
                      showConfirmButton: false,
                      timer : 1000
                    });
                    load_prev();
                    $("#kanban_no").val('');
                }else if(response == 'invalid line number'){
                    Swal.fire({
                      icon: 'info',
                      title: 'Invalid Line Number !!!',
                      text: 'Information',
                      showConfirmButton: false,
                      timer : 1000
                    });
                    load_prev();
                    $("#line_name").val('');
                    $("#kanban_no").val('');
                }else if(response == 'duplicate'){
                     Swal.fire({
                      icon: 'info',
                      title: 'Already Scanned !!!',
                      text: 'Information',
                      showConfirmButton: false,
                      timer : 1000
                    });
                    load_prev();
                    $("#kanban_no").val('');
                }else{
                    Swal.fire({
                      icon: 'error',
                      title: 'Error !!!',
                      text: 'Error',
                      showConfirmButton: false,
                      timer : 1000
                    });
                    load_prev();
                    $("#line_name").val('');
                    $("#kanban_no").val('');                 
                }     
            }
        });
}

const load_prev =()=>{
     var line_no = document.getElementById('line_names').value;
     var section = document.getElementById('section_name').value;
    $.ajax({
        url:'process/processor.php',
        type:'POST',
        cache:false,
        data:{
            method:'prev_scanned',
            line_no:line_no,
            section:section
        },success:function(response){
            $('#date_prev_scanned').html(response);
        }
    });
}

const get_inventory_details =(param)=>{
    var string = param.split('~!~');
    var id = string[0];
    var line_number = string[1];
    var partscode = string[2];
    var partsname = string[3];
    var quantity = string[4];
document.getElementById('id_update_qty').value = id;
document.getElementById('line_no_update').value = line_number;
document.getElementById('parts_code_update').value = partscode;
document.getElementById('parts_name_update').value = partsname;
document.getElementById('qty_update').value = quantity;
}

const update_qty =()=>{
    var id = document.getElementById('id_update_qty').value;
    var qty = document.getElementById('qty_update').value;

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
            method:'update_qty',
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
                load_prev();
                $('#edit_qty').modal('hide');
            }else{
                 Swal.fire({
                      icon: 'error',
                      title: 'Error !!!',
                      text: 'Error',
                      showConfirmButton: false,
                      timer : 1000
                    });
                load_prev();
                $('#edit_qty').modal('hide');
            }
        }
    });
    }
}
</script>