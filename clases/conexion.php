<?php
class Conectar //DECLARAMOS LA CLASE Conectar
{	
	public static function con()//DECLARAMOS EL METODO con() DONDE VAMOS A CONECTAR CON NUESTRA BASE DE DATOS
	{
            //DECLARAMOS LA VARIABLE QUE VA A CONTENER NUESTRA CADENA DE CONEXION
            $host = "localhost";
			$port = "5433";
			$dbname = "sistema_consultorio";
			$user = "postgres";
			$password = "123";
	        $cn = pg_connect("host='$host' port='$port' dbname='$dbname' user='$user' password='$password'");
	        return $cn;
            
            //RETORNAMOS LA CONEXION A NUESTRA BASE DE DATOS
            
	}

}

//DECLARAMOS LA CLASE consultas QUE EXTIENDE A LA CLASE Conectar
class consultas extends Conectar
{
    public function preparar($query) {
        // Implementation of the preparar() method
        // This method prepares the database query
    }
        //DECLARAMOS EL METODO get_datos() CON EL UN PARAMETRO QUE CONTENDRA NUESTRA SENTENCIA SQL
	public static function get_datos($sql)
	{
		//EJECUTAMOS LA SENTENCIA SQL QUE LE PASAMOS POR PARAMETROS AL METODO
                $res = pg_query(parent::con(), $sql) or die($sql.'<br>'. utf8_decode(pg_last_error()));
		
                //PREGUNTAMOS SI NUESTRA CONSULTA NOS RETORNA DATOS
                if(isset($res)){//EN CASO DE RETORNAR DATOS
                    while($reg = pg_fetch_assoc($res))//MIENTRAS HAYA FILAS EN EL RESULTADO
                    {
                        $t[]=$reg;//GUARDAMOS NUESTRO RESULTADO EN UN ARREGLO
                    }
                    
                    if(isset($t)){//SI LA VARIABLE t CONTIENE DATOS
                        return $t;//RETORNAMOS LA VARIABLE t
                    }else{//SI LA VARIABLE t NO CONTIENE DATOS
                        return null;//RETORNAMOS NULO
                    }
		}
                
	}    
        //DECLARAMOS EL METODO ejecutar_sql PASANDOLE COMO PARAMETRO LA SENTENCIA.
        public static function ejecutar_sql($sql)//ESTE METODO SOLO RETORNA VERDADERO O FALSO
        {
            if(pg_query(parent::con(), $sql)){//SI NUESTRA SENETENCIA ES EJECUTADA SIN ERRORES
				return true;//EL METODO RETORNA VERDADERO
			}else{//SI HAY ERRORES EN NUESTRA SENTENCIA SQL
				return false;//RETORNA FALSO
			}
        }
    private $conexion;
    // Aquí podrías agregar otros métodos para ejecutar consultas, etc.

}
?>
