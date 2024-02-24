<?php

function calculate_added_items_value($data_etapa_3, $quantidade_dias) {
    $valor_itens_adicionados = 0;
    foreach ($data_etapa_3 as $item_nome => $item_data) {
        if ($item_data['price'] > 0) {
            if ($item_nome == 'limpeza_garantida') {
                $valor_itens_adicionados += $item_data['price'];
            } else {
                $valor_itens_adicionados += $item_data['price'] * $item_data['quantity'] * $quantidade_dias;
            }
        }
    }
    return $valor_itens_adicionados;
}

function sanitize_form_data($form_data) {
    $dados_condutor = array(
        'nome' => sanitize_text_field($form_data['cliente_nome']),
        'sobrenome' => sanitize_text_field($form_data['cliente_sobrenome']),
        'cpf' => sanitize_text_field($form_data['cliente_cpf']),
        'email' => sanitize_text_field($form_data['cliente_email']),
        'telefone' => sanitize_text_field($form_data['cliente_telefone']),
        'observacao' => sanitize_text_field($form_data['observacao']),
    );
    return $dados_condutor;
}

function build_message($dados_condutor, $data_etapa_1, $data_etapa_2, $data_etapa_3, $preco_total_formatado) {
    $mensagem = "Olá, " . $dados_condutor['nome'] . "\n\n";
    $mensagem .= "Segue abaixo os dados da sua reserva\n\n";
    $mensagem .= "Dados do titular\n\n";
    $mensagem .= "Nome: " . $dados_condutor['nome'] . "\n";
    $mensagem .= "Sobrenome: " . $dados_condutor['sobrenome'] . "\n";
    $mensagem .= "CPF: " . $dados_condutor['cpf'] . "\n";
    $mensagem .= "E-mail: " . $dados_condutor['email'] . "\n";
    $mensagem .= "Telefone: " . $dados_condutor['telefone'] . "\n";
    if ($dados_condutor['observacao'] !== '') {
        $mensagem .= "Observações: " . $dados_condutor['observacao'] . "\n";
    }
    $mensagem .= "\nDados da reserva\n\n";
    $mensagem .= "Retirada: " . format_date($data_etapa_1['data_retirada']) . " às " . $data_etapa_1['hora_retirada'] . "\n";
    $mensagem .= "Devolução: " . format_date($data_etapa_1['data_devolucao']) . " às " . $data_etapa_1['hora_devolucao'] . "\n";
    $mensagem .= "Categoria do veículo: " . $data_etapa_2['categoria_veiculo'] . "\n";
    $mensagem .= "Veículo: " . $data_etapa_2['vehicle']['cars'] . "\n";
    $mensagem .= "\nItens adicionados\n\n";
    foreach ($data_etapa_3 as $item_nome => $item_data) {
        if ($item_data['price'] > 0) {
            $mensagem .= "- " . $item_nome . ": R$ " . $item_data['price'] . " / dia\n";
        }
    }
    $mensagem .= "\nTotal de diárias: " . calcular_quantidade_dias($data_etapa_1['data_retirada'], $data_etapa_1['data_devolucao']) . "\n";
    $mensagem .= "\nTotal previsto: R$ " . $preco_total_formatado . "\n";
    $mensagem = urlencode($mensagem);
    return $mensagem;
}
?>