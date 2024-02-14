<?php
// Salvar dados do formulário da Etapa 2
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['etapa_2_submit'])) {
    // Adicione validações e sanitizações conforme necessário
    $vehicle_index = sanitize_text_field($_POST['vehicle_index']);
    $categoria_veiculo = sanitize_text_field($_POST['vehicle_category']);

    // Obter dados dos veículos salvos no banco de dados
    $veiculos_data = get_option('reserva_veiculos_data_veiculos', array());

    // Certifique-se de que o índice existe no array
    if (isset($veiculos_data[$vehicle_index])) {
        $price = $veiculos_data[$vehicle_index]['price'];

        // Salvar os dados do veículo selecionado
        update_option('reserva_veiculos_data_etapa_2', array('categoria_veiculo' => $categoria_veiculo, 'price' => $price, 'vehicle' => $veiculos_data[$vehicle_index]));

        // Redirecionar para a próxima página (Etapa 2)
        wp_redirect(site_url('/etapa3'));

        exit;
    }
}
?>

<div class="container-etapa-2">
    <div class="menu">
        <a class="link" href="<?php echo site_url('/'); ?>">Home</a>
    </div>
    <div class="timeline">
        <div class="timeline-wrapper">
            <div class="step" id="step1"><a class="link" href="<?php echo site_url('/'); ?>">Local, Data e Hora</a></div>
            <div class="step active" id="step2"><a class="link" href="<?php echo site_url('/etapa2'); ?>">Grupos de Carros</a></div>
            <div class="step" id="step3"><p>Adicionais e Acessórios</p></div>
            <div class="step" id="step4"><p>Dados Cadastrais</p></div>
        </div>
    </div>
    <h2 class="titulo-etapa-2">Escolha o grupo de carros</h2>
    <div class="wrapper-etapa-2">
        <?php
        // Obter dados dos veículos salvos no banco de dados
        $veiculos_data = get_option('reserva_veiculos_data_veiculos', array());
        foreach ($veiculos_data as $index => $vehicle): ?>
            <form method="post" action="">
                <div class="card-etapa-2">
                    <h3 class="title-category"><?php echo $vehicle['category']; ?></h3>
                    <?php
                    $image_path = plugin_dir_path(__FILE__) . $vehicle['image'];
                    if (file_exists($image_path)) {
                        $image_url = plugin_dir_url(__FILE__) . $vehicle['image'];
                        echo "<img class='image-card-etapa-2' src='{$image_url}' alt='{$vehicle['cars']}'>";
                    } else {
                        echo "<p>Image not found</p>";
                    }
                    ?>
                    <h6 class="description-category"><?php echo $vehicle['cars'] ?></h6>
                    <p class="info">*Sua reserva garante um dos modelos de carro acima, estando sujeito à disponibilidade da locadora.</p>
                    <div class="resumo-total">
                        <span>Valor da diária</span>
                        <span class='preco-diaria'>R$ <?php echo $vehicle['price']; ?> /dia</span>
                        <span class="info">*As Proteções estão inclusas neste valor.</span>
                        <input type="hidden" name="vehicle_index" value="<?php echo $index; ?>">
                        <input type="hidden" name="vehicle_category" value="<?php echo $vehicle['category']; ?>">
                        <button class="button-form-etapa-2" type="submit" name="etapa_2_submit" value="carro">Escolher Grupo</button>
                    </div>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</div>