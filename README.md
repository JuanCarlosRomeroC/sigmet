# Sigme
Sistema de seguimiento y control de metas, es un proyecto realizado en PHP usando la patrón de arquitectura de software MVC que servirá de base para aquella persona que quiera aprender la metodología. Para el manejo de la información se uso PL/SQL en MySQL para un mejor control de los datos. Se usaron también el  conjunto de bibliotecas ADOdb para brindar mas portabilidad, rapidez y facilidad en las conexiones. El sistema también maneja librerías de Email y de PDF para la generación de reportes.



Todo esta incluido y listo para usar, espero sea de utilidad.


## Vision General :mag:
Menu Principal
![](https://raw.githubusercontent.com/delfinworks/Sigme/master/images/sigme1.jpg)

Modulo de Carga
![](https://raw.githubusercontent.com/delfinworks/Sigme/master/images/sigme2.jpg)

## Requerimiento :white_check_mark:
- Web Server Apache-2.2.15
- PHP 5.2.13
- MySQL 5.1.46
- phpMyAdmin 3.3.3 

## PHP :gear:

```bash
public function Clase_RendirEje() 
 {
    if ($this->error!="")return $array=array(false,$this->error,0);
    $SQL = "call rendir ('$this->eje', '".$_SESSION['seniat_users_id_sigme']."', '".$_SERVER['REMOTE_ADDR']."')";
    $db=DB_CONECCION();
    $rs = $db->Execute($SQL) or die("Error guardando");
    $db->close();
    return $array=array($rs->fields[0],utf8_decode($rs->fields[1]),$rs->fields[2]);
 }
```

## PL/SQL :gear:

```bash
CREATE DEFINER=`root`@`localhost` PROCEDURE `rendir` (`v_eje` INT, `v_users` VARCHAR(8), `v_ip` VARCHAR(20))  BEGIN
        DECLARE    v_id_generado int(8);
        DECLARE    v_mensaje varchar(150);
        DECLARE    v_valor bool;


        IF EXISTS(SELECT rindio FROM safor_pry_ae_eje_um WHERE id_eje=v_eje AND rindio=0) THEN
                SET v_id_generado= v_eje;
                SET v_mensaje='Disculpe pero hay unidades de medida en acciones especificas que faltan por rendir';
                SET v_valor=true;

        ELSE
                IF EXISTS(SELECT rindio FROM safor_pry_ae_ai_eje_um WHERE id_eje=v_eje AND rindio=0) THEN
                        SET v_id_generado= v_eje;
                        SET v_mensaje='Disculpe pero hay unidades de medida en acciones intermedias que faltan por rendir';
                        SET v_valor=true;

                ELSE
                        UPDATE safor_eje SET mes_rendicion = (mes_rendicion_global+1)
                                WHERE id_eje=v_eje;

                        SET v_id_generado= v_eje;
                        SET v_mensaje='La unidad ejecutora se rindio exitosamente';
                        SET v_valor=true;

                END IF;
        END IF;

        INSERT INTO seniat_users_log (id, ip, accion, valor, id_eje)
                VALUES (v_users, v_ip, v_mensaje, '', v_eje);

        select  v_id_generado as id,v_mensaje as mensaje,v_valor as valor;
END$$
```

## Configuración :gear:

****************************************************************************************
Los archivos de configuración de la aplicación se encuentran en el directorio "includes".
****************************************************************************************
```bash
/* Constantes de base de datos "configuracion_db.php" */
define('DB_TYPE','mysql');//manejador de base de datos
define('DB_SERVIDOR', '127.0.0.1'); //Dirección IP del servidor de base de datos
define('DB_SERVIDOR_PUERTO', '3306'); // Puerto de conexión de base de datos
define('DB_SERVIDOR_USERNAME', 'user'); // Usuario de conexión de base de datos
define('DB_SERVIDOR_PASSWORD', 'password); // Password de conexión de base de datos
define('DB_DATABASE', ' sigme'); //Nombre de la base de datos
define('DB_CONEXION_P', false);  // Usar conexiones persistentes?
define('DEBUG_ADODB', false); // Opción para que la Clase ADODB muestre los errores arrojados
```
```bash
/* Constantes de rutas del sistema "configuracion.php" */
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('PATH',$_SERVER['DOCUMENT_ROOT']. '/sigme''); // 'Coloca aquí la ruta donde se encuentra el sistema a partir del directorio raíz
```

Montar la base datos db/sigme.sql

Listo!


## Compatibilidad :triangular_ruler:

Exploradores modernos y IE11.
