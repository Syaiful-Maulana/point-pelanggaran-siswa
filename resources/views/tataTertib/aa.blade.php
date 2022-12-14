@extends('template.app')

@section('title', 'Bentuk Kategori')

@section('content')
    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Bentuk Pelanggaran</h1>
          <p class="mb-4">Berikut merupakan bentuk berdasarkan kategori pelanggaran di MA NU MAZROATUL HUDA</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Buku 2.0.1</h6>
            </div>
            <div class="card-body">
                 <a href="#" class="btn mb-3 btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#insertModal">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Tambah Data Buku</span>
                </a>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Buku</th>
                      <th>Nama Pengarang</th>
                      <th>Nama Penerbit</th>
                      <th>Ketebalan Buku</th>
                      <th>Ubah</th>
                      <th>Hapus</th>

                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($bentuk as $item)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>{{$item->kategori}}</td>
                      <td>{{$item->bentuk}}</td>
                      <th>{{$item->bobot}}</th>
                      <td>
                      <a href="ubah_buku/{{$item->id}}" class="btn btn-success btn-icon-split btn-sm">
                            <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Ubah</span>
                        </a>
                      </td>
                      <td>
                            <a href="hapus_item/{{$item->id}}" id="tombol-hapus" type="submit" class="btn btn-danger btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span class="text">Hapus</span>
                            </a>
                      </td>
                    </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
<!-- Modal -->
<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="insertModal">Input Data Buku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="user" method="POST" action="#" >
                @csrf
                <input type="hidden" name="id" value="#" >
                <div class="form-group">
                   <input id="name" type="text" class="form-control form-control-user " name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Judul Buku...">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                  <input id="pengarang" type="text" class="form-control form-control-user"  name="pengarang" value="{{ old('pengarang') }}" required autocomplete="pengarang" placeholder="Nama Pengarang...">
                    @error('pengarang')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                 <div class="form-group">
                  <input id="penerbit" type="text" class="form-control form-control-user"  name="penerbit" value="{{ old('penerbit') }}" required autocomplete="penerbit" placeholder="Nama Penerbit...">
                    @error('penerbit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                 <div class="form-group">
                  <input id="tebal" type="text" class="form-control form-control-user"  name="tebal" value="{{ old('tebal') }}" required autocomplete="tebal" placeholder="Jumlah Halaman...">
                    @error('tebal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                     <input id="thn_terbit" type="text" class="form-control form-control-user" onfocus="(this.type='date')" onblur="(this.type='text')" name="thn_terbit" required autocomplete="thn_terbit" placeholder="Tahun Terbit...">
                      @error('thn_terbit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                 </div>
                 <div class="form-group">
                  <input id="edisi" type="text" class="form-control form-control-user"  name="edisi" value="{{ old('edisi') }}" required autocomplete="edisi" placeholder="Edisi Buku...">
                    @error('edisi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                 <div class="form-group">
                  <input id="jumlah" type="text" class="form-control form-control-user"  name="jumlah" value="{{ old('jumlah') }}" required autocomplete="jumlah" placeholder="Jumlah Buku...">
                    @error('jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
        </div>
        </div>
    </div>
    </div>
@endsection