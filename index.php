<?php
            // Ignora requisições com final favicon
            if (str_ends_with($_SERVER['REQUEST_URI'], '/favicon.ico')) {
                http_response_code(204);
                exit;
            }

            require_once 'Tarefa.php';

            session_start(); 

            if(!isset($_SESSION['tarefas'])) {
                $_SESSION['tarefas'] = [];
            }

            $mensagemSucesso = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                

                if (isset($_POST['limparTarefas'])) {
                    unset($_SESSION['tarefas']); 
                    header('Location: ' . $_SERVER['PHP_SELF']); 
                    exit;
                
                } else if (isset($_POST['nomeTarefa'])) {
                    $nome = htmlspecialchars($_POST['nomeTarefa']); 
                    $descricao = htmlspecialchars($_POST['descricaoTarefa']);
                    $urgencia = htmlspecialchars($_POST['tipoUrgencia']);

                    $novaTarefa = new Tarefa($nome, $descricao, $urgencia);
                    $_SESSION['tarefas'][] = $novaTarefa;

                    $mensagemSucesso = "<p class='mensagemRegistro sucesso'>Tarefa '{$nome}' cadastrada com sucesso!</p>";
                }
            }

            function exibirLista() {
                $tarefas = $_SESSION['tarefas'];
                
                if(empty($tarefas)) {
                    echo "<p class='mensagemRegistro'>Nenhuma tarefa foi registrada.</p>";
                } else {
                    // Exibe a lista
                    echo "<section class='listaTarefas'>";
                    echo "<h2>Lista de tarefas:</h2>";
                    echo "<ul>";
                    foreach($tarefas as $tarefa) {
                        $classeUrgencia = 'urgencia-' . $tarefa->getUrgencia();
                        echo "<li class='{$classeUrgencia}'>";
                        echo "<strong>{$tarefa->getNome()}</strong>";
                        echo "<span>{$tarefa->getDescricao()} (Urgência: {$tarefa->getUrgencia()})</span>";
                        echo "</li>";
                    }
                    echo "</ul>"; 
                    echo "</section>";
                }
            }
        ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tarefas</title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
    
    <header>
        <h1>Minha Lista de Tarefas</h1>
    </header>

    <main>
            <h2>Cadastrar nova tarefa</h2>

            <?php echo $mensagemSucesso; ?>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <div class="grupoFormulario">
                <label for="nomeTarefa">Nome da tarefa</label>
                    <input type="text" name="nomeTarefa" id="nomeTarefa" required>
                </div>
                
                <div class="grupoFormulario">
                    <label for="descricaoTarefa">Descrição da tarefa</label>
                    <input type="text" name="descricaoTarefa" id="descricaoTarefa" required>
                </div>

                <div class="grupoFormulario">
                    <label for="tipoUrgencia">Urgência</label>
                    <select name="tipoUrgencia" id="tipoUrgencia" required>
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                
                <button type="submit" class="botaoCadastrar">Cadastrar</button>
            </form>
        </section>
        <?php
            exibirLista();
        ?>

        <?php if (!empty($_SESSION['tarefas'])): ?>
        <section class="limpar">
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <button type="submit" name="limparTarefas" class="botaoLimpar">Limpar todas as tarefas</button>
            </form>
        </section>
        <?php endif; ?>
    </main>

</body>
</html>
