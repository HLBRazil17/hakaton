<section id="aluno-detalhes" class="container">
    <h2>Edição Usuário</h2>
    <a href="/" style="color: black; margin: 20px 0; display: flex; align-items: center;">
        <span class="material-symbols-outlined">
            arrow_back_ios
        </span> Voltar
    </a>
    <form id="dadosAluno" method="post" class="container">

    </form>

    <h2>Tabela Curriculos</h2>

    <table class="table-desktop">
        <thead>
            <tr class="curriculo-row ">
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
                        Curso
                    </span>
                </th>
                <th>
                    <span class="material-symbols-outlined">
                        mail
                    </span>
                    <span>
                        Curriculo
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

</section>

<script>
    //OBTÉM O HOST DA URL ATUAL
    const urlHost = window.location.origin;

    //OBTÉM A URL POR INTEIRO
    const url = window.location.href;

    //OBTÉM OS PARÂMETROS DA URL
    const params = new URLSearchParams(new URL(url).search);

    //CAPTURA O VALOR DO PARÂMETRO "IDUSER"
    const alunoId = params.get('idUser');

    function getApiAluno() {
        //OBTÉM OS VALORES DO ALUNO ATRAVÉ DE SEU ID
        fetch(`${urlHost}/api/v1/getCurriculo.php?idUser=${alunoId}`, {
            method: 'GET',
            credentials: 'include'
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                renderAlunoDetalhes(data);
                createCurriculosTable(data.curriculos);
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
    getApiAluno();

    //METODO RESPONSÁVEL POR RENDERIZAR OS DADOS DO ALUNO
    function renderAlunoDetalhes(aluno) {
        const alunoDetalhes = document.getElementById('dadosAluno');

        const alunoDiv = document.createElement('div');
        alunoDiv.className = 'container';

        const alunoContent = `
        <div class="row-card">
            <div class="form-group">
                <label>Nome:</label>
                <input type="text" value="${aluno.nome}" name="nome">
            </div>
            <div class="form-group">
                <label>Ra:</label>
                <input type="text" value="${aluno.ra}" name="ra">
            </div>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="text" value="${aluno.email}" name="email">
        </div>
        <div class="form-group">
            <label>Telefone:</label>
            <input type="text" value="${aluno.telefone}" name="telefone">
        </div>
        <div class="row-card">
            <div class="form-group">
                <label>Data de nascimento:</label>
                <input type="date" name="dataNasc" id="dataNasc" value="${aluno.dataNasc}">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="estado">
                    <option value="a" ${aluno.estado === 'a' ? 'selected' : ''}>Ativo</option>
                    <option value="i" ${aluno.estado === 'i' ? 'selected' : ''}>Inativo</option>
                </select>
            </div>
        </div>
        <input class="button" type="submit" value="Atualizar" style="width:100%;">
        `;

        alunoDiv.innerHTML = alunoContent;
        alunoDetalhes.appendChild(alunoDiv);
    }

    //METODO RESPONSÁVEL POR RENDERIZAR OS DADOS DOS CURRICULOS
    function createCurriculosTable(curriculos) {
        const dadosAlunosDesktop = document.getElementById('dadosAlunosDesktop');
        //LIMPA O CONTEÚDO ANTES DE INSERIR OS NOVOS DADOS
        dadosAlunosDesktop.innerHTML = '';

        //VERIFICA SE CURRICULOS POSSUI INFORMAÇÕES, SE NÃO TIVER RETORNA UM AVISO
        if (!curriculos.length) {
            const div = document.createElement('div');
            div.innerHTML = `<strong style="margin-top: 40px; display: flex;justify-content: center;width: 100%;">Não há nenhum curriculo cadastrado :(</strong>`
            dadosAlunosDesktop.appendChild(div);
        }

        //PERCORRE AS INFORMAÇÕES DE CURRICULOS PARA RENDERIZA-LOS
        curriculos.forEach(curriculo => {
            const tr = document.createElement('tr');
            tr.className = 'curriculo-row';
            tr.innerHTML = `
            <td>${curriculo.idCurriculo}</td>
            <td>${curriculo.nomeCurso}</td>
            <td><a href="${urlHost}/upload/${curriculo.midia}" target="_blank">${urlHost}/upload/${curriculo.midia}</a> </td>
            <td>
                <button onclick="deleteCurriculo(${curriculo.idCurriculo}, '${curriculo.midia}')" style="background:red;">
                    <span class="material-symbols-outlined">
                    delete
                    </span>
                </button>
            </td>
        `;
            dadosAlunosDesktop.appendChild(tr);
        });

        const dadosAlunosMobile = document.getElementById('dadosAlunosMobile');
        //LIMPA O CONTEÚDO ANTES DE INSERIR OS NOVOS DADOS
        dadosAlunosMobile.innerHTML = '';

        //VERIFICA SE CURRICULOS POSSUI INFORMAÇÕES, SE NÃO TIVER RETORNA UM AVISO
        if (!curriculos.length) {
            const div = document.createElement('div');
            div.innerHTML = `<strong style="margin-top: 40px; display: flex;justify-content: center;width: 100%;">Não há nenhum curriculo cadastrado :(</strong>`
            dadosAlunosMobile.appendChild(div);
        }

        //PERCORRE AS INFORMAÇÕES DE CURRICULOS PARA RENDERIZA-LOS
        curriculos.forEach(curriculo => {
            const div = document.createElement('div');
            div.className = 'curriculo';
            div.innerHTML = `
            <div>
                <b>
                    ID: ${curriculo.idCurriculo}
                </b>
            <div>
            <div>
                <span>
                    Curso: ${curriculo.nomeCurso}
                </span>
                <span style="">
                    Currículo: <a href="${urlHost}/upload/${curriculo.midia}" target="_blank">${urlHost}/upload/${curriculo.midia}</a>
                </span>
            <div>
                <button onclick="deleteCurriculo(${curriculo.idCurriculo}, '${curriculo.midia}')" style="background:red;">
                    <span class="material-symbols-outlined">
                    delete
                    </span>
                </button>
            </div>
        `;
            dadosAlunosMobile.appendChild(div);
        });
    }


    function deleteCurriculo(idCurriculo, nomeArquivo) {
        //DELETA O CURRICULO ATRAVÉS DE SEU ID 
        fetch(`${urlHost}/api/v1/deleteCurriculo.php?idCurriculo=${idCurriculo}&nomeArquivo=${nomeArquivo}`, {
            method: 'DELETE',
            credentials: 'include'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload()
                } else {
                    alert(data.error);
                }
                console.log('Resposta:', data);
                console.error('Erro ao deletar currículo:', error);
                alert('Erro ao deletar currículo. Por favor, tente novamente.');
            });
    }

    document.getElementById('dadosAluno').addEventListener('submit', function (event) {
        event.preventDefault()

        //CAPTURA OS DADOS CONTIDOS NO FORMULÁRIO
        const formData = new FormData(this);

        //ATUALIZA OS DADOS DO ALUNO ATRAVÉS DE SEU ID
        fetch(`${urlHost}/api/v1/updateAluno.php?idUser=${alunoId}`, {
            method: 'POST',
            body: formData,
            credentials: 'include'
        })
            .then(response => response.json())
            .then(data => {
                window.location.reload()
                this.reset();
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao atualizar o aluno. Por favor, tente novamente.');
            });
    });


</script>