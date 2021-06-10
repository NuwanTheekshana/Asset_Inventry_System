<script>
    $('#emp_type').change(function () 
    {
         var compy_type = $('#compy_type').val();
         var emp_type = $('#emp_type').val();

         if (compy_type != "" && emp_type != "") 
         {
            if (emp_type != "Other") {
                $('#epf_no_div').show(1000);
            }
            else
            {
                $('#epf_no_div').hide();
            }
         }
         else
         {
            if (compy_type == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Company is required..!</i></b>',
                {
                type: 'danger',
                width: 500,
                delay: 10000,
                });
                $(window).scrollTop(0);
            }
            
         }

    });
</script>

<script>
    $('#nexttype_btn').click(function () 
    {
        var compy_type = $('#compy_type').val();
        var emp_type = $('#emp_type').val();
        var epfno = $('#epfno').val();
        
        if (emp_type != "Other") 
        {
            if (compy_type == "") 
            {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Company is required..!</i></b>',
            {
                type: 'danger',
                width: 500,
                delay: 10000,
                
            });
            $(window).scrollTop(0);
        }

        if (emp_type == "") 
        {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Employee type is required..!</i></b>',
            {
                type: 'danger',
                width: 500,
                delay: 10000,
                
            });
            $(window).scrollTop(0);
        }

        if (compy_type == "" || emp_type=="") 
        {
            return false;
        }

        if (epfno == "") 
        {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;EPF number is required..!</i></b>',
            {
                type: 'danger',
                width: 500,
                delay: 10000,
            });
            $(window).scrollTop(0);
            return false;
        }

        $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
           type:'POST',
           url:'{{url("/employee_validation")}}',
           data:{compy_type:compy_type, emp_type:emp_type, epfno:epfno},
           success:function(data)
           {
                    if (data.emp_details.EmployeeNo != "" || emp_type == "Other") 
                    {
                        let epf = parseInt(data.emp_details.EmployeeNo, 10);
                        $('#epfno_val').val(epf);
                        $('#epfno_val').prop('readonly', true);
                        $('#fullname').val(data.emp_details.DisplayName);
                        $('#fullname').prop('readonly', true);
                        $('#email').val(data.emp_details.EmailAddress);
                        $('#email').prop('readonly', true);
                    }

                    if (emp_type == "Other") {
                        $('#epfno').val('00000');
                        $('#epfno_val').val('00000');
                    }

                    $('#user_maintype_data_card').hide(1000);
                    $('#user_data_card').show(1000);
                }
       
        });


    }
    else
    {
        $('#epfno_val').prop('readonly', false);
        $('#fullname').prop('readonly', false);
        $('#email').prop('readonly', false);
        $('#epfno').val('00000');
        $('#epfno_val').val('00000');
        $('#epfno_val').prop('readonly', true);

        $('#user_maintype_data_card').hide(1000);
        $('#user_data_card').show(1000);
    }
    

        

    });
</script>

<script>
    $('#next1').click(function () 
    {
        var epfno = $('#epfno_val').val();
        var emp_type = $('#emp_type').val();
        var fullname = $('#fullname').val();
        var NIC = $('#NIC').val();
        var designation = $('#designation').val();
        var location = $('#location').val();
        var compy_type = $('#compy_type').val();
        var email = $('#email').val();
        var contact_no = $('#contact_no').val();

        if (epfno == "" || emp_type == "" || fullname == "" || NIC == "" || designation == "" || location == "" || compy_type == "" || email == "" || contact_no == "") 
        {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;All feilds are required..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
                    $(window).scrollTop(0);
                    return false;
        }


        if (contact_no.length > 10 || contact_no.length < 10) 
          {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Invalid contact number..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
                    $(window).scrollTop(0);
            return false;
          }


          $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
           type:'POST',
           url:'{{url("/employee_details_validation")}}',
           data:{compy_type:compy_type, emp_type:emp_type, epfno:epfno},
           success:function(data)
           {
                if (data.find_user_count > 0) 
                {
                    $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;'+data.already_added_user+'</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
                    $(window).scrollTop(0);
                    return false;
                }
                else
                {
                    $('#user_data_card').hide(1000); 
                    $('#asset_data_card').show(1000);
                }
               

           }
       
        });

    });

</script>

<script>
    $('#asset_type').change(function () 
    {
        var asset_type = $('#asset_type').val();

        if (asset_type == "Pen Drive" || asset_type == "External Hard Drive") 
        {
            $('#asset_no_div').hide();
            $('#serial_no_div').hide();
            $('#dev_modal_div').hide();
            $('#not_mention_div').hide();
            $('#add_item').hide();
            $('#add_item_other').show();
            $('#pen_model_div').show();
            $('#pen_storage_div').show();
            
        }
        else
        {
            $('#asset_no_div').show();
            $('#serial_no_div').show();
            $('#not_mention_div').show();
            $('#add_item').show();
            $('#dev_modal_div').show();
            $('#pen_model_div').hide();
            $('#pen_storage_div').hide();
            $('#add_item_other').hide();
        }
    });
</script>


<script>
    $(document).ready(function () {
        count = 0;
     $('#add_item').click(function () {
          var asset_type = $('#asset_type').val();
          var asset_no = $('#asset_no').val();
          var serialno = $('#serialno').val();
          var dev_modal = $('#dev_modal').val();
          var notmention = $('#notmention');

            if ($('#notmention').is(":checked"))
            {
                var notmention = "Yes"; 
            }
            else
            {
                var notmention = "No"; 
            }

          if (asset_type == null || asset_type == "") 
          {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Assert Type is Required..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
             return false;
          }

          if (asset_no == "" && serialno == "")
          {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Assert Details Required..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
             return false;
          }

          let currentId = new Date();
        let getid = currentId.getTime();
        $('#table_div').show(1000);
        $("#asset_data_table tbody").append(
       "<tr id='row"+getid+"'>" +
         "<td style='text-align: center'>"+asset_type+"<input type='hidden' value='"+asset_type+"' id='asset_type_val' name='asset_type_val[]'></td>" +
         "<td style='text-align: center'>"+asset_no+"<input type='hidden' value='"+asset_no+"' id='asset_no_val' name='asset_no_val[]'></td>" +
         "<td style='text-align: center'>"+serialno+"<input type='hidden' value='"+serialno+"' id='serial_no_val' name='serial_no_val[]'></td>" +
         "<td style='text-align: center'>"+dev_modal+"<input type='hidden' value='"+dev_modal+"' id='dev_modal_val' name='dev_modal_val[]'></td>" +
         "<td style='text-align: center'><button class='btn btn-danger btn-sm' type='button' id='assertremove_btn' onclick='removerow("+getid+")' style='background-color:red;'><i class='fa fa-trash'></i></button></td>" +
       "</tr>"
          );
          $('#asset_type').val('');
          $('#asset_no').val('');
          $('#serialno').val('');
          $('#dev_modal').val('');
          $('#asset_status').val('1');
         count++;


     }); 
    });

 </script>
 
 <script>
     function removerow(id) 
       {
           var idv = document.getElementById("row"+id);
           var asset_type_val = document.getElementById("asset_type_val");
           var asset_no_val = document.getElementById("asset_no_val");
           var dev_modal_val = document.getElementById("dev_modal_val");
           var serial_no_val = document.getElementById("serial_no_val");    
   
           idv.parentNode.removeChild(idv);
           asset_type_val.parentNode.removeChild(asset_type_val);
           asset_no_val.parentNode.removeChild(asset_no_val);
           dev_modal_val.parentNode.removeChild(dev_modal_val);
           serial_no_val.parentNode.removeChild(serial_no_val);
           count--; 
           
           if (count == 0) {
               $('#table_div').hide(1000);
           }
           if (count_other == 0 && count == 0) 
          {
            $('#asset_status').val('0');
          }
       }
   </script>

<script>
    $(document).ready(function () 
    {
        count_other = 0;

        $('#add_item_other').click(function () 
        {
            var asset_type = $('#asset_type').val();
            var pen_model = $('#pen_model').val();
            var pen_storage = $('#pen_storage').val();

                if (asset_type == "Pen Drive" || asset_type == "External Hard Drive") 
            {
                if (pen_model == null || pen_model == "") 
                {
                    $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Model is Required..!</i></b>',
                        {
                            type: 'danger',
                            width: 500,
                            delay: 10000,
                        });
                    return false;
                }

                if (pen_storage == null || pen_storage == "") 
                {
                    $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Capacity is Required..!</i></b>',
                        {
                            type: 'danger',
                            width: 500,
                            delay: 10000,
                        });
                    return false;
                }
            }

            let currentId = new Date();
            let getid = currentId.getTime();
            $('#table_other_div').show(1000);
            $("#other_asset_data_table tbody").append(
        "<tr id='row_other"+getid+"'>" +
            "<td style='text-align: center'>"+asset_type+"<input type='hidden' value='"+asset_type+"' id='asset_type_other_val' name='asset_type_other_val[]'></td>" +
            "<td style='text-align: center'>"+pen_model+"<input type='hidden' value='"+pen_model+"' id='pen_asset_no_val' name='pen_asset_no_val[]'></td>" +
            "<td style='text-align: center'>"+pen_storage+"<input type='hidden' value='"+pen_storage+"' id='storange_val' name='storange_val[]'></td>" +
            "<td style='text-align: center'><button class='btn btn-danger btn-sm' type='button' id='assert_otherremove_btn' onclick='remove_other_row("+getid+")' style='background-color:red;'><i class='fa fa-trash'></i></button></td>" +
        "</tr>"
            );
            $('#asset_type').val('');
            $('#pen_model').val('');
            $('#pen_storage').val('');
            $('#asset_status').val('1');
            count_other++;


        });
    });
</script>


<script>
    function remove_other_row(id) 
      {
          var idv = document.getElementById("row_other"+id);
          var asset_type_val = document.getElementById("asset_type_other_val");
          var asset_no_val = document.getElementById("pen_asset_no_val");
          var serial_no_val = document.getElementById("storange_val");    
  
          idv.parentNode.removeChild(idv);
          asset_type_val.parentNode.removeChild(asset_type_val);
          asset_no_val.parentNode.removeChild(asset_no_val);
          serial_no_val.parentNode.removeChild(serial_no_val);
          count_other--; 

          if (count_other == 0) {
              $('#table_other_div').hide(1000);
              
          }
          if (count_other == 0 && count == 0) 
          {
            $('#asset_status').val('0');
          }
      }
  </script>

<script>
    $('#skip_asset').click(function () 
    {
        $('#asset_status').val('0');
        $('#asset_data_card').hide(1000);
        $('#dongle_connection_div').show(1000);
    });
</script>

<script>
    $('#next_asset_btn').click(function () 
    {
        if (count == 0) 
        {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Asset details required..!</i></b>',
                {
                    type: 'danger',
                    width: 500,
                    delay: 10000,
                });
            return false;
        }
        $('#asset_data_card').hide(1000);
        $('#dongle_connection_div').show(1000);
        
    });
</script>


<script>
    $(document).ready(function () {
        count2 = 0;
     $('#insert_don_data').click(function () {
          var don_asset_type = $('#don_asset_type').val();
          var don_con_type = $('#don_con_type').val();
          var don_con_number = $('#don_con_number').val();
          var don_sim_number = $('#don_sim_number').val();
          var don_ip = $('#don_ip').val();
          var don_modal = $('#don_modal').val();
          var don_imei = $('#don_imei').val();

          if (don_asset_type == "" || don_con_type == "" || don_con_number == "" || don_sim_number == "" || don_ip == "" || don_modal == "" || don_imei == "") 
          {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;All fields are required..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
             return false;
          }
          if (don_con_number.length > 10 || don_con_number.length < 10) 
          {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Invalid dongle connection number..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
            return false;
          }

          if (don_sim_number.length > 25 || don_sim_number.length < 14) 
          {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Invalid SIM number..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
            return false;
          }

          if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(don_ip)) 
          {}
          else
          {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;You have entered an invalid IP address!..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
            return false;
          }

          

          if (don_imei.length > 30 || don_imei.length < 12) 
          {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Invalid IMEI number..!</i></b>',
                    {
                        type: 'danger',
                        width: 500,
                        delay: 10000,
                    });
            return false;
          }
  

            let currentId = new Date();
            let getid = currentId.getTime();
            $('#dongle_table_div').show(1000);
            $("#dongle_data_table tbody").append(
            "<tr id='donglerow"+getid+"'>" +
                "<td style='text-align: center'>"+don_asset_type+"<input type='hidden' value='"+don_asset_type+"' id='don_asset_type_val' name='don_asset_type_val[]'></td>" +
                "<td style='text-align: center'>"+don_con_type+"<input type='hidden' value='"+don_con_type+"' id='don_con_type_val' name='don_con_type_val[]'></td>" +
                "<td style='text-align: center'>"+don_con_number+"<input type='hidden' value='"+don_con_number+"' id='don_con_number_val' name='don_con_number_val[]'></td>" +
                "<td style='text-align: center'>"+don_sim_number+"<input type='hidden' value='"+don_sim_number+"' id='don_sim_number_val' name='don_sim_number_val[]'></td>" +
                "<td style='text-align: center'>"+don_ip+"<input type='hidden' value='"+don_ip+"' id='don_ip_val' name='don_ip_val[]'></td>" +
                "<td style='text-align: center'>"+don_modal+"<input type='hidden' value='"+don_modal+"' id='don_modal_val' name='don_modal_val[]'></td>" +
                "<td style='text-align: center'>"+don_imei+"<input type='hidden' value='"+don_imei+"' id='don_imei_val' name='don_imei_val[]'></td>" +
                "<td style='text-align: center'><button class='btn btn-danger btn-sm' id='dongle_remove_btn' onclick='removedonglerow("+getid+")' style='background-color:red;'><i class='fa fa-trash'></i></button></td>" +
            "</tr>"
            );
            $('#don_asset_type').val('');
            $('#don_con_type').val('');
            $('#don_con_number').val('');
            $('#don_sim_number').val('');
            $('#don_ip').val('');
            $('#don_modal').val('');
            $('#don_imei').val('');
            $('#next_dongle').show(1000);
            count2++;
    
     }); 
    });
 </script>
 
 <script>
    function removedonglerow(id) 
      {
          var idv = document.getElementById("donglerow"+id);
          var don_asset_type_val = document.getElementById("don_asset_type_val");
          var don_con_type_val = document.getElementById("don_con_type_val");
          var don_con_number_val = document.getElementById("don_con_number_val");    
          var don_sim_number_val = document.getElementById("don_sim_number_val");    
          var don_ip_val = document.getElementById("don_ip_val");    
          var don_modal_val = document.getElementById("don_modal_val");    
          var don_imei_val = document.getElementById("don_imei_val");    
  
          idv.parentNode.removeChild(idv);
          don_asset_type_val.parentNode.removeChild(don_asset_type_val);
          don_con_type_val.parentNode.removeChild(don_con_type_val);
          don_con_number_val.parentNode.removeChild(don_con_number_val);
          don_sim_number_val.parentNode.removeChild(don_sim_number_val);
          don_ip_val.parentNode.removeChild(don_ip_val);
          don_modal_val.parentNode.removeChild(don_modal_val);
          don_imei_val.parentNode.removeChild(don_imei_val);
          count2--; 

          if (count2 == 0) {
              $('#dongle_table_div').hide(1000);
              $('#next_dongle').hide(1000);
              $('#dongle_status').val('0');
              
          }
      }
  </script>

<script>
    $('#skip_dongle').click(function () 
    {
        var asset_status = $('#asset_status').val();
        $('#dongle_status').val('0');
        $('#dongle_connection_div').hide(1000);

        if (asset_status == "1") 
        {
            $('#asset_data_card').show(1000);
            $('#asset_group').hide(1000);
            $('#asset_div_btn').hide(1000);

            $('#user_data_card').show(1000);
            $('#user_div_btn').hide(1000);

            $('#email').prop("readonly",true);
            $('#contact_no').prop("readonly",true);
            $('#table_div').show(1000);
            $('#submit_btn').show(1000);

        }
        else
        {
            $('#user_div_btn').hide(1000);
            $('#user_data_card').show(1000);
            $('#email').prop("readonly",true);
            $('#contact_no').prop("readonly",true);
            $('#submit_btn').show(1000);
        }
    });
</script>

<script>
    $('#next_dongle').click(function () 
    {
        var asset_status = $('#asset_status').val();
        var dongle_status = $('#dongle_status').val();

        if (asset_status == "1" && dongle_status == "1") 
        {
            $('#asset_data_card').show(1000);
            $('#asset_group').hide(1000);
            $('#asset_div_btn').hide(1000);
            $('#table_div').show(1000);
            

            $('#user_data_card').show(1000);
            $('#user_div_btn').hide(1000);
            $('#email').prop("readonly",true);
            $('#contact_no').prop("readonly",true);
            
            
            $('#dongle_connection_div').show(1000);
            $('#dongle_group').hide(1000);
            $('#dongle_div_btn').hide(1000);
            $('#next_dongle').hide(1000);
            $('#dongle_table_div').show(1000);
            
            $('#submit_btn').show(1000);

        }

        if (asset_status == "0" && dongle_status == "1") 
        {

            $('#user_data_card').show(1000);
            $('#user_div_btn').hide(1000);
            $('#email').prop("readonly",true);
            $('#contact_no').prop("readonly",true);
            
            
            $('#dongle_connection_div').show(1000);
            $('#dongle_group').hide(1000);
            $('#dongle_div_btn').hide(1000);
            $('#next_dongle').hide(1000);
            $('#dongle_table_div').show(1000);
            
            $('#submit_btn').show(1000);

        }
    });
</script>


<script>
    $('#submit_btn').click(function () 
    {
        var form = $("#form").serialize();
        
        $('#user_maintype_data_card').hide(1000);
        $('#user_data_card').hide(1000);
        $('#asset_data_card').hide(1000);
        $('#dongle_connection_div').hide(1000);
        $('#submit_btn').hide(1000);
        $('#imgdiv').show(1000);

        $(window).scrollTop(0);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'{{url("/insert_new_asset_data")}}',
            data:form,
            success:function(data)
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Success &nbsp;!&nbsp;'+data.success+'</i></b>',
                    {
                        type: 'success',
                        width: 500,
                        delay: 10000,
                    });

                    setTimeout(function() { 
                        location.href = "{{url('/add_new')}}";
                    }, 4000);

                    

            },

         });
    });
</script>