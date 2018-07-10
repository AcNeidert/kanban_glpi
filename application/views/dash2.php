<?php $this->load->view('header', array()); ?>
<?php 
	$this->load->view('kanban_assign', array(
			'box' => $box, 
      'dragTo' => $dragTo, 
			'function' => $function,
      'initialItemsNew' => $initialItemsNew
	)); 
?>
<?php $this->load->view('modal_view_chamado', array());?>
<?php $this->load->view('definir_ticket', array()); ?>
<?php $this->load->view('script_end', array()); ?>





