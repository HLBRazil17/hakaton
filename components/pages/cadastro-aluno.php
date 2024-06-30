<form class="container" id="formAluno" method="post">
    <div class="card-info">
        Este campo de cadastro de alunos é uma parte fundamental do nosso sistema de gerenciamento de alunos. Ele é
        utilizado para coletar informações essenciais de identificação dos alunos, permitindo um registro detalhado e
        organizado de cada um.
    </div>

    <div class="form-group">
        <div id="mensagensAviso"></div>

        <strong>
            Os campos que possuem * são obrigatórios
        </strong>

        <div class="row-card">
            <div class="form-group">
                <label>*Nome:</label>
                <input type="text" name="nome" id="nome" placeholder="Insira seu nome" value="">
            </div>
            <div class="form-group">
                <label>*Email:</label>
                <input type="email" name="email" id="email" placeholder="Insira seu email" value="">
            </div>
        </div>
        <div class="form-group">
            <label>*Ra:</label>
            <input type="text" name="ra" id="ra" placeholder="Insira seu Ra" value="">
        </div>
        <div class="form-group">
            <label>*Telefone:</label>
            <input type="text" name="telefone" id="telefone" placeholder="(00) 9 0000-0000" value="">
        </div>
        <div class="row-card">
            <div class="form-group">
                <label>*Data de nascimento:</label>
                <input type="date" name="dataNasc" id="dataNasc" value="">
            </div>

            <div class="form-group">
                <label for="cursos">*Escolha um curso:</label>
                <select id="cursos" name="cursoNome" class="form-group">
                    <option value="" style="display: none;" selected>Selecione o curso...</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <input class="button" type="submit" value="Cadastrar">
        </div>
    </div>
</form>

<script>
    //OBTÉM O HOST DA URL ATUAL
    const urlHost = window.location.origin

    //OBTÉM OS VALORES DOS INPUTS
    const nome = document.querySelector('#nome').value;
    const email = document.querySelector('#email').value;
    const ra = document.querySelector('#ra').value;
    const telefone = document.querySelector('#telefone').value;
    const dataNasc = document.querySelector('#dataNasc').value;


    //FUNÇÃO QUE EXIBE UM AVISO PARA O USUÁRIO   
    function mostrarAviso(mensagem, tipo = 'info') {
        const mensagensAviso = document.querySelector('#mensagensAviso');
        mensagensAviso.innerHTML = `<div class="aviso ${tipo}">${mensagem}</div>`;
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

    document.getElementById('formAluno').addEventListener('submit', function (event) {
        event.preventDefault();

        //CAPTURA OS DADOS CONTIDOS NO FORMULÁRIO
        const formData = new FormData(this);

        //ENVIA OS DADOS DO ALUNOS PARA O CADASTRO
        fetch(`${urlHost}/api/v1/cadAluno.php`, {
            method: 'POST',
            body: formData,
            credentials: 'include'
        })
            .then(response => response.json())
            .then(data => {
                console.log('Cadastro realizado:', data);
                mostrarAviso('Dados enviados com sucesso!', 'sucesso');

                this.reset();
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao cadastrar aluno. Por favor, tente novamente.');
            });
    });
</script>