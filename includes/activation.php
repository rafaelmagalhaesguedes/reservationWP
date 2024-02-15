<?php
// Verifique se o arquivo não está sendo acessado diretamente
if (!defined('ABSPATH')) {
    exit;
}

// Função para adicionar dados iniciais ao ativar o plugin
function reserva_veiculos_activation()
{
    // Dados dos veículos
    $vehicles = array(
        array('image' => '../assets/images/grupo-a.png', 'cars' => 'Kwid, Uno, Mobi ou similar', 'category' => 'Grupo A - Compacto', 'price' => 100.55),
        array('image' => '../assets/images/grupo-b.png', 'cars' => 'Argo, Onix, HB20 ou similar', 'category' => 'Grupo B - Hatch', 'price' => 120.55),
        array('image' => '../assets/images/grupo-c.png', 'cars' => 'Cronos, Onix plus, HB20s ou similar', 'category' => 'Grupo C - Sedan', 'price' => 180.55),
        array('image' => '../assets/images/grupo-d.png', 'cars' => 'Renegade, Duster, Creta ou similar', 'category' => 'Grupo D - SUV', 'price' => 200.55),
        array('image' => '../assets/images/grupo-e.png', 'cars' => 'Chevrolet Spin ou Fiat Doblò', 'category' => 'Grupo E - Mini Van', 'price' => 300.55),
        array('image' => '../assets/images/grupo-f.png', 'cars' => 'S10, Ranger, Hillux ou similar', 'category' => 'Grupo F - 4x4', 'price' => 400.55),
    );

    // Dados dos adicionais
    $additionals = array(
        array('name' => 'Limpeza Garantida', 'price' => 40.00, 'description' => 'Adquira o serviço de Limpeza Garantida para facilitar sua locação e deixe de se preocupar com a lavagem do veículo antes de devolvê-lo. No entanto, esteja ciente de que se o carro estiver muito sujo, pode ser necessário pagar por uma limpeza adicional.'),
        array('name' => 'Cadeira de Bebê', 'price' => 30.00, 'description' => 'Proporcione segurança e conforto para o seu bebê em todos os passeios com nossa cadeira especializada.'),
        array('name' => 'Bebê Conforto', 'price' => 30.00, 'description' => 'Eleve a segurança e o conforto do seu filho em cada viagem com nosso assento de elevação projetado especialmente para garantir tranquilidade aos pais.'),
        array('name' => 'Assento de Elevação', 'price' => 30.00, 'description' => 'Proporcione o máximo de conforto e segurança para seu bebê durante todos os passeios com nosso bebê conforto, pensado para tranquilizar os pais e garantir o bem-estar do seu pequeno.'),
    );

    // Salvar os dados iniciais no banco de dados
    update_option('reserva_veiculos_data_veiculos', $vehicles);
    update_option('reserva_veiculos_data_additionals', $additionals);
}