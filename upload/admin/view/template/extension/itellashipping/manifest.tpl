<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><img src="view/image/itellashipping/logo.png" alt="Itella Logo"></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <!-- Errors / Success -->
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php } ?>
    <?php if ($success) { ?>
      <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $success; ?>
      </div>
    <?php } ?>
  </div>
  <ul class="nav nav-tabs">
    <li <?=($active_tab == 'all' ? ' class="active"' : '');?>><a href="#tab-all" data-toggle="tab"><?php echo $tab_all . " ($order_total)"; ?></a></li>
    <li <?=($active_tab == 'manifest' ? ' class="active"' : '');?>><a href="#tab-manifest" data-toggle="tab"><?php echo $tab_manifest . " ($manifest_total)"; ?></a></li>
  </ul>
  <div class="tab-content">
    <!-- Ready Orders -->
    <div class="tab-pane <?=($active_tab == 'all' ? ' active' : '');?>" id="tab-all">
      <div class="container-fluid">
        <div class="panel panel-default">
        <form id="form-orders" method="POST">
            <!-- HEADER -->
          <div class="panel-heading">
            <div class="well">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="control-label" for="input-order-id"><?php echo $lng_id; ?></label>
                    <input type="text" name="filter_order_id" value="<?= $filter_order_id; ?>" placeholder="<?php echo $lng_id; ?>" id="input-order-id" class="form-control">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="input-customer"><?php echo $lng_customer; ?></label>
                    <input type="text" name="filter_customer" value="<?= $filter_customer; ?>" placeholder="<?php echo $lng_customer; ?>" id="input-customer" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="control-label" for="input-order-status"><?php echo $lng_status; ?></label>
                    <select name="filter_order_status" id="input-order-status" class="form-control">
                      <option value=""></option>
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $filter_order_status) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="input-tracking"><?php echo $lng_tracking_nr; ?></label>
                    <input type="text" name="filter_tracking" value="<?= $filter_tracking; ?>" placeholder="<?php echo $lng_tracking_nr; ?>" id="input-tracking" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="control-label" for="input-date-added"><?php echo $lng_date_added; ?></label>
                    <div class="input-group date">
                      <input type="text" name="filter_date_added" value="<?= $filter_date_added; ?>" placeholder="<?php echo $lng_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="input-date-modified"><?php echo $lng_date_modified; ?></label>
                    <div class="input-group date">
                      <input type="text" name="filter_date_modified" value="<?= $filter_date_modified; ?>" placeholder="<?php echo $lng_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                      </span>
                    </div>
                  </div>
                  <button onclick="itella_action='filter'" formaction="<?= $form_btn['filter']; ?>" type="submit" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $btn_filter; ?></button>
                  <?php if($filter): ?>
                    <button onclick="itella_action='filter'" formaction="<?= $form_btn['filter_reset']; ?>" type="submit" id="button-reset" class="btn btn-danger pull-right"><i class="fa fa-eraser"></i> <?php echo $btn_reset; ?></button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- BODY -->
          <div class="panel-body itella-info">
            <table class='table table-bordered table-hover itella-order-table'>
              <thead class='itella-order-head'>
                  <th>
                    <label class="checkbox-inline itella-checkbox">
                      <input type="checkbox" id="check_all_orders"><span><?= $lng_id; ?></span>
                    </label>
                  </th>
                  <th><?= $lng_customer; ?></th>
                  <th><?= $lng_tracking_nr; ?></th>
                  <th><?= $lng_status; ?></th>
                  <th><?= $lng_date_added; ?></th>
                  <th><?= $lng_date_modified; ?></th>
                  <th><?= $lng_actions; ?></th>
              </thead>
              <tbody id="order_table">
                <?php foreach($orders as $order): ?>
                  <tr class="itella-order-row <?= $order['itella_error'] ? ' alert-danger ' : ''; ?>">
                    <td data-checkbox>
                      <label class="checkbox-inline itella-checkbox">
                        <?php if(!$order['itella_error']): ?>
                          <input type="checkbox" value="<?= $order['order_id']; ?>" name="order_ids[]"
                            data-label="<?= $order['label_number']; ?>"
                          >
                        <?php endif; ?>
                        <span><?= $order['order_id']; ?></span>
                      </label>
                    </td>
                    <td><span class="itella-order-data"><?= $lng_customer; ?>: </span><a href="<?= $order['view']; ?>"><?= $order['customer']; ?></a></td>
                    <td><span class="itella-order-data"><?= $lng_tracking_nr; ?>: </span><?= $order['label_number']; ?></td>
                    <td><span class="itella-order-data"><?= $lng_status; ?>: </span><?= $order['order_status']; ?></td>
                    <td><span class="itella-order-data"><?= $lng_date_added; ?>: </span><?= $order['date_added']; ?></td>
                    <td><span class="itella-order-data"><?= $lng_date_modified; ?>: </span><?= $order['date_modified']; ?></td>
                    <td class='itella-order-actions'>
                      <?php if ($order['itella_error']): ?>
                        <?= $error_itella_error; ?>
                      <?php else: ?>
                        <?php foreach($order['actions'] as $action => $link): ?>
                          <a class="btn btn-default" href="<?= $link; ?>"><?= ${"btn_" . $action}; ?></a>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php if(!$orders): ?>
                  <tr>
                    <td colspan="7"><?= $lng_no_orders; ?></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
            
            <div class="text-center itella-mass-acctions">
              <button onclick="itella_action='mass_label_gen'" formaction="<?= $form_btn['mass_label_gen']; ?>" class="btn btn-default"><?= $btn_mass_generate; ?></button>
              <button onclick="itella_action='mass_label_print'" formaction="<?= $form_btn['mass_label_print']; ?>" class="btn btn-default"><?= $btn_mass_print; ?></button>
              <button onclick="itella_action='mass_manifest'" formaction="<?= $form_btn['mass_manifest_gen']; ?>" class="btn btn-default"><?= $btn_mass_manifest; ?></button>
            </div>
            <div class="text-center">"<?= $btn_mass_print; ?>", "<?= $btn_mass_manifest; ?>" <?= $lng_mass_action_notice; ?></div>

            <div class="text-center">
              <?=$pagination;?>
            </div>
          </div>
          <div class="panel-footer clearfix">
            <div class="pull-right">
              <!--  -->
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Manifest Tab -->
    <div class="tab-pane <?=($active_tab == 'manifest' ? ' active' : '');?>" id="tab-manifest">
      <input type="hidden" id="view-order-base-link" value="<?= $manifest_view_order; ?>">
      <div class="container-fluid">
        <div class="panel panel-default">
          <form>
          <div class="panel-heading">
            <!--  -->
          </div>
          <div class="panel-body itella-info">
            <table class='table table-bordered table-hover table-responsive'>
              <thead>
                  <th><?= $lng_id; ?></th>
                  <th><?= $lng_total_orders; ?></th>
                  <th><?= $lng_date_added; ?></th>
                  <th><?= $lng_actions; ?></th>
              </thead>
              <tbody>
                <?php foreach($manifests as $manifest): ?>
                  <tr>
                    <td><?= $manifest['id_itella_manifest']; ?></td>
                    <td>
                      <span><?= $manifest['order_total']; ?></span>
                      <a data-toggle="modal" data-target="#itella-order-modal" 
                        data-manifest='<?= $manifest['id_itella_manifest']; ?>' data-link="<?= $manifest['show_orders']; ?>" 
                        href='#'><?= $btn_show; ?></a>
                    </td>
                    <td><?= $manifest['date_added']; ?></td>
                    <td>
                      <a class="btn btn-default" href="<?= $manifest['print']; ?>"><?= $btn_print; ?></a>
                      <button type="button" data-id="<?= $manifest['id_itella_manifest']; ?>" data-type="call" data-href="<?= $manifest['call_courier']; ?>"
                        data-toggle="modal" data-target="#itella-modal" class="btn btn-primary">
                        <?= $btn_call_courier; ?>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php if(!$manifests): ?>
                  <tr>
                    <td colspan="4"><?= $lng_no_manifest; ?></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>

            <div class="text-center">
              <?=$manifest_pagination;?>
            </div>
          </div>
          <div class="panel-footer clearfix">
            <div class="pull-right">
              <!--  -->
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<div id="itella-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><img src="view/image/itellashipping/logo.png" alt="Itella Logo" class="itella-logo"><?= $lng_modal_title; ?></h4>
      </div>
      <div class="modal-body">
        <h4><?= $lng_modal_message; ?></h4>
        <table class="table table-striped">
          <tr>
            <td><?= $lng_modal_name; ?></td>
            <td><?= $call_info['name']; ?></td>
          </tr>
          <tr>
            <td><?= $lng_modal_address; ?></td>
            <td><?= $call_info['address']; ?></td>
          </tr>
          <tr>
            <td><?= $lng_modal_phone; ?></td>
            <td><?= $call_info['contact_phone']; ?></td>
          </tr>
          <tr>
            <td><?= $lng_modal_manifest_id; ?></td>
            <td><span id="attach-id"></span></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <a id="call-submit" class="btn btn-success" href="#"><?= $lng_modal_btn_call; ?></a>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= $lng_modal_btn_cancel; ?></button>
      </div>
    </div>
  </div>
</div>

<div id="itella-order-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title"><img src="view/image/itellashipping/logo.png" alt="Itella Logo" class="itella-logo"><?= $lng_modal_order_title; ?><span data-id>0</span></h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <th><?= $lng_id; ?></th>
            <th><?= $lng_customer; ?></th>
            <th><?= $lng_status; ?></th>
          </thead>
          <tbody id='manifest-orders-table'>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= $lng_modal_btn_cancel; ?></button>
      </div>
    </div>
  </div>
</div>

<style>
  .modal-content {
    max-height: 95vh;
  }

  .modal-body {
    max-height: 50vh;
    overflow: auto;
  }
  #button-reset {
    margin-right: 1em;
  }

  .modal-header span[data-id], .itella-info a[data-manifest] {
    padding: 0 0.5rem;
  }

  .page-header h1 img, .modal-header h4 img.itella-logo {
    height: 33px;
  }

  .modal-header h4 img.itella-logo {
    margin-right: 1em;
  }

  th .itella-checkbox {
    font-weight: 700;
  }

  .itella-checkbox input[type="checkbox"] {
    position: absolute;
  }

  .itella-mass-acctions {
    font-size: 0;
    margin-bottom: 1rem;
  }

  .itella-mass-acctions button {
    display: block;
    width: 100%;
    margin: 0;
  }

  .itella-mass-acctions button:not(:last-of-type) {
    margin-bottom: 1rem;
  }

  .itella-order-actions {
    font-size: 0;
  }

  .itella-order-actions > a:first-of-type {
    margin-right: 1em;
  }

  .itella-order-row > td .itella-order-data {
    display: none;
  }

  .itella-overlay {
    position: relative;
  }

  .itella-overlay::after {
    content: "<?= $lng_loading; ?>";
    font-size: 2em;
    font-weight: 600;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    background-color: rgba(255, 255, 255, 0.8);
    width: 100%;
    top: 0;
    bottom: 0;
  }

  @media (max-width: 935px) {
    .itella-order-actions > a {
      width: 100%;
    }

    .itella-order-actions > a:first-of-type {
      margin: 0;
      margin-bottom: 1em;
    }
  }

  @media (max-width: 768px) {
    .itella-order-actions > a {
      width: auto;
    }

    .itella-order-actions > a:first-of-type {
      margin: 0;
      margin-right: 1em;
    }

    .itella-order-table {
      border: none;
    }

    .itella-order-head {
      display: none;
    }

    .itella-order-row {
      display: flex;
      flex-direction: column;
      margin-bottom: 1.5em;
      border: 1px solid #aaa;
    }

    .itella-order-row > td {
      border: 0!important;
      border-bottom: 1px solid #ddd!important;
    }

    .itella-order-row > td .itella-order-data {
      display: inline;
      font-weight: 700;
    }
  }

  @media (min-width: 450px) {
    .itella-mass-acctions button{
      display: inline-block;
      width: auto;
    }

    .itella-mass-acctions button:not(:last-of-type) {
      margin-bottom: 0;
    }

    .itella-mass-acctions button:nth-of-type(2) {
      margin-left: 1rem;
      margin-right: 1rem;
    }
  }
</style>
<script>
  function registerItellaButtons() {
    window.itella_action = false;

    $('#itella-order-modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var link = button.data('link'); // Extract link from data-link
      var manifest_id = button.data('manifest'); // Extract manifest id from data-id
      var modal = $(this);
      modal.find('span[data-id]').text(manifest_id);
      document.getElementById('manifest-orders-table').innerHTML = '';
      showOverlay($('#itella-order-modal .modal-body'));
      $.ajax({
        type: 'GET',
        url: link,
        success: function (json) {
          json = JSON.parse(json);
          if (typeof json.success != 'undefined') {
            buildManifestOrderTable(json.data);
          }
          if (typeof json.error != 'undefined') {
            alert('Error: ' + json.error);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        },
        complete: function(jqXHR, status) {
          hideOverlay($('#itella-order-modal .modal-body'));
        }
      });
    });

    $('#itella-modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var href = button.data('href'); // Extract link from data-href
      var manifest_id = button.data('id'); // Extract manifest id from data-id
      var modal = $(this);
      modal.find('.modal-body #attach-id').text(manifest_id);
      document.getElementById('call-submit').href = href; // update "call" button link in modal
    });

    $('td[data-checkbox]').on('click', function(e){
      if (typeof e.target.dataset.checkbox == 'undefined') {
        return true; // pass event further up
      }
      var chk_box = $(this).find('input[type="checkbox"]');
      if(chk_box.length > 0) {
        chk_box[0].checked = !chk_box[0].checked;
      }
    });

    $('#form-orders').on('submit', function(e){
      if(itella_action != 'filter' && !validateSelection()) {
        e.preventDefault();
        return;
      }
    });
  }

  function showOverlay($target) {
    $target.addClass('itella-overlay');
  }

  function hideOverlay($target) {
    $target.removeClass('itella-overlay');
  }

  function buildManifestOrderTable(data) {
    var base_link = document.getElementById('view-order-base-link').value;
    var manifest_orders_table = document.getElementById('manifest-orders-table');

    if (data.length < 1) {
      manifest_orders_table.innerHTML = '<tr><td colspan="3"><?= $lng_no_orders; ?></td></tr>';
      return;
    }

    html = '';
    data.forEach(function(row) {
      html += '<tr>';
      html += '<td>' + row.order_id + '</td>';
      html += '<td><a href="' + base_link + row.order_id + '">' + row.customer + '</a></td>';
      html += '<td>' + row.order_status + '</td>';
      html += '</tr>';
    });

    manifest_orders_table.innerHTML = html;
  }

  function validateSelection() {
    // check that everythign selected
    var $selection = $('input[name^="order_ids"]:checked');
    if ($selection.length == 0) {
      alert('<?= $lng_no_order_selected?>');
      return false;
    }

    if (itella_action == 'mass_label_gen') { // get consent if order has label
      for(var i=0; i<$selection.length; i++) {
        if(typeof $selection[i].dataset.label != 'undefined' && $selection[i].dataset.label != '') {
          return confirm('<?= $lng_label_caution; ?>');
        }
      };
    }

    return true;
  }

  $(document).ready(function() {
    $('#check_all_orders').on('change', function(e){
      var state = this.checked;
      $('#order_table').find('input[type="checkbox"]').each(function (index, el) {
        el.checked = state;
      });
    });

    registerItellaButtons();
  });
</script>
<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>
<?php echo $footer; ?>