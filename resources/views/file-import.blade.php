<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Import Excel & CSV to Database in Laravel 8</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>

<body>
<div class="container mt-5 text-center">
    <div class="card">
        <div class="card-header"> Laravel 8 Import CSV & Excel to Database Example</div>
        <div class="card-body">
      <div class="form_error_container">

      </div>
            <form action="{{route('file-import-store')}}" method="post" enctype="multipart/form-data" id="main_form">
                <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                    <div class="custom-file text-left">
                        <input type="file" name="file" class="custom-file-input" id="customFile">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Import Data</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

   $(function (){

       toastr.options = {
           "closeButton": true,
           "newestOnTop": true,
           "positionClass": "toast-top-right"
       };
       $('#main_form').on('submit',function (e){

           e.preventDefault();
           var _token = $('input#_token').val();
           var files = $('#customFile').files;
               var formData = new FormData();
               formData.append("_token", _token);
               formData.append("file", $('#customFile')[0].files[0]);
               $.ajax({
                   url: $(this).attr('action'),
                   type: $(this).attr('method'),
                   contentType: false,
                   processData: false,
                   cache: false,
                   data: formData,
                   success: function (data) {

                       if(data.success == 1){
                           if(data.extension == 'csv'){
                               toastr.success(data.message);
                           }
                       }

                       else{
                           toastr.error('Hatalı seçim yaptınız');
                       }
                   },

                   error   : function ( jqXhr, json, errorThrown )
                   {
                       var errors = jqXhr.responseJSON;
                       var errorsHtml= '';
                       $.each( errors, function( key, value ) {
                           errorsHtml +=  value[0];
                       });
                       $(".form_error_container").addClass("alert alert-danger").text( errorsHtml , "Error " + jqXhr.status +': '+ errorThrown);

                   }

               });
       });

   });
</script>
</body>

</html>
