<div class="modal fade" id="closeTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solucionar Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="POST" action="" >
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Id:</label>
            <input type="text" class="form-control" disabled id="idChamado" name="id" >
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Solução:</label>
            <textarea name="solution" class="form-control" id="message-text"></textarea>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="solve" class="btn btn-primary">Solucionar</button>
		</form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $("#solve").on("click", function(data){
  $.ajax({
    type: "POST",
    url: "/kanban/dashboard/closeTicket/",
    data: {id :$( "input[name='id']" ).val() , 
      solution : $( "textarea[name='solution']" ).val()},
    success: function(msg){
         location.reload();
         },
     beforeSend : function(){
     $('#closeTicket').html('<div class="loader"></div>');  
     }
  });
});</script>