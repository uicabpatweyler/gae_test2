$().ready(function() {
  $('#form_escuela').validate({
    debug: false,
    errorElement: "div",
    rules: {
      cct: { required: true, minlength:10, maxlength:10 },
      nombre:  "required",
      tipo_id: "required",
      nivel_id: "required",
      servicio_id: "required",
      turno: 'required',
      sostenimiento: 'required'
    },
    messages: {
      cct: { required: "Falta la clave", minlength:"Min. 10 caracteres", maxlength:"Max. 10 caracteres" },
      nombre: "Falta el nombre",
      tipo_id: "Elija el tipo",
      nivel_id: "Elija el nivel",
      servicio_id: "Elija el tipo de servicio",
      turno: 'Elija el turno',
      sostenimiento: 'Elija público o privado'

    },
    invalidHandler: function(event, validator) {
      // 'this' refers to the form
      var errors = validator.numberOfInvalids();
      if (errors) {
        var message = errors === 1
          ? 'Verifica el campo marcado en rojo'
          : 'Verifica los ' + errors + ' campos marcados en rojo';
        showAlert('error','ERROR',message,'');
      } else {
        // informar que se procedera a guardar el formulario
      }
    },
    submitHandler: function() { saveUpdate(); },
    errorPlacement: function ( error, element ) {
      error.addClass( "invalid-feedback" );
      if ( element.prop( "type" ) === "checkbox" ) {
        error.insertAfter( element.parent( "label" ) );
      } else {
        error.insertAfter( element );
      }
    },
    success: function(element){
      $( element ).remove();
    },
    highlight: function ( element, errorClass, validClass ) {
      $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
    },
    unhighlight: function (element, errorClass, validClass) {
      $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
    }
  });
});

function saveUpdate(){
  $("#btn_guardar").prop('disabled', 'disabled');
  $.ajax({
    method: "POST",
    url: $("#form_escuela").attr('action'),
    data: $("#form_escuela").serialize()
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

/*Evento change. Select: Tipo de Escuela*/
$("#tipo_id").change( function (){
  if($(this).val()!==''){

    $('#nivel_id').enableControl(true,true);
    $('#servicio_id').enableControl(true,false);

    $.getJSON(urlRoot+'/admin/niveltipo/'+$(this).val(), null, function (values) {
      $('#nivel_id').populateSelect(values);
    });

  }
  else{
    $('#nivel_id').enableControl(true,false);
    $('#servicio_id').enableControl(true,false);
  }
});

/* Evento change. Select: Nivel de Escuela*/
$("#nivel_id").change( function() {
  if($(this).val()!==''){

    $('#servicio_id').enableControl(true,true);

    $.getJSON(urlRoot+'/admin/servnivel/'+$(this).val(), null, function (values) {
      $('#servicio_id').populateSelect(values);
    });

  }
  else{
    $('#servicio_id').enableControl(true,false);
  }
});