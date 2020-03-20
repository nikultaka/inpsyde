<style>
    .dataTables_filter {
        display:none;
    }
</style>       

<div class="loading">
    <img  class="loader" src="<?php echo plugins_url('website-custom-plugin/WCP/assets/images/loader.gif'); ?>" />
</div>

<div class="flex_container" style="padding-top:20px;">
    <div class="col-sm-12">
        <div class="col-sm-6">
            <h3>Users List</h3>
        </div>

        <div style="padding-bottom:10px;">
            <div style="clear:both;"></div>
        </div>
        <div class="">
            <table id='service-table' class="table table-bordered">
                <thead>
                    <tr>
                        <th class="all">ID</th>
                        <th class="all">Name</th>
                        <th class="all">Username</th>
                        <th class="all">Email</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal" id="user_detail" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Details</h5>
        <button type="button" class="close close_modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-3">Name</div>
                <div class="col-md-9" id="name"></div>
            </div>
            <div class="row">
                <div class="col-md-3">Username</div>
                <div class="col-md-9" id="username"></div>
            </div>  
            <div class="row">
                <div class="col-md-3">Email</div>
                <div class="col-md-9" id="email"></div>
            </div>
            <div class="row">
                <div class="col-md-3">Address</div>
                <div class="col-md-9" id="address"></div>
            </div>
            <div class="row">
                <div class="col-md-3">Phone</div>
                <div class="col-md-9" id="phone"></div>
            </div>
            <div class="row">
                <div class="col-md-3">Website</div>
                <div class="col-md-9" id="website"></div>
            </div>
            <div class="row">
                <div class="col-md-3">Company Name</div>
                <div class="col-md-9" id="company_name"></div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close_modal" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<script>
    
    jQuery(document).ready(function(){
        $ = jQuery;
        reload_table();
    });
    jQuery(".close_modal").click(function() {
        jQuery("#user_detail").hide(); 
    });
    function reload_table() {
        jQuery('#service-table').dataTable({
            "paging": true,
            "pageLength": 10,
            "bProcessing": true,
            "serverSide": true,
            "bDestroy": true,
            "ordering": false,
            "ajax": {
                type: "post",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {"action": "WCP_BackEnd_Users_Controller::get_data"}

            },
            "aoColumns": [
                {mData: 'id'},
                {mData: 'name'},
                {mData: 'username'},
                {mData: 'email'},
            ],
            "order": []
        });
    }
    
    function get_user_data(id) {
        jQuery(".loading").show();
        jQuery.ajax({
            type : 'POST',
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {"action": "WCP_BackEnd_Users_Controller::get_user_detail","id":id},
            dataType : 'json',
            success : function(msg) {   
                jQuery(".loading").hide();
                jQuery("#name").html(msg.name);
                jQuery("#username").html(msg.username);
                jQuery("#email").html(msg.email);
                jQuery("#address").html(msg.address);
                jQuery("#phone").html(msg.phone);
                jQuery("#website").html(msg.website);
                jQuery("#company_name").html(msg.company_name);
                jQuery("#user_detail").show();
            }
        })
    }
</script>
