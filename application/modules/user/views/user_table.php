<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>
               <?php echo lang("users");?>                                
            </h2>
            <ul class="header-dropdown m-r--5">
                <?php if(CheckPermission("user", "own_create")){ ?>
                  <button type="button" class="btn btn-lg btn-primary waves-effect modalButtonUser" data-toggle="modal"><i class="material-icons">add</i> <?php echo lang('add_user'); ?></button>
                <?php } if(setting_all('email_invitation') == 1){  ?>
                  <button type="button" class="btn btn-lg btn-primary waves-effect InviteUser" data-toggle="modal"><i class="material-icons">add</i><?php echo lang('invite_people'); ?></button>
                <?php } ?>
            </ul>
          </div>
          <!-- /.box-header -->
          <div class="body table-responsive">           
            <table id="example1" class="table table-bordered table-striped table-hover delSelTable">
              <thead>
                <tr>
                  <th>
                    <input type="checkbox" class="selAll" id="basic_checkbox_1mka" />
                    <label for="basic_checkbox_1mka"></label>
                  </th>
                  <th><?php echo lang('user_type') ?></th>
									<th><?php echo lang('email') ?></th>
									<th><?php echo lang('name') ?></th>
									<th><?php echo lang('status') ?></th>
									<th><?php echo lang('create_date') ?></th>
									<?php  $cf = get_cf('user');
                    if(is_array($cf) && !empty($cf)) {
                      foreach ($cf as $cfkey => $cfvalue) {
                        echo '<th>'.lang(get_lang($cfvalue->rel_crud).'_'.get_lang($cfvalue->name)).'</th>';
                      }
                    }
                  ?>
                  <th><?php echo lang('Action'); ?></th>
                </tr>
              </thead>
              <tbody>
              </tbody> 
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
  </div>
  <!-- /.row -->
</section>
  <!-- /.content -->
<div class="modal fade" id="nameModal_user" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="defaultModalLabel"><?php echo lang('user_form'); ?></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div><!--End Modal Crud --> 
<script type="text/javascript">
  $(document).ready(function() {  
    var url = '<?php echo base_url();?>';
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          "processing": true,
          "serverSide": true,
          "ajax": url+"user/dataTable",
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
          "aoColumnDefs": [ 
            { "bSortable": false, "aTargets": [ 0 ] }
          ]
      });
    
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');

        $('.dataTables_info').before('<button data-del-url="<?php echo base_url().'user/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left"> <i class="material-icons col-red">delete</i> </button><br><br>');   
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
  });
</script>            