<!-- 
    Função para calcular o valor total de uma reserva
    Parâmetros:
        - quantidade_dias: quantidade de dias da reserva
        - taxa_diaria: taxa diária do veículo
    Retorno:
        - valor total da reserva
 -->
<?php
    function calcular_valor_total($quantidade_dias, $taxa_diaria) {
        return $quantidade_dias * $taxa_diaria;
    }
?>