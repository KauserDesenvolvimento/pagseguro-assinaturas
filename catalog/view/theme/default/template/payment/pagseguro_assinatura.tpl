<style>
#pagseguro_assinatura {
    padding: 15px;
    padding-top: 45px;
    width: 100%;
    background: linear-gradient(to bottom, #F7F7F7 0px, #F7F7F7 30px, #ddd 30px, #ddd 31px, #ffffff 31px);
    border: 1px solid #DDD;
    box-sizing: border-box;
}
</style>
<div id="pagseguro_assinatura">
	<p>Após confirmar os dados seguintes, voce será redirecionado para a página de confirmação de planos do PagSeguro e logo após a confirmação você será redirecionado de volta para nossa loja.</p>
    <table class="form">
        <tr>
            <td>Periodicidade</td>
            <td>
                <select name="period">
                    <option value="WEEKLY">Semanal</option>
                    <option value="MONTHLY">Mensal</option>
                    <option value="BIMONTHLY">Bimestral</option>
                    <option value="TRIMONTHLY">Trimonthly</option>
                    <option value="SEMIANNUALLY">Semestralmente</option>
                    <option value="YEARLY">Anual</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Data Final
                <br><small>Maximo de 2 anos</small></td>
            <td>
                <input type="text" id="datepicker" name="data_final">
            </td>
        </tr>
    </table>
    <input type="button" id="test" value="Continuar" class="button">
</div>
<script>
$(function() {
    $('#test').click(function(e) {
        $.ajax({
            url: 'index.php?route=payment/pagseguro_assinatura/gerarPre',
            type: 'post',
            data: {
                period: $('select[name="period"]').val(),
                data_final: $('input[name="data_final"]').val()
            },
            success: function(data) {
            	window.location = data;
            }
        });

    });
    $("#datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior',
        changeMonth: true,
        changeYear: true,
        minDate: -0,
        maxDate: "+2Y",
    });
});
</script>
