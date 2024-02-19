<?php
require_once(plugin_dir_path(__FILE__) . '../includes/helpers/format_date.php');
require_once(plugin_dir_path(__FILE__) . '../includes/helpers/format_days.php');
require_once(plugin_dir_path(__FILE__) . '../includes/helpers/format_values.php');

// Obter dados salvos das etapas anteriores
$data_etapa_1 = get_option('reserva_veiculos_data_etapa_1');
$data_etapa_2 = get_option('reserva_veiculos_data_etapa_2');
$data_etapa_3 = get_option('reserva_veiculos_data_etapa_3');

// Recuperar o veículo selecionado
$selected_vehicle = isset($data_etapa_2['vehicle']) ? $data_etapa_2['vehicle'] : null;

// Quantidade de dias
$quantidade_dias = calcular_quantidade_dias($data_etapa_1['data_retirada'], $data_etapa_1['data_devolucao']);

// Valor dos itens adicionados
$valor_itens_adicionados = 0;

// Somar o valor de cada item adicionado
foreach ($data_etapa_3 as $item_nome => $item_data) {
    if ($item_data['price'] > 0) {
        if ($item_nome == 'limpeza_garantida') {
            $valor_itens_adicionados += $item_data['price'];
        } else {
            $valor_itens_adicionados += $item_data['price'] * $item_data['quantity'] * $quantidade_dias;
        }
    }
}

// Calcular o valor total previsto
$preco_total = $selected_vehicle['price'] * $quantidade_dias + $valor_itens_adicionados;

// Format the total price with 2 decimal places
$preco_total_formatado = number_format($preco_total, 2, '.', '');

// Verificar se o formulário foi enviado
if (isset($_POST['finalizar_submit'])) {

    // Adicione validações e sanitizações conforme necessário
    $nome = sanitize_text_field($_POST['cliente_nome']);
    $sobrenome = sanitize_text_field($_POST['cliente_sobrenome']);
    $cpf = sanitize_text_field($_POST['cliente_cpf']);
    $email = sanitize_text_field($_POST['cliente_email']);
    $telefone = sanitize_text_field($_POST['cliente_telefone']);
    $observacao = sanitize_text_field($_POST['observacao']);

    if ($observacao === '') {
        $observacao = '';
    }

    // Obter os dados do formulário
    $dados_condutor = array(
        'nome' => $nome,
        'sobrenome' => $sobrenome,
        'cpf' => $cpf,
        'email' => $email,
        'telefone' => $telefone,
        'observacao' => $observacao,
    );

    // Salvar os dados do formulário
    update_option('reserva_veiculos_data_etapa_4', $dados_condutor);

    // Montar a mensagem
    $mensagem = "Olá, " . $nome . "\n\n";
    $mensagem .= "Segue abaixo os dados da sua reserva\n\n";

    $mensagem .= "Dados do titular\n\n";
    $mensagem .= "Nome: " . $nome . "\n";
    $mensagem .= "Sobrenome: " . $sobrenome . "\n";
    $mensagem .= "CPF: " . $cpf . "\n";
    $mensagem .= "E-mail: " . $email . "\n";
    $mensagem .= "Telefone: " . $telefone . "\n";
    if ($observacao !== '') {
        $mensagem .= "Observações: " . $observacao . "\n";
    }
            
    $mensagem .= "\nDados da reserva\n\n";
    $mensagem .= "Retirada: " . format_date($data_etapa_1['data_retirada']) . " às " . $data_etapa_1['hora_retirada'] . "\n";
    $mensagem .= "Devolução: " . format_date($data_etapa_1['data_devolucao']) . " às " . $data_etapa_1['hora_devolucao'] . "\n";
    $mensagem .= "Categoria do veículo: " . $data_etapa_2['categoria_veiculo'] . "\n";
    $mensagem .= "Veículo: " . $selected_vehicle['cars'] . "\n";
            
    $mensagem .= "\nItens adicionados\n\n";

    foreach ($data_etapa_3 as $item_nome => $item_data) {
        if ($item_data['price'] > 0) {
            $mensagem .= "- " . $item_nome . ": R$ " . $item_data['price'] . " / dia\n";
        }
    }

    $mensagem .= "\nTotal de diárias: " . calcular_quantidade_dias($data_etapa_1['data_retirada'], $data_etapa_1['data_devolucao']) . "\n";
    $mensagem .= "\nTotal previsto: R$ " . $preco_total_formatado . "\n";
    $mensagem = urlencode($mensagem);

    // Define the subject of the email
    $assunto = "Detalhes da sua reserva";

    // Define the headers for the email
    $headers = 'From: cyberrminfo@gmail.com' . "\r\n" .
        'Reply-To: cyberrminfo@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Send the email to the user
    mail($email, $assunto, $mensagem, $headers);

    // Send the email to the company
    mail('cyberrminfo@gmail.com', $assunto, $mensagem, $headers);


    // Redirecionar para a URL do WhatsApp
    header('Location: https://wa.me/73999695380?text=' . $mensagem);
    exit;
}
?>

<div class="menu">
    <a class="link" href="<?php echo site_url('/'); ?>">Home</a>/
    <a class="link" href="#">Reservas Online</a>
</div>

<div class="timeline">
    <div class="timeline-wrapper">
        <div class="step" id="step1"><a class="link" href="<?php echo site_url('/'); ?>">Local, Data e Hora</a></div>
        <div class="step" id="step2"><a class="link" href="<?php echo site_url('/etapa2'); ?>">Grupos de Carros</a></div>
        <div class="step" id="step3"><a class="link" href="<?php echo site_url('/etapa3'); ?>">Adicionais e Acessórios</a></div>
        <div class="step active" id="step4"><a class="link" href="<?php echo site_url('/etapa4'); ?>">Finalizar Reserva</a></div>
    </div>
</div>

<h2 class="title">Responsável pela reserva</h2>

<div class="container-form">
    <section class="resumo-final">
        <h2 class="title-mobile">Responsável pela reserva</h2>
        <form class="form-4" method="post" action="">
            <div class="input-box-form-name">
                <label for="cliente_nome">Nome</label>
                <input type="text" id="cliente_nome" name="cliente_nome" required>
            </div>

            <div class="input-box-form-lastname">
                <label for="cliente_sobrenome">Sobrenome</label>
                <input type="text" id="cliente_sobrenome" name="cliente_sobrenome" required>
            </div>
                
            <div class="input-box-form-email">
                <label for="cliente_email">E-mail</label>
                <input type="email" id="cliente_email" name="cliente_email" required>
            </div>

            <div class="input-box-form-telefone">
                <label for="cliente_telefone">Telefone</label>
                <input type="tel" id="cliente_telefone" name="cliente_telefone" required>
            </div>

            <div class="input-box-form-cpf">
                <label for="cliente_cpf">CPF</label>
                <input type="text" id="cliente_cpf" name="cliente_cpf" required>
            </div>

            <div class="input-box-form-observacao">
                <label for="observacao">Observações</label>
                <textarea id="observacao" name="observacao" rows="6"></textarea>
            </div>

            <div class="payment">
                <h2 class="title-payment">Pagamento</h2>
                <p>Seu pagamento será realizado no momento da retirada do veículo.</p>
                
                <div class="checkbox-termos">
                    <div>
                        <input type="checkbox" id="aceito_termos" name="aceito_termos" required>
                        <label for="aceito_termos">Li e aceito os <a href="#">termos e condições</a> da reserva.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="aceito_politica" name="aceito_politica" required>
                        <label for="aceito_politica">Declaro ter conhecimento que é necessária a apresentação do mesmo cartão de crédito usado nesta transação na retirada do veículo, sob pena de cancelamento da reserva. A caução poderá ser realizada em outro cartão de crédito, desde que seja do mesmo titular da reserva e do cartão utilizado para o pré-Pagamento.</label>
                    </div>
                </div>

                <p class="text-form">Ao clicar em "Finalizar Reserva", você será redirecionado para o WhatsApp para confirmar sua reserva.</p>
            </div>

            <div class="button-submit">
                <button class="button-user-form" name="finalizar_submit" id="finalizar_submit">Finalizar Reserva</button>
            </div>
        </form>
    </section>

    <aside class="asideForm">
        <h2 class='title-geral'>Resumo da reserva</h2>

        <div class="resumo">
            <h4 class="subtitulo">
                <p><?php echo isset($data_etapa_2['categoria_veiculo']) ? esc_html($data_etapa_2['categoria_veiculo']) : ''; ?></p>
                <span class="descricao-categoria"><?php echo isset($selected_vehicle) ? esc_html($selected_vehicle['cars']) : ''; ?></span>
            </h4>
                
            <p class="descricao">
                <?php
                    if ($selected_vehicle) {
                        $image = $selected_vehicle['image'];
                        $image_path = plugin_dir_path(__FILE__) . $image;

                        if (file_exists($image_path)) {
                            $image_url = plugin_dir_url(__FILE__) . $image;
                            echo "<img class='imagem-categoria-resumo' src='{$image_url}' alt='{$selected_vehicle['category']}'>";
                        } else {
                            echo "<p>Image not found</p>";
                        }
                    }
                ?>
            </p>

            <div>
                <h4 class="subtitulo">Retirada</h4>
                <p class="descricao">
                    <?php
                        echo '<strong>', format_date(isset($data_etapa_1['data_retirada']) ? esc_html($data_etapa_1['data_retirada']) : '');
                        echo ' às ', isset($data_etapa_1['hora_retirada']) ? esc_html($data_etapa_1['hora_retirada']) : '', '</strong>';
                        echo '<br>Agência Aeroporto de Porto Seguro';
                    ?>
                </p>
            </div>
            
            <hr class="divider">
            
            <div>
                <h4 class="subtitulo">Devolução</h4>
                <p class="descricao">
                    <?php
                        echo '<strong>', format_date(isset($data_etapa_1['data_devolucao']) ? esc_html($data_etapa_1['data_devolucao']) : '');
                        echo ' às ', isset($data_etapa_1['hora_devolucao']) ? esc_html($data_etapa_1['hora_devolucao']) : '', '</strong>';
                        echo '<br>Agência Aeroporto de Porto Seguro';
                    ?>
                </p>
            </div>

            <hr class="divider">

            <h4 class="titulo-detalhe">Oferta Especial</h4>

            <p><strong>Diárias</strong><br>
                <?php echo $quantidade_dias; ?> x <span id="daily-price" data-price="<?php echo $selected_vehicle['price']; ?>">R$ <?php echo number_format($selected_vehicle['price'], 2); ?></span>
            </p>

            <h4 class="subtitulo">Itens adicionados</h4>
            <p class="descricao">
                <?php
                    foreach ($data_etapa_3 as $item_nome => $item_data) {
                        if ($item_data['price'] > 0) {
                            if ($item_nome == 'limpeza_garantida') {
                                echo '<span class="items-adicionados">- Limpeza Garantida: R$ ', $item_data['price'], '</span><br>';
                            } else if ($item_nome == 'cadeira_de_bebe') {
                                echo '<span class="items-adicionados">- Cadeira de Bebê: R$ ', $item_data['price'], ' / dia (x', $item_data['quantity'], ')</span><br>';
                            } else if ($item_nome == 'bebe_conforto') {
                                echo '<span class="items-adicionados">- Bebê Conforto: R$ ', $item_data['price'], ' / dia (x', $item_data['quantity'], ')</span><br>';
                            } else if ($item_nome == 'assento_de_elevacao') {
                                echo '<span class="items-adicionados">- Assento de Elevação: R$ ', $item_data['price'], ' / dia (x', $item_data['quantity'], ')</span><br>';
                            } else {
                                echo '<span class="items-adicionados">- ', $item_nome, ': R$ ', $item_data['price'], ' / dia (x', $item_data['quantity'], ')</span><br>';
                            }
                        }
                    }

                    if ($valor_itens_adicionados == 0) {
                        echo 'Nenhum item adicionado';
                    }
                ?>
            </p>
            
            <div class="total-previsto">
                <h4>Total previsto</h4>
                <p class="descricao">
                    <?php
                        echo '<strong class="total-price">R$ ' . $preco_total_formatado . '</strong>';
                        echo '<br>em até 6x sem juros';
                    ?>
                </p>
            </div>
        </div>
    </aside>
</div>

<div id="dialog" class="dialog">
    <div class="dialog-content">
        <p class="dialog-title">Atenção</p>
        <p id="dialog-message" class="dialog-message"></p>
        <button id="dialog-close" class="dialog-close">Fechar</button>
    </div>
</div>

<script>
    document.getElementById('finalizar_submit').addEventListener('click', function(event) {
        let nome = document.querySelector('input[name="cliente_nome"]').value;
        let sobrenome = document.querySelector('input[name="cliente_sobrenome"]').value;
        let email = document.querySelector('input[name="cliente_email"]').value;
        let cpf = document.querySelector('input[name="cliente_cpf"]').value;
        let telefone = document.querySelector('input[name="cliente_telefone"]').value;

        if (nome === '' || sobrenome === '' || email === '' || cpf === '' || telefone === '') {
            showDialog('Todos os campos são obrigatórios!');
            event.preventDefault();
        } else if (!validateEmail(email)) {
            showDialog('Email inválido! Digite um email válido.');
            event.preventDefault();
        } else if (!validaCPF(cpf)) {
            showDialog('CPF inválido! Digite um CPF válido.');
            event.preventDefault();
        }

        return true;
    });

    document.getElementById('dialog-close').addEventListener('click', function() {
        document.getElementById('dialog').style.display = 'none';
    });

    function showDialog(message) {
        document.getElementById('dialog-message').textContent = message;
        document.getElementById('dialog').style.display = 'block';
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function validaCPF(cpf) {
        cpf = cpf.replace(/\D/g, '');
        if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) return false;
        var result = true;
        [9, 10].forEach(function(j) {
            var soma = 0, r;
            cpf.split(/(?=)/).splice(0,j).forEach(function(e, i) {
                soma += parseInt(e) * ((j+2)-(i+1));
            });
            r = soma % 11;
            r = (r <2)?0:11-r;
            if(r != cpf.substring(j, j+1)) result = false;
        });
        return result;
    }
</script>
