<div class="container">
<?php echo ucwords($kind) ?>

	<p class="text-success">
		<?php 
			if( $message != ""){
				echo $message.' '.link_to(' Ver Log','users/ViewExportResults');
			}
		?>
	</p>

	<form class="form" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="span6">
					<label for="college"></label>
					<select name="form[college_id]">
						<option value="">Colegio</option>
						<?php 
							foreach ($colleges as $key => $college) { ?>
								<option value="<?php echo $college->getId(); ?>"><?php echo $college->getName() ?></option>
							<?php }
						?>	
					</select>

		  	  <label>Separador</label>
			     <select name="form[separator]" id="separador">
			     		<option value=";">punto y coma ( ; )</option>
			     		<option value=",">coma ( , )</option>
			     </select>


						<label class="checkbox">
						  <input type="checkbox" name="form[skip_first_line]" value="1" checked="checked">
						  Omitir primera fila
						</label>

						<label>Archivo(csv)</label>
							<input type="file" name="import_file" />

					<button type="submit">Importar</button>							
			</div>
			<div class="span6">
				  <div class="admin-import-file-structure">
			      El fichero CSV debe tener el siguiente formato (Los campos en negrita son obligatorios) :
			      <ul>
			      	<li><span><b>Nombres</b></span>Longitud Maxima. 60 caracteres</li>
				      <li><span><b>Apellidos </b></span>Longitud Maxima. 60 caracteres</li>
			  	    <li><span>Email </span>Longitud Maxima. 100 caracteres</li>
			      	<li><span>Login </span>Longitud Maxima. 20 caracteres</li>
			      	<li><span>Password </span>Longitud Maxima. 50 caracteres</li>
			        <li><a href="<?php echo url_for('users/DownloadImportFileExample') ?>">Ver Ejemplo </a></li>
			      </ul>
			    </div>
			</div>
		</div>
	</form>

</div>
