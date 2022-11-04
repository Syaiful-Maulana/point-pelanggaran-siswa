@extends('templateSiswa.app')

@section('title', 'Data Pelanggaran Siswa')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/table/datatables.min.css')}}">
@endpush

@section('content')
    <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <div class="title mb-30">
                      <h2>Daftar Pelanggaran Siswa</h2>
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
                          <li class="breadcrumb-item active" aria-current="page">Data Pelanggaran Siswa</li>
                        </ol>
                      </nav>
                    </div>
                  </div>

                  <div class="col-md-6" style="margin-left: 25%" >
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Siswa</h6>
                        </div>
                        <div class="card-body ">
                            <div class="overflow-auto">
                                <div class="mb-4 justify-content-center">
                                    <h3 class="h4 mb-0 text-center">{{ auth()->user()->nama}}</h3>
                                </div>
                                <ul class="list-unstyled mb-4">

                                    <li class="mb-3">
                                        <i class="fa fa-user display-25 me-3 text-secondary"></i>NISN : {{ auth()->user()->nisn}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="fa fa-school display-25 me-3 text-secondary"></i>Kelas : {{ auth()->user()->kelas->kelas}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-map-marker-alt display-25 me-3 text-secondary"></i>Alamat : {{  auth()->user()->alamat}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="fa fa-calendar display-25 me-3 text-secondary"></i>Tempat, Tanggal Lahir : {{auth()->user()->tempat}}, {{ auth()->user()->ttl}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="far fa-envelope display-25 me-3 text-secondary"></i> Jumlah Point : 
                                        {{$hitung}} 
                                    </li>
                                    <li class="mb-3">
                                        <i class="far fa-envelope display-25 me-3 text-secondary"></i> Sanksi : 
                                        @if ($hitung == 0)
                                            {{-- <p>-</p> --}}
                                          {{'-'}}
                                        @elseif( $hitung <= 25)
                                            <p>1. Ditegur dan diperingatkan Wali Kelas</p>
                                            <p>2. Diberi sanksi edukatif</p>
                                            <p>3. Membuat surat pernyataan yang diketahui Wali Murid dan Wali Kelas</p>
                                        @elseif( $hitung <= 50)
                                            <p>1. Diserahkan Wali Kelas untuk dibina/diberi peringatan</p>
                                            <p>2. Diserahkan Guru BP / Kepala Madrasah untuk dibina</p>
                                            <p>3. Orang tua wali murid di datangkan ke madrasah</p>
                                        @elseif( $hitung <= 90)
                                            <p>1. Skorsing 4 (empat) hari</p>
                                            <p>2. Tidak diijinkan mengikuti test semester, UN / UM dan tidak naik kelas</p>
                                        @else 
                                            <p>1. Dikembalikan kepada orang tua / wali murid dan atau dikeluarkan dari madrasah / sekolah</p>
                                            <p>2. Diserahkan kepada pihak yang berwajib</p>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- DataTales Example -->
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Pelanggaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="overflow-auto">
                                <table class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-1">No.</th>
                                            <th class="col-lg-3">Pelanggaran</th>
                                            <th class="col-lg-1">Point</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tbody>
                                            @foreach ($pelanggaran as $item)
                                            <tr>
                                              <td>{{ $loop->iteration}}</td>
                                              <td>{{ $item->bentuk}}</td>
                                              <td>{{ $item->bobot}}</td>
                                            </tr>
                                            
                                            @endforeach
                                          </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
  @endsection

@push('js')
<script src="{{ asset('assets/table/datatables.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.4/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>



    //get kelas
    $(document).on('change', '#bentuk_id', function(){
        let id = $(this).val()
        $.ajax({
            url: "{{route('getPelanggaran')}}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}" 
            }, success: function(res){
                $('#bobot_id').val(res.data.bobot)
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