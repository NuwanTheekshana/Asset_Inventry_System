
<script>
    var concatenatedSerials = '';
    var concatenatedSerialsCount = '';
    $('#add_peripherals_serials').click(function () 
    {
        var serial = $('#phrip_serial_no').val();

        if (!serial) {
            alert("Please enter the serial number");
            return false;
        }

        let currentId = new Date();
            let getid = currentId.getTime();
            document.getElementById('serialclone').innerHTML += '<div class="row mt-2" id="'+getid+'"><div class="col-6"><input type="text" class="form-control mb-2" name="seriallist[]" id="seriallist" value="'+serial+'" readonly>'+
            '<button type="button" class="btn btn-danger mb-2 ml-2 btn-sm" id="btn_remove_txtbox_first" onclick="removeserial_val('+getid+');" style="background-color:red;"><i class="fas fa-trash"></i></button></div> </div>';
            $('#phrip_serial_no').val('');
            
            updateConcatenatedSerials();
    });

    $('#save_seriallist_btn').click(function () {
        updateConcatenatedSerials();
        $('#add_serial_no').val(concatenatedSerials);
        $('#add_unallocate_quantity').val(concatenatedSerialsCount).prop('readonly', true);;
        $('#serial_no_model').modal('hide');
    });

    function updateConcatenatedSerials() {
        var allSerials = $('input[name="seriallist[]"]').map(function() {
            return $(this).val();
        }).get();
        concatenatedSerials = allSerials.join('|');
        concatenatedSerialsCount = allSerials.length;
    }

    function removeserial_val(id)
    {
        var seriallist = document.getElementById("seriallist");
        var btn_remove_txtbox_first = document.getElementById("btn_remove_txtbox_first");

        seriallist.parentNode.removeChild(seriallist);
        btn_remove_txtbox_first.parentNode.removeChild(btn_remove_txtbox_first);

    }
</script>