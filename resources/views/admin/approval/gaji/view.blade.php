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
                        {!! Form::text('year',null,['class'=>'form-control','readonly'=>true]) !!}
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Bulan</label>
                        {!! Form::text('month',null,['class'=>'form-control','readonly'=>true]) !!}
                      </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                      {!! Html::link(Admin::urlBackendAction('excel/'.$model->id),'Export Excel',['class'=>'btn btn-success']) !!}
                    </div>

                    <div class="box-body">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Gaji Pokok</th>
                              <th>Total Uang Makan</th>
                              <th>Total Transport</th>
                              <th>Lembur</th>
                              <th>THR</th>
                              <th>PPH21</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody id = "tbody">
                            @foreach($model->details as $row)  
                              <tr>
                                <td>{{ $row->employee->nip }} - {{ $row->employee->name }}</td>
                                <td>{{ Admin::formatMoney($row->gaji_pokok) }}</td>
                                <td>{{ Admin::formatMoney($row->total_uang_makan) }}</td>
                                <td>{{ Admin::formatMoney($row->total_transport) }}</td>
                                <td>{{ Admin::formatMoney($row->total_lembur) }}</td>
                                <td>{{ Admin::formatMoney($row->thr) }}</td>
                                <td>{{ Admin::formatMoney($row->pph21) }}</td>
                                <td>{{ Admin::formatMoney($row->total) }}</td>
                              </tr>
                            @endforeach
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
