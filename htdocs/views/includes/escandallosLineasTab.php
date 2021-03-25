							<div class="container fluid"><!-- style="margin: 100">-->
							<div><br></div>
							<div class="row ">
								<div class="col-sm">
									<?php $ing=new ingrediente();$ing->selectIngredientes(); ?>
									<select class="form-control" id="selectEsencial" name="selectEsencial" required <?php echo $deshabilito?>>
										<option value='0' selected>NO ESENCIAL para el plato.</option>
										<option value='1'>ESENCIAL para el plato.</option>
									</select>
									<!--<select class="form-control" id="selectUds" name="selectUds" required <?php echo $deshabilito ?>>
										<option selected>GR</option>
										<option value="1">Kilos</option>
										<option value="2">Litros</option>
										<option value="3">Gramos</option>
										<option value="4">MiliLitros-CC</option>
									</select>-->
									<?php $esc->selectUnidades();?>
									<input type="text" class="form-control" id="inputCantidad"  name="inputCantidad" required maxlength="9" pattern="[0-9]{1,6}\.[0-9]{2}" placeholder="Cantidad de ingrediente con 2 decimales" <?php echo $deshabilito?>>
								</div>
								<div class="col-sm">
									<input type="text" class="form-control" id="inputCosteUd"  name="inputCosteUd" required pattern="[0-9]{1,6}\.[0-9]{2}" placeholder="Coste por Unidad de producto" <?php echo $deshabilito?>>
									<input type="text" class="form-control" id="inputCosteTotal"  name="inputCosteTotal" required pattern="[0-9]{1,6}\.[0-9]{2}" placeholder="Coste Total Unidades incluidas" <?php echo $deshabilito?>>
									<input type="text" class="form-control" id="inputCosteRacion"  name="inputCosteRacion" required pattern="[0-9]{1,6}\.[0-9]{2}" placeholder="Coste por Ración de plato servido" <?php echo $deshabilito?>>
									<input type="text" class="form-control" id="inputMerma"  name="inputMerma" required pattern="[0-9]{1,6}\.[0-9]{2}" placeholder="% Merma del ingrediente en la elaboración" <?php echo $deshabilito?>>
								</div>
								<button type="button" class="btn btn-primary" id="añadeLinea" style="margin: 20" <?php echo $deshabilito?>>Añadir</button>
								<button type="button" class="btn btn-warning" id="modificaLinea" style="display:none" style="margin: 20" <?php echo $deshabilito?>>modifica</button>
							</div>
							<div><br/></div>

							<?php $esc->cargaTablaLineas($_SESSION['idEscandallo']);?>
							</div>