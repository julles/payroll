@extends('admin.layouts.auth.layout')
@section('content')
  <!-- /.login-logo -->
  @include('admin.flashes.flash')
  <div class="login-box-body">
    <p class="login-box-msg">ABSENT DISINI</p>

      <div class="form-group has-feedback">
        {!! Form::text('nip',null,['class'=>'form-control','placeholder'=>'Masukan NIP Anda','id'=>'nip']) !!}
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <a id = "absen_masuk" href="#" onclick = "urlMasuk()" class = "btn btn-success disabled">MASUK</a><br>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <a  id = "absen_keluar"  onclick = "urlKeluar()" class = "btn btn-danger disabled">KELUAR</a><br>
        </div>
        <!-- /.col -->
      </div>
    <!-- /.social-auth-links -->
  </div>
  <!-- /.login-box-body -->
@endsection
@push('scripts')
<script type="text/javascript">
  
  $(document).ready(function(){
      $("#nip").on('keyup',function(){
        $.ajax({
          url:'{{ url("absent/cek") }}',
          data : {
            nip : $(this).val(),
          },
          success : function(data){
              if(data.result == 'absen_masuk')
              {
                $("#absen_masuk").removeClass("btn btn-success disabled");
                $("#absen_masuk").addClass("btn btn-success");

                $("#absen_keluar").removeClass("btn btn-danger");
                $("#absen_keluar").addClass("btn btn-danger disabled");
              }else if(data.result == 'absen_keluar'){
                $("#absen_masuk").removeClass("btn btn-success");
                $("#absen_masuk").addClass("btn btn-success disabled");

                $("#absen_keluar").removeClass("btn btn-danger disabled");
                $("#absen_keluar").addClass("btn btn-danger ");
              }else{
                $("#absen_keluar").addClass("btn btn-danger disabled");
                $("#absen_masuk").addClass("btn btn-success disabled");
              }
          },
        });
      });

  });

  function urlMasuk()
  {
    url = "/api/update/" + $("#nip").val() + "/absen,i";
    $.ajax({
      url : url,
      success : function(){
        document.location.href = '/absent';
      },
    });
  }

  function urlKeluar()
  {
    url = "/api/update/" + $("#nip").val() + "/absen,o";
     $.ajax({
      url : url,
      success : function(){
       document.location.href = '/absent';
      },
    });
  }

</script>
@endpush