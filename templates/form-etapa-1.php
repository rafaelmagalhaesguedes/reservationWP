<?php
// Salvar dados do formulário da Etapa 1
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['etapa_1_submit'])) {
    // Adicione validações e sanitizações conforme necessário
    $data_etapa_1 = array(
        'local_retirada' => sanitize_text_field($_POST['local_retirada']),
        'data_retirada' => sanitize_text_field($_POST['data_retirada']),
        'hora_retirada' => sanitize_text_field($_POST['hora_retirada']),
        'data_devolucao' => sanitize_text_field($_POST['data_devolucao']),
        'hora_devolucao' => sanitize_text_field($_POST['hora_devolucao']),
    );

    update_option('reserva_veiculos_data_etapa_1', $data_etapa_1);

    // Redirecionar para a próxima página (Etapa 2)
    wp_redirect(home_url('/etapa2'));

    exit;
}
?>

<?php
    $blocked_dates = get_option('reserva_veiculos_data_block_dates', array());

    for ($i = 0; $i < count($blocked_dates); $i++) {
        $start_date = DateTime::createFromFormat('d/m/Y', $blocked_dates[$i]['start_date']);
        $end_date = DateTime::createFromFormat('d/m/Y', $blocked_dates[$i]['end_date']);
    }
?>

<div class="container-etapa-1">
    <div class="wrapper-etapa-1">
        <form class="form-etapa-1" method="post" action="">
            <div class="wrapper-form-etapa-1">
                <h6 class="reservas-online">RESERVAS ONLINE</h6>
                <div class="card-form-etapa-1">
                    <div class="data_hora">
                        <div class="input-local-retirada">
                            <div class="select-wrapper">
                                <select
                                    class="select-location"
                                    type="text"
                                    name="local_retirada"
                                    id="local_retirada"
                                    required
                                >
                                    <option value="" disabled selected>Local de Retirada</option>
                                    <option value="Agência Aeroporto de Porto Seguro">Agência Aeroporto de Porto Seguro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        
                    <div class="data_hora">
                            <label>Data de Retirada</label>
                        <div class="input-date-time">
                            <input type="date" class="date-retirada" name="data_retirada" id="data_retirada" required />
                            <select class="time" name="hora_retirada" id="hora_retirada" required></select>
                        </div>
                    </div>
                        
                    <div class="data_hora">
                        <label>Data de Devolução</label>
                        <div class="input-date-time">
                            <input type="date" class="date-retirada" name="data_devolucao" id="data_devolucao" required />
                            <select class="time" name="hora_devolucao" id="hora_devolucao" required></select>
                        </div>
                    </div>

                    <div class="button-form">
                        <input type="submit" name="etapa_1_submit" value="Continuar" />
                    </div>
                </div>
            </div>
        </form>
        <span id="data_retirada_error" class="error-message"></span>
        <span id="data_devolucao_error" class="error-message"></span>
    </div>
</div>

<script>
    window.onload = function() {
        var selectIds = ["hora_retirada", "hora_devolucao"];
        for (var j = 0; j < selectIds.length; j++) {
            var select = document.getElementById(selectIds[j]);
            for (var i = 1; i <= 24; i++) {
                var option = document.createElement("option");
                var hour = i < 10 ? '0' + i : i;
                if (i === 24) {
                    hour = '00';
                }
                option.value = option.text = hour + ":00";
                select.add(option);
            }
        }
    }
</script>

<script>
    document.querySelector('.form-etapa-1').addEventListener('submit', function(event) {
        const dataRetirada = new Date(document.getElementById('data_retirada').value);
        const dataDevolucao = new Date(document.getElementById('data_devolucao').value);

        let dataAtual = new Date();
        dataAtual.setHours(0, 0, 0, 0);

        // Bloqueio de datas
        let blockedDates = <?php echo json_encode($blocked_dates); ?>;
        let inicioBloqueio = new Date();
        let fimBloqueio = new Date();

        for (let i = 0; i < blockedDates.length; i++) {
            inicioBloqueio = new Date(blockedDates[i].start_date);
            fimBloqueio = new Date(blockedDates[i].end_date);
            if ((dataRetirada >= inicioBloqueio && dataRetirada <= fimBloqueio) || (dataDevolucao >= inicioBloqueio && dataDevolucao <= fimBloqueio)) {
                // Se a data de retirada ou devolução estiver dentro do intervalo bloqueado, redirecionar para outra página
                window.location.href = '/atendimento-via-hatsapp';
                event.preventDefault();
            } 
        }

        if (dataRetirada < dataAtual) {
            document.getElementById('data_retirada_error').textContent = 'A data de retirada não pode ser menor que a data atual.';
            document.getElementById('data_retirada_error').style.display = 'block';
            event.preventDefault();
        }
        if (dataDevolucao < dataRetirada) {
            document.getElementById('data_devolucao_error').textContent = 'A data de devolução não pode ser menor que a data de retirada.';
            document.getElementById('data_devolucao_error').style.display = 'block';
            event.preventDefault();
        }
    });
</script>