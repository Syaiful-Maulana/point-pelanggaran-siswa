@extends('template.app')

@section('title', 'Data Pelanggaran Siswa')

@section('content')
    <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <div class="title mb-30">
                      <h2>Daftar Siswa {{$siswa->nama}}</h2>
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
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Pelanggaran</h6>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-info" id="btn-tambah">
                                <i class="fas fa-plus-square"></i> Tambah Data
                            </button>
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
                                        @foreach ($data as $row)
                                            <tr>
                                                <th>{{ $loop->iteration}}</th>
                                                <th>{{ $row->bentuk}}</th>
                                                <th>{{ $row->bobot}}</th>
                                                {{-- <th></th> --}}
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Total Point</th>
                                            <th >{{ $point}}</th>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Siswa</h6>
                        </div>
                        {{-- <img src="https://www.bootdey.com/img/Content/avatar/avatar6.png" class="justify-content-center" width="200px" height="200px" alt="..."> --}}
                        <div class="card-body ">
                            
                                
                            <div class="overflow-auto">
                                <div class="mb-4 justify-content-center">
                                    <h3 class="h4 mb-0 text-center">{{ $siswa->nama}}</h3>
                                </div>
                                <ul class="list-unstyled mb-4">
                                    {{-- <i class="far fa-envelope display-25 me-3 text-secondary"></i>{{ $siswa->kelas}} --}}
                                    <li class="mb-3">
                                        <i class="far fa-envelope display-25 me-3 text-secondary"></i>{{ $pelanggaran->kelas}}
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-mobile-alt display-25 me-3 text-secondary"></i>{{ $siswa->alamat}}
                                    </li>
                                    <li>
                                        <i class="fas fa-map-marker-alt display-25 me-3 text-secondary"></i>{{$siswa->tempat}}, {{ $siswa->ttl}}
                                    </li>
                                </ul>
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
                    <input type="hidden" name="nama" id="nama" value="{{$var_id}}" >
                  </div>
              <div class="form-group">
                <input type="hidden" name="kelas" id="kelas" value="{{$var_id}}" >
              </div>
   
              <div class="form-group">
                  <label for="">Bentuk Pelanggaran</label>
                  <select name="bentuk" id="bentuk" class="form-control">
                      <option value="">Pilih Kategori</option>
                      @foreach ($bentuk as $item)
                          <option value="{{ $item->id}}">{{ $item->bentuk}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label for="">Point Pelanggaran</label>
                  <select name="bobot" id="bobot" class="form-control">
                      <option value="">Pilih Point</option>
                      @foreach ($bentuk as $item)
                          <option value="{{ $item->id}}">{{ $item->bobot}}</option>
                      @endforeach
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="{{ asset('assets/datatables/jquery.dataTables.js')}}"></script>
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
</script>

@endpush