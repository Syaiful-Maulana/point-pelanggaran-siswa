<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<h1 style="margin-left: 40%">Data Pelanggaran Siswa</h1>

<table id="customers">
  <tr>
      <th>No.</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Pelanggaran</th>
    <th>Point Pelanggaran</th>
  </tr>
  @foreach ($data as $item)
      
  <tr>
    <td>{{ $loop->iteration}}</td>
    <td>{{ $item->nama}}</td>
    <td>{{ $item->kelas}}</td>
    <td>{{ $item->bentuk}}</td>
    <td>{{ $item->bobot}}</td>
  </tr>
  @endforeach
</table>

</body>
</html>


