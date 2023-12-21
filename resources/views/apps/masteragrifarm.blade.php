@extends('partial.index')
@section('title', 'News Letter')
@section('content')

<div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title fw-semibold mt-2">Urban Agriculture</h5>
          <button id="button-add" class="btn btn-success" style="height: 20%">Add Agri</button>
        </div>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>{{ session('success.title') }} </strong> {{ session('success.message') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="alert alert-danger alert-dismissible fade collapse" role="alert" id="custom_alert">
          <strong id="title_alert"> </strong><span id="message_alert"></span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="table-responsive">
          <table id="tb_agrifarm" class="table table-stripped">
            <thead class="text-center">
                <tr>
                    <th scope="col">Kode Tanaman</th>
                    <th scope="col">Nama Tanaman</th>
                    <th scope="col">Rilis</th>
                    <th scope="col">Creator</th>
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

@section('modal')
<!-- Modal -->
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static" style="overflow-y: auto">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Add Agri Farm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/apps/agri-farm" method="post" id="myform_submit">
              @csrf
              <input type="text" id="status_update" name="status_update" hidden>
              <input type="text" id="fv_agricode" name="fv_agricode" hidden>
              <div class="modal-body">
                <div class="form-group mb-1">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" id="fv_agriname" name="fv_agriname" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
  $('#button-add').click(function(){
    $('#modal').modal('show');
  })

  $('#myform_submit').submit(function(){
    $('#modal').modal('hide');
    $('#modal_loading').modal('show');
  })

  function update_agrifarm(fv_agricode) {
    var newId = window.btoa(fv_agricode);
    $('#modal_loading').modal('show');

    $.ajax({
      url: '/apps/agri-farm/' + newId,
      method: 'GET',
      dataType: 'JSON',
      success: function(response){
        if (response.status){
          var data = response.data;
          $('#fv_agriname').val(data.fv_agriname);
          $('#modal').modal('show');
          $('#status_update').val('TRUE');
          $('#fv_agricode').val(fv_agricode);
        } else {
          iziToast.error({
            title: 'Error!',
            message: response.message,
            position: 'topRight'
          });
        }
        setTimeout(() => {
          $('#modal_loading').modal('hide')
        }, 300);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        setTimeout(function() {
            $('#modal_loading').modal('hide');
        }, 500);
        swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
            icon: 'error',
        });
      } 
    })
  }

  var table = $('#tb_agrifarm').DataTable({
      processing: true,
      serverSide: true,
      destroy: true,
      ajax: {
        url: '/apps/agri-farm/list',
        type: 'GET'
      },
      columnDefs: [
        {
          className: 'text-center',
          targets: [0,1,2,3,4],
        },
        {
          searchAble: true,
          targets: [0,1,2,3,4],
        },
        
      ],
      columns: [
          {
            data: 'fv_agricode', 
          },
          {
            data: 'fv_agriname',
          },
          {
            data: 'created_at',
            render: formatTimestamp
          },
          {
            data: 'created_by'
          },
          {
            data: null,
            "width": "20%"
          }
      ],
      rowCallback: function(row, data) {
          $('td:eq(4)', row).html(`
              <a class="btn btn-warning btn-sm mr-1" href="#" onclick="update_agrifarm('${data.fv_agricode}')"><i class="fa fa-edit"></i></a>
              <a id="button_delete" class="btn btn-danger btn-sm mr-1" onclick="delete_agri('${data.fv_agricode}')"><i class="fa fa-trash"></i></a>
          `);
      }
  });

  function delete_agri(fv_agricode){
    var newId = window.btoa(fv_agricode)
    $('#modal_loading').modal('show')

    $.ajax({
      url: '/apps/agri-farm/'+newId,
      method: 'DELETE',
      dataType: 'JSON',
      success: function(response) {
          if (response.status === 200) {
              table.ajax.reload();
              var data = response.data;
              $('#title_alert').html(data.title + ` `)
              $('#message_alert').html(data.message)
              $('#custom_alert').addClass('show')
              $('#custom_alert').removeClass('collapse')
          } else {
              iziToast.error({
                  title: 'Error!',
                  message: response.message,
                  position: 'topRight'
              });
          }
          setTimeout(() => {
            $('#modal_loading').modal('hide')
          }, 300);
      },
      error: function(jqXHR, textStatus, errorThrown) {
          setTimeout(function() {
              $('#modal_loading').modal('hide');
          }, 500);
          swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
              icon: 'error',
          });
      } 
    })
  }
</script>
@endsection