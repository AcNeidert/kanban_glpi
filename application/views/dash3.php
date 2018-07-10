<?php $this->load->view('header', array()); ?>
<?php $this->load->view('definir_ticket', array()); ?>

<script type="text/javascript">
// DOM element where the Timeline will be attached
var container = document.getElementById('visualization');
// Create a DataSet (allows two way data-binding)
var items = new vis.DataSet([
{id: 1, content: 'item 1', start: '2018-04-20'},
{id: 2, content: 'item 2', start: '2018-04-14'},
{id: 3, content: 'item 3', start: '2018-04-18'},
{id: 4, content: 'item 4', start: '2018-04-16', end: '2018-04-19'},
{id: 5, content: 'item 5', start: '2018-08-25'},
{id: 6, content: 'item 6', start: '2018-08-27'}
]);
// Configuration for the Timeline
var options = {};
// Create a Timeline
var timeline = new vis.Timeline(container, items, options);
</script>
</body>
<script>
function dataAtualFormatada(dd){
var data = new Date(dd);
var dia = data.getDate();
if (dia.toString().length == 1)
dia = "0"+dia;
var mes = data.getMonth()+1;
if (mes.toString().length == 1)
mes = "0"+mes;
var ano = data.getFullYear();
return dia+"/"+mes+"/"+ano;
}
$('#dropDownFilter .dropdown-menu').on({
	"click":function(e){
e.stopPropagation();
}
});
$("#solve").on("click", function(data){
	$.ajax({
	type: "POST",
	url: "/kanban/dashboard/assingTicket/",
	data: {id :$( "input[name='id']" ).val() ,
				idUser :$( "input[name='idUser']" ).val() ,
			comment : $( "textarea[name='comment']" ).val()},
	success: function(msg){
				location.reload();
			},
	error :  function(msg){
				location.reload();
			},
	beforeSend : function(){
		$('#closeTicket').html('<div class="loader"></div>');
	}
			
	});
});
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
								$('#alertas').html('<div id="alert_ok" class="alert alert-success" role="alert"><strong>Sucesso!</strong> Acompanhamento Inserido com sucesso :).</div>');
			},
	error :  function(msg){
				//location.reload();
				$('#alertas').html('<div id="alert_error" class="alert alert-danger" role="alert"><strong>Erro!</strong> Acompanhamento Inserido com erro, tente novamente :(.</div>');
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
</html>