English | [Español](./README.es-US.md)


# Sigmet
System of monitoring and control of objectives, is a project made in PHP using the software architecture pattern MVC. Will serve for that person who wants to learn the methodology. The PL / SQL programming language was used to manage the information in MySQL for better control of the data. The ADOdb library set was also implemented to provide more portability, speed and ease of connections. The system also manages email and PDF libraries for the generation of reports.

Everything is included and ready to use, I hope it will be useful.

## Overview :mag:
Main menu
![](https://raw.githubusercontent.com/delfinworks/sigmet/master/images/sigme1.jpg)

Load Module
![](https://raw.githubusercontent.com/delfinworks/sigmet/master/images/sigme2.jpg)

## Usage :white_check_mark:
- Web Server Apache-2.2.15
- PHP 5.2.13
- MySQL 5.1.46
- phpMyAdmin 3.3.3 

## PHP :eyes:
```bash
public function Clase_RendirEje() 
 {
    if ($this->error!="")return $array=array(false,$this->error,0);
    $SQL = "call rendir ('$this->eje', '".$_SESSION['users_id_sigme']."', '".$_SERVER['REMOTE_ADDR']."')";
    $db=DB_CONECCION();
    $rs = $db->Execute($SQL) or die("Error saving");
    $db->close();
    return $array=array($rs->fields[0],utf8_decode($rs->fields[1]),$rs->fields[2]);
 }
```

## PL/SQL :eyes:
```bash
CREATE DEFINER=`root`@`localhost` PROCEDURE `rendir` (`v_eje` INT, `v_users` VARCHAR(8), `v_ip` VARCHAR(20))  BEGIN
        DECLARE    v_id_generado int(8);
        DECLARE    v_mensaje varchar(150);
        DECLARE    v_valor bool;


        IF EXISTS(SELECT rindio FROM safor_pry_ae_eje_um WHERE id_eje=v_eje AND rindio=0) THEN
                SET v_id_generado= v_eje;
                SET v_mensaje='Excuse me but there are units of measurement in specific actions that are still pending';
                SET v_valor=true;

        ELSE
                IF EXISTS(SELECT rindio FROM safor_pry_ae_ai_eje_um WHERE id_eje=v_eje AND rindio=0) THEN
                        SET v_id_generado= v_eje;
                        SET v_mensaje='Excuse me but there are units of measure in intermediate actions that are still pending';
                        SET v_valor=true;

                ELSE
                        UPDATE safor_eje SET mes_rendicion = (mes_rendicion_global+1)
                                WHERE id_eje=v_eje;

                        SET v_id_generado= v_eje;
                        SET v_mensaje='The executing unit successfully surrendered';
                        SET v_valor=true;

                END IF;
        END IF;

        INSERT INTO users_log (id, ip, accion, valor, id_eje)
                VALUES (v_users, v_ip, v_mensaje, '', v_eje);

        select  v_id_generado as id,v_mensaje as mensaje,v_valor as valor;
END$$
```

## Configuration :gear:

****************************************************************************************
The configuration files of the application are in the "includes" directory.
****************************************************************************************
```bash
/* Database constants "configuracion_db.php" */
define('DB_TYPE','mysql'); //Database manager
define('DB_SERVIDOR', '127.0.0.1'); // IP address of the database server
define('DB_SERVIDOR_PUERTO', '3306'); // Database connection port
define('DB_SERVIDOR_USERNAME', 'user'); // Database connection user
define('DB_SERVIDOR_PASSWORD', 'password); // Database connection password
define('DB_DATABASE', ' sigme'); //Database name
define('DB_CONEXION_P', false);  // Use persistent connections??
define('DEBUG_ADODB', false); // Option for the ADODB Class to show the errors thrown
```
```bash
/* System routing constants "configuracion.php" */
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('PATH',$_SERVER['DOCUMENT_ROOT']. '/sigme''); // 'Place the path where the system is located from the root directory
```

Mount database db/sigme.sql

Ready!

## Compatibility :triangular_ruler:

Modern browsers and IE11.
