@extends('admin.layouts.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.scaffolding.content_header')

    <!-- Main content -->
    <section class="content">

      <div class="row">
          <div class="col-md-12">
              <div class="box box-primary">
                  {!! Form::model($model,['form']) !!}
                    <div class="box-body">
                      
                      @include('admin.flashes.flash')
                      
                      <div class="form-group">
                        <label for="exampleInputEmail1">Tahun</label>
                        <?= Form::select('year' , $years , request()->get('year') , ['class'=>'form-control','id'=>'year']) ?>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Bulan</label>
                        <?= Form::text('month_display' , date('F'), ['class'=>'form-control','readonly'=>true]) ?>
                        <?= Form::hidden('month' , date('m'),['id'=>'month']) ?>
                      </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                      <button class="btn btn-primary" type="button" id = "generate">Generate</button>
                      {!! Html::image(asset('loading.gif') , 'loading' , ['id'=>'loading','style'=>'display:none;']) !!}
                    </div>

                    <div class="box-body">
                        <table class="table">
                          <thead>
                            <th>Name</th>
                            <th>Gaji Pokok</th>
                            <th>Total Uang Makan</th>
                            <th>Total Transport</th>
                            <th>Lembur</th>
                            <th>THR</th>
                            <th>PPH21</th>
                            <th>Total</th>
                          </thead>
                          <tbody id = "tbody">
                            
                          </tbody>
                      </table>
                    </div>

                  {!! Form::close() !!}
                </div>
          </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@push('scripts')
<script type="text/javascript">
  $(document).ready(function(){
      $("#generate").on('click' , function(){
          year = $("#year").val();
          month = $("#month").val();

          if(year == "")
          {
            alert("Tahun harus di isi");
          }else{
              $.ajax({
                url : '{{ Admin::urlBackendAction("generate") }}',
                data : {
                  year : year,
                  month :  month,
                },
                beforeSend : function(){
                  $("#generate").hide();
                  $("#loading").show();
                },
                success : function(data){
                  $("#generate").show();
                  $("#loading").hide();

                  $("#tbody").html("");
                  $("#tbody").html(data.result);
                },
              });
          }
      });
  });

</script>
@endpush