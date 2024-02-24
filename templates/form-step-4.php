<?php
    require_once(plugin_dir_path(__FILE__) . '../includes/helpers/format_date.php');
    require_once(plugin_dir_path(__FILE__) . '../includes/helpers/format_days.php');
    require_once(plugin_dir_path(__FILE__) . '../includes/helpers/format_values.php');
    require_once(plugin_dir_path(__FILE__) . '../includes/functions/step_4.php');

    // Get saved data from previous steps
    $data_etapa_1 = get_option('reserva_veiculos_data_etapa_1');
    $data_etapa_2 = get_option('reserva_veiculos_data_etapa_2');
    $data_etapa_3 = get_option('reserva_veiculos_data_etapa_3');

    // Retrieve the selected vehicle
    $selected_vehicle = isset($data_etapa_2['vehicle']) ? $data_etapa_2['vehicle'] : null;

    // Number of days
    $quantidade_dias = calcular_quantidade_dias($data_etapa_1['data_retirada'], $data_etapa_1['data_devolucao']);

    // Value of added items
    $valor_itens_adicionados = calculate_added_items_value($data_etapa_3, $quantidade_dias);

    // Calculate the total value
    $preco_total = $selected_vehicle['price'] * $quantidade_dias + $valor_itens_adicionados;

    // Format the total price with 2 decimal places
    $preco_total_formatado = number_format($preco_total, 2, '.', '');
    
    // Check if the form was submitted
    if (isset($_POST['finalizar_submit'])) {
        // Add validations and sanitizations as necessary
        $dados_condutor = sanitize_form_data($_POST);

        // Save the form data
        update_option('reserva_veiculos_data_etapa_4', $dados_condutor);

        // Build the message
        $mensagem = build_message($dados_condutor, $data_etapa_1, $data_etapa_2, $data_etapa_3, $preco_total_formatado);

        // Define the subject of the email
        $assunto = "Detalhes da sua reserva";

        // Define the headers for the email
        $headers = 'From: cyberrminfo@gmail.com' . "\r\n" .
            'Reply-To: cyberrminfo@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Send the email to the user
        mail($dados_condutor['email'], $assunto, $mensagem, $headers);

        // Send the email to the company
        mail('cyberrminfo@gmail.com', $assunto, $mensagem, $headers);

        // Redirect to the WhatsApp URL
        header('Location: https://wa.me/73991998146?text=' . $mensagem);
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

        <!-- Payment Form -->
        <form action="../checkout.php" method="POST">
            <button type="submit" id="checkout-button">Checkout</button>
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

<script src="../../form-step-4.js"></script>
