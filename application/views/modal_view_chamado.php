<div id="descChamado" class="modal ">
	<div class="modal-dialog modal-lg " role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id='TITULOMODAL'></a></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			
			<div id="accordion" role="tablist" aria-multiselectable="true">
				<div class="card">
					<div class="card-header" role="tab" id="headingOne">
						<h5 class="mb-0">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Informações do chamado
						</a>
						</h5>
					</div>
					<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
						<div class="card-block">
							
							
							<table class="table">
								<tr>
									<th scope="row">Título</th>
									<td id="TITULO">'+data[0].title+'</td>
									<td></td>
									<th scope="row">Data</th>
									<td id="DATA">'+dataAtualFormatada(data[0].date)+'</td>
								</tr>
								<tr>
									<th scope="row">Requerente</th>
									<td id="REQ" colspan="4">'+data[0].requerente+'</td>
									<td></td>
								</tr>
								<tr>
									<th scope="row">Descrição</th>
									<td id="DESC" colspan="4">'+data[0].content+'</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" role="tab" id="headingTwo">
						<h5 class="mb-0">
						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							Acompanhamentos
						</a>
						</h5>
					</div>
					<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div id='acompanhamentos' class="card-block">
							NONE
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" role="tab" id="headingThree">
						<h5 class="mb-0">
						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							Inserir Acompanhamento
						</a>
						</h5>
					</div>
					<div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="card-block">
							<div id="alertas"></div>
							<form  method="POST" action="" >
								<div class="form-group">
									<input type="text" class="form-control" hidden id="id_ac" name="id_ac" >
									<label for="message-text" class="col-form-label">Comentário:</label>
									<textarea name="comment_ac" class="form-control" id="message-text"></textarea>
								</div>
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								<button type="button" id="acompanhamento" class="btn btn-primary">Inserir</button>
							</form>
							
							
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		</div>
	</div>
</div>
<script type="text/javascript">
$("#acompanhamento").on("click", function(data){
	$("#acompanhamento").prop('disabled', true);
	$('#alertas').html('<div class="loader"></div>');
	$.ajax({
	type: "POST",
	url: "/kanban/dashboard/addComment/",
		data: {id_ac :$( "input[name='id_ac']" ).val() ,
			comment_ac : $( "textarea[name='comment_ac']" ).val()},
	success: function(msg){
				// location.reload();
				$('#alertas').html('<div id="alert_ok" class="alert alert-success" role="alert"><strong>Sucesso!</strong> Acompanhamento Inserido com sucesso <strong> :)</strong> </div>');
								$( "textarea[name='comment_ac']" ).val("");
			},
	error :  function(msg){
				//location.reload();
				$('#alertas').html('<div id="alert_error" class="alert alert-danger" role="alert"><strong>Erro!</strong> Acompanhamento Inserido com erro, tente novamente <strong> :(</strong> </div>');
			},
	beforeSend : function(){
		//$('#acompanhamento').html('<div class="loader"></div>');
	}
			
	});
});
$('#descChamado').on('hidden.bs.modal', function (e) {
	$('#alertas').html('');
	$("#acompanhamento").prop('disabled', false);
})
$(".kanban-item").dblclick( function(){
	$('#TITULOMODAL').html('Buscando Informações.... Aguarde!');
	$('#TITULO').html('');
	$('#DATA').html('');
	$('#REQ').html('');
	$('#DESC').html('<div class="loader"></div>');
	$.getJSON( "/kanban/dashboard/getTicketById/" + this.dataset.eid, function( data ) {
		//var dataSql = new Date();
		
		$('#TITULOMODAL').html('Chamado <a href="http://suporte.solidabrasil.com.br/chamados/front/ticket.form.php?id='+data[0].id+' " target="_blank">#'+ data[0].id+'</a>');
		$('#TITULO').html(data[0].title);
		$('#DATA').html(dataAtualFormatada(data[0].date));
		$('#REQ').html(data[0].requerente);
		$('#DESC').html(data[0].content);
		$( "input[name='id_ac']" ).val(data[0].id);
		$('#acompanhamentos').html(data['acomp']);
		
	});
	$('#descChamado').modal('show');
	
});
</script>