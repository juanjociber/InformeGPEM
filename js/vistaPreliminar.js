
document.getElementById('description').addEventListener('input', function(event) {
    let textarea = event.target;
    let value = textarea.value;
    let lastChar = value.slice(-1);

    if (lastChar === '.') {
        // Salto de linea al detectar .
        let lines = value.split('\n');
        // Obteniendo la ultima liea
        lines[lines.length - 1] = '\u2022 ' + lines[lines.length - 1];
        // Une la nueva liena
        textarea.value = lines.join('\n');
        // agrega una nueva linea 
        textarea.value += '\n\u2022 ';
    }
});

// iniciando
document.getElementById('description').value = '\u2022 ';