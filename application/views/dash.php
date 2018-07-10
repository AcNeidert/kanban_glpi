<?php $this->load->view('header', array()); ?>
<?php $this->load->view('solucionar_ticket', array()); ?>
<?php 
    $this->load->view('kanban_main', array(
        'canUpdate' => $canUpdate,
        'initialItemsNew' => $initialItemsNew,
        'initialItemsWkg' => $initialItemsWkg,
        'initialItemsTodo' => $initialItemsTodo
    ));
?>
<?php $this->load->view('modal_view_chamado', array());?>
<?php $this->load->view('script_end', array()); ?>