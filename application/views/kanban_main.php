<div id="myKanban">
	
</div>
<script src="/kanban/assets/dist/jkanban.min.js"></script>
<script>
    var KanbanTest = new jKanban({
        element: '#myKanban',
        gutter: '10px',
        widthBoard: '430px',
        dropEl : function (el, target, source, sibling) {
			var elem_working = KanbanTest.getBoardElements('_working');
			var i = 0;
			var itens = [];
			for(i = 0; i< elem_working.length; i++){
				
				itens[i] = elem_working[i].dataset.eid;
			}
			<?php echo $canUpdate[0];?> 
			
			var elem_working = KanbanTest.getBoardElements('_todo');
			var i = 0;
			var itens = [];
			for(i = 0; i< elem_working.length; i++){
				
				itens[i] = elem_working[i].dataset.eid;
			}
			<?php echo $canUpdate[1];?>	

			var elem_working = KanbanTest.getBoardElements('_done');
			if(elem_working.length > 0){
				var i = 0;
				var itens = [];
				for(i = 0; i< elem_working.length; i++){
					
					$('#idChamado').val(elem_working[i].dataset.eid);
					$('#closeTicket').modal('show');
					itens[i] = elem_working[i].dataset.eid;
				}
			}
		}, 
		boards: [
            {
                "id": "_New",
                "title": "Novos",
                "class": "info,good",
                "dragTo": ['_todo', '_working'],
                "item": <?php echo $initialItemsNew;?> 
            },
            {
                "id": "_todo",
                "title": "To Do",
                "class": "danger",
                "dragTo": ['_working'],
                "item": <?php echo $initialItemsTodo;?> 
            },
            {
                "id": "_working",
                "title": "Trabalhando",
                "class": "warning",
                "item": <?php echo $initialItemsWkg;?> 
            },
            {
                "id": "_done",
                "title": "Feito",
                "class": "success",
                "dragTo": ['_working'],
                "item": []
            }
        ]
    });
</script>