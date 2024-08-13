<?php
//Menu
$_['menu_head']     = 'Smartpost';
$_['menu_manifest'] = 'Manifest';
$_['menu_settings'] = 'Settings';

// Heading
$_['heading_title']         = '<img src="view/image/itellashipping/logo.png" alt="Smartpost Itella Logo" style="height: 33px;">Smartpost';
$_['heading_title_nologo']  = 'Smartpost Itella';

// Defaults
$_['text_enabled']    = 'Enabled';
$_['text_disabled']   = 'Disabled';
$_['text_home']       = 'Sākums';
$_['text_extension']  = 'Extensions';
$_['text_manifest']      = 'Smartpost Manifest';
$_['button_save']     = 'Saglabāt';
$_['button_cancel']   = 'Atcelt';

// DB fix notification
$_['db_fix_notify'] = 'Problems found with DB tables';
$_['button_fix_db'] = 'FIX IT';
// XML fix notification
$_['xml_fix_notify'] = 'Newer version of modification file found for system/itella_base.ocmod.xml';
$_['button_fix_xml'] = 'Update file';
$_['xml_updated']   = 'system/itella_base.ocmod.xml updated. Please refresh modifications now.';

// Text
$_['text_shipping'] = 'Piegāde';
$_['text_success']  = 'Success: Smartpost settings updated!';
$_['text_edit']     = 'Module settings';

// Entry
$_['entry_cost']        = 'Courier Cost';
$_['entry_cost_parcel'] = 'Pickup Point Cost';
$_['entry_tax_class']   = 'Tax Class';
$_['entry_geo_zone']    = 'Ģeo zona';
$_['entry_status']      = 'Statuss';
$_['entry_sort_order']  = 'Šķirošanas secība';

// Error
$_['error_permission']    = 'Warning: You do not have permission to modify!';
$_['error_no_label']      = 'No tracking number found';
$_['error_empty_label']   = 'Downloaded label data is empty';
$_['error_no_order_id']   = 'No order ID given';
$_['error_itella_error']  = 'Pasūtījumā ir kļūdas';
$_['error_itella_empty']  = 'No order IDs given';

// Locations
$_['text_locations']                        = 'Informācija par saņemšanas punktiem';
$_['text_last_update']                      = 'Pēdējais atjauninājums';
$_['text_total_locations']                  = 'Kopā saņemšanas punkti';
$_['text_cron_url']                         = 'CRON URL';
$_['text_locations_settings']               = 'Pickup points settings';
$_['entry_locations_exclude_outdoors']      = 'Exclude outdoors';
$_['text_locations_exclude_outdoors_help']  = 'In the Checkout page dont show pickup points that have "Outdoors" parameter';

$_['button_update']                         = 'Update Now';

// API
$_['text_cod_options_help'] = 'Select payment options that are for C.O.D';
$_['text_locations_help']   = 'Use this link to setup automated pickup points update (Cron Job)';

$_['text_api_settings']   = 'API Settings';
$_['entry_test_mode']     = 'Test Mode';
$_['entry_api_user']      = 'API User';
$_['entry_api_pass']      = 'API Password';
$_['entry_api_contract']  = 'API Contract #';
$_['entry_api_2711']      = '2711 Product Credentials';
$_['entry_api_2317']      = '2317 Product Credentials';
$_['entry_bic']           = 'BIC';
$_['entry_iban']          = 'IBAN';

$_['entry_price_country']             = 'Valsts';
$_['entry_price_pickup']              = 'Pickup Point price';
$_['entry_price_courier']             = 'Courier price';
$_['entry_price_free']                = 'free from';
$_['button_add_price']                = 'Add Price';
$_['button_save_price']               = 'Save Price';
$_['entry_price_country_placeholder'] = 'Izvēlēties valsti';
$_['text_actions']                    = 'Actions';

$_['text_price_settings'] = 'Price Settings';
$_['text_cod_settings']   = 'C.O.D Settings';
$_['entry_cod_options']   = 'C.O.D Options';

$_['text_advanced_settings']        = 'Advanced settings';
$_['entry_advanced_email_subject']  = 'Email subject';
$_['entry_advanced_email']          = 'Courier email';

$_['text_sender_settings']  = 'Sender Information';
$_['entry_sender_name']     = 'Vārds';
$_['entry_sender_street']   = 'Iela';
$_['entry_sender_postcode'] = 'Pasta indekss';
$_['entry_sender_city']     = 'Pilsēta';
$_['entry_sender_country']  = 'Valsts';
$_['entry_sender_phone']    = 'Mob. telefons';
$_['entry_sender_email']    = 'E-pasts';

$_['tab_api']           = 'API';
$_['tab_general']       = 'Galvenais';
$_['tab_sender_info']   = 'Sender';
$_['tab_price']         = 'Cena';
$_['tab_cod']           = 'C.O.D';
$_['tab_pickuppoints']  = 'Saņemšanas punkti';
$_['tab_advanced']      = 'Advanced Settings';

$_['text_price_help']         = 'Set -1 (negative price) in price field to disable that option for particular country.';
$_['text_price_help_country'] = 'Izvēle ir ierobežota noteiktai Ģeo zonai';

// order_info_form
$_['itella_bad_order_id']   = 'Order information not found in database';
$_['itella_not_itella']     = 'Not Smartpost order';
$_['itella_bad_terminal']   = 'Paņemšanas punkts neeksistē vai neaktīvs';
$_['itella_insert_failed']  = 'Failed to add this order to Smartpost Itella table';

$_['itella_lng_title']          = 'Smartpost';
$_['itella_lng_prefix']         = 'Smartpost:';
$_['itella_lng_packets_total']  = 'Pakas (kopā):';
$_['itella_lng_weight']         = 'Svars (kg):';
$_['itella_lng_cod']            = 'C.O.D:';
$_['itella_lng_no']             = 'Nē';
$_['itella_lng_yes']            = 'Jā';
$_['itella_lng_cod_amount']     = 'C.O.D. amount:';
$_['itella_lng_carrier']        = 'Pārvadātājs:';
$_['itella_lng_courier']        = 'Kurjers';
$_['itella_lng_pickup']         = 'Saņemšanas punkts';
$_['itella_lng_pickup_point']   = 'Saņemšanas punkts:';
$_['itella_lng_extra']          = 'Papildus pakalpojumi:';
$_['itella_lng_oversized']      = 'Lielizmēra';
$_['itella_lng_call_before_delivery'] = 'Zvans pirms piegādes';
$_['itella_lng_fragile']        = 'Trausls';
$_['itella_lng_multi']          = 'Daudzpaku sūtījums';
$_['itella_lng_print']          = 'Print';
$_['itella_lng_save']           = 'Saglabāt';
$_['itella_lng_generate']       = 'Generate label';
$_['itella_lng_loading']        = 'Ielādējas…';
$_['itella_lng_attention']      = 'Changing carrier here will not recalculate order shipping cost!';

// Manifest Page
$_['tab_all']       = 'Orders';
$_['tab_manifest']  = 'Manifests';

$_['btn_label']             = 'Label';
$_['btn_print']             = 'Print';
$_['btn_view']              = 'Skats';
$_['btn_show']              = 'Parādīt';
$_['btn_gen_label']         = 'Generate label';
$_['btn_call_courier']      = 'Call courier';
$_['btn_mass_generate']     = 'Generate labels';
$_['btn_mass_print']        = 'Print labels';
$_['btn_generate_manifest'] = 'Manifest';
$_['btn_mass_manifest']     = 'Generate manifest';
$_['btn_filter']            = 'Filtrēt';
$_['btn_reset']             = 'Atjaunot filtru';

$_['lng_missing']               = '';
$_['lng_id']                    = 'ID';
$_['lng_customer']              = 'Klients';
$_['lng_tracking_nr']           = 'Sūtījuma izsekošana #';
$_['lng_status']                = 'Statuss';
$_['lng_date_added']            = 'Date added';
$_['lng_date_modified']         = 'Date modified';
$_['lng_actions']               = 'Actions';
$_['lng_total_orders']          = 'Total orders';
$_['lng_no_manifest']           = 'There is no generated manifests.';
$_['lng_no_orders']             = 'There is no orders.';
$_['lng_mass_action_notice']    = 'will ignore orders without tracking number';
$_['lng_label_caution']         = 'Caution! One or more selected orders already has tracking number. Continuing will register new label. Continue?';
$_['lng_manifest_gen_success']  = 'Manifest generated. Orders in manifest:';
$_['lng_register_success']      = 'Order registered';
$_['lng_total_registered']      = 'Total registered orders:';
$_['lng_no_order_selected']     = 'No order selected!';
$_['lng_courier_email_missing'] = 'Courier service email not set';
$_['lng_call_success']          = 'Courier called to:';
$_['lng_call_failed']           = 'Call courier failed with:';

// manifest page modal
$_['lng_modal_order_title'] = 'Manifest:';
$_['lng_modal_title']       = 'Call Smartpost courier';
$_['lng_modal_message']     = 'Courier will be called to';
$_['lng_modal_name']        = 'Vārds:';
$_['lng_modal_address']     = 'Adrese:';
$_['lng_modal_phone']       = 'Kontakttelefons:';
$_['lng_modal_manifest_id'] = 'Manifest ID to attach:';
$_['lng_modal_btn_call']    = 'Call Courier';
$_['lng_modal_btn_cancel']  = 'Atcelt';

$_['itella_label_downloaded'] = 'Label downloaded';

// Manifest PDF strings
$_['manifest_sender_address']   = 'Sender address:';
$_['manifest_nr']               = 'No.';
$_['manifest_track_num']        = 'Sūtījuma izsekošanas numurs';
$_['manifest_date']             = 'Datums';
$_['manifest_amount']           = 'Daudzums';
$_['manifest_weight']           = 'Svars (kg)';
$_['manifest_delivery_address'] = 'Piegādes adrese';
$_['manifest_courier']          = 'Kurjers';
$_['manifest_sender']           = 'Sender';
$_['manifest_signature']        = 'name, lastname, signature';

// GLS contract strings
$_['entry_api_contract_gls']        = 'API GLS Contract #';
$_['text_api_contract_gls_help']    = 'For GLS countries only (not LT, LV, EE, FI).';

// order_info_form comment field
$_['itella_lng_comment'] = 'Shipment comment:';

// Tracking Email
$_['itella_lng_resend_email'] = 'Resend tracking URL email';
$_['btn_resend_email'] = 'Resend tracking URL email';
$_['tab_tracking_email'] = 'Tracking URL Email';
$_['text_tracking_email'] = 'Tracking URL email';
$_['entry_tracking_email_subject'] = 'Email subject';
$_['entry_tracking_email_template'] = 'Email template';
$_['text_tracking_email_template_help'] = '{{ tracking_url }} - key where to insert tracking URL, to insert just tracking number please use {{ tracking_number }}';
$_['error_tracking_email_disabled'] = 'Tracking URL email is disabled';

// added in v1.2.15
$_['itellashipping_title_lang'] = 'Language';
$_['itellashipping_pickup_point_title'] = 'Pickup point title in checkout';
$_['itellashipping_courier_title'] = 'Courier title in checkout';
$_['itellashipping_pickup_point_title_default'] = 'Smartpost Pickup point';
$_['itellashipping_courier_title_default'] = 'Smartpost Courier';
