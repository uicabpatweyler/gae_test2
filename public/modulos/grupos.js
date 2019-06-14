$().ready(function() {
  $('#form_grupo').validate({
    debug: false,
    errorElement: "div",
    rules: {
      escuela_id: "required",
      ciclo_id: "required",
      grado_id: "required",
      nombre: "required",
      cupoalumnos: {required: true, min: 1, max: 50}
    },
    messages: {
      escuela_id: "Elija la escuela",
      ciclo_id: "Elija el ciclo escolar",
      grado_id: "Elija el grado",
      nombre: "Falta el nombre del grupo",
      cupoalumnos: {
        required: "Obligatorio",
        min: "Min. 1",
        max: "Max. 50"
      }
    },
    invalidHandler: function (event, validator) {
      // 'this' refers to the form
      var errors = validator.numberOfInvalids();
      if (errors) {
        var message = errors === 1
          ? 'Verifica el campo marcado en rojo'
          : 'Verifica los ' + errors + ' campos marcados en rojo';
        showAlert('error', 'ERROR', message, '');
      } else {
        // informar que se procedera a guardar el formulario
      }
    },
    submitHandler: function() { saveUpdate(); },
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }
    },
    success: function (element) {
      $(element).remove();
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).addClass("is-valid").removeClass("is-invalid");
    }
  });
});

function saveUpdate(){
  $("#btn_guardar").prop('disabled', 'disabled');
  $.ajax({
    method: "POST",
    url: $("#form_grupo").attr('action'),
    data: $("#form_grupo").serialize()
  })
    .done(function(data, textStatus, jqXHR){
      showAlert(textStatus, jqXHR.statusText, data.message, data.location);
    })
    .fail(function( jqXHR, textStatus, errorThrown){
      var errors = Object.keys(jqXHR.responseJSON.errors).length;
      var message = errors === 1
        ? 'Verifica el campo marcado en rojo'
        : 'Verifica los ' + errors + ' campos marcados en rojo';

      showAlert(textStatus, jqXHR.statusText, message, '');

      $.each(jqXHR.responseJSON.errors, function(key,value){
        $( "#"+key ).addClass( "is-invalid" ).removeClass( "is-valid" );
        $('<div id="'+key+'-error" class="error invalid-feedback">'+value+'</div>').insertAfter( $( "#"+key ) );
      });
      $("#btn_guardar").removeAttr('disabled');
    });
}

$("#escuela_id").change( function (){
  if($(this).val()!==''){
    $('#grado_id').enableControl(true,true);

    $.getJSON(urlRoot+'/data/selectgrados/'+$(this).val(), null, function (values) {
      $('#grado_id').populateSelect(values);
    });

    if($("#ciclo_id").val()!==''){
      activeCuotas();
      getCuotas(1);
      getCuotas(2);
    }
  }
  else{
    $('#grado_id').enableControl(true,false);
    disableCuotas();
  }
});

$("#ciclo_id").change(function(){
  if($(this).val()!=='' && $("#escuela_id").val()!==''){
   activeCuotas();
   getCuotas(1);
   getCuotas(2);
  }
  else{
    disableCuotas();
  }
});

function getCuotas($tipo){
  let url = urlRoot+'/data/_cuotas'+'/'+$("#escuela_id").val()+'/'+$("#ciclo_id").val()+'/'+$tipo;
  $.getJSON(url, null, function (values) {
    if($tipo===1){
      $('#cuotainscripcion_id').populateSelect(values);
    }
    if($tipo===2){
      $('#cuotacolegiatura_id').populateSelect(values);
    }
  });
}

function activeCuotas(){
  $("#cuotainscripcion_id").enableControl(true,true);
  $("#cuotacolegiatura_id").enableControl(true,true);
}
function disableCuotas(){
  $("#cuotainscripcion_id").enableControl(true,false);
  $("#cuotacolegiatura_id").enableControl(true,false);
}
