@extends('template.app')

@section('title', 'Bentuk Kategori')

@section('content')
<div class="container-fluid">
  <!-- ========== title-wrapper start ========== -->
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="title mb-30">
          <h2>Bentuk Pelanggaran</h2>
          <p class="mb-4">Berikut merupakan bentuk berdasarkan kategori pelanggaran di MA NU MAZROATUL HUDA</p>
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
              <li class="breadcrumb-item active" aria-current="page">Bentuk Pelanggaran</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- end col -->
      <div class="row">
        @foreach ($kategori as $item)
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kategori {{$item->kategori}}</div>
                @php
                    $i = 1;
                @endphp
                <div class="h5 mt-3 mb-3 font-weight-bold text-gray-800">{{$bentuk = DB::table('bentuks')->where('kategori', '=', $item->id)->count()}} Data</div>
                @php
                $i++
                @endphp
                <a href="detail_pelanggaran/{{$item->id}}" class="mt-3 btn btn-primary btn-sm btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                <span class="text">Lihat Detail</span>
              </a>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- end card --}}
         @endforeach
      </div>
    <!-- End Col -->
    </div>
    <!-- end row -->
  </div>
</div>
<!-- end container -->


</div>
@endsection
@section('aa')

@endsection
