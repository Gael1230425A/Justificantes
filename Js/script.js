// Seleccionar elementos del DOM
const fileInput = document.getElementById('fileInput');
const output = document.getElementById('output');
const saveJsonButton = document.getElementById('saveJsonButton');

// Variable para almacenar los datos JSON de todas las hojas
let jsonData = {};

// Evento para manejar la carga del archivo
fileInput.addEventListener('change', (event) => {
  const file = event.target.files[0];

  if (!file) {
    alert('Por favor, selecciona un archivo.');
    return;
  }

  const reader = new FileReader();

  // Leer el archivo como binario
  reader.onload = (e) => {
    const data = new Uint8Array(e.target.result);
    const workbook = XLSX.read(data, { type: 'array' });

    // Iterar sobre todas las hojas del archivo
    workbook.SheetNames.forEach((sheetName) => {
      const sheet = workbook.Sheets[sheetName];

      // Convertir los datos de la hoja a JSON
      let sheetData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

      // Usar la primera fila como claves (headers) y las demás como datos
      if (sheetData.length > 1) {
        const headers = sheetData[0]; // La primera fila será el encabezado
        sheetData = sheetData.slice(1); // Eliminar la primera fila de los datos

        // Convertir el resto de las filas en objetos usando los encabezados
        const formattedData = sheetData.map(row => {
          const obj = {};
          row.forEach((cell, index) => {
            obj[headers[index]] = cell;
          });
          return obj;
        });

        // Almacenar los datos formateados bajo el nombre de la hoja
        jsonData[sheetName] = formattedData;
      }
    });

    // Mostrar los datos de la primera hoja en la tabla (para visualización)
    const firstSheetName = workbook.SheetNames[0];
    renderTable(jsonData[firstSheetName]);

    // Habilitar el botón para guardar el archivo JSON
    saveJsonButton.disabled = false;
  };

  reader.readAsArrayBuffer(file);
});

// Función para renderizar los datos en una tabla HTML
function renderTable(data) {
  output.innerHTML = ''; // Limpiar la tabla

  if (data && data.length > 0) {
    // Crear encabezados de la tabla
    const headersRow = document.createElement('tr');
    const headers = Object.keys(data[0]);
    headers.forEach(header => {
      const th = document.createElement('th');
      th.textContent = header;
      headersRow.appendChild(th);
    });
    output.appendChild(headersRow);

    // Crear las filas de los datos
    data.forEach(row => {
      const tr = document.createElement('tr');
      headers.forEach(header => {
        const td = document.createElement('td');
        td.textContent = row[header] || ''; // Usar '' si no hay valor
        tr.appendChild(td);
      });
      output.appendChild(tr);
    });
  }
}

// Función para guardar los datos de todas las hojas como un archivo JSON
saveJsonButton.addEventListener('click', () => {
  const blob = new Blob([JSON.stringify(jsonData, null, 2)], { type: 'application/json' });
  saveAs(blob, 'datos_completos.json'); // Usamos FileSaver.js para guardar el archivo
});
