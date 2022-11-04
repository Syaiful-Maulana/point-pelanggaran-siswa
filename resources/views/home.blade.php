@extends('template.app')

@section('title', 'home')

@section('content')

<section class="section">
    <div class="container-fluid">
      <!-- ========== title-wrapper start ========== -->
      <div class="title-wrapper pt-30">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="title mb-30">
              <h2>Data</h2>
            </div>
          </div>
          <!-- end col -->
          <div class="col-md-6">
            <div class="breadcrumb-wrapper mb-30">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#0">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- ========== title-wrapper end ========== -->
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon purple">
              <i class="lni lni-library"></i>
            </div>
            <div class="content">
              <h6 class="mb-10">Kategori Pelanggaran</h6>
              <h3 class="text-bold mb-10">{{ $kategori}}</h3>
            </div>
          </div>
          <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon success">
              <i class="lni lni-apartment"></i>
            </div>
            <div class="content">
              <h6 class="mb-10">Jumlah Kelas</h6>
              <h3 class="text-bold mb-10">{{ $kelas}}</h3>
            </div>
          </div>
          <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon primary">
              <i class="lni lni-users"></i>
            </div>
            <div class="content">
              <h6 class="mb-10">Jumlah Siswa</h6>
              <h3 class="text-bold mb-10">{{ $siswa}}</h3>
            </div>
          </div>
          <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon orange">
              <i class="lni lni-book"></i>
            </div>
            <div class="content">
              <h6 class="mb-10">Jumlah Pelanggar</h6>
              <h3 class="text-bold mb-10">{{ $pelanggar}}</h3>
            </div>
          </div>
          <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
      </div>
      <div class="row">
        <div class="col-md-6">
          {{-- <div id="chart"></div> --}}
        </div>
        <div class="col-md-6">
          {{-- <div id="bulat"></div> --}}
        </div>
      </div>
      
      <!-- End Row -->
    </div>
    <!-- end container -->
   
</section>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.4/dist/sweetalert2.all.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
  Highcharts.chart('chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Data Siswa'
    },
    xAxis: {
        // categories: {!!json_encode($kategoris)!!},
        categories: ,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Siswa'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Total',
        // data: {!! json_encode($data)!!}
        data:

    }]
});
</script>
<script>
  // Make monochrome colors
var pieColors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

// Build the chart
Highcharts.chart('bulat', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares at a specific website, 2014'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            colors: pieColors,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: 'Share',
        data: [
            { name: 'Chrome', y: 61.41 },
            { name: 'Internet Explorer', y: 11.84 },
            { name: 'Firefox', y: 10.85 },
            { name: 'Edge', y: 4.67 },
            { name: 'Safari', y: 4.18 },
            { name: 'Other', y: 7.05 }
        ]
    }]
});
</script>
<script>
  @if (session('status'))
    Swal.fire({
      position: 'top-center',
      icon: 'success',
      title: 'Selamat datang di halaman admin',
      showConfirmButton: false,
      timer: 1500
    })
  @endif

</script>

@endpush