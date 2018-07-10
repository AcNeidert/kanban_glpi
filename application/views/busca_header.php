<form action="/kanban/dashboard/search" method="POST" class="form my-2 my-lg-0 navbar-nav mr-left	">
      <div class="input-group">
		<input class="form-control" type="text" placeholder="" name="qry">
		<div id="dropDownFilter"  class="input-group-btn">
		<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  Filtros
		</button>
		<div class="dropdown-menu dropdown-menu-right"> 
		 <div role="separator" class="dropdown-divider"></div>
		 <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='title'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Título do Chamado</span>
			</label>
		  </label>
		</div>
		  <div role="separator" class="dropdown-divider"></div>
		  <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='desc'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Descrição do Chamado
			</label>			  
		  </label>
		</div>
		<div role="separator" class="dropdown-divider"></div>
		 <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='req'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Requerente do Chamado
			</label>			  
		  </label>
		</div>
		  <div role="separator" class="dropdown-divider"></div>
		  <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='acom'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Acompanhamento do Chamado
			</label>			  
		  </label>
		</div>
		<div role="separator" class="dropdown-divider"></div>
		  <div class="form-check form-check dropdown-item">
		  <label class="form-check-label">
			<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" name="filter[]" value='id'>
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description"> Id do Chamado
			</label>
		  </label>
		</div>
		<div role="separator" class="dropdown-divider"></div>
		</div>
      </div>
	  </div>
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>