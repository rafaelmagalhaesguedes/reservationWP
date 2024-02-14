<!-- 
    Função para calcular a quantidade de dias entre duas datas
    Exemplo de uso:
    $data_inicio = '2019-01-01';
    $data_fim = '2019-01-31';
    $quantidade_dias = calcular_quantidade_dias($data_inicio, $data_fim);
    echo $quantidade_dias; // 30
 -->
<?php
    function calcular_quantidade_dias($data_inicio, $data_fim) {
        $data_inicio = strtotime($data_inicio);
        $data_fim = strtotime($data_fim);
        $diferenca = $data_fim - $data_inicio;
        return floor($diferenca / (60 * 60 * 24)); // 60 segundos * 60 minutos * 24 horas
    }
?>