<?php
// Verifica se foi enviado um arquivo
if ($_FILES['pdfFile']['error'] == UPLOAD_ERR_OK && $_FILES['pdfFile']['type'] == 'application/pdf') {
   
    // Define o tamanho máximo em bytes (exemplo: 5 MB)
    $maxFileSize = 5 * 1024 * 1024; // 5 MB
   
    // Verifica o tamanho do arquivo
    if ($_FILES['pdfFile']['size'] > $maxFileSize) {
        echo "Erro: O arquivo PDF deve ter no máximo 5 MB.";
    } else {
        // Se o tamanho estiver correto, move o arquivo para o destino desejado
        $destino = 'upload/' . $_FILES['pdfFile']['name'];
        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $destino)) {
            echo "Arquivo enviado com sucesso.";
        } else {
            echo "Erro ao enviar o arquivo.";
        }
    }
   
} else {
    echo "Erro: Envie um arquivo PDF válido.";
}
?>
