@extends('template.app')

@section('title', 'Daftar Siswa')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css')}}">
@endpush

@section('content')
    <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <div class="title mb-30">
                      <h2>Daftar Siswa {{$kelas->kelas}}</h2>
                      <p class="mb-4">Berikut merupakan daftar siswa berdasarkan kelas di MA NU MAZROATUL HUDA</p>
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

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Pelanggaran</h6>
            </div>
            <div class="card-body">
                @if (auth()->user()->level == 'admin')
                    
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-info" id="btn-tambah">
                    <i class="fas fa-plus-square"></i> Tambah Data
                </button>
                @endif
                <div class="overflow-auto">
                    <table class="table table-stripped table-bordered text-center"  id="table" style="width: 100%">
                        <thead>
                            <tr>
                                @if (auth()->user()->level == 'guru')
                                <th class="col-lg-1">No.</th>
                                <th class="col-lg-2">NIS</th>
                                <th class="col-lg-2">Nama</th>
                                <th class="col-lg-1">Tempat Lahir</th>
                                <th class="col-lg-1">Tanggal Lahir</th>
                                <th class="col-lg-1">Jenis Kelamin</th>
                                <th class="col-lg-2">Alamat</th>
                                @endif
                                @if (auth()->user()->level == 'admin')
                                <th class="col-lg-1">No.</th>
                                <th class="col-lg-2">NIS</th>
                                <th class="col-lg-2">Nama</th>
                                <th class="col-lg-1">Tempat Lahir</th>
                                <th class="col-lg-2">Tanggal Lahir</th>
                                <th class="col-lg-1">Jenis Kelamin</th>
                                <th class="col-lg-1">Alamat</th>
                                <th class="col-lg-3">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>00{{$item->nisn}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->tempat}}</td>
                                <td>{{$item->ttl}}</td>
                                <td>{{$item->jekel}}</td>
                                <td>{{$item->alamat}}</td>
                                @if (auth()->user()->level == 'admin')
                              <td>
                                <button  class="edit btn btn-sm btn-warning" id="{{ $item->id}}" name="edit"><i class="fas fa-edit"></i> Edit</button>
                                <button class="hapus btn btn-sm btn-danger" id="{{ $item->id}}" name="hapus"><i class="fas fa-trash-alt"></i> Hapus</button>
                              </td>
                              @endif
                            </tr>
                              @endforeach
                          </tbody>
                    </table>
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
        <form action="{{ route('insertSiswa')}}" id="forms" method="POST">
            @csrf
        <div class="modal-body">
            <input type="hidden" name="kelas_id" id="kelas_id" value="{{$var_id}}" >
                <div class="form-group">
                    <label for="">NISN</label>
                    <input type="text"  maxlength="9" class="form-control" autocomplete="off" id="nisn" name="nisn" placeholder="NISN Siswa">
                    <input type="text" hidden class="form-control" id="id" name="id">
                </div>
                <div class="form-group">
                    <label for="">password</label>
                    <input type="password" class="form-control" autocomplete="off" id="password" name="password" placeholder="Password">
                    <input type="text" hidden class="form-control" id="id" name="id">
                </div>
                <div class="form-group">
                    <label for="">Nama Siswa</label>
                    <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" placeholder="Nama Siswa">
                </div>
                <div class="form-group">
                    <label for="">Tempat Lahir</label>
                    <input type="text" class="form-control" autocomplete="off" id="tempat" name="tempat" placeholder="Tempat Lahir">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input  type="date"  
                            name="ttl" 
                            id="ttl"
                            autocomplete="off"
                            class="form-control" 
                            placeholder="Tanggal Lahir"
                            autofocus>
                </div>
                <div class="form-group">
                    <label for="">Alamat</label>
                    <input type="text" class="form-control" autocomplete="off" id="alamat" name="alamat" placeholder="Alamat">
                </div>
                <div class="form-group">
                    <label for="">Jenis Kelamin</label>
                    <select type="text" name="jekel" class="form-control" autofocus>
                        <option value="">-- Pilih --</option>
                        <option value="Laki - Laki" >Laki - Laki</option>
                        <option  value="Perempuan">Perempuan</option>
                    </select>                
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
<script src="{{ asset('assets/datatables/datataTablesSiswa.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.4/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  $(document).ready( function () {
      $('#table').DataTable();
  });
</script>
<script>

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
                location.reload();
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
        $('#forms').attr('action', "{{ route('siswa.update')}}")
        let id = $(this).attr('id')
        $.ajax({
            url: "{{route('siswa.edit')}}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res){
                console.log(res)
                $('#nama').val(res.nama)
                $('#id').val(res.id)
                $('#nisn').val(res.nisn)
                $('#kelas').val(res.kelas)
                $('#tempat').val(res.tempat)
                $('#ttl').val(res.ttl)
                $('#alamat').val(res.alamat)
                $('#siswa').val(res.siswa)
                $('#btn-tambah').click()
                $('#modal-info').on("hidden.bs.modal", function(){
                    $('#forms')[0].reset()
                    $('#forms').attr('action', "{{ route('siswa.store')}}")
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
              title: 'Yakin?',
        text: "Kamu akan menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus data ini!'
                }).then((result) => {
                if (result.isConfirmed) {
            $.ajax({
                url: '{{ route('siswa.delete')}}',
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
                                location.reload()
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