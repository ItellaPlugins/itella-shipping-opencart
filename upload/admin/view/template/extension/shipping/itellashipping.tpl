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
      <span class="itella-version">v<?= $itella_version; ?></span>
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
  <!-- DB CHECK -->
  <div class="container-fluid">
    <?php if ($db_check): ?>
      <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?= $db_fix_notify; ?> 
        <a href="<?= $db_fix_url; ?>" class="btn btn-success"><?= $button_fix_db; ?></a>
      </div>
    <?php endif; ?>
  </div>
  <!-- XML CHECK -->
  <div class="container-fluid">
    <?php if ($xml_check): ?>
      <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?= $xml_fix_notify; ?> 
        <a href="<?= $xml_fix_url; ?>" class="btn btn-success"><?= $button_fix_xml; ?></a>
      </div>
    <?php endif; ?>
  </div>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-api" data-toggle="tab"><?php echo $tab_api; ?></a></li>
    <li><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
    <li><a href="#tab-sender-info" data-toggle="tab"><?php echo $tab_sender_info; ?></a></li>
    <li><a href="#tab-price" data-toggle="tab"><?php echo $tab_price; ?></a></li>
    <li><a href="#tab-cod" data-toggle="tab"><?php echo $tab_cod; ?></a></li>
    <li><a href="#tab-pickuppoints" data-toggle="tab"><?php echo $tab_pickuppoints; ?></a></li>
    <li><a href="#tab-tracking-email" data-toggle="tab"><?php echo $tab_tracking_email; ?></a></li>
    <li><a href="#tab-advanced" data-toggle="tab"><?php echo $tab_advanced; ?></a></li>
  </ul>

  <!-- API Settings -->
  <div class="tab-content">
    <div class="tab-pane active" id="tab-api">
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cogs"></i> <?php echo $text_api_settings; ?></h3>
          </div>
          <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-itellashipping-api" class="form-horizontal">
              <input type="hidden" name="api_settings_update">
 
              <div class="panel panel-default">
                <div class="panel-heading bold"><?php echo $entry_api_2711; ?></div>
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="input-api-user"><?php echo $entry_api_user; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="itellashipping_api_user_2711" value="<?php echo $itellashipping_api_user_2711; ?>" placeholder="<?php echo $entry_api_user; ?>" id="input-api-user" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="input-api-pass"><?php echo $entry_api_pass; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="itellashipping_api_pass_2711" value="<?php echo $itellashipping_api_pass_2711; ?>" placeholder="<?php echo $entry_api_pass; ?>" id="input-api-pass" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="input-api-contract"><?php echo $entry_api_contract; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="itellashipping_api_contract_2711" value="<?php echo $itellashipping_api_contract_2711; ?>" placeholder="<?php echo $entry_api_contract; ?>" id="input-api-contract" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="panel panel-default">
                <div class="panel-heading bold"><?php echo $entry_api_2317; ?></div>
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="input-api-user-2"><?php echo $entry_api_user; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="itellashipping_api_user_2317" value="<?php echo $itellashipping_api_user_2317; ?>" placeholder="<?php echo $entry_api_user; ?>" id="input-api-user-2" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="input-api-pass-2"><?php echo $entry_api_pass; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="itellashipping_api_pass_2317" value="<?php echo $itellashipping_api_pass_2317; ?>" placeholder="<?php echo $entry_api_pass; ?>" id="input-api-pass-2" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="input-api-contract-2"><?php echo $entry_api_contract; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="itellashipping_api_contract_2317" value="<?php echo $itellashipping_api_contract_2317; ?>" placeholder="<?php echo $entry_api_contract; ?>" id="input-api-contract-2" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="input-api-contract-3"><?php echo $entry_api_contract_gls; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="itellashipping_api_contract_2317_gls" value="<?php echo $itellashipping_api_contract_2317_gls; ?>" placeholder="<?php echo $entry_api_contract_gls; ?>" id="input-api-contract-3" class="form-control" />
                      <p class="help-block"><?php echo $text_api_contract_gls_help; ?></p>
                    </div>
                  </div>
                </div>
              </div>

            </form>
          </div>

          <div class="panel-footer clearfix">
            <div class="pull-right">
              <button type="submit" form="form-itellashipping-api" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Module Settings -->
    <div class="tab-pane" id="tab-general">
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
          </div>
          <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-itellashipping" class="form-horizontal">
              <input type="hidden" name="module_settings_update">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
                <div class="col-sm-10">
                  <select name="itellashipping_tax_class_id" id="input-tax-class" class="form-control">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($tax_classes as $tax_class) { ?>
                      <?php if ($tax_class['tax_class_id'] == $itellashipping_tax_class_id) { ?>
                        <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                      <?php } else { ?>
                        <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="itellashipping_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                      <?php if ($geo_zone['geo_zone_id'] == $itellashipping_geo_zone_id) { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                      <?php } else { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="itellashipping_status" id="input-status" class="form-control">
                    <?php if ($itellashipping_status) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_sort_order" value="<?php echo $itellashipping_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </form>
          </div>

          <div class="panel-footer clearfix">
            <div class="pull-right">
              <button type="submit" form="form-itellashipping" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Sender Settings -->
    <div class="tab-pane" id="tab-sender-info">
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_sender_settings; ?></h3>
          </div>
          <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-itellashipping-sender" class="form-horizontal">
              <input type="hidden" name="sender_settings_update">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sender-name"><?php echo $entry_sender_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_sender_name" value="<?php echo $itellashipping_sender_name; ?>" placeholder="<?php echo $entry_sender_name; ?>" id="input-sender-name" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sender-street"><?php echo $entry_sender_street; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_sender_street" value="<?php echo $itellashipping_sender_street; ?>" placeholder="<?php echo $entry_sender_street; ?>" id="input-sender-street" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sender-postcode"><?php echo $entry_sender_postcode; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_sender_postcode" value="<?php echo $itellashipping_sender_postcode; ?>" placeholder="<?php echo $entry_sender_postcode; ?>" id="input-sender-postcode" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sender-city"><?php echo $entry_sender_city; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_sender_city" value="<?php echo $itellashipping_sender_city; ?>" placeholder="<?php echo $entry_sender_city; ?>" id="input-sender-city" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_sender_country; ?></label>
                <div class="col-sm-10">
                  <select name="itellashipping_sender_country" class="js-select-sender" style="width: 100%">
                      <option value=""></option>
                    <?php foreach ($countries as $country) : ?>
                      <option value="<?= $country['iso_code_2']; ?>"
                        <?= ($country['iso_code_2'] == $itellashipping_sender_country ? 'selected' : ''); ?>><?= $country['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sender-phone"><?php echo $entry_sender_phone; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_sender_phone" value="<?php echo $itellashipping_sender_phone; ?>" placeholder="<?php echo $entry_sender_phone; ?>" id="input-sender-phone" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sender-email"><?php echo $entry_sender_email; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_sender_email" value="<?php echo $itellashipping_sender_email; ?>" placeholder="<?php echo $entry_sender_email; ?>" id="input-sender-email" class="form-control" />
                </div>
              </div>
            </form>
          </div>

          <div class="panel-footer clearfix">
            <div class="pull-right">
              <button type="submit" form="form-itellashipping-sender" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Price Settings -->
    <div class="tab-pane" id="tab-price">
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money"></i> <?php echo $text_price_settings; ?></h3>
          </div>
          <div class="panel-body">
            <p class="help-block"><?= $text_price_help; ?></p>
            <div id="price-table" class="form-horizontal">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_price_country; ?></label>
                    <div class="col-sm-10">
                      <select name="country" class="js-select2" style="width: 100%" data-placeholder="<?php echo $entry_price_country_placeholder; ?>">
                        <?php foreach ($countries as $country) : ?>
                          <option value="<?= $country['iso_code_2']; ?>"><?= $country['name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <p class="help-block"><?= $text_price_help_country; ?></p>
                    </div>

                  </div>
                  <div class="form-group">

                    <label class="col-sm-2 control-label" for="input-pickup-price"><?php echo $entry_price_pickup; ?></label>
                    <div class="col-sm-4">
                      <input type="text" name="pickup_price" value="" placeholder="<?php echo $entry_price_pickup; ?>" id="input-pickup-price" class="form-control" />
                    </div>

                    <label class="col-sm-2 control-label" for="input-pickup-price-free"><?php echo $entry_price_free; ?></label>
                    <div class="col-sm-4">
                      <input type="text" name="pickup_price_free" value="" placeholder="<?php echo $entry_price_free; ?>" id="input-pickup-price-free" class="form-control" />
                    </div>

                  </div>

                  <div class="form-group">

                    <label class="col-sm-2 control-label" for="input-courier-price"><?php echo $entry_price_courier; ?></label>
                    <div class="col-sm-4">
                      <input type="text" name="courier_price" value="" placeholder="<?php echo $entry_price_courier; ?>" id="input-courier-price" class="form-control" />
                    </div>

                    <label class="col-sm-2 control-label" for="input-courier-price-free"><?php echo $entry_price_free; ?></label>
                    <div class="col-sm-4">
                      <input type="text" name="courier_price_free" value="" placeholder="<?php echo $entry_price_free; ?>" id="input-courier-price-free" class="form-control" />
                    </div>

                  </div>
                  <div class="form-group text-center">
                    <button id="add-price-btn" class="btn btn-default center"><?php echo $button_add_price; ?></button>
                  </div>
                </div>
                <div class="panel-body table-responsive">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th><?php echo $entry_price_country; ?></th>
                        <th><?php echo $entry_price_pickup; ?></th>
                        <th><?php echo $entry_price_free; ?></th>
                        <th><?php echo $entry_price_courier; ?></th>
                        <th><?php echo $entry_price_free; ?></th>
                        <th><?php echo $text_actions; ?></th>
                      </tr>
                    </thead>
                    <tbody id="created-prices">
                      <tr id="no-price-notification" style="<?= ($itellashipping_prices ? 'display: none' : ''); ?>">
                        <td colspan="6">No prices set</td>
                      </tr>
                      <?php foreach ($itellashipping_prices as $price) : ?>
                        <tr data-price-row="<?= $price['country']; ?>" data-price-data='<?= json_encode($price); ?>'>
                          <td><?= $price['country_name']; ?></td>
                          <td><?= $price['pickup_price']; ?></td>
                          <td><?= $price['pickup_price_free']; ?></td>
                          <td><?= $price['courier_price']; ?></td>
                          <td><?= $price['courier_price_free']; ?></td>
                          <td>
                            <button data-edit-btn class="btn btn-primary"><i class="fa fa-edit"></i></button>
                            <button data-delete-btn class="btn btn-danger"><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- COD Settings -->
    <div class="tab-pane" id="tab-cod">
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money"></i> <?php echo $text_cod_settings; ?></h3>
          </div>
          <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-itellashipping-cod" class="form-horizontal">
              <input type="hidden" name="cod_settings_update">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-cod-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="itellashipping_cod_status" id="input-cod-status" class="form-control">
                    <?php if ($itellashipping_cod_status) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_cod_options; ?></label>
                <div class="col-sm-10">
                  <div class="itella-checkboxes">
                    <?php foreach ($cod_options as $key => $cod_name) : ?>
                      <div class="checkbox">
                        <input type="checkbox" name="itellashipping_cod_options[]" id="cod-option-<?= $key; ?>" value="<?= $key; ?>" <?= (in_array($key, $itellashipping_cod_options) ? 'checked' : ''); ?>>
                        <label for="cod-option-<?= $key; ?>"><?= $cod_name; ?></label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <p class="help-block"><?= $text_cod_options_help; ?></p>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-bic"><?php echo $entry_bic; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_bic" value="<?php echo $itellashipping_bic; ?>" placeholder="<?php echo $entry_bic; ?>" id="input-bic" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-iban"><?php echo $entry_iban; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_iban" value="<?php echo $itellashipping_iban; ?>" placeholder="<?php echo $entry_iban; ?>" id="input-iban" class="form-control" />
                </div>
              </div>
            </form>
          </div>

          <div class="panel-footer clearfix">
            <div class="pull-right">
              <button type="submit" form="form-itellashipping-cod" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Pickup Points Information -->
    <div class="tab-pane" id="tab-pickuppoints">
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-map-marker"></i> <?php echo $text_locations; ?></h3>
          </div>
          <div class="panel-body itella-info">
            <div class="row itella-list">
              <div class="col-sm-4 itella-info-name"><?= $text_last_update; ?>:</div>
              <div class="col-sm-8 bold"><?= $last_update; ?></div>

              <?php
              foreach ($locations_info as $key => $loc_count) : ?>
                <div class="col-sm-4 itella-info-name"><?= $text_total_locations; ?> (<?= $key; ?>):</div>
                <div class="col-sm-8 bold"><?= $loc_count; ?></div>
              <?php endforeach; ?>

              <div class="col-sm-4 itella-info-name"><?= $text_cron_url; ?>:</div>
              <div class="col-sm-8 bold">
                <?php if ($cron_url) { ?>
                  <a target="_blank" href="<?= $cron_url; ?>"><?= $cron_url; ?></a>
                  <p class="help-block"><?= $text_locations_help; ?></p>
                <?php } else {
                  echo 'Secret not set';
                } ?>
              </div>

              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-itellashipping-locations">
                <input type="hidden" name="force_locations_update">
              </form>
            </div>
          </div>
          <div class="panel-footer clearfix">
            <div class="pull-right">
              <button type="submit" form="form-itellashipping-locations" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Tracking Email -->
    <div class="tab-pane" id="tab-tracking-email">
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $text_tracking_email; ?></h3>
          </div>
          <div class="panel-body">
            <form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-itellashipping-tracking-email" class="form-horizontal">
              <input type="hidden" name="tracking_email_update">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-tracking-email-status"><?= $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="itellashipping_tracking_email_status" id="input-tracking-email-status" class="form-control">
                    <?php if ($itellashipping_tracking_email_status): ?>
                      <option value="1" selected="selected"><?= $text_enabled; ?></option>
                      <option value="0"><?= $text_disabled; ?></option>
                    <?php else: ?>
                      <option value="1"><?= $text_enabled; ?></option>
                      <option value="0" selected="selected"><?= $text_disabled; ?></option>
                    <?php endif; ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-tracking-email-subject"><?= $entry_tracking_email_subject; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_tracking_email_subject" value="<?= $itellashipping_tracking_email_subject; ?>" placeholder="<?= $entry_tracking_email_subject; ?>" id="input-tracking-email-subject" class="form-control" />
                </div>
              </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-tracking-email-template"><?= $entry_tracking_email_template; ?></label>
                  <div class="col-sm-10">
                    <textarea name="itellashipping_tracking_email_template" placeholder="<?= $entry_tracking_email_template; ?>" id="input-tracking-email-template" class="form-control" rows="20"><?= $itellashipping_tracking_email_template; ?></textarea>
                    <p class="help-block"><?= $text_tracking_email_template_help; ?></p>
                  </div>
                </div>

            </form>
          </div>

          <div class="panel-footer clearfix">
            <div class="pull-right">
              <button type="submit" form="form-itellashipping-tracking-email" data-toggle="tooltip" title="<?= $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
              <a href="<?= $cancel; ?>" data-toggle="tooltip" title="<?= button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Advanced Settings -->
    <div class="tab-pane" id="tab-advanced">
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_advanced_settings; ?></h3>
          </div>
          <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-itellashipping-advanced" class="form-horizontal">
              <input type="hidden" name="advanced_settings_update">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-advanced-email-subject"><?php echo $entry_advanced_email_subject; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="itellashipping_advanced_email_subject" value="<?php echo $itellashipping_advanced_email_subject; ?>" placeholder="<?php echo $entry_advanced_email_subject; ?>" id="input-advanced-email-subject" class="form-control" />
                </div>
              </div>
              <?php foreach($advanced_emails as $adv_email): ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-advanced-email-<?= $adv_email['code']; ?>"><?php echo $adv_email['code'] . ' ' . $entry_advanced_email; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="itellashipping_advanced_email_<?= $adv_email['code']; ?>" value="<?php echo $adv_email['email']; ?>" placeholder="<?php echo $entry_advanced_email; ?>" id="input-advanced-email-<?= $adv_email['code']; ?>" class="form-control" />
                  </div>
                </div>
              <?php endforeach; ?>
            </form>
          </div>

          <div class="panel-footer clearfix">
            <div class="pull-right">
              <button type="submit" form="form-itellashipping-advanced" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Price EDIT Modal -->
  <div class="edit-price-modal" style="display: none;">
    <div class="panel panel-default col-xs-11 col-md-9 col-lg-7">
      <div class="panel-body form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-modal-country"><?php echo $entry_price_country; ?></label>
          <div class="col-sm-10">
            <input type="hidden" name="country" value="">
            <input name="country_name" type="text" readonly="" value="<?= $text_price_help_country; ?>" id="input-modal-country" class="form-control">
          </div>

        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-modal-pickup-price"><?php echo $entry_price_pickup; ?></label>
          <div class="col-sm-4">
            <input type="text" name="pickup_price" value="" placeholder="<?php echo $entry_price_pickup; ?>" id="input-modal-pickup-price" class="form-control" />
          </div>

          <label class="col-sm-2 control-label" for="input-modal-pickup-price-free"><?php echo $entry_price_free; ?></label>
          <div class="col-sm-4">
            <input type="text" name="pickup_price_free" value="" placeholder="<?php echo $entry_price_free; ?>" id="input-modal-pickup-price-free" class="form-control" />
          </div>
        </div>

        <div class="form-group">

          <label class="col-sm-2 control-label" for="input-modal-courier-price"><?php echo $entry_price_courier; ?></label>
          <div class="col-sm-4">
            <input type="text" name="courier_price" value="" placeholder="<?php echo $entry_price_courier; ?>" id="input-modal-courier-price" class="form-control" />
          </div>

          <label class="col-sm-2 control-label" for="input-modal-courier-price-free"><?php echo $entry_price_free; ?></label>
          <div class="col-sm-4">
            <input type="text" name="courier_price_free" value="" placeholder="<?php echo $entry_price_free; ?>" id="input-modal-courier-price-free" class="form-control" />
          </div>

        </div>
        <div class="form-group text-center">
          <button id="save-price-btn" class="btn btn-default center"><?php echo $button_save_price; ?></button>
          <button id="cancel-price-btn" class="btn btn-default center"><?php echo $button_cancel; ?></button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  #content {
    position: relative;
  }

  .itella-overlay {
    position: relative;
  }

  .itella-overlay::after {
    content: "Loading...";
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

  .page-header h1 img {
    height: 33px;
  }

  .bold {
    font-weight: 700;
  }

  .itella-checkboxes {
    padding-left: 20px;
  }

  .help-block {
    font-style: italic;
  }

  .itella-list a {
    word-break: break-all;
  }

  .itella-list>div:nth-of-type(even):not(:last-of-type) {
    margin-bottom: 1em;
  }

  .itella-info {
    padding: 15px 30px;
  }

  .itella-info-name {
    text-align: left;
  }

  .edit-price-modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    width: 100%;
    bottom: 0;
    top: 0;
    background-color: rgba(255, 255, 255, 0.8);
  }

  @media (min-width: 768px) {
    .itella-info-name {
      text-align: right;
    }

    .itella-list>div:not(:last-child) {
      margin-bottom: 1em;
    }
  }
</style>
<link rel="stylesheet" href="view/javascript/itellashipping/select2.min.css">
<script src="view/javascript/itellashipping/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.js-select-sender').select2();

    $('.js-select2').select2({
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
  });
  var ajax_url = '<?= $ajax_url; ?>';
  var itella_geo_zone_id = '<?= $itellashipping_geo_zone_id; ?>';
</script>
<script src="view/javascript/itellashipping/settings.js"></script>
<?php echo $footer; ?>