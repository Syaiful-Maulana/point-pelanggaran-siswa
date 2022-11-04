@extends('templateSiswa.app')

@section('title', 'Kategori Pelanggaran')

@push('css')
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css"> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
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
            <h2>Kategori Pelanggaran</h2>
          </div>
        </div>
        <!-- end col -->
        <div class="col-md-6">
          <div class="breadcrumb-wrapper mb-30">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ url('homeSiswa')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Kategori Pelanggaran</li>
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
                                            <div class="overflow-auto">
                                                <table class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-lg-1">No.</th>
                                                            <th class="col-lg-4">Kategori</th>
                                                            {{-- <th class="col-lg-7">Aksi</th> --}}
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
      <!-- end row -->
    </div>
  </div>
  <!-- end container -->
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
                url : "{{route('kategoriSiswa')}}"
            },
            columns: [
                {
                    data: null,
                    "sortable": false,
                    render: function(data, type, row, meta){
                        return meta.row+ meta.settings._iDisplayStart + 1;
                    } // Auto Numberinig
                },
                {data: 'kategori', name: 'kategori'},
                // {data: 'aksi', name: 'aksi',odrderable: false},
            ]
        })
    }


</script>
<script>
    $(document).on('click', '.add', function(){
        let id = $(this).attr('id')
        $("a").attr("href", "/detail_pelanggaran_siswa/" + id)
    })
</script>

@endpush