							<div class="col-lg-12 col-md-12 mx-auto" style="margin-top:20">
								<br/><br/>
								<label for="inputRaciones">Raciones</label>
								<input type="text" class="form-control mb-2 mr-sm-2 escGeneral" id="inputRaciones" name="inputRaciones" minlength="1" maxlength="3" min="1" max= "999" required placeholder="Raciones. Entre 1 y 999" title="Raciones entre 1 y 999" required value='<?php echo $iRaciones?>' <?php echo $deshabilito?>>
								<label for="inputCoste">Coste/Ración</label>
								<div class="input-group mb-2 mr-sm-2">
									<input type="text" class="form-control escGeneral" id="inputCoste" name="inputCoste" maxlength="6" maxlength="6" max="999" required pattern="[0-9]{1,3}\.[0-9]{2}" title="Introduzca el número con dos decimales. Máxima longitud 6. Ejemplos 1.12, 23.00, 0.12" required value='<?php echo $iCoste?>' <?php echo $deshabilito?>>
									<div class="input-group-prepend">
									<div class="input-group-text"><img src="./Assets/Icons/calcular.svg" alt="Ver detalle"></div>
									</div>
								</div>
								<label for="inputPrecio">Precio Venta/Ración</label>
								<input type="text" class="form-control mb-2 mr-sm-2 escGeneral" id="inputPrecio" name ="inputPrecio" placeholder="Precio Venta/Ración" maxlength="6" max="999" required pattern="[0-9]{1,3}\.[0-9]{2}" title="Introduzca el número con dos decimales. Máxima longitud 6. Ejemplos 1.12, 23.00, 0.12" value='<?php echo $iPrecio?>' <?php echo $deshabilito?>>
	                            <center><button type="submit" class="btn btn-primary" id="verifica" type="submit" onclick="" disabled="disabled" style="margin: 20">Verifica</button><center>
							</div>