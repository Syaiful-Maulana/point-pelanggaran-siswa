@extends('templateSiswa.app')

@section('title', 'Sanksi Pelanggaran')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Sanksi Pelanggaran</h2>
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
                <li class="breadcrumb-item active" aria-current="page">Sanksi Pelanggaran</li>
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
                                        <table style="background-color:rgba(0, 0, 0, 0);" class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="col-lg-1">No.</th>
                                                    <th class="col-lg-2">Kriteria Pelanggaran</th>
                                                    <th class="col-lg-1">Bobot</th>
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
      </div>
      <!-- end row -->
    </div>
<div class="pindah">
    <a href="{{ url('bentuk1')}}" hidden></a>
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
        <form action="sanksi.store" method="POST" id="forms">
            @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="">Kriteria Pelanggaran</label>
                <input type="text" class="form-control" autocomplete="off" id="kriteria" name="kriteria" placeholder="Kriteria Pelanggaran">
                <input type="text" hidden class="form-control" id="id" name="id" placeholder="Nama Obat">
            </div>
            <div class="form-group">
                <label for="">Bobot</label>
                <input type="text" class="form-control" autocomplete="off" id="bobot" name="bobot" placeholder="Bobot Pelanggaran">
            </div>
            <div class="form-group">
                <label for="">Sanksi Pelanggaran</label>
                <input type="text" class="form-control" autocomplete="off" id="sanksi" name="sanksi" placeholder="Gunakan <br/> untuk mengganti baris">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="btn-tutup"  data-bs-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
    </div>
  </div>
<!-- /.modal -->

  
  <!-- Modal Lihat Sanksi-->
  @foreach ($data as $item)
      
  <div class="modal fade" id="modal-lihat{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sanksi dari {{$item->kriteria}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Berikut sanksi yang diberikan :</p>
            <p>{!! $item->sanksi!!}</p>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  @endforeach
<!-- /.modal -->
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
                url : "{{route('sanksiSiswa')}}"
            },
            columns: [
                {
                    data: null,
                    "sortable": false,
                    render: function(data, type, row, meta){
                        return meta.row+ meta.settings._iDisplayStart + 1;
                    } // Auto Numberinig
                },
                {data: 'kriteria', name: 'kriteria'},
                {data: 'bobot', name: 'bobot'},
                // {data: 'sanksi',name: 'sanksi'},
                // {data: 'sanksi', name: 'sanksi',odrderable: false},
                {data: 'aksi', name: 'aksi',odrderable: false},
            ]
        })
    }




</script>
@endpush