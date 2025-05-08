function atualizarPreco() {
    const input = document.getElementById('arquivoAtualizarPreco');

    const file = input.files[0];

    if (!file) {
        alert('Por favor, selecione um arquivo Excel primeiro.');
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });

        // Pegando a primeira aba da planilha
        const firstSheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[firstSheetName];

        // Convertendo em array de objetos
        const json = XLSX.utils.sheet_to_json(worksheet);

        const formData = new FormData();
        formData.append('funcao', 'atualizarPreco');
        formData.append('dados', JSON.stringify(json));

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../../php/funcoes.php", true);
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.responseText);
            }
        }
        xhr.send(formData);
    };

    reader.readAsArrayBuffer(file);
}