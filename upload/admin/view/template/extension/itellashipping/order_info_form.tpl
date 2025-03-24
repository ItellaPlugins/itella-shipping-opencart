<div id="itella_panel" class="clearfix">
  <div class="panel panel-default col-md-6 itella-no-padding">
    <div class="panel-heading">
      <h3 class="panel-title"><img src="view/image/itellashipping/logo.png" class="itella-logo" alt="Smartposti Logo"><?= $itella_lng['title'] ?></h3>
      <?php if ($itella['data']['label_number'] and $itella['tracking_email_status']): ?>
      <a href="index.php?route=extension/shipping/itellashipping/ajax&action=resendEmail&id_order=<?= $itella['data']['id_order']; ?>&token=<?= $token; ?>"
        id="itella_resend_email_btn" class="btn btn-success"><i class="fa fa-envelope-o"></i><?= $itella_lng['resend_email']; ?></a>
      <?php endif; ?>
    </div>

    <?php if($itella['data']['error']): ?>
        <div class="col-xs-12">
          <div class="itella-error alert-danger">
            <?= $itella['data']['error']; ?>
          </div>
        </div>
    <?php endif;?>

    <form id="itella_order_form" class="panel-body itella-form">

      <div class="row">
        <div class="col-md-6">
          <label class="control-label"><?= $itella_lng['packets_total'] ?></label>
          <select id="itella-packs" name="packs" class="form-control">
            <?php for ($amount = 1; $amount <= 10; $amount++) : ?>
              <option value="<?= $amount; ?>"><?= $amount; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="control-label"><?= $itella_lng['weight'] ?></label>
          <input type="text" id="itella-weight" name="weight" value="<?= isset($itella['data']['weight']) ? $itella['data']['weight'] : 1; ?>" class="form-control" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <label class="control-label"><?= $itella_lng['cod'] ?></label>
          <select id="itella-cod" name="is_cod" class="form-control">
            <option value="0"><?= $itella_lng['no'] ?></option>
            <option value="1" <?= (isset($itella['data']['is_cod']) && $itella['data']['is_cod'] == 1 ? 'selected' : ''); ?>><?= $itella_lng['yes'] ?></option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="control-label"><?= $itella_lng['cod_amount'] ?></label>
          <input id="itella-cod-amount" type="text" name="cod_amount" disabled="disabled" class="form-control" 
            value="<?= isset($itella['data']['cod_amount']) ? $itella['data']['cod_amount'] : $itella['order_total']; ?>" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label class="control-label"><?= $itella_lng['carrier'] ?></label>
          <select id="itella-carrier" name="is_pickup" class="form-control">
            <option value="0"><?= $itella_lng['courier'] ?></option>
            <option value="1" <?= $itella['data']['is_pickup'] ? 'selected' : ''; ?>><?= $itella_lng['pickup'] ?></option>
          </select>
          <span class="help-block"><?= $itella_lng['attention'] ?></span>
        </div>
      </div>

      <div class="row pickup-point-container">
        <div class="col-md-12">
          <label class="control-label"><?= $itella_lng['pickup_point'] ?></label>
          <select name="id_pickup_point" class="form-control js-select2" style="width: 100%">
            <option value="0"></option>
          </select>
        </div>
      </div>

      <div class="row extra-services-container">
        <div class="col-md-12">

          <div class="itella-extra-header">
            <div class="row">
              <div class="col-xs-12">
                <span><?= $itella_lng['extra'] ?></span>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-xs-12">
              <?php foreach(array('oversized', 'call_before_delivery', 'fragile') as $key): ?>
                <label class="checkbox-inline">
                <input type="checkbox" value="is_<?= $key; ?>" name="itella_extra[]" 
                  <?= ($itella['data']['is_' . $key] ? 'checked="checked"' : ''); ?>>
                <?= $itella_lng[$key] ?>
              </label>
              <?php endforeach; ?>
              
              <label class="checkbox-inline disabled" id="multi_parcel_chb">
                <input id="itella-multi" type="hidden" name="itella_extra[]" value="is_multi" disabled="disabled">
                <input disabled="disabled" type="checkbox" checked>
                <?= $itella_lng['multi'] ?>
              </label>
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label class="control-label"><?= $itella_lng['comment'] ?></label>
          <input id="itella-comment" type="text" name="comment" class="form-control" 
            value="<?= $itella['data']['comment'] ?>" />
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="ajaxresponse">
          </div>
        </div>
      </div>

    </form>

    <div class="panel-footer itella-footer">
      <span>
        <a href="index.php?route=extension/shipping/itellashipping/ajax&action=printLabel&id_order=<?= $itella['data']['id_order']; ?>&token=<?= $token; ?>"
          target="_blank" data-disabled="<?= ($itella['data']['label_number'] ? 'false' : 'true'); ?>"
          id="itella_print_label_btn" class="btn btn-success"><i class="fa fa-file-pdf-o"></i><?= $itella_lng['print'] ?></a>
      </span>
      <span>
        <button type="submit" name="itella_save_cart_info" id="itella_save_cart_info_btn" class="btn btn-success"><i class="fa fa-save"></i><?= $itella_lng['save'] ?></button>
        <button type="submit" name="itella_generate_label" id="itella_generate_label_btn" class="btn btn-success"><i class="fa fa-tag"></i><?= $itella_lng['generate'] ?></button>
      </span>
    </div>

  </div>
</div>

<style type="text/css">
  #itella_panel {
    display: flex;
  }

  #itella_panel .panel-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .itella-form > .row:not(:last-of-type) {
    margin-bottom: 1em;
  }

  .itella {
    margin: 0;
  }

  .itella-no-padding {
    padding: 0;
  }

  .itella-logo {
    height: 17px;
    padding-right: 5px;
  }

  .itella-footer {
    height: auto !important;
    display: flex;
    justify-content: space-between;
  }

  .itella-footer .btn {
    text-transform: uppercase;
    font-weight: 700;
  }

  .itella-extra-header {
    padding-top: 1em;
    padding-bottom: 0.5em;
    font-size: 1.1em;
    font-weight: 900;
  }

  #itella_print_label_btn,
  #itella_save_cart_info_btn,
  #itella_generate_label_btn {
    border: none;
    /* margin-bottom: 1em; */
  }

  #itella_print_label_btn {
    background-color: #0b7489;
  }

  #itella_print_label_btn[data-disabled="true"] {
    -webkit-box-shadow: none;
    box-shadow: none;
    cursor: not-allowed;
    filter: alpha(opacity=65);
    opacity: .65;
    pointer-events: none;
  }

  #itella_save_cart_info_btn {
    background-color: #829191;
    margin-right: 1em;
  }

  #itella_generate_label_btn {
    background-color: #6eb257;
  }

  #itella_panel .panel-heading .btn .fa,
  .itella-footer .btn .fa {
    padding-right: 5px;
  }

  .itella .field-row {
    margin-bottom: 1em;
  }

  #itella_panel .ajaxresponse {
    margin-top: 1em;
  }

  .itella-overlay {
    position: relative;
  }

  .itella-overlay::after {
    content: "<?= $itella_lng['loading'] ?>";
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

  .itella-error {
    padding: 10px;
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 3px;
  }
</style>

<script type="text/javascript">
  function initItellaForm() {
    var itella_prefix = '<?= $itella_lng['prefix']; ?> ';
    var itella_full_data = <?= json_encode($itella); ?>;
    var itella_data = itella_full_data.data;
    var itella_label = itella_data.label_number;
    var itella_form = document.getElementById('itella_order_form');
    var packs = document.getElementById('itella-packs');
    var weight = document.getElementById('itella-weight');
    var is_cod = document.getElementById('itella-cod');
    var cod_amount = document.getElementById('itella-cod-amount');
    var is_pickup = document.getElementById('itella-carrier');
    var is_multi = document.getElementById('itella-multi');
    var $pickup_points = $('#itella_panel select[name="id_pickup_point"]');
    var $extra_services = $('#itella_panel .extra-services-container');
    var $response = $('#itella_panel .ajaxresponse');
    var itella_buttons = {
      resend_email: document.getElementById('itella_resend_email_btn'),
      print: document.getElementById('itella_print_label_btn'),
      save: document.getElementById('itella_save_cart_info_btn'),
      generate: document.getElementById('itella_generate_label_btn')
    }

    console.log('Working', <?= json_encode($itella); ?>);

    fillItellaData();

    $(packs).on('change', function(e) {
      toggleMultiParcel();
    });
    $(is_cod).on('change', function(e) {
      toggleCodAmount();
    });

    $(is_pickup).on('change', function(e) {
      togglePickupPoints();
    });

    $(itella_buttons.print).on('click', function(e) {
      if (typeof itella_buttons.print.dataset.disabled != 'undefined' && itella_buttons.print.dataset.disabled == 'true') {
        e.preventDefault();
      }
    });

    $(itella_buttons.save).on('click', function(e) {
      e.preventDefault();

      if (is_pickup.value == '1' && $pickup_points.val() == 0) {
        warning('{l s="Pickup point not selected" mod="itellashipping"}');
        return false;
      }
      let form_data = new FormData(itella_form);
      saveItellaCart(form_data);
    });

    $(itella_buttons.generate).on('click', function(e) {
      e.preventDefault();

      if (itella_label && !confirm('Generating new label will replace existing one. Continue?')) {
        return;
      }

      generateItellaLabel(new FormData(itella_form));
    });

    $(itella_buttons.resend_email).on('click', function(e) {
      e.preventDefault();

      showOverlay();
      $.ajax({
        type: "GET",
        url: this.href,
        processData: false,
        contentType: false,
        cache: false,
        success: function(res) {
          res = JSON.parse(res);
          if (typeof res.error != 'undefined') {
            showResponse(res.error, 'danger');
          }
          if (typeof res.success != 'undefined') {
            showResponse(res.success, 'success');
          }
        },
        complete: function(jqXHR, status) {
          hideOverlay();
        }
      });
    });

    function fillItellaData() {
      packs.value = itella_data.packs;
      weight.value = itella_data.weight ? itella_data.weight : 1;
      is_cod.value = itella_data.is_cod;
      cod_amount.value = itella_data.cod_amount;
      is_pickup.value = itella_data.is_pickup;
      toggleCodAmount();
      //togglePickupPoints();
      toggleMultiParcel();
      $response.hide();
      loadPickupPoints();
    }

    function toggleCodAmount() {
      cod_amount.disabled = is_cod.value == '0';
    }

    function togglePickupPoints() {
      if (is_pickup.value == '1') {
        $('.pickup-point-container').show();
        disableExtraServices();
      } else {
        $('.pickup-point-container').hide();
        enableExtraServices();
      }
    }

    function disableExtraServices() {
      // reset packs to 1
      packs.value = 1;
      $(packs).trigger('change');

      packs.disabled = true;
      is_multi.disabled = true;

      $extra_services.hide();
    }

    function enableExtraServices() {
      packs.disabled = false;
      is_multi.disabled = false;
      toggleMultiParcel();
      $extra_services.show();
    }

    function toggleMultiParcel() {
      var $multi = $('#multi_parcel_chb');
      if (parseInt(packs.value) > 1) {
        $multi.show();
        is_multi.disabled = false;
      } else {
        $multi.hide();
        is_multi.disabled = true;
      }
    }

    function showOverlay() {
      $('#itella_panel').addClass('itella-overlay');
    }

    function hideOverlay() {
      $('#itella_panel').removeClass('itella-overlay');
    }

    function saveItellaCart(form_data) {
      form_data.set('id_order', '<?= $itella['data']['id_order']; ?>');
      form_data.set('pickup_label', 'Itella: ' + $pickup_points.find('option:selected').text().trim());

      disableButtons();
      showOverlay();
      $.ajax({
        type: "POST",
        url: "index.php?route=extension/shipping/itellashipping/ajax&action=save&token=<?= $token; ?>&store_id=0",
        //async: false,
        processData: false,
        contentType: false,
        cache: false,
        data: form_data,
        success: function(res) {
          res = JSON.parse(res);
          console.log(res);
          if (typeof res.error != 'undefined') {
            showResponse(res.error, 'danger');
          }
          if (typeof res.success != 'undefined') {
            showResponse(res.success, 'success');
            itella_label = false; // this will disable print as it will need new label
          }
        },
        complete: function(jqXHR, status) {
          enableButtons();
          hideOverlay();
        }
      });
    }

    function generateItellaLabel(form_data) {
      form_data.set('id_order', '<?= $itella['data']['id_order']; ?>');

      disableButtons();
      showOverlay();
      $.ajax({
        type: "POST",
        url: "index.php?route=extension/shipping/itellashipping/ajax&action=generateLabel&token=<?= $token; ?>",
        processData: false,
        contentType: false,
        cache: false,
        data: form_data,
        success: function(res) {
          res = JSON.parse(res);
          console.log(res);
          if (typeof res.error != 'undefined') {
            showResponse(res.error, 'danger');
          }
          if (typeof res.success != 'undefined') {
            showResponse(res.success, 'success');
            itella_label = res.tracking_number;
          }
        },
        complete: function(jqXHR, status) {
          enableButtons();
          hideOverlay();
        }
      });
    }

    function disableButtons() {
      itella_buttons.save.disabled = true;
      itella_buttons.generate.disabled = true;
      itella_buttons.print.dataset.disabled = true;
    }

    function enableButtons() {
      itella_buttons.save.disabled = false;
      itella_buttons.generate.disabled = false;
      if (itella_label) {
        itella_buttons.print.dataset.disabled = false;
      }
    }

    function warning(text) {
      if (!!$.prototype.fancybox) {
        $.fancybox.open([{
          type: 'inline',
          autoScale: true,
          minHeight: 30,
          content: '<p class="fancybox-error">' + text + '</p>'
        }], {
          padding: 0
        });
      } else {
        alert(text);
      }
    }

    function showResponse(msg, type) {
      console.log(msg, type);
      $response.removeClass('alert alert-danger alert-success');
      $response.addClass('alert alert-' + type);
      $response.html('');
      var ol = document.createElement('ol');
      var li = document.createElement('li');
      li.innerText = msg;
      ol.appendChild(li);
      $response.append(ol);
      $response.show();
    }

    function buildDropdown(terminals) {
      var html = [];
      var address = '';
      if (!terminals) {
        terminals = [];
      }
      terminals.forEach(function(terminal) {
        if (terminal.address.postalCodeName != null && terminal.address.postalCodeName != '') {
          address += terminal.address.postalCodeName;
        } else {
          address += terminal.address.municipality;
        }

        if (terminal.address.address != null && terminal.address.address != '') {
          address += ' - ' + terminal.address.address + ', ' + terminal.address.postalCode;
        } else {
          address += ' - ' + terminal.address.streetName + ' ' + terminal.address.streetNumber + ', ' + terminal.address.postalCode;
        }

        html.push('<option value="itellashipping.pickup_' + terminal.pupCode + '">' + address + ' (' + terminal.publicName + ')</option>');

        address = '';
      });
      $pickup_points.append($(html.join('')));
    }

    function selectCurrentMethod() {
      var current_method = '<?= $itella['shipping_code']; ?>';
      var method_parts = current_method.split('.');
      if (method_parts[0] == 'itellashipping' && method_parts[1] != 'courier') {
        $pickup_points.val(current_method);
        $pickup_points.trigger('change');
        is_pickup.value = 1;
        togglePickupPoints();
      } else { // assume courier
        is_pickup.value = 0;
        togglePickupPoints();
      }
    }

    function loadPickupPoints() {
      disableButtons();
      showOverlay();
      $.ajax({
        url: '<?php echo $catalog; ?>index.php?route=extension/module/itellashipping/ajax&action=getTerminals&token=' + token + '&store_id=0',
        type: 'post',
        data: {
          'order_info': '1',
          'country_id': '<?= $itella['country_id']; ?>',
          'zone_id': '<?= $itella['zone_id']; ?>'
        },
        dataType: 'json',
        crossDomain: true,
        beforeSend: function() {
          //$('#button-shipping-address').button('loading');
        },
        complete: function() {
          //$('#button-shipping-address').button('reset');
          enableButtons();
          hideOverlay();
        },
        success: function(json) {
          //console.log(json);
          var terminals = JSON.parse(json.terminals);
          buildDropdown(terminals);
          selectCurrentMethod();
        }
      });
    }

    window.itellaLoadPickupPoints = loadPickupPoints;

  }
</script>
<link rel="stylesheet" href="view/javascript/itellashipping/select2.min.css">
<script src="view/javascript/itellashipping/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.js-select2').select2({
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
      placeholder: {
        id: '0', // the value of the option
        text: 'Select pickup point'
      }
    });
  });
</script>