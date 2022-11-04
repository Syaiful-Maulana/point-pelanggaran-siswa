@extends('template.app')

@section('title', 'Data Admin')

@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@include('sweetalert::alert')
<div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Data Siswa</h2>
          </div>
        </div>
        <!-- end col -->
        <div class="col-md-6">
          <div class="breadcrumb-wrapper mb-30">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ url('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Data Admin</li>
              </ol>
            </nav>
          </div>
        </div>
        <!-- end col -->
        <div class="card">
            <div class="card-body">
                <section class="content">
                    <div class="container-fluid">
                        <div class="py-12" >
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-left: 30px">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                    {{-- Button Modal --}}
                                    <button type="button" class="btn btn-primary mb-4 mt-3"  data-bs-toggle="modal" data-bs-target="#modal-info" id="btn-tambah">
                                        <i class="fas fa-plus-square"></i> Tambah Data
                                    </button>
                                    <div class="overflow-auto">
                                        <table class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="col-lg-1">No.</th>
                                                    <th class="col-lg-2">Nama</th>
                                                    <th class="col-lg-3">Username</th>
                                                    <th class="col-lg-3">Email</th>
                                                    <th class="col-lg-3">Level</th>
                                                    <th class="col-lg-3">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
      <!-- End Col -->
      </div>
      <!-- end row -->
    </div>
  </div>
  <!-- end container -->
@endsection
@section('modal')
    
  <!-- Modal -->
  <div class="modal fade" id="modal-info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Info Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ url('admin.store')}}" method="POST" id="forms">
            @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="">Nama User</label>
                <input type="text" class="form-control" autocomplete="off" id="name" name="name" placeholder="Nama User">
                <input type="text" hidden class="form-control" id="id" name="id">
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="form-control" autocomplete="off" id="username" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" autocomplete="off" id="email" name="email" placeholder="email">
            </div>
            <div class="form-group">
                <label for="">Level</label>
                <select type="text"  id="level" name="level" class="form-control" autofocus>
                    <option value="">-- Pilih --</option>
                    <option value="admin" >Admin</option>
                    <option  value="guru">Guru</option>
                </select>                
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" autocomplete="off" id="password" name="password" placeholder="password">
            </div>
        </div>
        <div class="modal-footer" >
            <button type="button" class="btn btn-danger" id="btn-tutup"  data-bs-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
    </div>
  </div>
<!-- /.modal -->

@endsection
@push('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="{{ asset('assets/datatables/jquery.dataTables.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.4/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready( function () {
    loaddata();
    });
    function loaddata(){
       $('#table').DataTable({
            serverside: true,
            processing: true,
            ajax: {
                url : "{{route('admin')}}"
            },
            columns: [
                {
                    data: null,
                    "sortable": false,
                    render: function(data, type, row, meta){
                        return meta.row+ meta.settings._iDisplayStart + 1;
                    } // Auto Numberinig
                },
                {data: 'name', name: 'name'},
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'level', name: 'level'},
                {data: 'aksi', name: 'aksi',odrderable: false},
            ]
        })
    }
   // add data
   $(document).on('submit', 'form', function (event){
       event.preventDefault();
       $.ajax({
           url: $(this).attr('action'),
            type: $(this).attr('method'),
            typeData: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(res){
                console.log(res);
                $('#btn-tutup').click()
                $('#table').DataTable().ajax.reload();
                // location.reload();
                $('#forms')[0].reset();
                toastr.success(res.text, 'Sukses')
            }, 
            error: function(xhr){
                toastr.error(xhr.responseJSON.text, 'Gagal Menyimpan!')
            }
        })
    })

    // Edit Data
    $(document).on('click', '.edit', function(){
        $('#forms').attr('action', "{{ route('admin.update')}}")
        let id = $(this).attr('id')
        $.ajax({
            url: "{{route('admin.edit')}}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res){
                console.log(res)
                $('#name').val(res.name)
                $('#id').val(res.id)
                $('#username').val(res.username)
                $('#email').val(res.email)
                $('#password').val(res.password)
                $('#btn-tambah').click()
                $('#modal-info').on("hidden.bs.modal", function(){
                    $('#forms')[0].reset()
                    $('#forms').attr('action', "{{ route('admin.store')}}")
                    })
            },
            error: function(xhr){
                console.log(xhr)
            }
        })
    })

</script>
@endpush