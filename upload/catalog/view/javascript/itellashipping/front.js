function initItella($this) {
  console.log('Initializing Itella', $this);
  $.ajax({
    url: 'index.php?route=extension/module/itellashipping/ajax&action=getTerminals',
    dataType: 'json',
    success: function (json) {
      console.log('Current method', json.current_method);
      if (typeof json.terminals == 'undefined') {
        json.terminals = false;
      }
      if (typeof json.country_code == 'undefined') {
        json.country_code = '';
      }
      buildItella($this, JSON.parse(json.terminals), json.country_code, json.current_method);
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function buildItella(target, terminals, country_code, current_method) {
  var $newEl = $('<div></div>');
  $(target).closest('div').append($newEl);
  window.itella = new itellaMapping($newEl.get(0));
  itella
    .setImagesUrl('image/catalog/itellashipping/')
    .setStrings(itella_translation)
    .setCountry(country_code);
  itella.init();
  itella.setLocations(terminals, true);
  itella.registerCallback(function (manual) {
    console.log(this.selectedPoint);
    target.val('itellashipping.pickup_' + this.selectedPoint.pupCode);
    if (manual) {
      target.prop('checked', 'checked');
      //target.get(0).click();

      $.ajax({
        url: 'index.php?route=extension/module/itellashipping/ajax&action=save',
        data: {
          itella_pickup_point: this.selectedPoint.pupCode
        },
        type: "POST",
        dataType: "json",
        success: function (json) {
          console.log(json);
        }
      });
    }
  });

  if (current_method != false) {
    itella.setSelection(current_method, false);
  }
}