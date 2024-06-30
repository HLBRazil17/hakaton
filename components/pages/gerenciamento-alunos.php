<table class="table-desktop">
    <thead>
        <tr>
            <th>
                <span>
                    ID
                </span>
            </th>
            <th>
                <span class="material-symbols-outlined">
                    group
                </span>
                <span>
                    Nome
                </span>
            </th>
            <th>
                <span class="material-symbols-outlined">
                    mail
                </span>
                <span>
                    Email
                </span>
            </th>
            <th>
                <span class="material-symbols-outlined">
                    content_paste_search
                </span>
                <span>
                    Ra
                </span>
            </th>
            <th>
                <span class="material-symbols-outlined">
                    edit
                </span>
                <span>
                    Status
                </span>
            </th>
            <th>
                <span class="material-symbols-outlined">
                    edit
                </span>
                <span>
                    Edição
                </span>
            </th>
        </tr>
    </thead>
    <tbody id="dadosAlunosDesktop">

    </tbody>
</table>
<section class="container" id="dadosAlunosMobile">

</section>

<script>
    //OBTÉM O HOST DA URL ATUAL
    const urlHost = window.location.origin

    //FUNÇÃO QUE EXIBE UM AVISO PARA O USUÁRIO
    function mostrarAviso(mensagem, tipo = 'info') {
        const mensagensAviso = document.querySelector('#mensagensAviso');
        mensagensAviso.innerHTML = `<div class="aviso ${tipo}">${mensagem}</div>`;
    }

    //METODO RESPONSÁVEL POR RENDERIZAR
    function mostrarAlunos(data) {
        const dadosAlunosDesktop = document.querySelector('#dadosAlunosDesktop');
        const dadosAlunosMobile = document.querySelector('#dadosAlunosMobile');

        //LIMPA O CONTEÚDO ANTES DE INSERIR OS NOVOS DADOS
        dadosAlunosDesktop.innerHTML = '';

        //PERCORRE AS INFORMAÇÕES DO ALUNO PARA RENDERIZA-LOS
        data.forEach(aluno => {
            const divAluno = document.createElement('tr');
            divAluno.classList.add('aluno');

            divAluno.innerHTML = `
                <td><span>${aluno.iduser}</span></td>
                <td><span>${aluno.nome}</span></td>
                <td><span>${aluno.email}</span></td>
                <td><span>${aluno.ra}</span></td>
                <td><strong style="color: ${aluno.estado === 'a' ? 'green' : 'red'};">${aluno.estado === 'a' ? 'Ativo' : 'Inativo'}</strong></td>
                <td>
                    <a href="/detalheAluno?idUser=${aluno.iduser}">
                        <span class="material-symbols-outlined">
                        open_in_new
                        </span>
                        Detalhes
                    </a>
                </td>
            `;

            dadosAlunosDesktop.appendChild(divAluno);
        });

        //PERCORRE AS INFORMAÇÕES DO ALUNO PARA RENDERIZA-LOS
        data.forEach(aluno => {
            const divAluno = document.createElement('div');
            divAluno.classList.add('aluno');

            divAluno.innerHTML = `
                <div><b>ID: ${aluno.iduser}</b></div>
                <div>
                    <span>Nome: ${aluno.nome}</span>
                    <span>Email: ${aluno.email}</span>
                    <span>Ra: ${aluno.ra}</span>
                </div>
                <div style="justify-content:space-between; flex-direction: row;">
                    <span>
                        Status:
                        <strong style="color: ${aluno.estado === 'a' ? 'green' : 'red'};">${aluno.estado === 'a' ? 'Ativo' : 'Inativo'}</strong></td>
                    </span>
                    <a href="/detalheAluno?idUser=${aluno.iduser}">
                        <span class="material-symbols-outlined">
                        open_in_new
                        </span>
                        Detalhes
                    </a>
                </div>
            `;

            dadosAlunosMobile.appendChild(divAluno);
        });
    }

    function getApiAluno() {
        //OBTÉM OS DADOS DE TODOS OS ALUNOS
        fetch(`${urlHost}/api/v1/getAlunos.php`, {
            method: 'GET',
            credentials: 'include'
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na requisição');
                }
                return response.json();
            })
            .then(data => {
                mostrarAlunos(data);
            })
            .catch(error => {
                console.error('Erro:', error);
                mostrarAviso('Erro ao carregar os dados dos alunos.', 'error');
            });
    }

    getApiAluno();

</script>