<?php
//Menu
$_['menu_head']     = 'Smartposti';
$_['menu_manifest'] = 'Manifest';
$_['menu_settings'] = 'Settings';

// Heading
$_['heading_title']         = '<img src="view/image/itellashipping/logo.png" alt="Smartposti Logo" style="height: 33px;">Smartposti';
$_['heading_title_nologo']  = 'Smartposti';

// Defaults
$_['text_enabled']    = 'Enabled';
$_['text_disabled']   = 'Disabled';
$_['text_home']       = 'Home';
$_['text_extension']  = 'Extensions';
$_['text_manifest']      = 'Smartposti Manifest';
$_['button_save']     = 'Save';
$_['button_cancel']   = 'Cancel';

// DB fix notification
$_['db_fix_notify'] = 'Problems found with DB tables';
$_['button_fix_db'] = 'FIX IT';
// XML fix notification
$_['xml_fix_notify'] = 'Newer version of modification file found for system/itella_base.ocmod.xml';
$_['button_fix_xml'] = 'Update file';
$_['xml_updated']   = 'system/itella_base.ocmod.xml updated. Please refresh modifications now.';

// Text
$_['text_shipping'] = 'Shipping';
$_['text_success']  = 'Success: Smartposti settings updated!';
$_['text_edit']     = 'Module settings';

// Entry
$_['entry_cost']        = 'Courier Cost';
$_['entry_cost_parcel'] = 'Pickup Point Cost';
$_['entry_tax_class']   = 'Tax Class';
$_['entry_geo_zone']    = 'Geo Zone';
$_['entry_status']      = 'Status';
$_['entry_sort_order']  = 'Sort Order';

// Error
$_['error_permission']    = 'Warning: You do not have permission to modify!';
$_['error_no_label']      = 'No tracking number found';
$_['error_empty_label']   = 'Downloaded label data is empty';
$_['error_no_order_id']   = 'No order ID given';
$_['error_itella_error']  = 'Order has errors';
$_['error_itella_empty']  = 'No order IDs given';

// Locations
$_['text_locations']                        = 'Pickup points information';
$_['text_last_update']                      = 'Last update';
$_['text_total_locations']                  = 'Total pickup points';
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

$_['entry_price_country']             = 'Country';
$_['entry_price_pickup']              = 'Pickup Point price';
$_['entry_price_courier']             = 'Courier price';
$_['entry_price_free']                = 'free from';
$_['button_add_price']                = 'Add Price';
$_['button_save_price']               = 'Save Price';
$_['entry_price_country_placeholder'] = 'Select country';
$_['text_actions']                    = 'Actions';

$_['text_price_settings'] = 'Price Settings';
$_['text_cod_settings']   = 'C.O.D Settings';
$_['entry_cod_options']   = 'C.O.D Options';

$_['text_advanced_settings']        = 'Advanced settings';
$_['entry_advanced_email_subject']  = 'Email subject';
$_['entry_advanced_email']          = 'Courier email';

$_['text_sender_settings']  = 'Sender Information';
$_['entry_sender_name']     = 'Name';
$_['entry_sender_street']   = 'Street';
$_['entry_sender_postcode'] = 'Postcode';
$_['entry_sender_city']     = 'City';
$_['entry_sender_country']  = 'Country';
$_['entry_sender_phone']    = 'Mob. phone';
$_['entry_sender_email']    = 'E-mail';

$_['tab_api']           = 'API';
$_['tab_general']       = 'General';
$_['tab_sender_info']   = 'Sender';
$_['tab_price']         = 'Price';
$_['tab_cod']           = 'C.O.D';
$_['tab_pickuppoints']  = 'Pickup Points';
$_['tab_advanced']      = 'Advanced Settings';

$_['text_price_help']         = 'Set -1 (negative price) in price field to disable that option for particular country.';
$_['text_price_help_country'] = 'Selection is limited to set Geo Zone';

// order_info_form
$_['itella_bad_order_id']   = 'Order information not found in database';
$_['itella_not_itella']     = 'Not Smartposti order';
$_['itella_bad_terminal']   = 'Pickup point doesnt exist or it was removed';
$_['itella_insert_failed']  = 'Failed to add this order to Smartposti table';

$_['itella_lng_title']          = 'Smartposti';
$_['itella_lng_prefix']         = 'Smartposti:';
$_['itella_lng_packets_total']  = 'Packets (total):';
$_['itella_lng_weight']         = 'Weight (kg):';
$_['itella_lng_cod']            = 'C.O.D:';
$_['itella_lng_no']             = 'No';
$_['itella_lng_yes']            = 'Yes';
$_['itella_lng_cod_amount']     = 'C.O.D. amount:';
$_['itella_lng_carrier']        = 'Carrier:';
$_['itella_lng_courier']        = 'Courier';
$_['itella_lng_pickup']         = 'Pickup Point';
$_['itella_lng_pickup_point']   = 'Pickup point:';
$_['itella_lng_extra']          = 'Extra services:';
$_['itella_lng_oversized']      = 'Oversized';
$_['itella_lng_call_before_delivery'] = 'Call before delivery';
$_['itella_lng_fragile']        = 'Fragile';
$_['itella_lng_multi']          = 'Multi parcel';
$_['itella_lng_print']          = 'Print';
$_['itella_lng_save']           = 'Save';
$_['itella_lng_generate']       = 'Generate label';
$_['itella_lng_loading']        = 'Loading...';
$_['itella_lng_attention']      = 'Changing carrier here will not recalculate order shipping cost!';

// Manifest Page
$_['tab_all']       = 'Orders';
$_['tab_manifest']  = 'Manifests';

$_['btn_label']             = 'Label';
$_['btn_print']             = 'Print';
$_['btn_view']              = 'View';
$_['btn_show']              = 'Show';
$_['btn_gen_label']         = 'Generate label';
$_['btn_call_courier']      = 'Call courier';
$_['btn_mass_generate']     = 'Generate labels';
$_['btn_mass_print']        = 'Print labels';
$_['btn_generate_manifest'] = 'Manifest';
$_['btn_mass_manifest']     = 'Generate manifest';
$_['btn_filter']            = 'Filter';
$_['btn_reset']             = 'Reset filter';

$_['lng_missing']               = '';
$_['lng_id']                    = 'ID';
$_['lng_customer']              = 'Customer';
$_['lng_tracking_nr']           = 'Tracking #';
$_['lng_status']                = 'Status';
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
$_['lng_modal_title']       = 'Call Smartposti courier';
$_['lng_modal_message']     = 'Courier will be called to';
$_['lng_modal_name']        = 'Name:';
$_['lng_modal_address']     = 'Address:';
$_['lng_modal_phone']       = 'Contact mob. phone:';
$_['lng_modal_manifest_id'] = 'Manifest ID to attach:';
$_['lng_modal_call_msg']    = 'Message';
$_['lng_modal_pickup_time'] = 'Pickup time';
$_['lng_modal_btn_call']    = 'Call Courier';
$_['lng_modal_btn_cancel']  = 'Cancel';

$_['itella_label_downloaded'] = 'Label downloaded';

// Manifest PDF strings
$_['manifest_sender_address']   = 'Sender address:';
$_['manifest_nr']               = 'No.';
$_['manifest_track_num']        = 'Tracking number';
$_['manifest_date']             = 'Date';
$_['manifest_amount']           = 'Amount';
$_['manifest_weight']           = 'Weight (kg)';
$_['manifest_delivery_address'] = 'Delivery address';
$_['manifest_courier']          = 'Courier';
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
$_['itellashipping_pickup_point_title_default'] = 'Smartposti Pickup point';
$_['itellashipping_courier_title_default'] = 'Smartposti Courier';

// added in v1.2.19
$_['browser_tab_settings'] = 'Smartposti settings';
$_['browser_tab_manifest'] = 'Smartposti manifest';
