<!-- Content Wrapper. Contains page content -->
<section class="content extensions-page">
  <div class="container-fluid">
    <div class="card">
      <div class="header">
        <h2><?php echo lang('extensions'); ?></h2>
        <ul class="header-dropdown m-r--5">
          <button class="btn btn-primary waves-effect add-extn-btn" type="button"> <i class="material-icons">add</i> <?php echo lang('add_extension'); ?> </button>
        </ul> 
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <blockquote class="m-b-25" style="display: none;">
              <form action="<?php echo base_url().'extension/install'; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <div class="form-line">
                    <input type="file" required name="extn_file" class="form-control" accept=".zip">
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary"><?php echo lang('install'); ?></button>
                  <input class="btn btn-danger cn-btn" type="reset" value="<?php echo lang('cancel'); ?>">
                </div>
              </form>
            </blockquote>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table class="table table-hover" id="extension_tbl">
                  <thead>
                    <tr>
                      <th><strong>#</strong></th>
                      <th><strong><?php echo lang('name'); ?></strong></th>
                      <th><strong><?php echo lang('status'); ?></strong></th>
                      <th><strong><?php echo lang('action'); ?></strong></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    data_table();

    $('body').on('click', '.ch-status', function() {
      $.post($('body').attr('data-base-url') + 'extension/upd_status', {status: $(this).attr('rel'), id : $(this).attr('data-id')}, function(data) {
          if(data) {
            //$('#extension_tbl').DataTable().ajax.reload();
            window.location.reload();
          }
        });  
    });

    $('.add-extn-btn').on('click', function() {
      $('blockquote').slideToggle('slow');
    });

    $('.cn-btn').on('click', function() {
      $('blockquote').slideUp('slow');
    })
  });

var data_table = function($filter, $search) {
  var url = "<?php echo base_url();?>";
  return table = $("#extension_tbl").DataTable({
    "dom": 'lfBrtip',
          "buttons": ['copy','excel','print'],
    "processing": true,
        "serverSide": true,
        "ajax": {
          "url" : url + "extension/ajx_data",
        "data": function ( d ) {
          if($filter != '') {
            $.each($filter, function(index, val) {
              d[index] = val;
            });
          }
        }
        },
        "sPaginationType": "full_numbers",
        "language": {
      "search": "_INPUT_", 
      "searchPlaceholder": "<?php echo lang('search'); ?>",
      "paginate": {
          "next": '<i class="material-icons">keyboard_arrow_right</i>',
          "previous": '<i class="material-icons">keyboard_arrow_left</i>',
          "first": '<i class="material-icons">first_page</i>',
          "last": '<i class="material-icons">last_page</i>'
      }
    },
    "iDisplayLength": 10,
    "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"<?php echo lang('all'); ?>"]],
    "columnDefs" : [
      {
        "orderable": false, 
        "targets": [0]
      }
      <?php if(!CheckPermission("extension", "all_delete") && !CheckPermission("extension", "own_delete")){ ?>
      ,{
        "targets": [0],
        "visible": false,
        "searchable": false
      }
            <?php } ?>
    ],
    "order": [[1, 'asc']],
    "oSearch": {"sSearch": $search}
  });
}
</script>
