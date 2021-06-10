<script src="{{ asset('js/1jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.bootstrap-growl.min.js') }}"></script>

  {{-- <script type="text/javascript">
       $(document).ready(function(){
        $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Success &nbsp;!&nbsp;gg</i></b>',
        {
            type: 'success',
            width: 280,
            delay: 10000,
        });
    });
   </script> --}}



   

@if ($message = Session::get('success'))


<script type="text/javascript">

$(document).ready(function()
{

$.bootstrapGrowl('<span class = "fas fa-info-circle"></span>&nbsp;&nbsp;&nbsp;Success&nbsp;!&nbsp;{{ $message }}',
{
    type: 'success',
    width: 500,
    delay: 5000,  

});

});

</script>

@endif  




@if (Session::get('errors'))


@foreach ($errors->all() as $error)
               
          

<script type="text/javascript">

$(document).ready(function()
{

$.bootstrapGrowl(' <span class = "fas fa-exclamation-triangle"></span>&nbsp;&nbsp;&nbsp;Warning&nbsp;!&nbsp;{{ $error }}',
{
    type: 'danger',
    width: 500,
    delay: 10000,  

});

});

</script>

@endforeach

@endif

@if (Session::get('error'))

<script type="text/javascript">

    $(document).ready(function()
    {
    
    $.bootstrapGrowl(' <span class = "fas fa-exclamation-triangle"></span>&nbsp;&nbsp;&nbsp;Warning&nbsp;!&nbsp;{{ Session::get('error') }}',
    {
        type: 'danger',
        width: 500,
        delay: 10000,  
    
    });
    
    });
    
    </script>

@endif