@extends('template.app')

@section('title', 'Data Pelanggaran Siswa')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css')}}">
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.css"/> --}}
 

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
            <h2>Data Pelanggaran Siswa</h2>
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
                  <a href="{{ url('isiKelas')}}">Daftar Kelas</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
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
                                    {{-- <button type="button" class="btn btn-primary mb-4 mt-3" hidden  data-bs-toggle="modal" data-bs-target="#modal-info" id="btn-tambah">
                                        <i class="fas fa-plus-square"></i> Tambah Data
                                    </button> --}}
                                    <a href="{{ url('exportPDF')}}" type="button" class="btn btn-primary mb-4 mt-3">
                                        <i class="fas fa-file-import"></i> Export PDF
                                    </a>
                                    <div class="overflow-auto">
                                        <table class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="col-lg-1">No.</th>
                                                    <th class="col-lg-2">NISN</th>
                                                    <th class="col-lg-2">Nama</th>
                                                    <th class="col-lg-1">Kelas</th>
                                                    <th class="col-lg-3">Pelanggaran</th>
                                                    <th class="col-lg-2">Point Pelanggaran</th>
                                                    {{-- <th class="col-lg-2">Tgl Input</th> --}}
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
@push('js')
<script src="{{ asset('assets/datatables/datataTablesSiswa.min.js')}}"></script>
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
                url : "{{route('pelanggaran')}}"
            },
            columns: [
                {
                    data: null,
                    "sortable": false,
                    render: function(data, type, row, meta){
                        return meta.row+ meta.settings._iDisplayStart + 1;
                    } // Auto Numberinig
                },
                {data: 'nisn', name: 'nisn'},
                {data: 'nama', name: 'nama'},
                {data: 'kelas', name: 'kelas'},
                {data: 'bentuk', name: 'bentuk'},
                {data: 'bobot', name: 'bobot'},
                // {data: 'created_at', name: 'created_at'}

                // {data: 'aksi', name: 'aksi',odrderable: false},
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
        $('#forms').attr('action', "{{ route('pelanggaran.update')}}")
        let id = $(this).attr('id')
        $.ajax({
            url: "{{route('pelanggaran.edit')}}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res){
                console.log(res)
                $('#nama_id').val(res.nama_id)
                $('#id').val(res.id)
                $('#kelas_id').val(res.kelas_id)
                $('#bentuk_id').val(res.bentuk_id)
                $('#bobot_id').val(res.bobot_id)
                $('#btn-tambah').click()
                $('#modal-info').on("hidden.bs.modal", function(){
                    $('#forms')[0].reset()
                    $('#forms').attr('action', "{{ route('pelanggaran.store')}}")
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
            url: '{{ route('pelanggaran.delete')}}',
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
    // get point
    $(document).on('change', '#bentuk_id', function(){
        let id = $(this).val()
        $.ajax({
            url: "{{route('getPelanggaran')}}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}" 
            }, success: function(res){
                $('#bobot_id').val(res.data.bobot_id)
                console.log(res);
            }, error: function(xhr){
                console.log(xhr);
            }
        })
    })
          // Input Harus Angka
          function number(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if(charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
</script>


@endpush