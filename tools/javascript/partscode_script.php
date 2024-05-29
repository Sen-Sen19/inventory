<script type="text/javascript">
  $(document).ready(function () {
    fetch_section_list();
});


const fetch_section_list = () => {
    $.ajax({
        url: 'process/partscode_p.php',
        type: 'POST',
        cache: false,
        data: {
            method: 'fetch_section_list',
        },
        success: function (response) {
            $('#section_list').html(response);
        }
    });
}

const fetch_location_list = () => {
    var section = $('#section_list').val();
    $.ajax({
        url: 'process/partscode_p.php',
        type: 'POST',
        cache: false,
        data: {
            method: 'fetch_location_list',
            section: section 
        },
        success: function (response) {
            $('#location_list').html(response);
        }
    });
}


$('#section_list').change(function () {
    fetch_location_list();
});

</script>