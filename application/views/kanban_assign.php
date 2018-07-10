<div id="myKanban">
	
</div>
<script src="/kanban/assets/dist/jkanban.min.js"></script>
<script>
    var KanbanTest = new jKanban({
        element: '#myKanban',
        gutter: '10px',
        widthBoard: '350px',
        dropEl : function (el, target, source, sibling) {
			
			var i = 0;
			var itens = [];
					
			<?php echo $function;?>
		}, 
		boards: [
            {
                "id": "_new",
                "title": "Chamados novos",
                "class": "info,good",
                "dragTo": [<?php echo $dragTo;?>],
                "item": <?php echo $initialItemsNew;?> 
            }
            <?php echo $box;?>
        ]
    });
</script>