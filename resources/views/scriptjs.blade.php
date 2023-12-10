<script>
    function reset_all_select() {
      $('.select2').each(function() {
         var name = $(this).attr("name");
         $('[name="' + name + '"]').select2().trigger('change');
      });

      $('.selectric').each(function() {
         var name = $(this).attr("name");
         $('[name="' + name + '"]').selectric();
      });
   }

    $('#form_submit').on('submit', function(e) {
      e.preventDefault();

      var form_id = $(this).attr("id");
      var formData = new FormData($('#form_submit')[0]);
        // Cek apakah input dengan nama 'image_file' ada dan memiliki file terpilih
      var imageInput = $('#customFile')[0];
      if (imageInput && imageInput.files.length > 0) {
         formData.append('image_file', imageInput.files[0]);
      }
      if (check_required(form_id) === false) {
         swal("Oops! Mohon isi field yang kosong", {
            icon: 'warning',
         });
         return;
      }

      swal({
            title: 'Yakin?',
            text: 'Apakah anda yakin akan menyimpan data ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
         })
         .then((save) => {
            if (save) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url: $('#form_submit').attr('action'),
                  type: $('#form_submit').attr('method'),
                  data: formData,
                  contentType: false,
                   processData: false,
                  // data: $('#form_submit').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#form_submit")[0].reset();
                        reset_all_select();
                        tb.ajax.reload(null, false);

                     } else if (response.status == 201) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        location.href = response.link;
                     } else if (response.status == 203) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        tb.ajax.reload(null, false);
                     } else if (response.status == 300) {
                        swal(response.message, {
                           icon: 'error',
                        });
                     }
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });
</script>