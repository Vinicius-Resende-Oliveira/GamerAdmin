<div class="container">
	<div class="row">
		<div class="col-sm-12 bg-primary">
			<div class="card bg-primary">
				<div class="card-head">
					Adicionar novo membro.
				</div>
				<div card="card-body">
					<form method="POST" class="form-inline" action="<?=BASE_URL?>member/add">
						<label for="nickname">Nickname:</label>
						  <input type="text" class="form-control" placeholder="Digite o nickname" id="nickname" name="nickname">
						  <input type="submit" class="btn btn-primary btn-sm" value="Adicionar">
					</form>
				</div>
				<div class="card-footer">
					<small>Caso o usuário não esteja cadastrado iremos criar para você.</small>
				</div>
			</div>
		</div>
	</div>
</div>