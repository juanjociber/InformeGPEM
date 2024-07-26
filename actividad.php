<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";
	$Id=$_GET['informe'];
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

	function FnGenerarInformeHtmlAcordeon($arbol, $imagenes, $clsHide, $nivel = 0, $indice ='1') {
		//$html='<div class="accordion-item">';
		$html='';
		$contador=1;		

		foreach ($arbol as $key=>$nodo) {
			$indiceActual = $nivel==0?$contador++:$indice.'.'.($key+1);
			$html.='<div class="accordion-item" id="'.$contador.'">';
			$html.='
				<h2 class="accordion-header" id="accordion-header-'.$contador.'">
          <div class="cabecera">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-accordion-'.$contador.'" aria-expanded="true" aria-controls="collapse-accordion-'.$contador.'">
						'.$indiceActual.' - '.$nodo['actividad'].'
            </button>
            <div class="accordion-botones">
              <i class="bi bi-plus-lg icono agregarActividad" data-id="'.$contador.'" onclick="fnAgregarActividad(this)"></i>
              <i class="bi bi-pencil-square icono editarActividad" data-id="'.$contador.'" onclick="fnEditarActividad(this)"></i>
              <i class="bi bi-paperclip icono agregarImagen" data-id="'.$contador.'" onclick="fnAgregarImagen(this)"></i>
              <i class="bi bi-trash3 icono eliminarActividad" data-id="'.$contador.'" onclick="fnEliminarActividad(this)"></i>
            </div>
          </div>
				</h2>
				<div id="collapse-accordion-'.$contador.'" class="accordion-collapse collapse show" aria-labelledby="accordion-header-'.$contador.'">
					<div class="accordion-body">
						<div class="row">
							<div class="col-6">
                <label class="form-label mb-0">Diagnóstico</label>
                <p class="mb-1" style="font-size=15px">Diagnostico Nro.1</p>
              </div>
							<div class="col-6">
                <label class="form-label mb-0">Trabajos</label>
                <p class="mb-1" style="font-size=15px">Trabajo Nro.1</p>
              </div>
							<div class="col-12">
                <label class="form-label mb-0">Observaciones</label>
                <p class="mb-1" style="font-size=15px">Observación Nro.1</p>
              </div>
						</div>
						<div class="row">';
							if(isset($imagenes[$nodo['id']])){
								foreach($imagenes[$nodo['id']] as $elemento){
									$html.='
                    <div class="col-6 col-lg-3">
                      <p class="text-center">Título 1</p>
                        <img src="/mycloud/gesman/files/'.$elemento['nombre'].'" class="img-fluid" alt="...">
                      <p class="text-center">Descripción 1</p>
                    </div>';
								}
							}
						$html.='</div>';

			if (!empty($nodo['hijos'])) {
				//$html.='<div class="accordion-item" id="accordionId-3">';
				//$html.='<tr><td colspan="2" style="border: blue 1px solid">';
				//$html.='<table width="100%" style="border: #b2b2b2 1px solid">';
				$html.='<div class="accordion" id="accordionExample">';
				$html.=FnGenerarInformeHtmlAcordeon($nodo['hijos'], $imagenes, $nivel+1, $indiceActual, $clsHide);
				//$html.='</table>';
				//$html.='</td></tr>';
				$html.='</div>';
			}
			$html.='</div>';
			$html.='</div>';
			$html.='</div>';
		}
		//$html.='</div>';
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
				//$html.='<table width="100%" style="border: #b2b2b2 1px solid">';
				$html.=FnGenerarInformeHtml($nodo['hijos'], $imagenes, $nivel+1, $indiceActual);
				//$html.='</table>';
				$html.='</td></tr>';
			}
		}
		$html.='</table>';
		return $html;
	}

	try{
		$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt=$conmy->prepare("select id, nombre, estado  from tblinforme where id=:Id;");
		$stmt->execute(array(':Id'=>$Id));
		$row=$stmt->fetch();
		if($row){
			$Id = $row['id'];
			$Nombre = $row['nombre'];
			$Estado = $row['estado'];
		}
		if($Estado==2){$clsHide='';}

		$stmt2 = $conmy->prepare("select id, ownid, tipo, actividad, diagnostico, trabajos, observaciones from tbldetalleinforme where infid=:InfId;");
		$stmt2->bindParam(':InfId', $Id, PDO::PARAM_INT);
		$stmt2->execute();
		$actividades = $stmt2->fetchAll(PDO::FETCH_ASSOC);

		$arbol = construirArbol($actividades);

		$ids = array_map(function($elemento) {
			return $elemento['id'];
		}, $actividades);

		$cadenaIds = implode(',', $ids);
		$imagenes=array();

		$stmt3 = $conmy->prepare("select id, refid, nombre, descripcion from tblarchivos where refid IN(".$cadenaIds.") and tabla=:Tabla and tipo=:Tipo;");				
		$stmt3->execute(array(':Tabla'=>'INF', ':Tipo'=>'IMG'));
		while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
			$imagenes[$row3['refid']][]=array(
				'id'=>(int)$row3['id'],
				'nombre'=>$row3['nombre'],
				'descripcion'=>$row3['descripcion']
			);
		}
		//echo '<pre>';
		//print_r($imagenes);
		//echo '</pre>';
		$tablaHTML.='<div class="accordion" id="accordionExample">';
			$tabla=FnGenerarInformeHtmlAcordeon($arbol, $imagenes, $clsHide);
			$tablaHTML .=$tabla;
		$tablaHTML.='</div>';
		//echo $tablaHTML ;
	}catch(PDOException $ex){
		$conmy=null;
		echo $ex;
	};
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="css/main.css"> -->
	<title>Document</title>
  <style>
      img{
        width: 100%;
      }
      ::placeholder{
        color: #cecccc !important;
        font-weight: 300;
        font-size:15px;
      }
      .form-label{
        color:#212529;
        font-weight:300; 
      }
      .accordion-body{
        padding-right: 0px;
        padding-left: 10px;
      }
      .accordion-header{
        position: relative;
      }

      .accordion-button::after{
        width: 0;
      }
      .accordion-botones{
        position:absolute;
        top:5px;
        right: 0;
        z-index: 1000;
        display:flex;
      }
      .accordion-botones i{
        font-size:20px;
        margin-right: 1rem;
        cursor: pointer;

      }
      /* 
      .custom-file-button {
        display: inline-flex;
        align-items: center;
        padding: 0.5em 1em;
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        text-align: center;
        cursor: pointer;
      }
      .custom-file-button i {
          margin-right: 0.5em;
      }
      .preview {
        width: 300px;
        height: auto;
        border: 2px solid #000;
        border-radius: 10px;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
        display: none;
        margin-top: 1em;
      }
      .ocultarDiv{
        display: none
      }
      .accordion-body--mod{
        padding-right: 10px;
        padding-left: 10px;
      }
      .accordion-button::after{
        width: 0;
      }
      .accordion-button--mod{
        padding: 0.5rem;
        position: relative;
      }
      .accordion-botones{
        position:absolute;
        top:5px;
        right: 0;
        z-index: 1000;
        display:flex;
      }
      .accordion-botones i{
        font-size:20px;
        margin-right: 1rem;
        cursor: pointer;

      }
    
      @media(max-width:767px){
        .form-label{
          font-size: 13px;
        }
        .listadoAcvidades{
          font-size: 13px;
        }
        .accordion-actividad{
          font-size: 13px;
        }
      }
      @media(min-width:768px){
        .mt--mod{
          margin-top: 17px !important;
        }
        .accordion-actividad{
          margin-top: 0 !important;
        }
        .accordion-botones{
          margin-top: 3px;
        }
      }
      @media(min-width:92px){
        .form-label{
          font-size: 15px;
        }
        .listadoAcvidades{
          font-size: 15px;
        }
        .accordion-actividad{
          font-size: 15px;
        }
      }
      .form-control{
        border-radius:.25rem;
      }
      .btn-control{
        padding:.375rem .75rem;
      }
      .fixed-size-textarea {
        resize: none; 
      }
      .accordion-actividad{
        color: #212529;
        font-weight: 300;
        margin-top: 1.5rem;
        text-align: justify;
      }
      .accordion-header--mod{
        border: none !important;
      }
      .item-actividad{
        position:relative;
      }
      .imagenes-actividad{
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 5px;
      }
      @media(min-width:992px){
        .imagenes-actividad{
          grid-template-columns: 1fr 1fr 1fr 1fr;
        }
      }
      .imagenes-actividad input{
        text-align: center;
      } */

    </style>
</head>
<body>

	<div class="container">

    <div class="row border-bottom mb-3 fs-5">
      <div class="col-12 fw-bold d-flex justify-content-between">
        <p class="m-0 p-0">CLIENTE</p>
          <input type="text" class="d-none" id="txtIdOt" value="" readonly/>
        <p class="m-0 p-0 text-center text-secondary">GP-INF-1</p>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item fw-bold"><a href="/informes/datoGeneral.php" class="text-decoration-none">INFORME</a></li>
            <li class="breadcrumb-item fw-bold"><a href="/informes/datoEquipo.php" class="text-decoration-none">EQUIPO</a></li>
            <li class="breadcrumb-item fw-bold"><a href="/informes/resumen.php" class="text-decoration-none">RESUMEN</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">ACTIVIDAD</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row mb-1 border-bottom">
      <div class="col-4 col-md-2 mb-2">
          <button type="button" class="btn btn-outline-primary form-control text-uppercase" data-bs-toggle="modal" data-bs-target="#actividadModal" data-bs-whatever="@mdo" id="agregarActividad"><i class="bi bi-plus-lg"></i> Agregar</button>
      </div>
    </div>    

		<div class="row">
			<div class="col-12">
        <?php
          echo $tablaHTML;
        ?>
      </div>
		</div>
	</div>

</body>
  <!-- <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script> -->
  <script src="js/actividad.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</html>