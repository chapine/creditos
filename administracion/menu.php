	<div class="navbar-header" style="z-index: 2147483647; position:fixed;">
		<div href="#menu-toggle" class="slidebar-toggle" id="menu-toggle" style="z-index: 2147483647; position:fixed;">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<div>Menú</div>
		</div>
	</div>

  <div id="wrapper">
        <!-- Sidebar -->
	<div id="slidebar-white" class="slidebar-nav" style="border: 1px solid #d9edf7; border-top: 0; margin-top: -50px !important; background:#FFFFFF">
      <nav id="navbar1-white" class="navbar navbar-default" role="navigation">
        <ul class="nav navbar-nav">
			<?php
				$sql111 = "SELECT count(id_cliente) as cliente FROM clientes WHERE ocultar = 0";
				$res111 = $mysqli->query($sql111);
				$row111 = $res111->fetch_assoc();
			
				$sql222 = "SELECT count(id_prestamo) as prestamos FROM prestamos";
				$res222 = $mysqli->query($sql222);
				$row222 = $res222->fetch_assoc();
			
				$sql333 = "SELECT count(id_usuario) as usuarios FROM usuarios WHERE tipo_usuario = 'cobrador'";
				$res333 = $mysqli->query($sql333);
				$row333 = $res333->fetch_assoc();
			
				$sql444 = "SELECT count(id_usuario) as usuarios FROM usuarios WHERE id_usuario <> 0";
				$res444 = $mysqli->query($sql444);
				$row444 = $res444->fetch_assoc();
			?>
            
			<li class="dropdown">
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td width="90%" style="padding: 15px 0 15px 15px; border-bottom: 1px solid #cccccc; font-size: 13px;">&nbsp;</td>
							<td style="padding: 15px 15px 15px 15px; border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;">
								<a href="../logout.php" title="Cerrar sesión" style="color: red; font-size: 16px; font-weight: bold;">
									<i class="glyphicon glyphicon-off"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
            </li>
            
            <li class="dropdown">
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td width="90%" style="padding: 10px 0 10px 0; border-bottom: 1px solid #cccccc; font-size: 13px;" align="center">
							<img src="../images/logo.png" height="164" width="220" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='....'; return true;">
								<br>
								<b><spam id="Fecha_Reloj"></spam></b>
							</td>
						</tr>
					</tbody>
				</table>
            </li>
            
            <li class="dropdown">
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td align="center" width="100%" style="padding: 10px 0 10px 15px; border-bottom: 1px solid #cccccc; font-size: 13px;" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='....'; return true;">
								<a href="#" onclick="javascript:location.href='perfil_usuario.php?id=<?php echo $_SESSION['id_usuario']; ?>'" style="text-decoration:none;"><i class="glyphicon glyphicon-user"></i> <b>Bienvenido [</b> <?php echo $_SESSION['usuario']; ?> <b>]</b></a>
							</td>
						</tr>
					</tbody>
				</table>
			</li>
            
            <!--center><br><img src="../images/logo.png" height="164" width="220"><br><br><br></center-->
            
            <li class="dropdown <?php echo $active_clientes;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-briefcase"></i> Clientes <span class="badge pull-right"><?php if($row111['cliente']>99){ echo '99+'; }else{ echo $row111['cliente']; } ?></span> <b class="caret"></b></a>
                <ul class="dropdown-menu"> 
                    <li><a href="#" onclick="javascript:location.href='lista_clientes.php?numero=1'"><i class="glyphicon glyphicon-th-list"></i> Lista de clientes</a></li>
                    <li class="divider"></li>
                    <li><a href="#" onclick="javascript:location.href='lista_clientes_prestamos.php?a=0'"><i class="glyphicon glyphicon-saved"></i> Clientes sin prestamos</a></li>
                    <li><a href="#" onclick="javascript:location.href='lista_clientes_prestamos.php?a=1'"><i class="glyphicon glyphicon-open"></i> Clientes con prestamos</a></li>
                    <!--li><a href="#" onclick="javascript:location.href=''"><i class="glyphicon glyphicon-print"></i> Imprimir lista de clientes</a></li-->
                    <li role="separator" class="divider"></li>
                    <li><a href="#" onclick="javascript:location.href='nuevo_cliente.php'"><i class="glyphicon glyphicon-plus"></i> Nuevo cliente</a></li>
                    <li role="separator" class="divider"></li>
                </ul>
            </li>
               
        <li class="dropdown <?php echo $active_prestamos;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-tags"></i> Préstamos <span class="badge pull-right"><?php if($row222['prestamos']>99){ echo '99+'; }else{ echo $row222['prestamos']; } ?></span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="javascript:location.href='lista_prestamos.php?a=1'"><i class="glyphicon glyphicon-th-list"></i> Todos los préstamos</a></li>
            <li class="divider"></li>
            
            <li><a href="#" onclick="javascript:location.href='lista_prestamos.php?a=2'"><i class="glyphicon glyphicon-log-out"></i> Préstamos <span class="label label-primary">Activos</span></a></li>
            <li><a href="#" onclick="javascript:location.href='lista_prestamos.php?a=3'"><i class="glyphicon glyphicon-log-out"></i> Préstamos <span class="label label-success">Finalizados</span></a></li>
            <li><a href="#" onclick="javascript:location.href='lista_prestamos.php?a=4'"><i class="glyphicon glyphicon-log-out"></i> Préstamos <span class="label label-warning">Atrasados</span></a></li>
            
            <li class="divider"></li>
            
            <li><a href="#" onclick="javascript:location.href='lista_prestamos_vencidos.php?a=1'"><i class="glyphicon glyphicon-new-window"></i> Préstamos <span class="label label-danger">Vencidos</span></a></li>
            <li><a href="#" onclick="javascript:location.href='lista_prestamos_renovados.php?a=1'"><i class="glyphicon glyphicon-new-window"></i> Préstamos <span class="label label-primary">Renovados Activos</span></a></li>
            <li><a href="#" onclick="javascript:location.href='lista_prestamos_renovados.php?a=2'"><i class="glyphicon glyphicon-new-window"></i> Ptmo <span class="label label-success">Renovados Finalizados</span></a></li>
            
            <li class="divider"></li>
            <li><a href="#" onclick="javascript:location.href='seleccionar_fecha_ruta.php?a=1'">
            	<i class="glyphicon glyphicon-log-in"></i> Ptmo. por fecha, ruta y cobrador</a>
            </li>
            	
            <li><a href="#" onclick="javascript:location.href='seleccionar_fecha_ruta.php?a=2'">
            	<i class="glyphicon glyphicon-log-in"></i> Cobros de Ptmo por fecha, <br>ruta y cobrador</a>
            </li>
            
            
            
            <li class="divider"></li>
            
            
            <li><a href="#" onclick="javascript:location.href='seleccionar_fecha_ruta.php?a=3'">
            	<i class="glyphicon glyphicon-log-in"></i> Renovaciones. por fecha, <br>ruta y cobrador</a>
            </li>
            	
            <li><a href="#" onclick="javascript:location.href='seleccionar_fecha_ruta.php?a=4'">
            	<i class="glyphicon glyphicon-log-in"></i> Cobros de renovaciones <br>por fecha, ruta y cobrador</a>
            </li>
            	
            <li class="divider"></li>
          </ul>
        </li>
           
        <li class="dropdown <?php echo $active_cobradores;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-object-align-top"></i> Cobradores <span class="badge pull-right"><?php echo $row333['usuarios']; ?></span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="javascript:location.href='lista_cobradores.php'"><i class="glyphicon glyphicon-th-list"></i> Lista de cobradores</a></li>
            <li class="divider"></li>
            
            <li><a href="#" onclick="javascript:location.href='seleccione_cobrador.php?a=1'"><i class="glyphicon glyphicon-star"></i> Ptmo. por cobrador <span class="label label-info">Activo</span></a></li>
            <li><a href="#" onclick="javascript:location.href='seleccione_cobrador.php?a=4'"><i class="glyphicon glyphicon-star"></i> Ptmo. por cobrador <span class="label label-success">Finalizado</span></a></li>  
            <li><a href="#" onclick="javascript:location.href='seleccione_cobrador.php?a=2'"><i class="glyphicon glyphicon-star"></i> Ptmo. por cobrador <span class="label label-warning">Atrasados</span></a>
            <li><a href="#" onclick="javascript:location.href='seleccione_cobrador.php?a=6'"><i class="glyphicon glyphicon-star"></i> Ptmo. por cobrador <span class="label label-danger">Vencidos</span></a></li>
            
            <li class="divider"></li>
            <li><a href="#" onclick="javascript:location.href='seleccione_cobrador.php?a=5'"><i class="glyphicon glyphicon-user"></i> Clientes por cobradores</a></li>
            <li class="divider"></li>
            
            <li><a href="#" onclick="javascript:location.href='seleccionar_fecha.php?a=1'"><i class="glyphicon glyphicon-copyright-mark"></i> Cobros realizados por fecha</a></li>
			<!--li><a style="color: #7C0002;" href="#" onclick="javascript:location.href='seleccione_cobrador.php?a=2'"><i class="glyphicon glyphicon-copyright-mark"></i> Cobros atrasados por cobrador</a--></li>
         	<li><a href="#" onclick="javascript:location.href='seleccionar_fecha.php?a=2'" style="font-weight: bold;"><i class="glyphicon glyphicon-copyright-mark"></i> Cobros diarios</a></li>
         	<li class="divider"></li>
         	
         	<li><a href="#" onclick="javascript:location.href='cambiar_rutas.php?a=1'" style="font-weight: bold;"><i class="glyphicon glyphicon-road"></i> Cambiar rutas</a></li>
         	<li class="divider"></li>
          </ul>
        </li>
           
           
        <li class="dropdown <?php echo $active_porcentaje;?>">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="javascript:location.href='porcentaje.php'">
          		<i class="glyphicon glyphicon-tint"></i> Porcentajes <span class="label label-danger badge-pill">Nuevo</span>
        	</a>
        </li>
            
        <li class="dropdown <?php echo $active_cobros;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-stats"></i> Estadísticas <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="javascript:location.href='seleccione_cobrador.php?a=3'"><i class="glyphicon glyphicon-signal"></i> Rendimiento de cobradores</a></li>
            <li><a href="#" onclick="javascript:location.href='rendimiento_global.php'"><i class="glyphicon glyphicon-signal"></i> Rendimiento global</a></li>
            <li class="divider"></li>
            <li><a href="#" onclick="javascript:location.href='seleccionar_fecha.php?a=3'"><i class="glyphicon glyphicon-signal"></i> Rendimiento por fecha</a></li>
            <li class="divider"></li>
          </ul>
        </li>
            
            
       	<li class="dropdown <?php echo $active_rutas;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-road"></i> Rutas <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="javascript:location.href='lista_rutas.php'"><i class="glyphicon glyphicon-road"></i> Ver todas las rutas</a></li>
            <li><a href="#" onclick="javascript:location.href='nueva_ruta.php'"><i class="glyphicon glyphicon-road"></i> Agregar ruta</a></li>
            <li class="divider"></li>
          </ul>
        </li>
             
        <li class="dropdown <?php echo $active_usuarios;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> Usuarios <span class="badge pull-right"><?php echo $row444['usuarios']; ?></span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="javascript:location.href='lista_usuarios.php'"><i class="glyphicon glyphicon-th-list"></i> Lista de usuarios</a></li>
            <li class="divider"></li>
            <li><a href="#" onclick="javascript:location.href='nuevo_usuario.php'"><i class="glyphicon glyphicon-plus"></i> Nuevo usuario</a></li>
            <li class="divider"></li>
          </ul>
        </li>
        
        
        <li class="dropdown <?php echo $active_bitacora;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-book"></i> Registro de cambios <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="javascript:location.href='seleccionar_usuario.php'"><i class="glyphicon glyphicon-th-list"></i> Ver cambios del sistema</a></li>
            <li class="divider"></li>
          </ul>
        </li>
        
        <li class="dropdown <?php echo $active_mantenimiento;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Mantenimiento <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="javascript:location.href='sesiones.php'"><i class="glyphicon glyphicon-ok"></i> Sesiones activas</a></li>
            <li class="divider"></li>
            <li><a href="#" onclick="javascript:location.href='configuracion.php'"><i class="glyphicon glyphicon-cog"></i> Configuración</a></li>
          </ul>
        </li>
        
        <li class="dropdown <?php echo $active_temas;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="javascript:location.href='temas.php'"><i class="glyphicon glyphicon-tint"></i> Temas <!--span class="label label-danger badge-pill">Nuevo</span--> <span class="badge pull-right">17</span></a>
          
        </li>
        	
        	<li class="dropdown">
				<a href="../logout.php" class="dropdown-toggle" style="color: red;"><i class="glyphicon glyphicon-off"></i> <b>Cerrar sesión</b></a>
			</li>
        </ul>
        <br>
      </nav><!--/.navbar -->
    </div><!--/.sidebar-nav -->
    <script>//$("#wrapper").attr( "class", "toggled" );</script>