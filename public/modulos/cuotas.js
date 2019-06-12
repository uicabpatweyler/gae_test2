$().ready(function() {
  $('#form_cuota').validate({
    debug: false,
    errorElement: "div",
    rules: {
      escuela_id: "required",
      ciclo_id: "required",
      tipo: "required",
      nombre: "required",
      cantidad: {required: true, digits:true}
    },
    messages: {
      escuela_id: "Elija la escuela",
      ciclo_id: "Elija el ciclo escolar",
      tipo: "Elija el tipo de cutoa",
      nombre: "Falta el nombre",
      cantidad: {
        required: "Dato obligatorio",
        digits: "Solo números"
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
    url: $("#form_cuota").attr('action'),
    data: $("#form_cuota").serialize()
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