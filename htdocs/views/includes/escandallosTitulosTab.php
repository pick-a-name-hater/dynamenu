							<div><br></div>
							
							<div class="row">
								<div class="col-sm">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">Nombre del plato</span>
										</div>
										<input type="text" class="form-control" placeholder="Introduce nombre del Plato" id="inputTitulo"  name="inputTitulo" required minlength="5" maxlength="50" <?php echo $deshabilito?>>
									</div>
								</div>
							</div>
							</br/>
							<div class="row">
								<div class="col-sm">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">Descripción Plato</span>
										</div>
										<textarea class="form-control" id="inputDescripcion"  name="inputDescripcion" minlength="5" maxlength="300" placeholder="Introduce Descripción del plato" <?php echo $deshabilito?>></textarea>
									</div>							
								</div>
							</div>
							<br/>
							<div class="row">
								<div class="col-sm col-md-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">Idioma</span>
										</div>
										<?php $esc->selectIdiomas()?>
										<center><button type="button" type="submit" class="btn btn-primary" id="añadeTitulo" style="margin: 20" <?php echo $deshabilito?>>Añadir</button><center>
										<center><button type="button" type="submit" class="btn btn-warning" id="modificaTitulo" style="display:none" style="margin: 20" <?php echo $deshabilito?>>Modifica</button><center>
									</div>	
								</div>
								<!--<div class="col-sm col-md-4">
									<center><button type="button" type="submit" class="btn btn-primary" id="añadeTitulo" style="margin: 20">Añadir</button><center>
									<center><button type="button" type="submit" class="btn btn-warning" id="modificaTitulo" style="margin: 20">Modifica</button><center>
								</div>-->
								<?php $esc->cargaTablaTitulos($_SESSION['idEscandallo']); ?>
							</div>
							<br/>
