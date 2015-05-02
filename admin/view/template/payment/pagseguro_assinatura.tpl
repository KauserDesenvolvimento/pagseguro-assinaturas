<?php echo $header; ?>

<style>
	div.content:after{
		content: '';
		display: block;
		clear: both;
	}
	table.form{
		width: 50%;
		float: left;
	}
	table.form .large-field{
		width: 250px;
	}
	div.stream-parent{
		width: 48%;
		float: right;
		overflow: hidden;
	}
	div.stream{
		width: 470px;
		float: right;
		border-right: solid 1px  #ECECEC;
		border-left: solid 1px  #ECECEC;
		border-bottom: solid 1px  #ECECEC;
	}
	.stream.slick-slider{
		margin-bottom: 5px;
	}
	.stream-oferecimento{
		width: 470px;
		float: right;
		font-size: 11px;
		text-align: right;
		text-transform: uppercase;
		font-weight: bold;
	}
	.stream-oferecimento span{
		position: relative;
		bottom: 6px;
		color: rgb(163, 163, 163);
		font-size: 10px;
	}
	.produto-mercado{
		position: absolute;
		bottom: 9px;
		right: 8px;
		opacity: 0.3;
	}
	.s-product{
		padding: 4px;
		background: rgb(252, 252, 252);
		width: 460px;
		box-shadow: 0 1px 1px 0px rgba(0, 0, 0, 0.21);
		border-top: solid 1px #ECECEC !important;
		transition: all .3s;
		position: relative;
	}
	.s-product:hover{
		box-shadow: inset 0px 0px 0 4px rgba(0, 0, 0, 0.04);
	}
	.s-product:first-child{
		border-top: 0;
	}
	.sp-image{
		float: left;
		width: 75px;
		min-height: 75px;
		vertical-align: middle;
		line-height: 75px;
		text-align: center;
	}
	.sp-image a{
		vertical-align: middle;
		display: inline-block;
	}
	.sp-image img{
		max-width: 75px;
		vertical-align: middle;
		max-height: 75px;
	}	

	.sp-titulo a,
	.sp-preco a{
		display: block;
		font-size: 13px;
		margin-left: 10px;
		float: right;
		width: 369px;
		color: rgb(86, 86, 86);
		text-decoration: none;
	}
	.sp-titulo a{
		margin-top: 9px;
		font-weight: bold;
	}
	.sp-preco a{
		font-size: 14px;
		margin-top: 12px;
		font-weight: bold;
	}
	.kauser-tag{
		text-align: center;
		margin-top: 20px;
	}
	.kauser-tag img{
		max-width: 85%;
	}

	.clearfix:before {
	    content: " ";
	    display: table;
	}
	.clearfix:after {
		content: " ";
		display: table;
		clear: both;
	}
	.cb{
	  clear: both;
	}
</style>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?>
        <a href="<?php echo $breadcrumb['href']; ?>">
            <?php echo $breadcrumb['text']; ?>
        </a>
        <?php } ?>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a onclick="$('#form').submit();" class="button">
                    <?php echo $button_save; ?>
                </a>
                <a href="<?php echo $cancel; ?>" class="button">
                    <?php echo $button_cancel; ?>
                </a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            	<div class="stream-parent">
	            	<div class="stream">
	            		<!-- <div class="s-product clearfix">
	            			<div class="sp-image">
	            				<img src="http://www.codemarket.com.br/image/cache/data/felipo/opencart/reporestoque-150x150.png" width="75" height="75" alt="">
	            			</div>
	            			<div class="sp-titulo">Repor Estoque automático pelo Status do Pedido para Opencart</div>
	            			<div class="sp-preco">R$ 54,88</div>
	            		</div> -->
	            	</div>
            	</div>
                <table class="form">
                	<tr>
                		<td>Token de Produção</td>
                		<td><input type="text" class="large-field" name="pagseguro_assinatura_token_producao" value="<?php echo $pagseguro_assinatura_token_producao ?>"></td>
                	</tr>
                	<tr>
                		<td>Token da Sandbox</td>
                		<td><input type="text" class="large-field" name="pagseguro_assinatura_token_sandbox" value="<?php echo $pagseguro_assinatura_token_sandbox ?>"></td>
                	</tr>
                	<tr>
                		<td>Email</td>
                		<td><input type="text" class="large-field" name="pagseguro_assinatura_email" value="<?php echo $pagseguro_assinatura_email ?>"></td>
                	</tr>
                	<tr>
                		<td>Ambiente</td>
                		<td>
                			<select name="pagseguro_assinatura_ambiente">
                				<option <?php echo ("sandbox" == $pagseguro_assinatura_ambiente) ? 'selected="selected': '' ?>value="sandbox">Sandbox</option>
                				<option <?php echo ("producao" == $pagseguro_assinatura_ambiente) ? 'selected="selected': '' ?>value="producao">Producao</option>
                			</select>
                		</td>
                	</tr>
                    <tr>
                        <td>Status de Pedido de Assinatura</td>
                        <td><select class="form-control" name="pagseguro_assinatura_order_status" id="pagseguro_assinatura_order_status">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $pagseguro_assinatura_order_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"
                                        selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option
                                        value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Região Geográfica
                        </td>
                        <td>
                            <select name="pagseguro_assinatura_geo_zone_id">
                                <option value="0">
                                    Todas as regiões
                                </option>
                                <?php foreach ($geo_zones as $geo_zone) { ?>
                                <?php if ($geo_zone['geo_zone_id'] == $pagseguro_assinatura_geo_zone_id) { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected">
                                    <?php echo $geo_zone['name']; ?>
                                </option>
                                <?php } else { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>">
                                    <?php echo $geo_zone['name']; ?>
                                </option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Status
                        </td>
                        <td>
                            <select name="pagseguro_assinatura_status">
                                <?php if ($pagseguro_assinatura_status) { ?>
                                <option value="1" selected="selected">
                                    Habilitado
                                </option>
                                <option value="0">
                                    Desabilitado
                                </option>
                                <?php } else { ?>
                                <option value="1">
                                    Habilitado
                                </option>
                                <option value="0" selected="selected">
                                    Desabilitado
                                </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ordem de Exibição
                        </td>
                        <td>
                            <input type="text" name="pagseguro_assinatura_sort_order" value="<?php echo $pagseguro_assinatura_sort_order; ?>" size="1" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="kauser-tag">
        	<a href="http://kauser.com.br/" target="_blank"><img src="view/image/kauser-tag.png" alt="Desenvolvido por Kauser"></a>
        </div>
    </div>
</div>

<script>
$(function() {
	$.ajax({
		url: 'http://kauser.com.br/partners/?<?=$token?>',
		type: 'get',
		dataType: 'json',
		success: function(produto){
			$('div.stream').hide(0);
			$('div.stream-oferecimento').hide(0);
			$.each(produto, function(index, val) {
				var html = '<div class="s-product clearfix">';
				html += '<div class="sp-image">';
				html += '<a href="'+val['href']+'" target="_blank"><img src="'+val['thumb']+'" alt="'+val['name']+'"></a>';
				html += '</div>';
				html += '<div class="sp-titulo"><a href="'+val['href']+'" target="_blank">'+val['name']+'</a></div>';
				html += '<div class="sp-preco"><a href="'+val['href']+'" target="_blank">'+val['price']+'</a></div>';
				html += '<a href="'+val['href']+'" target="_blank"><img src="view/image/'+val['mercado']+'-logo.png" class="produto-mercado" alt="'+val['mercado']+'"></a>';
				html += '</div>';
				$('div.stream').append(html);	
				 //$('div.stream').append(val['name'] + '<br>');
			});
			//if (html) {
				$('div.stream').show(0);
				$('div.stream-oferecimento').show(0);
				$('div.stream').slick({
				  infinite: true,
				  slidesToShow: 4,
				  slidesToScroll: 2,
				  vertical: true,
				  variableWidth: false,
				  verticalSwiping: true,
				  autoplay: true,
				  autoplaySpeed: 4500,
				  adaptiveHeight: true
				});
			//}
		}
	});
});
</script>
<?php echo $footer; ?>
