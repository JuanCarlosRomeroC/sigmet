<?php
require_once("../../includes/funciones/funciones_iniciales.php");
$saja->set_process_file(PATH."/modulos/principal/index.funciones.php");
$saja->set_process_class("index_funciones");

echo $saja->saja_js();
//$gui->pathway_recorrido("Acerca de..",true);  
?>
<style type="text/css">
.centrado{
	text-align: center;
}
</style>
<link href="msj/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="msj/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="msj/jquery-ui-personalized-1.5.2.packed.js"></script>
<script type="text/javascript" src="msj/sprinkle.js"></script>
<script language="JavaScript">
	<?php echo $saja->run("Grid_Eje()->eje");?>
</script>

<body>
<?php $gui->marco_abrir("Bienvenido ".$_SESSION['seniat_users_nombre_sigme']); ?>
		<div id="tabvanilla" class="widget">
            <ul class="tabnav">
                <li><a href="#general">INFORMACI&oacute;N GENERAL</a></li>
                <li><a href="#status">STATUS DE LA RENDICI&oacute;N</a></li>
            </ul>

            <div id="general" class="tabdiv">
                <ul>
                    <li>Recuerde que la Ejecuci&oacute;n del Plan es hasta el mes de <strong class="rojo">DICIEMBRE <img src="../../images/rendido_peq.png" width="16" height="16"></strong></li>
              <p>&nbsp;</p>
                    <li>La fecha TOPE para la carga de la Ejecuci&oacute;n del Plan es el <strong class="rojo">15 de Enero</strong> <img src="../../images/icon-date.gif" width="16" height="16"></li>
                   <p>&nbsp;</p>
                   <p>&nbsp;</p>
                   <p>&nbsp;</p>
                   <p>&nbsp;</p>
                   <p>&nbsp;</p>
                   <p>&nbsp;</p>                   
                   <p align="center">&copy; Copyright Oficina de Planificaci&oacute;n y Presupuesto - Red Interna</p>
              </ul>
</div>
            
             <div id="status" class="tabdiv">
                <ul>
                    <li><strong>Status de la Ejecuci&oacute;n del Plan por Ejecutor:</strong></li>
                  <p><div id="eje"></div></p>
              </ul>
            </div>
        </div>

<?php $gui->marco_cerrar(); ?>
</body>
</html>