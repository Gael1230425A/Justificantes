//elementos html que se manipulan
const excelForm= document.getElementById('excelForm');
const fileInput = document.getElementById('subirArc');

excelForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Previene que el formulario se envíe de forma predeterminada
    
    const file = fileInput.files[0]; // Obtiene el archivo cargado

    if (!file) {
        alert("Por favor, selecciona un archivo Excel.");
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {
        const data = e.target.result;
        
        // Lee el archivo Excel usando la librería xlsx
        const workbook = XLSX.read(data, { type: 'binary' });

        // Selecciona la primera hoja del archivo
        const nombreHoja = workbook.SheetNames;

        let jsonFinal = [];

        // Itera por cada hoja en el workbook
        for (let i = 0; i < nombreHoja.length; i++) {
            const numHoja = nombreHoja[i];
            const hoja = workbook.Sheets[numHoja];
        
            // Convierte la hoja a JSON y concatena los datos
            const json = XLSX.utils.sheet_to_json(hoja);
            jsonFinal = jsonFinal.concat(json);
        }
         // Genera los INSERTS
        generarSentenciasInsert(jsonFinal);
        
        setTimeout(() => {
            excelForm.submit();
        }, 4000); 

    };
    
    function generarSentenciasInsert(jsonData) {
        // Almacena tutores únicosconst aluInput = document.getElementById("alu");

        let uniqueTutors = new Map();
        let insertTutor = "";
        let insertEstudiantes = "";
    
        jsonData.forEach((record) => {
            // Sentencias para la tabla tutor
            if (!uniqueTutors.has(record.numTutor)) {
                uniqueTutors.set(record.numTutor, record.nombreTutor);
                insertTutor += `INSERT INTO tutor (numTutor, nombreTutor) VALUES (${record.numTutor}, '${(record.nombreTutor || '').replace(/'/g, "''")}');\n`;
            }
    
            // Sentencias para la tabla estudiantes
            insertEstudiantes += `INSERT INTO estudiantes(NoControl, Nombre, Semestre, Grupo, Turno, numTutor) VALUES (${record.NoControl}, '${(record.Nombre || '').replace(/'/g, "''")}', '${record.Semestre || ''}','${record.Grupo || ''}', '${record.Turno || ''}', ${record.numTutor});\n`;
        });
        document.getElementById("alu").value=insertEstudiantes;
        document.getElementById("tuto").value=insertTutor;
    }
    // Lee el archivo como un binario
    reader.readAsBinaryString(file);
});