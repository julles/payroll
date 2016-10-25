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
              <div class="box">
                  
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>NIP</td>
                          <td>{{ $model->employee->nip }}</td>
                        </tr>
                        <tr>
                          <td>Nama</td>
                          <td>{{ $model->employee->name }}</td>
                        </tr>
                        <tr>
                          <td>Tanggal Cuti</td>
                          <td>{{ $model->start_date->format('d, F Y') }}</td>
                        </tr>
                        <tr>
                          <td>Sampai Tanggal</td>
                          <td>{{ $model->end_date->format('d, F Y') }}</td>
                        </tr>
                        <tr>
                          <td>Alasan</td>
                          <td>{{ $model->reason }}</td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td>{{ $model->status }}</td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            @if($model->status == 'pending')
                              {!! Html::link(Admin::urlBackendAction('approve/'.$model->id),"Approve",['class'=>'btn btn-success','onclick'=>'return confirm("Anda yakin?")']) !!}
                              {!! Html::link(Admin::urlBackendAction('reject/'.$model->id),"Reject",['class'=>'btn btn-danger','onclick'=>'return confirm("Anda yakin?")']) !!}
                            
                            @else
                              {!! Html::link(Admin::urlBackendAction('index'),"Kembali",['class'=>'btn btn-info']) !!}
                            @endif
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    

              </div>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
