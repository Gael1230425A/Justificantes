function actInput1() {
    // Obtengo los elementos que usaré
    const fieldset = document.getElementById('f1');
    const input = document.getElementById('semestre1');
    const button = document.getElementById('btn1');
    const borrarButton = fieldset.querySelector('button[type="button"][id="btn2"]'); // Encuentra el botón de "Borrar"

    // Remuevo el atributo readonly del input
    input.removeAttribute('readonly');
    
    // Hago desaparecer el botón "Editar"
    button.style.display = 'none';

    // Crear un botón de envío (submit) para "Confirmar Edición"
    const submit = document.createElement('input');
    submit.setAttribute('type', 'submit');
    submit.setAttribute('name', 'opcion');
    submit.value = 'Confirmar Edición';

    // Crear el botón "Cancelar"
    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.textContent = 'Cancelar';
    cancelButton.onclick = cancelAction1; // Asociar la acción de cancelación

    // Insertar los nuevos botones antes del botón de "Borrar"
    fieldset.insertBefore(submit, borrarButton);
    fieldset.insertBefore(cancelButton, submit);
}

function actInput2() {
    // Obtengo los elementos que usaré
    const fieldset = document.getElementById('f1');
    const input = document.getElementById('semestre1');
    const button = document.getElementById('btn2');

    // Remuevo el atributo readonly del input
    input.removeAttribute('readonly');
    
    // Hago desaparecer el botón "Borrar"
    button.style.display = 'none';

    // Crear un botón de envío (submit) para "Confirmar Borrado"
    const submit = document.createElement('input');
    submit.setAttribute('type', 'submit');
    submit.setAttribute('name', 'opcion');
    submit.value = '¿Deseas Borrar la Base de Datos?';

    // Crear el botón "Cancelar"
    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.textContent = 'Cancelar';
    cancelButton.onclick = cancelAction2; // Asociar la acción de cancelación

    // Insertar los nuevos botones al final del fieldset
    fieldset.appendChild(submit);
    fieldset.appendChild(cancelButton);
}

function cancelAction1() {
    // Recargar la página para restablecer el estado original
    location.reload();
}

function cancelAction2() {
    // Recargar la página para restablecer el estado original
    location.reload();
}