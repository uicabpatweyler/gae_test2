$().ready(function() {
  $('#form_categoria').validate({
    debug: false,
    errorElement: "div",
    rules: {
      nombre: {required: true, minlength: 2, maxlength: 30}
    },
    messages: {
      nombre: {
        required: "Obligatorio",
        minlength: "Mínimo 2 letras",
        maxlength: "Máximo 30 letras"
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
  function saveUpdate(){
    $("#btn_guardar").prop('disabled', 'disabled');
    $.ajax({
      method: "POST",
      url: $("#form_categoria").attr('action'),
      data: $("#form_categoria").serialize()
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
});