@extends('partial.index')
@section('title', 'News Letter')
@section('content')

<div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title fw-semibold mt-2">News Letter</h5>
          <button id="button-add" class="btn btn-success" style="height: 20%">Add News Letter</button>
        </div>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>{{ session('success.status') }} </strong> {{ session('success.message') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="alert alert-danger alert-dismissible fade collapse" role="alert" id="custom_alert">
          <strong id="title_alert"> </strong><span id="message_alert"></span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="table-responsive">
          <table id="tb_newsletter" class="table table-stripped">
            <thead class="text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Kategori</th>
                    <th scope="col" hidden>Deskripsi</th>
                    <th scope="col">Rilis</th>
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

@section('modal')
<!-- Modal -->
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static" style="overflow-y: auto">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Add News Letter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/apps/news-letter" method="post" id="myform_submit">
              @csrf
              <input type="text" id="status_update" name="status_update" hidden>
              <input type="text" id="fc_newsletterid" name="fc_newsletterid" hidden>
              <div class="modal-body">
                <div class="form-group mb-1">
                  <label class="form-label">Judul Berita</label>
                  <input type="text" class="form-control" id="fv_title" name="fv_title" required>
                </div>
                <div class="form-group mb-1">
                  <label class="form-label">Kategori</label>
                  <select class="form-control select2" name="fv_category" id="fv_newscategory" style="width: 100%" required></select>
                </div>
                <div class="form-group mb-1">
                  <label class="form-label">Deskripsi</label>
                  <textarea class="form-control" name="ft_description" id="ft_description" rows="3" required></textarea>
                </div>
                <div class="form-group mb-1">
                  <label class="form-label">Penulis</label>
                  <input type="text" name="fv_writer" class="form-control" id="fv_writer" required>
                </div>
                <div class="form-group mb-1">
                  <label class="form-label">Link Sumber</label>
                  <input type="text" name="ft_linkresource" class="form-control" id="ft_linkresource">
                </div>
                <div class="form-group mb-1">
                  <label class="form-label">Tanggal Rilis</label>
                  <input type="date" name="fd_releasedate" class="form-control" id="fd_releasedate" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="newsletter_modal_detail" data-keyboard="false" data-backdrop="static" style="overflow-y: auto">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
          <div class="modal-header pb-0">
              <h5 class="modal-title" id="newsletter_title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body pt-2">
            <article id="newsletter_description" class="mb-3">
            </article>
            <figure class="text-end">
              <i><p id="newsletter_source"></p></i>
              <figcaption class="blockquote-footer">
                <cite title="Source Title" id="newsletter_writer"></cite>
              </figcaption>
            </figure>
          </div>
      </div>
  </div>
</div>
@endsection

@section('custom-js')
<script>
  var fv_category = "";

  $(document).ready(function() {
      get_category();
      $(".select2").select2({
        dropdownParent: $("#modal")
      });
  });

  $('#button-add').click(function(){
    $('#modal').modal('show');
  })

  function updateNewsLetter(fc_newsletterid) {
    var newId = window.btoa(fc_newsletterid);
    $('#modal_loading').modal('show');

    $.ajax({
      url: '/apps/news-letter/' + newId,
      method: 'GET',
      dataType: 'JSON',
      success: function(response){
        if (response.status){
          var data = response.data;
          $('#fc_newsletterid').val(fc_newsletterid);
          $('#fv_title').val(data.fv_title);
          $('#fv_writer').val(data.fv_writer);
          $('#fd_releasedate').val(data.fd_releasedate);
          $('#ft_description').val(data.ft_description);
          $('#ft_linkresource').val(data.ft_linkresource);
          $('#status_update').val("TRUE");
          fv_category = data.fv_category;
          get_category();
          $('#modal').modal('show')
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

  function get_category() {
    $.ajax({
      url: "/apps/news-letter/category",
      type: "GET",
      dataType: "JSON",
      success: function(response) {
          if (response.status === 200) {
              var data = response.data;
              $("#fv_newscategory").empty();
              $("#fv_newscategory").append(`<option value="" selected disabled> - Pilih - </option>`);

              if(( $('#status_update').val() !== null || $('#status_update').val() != "" ) && fv_category != "") {
                for (var i = 0; i < data.length; i++) {
                  if(fv_category == data[i].fc_trxcode) {
                    $("#fv_newscategory").append(`<option value="${data[i].fc_trxcode}" selected>${data[i].fc_description}</option>`);
                  } else {
                    $("#fv_newscategory").append(`<option value="${data[i].fc_trxcode}">${data[i].fc_description}</option>`);
                  }
                } 
              } else {
                for (var i = 0; i < data.length; i++) {
                  $("#fv_newscategory").append(`<option value="${data[i].fc_trxcode}">${data[i].fc_description}</option>`);
                }
              }
          } else {
              iziToast.error({
                  title: 'Error!',
                  message: response.message,
                  position: 'topRight'
              });
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          setTimeout(function() {
              $('#modal_loading').modal('hide');
          }, 500);
          swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
              icon: 'error',
          });
      }
    });
  }

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
          targets: [0,1,2,3,4,5],
        },
        {
          searchAble: true,
          targets: [1,2,3,4,5],
        }
      ],
      columns: [
          {
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex'
          },
          {
            data: 'fv_title', 
          },
          {
            data: 'category.fc_description'
          },
          {
            data: 'ft_description',
            visible: false
          },
          {
            data: 'fd_releasedate',
          },
          {
            data: 'fv_writer'
          },
          {
            data: null,
            "width": "20%"
          }
      ],
      rowCallback: function(row, data) {
          $('td:eq(5)', row).html(`
              <a class="btn btn-primary btn-sm mr-1" href="#" onclick="detailNewsLetter('${data.fc_newsletterid}')"><i class="fa fa-eye"></i> Detail</a>
              <a class="btn btn-warning btn-sm mr-1" href="#" onclick="updateNewsLetter('${data.fc_newsletterid}')"><i class="fa fa-edit"></i></a>
              <a id="button_delete" class="btn btn-danger btn-sm mr-1" onclick="delete_news('${data.fc_newsletterid}')"><i class="fa fa-trash"></i></a>
          `);
      }
  });

  function delete_news(fc_newsletterid){
    var newId = window.btoa(fc_newsletterid)
    $('#modal_loading').modal('show')

    $.ajax({
      url: '/apps/news-letter/'+newId,
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

  function detailNewsLetter(fv_newsletterid){
    var newid = window.btoa(fv_newsletterid);
    $('#modal_loading').modal('show');
    $.ajax({
      url: '/apps/news-letter/' + newid,
      method: 'GET',
      dataType: 'JSON',
      success: function(response) {
          if (response.status === 200) {
              var data = response.data;
              $('#newsletter_title').html(data['fv_title']);
              $('#newsletter_description').html(data['ft_description'])
              $('#newsletter_writer').html(data['fv_writer'])
              if (data['ft_linkresource'] != null || data['ft_linkresource'] != "") {
                $('#newsletter_source').html(`<a href="${data['ft_linkresource']}">${data['ft_linkresource']}</a>`)
              } 

              $('#newsletter_modal_detail').modal('show');
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
    });
  }
</script>
@endsection