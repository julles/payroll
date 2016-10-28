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
                  <div class="box-header with-border">
                    Data Pegawai : {{ $model->nip }}
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="col-md-6">
                        <table class="table table-bordered" id = ''>
                          <tbody>
                              <tr>
                                <td><b>Departemen</b></td>
                                <td>{{ $model->position->department->department }}</td>
                              </tr>
                              <tr>
                                <td><b>Jabatan</td>
                                <td>{{ $model->position->position }}</td>
                              </tr>
                              <tr>
                                <td><b>NIP</b></td>
                                <td>{{ $model->nip }}</td>
                              </tr>
                              <tr>
                                <td><b>Nama</b></td>
                                <td>{{ $model->name }}</td>
                              </tr>
                              <tr>
                                <td><b>Jenis Kelamin</b></td>
                                <td>{{ $model->gender == 'm' ? 'Laki laki' : 'Perempuan' }}</td>
                              </tr>
                              <tr>
                                <td><b>Status</b></td>
                                <td>{{ ucwords($model->status) }}</td>
                              </tr>
                              <tr>
                                <td><b>Tempat Lahir</b></td>
                                <td>{{ $model->place_of_birth }}</td>
                              </tr>
                              <tr>
                                <td><b>Tanggal Lahir</b></td>
                                <td>{{ $model->date_of_birth->format("d , F Y") }}</td>
                              </tr>
                              <tr>
                                <td><b>Alamat</b></td>
                                <td>{{ $model->address }} {{ $model->postal_code }}</td>
                              </tr>
                              <tr>
                                <td><b>Foto</b></td>
                                <td>{{ Html::image(Admin::assetContents($model->foto)) }}</td>
                              </tr>
                          </tbody>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered" id = ''>
                          <tbody>
                              <tr>
                                <td><b>No Telepon</b></td>
                                <td>{{ $model->phone }}</td>
                              </tr>
                              <tr>
                                <td><b>Agama</td>
                                <td>{{ ucwords($model->religion) }}</td>
                              </tr>
                              <tr>
                                <td><b>No Identitas</b></td>
                                <td>{{ $model->number_id }}</td>
                              </tr>
                              <tr>
                                <td><b>Tanggal masuk</b></td>
                                <td>{{ $model->join_date->format("d , F Y") }}</td>
                              </tr>
                              <tr>
                                <td><b>Gaji Pokok</b></td>
                                <td>{{ Admin::formatMoney($model->basic_salary) }}</td>
                              </tr>
                              <tr>
                                <td><b>Uang Pokok</b></td>
                                <td>{{ Admin::formatMoney($model->meal_allowance) }}</td>
                              </tr>
                              <tr>
                                <td><b>Transport</b></td>
                                <td>{{ Admin::formatMoney($model->transport) }}</td>
                              </tr>
                              <tr>
                                <td><b>Lembur (/jam)</b></td>
                                <td>{{ Admin::formatMoney($model->overtime) }}</td>
                              </tr>
                          </tbody>

                        </table>
                    </div>

                    {!! Html::link(Admin::urlBackendAction('index'),'Back',['class'=>'btn btn-success']) !!}
                    
                    {!! Html::link('#','Update Finger Print',['class'=>'btn btn-info','id'=>'finger']) !!}

                  </div>
                  <!-- /.box-body -->
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
    $("#finger").on('click',function(){
      $.ajax({
        type:'get',
        url : '{{ url("api/update/".$model->nip."/reg,1") }}',
        success : function(){
          document.location.href = '{{ Admin::urlBackendAction("view/".$model->id) }}';
        },
      });
    });
  });
</script>
@endpush