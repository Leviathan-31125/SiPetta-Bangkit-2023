@extends('partial.index')
@section('title', 'News Letter')
@section('content')
<div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">News Letter</h5>
        <div class="table-responsive">
          <table id="tb_newsletter" class="table table-stripped">
            <thead class="text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Tanggal Rilis</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('custom-js')
<script>
  var table = $('#tb_newsletter').DataTable({
      processing: true,
      serverSide: true,
      destroy: true,
      ajax: {
        url: '/apps/news-letter/list',
        type: 'GET'
      },
      columnDefs: [
        {
          className: 'text-center',
          targets: [0,1,2,3,4,5]
        }
      ],
      columns: [
          {
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex'
          },
          {
            data: 'fv_tittle', 
          },
          {
            data: 'ft_description', 
          },
          {
            data: 'fd_releasedate',
          },
          {
            data: 'fv_writer'
          },
          {
            data: null
          }
      ],
      rowCallback: function(row, data) {
          $('td:eq(5)', row).html(`
              <a class="btn btn-primary btn-sm mr-1" href="#"><i class="fa fa-eye"></i> Detail</a>
              <a class="btn btn-warning btn-sm mr-1" href="#"><i class="fa fa-edit"></i></a>
              <a class="btn btn-danger btn-sm mr-1" href="#"><i class="fa fa-trash"></i></a>
          `);
      }
  });
</script>
@endsection