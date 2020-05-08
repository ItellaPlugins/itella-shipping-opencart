$(document).ready(function () {
  initPriceSettings();
});
//var itella_price_range = [];
function initPriceSettings() {
  console.log('Itella settings activated');
  window.$price_table = $('#price-table');
  sortPrices();
  $.ajax({
    type: 'POST',
    url: ajax_url + '&action=getCountries',
    dataType: 'json',
    //contentType: "application/json",
    data: {
      "geo_zone_id": itella_geo_zone_id
    },
    success: function (json) {
      //itella_price_range = json;
      buildHtml(json);
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });

  // delete price button
  $('#price-table').on('click', '[data-delete-btn]', function (e) {
    e.preventDefault();
    var data = jsonDecodeFromHTML($(this).parent().parent().get(0).dataset.priceData);
    deletePrice(data);
  });

  // edit price button
  $('#price-table').on('click', '[data-edit-btn]', function (e) {
    e.preventDefault();
    var data = jsonDecodeFromHTML($(this).parent().parent().get(0).dataset.priceData);
    fillPriceModal(data);
    $('.edit-price-modal').show();
  });

  $('#save-price-btn').on('click', function (e) {
    e.preventDefault();
    var data = {
      country: $('.edit-price-modal [name="country"]').val(),
      country_name: $('.edit-price-modal [name="country_name"]').val(),
      pickup_price: $('.edit-price-modal [name="pickup_price"]').val(),
      pickup_price_free: $('.edit-price-modal [name="pickup_price_free"]').val(),
      courier_price: $('.edit-price-modal [name="courier_price"]').val(),
      courier_price_free: $('.edit-price-modal [name="courier_price_free"]').val()
    };
    savePrice(data);
    cleanPriceModal();
    $('.edit-price-modal').hide();
  });

  $('#cancel-price-btn').on('click', function (e) {
    e.preventDefault();
    cleanPriceModal();
    $('.edit-price-modal').hide();
  });

  $('#add-price-btn').on('click', function (e) {
    e.preventDefault();
    if ($('#price-table [name="country"]').val() == null) {
      console.log('Impossible');
      return;
    }
    var data = {
      country: $('#price-table [name="country"]').val(),
      country_name: $('#price-table [name="country"] option:selected').text(),
      pickup_price: $('#price-table [name="pickup_price"]').val(),
      pickup_price_free: $('#price-table [name="pickup_price_free"]').val(),
      courier_price: $('#price-table [name="courier_price"]').val(),
      courier_price_free: $('#price-table [name="courier_price_free"]').val()
    };
    savePrice(data);
  });
}

function buildHtml(json) {
  if (json.length < 1) {
    return;
  }
  var html = json.map(function (country) {
    if ($('[data-price-row="' + country.iso_code_2 + '"]').length > 0) {
      return '';
    }
    return '<option value="' + country.iso_code_2 + '">' + country.name + '</option>'
  }).join('\n');

  $('[name="country"]').html(html);
  $('[name="country"]').trigger('change');
}

function updatePriceNotification() {
  if ($('#created-prices').find('tr').length > 1) {
    $('#no-price-notification').hide();
  } else {
    $('#no-price-notification').show();
  }
}

function jsonEncodeToHTML(json) {
  return JSON.stringify(json).replace(/"/g, '\'');
}

function jsonDecodeFromHTML(json_string) {
  return JSON.parse(json_string.replace(/'/g, '"'));
}

function fillPriceModal(data) {
  $('.edit-price-modal [name="country"]').val(data.country);
  $('.edit-price-modal [name="country_name"]').val(data.country_name);
  $('.edit-price-modal [name="pickup_price"]').val(data.pickup_price);
  $('.edit-price-modal [name="pickup_price_free"]').val(data.pickup_price_free);
  $('.edit-price-modal [name="courier_price"]').val(data.courier_price);
  $('.edit-price-modal [name="courier_price_free"]').val(data.courier_price_free);
}

function cleanPriceModal() {
  $('.edit-price-modal [name="country"]').val('');
  $('.edit-price-modal [name="country_name"]').val('');
  $('.edit-price-modal [name="pickup_price"]').val('');
  $('.edit-price-modal [name="pickup_price_free"]').val('');
  $('.edit-price-modal [name="courier_price"]').val('');
  $('.edit-price-modal [name="courier_price_free"]').val('');
}

function sortPrices() {
  var pricesHTML = $('#created-prices').find('[data-price-row]').remove();
  pricesHTML.sort(function (a, b) {
    return $(a).find('td').first().text().localeCompare($(b).find('td').first().text());
  });
  $('#created-prices').append(pricesHTML);
}

function deletePrice(data) {
  console.log('Deletion data:', data);
  $('#price-table').addClass('itella-overlay');
  $.ajax({
    type: 'POST',
    url: ajax_url + '&action=deletePrice',
    dataType: 'json',
    //contentType: "application/json",
    data: data,
    success: function (json) {
      //itella_price_range = json;
      console.log(json);
      $('[name="country"]').append($('<option value="' + data.country + '">' + data.country_name + '</option>'));
      $('[name="country"]').trigger('change');
      $('[data-price-row="' + data.country + '"]').remove();
      updatePriceNotification();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    },
    complete: function (xhr, status) {
      console.log('Completed with: ', status);
      $('#price-table').removeClass('itella-overlay');
    }
  });
}

function savePrice(data) {
  $('#price-table').addClass('itella-overlay');
  $.ajax({
    type: 'POST',
    url: ajax_url + '&action=savePrice',
    dataType: 'json',
    data: data,
    success: function (json) {
      console.log(json);
      $('[name="country"]').find('[value="' + data.country + '"]').remove();
      var buttons = '<button data-edit-btn class="btn btn-primary"><i class="fa fa-edit"></i></button> '
        + '<button data-delete-btn class="btn btn-danger"><i class="fa fa-trash"></i></button>';
      $row = $('<tr data-price-row="' + data.country + '" data-price-data="' + jsonEncodeToHTML(data) + '"><td>' + data.country_name + '</td><td>' + data.pickup_price + '</td><td>' + data.pickup_price_free + '</td><td>' + data.courier_price + '</td><td>' + data.courier_price_free + '</td><td>' + buttons + '</td></tr>');
      if ($('#created-prices [data-price-row="' + data.country + '"]').length > 0) {
        // Editing price, so remove old entry
        $('#created-prices [data-price-row="' + data.country + '"]').remove();
      }
      // Add price data to table
      $('#created-prices').append($row);
      updatePriceNotification();
      sortPrices();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    },
    complete: function (xhr, status) {
      console.log('Completed with: ', status);
      $('#price-table').removeClass('itella-overlay');
    }
  });
}
