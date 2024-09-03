<section class="adotante-form">
            <h2>Cadastro de Adotante</h2>
            <form action="processar_adotante.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone">

                <label for="endereco">Endereço:</label>
                <textarea id="endereco" name="endereco" rows="4"></textarea>

                <label for="preferencias">Preferências:</label>
                <textarea id="preferencias" name="preferencias" rows="4"></textarea>

                <input type="submit" value="Cadastrar">
            </form>
        </section>
    </div>
</body>
</html>
<section class="adotante-form">
            <h2>Formulário de Adoção</h2>
            <form>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome">
                
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email">
                
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone">
                
                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" rows="4"></textarea>
                
                <input type="submit" value="Enviar">
            </form>
        </section>