<div class="container">
	<form method="POST" action="<?=BASE_URL?>print/upload" enctype="multipart/form-data" id="formulario">
		<div row="row">
			<div class="col-sm-12">
				<div class="card bg-info text-white">
					<div class="card-header">
						<h3>
							<i class="fas fa-image"></i>
							Envie os prints de sua caçada!
						</h3>
					</div>
					<div class="card-body">
						<div class="custom-file">
							<input onsubmit="CheckFiles(this); return false;" type="file" class="custom-file-input" id="prints" accept="image/png, image/jpeg" name="print" required>
							<label class="custom-file-label" for="customFile">Selecione os prints</label>
						</div>
					</div>
					<div class="card-footer">
						<div class="col-sm-4">
							<button onclick="processar_formulario();" class="btn btn-success form-control" id="button_prints">Enviar</button>
						</div>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>