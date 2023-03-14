
function toggleInput() {
  // Seleccionar el checkbox por su ID
  var checkbox = document.getElementById("activarInput");

  // Seleccionar el input por su ID
  var input = document.getElementById("password");
  var input2 = document.getElementById("oldpassword");

  // Verificar el estado del checkbox
  if (checkbox.checked == true) {
    // Activar el input
    input.disabled = false;
    input2.disabled = false;
    input.focus();
  } else {
    // Desactivar el input
    input.disabled = true;
    input2.disabled = true;
  }
}