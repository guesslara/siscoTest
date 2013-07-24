<style type="text/css">
<!--
			body {
				margin: 0px;
				/*padding: 25px;*/
				font-family: Verdana, Arial, Helvetica, sans-serif;
				font-size: small;
			}
			h1 {
				font-family: sans-serif;
				color: #0068B8;
			}
			
			li.LOCKED {
				font-weight: bold;
			}
			/* ======================================================================== */
ul.jd_menu, 
ul.jd_menu_vertical {
	margin: 0px;
	padding: 0px;
	list-style-type: none;
}
ul.jd_menu ul,
ul.jd_menu_vertical ul {
	display: none;
}
ul.jd_menu li {
	float: left; width:auto;
}

/* -- Sub-Menus -- */
ul.jd_menu ul,
ul.jd_menu_vertical ul {
	position: absolute;
	display: none;
	list-style-type: none;
	margin: 0px;
	padding: 0px;
	z-index: 10000;
}
ul.jd_menu ul li,
ul.jd_menu_vertical ul li {
	float: none;
	margin: 0px;
}			
		/* ======================================================================== */
ul.jd_menu_slate {
	height: 19px;
	background-color: #DDF;
	background: url(../../js/jdmenu/gradient.png) repeat-x;
	/*border: 1px solid #70777D;
	border-top: 1px solid #A5AFB8;
	border-left: 1px solid #A5AFB8;*/
	clear: both;
}

ul.jd_menu_vertical {
	width: 200px;
	height: auto;
	clear: both;
	background: url(../../js/jdmenu/gradient-vertical.png) repeat-x;
	background-color: #A5AFB8;
}


ul.jd_menu_slate a, 
ul.jd_menu_slate a:active,
ul.jd_menu_slate a:link,
ul.jd_menu_slate a:visited {
	text-decoration: none;
	color: #000;
}
ul.jd_menu_slate ul li a,
ul.jd_menu_slate ul li a:active,
ul.jd_menu_slate ul li a:link,
ul.jd_menu_slate ul li a:visited {
	color: #000;
}
ul.jd_menu_slate li {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	padding: 2px 6px 4px 6px;
	cursor: pointer;
	white-space: nowrap;
	color: #000;
}
ul.jd_menu_slate li.jd_menu_active_menubar,
ul.jd_menu_slate li.jd_menu_hover_menubar {
	padding-left: 5px;
	border-left: 1px solid #ABB5BC;
	padding-right: 5px;
	border-right: 1px solid #929AA1;
	border-right: 1px solid #70777D;
	color: #000;
	background: url(../../js/jdmenu/gradient-alt.png) repeat-x;
}

ul.jd_menu_vertical li.jd_menu_active_menubar,
ul.jd_menu_vertical li.jd_menu_hover_menubar {
	padding-left: 6px;
	padding-top: 1px;
	border-top: 1px solid #70777D;
	border-left: 0px;
	border-right: 0px;
}

ul.jd_menu_slate ul {
	background: #ABB5BC;
	border: 1px solid #70777D;
}
ul.jd_menu_slate ul li {
	padding: 0px 10px 3px 4px;
	background: #E6E6E6;
	border: none;
	color: #70777D;
}
ul.jd_menu_slate ul li.jd_menu_active,
ul.jd_menu_slate ul li.jd_menu_hover {
	background: url(../../js/jdmenu/gradient.png) repeat-x;
	padding-top: 1px;
	border-top: 1px solid #ABB5BC;
	padding-bottom: 2px;
	border-bottom: 1px solid #929AA1;
	color: #FFF;
}
ul.jd_menu_slate ul li.jd_menu_active a.jd_menu_active,
ul.jd_menu_slate ul li.jd_menu_hover a.jd_menu_hover {
	color: #FFF;
}
-->
</style>
		<script src="../../js/jdmenu/jquery.bgiframe.js" type="text/javascript"></script>
		<script src="../../js/jdmenu/jquery.dimensions.js" type="text/javascript"></script>
		<script src="../../js/jdmenu/jquery.jdMenu.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function(){
				$('ul.jd_menu').jdMenu({	onShow: loadMenu	});
				$('ul.jd_menu_vertical').jdMenu({onShow: loadMenu, onHide: unloadMenu, offset: 1, onAnimate: onAnimate});
			});

			function onAnimate(show) {
				//$(this).fadeIn('slow').show();
				if (show) {
					$(this)
						.css('visibility', 'hidden').show()
							.css('width', $(this).innerWidth())
						.hide().css('visibility', 'visible')
					.fadeIn('normal');
				} else {
					$(this).fadeOut('fast');
				}
			}

			var MENU_COUNTER = 1;
			function loadMenu() {
				if (this.id == 'dynamicMenu') {
					$('> ul > li', this).remove();
			
					var ul = $('<ul></ul>');
					var t = MENU_COUNTER + 10;
					for (; MENU_COUNTER < t; MENU_COUNTER++) {
						$('> ul', this).append('<li>Item ' + MENU_COUNTER + '</li>');
					}
				}
			}
			function unloadMenu() {
				if (MENU_COUNTER >= 30) {
					MENU_COUNTER = 1;
				}
			}
			// We're passed a UL
			function onHideCheckMenu() {
				return !$(this).parent().is('.LOCKED');
			}
			// We're passed a LI
			function onClickMenu() {
				$(this).toggleClass('LOCKED');
				return true;
			}
		</script>
<div style="background-image:URL(../../js/jdmenu/gradient.png); height:23px; z-index:4; display:block; position:relative; ">&nbsp;
<ul class="jd_menu jd_menu_slate" style="position: absolute; left:50%; top:0px; margin:0px 0px 0px -195px; padding:0px 0px 0px 0px; width: 390px; height:23px;">
	<li>Inventarios &raquo;
		<ul>
			<li><a href="../almacen/inventario.php?op=1">Buscar Productos</a></li>
			<li><a href="../almacen/inventario.php">Listar Productos</a></li>
		</ul>
	</li>
	<li>Movimientos &raquo;
		<ul>
			<li><a href="../movimientos/">Nuevo Movimiento</a></li>
			<li><a href="../movimientos/mov_list.php">Listar movimientos</a></li>
			<li><a href="../movimientos/editar_movimientos.php">Editar movimientos</a></li>
		</ul>
	</li>
	<li>Administracion &raquo;
		<ul>
			<li> Cat&aacute;logos &raquo;</a>
				<ul>
					<li><a href="../catalogos/usuarios1.php">Usuarios</a></li>
					<li> Almacenes &raquo;</a>
						<ul>
							<li><a href="../catalogos/tipo_alm.php">Nuevo Almacen</a></li>
							<li><a href="../catalogos/tipo_alm_listado.php">Listar Almacenes</a></li>
						</ul>			
					</li>
					<li><a href="../catalogos/conc_mov_listado.php">Conceptos de E/S</a></li>
					<li>Cat&aacute;logo de Productos &raquo;
						<ul>
							<li><a href="../almacen/alta_producto.php">Alta de Productos</a></li>
							<!--<li><a href="../almacen/cat_product_buscar.php">B&uacute;squeda</a></li>
							<li><a href="../almacen/cat_product1.php">Listar Productos</a></li>//-->
						</ul>			
					</li>
					<li>Lineas de Productos &raquo;
						<ul>
							<li><a href="../catalogos/cat_line_prod.php?op=1">Nuevo Linea</a></li>
							<li><a href="../catalogos/cat_line_prod.php?op=3">Listar Lineas</a></li>
						</ul>			
					</li>										
					<!--<li><a href="../catalogos/tipos_productos.php">Tipos Productos</a></li>	-->
					<li><a href="../catalogos/clientes.php">Clientes</a></li>
					<li><a href="../catalogos/contactos.php">Contactos</a></li>
					
				</ul>			
			</li>			
			<li><a href="../almacen/kardex.php">Kardex</a></li>
			<li><a href="../almacen/punto_reorden.php">Punto de Reorden</a></li>
			<li><a href="../reportes/">Reportes</a> </li>			
		</ul>
	</li>
	<li>Sistema &raquo;
		<ul>
			<li><a href="#">Ayuda</a></li>
			<li>M&oacute;dulos&raquo;	
				<ul>
					<li><a href="../bd_ing/main.php" target="_parent">Ingenieria</a></li>
					<li><a href="#">Otro</a></li>	
				</ul>
			</li>
	
						
			<li><a href="../../salir.php" target="_parent">Salir</a></li>
		</ul>
	</li>				
</ul>
</div>