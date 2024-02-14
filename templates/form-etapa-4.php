<?php
require_once(plugin_dir_path(__FILE__) . '../../includes/helpers/format_date.php');
require_once(plugin_dir_path(__FILE__) . '../../includes/helpers/format_days.php');
require_once(plugin_dir_path(__FILE__) . '../../includes/helpers/format_values.php');

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

// Verificar se o formulário foi enviado
if (isset($_POST['finalizar_submit'])) {

    // Obter os dados do formulário
    $dados_condutor = array(
        'nome' => sanitize_text_field($_POST['cliente_nome']),
        'sobrenome' => sanitize_text_field($_POST['cliente_sobrenome']),
        'cpf' => sanitize_text_field($_POST['cliente_cpf']),
        'email' => sanitize_text_field($_POST['cliente_email']),
        'telefone' => sanitize_text_field($_POST['cliente_telefone'])
    );

    // Salvar os dados do formulário
    update_option('reserva_veiculos_data_etapa_4', $dados_condutor);

    // Montar a mensagem
    $mensagem = "Olá, " . $dados_condutor['nome'] . "\n\n";
    $mensagem .= "Segue abaixo os dados da sua reserva\n\n";

    $mensagem .= "Dados do titular\n\n";
    $mensagem .= "Nome: " . $dados_condutor['nome'] . "\n";
    $mensagem .= "Sobrenome: " . $dados_condutor['sobrenome'] . "\n";
    $mensagem .= "CPF: " . $dados_condutor['cpf'] . "\n";
    $mensagem .= "E-mail: " . $dados_condutor['email'] . "\n";
    $mensagem .= "Telefone: " . $dados_condutor['telefone'] . "\n";
            
    $mensagem .= "\nDados da reserva\n\n";
    $mensagem .= "Retirada: " . format_date($data_etapa_1['data_retirada']) . " às " . $data_etapa_1['hora_retirada'] . "\n";
    $mensagem .= "Devolução: " . format_date($data_etapa_1['data_devolucao']) . " às " . $data_etapa_1['hora_devolucao'] . "\n";
    $mensagem .= "Categoria do veículo: " . $data_etapa_2['categoria_veiculo'] . "\n";
    $mensagem .= "Veículo: " . $selected_vehicle['cars'] . "\n";
            
    $mensagem .= "\nItens adicionados\n\n";

    foreach ($data_etapa_3 as $item_nome => $item_valor) {
        if ($item_valor > 0) {
            $mensagem .= "- " . $item_nome . ": R$ " . $item_valor . " / dia\n";
        }
    }

    $mensagem .= "\nQTotal de diárias: " . calcular_quantidade_dias($data_etapa_1['data_retirada'], $data_etapa_1['data_devolucao']) . "\n";
    $mensagem .= "\nTotal previsto: R$ " . $preco_total . "\n";
    $mensagem = urlencode($mensagem);

    // Redirecionar para a URL do WhatsApp
    header('Location: https://wa.me/73999695380?text=' . $mensagem);
    exit;
}
?>

<div class="menu">
    <a class="link" href="<?php echo site_url('/'); ?>">Home</a>
</div>

<div class="timeline">
    <div class="timeline-wrapper">
        <div class="step" id="step1"><a class="link" href="<?php echo site_url('/'); ?>">Local, Data e Hora</a></div>
        <div class="step" id="step2"><a class="link" href="<?php echo site_url('/etapa2'); ?>">Grupos de Carros</a></div>
        <div class="step" id="step3"><a class="link" href="<?php echo site_url('/etapa3'); ?>">Adicionais e Acessórios</a></div>
        <div class="step active" id="step4"><a class="link" href="<?php echo site_url('/etapa4'); ?>">Dados Cadastrais</a></div>
    </div>
</div>

<h2 class="title">Responsável pela reserva</h2>
<div class="container-form">
    <section class="resumo-final">
        <form class="form-4" method="post" action="">
            <div class="input-box-form-name">
                <label for="cliente_nome">Nome</label>
                <input type="text" name="cliente_nome" required>
            </div>

            <div class="input-box-form-lastname">
                <label for="cliente_sobrenome">Sobrenome</label>
                <input type="text" name="cliente_sobrenome" required>
            </div>
                
            <div class="input-box-form-email">
                <label for="cliente_email">E-mail</label>
                <input type="email" name="cliente_email" required>
            </div>

            <div class="input-box-form-telefone">
                <label for="cliente_telefone">Telefone</label>
                <input type="tel" name="cliente_telefone" required>
            </div>

            <div class="input-box-form-cpf">
                <label for="cliente_cpf">CPF</label>
                <input type="text" name="cliente_cpf" required>
            </div>

            <button class="button-user-form" name="finalizar_submit" id="finalizar_submit">Finalizar</button>
            <p class="text-form">* Ao finalizar sua reserva, os dados serão encaminhados para um de nossos atendentes via whatsapp e um <strong>voucher</strong> enviado ao seu email.</p>
            <p class="text-form-2">* O pagamento da reserva será realizado no momento da retirada do veículo.</p>
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
                            }
                            if ($item_nome == 'cadeira_de_bebe') {
                                echo '<span class="items-adicionados">- Cadeira de Bebê: R$ ', $item_data['price'], ' / dia (x', $item_data['quantity'], ')</span><br>';
                            }
                            if ($item_nome == 'bebe_conforto') {
                                echo '<span class="items-adicionados">- Bebê Conforto: R$ ', $item_data['price'], ' / dia (x', $item_data['quantity'], ')</span><br>';
                            }
                            if ($item_nome == 'assento_de_elevacao') {
                                echo '<span class="items-adicionados">- Assento de Elevação: R$ ', $item_data['price'], ' / dia (x', $item_data['quantity'], ')</span><br>';
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
                        echo '<strong class="total-price">R$ ' . $preco_total . '</strong>';
                        echo '<br>em até 6x sem juros';
                    ?>
                </p>
                <p class="info-payment">*O pagamento da reserva será realizado no momento da retirada do veículo.</p>
            </div>
        </div>
        <div class="info-pre-autorizacao">
            <span>Pré-autorização no cartão</span>
            <p>O valor da pré-autorização varia conforme a proteção contratada. Faça sua reserva com proteção do carro e garanta o valor reduzido.</p>
        </div>
    </aside>
</div>