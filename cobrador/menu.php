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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-briefcase"></i> Mis clientes <span class="badge pull-right"><?php echo $row111['cliente']; ?></span> <b class="caret"></b></a>
                <ul class="dropdown-menu"> 
                    <li><a href="#" onclick="javascript:location.href='lista_clientes.php'"><i class="glyphicon glyphicon-th-list"></i> Lista de clientes</a></li>
                    <li><a href="#" onclick="javascript:location.href='lista_clientes_prestamos.php?a=0'"><i class="glyphicon glyphicon-saved"></i> Clientes sin prestamos</a></li>
                    <li><a href="#" onclick="javascript:location.href='lista_clientes_prestamos.php?a=1'"><i class="glyphicon glyphicon-open"></i> Clientes con prestamos</a></li>
                </ul>
            </li>
        

        <li class="dropdown <?php echo $active_prestamos;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-tags"></i> Mis prestamos <span class="badge pull-right"><?php echo $row222['prestamos']; ?></span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            
            <li><a href="#" onclick="javascript:location.href='lista_prestamos.php?a=1'"><i class="glyphicon glyphicon-th-list"></i> Todos los préstamos</a></li>
            <li class="divider"></li>
            
            <li><a href="#" onclick="javascript:location.href='lista_prestamos.php?a=2'"><i class="glyphicon glyphicon-log-out"></i> Préstamos <span class="label label-primary">Activos</span></a></li>
            <li><a href="#" onclick="javascript:location.href='lista_prestamos.php?a=3'"><i class="glyphicon glyphicon-log-out"></i> Préstamos <span class="label label-success">Finalizados</span></a></li>
            
            <li class="divider"></li>
			<li><a href="#" onclick="javascript:location.href='lista_prestamos.php?a=4'"><i class="glyphicon glyphicon-log-out"></i> Préstamos <span class="label label-warning">Atrasados</span></a></li>
         	
         	<li class="divider"></li>
         	
         	<li><a style="color:#003201;" href="#" onclick="javascript:location.href='seleccionar_fecha_ruta.php'">
            	<i class="glyphicon glyphicon-log-in"></i> Ptmo. o cobros por fecha,<br> 
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ruta y cobrador</a></li>
          </ul>
		</li>
        
        
        <li class="dropdown <?php echo $active_cobradores;?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-object-align-top"></i> Cobros <span class="badge pull-right"><?php echo $row333['usuarios']; ?></span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="javascript:location.href='seleccionar_fecha.php'" style="color: #063A02; font-weight: bold;"><i class="glyphicon glyphicon-copyright-mark"></i> Cobros diarios</a></li>
          </ul>
        </li>
           
        <li class="dropdown <?php echo $active_cobros;?>">
          <a href="#" onclick="javascript:location.href='rendimiento.php'"><i class="glyphicon glyphicon-signal"></i> Mi rendimiento</a>
        </li>
             
        <li class="dropdown <?php echo $active_usuarios;?>">
          <a href="#" onclick="javascript:location.href='perfil_usuario.php'"><i class="glyphicon glyphicon-user"></i> Mi perfil</a>
        </li>
			
       
        <li class="dropdown">
			  <a href="../logout.php" class="dropdown-toggle" style="color: red;"><i class="glyphicon glyphicon-off"></i> <b>Cerrar sesión</b></a>
			</li>
        </ul>
        <br>
      </nav><!--/.navbar -->
    </div><!--/.sidebar-nav -->  