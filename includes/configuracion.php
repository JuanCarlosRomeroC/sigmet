<?php
ini_set('session.auto_start', 0);
include_once('configuracion_db.php');

/**
 *Constantes de rutas del sistema 
*/
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/opp\modulos\ejecucion\sigme');
define('RELATIVE_PATH','saforpre');
//--------------------------------//


/**
 *Constantes generales del sistema
*/
define('LOGO', '../../imagenes/logo.gif');//especifica la ubicaci�n virtual del logo
define('EMAIL_ADMINISTRADOR', 'cdelfin@seniat.gob.ve');//especifica la direcci�n de correo electr�nico del administrador del sistema
define('TELF_ADMINISTRADOR', '(0212) 274-4612');//especifica el telefono del administrador del sistema
define('NOMBRE_COMPANIA', '.:: seniat ::.');//Nombre a mostrar en el t�tulo de la ventana del explorador
define('MENSAJE_PIE', '<br> Todos los derechos reservados.<br>Copyright � 2010<br>Desarrollado por<br> Oficina de Planificacion y Presupuesto - SENIAT');
define('MENSAJE_PAGINA_PRINCIPAL','Como sentimiento que nos impulsa e inspira a prestarnos ayuda mutua, para nuestro crecimiento  personal  y  el  logro  de los objetivos institucionales, a trav�s de la suma de voluntades');//mensaje que aparece en la p�gina principal
define('NOMBRE_SITE', '.:: Sistema de Gesti�n de Metas- SIGME ::.');//Nombre a mostrar en algunas opciones del sistema
define('MOSTRAR_ERRORES_PHP', 'off'); //ON si desea que se muestren los errores arrojados por el sistema
define('JUEGO_CARACTERES', 'iso-8859-1');//tipo de codificaci�n que debe manejar el explorador
define('POST_MIN_CHAR', '30');//n�mero de caracteres requeridos para poder guardar un post
define('ZONA_MIN_CHAR', '100');//n�mero de caracteres requeridos para poder guardar un proyecto en la zona de valor
define('CERRAR_SESION_EXPIRA','SI');//s� desea que la sesi�n se cierre autom�ticamente despues de cumplido el tiempo de inactividad requerido
//--------------------------------//

/**
 * valores para el servidor SMTP de email
 * Note: se usa SMTP si mail() no funciona
*/
/*define(SMTP_HOST, "Coloque aqu� el nombre del host");// *Change Value*
define(SMTP_USUARIO, "Coloque aqu� la direcci�n de correo electr�nico");// *Change Value*
define(SMTP_PASS, "Coloque aqu� la contrase�a");// *Change Value*
define (EMAIL_USE_HTML, false);// *Especifica si desea utilizar formato html para los email*
define (SEND_EMAILS,true);*/
//--------------------------//
?>
