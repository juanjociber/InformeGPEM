<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";
  require_once 'Datos/InformesData.php';

  $Id =  $_GET['informe'];
  $NUMERO=1;
  $Nombre='';
	$Estado=0;

	$clsHide=' d-none';
	$tablaHTML ='';

	function construirArbol($registros, $padreId = 0) {
		$arbol = array();
		foreach ($registros as $registro) {
			if ($registro['ownid'] == $padreId) {
				$hijos = construirArbol($registros, $registro['id']);
				if (!empty($hijos)) {
					$registro['hijos'] = $hijos;
				}					
				$arbol[] = $registro;
			}
		}			
		return $arbol;
	}


	function FnGenerarInformeHtmlAcordeon($arbol, $imagenes,$numero, $clsHide, $nivel = 0, $indice ='1') {
		$html='';
		$contador=1;		

		foreach ($arbol as $key=>$nodo) {
      //ASIGNANDO VALOR A NODOGLOBAL
			$indiceActual = $nivel==0?$contador++:$indice.'.'.($key+1);
			//$html.='<div id="'.$nodo['id'].'">';
			$html.='
          <div class="cabecera col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">
						'.$numero.'.'.$indiceActual.' - '.$nodo['actividad'].'
            </p>
          </div>

				<div>
					<div>
						<div class="row">
							<div class="col-6">
                <label class="form-label mb-0">Diagnóstico</label>
                <p class="mb-1 textura-contenido" style="font-size=15px" id="diagnostico-'.$nodo['id'].'">'.$nodo['diagnostico'].'</p>
              </div>
							<div class="col-6">
                <label class="form-label mb-0">Trabajos</label>
                <p class="mb-1 textura-contenido" style="font-size=15px" id="trabajo-'.$nodo['id'].'">'.$nodo['trabajos'].'</p>
              </div>
							<div class="col-12">
                <label class="form-label mb-0">Observaciones</label>
                <p class="mb-1 textura-contenido" style="font-size=15px" id="observacion-'.$nodo['id'].'">'.$nodo['observaciones'].'</p>
              </div>
						</div>
						<div class="row contenedor-row" id="'.$nodo['id'].'">';
							if(isset($imagenes[$nodo['id']])){
								foreach($imagenes[$nodo['id']] as $elemento){
									$html.='
                    <div class="col-6 border mr-2" id="archivo-'.$elemento['id'].'">
                      <p class="text-center mt-4 mb-1 textura-contenido">'.$elemento['titulo'].'</p>
                        <img src="/mycloud/gesman/files/'.$elemento['nombre'].'" class="img-fluid" alt="">
                      <p class="text-center textura-contenido">'.$elemento['descripcion'].'</p>
                    </div>';
								}
							}
						$html.='</div>';
			if (!empty($nodo['hijos'])) {
				$html.='<div  id="accordion-container-'.$nodo['id'].'">';
				$html.=FnGenerarInformeHtmlAcordeon($nodo['hijos'], $imagenes,$numero, $nivel+1, $indiceActual, $clsHide);
				$html.='</div>';
			}
			$html.='</div>';
			$html.='</div>';
			$html.='</div>';
		}
		return $html;
	}

	function FnGenerarInformeHtml($arbol, $imagenes, $nivel = 0, $indice ='1') {
		$html='<table width="100%" style="border: #b2b2b2 1px solid">';
		$contador=1;		

		foreach ($arbol as $key=>$nodo) {
			$indiceActual = $nivel==0?$contador++:$indice.'.'.($key+1);
			$html.='<tr><td colspan="2" style="border: red 1px solid">'.$indiceActual.' - '.$nodo['actividad'].'</td></tr>';
			
			$imagen=array();
			if(isset($imagenes[$nodo['id']])){
				$html.='<tr><td><table width="100%" style="border: #b2b2b2 1px solid; color:red">';
				$i=1;
				foreach($imagenes[$nodo['id']] as $elemento){
					if($i==2){
						$html.='<td style="border: black 1px solid">'.$elemento['nombre'].'</td></tr>';
						$i=1;
					}else{
						$html.='<tr><td style="border: black 1px solid">'.$elemento['nombre'].'</td>';
						$i+=1;
					}
				}
				if($i==2){$html.='</tr>';}
				$html.='</table></td></tr>';
			}			
			if (!empty($nodo['hijos'])) {
				$html.='<tr><td colspan="2" style="border: blue 1px solid">';
				$html.=FnGenerarInformeHtml($nodo['hijos'], $imagenes, $nivel+1, $indiceActual);
				$html.='</td></tr>';
			}
		}
		$html.='</table>';
		return $html;
	}

  try {
    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_GET['informe'])) {
        $informe  = FnBuscarInformeMatriz($conmy, $Id);
        $archivos = FnBuscarInformesYArchivosPorId($conmy, $Id);
        $actividadesdetalles = FnBuscarActividadPorInfid($conmy, $Id);
    }
    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt=$conmy->prepare("select id, nombre, cli_nombre, estado  from tblinforme where id=:Id;");
		$stmt->execute(array(':Id'=>$Id));
		$row=$stmt->fetch();
		if($row){
			$Id = $row['id'];
			$Nombre = $row['nombre'];
			$Estado = $row['estado'];
      $ClienteNombre = $row['cli_nombre'];
		}
		if($Estado==2){$clsHide='';}

		$stmt2 = $conmy->prepare("select id, ownid, tipo, actividad, diagnostico, trabajos, observaciones from tbldetalleinforme where infid=:InfId;");
		$stmt2->bindParam(':InfId', $Id, PDO::PARAM_INT);
		$stmt2->execute();
		$datos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $actividades=array();
		$conclusiones=array();
		$recomendaciones=array();
		$antecedentes=array();

		foreach($datos as $dato){
			if($dato['tipo']=='act'){
				$actividades[]=array(
					'id'=>$dato['id'],
					'ownid'=>$dato['ownid'],
					'tipo'=>$dato['tipo'],
					'actividad'=>$dato['actividad'],
					'diagnostico'=>$dato['diagnostico'],
					'trabajos'=>$dato['trabajos'],
					'observaciones'=>$dato['observaciones'],
				);
			}else if($dato['tipo']=='con'){
				$conclusiones[]=array('actividad'=>$dato['actividad']);
			}else if($dato['tipo']=='rec'){
				$recomendaciones[]=array('actividad'=>$dato['actividad']);
			}else if($dato['tipo']=='ant'){
				$antecedentes[]=array('actividad'=>$dato['actividad']);
			}	
		}
		$arbol = construirArbol($actividades);
    // echo '<pre>';
    // print_r($arbol);
    // echo '</pre>';
		$ids = array_map(function($elemento) {
			return $elemento['id'];
		}, $actividades);

		$cadenaIds = implode(',', $ids);
		$imagenes=array();

		$stmt3 = $conmy->prepare("select id, refid, nombre, descripcion, titulo from tblarchivos where refid IN(".$cadenaIds.") and tabla=:Tabla and tipo=:Tipo;");				
		$stmt3->execute(array(':Tabla'=>'INFD', ':Tipo'=>'IMG'));
		while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
			$imagenes[$row3['refid']][]=array(
				'id'=>(int)$row3['id'],
				'nombre'=>$row3['nombre'],
				'descripcion'=>$row3['descripcion'],
        'titulo'=>$row3['titulo'],
			);
		}
		// $tablaHTML.='<div class="accordion" id="accordion-container-'.$nodo['id'].'">';
		// 	$tabla=FnGenerarInformeHtmlAcordeon($arbol, $imagenes, $clsHide);
		// 	$tablaHTML .=$tabla;
		// $tablaHTML.='</div>';
  } catch (PDOException $e) {
      throw new Exception($e->getMessage());
  } catch (Exception $e) {
      throw new Exception($e->getMessage());
  } finally {
      $conmy = null;
  }
?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/main.css">
    <title>Sistema GPEM S.A.C</title>
  </head>
  <style>
    ::placeholder{
      color: #cecccc !important;
      font-weight: 200;
      text-transform: uppercase;
    }
    img{
      width: 100%;
    }
    .form-label{
      color:#212529;
      font-weight:300; 
    }
    @media(max-width:767px){
      .form-label{
        font-size: 15px;
      }
    }
    @media(min-width:768px){
      .mt--mod{
        margin-top: 17px !important;
      }
    }
    @media(min-width:92px){
      .form-label{
        font-size: 15px;
      }
    }
    .form-control{
      border-radius:.25rem;
    }
    .btn-control{
      padding:.375rem .75rem;
    }
    @media(max-width:576px){
      .text-button{
        display:none;
      }
    }
    .color-contenido{
      color: #212529;
    }
    .color-titulo{
      color: #747272;
    }
    .textura-contenido{
      font-weight: 500;
      font-size: 16px;
      color: #676767;
    }
    .textura-contenido-mod{
      width: 15%;
      text-align: center;
      color: #FFFFFF;
      border-radius: 4px;
      padding: 4px 8px !important
    }
    .vineta::before {
      content: '\2713'; 
      font-size: 13px;
      color: green; 
      margin-right: 8px;
    }
    .contenedor-imagen{
      position: relative;
      border: 1px solid #67646442;
      border-radius: 4px;
      padding: 5px; 
    }
    .caja-imagen{

      margin-bottom: 5px;
    }
    @media(min-width:992px){
      .caja-imagen{
        grid-template-columns: 1fr 1fr 1fr 1fr;
      }
    }
    .contenedor-datos{
      border: 1px solid #aea7a782;
      border-radius: 4px;
      padding-top: 10px !important;
      margin-left: 0.5px;
      margin-right: 0.5px;
    }
    .contenedor-imagen-equipo{
      border: 1px solid #aea7a782;
      border-radius:4px;
    }
    .archivos{
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-bottom: 10px;
      margin-top:10px;
    }
    @media(min-width:992px){
      .contenedor-row{
        padding: 0px 250px;
      }
    }

    </style>
  <body>
      <!-- INICIO CONTAINER -->
      <div class="container">

        <div class="row mb-3 mt-3">
          <div class="col-12 btn-group" role="group" aria-label="Basic example">
            <a href="/informes/buscarInforme.php" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0"><i class="bi bi-list-task"></i><span class="text-button"> Informes</span></button>
            </a>
            <a href="/informes/datoGeneral.php?informe=<?php echo htmlspecialchars($Id);?>" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0; border-left:0"><i class="bi bi-pencil-square"></i><span class="text-button"> Editar</span></button>
            </a>
            <a href="#" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0; border-left:0"><i class="bi bi-check-square"></i><span class="text-button"> Finalizar</span></button>
            </a>
          </div>
        </div>

        <!-- BOTON DESCARGAR INFORME -->
        <div class="row">
          <div id="generarInforme" class="col-6 col-lg-2 mt-4 mb-4">
            <button id="guardarActividad" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" onclick=fnGenerarInforme()><i class="bi bi-cloud-download"></i> Descargar </button>
          </div>
        </div>

        <!-- NOMBRE DE CLIENTE E INFORME -->
        <div class="row border-bottom mb-2 fs-5">
          <div class="col-12 fw-bold d-flex justify-content-between">
            <p class="m-0 p-0 text-secondary"><?php echo htmlspecialchars($informe->clinombre); ?></p>
            <input type="text" class="d-none" id="txtId" value="">
            <p class="m-0 p-0 text-center text-secondary"><?php echo htmlspecialchars($informe->nombre); ?></p>
          </div>
        </div>

        <!-- DATOS GENERALES -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $NUMERO; ?>- DATOS GENERALES</p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Nro. Informe</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->numero); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Nombre Informe</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->nombre); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Fecha</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->fecha); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">OT N°</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->ordnombre); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Nombre de cliente:</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->clinombre); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Contacto</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->clicontacto); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Lugar</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->ubicacion); ?></p>
          </div>
          <div class="col-6 col-sm-8 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Supervisor</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->supervisor); ?></p>
          </div>
        </div>
        <?php $NUMERO+=1; ?>
        
        <!-- DATOS DEL EQUIPO -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $NUMERO; ?>- DATOS DEL EQUIPO</p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Nombre Equipo</p>
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equnombre); ?></p>              
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Modelo Equipo</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equmodelo); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Serie Equipo</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equserie); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Marca Equipo</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equmarca); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Kilometraje</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equkm); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Horas Motor</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equhm); ?></p>
          </div>
          <div class="col-12 col-lg-6 mb-1">
            <p class="m-0 text-secondary fw-light" style="font-size: 15px;">Carateristicas</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equdatos); ?></p>
          </div>
          <div class="row contenedor-row">
            <?php foreach($archivos as $archivo): ?>
              <div class="col-6 border">
                <p class="text-center mt-4 mb-1"><?php echo htmlspecialchars($archivo['titulo']); ?></p>
                <img src="/mycloud/gesman/files/<?php echo htmlspecialchars($archivo['nombre']); ?>" class="img-fluid" alt="">
                <p class="text-center"><?php echo htmlspecialchars($archivo['descripcion']); ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php $NUMERO+=1; ?>
        <!-- SOLICITUD DEL CLIENTE-->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $NUMERO; ?>- SOLICITUD DEL CLIENTE</p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <div class="col-12 mb-2 mt-2">
            <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($informe->actividad); ?></p>          
          </div>
        </div>
        <?php $NUMERO+=1; ?>

        <!-- ANTECEDENTES-->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $NUMERO; ?>- ANTECEDENTES</p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <?php foreach($antecedentes as $antecedente) :?>
              <div class="d-flex">
                <span class="vineta"></span> 
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo $antecedente['actividad'];?></p>
              </div>
          <?php endforeach ;?>
        </div>
        <?php $NUMERO+=1; ?>
  
        <!-- ACTIVIDADES -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $NUMERO; ?>- ACTIVIDADES</p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <?php
            $html = FnGenerarInformeHtmlAcordeon($arbol, $imagenes,$NUMERO, $clsHide);
            echo $html;
          ?>
        </div>

        <!-- CONCLUSIONES -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">6. CONCLUSIONES</p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <?php foreach($conclusiones as $conclusion) :?>
              <div class="d-flex">
                <span class="vineta"></span> 
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo $conclusion['actividad'];?></p>
              </div>
          <?php endforeach ;?>
        </div>

        <!-- RECOMENDACIONES -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">7. RECOMENDACIONES</p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <?php foreach($recomendaciones as $recomendacion) :?>
              <div class="d-flex">
                <span class="vineta"></span> 
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo $recomendacion['actividad'];?></p>
              </div>
          <?php endforeach ;?>
        </div>

        <!-- ANEXOS -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">8. ANEXOS</p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          
        </div>
        
        <!-- ESTADO -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">ESTADO</p>
          </div>
        </div>
        <div class="row p-1 mb-2">
          <?php
            $Estado = 1; 
            $EstadoClass = ($Estado == 1) ? 'bg-primary' : ($Estado == 2 ? 'bg-success' : 'bg-danger');
            $EstadoText = ($Estado == 1) ? 'Abierto' : ($Estado == 2 ? 'Cerrado' : 'Anulado');
          ?>
          <div class="col-12 col-lg-6 mb-2 mt-2">
            <p class="m-0 p-0 textura-contenido textura-contenido-mod <?php echo $EstadoClass; ?>"><?php echo htmlspecialchars($EstadoText); ?></p>
          </div>            
        </div>

      </div><!-- CIERRE CONTAINER -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="js/vistaPreliminar.js"></script>
  </body>
</html>