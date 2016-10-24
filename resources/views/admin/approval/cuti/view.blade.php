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
                          <td>{{ $model->start_date->format('') }}</td>
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
