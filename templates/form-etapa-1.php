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

                    <input class="button-continue-form-1" type="submit" name="etapa_1_submit" value="Continuar">
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

        // Bloquear o mês de dezembro
        const inicioBloqueio = new Date(dataRetirada.getFullYear(), 11, 1); // 1 de dezembro
        const fimBloqueio = new Date(dataRetirada.getFullYear(), 11, 31); // 31 de dezembro

        if (dataRetirada < dataAtual) {
            document.getElementById('data_retirada_error').textContent = 'A data de retirada não pode ser menor que a data atual.';
            document.getElementById('data_retirada_error').style.display = 'block';
            event.preventDefault();
        } else if (dataDevolucao < dataRetirada) {
            document.getElementById('data_devolucao_error').textContent = 'A data de devolução não pode ser menor que a data de retirada.';
            document.getElementById('data_devolucao_error').style.display = 'block';
            event.preventDefault();
        } else if ((dataRetirada >= inicioBloqueio && dataRetirada <= fimBloqueio) || (dataDevolucao >= inicioBloqueio && dataDevolucao <= fimBloqueio)) {
            // Se a data de retirada ou devolução estiver dentro do intervalo bloqueado, redirecionar para outra página
            window.location.href = '/atendimento-via-hatsapp';
            event.preventDefault();
        }
    });
</script>