<section class="container">
    <div class="card-info">
        Este campo permite que os alunos enviem seus currículos para cada curso em que estão matriculados. Cada curso
        permite o envio de até dois currículos diferentes, proporcionando aos alunos a flexibilidade de adaptar suas
        candidaturas de acordo com os requisitos específicos de cada curso.
    </div>

    <form class="form-group" method="post" enctype="multipart/form-data">
        <div id="mensagensAviso"></div>

        <strong>
            Os campos que possuem * são obrigatórios
        </strong>

        <div class="form-group">
            <label for="nome">*Ra:</label>
            <input type="text" id="ra" name="ra">
        </div>

        <div class="row-card">
            <div class="form-group">
                <label for="dataNasc">*Data de Nascimento:</label>
                <input type="date" id="dataNasc" name="dataNasc">
            </div>

            <div class="form-group">
                <label for="cursos">*Escolha um curso:</label>
                <select id="cursos" name="cursoNome">
                    <option value="" style="display: none;" selected>Selecione o curso...</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>*Enviar Curriculo (PDF):</label>
            <div class="row-card selecao-curriculo" onclick="document.getElementById('envioCurriculo').click();"
                style="cursor: pointer;">
                <span class="material-symbols-outlined">
                    note_stack_add
                </span>
                Selecionar Curriculo
            </div>
            <div id="previaCurriculo" onclick="fecharPrevia()">
                <div id="previa" style="width:100%; max-width:900px;">

                </div>
            </div>
            <input type="file" name="arquivoCurriculo" id="envioCurriculo" accept="application/pdf" style="display: none;">
        </div>

        <div class="form-group">
            <button onclick="enviarArquivo()">Enviar Curriculo</button>
        </div>
    </form>
</section>

<script>
    //OBTÉM O HOST DA URL ATUAL
    const urlHost = window.location.origin
    
    //FUNÇÃO QUE EXIBE UM AVISO PARA O USUÁRIO
    function mostrarAviso(mensagem, tipo = 'info') {
        const mensagensAviso = document.querySelector('#mensagensAviso');
        mensagensAviso.innerHTML = `<div class="aviso ${tipo}">${mensagem}</div>`;
        setTimeout(() => {
            mensagensAviso.innerHTML = ``;
        }, 15000);
    }

    //MÉTODO DE ENVIO DO CURRICULO
    function enviarArquivo() {
        event.preventDefault();

        //OBTÉM OS VALORES DO CAMPOS 
        const ra = document.querySelector('#ra').value;
        const dataNascimento = document.querySelector('#dataNasc').value;
        const cursoNome = document.querySelector('#cursos').value;
        const envioCurriculo = document.querySelector('#envioCurriculo');
        const arquivo = envioCurriculo.files[0];

        //VERIFICA SE O ARQUIVO FOI INSERIDO
        if (!arquivo) {
            mostrarAviso('Por favor, selecione um arquivo Válido.');
            return;
        }

        //VERIFICA SE O RA FOI INSERIDO
        if (!ra) {
            mostrarAviso('Por favor, insira seu nome.');
            return;
        }

        //VERIFICA SE A DATA DE NASCIMENTO FOI INSERIDA
        if (!dataNascimento) {
            mostrarAviso('Por favor, insira sua data de nascimento.');
            return;
        }

        //CRIA UM NOVO FORMULARIO E OBTÉM OS VALORES INSERIDOS PELO INPUT
        const formData = new FormData();
        formData.append('ra', ra);
        formData.append('dataNasc', dataNascimento);
        formData.append('arquivoCurriculo', arquivo);
        formData.append('cursoNome', cursoNome);

        //CADASTRO DO CURRICULO
        fetch(`${urlHost}/api/v1/valCurriculo.php`, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Ocorreu um erro ao enviar o arquivo.');
                }
                return response.json();
            })
            .then(data => {
                console.log('Resposta do servidor:', data);
                mostrarAviso('Dados enviados com sucesso!', 'sucesso');
            })
            .catch(error => {
                console.error('Erro ao enviar os dados:', error);
                mostrarAviso('Erro ao enviar os dados. Por favor, tente novamente.', 'erro');
            });
    }

    function getApiCurso() {
        //OBTÉM OS VALORES DOS CURSOS
        fetch(`${urlHost}/api/v1/getCurso.php`, {
            method: 'GET',
            credentials: 'include'
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                console.log(data);
                const selectCurso = document.getElementById('cursos');

                data.forEach(curso => {
                    const option = document.createElement('option');
                    option.value = curso.idCurso;
                    option.textContent = curso.nomeCurso;
                    selectCurso.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
    getApiCurso();

    //EXIBE UMA PRÉVIA DO CURRICULO INSERIDO
    function exibirPreviewPDF(event) {
        const arquivo = event.target.files[0];
        const reader = new FileReader();
        const previaCurriculo = document.querySelector('#previaCurriculo');
        const previa = document.querySelector('#previa');
        previaCurriculo.style.display='flex'

        reader.onload = function (e) {
            const curriculoUrl = e.target.result;
            const curriculo = `<embed src="${curriculoUrl}" type="application/pdf" width="100%" height="100%">`;
            previa.innerHTML = curriculo;
        };

        if (arquivo) {
            reader.readAsDataURL(arquivo);
        }
    }

    document.getElementById('envioCurriculo').addEventListener('change', exibirPreviewPDF);

    function fecharPrevia(){
            const previa =document.querySelector('#previaCurriculo');
            previa.style.display='none';
    }

</script>