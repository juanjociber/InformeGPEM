<?php 
    function FnRegistrarInforme($conmy, $orden, $cliente, $equipo, $fecha, $actividad, $usuario) {
        try {
            $stmt = $conmy->prepare("CALL spman_agregarinforme(:_ordid, :_equid, :_cliid, :_fecha, :_ordnombre, :_clinombre, :_clicontacto, :_ubicacion, :_supervisor, :_equcodigo, :_equnombre, :_equmarca, :_equmodelo, :_equserie, :_equdatos, :_equkm, :_equhm, :_actividad, :_usuario, @_id)");
            $stmt->bindParam(':_ordid', $orden->id, PDO::PARAM_INT);
            $stmt->bindParam(':_equid', $equipo->id, PDO::PARAM_INT);
            $stmt->bindParam(':_cliid', $cliente->id, PDO::PARAM_INT);
            $stmt->bindParam(':_fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':_ordnombre', $orden->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':_clinombre', $cliente->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':_clicontacto', $orden->contacto, PDO::PARAM_STR);
            $stmt->bindParam(':_ubicacion', $equipo->ubicacion, PDO::PARAM_STR);
            $stmt->bindParam(':_supervisor', $orden->supervisor, PDO::PARAM_STR);
            $stmt->bindParam(':_equcodigo', $equipo->codigo, PDO::PARAM_STR);
            $stmt->bindParam(':_equnombre', $equipo->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':_equmarca', $equipo->marca, PDO::PARAM_STR);
            $stmt->bindParam(':_equmodelo', $equipo->modelo, PDO::PARAM_STR);
            $stmt->bindParam(':_equserie', $equipo->serie, PDO::PARAM_STR);
            $stmt->bindParam(':_equdatos', $equipo->caracteristicas, PDO::PARAM_STR);
            $stmt->bindParam(':_equkm', $orden->km, PDO::PARAM_INT);
            $stmt->bindParam(':_equhm', $orden->hm, PDO::PARAM_INT);
            $stmt->bindParam(':_actividad', $actividad, PDO::PARAM_STR);
            $stmt->bindParam(':_usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $conmy->query("SELECT @_id as id");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $row['id'];

            return $id;
            
        } catch (PDOException $e) {
            throw new Exception("Error en la Marcación: ".$e->getMessage());//sera propagado al catch(Exception $ex) del nivel superior.
        }
    }

    function FnModificarInforme($conmy, $informe) {
        try {
            $res=false;
            $stmt = $conmy->prepare("update tblinforme set fecha=:Fecha, cli_contacto=:CliContacto, ubicacion=:Ubicacion, supervisor=:Supervisor, equ_nombre=:EquNombre, equ_marca=:EquMarca, equ_modelo=:EquModelo, equ_serie=:EquSerie, equ_datos=:EquDatos, equ_km=:EquKm, equ_hm=:EquHm, actualizacion=:Actualizacion);");
            $params = array(':Fecha'=>$informe->fecha, ':CliContacto'=>$informe->clicontacto, ':Ubicacion'=>$informe->ubicacion, ':Supervisor'=>$informe->supervisor, ':EquNombre'=>$informe->equnombre, ':EquMarca'=>$informe->equmarca, ':EquModelo'=>$informe->equmodelo, ':EquSerie'=>$informe->equserie, ':EquDatos'=>$informe->equdatos, ':EquKm'=>$informe->equkm, ':EquHm'=>$informe->equhm, ':Actualizacion'=>$informe->actualizacion);
            if($stmt->execute($params)){
                $res=true;
            }
            return $res;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Buscar la última programacion en proceso, estado:1
    function FnBuscarEquipo($conmy, $id) {
        try {
            $stmt = $conmy->prepare("select idactivo, codigo, activo, grupo, marca, modelo, serie, anio, fabricante, procedencia, caracteristicas, ubicacion from man_activos where idactivo=:Id;");
            $stmt->execute(array(':Id'=>$id));
            $equipo = new stdClass();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $equipo->id = $row['idactivo'];
                $equipo->codigo = $row['codigo'];
                $equipo->nombre = $row['activo'];
                $equipo->flota = $row['grupo'];
                $equipo->marca = $row['marca'];
                $equipo->modelo = $row['modelo'];
                $equipo->serie = $row['serie'];
                $equipo->anio = $row['anio'];
                $equipo->fabricante = $row['fabricante'];
                $equipo->procedencia = $row['procedencia'];
                $equipo->datos = $row['caracteristicas'];
                $equipo->ubicacion = $row['ubicacion'];
            }
            return $equipo;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function FnBuscarOrden($conmy, $id) {
        try {
            $stmt = $conmy->prepare("select idot, idactivo, idcliente, ot, km, hm, supervisor, contacto, estado from man_ots where idot=:Id;");
            $stmt->execute(array(':Id'=>$id));
            $orden = new stdClass();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orden->id = $row['idot'];
                $orden->equid = $row['idactivo'];
                $orden->cliid = $row['idcliente'];
                $orden->nombre = $row['ot'];
                $orden->km = $row['km'];
                $orden->hm = $row['hm'];
                $orden->supervisor = $row['supervisor'];
                $orden->contacto = $row['contacto'];
                $orden->estado = $row['estado'];
            }
            return $orden;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function FnBuscarCliente($conmy, $id) {
        try {
            $stmt = $conmy->prepare("select idcliente, ruc, razonsocial, nombre, estado from man_clientes where idcliente=:Id;");
            $stmt->execute(array(':Id'=>$id));
            $cliente = new stdClass();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cliente->id = $row['idcliente'];
                $cliente->ruc = $row['ruc'];
                $cliente->nombre = $row['razonsocial'];
                $cliente->alias = $row['nombre'];
                $cliente->estado = $row['estado'];
            }
            return $cliente;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function FnRegistrarActividad($conmy, $actividad) {
        try {
            $res=false;
            $stmt = $conmy->prepare("insert into tbldetalleinforme(infid, ownid, actividad, diagnostico, trabajos, observaciones, creacion, actualizacion) values(:InfId, :OwnId, :Actividad, :Diagnostico, :Trabajos, :Observaciones, :Creacion, :Actualizacion);");
            $params = array(':InfId'=>$actividad->infid, ':OwnId'=>$actividad->ownid, ':Actividad'=>$actividad->actividad, ':Diagnostico'=>$actividad->diagnostico, ':Trabajos'=>$actividad->trabajos, ':Observaciones'=>$actividad->observaciones, ':Creacion'=>$actividad->usuario, ':Actualizacion'=>$actividad->usuario);
            if($stmt->execute($params)){
                $res=true;
            }
            return $res;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function FnModificarActividad($conmy, $actividad) {
        try {
            $res=false;
            $stmt = $conmy->prepare("update tbldetalleinforme set actividad=:Actividad, diagnostico=:Diagnostico, trabajos=:Trabajos, observaciones=:Observaciones, actualizacion=:Actualizacion where id=:Id;");
            $params = array(':Actividad'=>$actividad->actividad, ':Diagnostico'=>$actividad->diagnostico, ':Trabajos'=>$actividad->trabajos, ':Observaciones'=>$actividad->observaciones, ':Actualizacion'=>$actividad->usuario, ':Id'=>$actividad->id);
            if($stmt->execute($params)){
                $res=true;
            }
            return $res;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function FnEliminarActividad($conmy, $id) {
        try {
            $res=false;
            $stmt = $conmy->prepare("delete from tbldetalleinforme where id=:Id);");
            $params = array(':Id'=>$id);
            if($stmt->execute($params)){
                $res=true;
            }
            return $res;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function FnRegistrarImagen($conmy, $imagen) {
        try {
            $res=false;
            $stmt = $conmy->prepare("insert into tblarchivos(refid, tabla, nombre, titulo, descripcion, tipo, actualizacion) values(:RefId, :Tabla, :Nombre, :Titulo, :Descripcion, :Tipo, :Actualizacion);");
            $params = array(':RefId'=>$imagen->refid, ':Tabla'=>$imagen->tabla, ':Nombre'=>$imagen->nombre, ':Titulo'=>$imagen->titulo, ':Descripcion'=>$imagen->descripcion, ':Tipo'=>$imagen->tipo, ':Actualizacion'=>$imagen->usuario);
            if($stmt->execute($params)){
                $res=true;
            }
            return $res;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function FnEliminarArchivo($conmy, $id) {
        try {
            $res=false;
            $stmt = $conmy->prepare("delete from tblarchivos where id=:Id);");
            $params = array(':Id'=>$id);
            if($stmt->execute($params)){
                $res=true;
            }
            return $res;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function FnBuscarInformes($conmy, $informe) {
        try {
            $informes=array('data'=>array(), 'pag'=>0);
            $query = "";
            /*if(!empty($_POST['pagina'])){
                $pagina = (int)$_POST['pagina'];
            }*/
            
            if(!empty($informe->nombre)){
                $query = " and nombre like='%".$informe->nombre."%'";
            }else{
                if(!empty($informe->equid)){$query .=" and equid=".$informe->equid;}
                $query.=" and fecha between '".$informe->fechainicial."' and '".$informe->fechafinal."'";
            }

            $stmt = $conmy->prepare("select id, nombre, fecha, cli_nombre, actividad, estado from tblinforme where cliid=:CliId".$query." limit :Pagina, 20;");
            $stmt->bindParam(':CliId', $informe->cliid, PDO::PARAM_INT);
			$stmt->bindParam(':Pagina', $informe->pagina, PDO::PARAM_INT);
            $stmt->execute();
			$n=$stmt->rowCount();
            if($n>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $informes['data'][]=array(
                        'id'=>(int)$row['id'],
                        'nombre'=>$row['nombre'],
                        'fecha'=>$row['fecha'],
                        'clinombre'=>$row['cli_nombre'],
                        'actividad'=>$row['actividad'],
                        'estado'=>(int)$row['estado']
                    );
                }
                $informes['pag']=$n;
            }            
            return $informes;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }



?>