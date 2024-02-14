<?php
require_once(plugin_dir_path(__FILE__) . '../../includes/helpers/format_date.php');
require_once(plugin_dir_path(__FILE__) . '../../includes/helpers/format_days.php');
require_once(plugin_dir_path(__FILE__) . '../../includes/helpers/format_values.php');

// Obter dados salvos das etapas anteriores
$data_etapa_1 = get_option('reserva_veiculos_data_etapa_1');
$data_etapa_2 = get_option('reserva_veiculos_data_etapa_2');
$dados_usuario = get_option('reserva_veiculos_data_etapa_3');

// Obter dados dos adicionais salvos no banco de dados
$adicionais_data = get_option('reserva_veiculos_data_additionals', []);

// Recuperar o veículo selecionado
$selected_vehicle = isset($data_etapa_2['vehicle']) ? $data_etapa_2['vehicle'] : null;

// Calcular a quantidade de diárias
$quantidade_dias = calcular_quantidade_dias($data_etapa_1['data_retirada'], $data_etapa_1['data_devolucao']);

// Salvar dados do formulário da Etapa 3    
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['etapa_3_submit'])) {
    // Add validations and sanitizations as necessary
    $dados_usuario = array();
    foreach ($adicionais_data as $adicional) {
        $adicional_name = str_replace(' ', '_', strtolower(remove_accents($adicional['name'])));
        $dados_usuario[$adicional_name] = array(
            'price' => sanitize_text_field(isset($_POST[$adicional_name])) ? $adicional['price'] : 0,
            'quantity' => sanitize_text_field(isset($_POST[$adicional_name . '_qty'])) ? $_POST[$adicional_name . '_qty'] : 0
        );
    }

    update_option('reserva_veiculos_data_etapa_3', $dados_usuario);

    // Redirect to the next page (Step 2)
    wp_redirect(site_url('/etapa4'));
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
        <div class="step active" id="step3"><a class="link" href="<?php echo site_url('/etapa3'); ?>">Adicionais e Acessórios</a></div>
        <div class="step" id="step4"><p>Dados Cadastrais</p></div>
    </div>
</div>

<h3 class='title'>Adicionais e Acessórios (opcional)</h3>
<div class="containerDisplay">
    <section class="sectionForm">
        <form class="form-user" method="POST" action="">
        <?php foreach ($adicionais_data as $adicional): ?>
            <div class="box-adicionais">
                <div class="adicionais">
                    <div class="sub-items">
                        <span class="add1"><?php echo esc_html($adicional['name']); ?></span>
                        <?php 
                        $adicional_name_attr = esc_attr(str_replace(' ', '_', strtolower(remove_accents($adicional['name']))));
                        $adicional_price = esc_attr($adicional['price']);
                        $adicional_name = esc_attr($adicional['name']);
                        ?>
                        <?php if ($adicional['name'] != 'Limpeza Garantida') : ?>
                            <span class="quantity">Quantidade</span><input type="number" class="quantity-additional" id="<?php echo $adicional_name_attr; ?>_qty" name="<?php echo $adicional_name_attr; ?>_qty" min="1" value="1">
                        <?php endif; ?>
                        <label for="<?php echo $adicional_name_attr; ?>">
                            <span>R$</span><?php echo esc_html($adicional['price']); ?><?php echo ($adicional['name'] != 'Limpeza Garantida') ? '/dia' : ''; ?>
                        </label>
                        <input type="checkbox" class="checkbox-additional" id="<?php echo $adicional_name_attr; ?>" name="<?php echo $adicional_name_attr; ?>" value="0" data-price="<?php echo $adicional_price; ?>" data-name="<?php echo $adicional_name; ?>">
                    </div>
                </div>
                <p><?php echo esc_html($adicional['description']); ?></p>
            </div>
        <?php endforeach; ?>

            <input class="button-user-form" type="submit" name="etapa_3_submit" value="Continuar">
        </form>
    </section>

    <aside class="asideForm">
        <h2 class='title-geral'>Resumo da Reserva</h2>

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

            <p class="descricao">
                <h4 class="titulo-detalhe">Oferta Especial</h4>

                <p><strong>Diárias</strong><br>
                    <?php echo $quantidade_dias; ?> x <span id="daily-price" data-price="<?php echo $selected_vehicle['price']; ?>">R$ <?php echo number_format($selected_vehicle['price'], 2); ?></span>
                </p>

                <?php
                // Display the total value of additional items
                echo '<p><strong>Itens adicionados</strong><br>';
                echo '<p class="itens" id="items"></p>';
                echo '</p>';
                echo '<div class="total-previsto"><span>Total previsto</span><p id="total-price" class="valor-total"></p></div>';
                ?>
            </p>

            <div class="info-pre-autorizacao">
                <span>Pré-autorização no cartão</span>
                <p>O valor da pré-autorização varia conforme a proteção contratada. Faça sua reserva com proteção do carro e garanta o valor reduzido.</p>
            </div>

        </div>
    </aside>
</div>

<script>
    // Get all checkboxes and quantity inputs
    let checkboxes = document.querySelectorAll('input[type="checkbox"]');
    let quantities = document.querySelectorAll('input[type="number"].quantity-additional');

    // Function to update total and display selected items
    function updateTotalAndDisplayItems() {
        let total = 0;
        let items = '';
        let dailyPrice = parseFloat(document.getElementById('daily-price').dataset.price);
        let numberOfDays = <?php echo $quantidade_dias; ?>;
        total += dailyPrice * numberOfDays;
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                let quantity = document.getElementById(checkboxes[i].id + '_qty') ? parseInt(document.getElementById(checkboxes[i].id + '_qty').value) : 1;
                if (checkboxes[i].dataset.name == 'Limpeza Garantida') {
                    total += parseFloat(checkboxes[i].dataset.price);
                    items += '- ' + checkboxes[i].dataset.name + ': R$ ' + parseFloat(checkboxes[i].dataset.price).toFixed(2) + '<br>';
                } else {
                    total += parseFloat(checkboxes[i].dataset.price) * numberOfDays * quantity;
                    items += '- ' + checkboxes[i].dataset.name + ': R$ ' + parseFloat(checkboxes[i].dataset.price).toFixed(2) + ' / dia (x' + quantity + ')<br>';
                }
            }
        }
        if (total == dailyPrice * numberOfDays) {
            items = 'Nenhum item adicionado';
        }
        document.getElementById('total-price').innerText = 'R$ ' + total.toFixed(2);
        document.getElementById('items').innerHTML = items;
    }

    // Add event listener to all checkboxes and quantity inputs
    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', updateTotalAndDisplayItems);
    }
    for (let i = 0; i < quantities.length; i++) {
        quantities[i].addEventListener('input', updateTotalAndDisplayItems);
    }

    // Update total and display items initially
    updateTotalAndDisplayItems();
</script>