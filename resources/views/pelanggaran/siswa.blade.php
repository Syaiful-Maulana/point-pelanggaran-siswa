@extends('template.app')

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
                          <li class="breadcrumb-item">
                            <a href="{{ url('isiKelas')}}">Data Kelas</a>
                          </li>
                          <li class="breadcrumb-item active" aria-current="page">Daftar Siswa</li>
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
                                    <h3 class="h4 mb-0 text-center">{{ $siswa->nama}}</h3>
                                </div>
                                <ul class="list-unstyled mb-4">

                                    <li class="mb-3">
                                        <i class="fa fa-user display-25 me-3 text-secondary"></i>NISN : {{ $siswa->nisn}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="fa fa-school display-25 me-3 text-secondary"></i>Kelas : {{ $siswa->kelass}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-map-marker-alt display-25 me-3 text-secondary"></i>Alamat : {{ $siswa->alamat}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="fa fa-calendar display-25 me-3 text-secondary"></i>Tempat, Tanggal Lahir : {{$siswa->tempat}}, {{ $siswa->ttl}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="far fa-envelope display-25 me-3 text-secondary"></i> Jumlah Point : 
                                        {{$hitung}} 
                                    </li>
                                    {{-- <li class="mb-3">
                                        <i class="far fa-envelope display-25 me-3 text-secondary"></i> Bentuk Pelanggaran : @if ($hitung == 0)
                                        {{'-'}}
                                    @elseif( $hitung <= 25)
                                        <p>Pelanggaran Ringan</p>
                                    @elseif( $hitung <= 50)
                                        <p>Pelanggaran Sedang</p>
                                    @elseif( $hitung <= 90)
                                        <p>Pelanggaran Menengah</p>
                                    @else 
                                        <p>Pelanggaran Berat</p>
                                    @endif
                                        
                                    </li> --}}
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
                            @if (auth()->user()->level=='guru')
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-info" id="btn-tambah">
                                <i class="fas fa-plus-square"></i> Tambah Data
                            </button>
                                
                            @endif
                            <div class="overflow-auto">
                                <table class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-1">No.</th>
                                            <th class="col-lg-3">Pelanggaran</th>
                                            <th class="col-lg-1">Point</th>
                                            @if (auth()->user()->level=='guru')
                                            <th class="col-lg-3">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tbody>
                                            @foreach ($pelanggaran as $item)
                                            <tr>
                                              <td>{{ $loop->iteration}}</td>
                                              <td>{{ $item->bentuk}}</td>
                                              <td>{{ $item->bobot}}</td>
                                              @if (auth()->user()->level=='guru')
                                              <td>
                                                {{-- <button  class="edit btn btn-sm btn-warning" id="{{ $item->id}}" name="edit"><i class="fas fa-edit"></i> Edit</button> --}}
                                                <button class="hapus btn btn-sm btn-danger" id="{{ $item->id}}" name="hapus"><i class="fas fa-trash-alt"></i> Hapus</button>
                                              </td>
                                              @endif
                                            </tr>
                                            
                                            @endforeach
                                          </tbody>
                                </table>
                                {{-- <table class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="col-lg-1">Jumlah Point Siswa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($pelanggaran as $item)
                                        <tr>
                                            <td>
                                                @if ($item->bobot == null or $item->bobot==0)
                                                    {{ $bobot = 0}}
                                                @else
                                                {{$item->bobot}}
                                                @endif
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                </table> --}}
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
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
        <form action="{{ route('insertPelanggaran')}}" id="forms" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="nama_id" id="nama_id" value="{{$var_id}}" >
                    <input type="hidden" hidden class="form-control" id="id" name="id" >
                </div>
                <div class="form-group">
                    <label for="" hidden>kelas</label>
                    <input type="hidden" name="kelas_id" id="kelas_id" value="{{ $siswa->kelas_id}}">
                    {{-- <select name="kelas_id" id="kelas_id" class="form-control">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id}}">{{ $item->kelas}}</option>
                        @endforeach
                    </select> --}}
                </div>
                <div class="form-group">
                    <label for="">Bentuk Pelanggaran</label>
                    <select name="bentuk_id" id="bentuk_id" class="form-control">
                        <option value="">Pilih Kategori</option>
                        @foreach ($bentuk as $item)
                            <option value="{{ $item->id}}">{{ $item->bentuk}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="" hidden>Bentuk Pelanggaran</label>
                    <input type="text" class="form-control" hidden readonly autocomplete="off" value="0" name="bobot_id" id="bobot_id">
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
<script src="{{ asset('assets/table/datatables.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.4/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>

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
                // $('#table').DataTable().ajax.reload();
                location.reload();
                $('#forms')[0].reset();
                toastr.success(res.text, 'Sukses')
            }, 
            error: function(xhr){
                toastr.error(xhr.responseJSON.text, 'Gagal Menyimpan!')
            }
        })
    })

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
                $('#nisn_id').val(res.nisn_id)
                $('#kelas_id').val(res.kelas_id)
                $('#bentuk_id').val(res.bentuk_id)
                $('#bobot_id').val(res.bobot_id)
                $('#btn-tambah').click()
                $('#modal-info').on("hidden.bs.modal", function(){
                    location.reload();
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
                            // $('#table').DataTable().ajax.reload()
                            location.reload();

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
    // Input Harus Angka
        function number(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if(charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
</script>

@endpush