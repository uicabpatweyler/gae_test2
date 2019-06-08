//Agregar datos dinamicos al select
$.fn.populateSelect = function (values) {
  var options = '';
  $.each(values, function (key, row) {
    options += '<option value="' + row.value + '">' + row.text + '</option>';
  });
  $(this).html(options);
};

$.fn.enableControl = function(empty, state){
  if(empty){ $(this).empty(); }
  if(state){
    $(this).removeAttr('disabled');
  }
  else{
    $(this).prop('disabled','disabled');
  }
};

function showCancel(_location){
  Swal.fire({
    title: '¿Realmente desea cancelar?',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'No, me equivoque',
    confirmButtonText: 'Si'
  }).then((result) => {
    if (result.value) {
      window.location.replace(_location);
    }
  })
}

function showAlert(_textStatus, _statusText, _message, _location){
  Swal.fire({
    type:  _textStatus,
    title: _statusText === 'OK' ? 'OK' : 'ERROR',
    text:  _message,
    allowOutsideClick:  false,
    showCancelButton:   _statusText !== 'OK',
    showConfirmButton:  _statusText === 'OK',
    confirmButtonColor: '#3085d6',
    cancelButtonColor:  '#d33',
    cancelButtonText:   'Corregir',
    confirmButtonText:  'Continuar'
  }).then((result) => {
    if (result.value) {
      window.location.replace(_location);
    }
  });
}

//Inicia funcion para mostrar los botones de accion de los datatable
function htmlDecode(data){
  var txt=document.createElement('textarea');
  txt.innerHTML=data;
  return txt.value
}
//Termina funcion para mostrar los botones de accion de los datatable

//Inicia funcion para eliminar el item seleccionado
function deleteItem(urlDelete){
  Swal.fire({
    title: '¿Realmente desea eliminar?',
    text: "Si hizo clic por equivocación, presione Cancelar",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, deseo eliminar'
  }).then((result) => {

    if (result.value) {

      axios.delete(urlDelete)
        .then(function (response) {
          location.reload();
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });

    }

  })
}
//Termina funcion para eliminar el item seleccionado