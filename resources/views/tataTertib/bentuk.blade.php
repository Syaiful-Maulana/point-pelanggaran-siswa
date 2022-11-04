@extends('template.app')

@section('title', 'Kategori Pelanggaran')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css')}}">
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
            <h2>Bentuk Pelanggaran</h2>
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
                <li class="breadcrumb-item">
                  <a href="{{ url('bentuk1')}}">Kategori Bentuk Pelanggaran</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Data Bentuk Pelanggaran</li>
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
                                        @if (auth()->user()->level=='admin')
                                            <a href="{{ url('exportExcel')}}" type="button"  class="btn btn-success mb-4 mt-3" >
                                                <i class="fas fa-file-export"></i> Export Excel
                                            </a>
                                            <!-- Button trigger modal -->
                                            <a href="#"  type="button" class="btn btn-primary mb-4 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-file-import"></i>
                                                Import Data
                                            </a>
                                        @endif
                                    {{-- export excel --}}
                                    <div class="overflow-auto">
                                        <table class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="col-lg-1">No.</th>
                                                    <th class="col-lg-3">Kategori</th>
                                                    <th class="col-lg-3">Bentuk</th>
                                                    <th class="col-lg-2">Bobot</th>
                                                    {{-- <th class="col-lg-3">Aksi</th> --}}
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('importExcel')}}" method="POST" id="forms">
                @csrf
            <div class="modal-body">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="file" id="file" required>
                    </div>
                </div>
            <div class="modal-footer" >
                <button type="button" class="btn btn-danger" id="btn-tutup"  data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
  {{-- end modal --}}

@endsection
@push('js')
<script src="{{ asset('assets/datatables/datatables.min.js')}}"></script>
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
                url : "{{route('bentuk')}}"
            },
            columns: [
                {
                    data: null,
                    "sortable": false,
                    render: function(data, type, row, meta){
                        return meta.row+ meta.settings._iDisplayStart + 1;
                    } // Auto Numberinig
                },
                {data: 'kategoris', name: 'kategoris'},
                {data: 'bentuk', name: 'bentuk'},
                {data: 'bobot', name: 'bobot'},
                // {data: 'aksi', name: 'aksi',odrderable: false},
            ]
        })
    }

    // import excel

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
        $('#forms').attr('action', "{{ route('bentuk.update')}}")
        let id = $(this).attr('id')
        $.ajax({
            url: "{{route('bentuk.edit')}}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res){
                console.log(res)
                $('#bentuk').val(res.bentuk)
                $('#id').val(res.id)
                $('#kategori').val(res.kategori)
                $('#bobot').val(res.bobot)
                $('#btn-tambah').click()
                $('#modal-info').on("hidden.bs.modal", function(){
                    $('#forms')[0].reset()
                    $('#forms').attr('action', "{{ route('bentuk.store')}}")
                    })
                // $('#forms')[0].reset();
            },
            error: function(xhr){
                console.log(xhr)
            }
        })
    })

    // Hapus
$(document).on('click', '.hapus', function(){
    let id = $(this).attr('id')
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
        $.ajax({
            url: '{{ route('bentuk.delete')}}',
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res, status){
                if(status = '200'){
                    setTimeout(() => {
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            title: 'Data Berhasil Di Hapus',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(res=>{
                            $('#table').DataTable().ajax.reload()
                        })
                    });
                }
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Data Gagal Di Hapus'
                    })
                }
            })
        }
        })
    })
    @if(Session::has('success'))   
        toastr.success('{{Session::get('success')}}')
    @endif

</script>

@endpush