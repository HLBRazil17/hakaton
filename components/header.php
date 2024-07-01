<header>
    <span class="toggle-menu" onclick="toggleNav()" style="display:flex; align-items: center;">
        <span class="material-symbols-outlined">
            menu
        </span>
    </span>
    <a href="/">
        <img src="./components/assets/logo.png" alt="logo" style="width:170px; margin:0 auto 0 10px;">
    </a>


    <div class="search-box">
        <input type="text" class="form-group" style="margin-bottom: 0;" id="searchInput" placeholder="Digite para buscar...">
        <div id="searchDropdown" class="search-dropdown"></div>
    </div>


    <!-- <span style="width:170px; margin:0 auto; align-items:center; display:flex; justify-content:center; font-size:24px;">
        HOPELUM
    </span> -->
</header>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchDropdown = document.getElementById('searchDropdown');

    searchInput.addEventListener('input', function() {
        let inputText = this.value.trim();

        //MOSTRA O DROPDWON SOMENTE SE HOUVER PELO MENOS DUAS PALAVRAS
        if (inputText.length >= 2) {
            searchDropdown.style.display = 'block';
            getAlunoName(inputText);
        } 
        
        if(inputText.length < 2){
            searchDropdown.style.display = 'none';
        }

    });

    function renderDropdown(data) {
        searchDropdown.innerHTML = '';

        //VERIFICA SE DATA POSSUI CONTEÚDO
        if (data.length == 0) {
            searchDropdown.innerHTML = '<strong>Nenhum usuário encontrado :(</strong>';
        }
        
        //PERCORRE AS INFORMAÇÕES DO ALUNO PARA RENDERIZA-LOS
        data.forEach(aluno => {
            const divAluno = document.createElement('div');
            divAluno.classList.add('aluno-box');

            divAluno.innerHTML = `
                <a href="/detalheAluno?idUser=${aluno.iduser}">
                    <div>
                        <span>
                            <b>
                                ${aluno.nome}
                            </b>
                        </span>
                         <div>
                            <small>
                                <span>Email: ${aluno.email}</span>
                                <span>Ra: ${aluno.ra}</span>
                            </small>
                         </div>
                    </div>
                </a>
            `;

            searchDropdown.appendChild(divAluno);
        });
    }

    function getAlunoName(nome) {
        console.log(nome);
        //OBTÉM OS DADOS DE TODOS OS ALUNOS
        fetch(`${urlHost}/api/v1/getAlunos.php?busca=${nome}`, {
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
                console.log(data);
                renderDropdown(data);
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
</script>