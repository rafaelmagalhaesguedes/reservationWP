<!-- 
    Função para formatar a data para o padrão brasileiro
    Exemplo de uso: echo format_date($post['created_at']);
 -->
<?php
    function format_date($date_string) {
        $date = new DateTime($date_string);
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE
        );
        return $formatter->format($date);
    }
?>