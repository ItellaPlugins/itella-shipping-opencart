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
$_['text_home']       = 'Avaleht';
$_['text_extension']  = 'Extensions';
$_['text_manifest']	  = 'Smartpost Manifest';
$_['button_save']     = 'Salvesta';
$_['button_cancel']   = 'Tühista';

// DB fix notification
$_['db_fix_notify'] = 'Problems found with DB tables';
$_['button_fix_db'] = 'FIX IT';
// XML fix notification
$_['xml_fix_notify'] = 'Newer version of modification file found for system/itella_base.ocmod.xml';
$_['button_fix_xml'] = 'Update file';
$_['xml_updated']   = 'system/itella_base.ocmod.xml updated. Please refresh modifications now.';

// Text
$_['text_shipping'] = 'Tarnimine';
$_['text_success']  = 'Success: Smartpost settings updated!';
$_['text_edit']     = 'Module settings';

// Entry
$_['entry_cost']        = 'Courier Cost';
$_['entry_cost_parcel'] = 'Pickup Point Cost';
$_['entry_tax_class']   = 'Tax Class';
$_['entry_geo_zone']    = 'Geo Zone';
$_['entry_status']      = 'Seisund';
$_['entry_sort_order']  = 'Sorteerimisjärjekord';

// Error
$_['error_permission']    = 'Warning: You do not have permission to modify!';
$_['error_no_label']      = 'No tracking number found';
$_['error_empty_label']   = 'Downloaded label data is empty';
$_['error_no_order_id']   = 'No order ID given';
$_['error_itella_error']  = 'Tellimuses esineb vigu';
$_['error_itella_empty']  = 'No order IDs given';

// Locations
$_['text_locations']        = 'Paki kättesaamiskohtade teave';
$_['text_last_update']      = 'Viimati uuendatud';
$_['text_total_locations']  = 'Kõik kättesaamiskohad';
$_['text_cron_url']         = 'CRON URL';

$_['button_update']         = 'Update Now';

// API
$_['text_cod_options_help'] = 'Vali makseviisid kaardimakseks kauba kättesaamisel';
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

$_['entry_price_country']             = 'Riik';
$_['entry_price_pickup']              = 'Pickup Point price';
$_['entry_price_courier']             = 'Courier price';
$_['entry_price_free']                = 'free from';
$_['button_add_price']                = 'Add Price';
$_['button_save_price']               = 'Save Price';
$_['entry_price_country_placeholder'] = 'Vali riik';
$_['text_actions']                    = 'Actions';

$_['text_price_settings'] = 'Price Settings';
$_['text_cod_settings']   = 'C.O.D Settings';
$_['entry_cod_options']   = 'C.O.D Options';

$_['text_advanced_settings']        = 'Advanced settings';
$_['entry_advanced_email_subject']  = 'Email subject';
$_['entry_advanced_email']          = 'Courier email';

$_['text_sender_settings']  = 'Sender Information';
$_['entry_sender_name']     = 'Nimi';
$_['entry_sender_street']   = 'Tänav';
$_['entry_sender_postcode'] = 'Sihtnumber';
$_['entry_sender_city']     = 'Linn';
$_['entry_sender_country']  = 'Riik';
$_['entry_sender_phone']    = 'Mobiiltelefon';
$_['entry_sender_email']    = 'E-post';

$_['tab_api']           = 'API';
$_['tab_general']       = 'Üldine';
$_['tab_sender_info']   = 'Sender';
$_['tab_price']         = 'Hind';
$_['tab_cod']           = 'Kaardimakse kauba kättesaamisel';
$_['tab_pickuppoints']  = 'Kättesaamiskohad';
$_['tab_advanced']      = 'Advanced Settings';

$_['text_price_help']         = 'Set -1 (negative price) in price field to disable that option for particular country.';
$_['text_price_help_country'] = 'Valik on piiratud määratud geograafilise tsooniga';

// order_info_form
$_['itella_bad_order_id']   = 'Order information not found in database';
$_['itella_not_itella']     = 'Not Smartpost order';
$_['itella_bad_terminal']   = 'Kättesaamiskohta ei ole või see eemaldati';
$_['itella_insert_failed']  = 'Failed to add this order to Smartpost table';

$_['itella_lng_title']          = 'Smartpost';
$_['itella_lng_prefix']         = 'Smartpost:';
$_['itella_lng_packets_total']  = 'Pakke (kokku):';
$_['itella_lng_weight']         = 'Kaal (kg):';
$_['itella_lng_cod']            = 'Kaardimakse kauba kättesaamisel:';
$_['itella_lng_no']             = 'Ei';
$_['itella_lng_yes']            = 'Jah';
$_['itella_lng_cod_amount']     = 'Kauba kättesaamisel kaardiga tasutav summa:';
$_['itella_lng_carrier']        = 'Transpordiettevõte:';
$_['itella_lng_courier']        = 'Kullerteenus';
$_['itella_lng_pickup']         = 'Paki kättesaamiskoht';
$_['itella_lng_pickup_point']   = 'Paki kättesaamiskoht:';
$_['itella_lng_extra']          = 'Lisateenused:';
$_['itella_lng_oversized']      = 'Ülemõõduline';
$_['itella_lng_call_before_delivery'] = 'Helista enne kohaletoimetamist';
$_['itella_lng_fragile']        = 'Õrn';
$_['itella_lng_multi']          = 'Mitu pakki';
$_['itella_lng_print']          = 'Print';
$_['itella_lng_save']           = 'Salvesta';
$_['itella_lng_generate']       = 'Generate label';
$_['itella_lng_loading']        = 'Laadib...';
$_['itella_lng_attention']      = 'Changing carrier here will not recalculate order shipping cost!';

// Manifest Page
$_['tab_all']       = 'Orders';
$_['tab_manifest']  = 'Manifests';

$_['btn_label']             = 'Label';
$_['btn_print']             = 'Print';
$_['btn_view']              = 'Vaata';
$_['btn_show']              = 'Näita';
$_['btn_gen_label']         = 'Generate label';
$_['btn_call_courier']      = 'Call courier';
$_['btn_mass_generate']     = 'Generate labels';
$_['btn_mass_print']        = 'Print labels';
$_['btn_generate_manifest'] = 'Manifest';
$_['btn_mass_manifest']     = 'Generate manifest';
$_['btn_filter']            = 'Filter';
$_['btn_reset']             = 'Lähtesta filter';

$_['lng_missing']               = '';
$_['lng_id']                    = 'ID';
$_['lng_customer']              = 'Klient';
$_['lng_tracking_nr']           = 'Saadetise kood';
$_['lng_status']                = 'Seisund';
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
$_['lng_modal_name']        = 'Nimi:';
$_['lng_modal_address']     = 'Aadress:';
$_['lng_modal_phone']       = 'Mobiilinumber:';
$_['lng_modal_manifest_id'] = 'Manifest ID to attach:';
$_['lng_modal_btn_call']    = 'Call Courier';
$_['lng_modal_btn_cancel']  = 'Tühista';

$_['itella_label_downloaded'] = 'Label downloaded';

// Manifest PDF strings
$_['manifest_sender_address']   = 'Sender address:';
$_['manifest_nr']               = 'Nr';
$_['manifest_track_num']        = 'Saadetise kood';
$_['manifest_date']             = 'Kuupäev';
$_['manifest_amount']           = 'Kogus';
$_['manifest_weight']           = 'Kaal (kg)';
$_['manifest_delivery_address'] = 'Kohaletoimetamise aadress';
$_['manifest_courier']          = 'Kullerteenus';
$_['manifest_sender']           = 'Sender';
$_['manifest_signature']        = 'name, lastname, signature';

// GLS contract strings
$_['entry_api_contract_gls']        = 'API GLS Contract #';
$_['text_api_contract_gls_help']    = 'For GLS countries only (not LT, LV, EE, FI).';
