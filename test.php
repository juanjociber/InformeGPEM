<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";
	$Id = $_GET['informe'] ?? 0;
	$Nombre = '';
	$Estado = 0;
	$ClienteNombre = '';
	$clsHide = ' d-none';
	$tablaHTML = '';

	$titulo = 'Crear actividad';

	function construirArbol($registros, $padreId = 0) {
		$arbol = [];
		foreach ($registros as $registro) {
			if ($registro['ownid'] == $padreId) {
				$registro['hijos'] = construirArbol($registros, $registro['id']);
				$arbol[] = $registro;
			}
		}
		return $arbol;
	}

	function FnGenerarInformeHtmlAcordeon($arbol, $imagenes, $clsHide, $nivel = 0, $indice = '1') {
		$html = '';
		$contador = 1;

		foreach ($arbol as $key => $nodo) {
			$indiceActual = $nivel == 0 ? $contador++ : $indice.'.'.($key+1);
			$html .= '<div class="accordion-item" id="'.$nodo['id'].'">';
			$html .= '
				<h2 class="accordion-header" id="accordion-header-'.$nodo['id'].'">
					<div class="cabecera">
						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-accordion-'.$nodo['id'].'" aria-expanded="true" aria-controls="collapse-accordion-'.$nodo['id'].'">
							'.$indiceActual.' - '.$nodo['actividad'].'
						</button>
						<div class="accordion-botones">
							<i class="bi bi-plus-lg icono agregarActividad" data-bs-toggle="modal" data-bs-target="#agregarActividadModal" data-id="'.$nodo['id'].'" onclick="fnAgregarActividad(this)"></i>
							<i class="bi bi-pencil-square icono editarActividad" data-bs-toggle="modal" data-bs-target="#editarActividadModal" data-id="'.$nodo['id'].'" onclick="fnEditarActividad(this)"></i>
							<i class="bi bi-paperclip icono agregarImagen" data-bs-toggle="modal" data-bs-target="#agregarImagenModal" data-id="'.$nodo['id'].'" onclick="fnAgregarImagen(this)"></i>
							<i class="bi bi-trash3 icono eliminarActividad" data-id="'.$nodo['id'].'" onclick="fnEliminarActividad(this)"></i>
						</div>
					</div>
				</h2>
				<div id="collapse-accordion-'.$nodo['id'].'" class="accordion-collapse collapse show" aria-labelledby="accordion-header-'.$nodo['id'].'">
					<div class="accordion-body">
						<div class="row">
							<div class="col-6">
								<label class="form-label mb-0">Diagnóstico</label>
								<p class="mb-1" id="diagnostico-'.$nodo['id'].'">'.$nodo['diagnostico'].'</p>
							</div>
							<div class="col-6">
								<label class="form-label mb-0">Trabajos</label>
								<p class="mb-1" id="trabajo-'.$nodo['id'].'">'.$nodo['trabajos'].'</p>
							</div>
							<div class="col-12">
								<label class="form-label mb-0">Observaciones</label>
								<p class="mb-1" id="observacion-'.$nodo['id'].'">'.$nodo['observaciones'].'</p>
							</div>
						</div>
						<div class="row">';

			if (isset($imagenes[$nodo['id']])) {
				foreach ($imagenes[$nodo['id']] as $elemento) {
					$html .= '
						<div class="col-6 col-lg-3 contenedor-imagen">
							<p class="text-center">'.$elemento['descripcion'].'</p>
							<i class="bi bi-x-circle icono-remover" style="position: absolute; font-size: 25px;color: tomato;top: 40px;left: 15px;" onclick="fnEliminarImagen(this)"></i>
							<img src="/mycloud/gesman/files/'.$elemento['nombre'].'" class="img-fluid" alt="">
						</div>';
				}
			}

			$html .= '</div>';

			if (!empty($nodo['hijos'])) {
				$html .= '<div class="accordion" id="accordion-container-'.$nodo['id'].'">';
				$html .= FnGenerarInformeHtmlAcordeon($nodo['hijos'], $imagenes, $nivel + 1, $indiceActual);
				$html .= '</div>';
			}
			$html .= '</div></div></div>';
		}

		return $html;
	}

	try {
		$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conmy->prepare("SELECT id, nombre, cli_nombre, estado FROM tblinforme WHERE id = :Id;");
		$stmt->execute([':Id' => $Id]);
		$row = $stmt->fetch();
		if ($row) {
			$Id = $row['id'];
			$Nombre = $row['nombre'];
			$Estado = $row['estado'];
			$ClienteNombre = $row['cli_nombre'];
		}
		if ($Estado == 2) {
			$clsHide = '';
		}

		$stmt2 = $conmy->prepare("SELECT id, ownid, tipo, actividad, diagnostico, trabajos, observaciones FROM tbldetalleinforme WHERE infid = :InfId;");
		$stmt2->execute([':InfId' => $Id]);
		$actividades = $stmt2->fetchAll(PDO::FETCH_ASSOC);

		$arbol = construirArbol($actividades);

		$ids = array_map(function($elemento) {
			return $elemento['id'];
		}, $actividades);

		$cadenaIds = implode(',', $ids);
		$imagenes = [];

		$stmt3 = $conmy->prepare("SELECT id, refid, nombre, descripcion FROM tblarchivos WHERE refid IN (".$cadenaIds.") AND tabla = :Tabla AND tipo = :Tipo;");
		$stmt3->execute([':Tabla' => 'INF', ':Tipo' => 'IMG']);
		while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
			$imagenes[$row3['refid']][] = [
				'id' => (int)$row3['id'],
				'nombre' => $row3['nombre'],
				'descripcion' => $row3['descripcion']
			];
		}

		$tablaHTML = '<div class="accordion" id="accordion-container">';
		$tablaHTML .= FnGenerarInformeHtmlAcordeon($arbol, $imagenes, $clsHide);
		$tablaHTML .= '</div>';
	} catch (PDOException $ex) {
		$conmy = null;
		echo $ex->getMessage();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/main.css">
	<title>Document</title>
	<style>
		img {
			width: 100%;
		}
		::placeholder {
			color: #cecccc !important;
			font-weight: 300;
			font-size: 15px;
		}
		.form-label {
			color: #212529;
			font-weight: 300;
		}
		.accordion-body {
			padding-right: 0;
			padding-left: 10px;
		}
		.accordion-header {
			position: relative;
		}
		.accordion-button::after {
			width: 0;
		}
		.accordion-botones {
			position: absolute;
			top: 5px;
			right: 0;
			z-index: 1000;
			display: flex;
		}
		.accordion-botones i {
			font-size: 20px;
			margin-right: 1rem;
			cursor: pointer;
		}
		.contenedor-imagen {
			position: relative;
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="card">
			<div class="card-header">
				<h5>INFORME DE SERVICIOS TÉCNICOS</h5>
			</div>
			<div class="card-body">
				<form id="formulario">
					<div class="row">
						<div class="col-12 col-lg-8 mb-3">
							<div class="row">
								<div class="col-12 col-lg-3">
									<label for="informeId" class="form-label">Informe N°</label>
									<input type="text" id="informeId" class="form-control form-control-sm" value="<?= $Id ?>" readonly>
								</div>
								<div class="col-12 col-lg-9">
									<label for="informeNombre" class="form-label">Informe</label>
									<input type="text" id="informeNombre" class="form-control form-control-sm" value="<?= $Nombre ?>" readonly>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4 mb-3">
							<label for="clienteNombre" class="form-label">Cliente</label>
							<input type="text" id="clienteNombre" class="form-control form-control-sm" value="<?= $ClienteNombre ?>" readonly>
						</div>
						<div class="col-12 col-lg-6 mb-3">
							<label for="nombreProyecto" class="form-label">Nombre del proyecto</label>
							<input type="text" id="nombreProyecto" class="form-control form-control-sm">
						</div>
						<div class="col-12 col-lg-6 mb-3">
							<label for="otNro" class="form-label">N° de OT</label>
							<input type="text" id="otNro" class="form-control form-control-sm">
						</div>
						<div class="col-12 col-lg-3 mb-3">
							<label for="fechaVisita" class="form-label">Fecha de visita</label>
							<input type="date" id="fechaVisita" class="form-control form-control-sm">
						</div>
						<div class="col-12 col-lg-3 mb-3">
							<label for="horaIngreso" class="form-label">Hora de ingreso</label>
							<input type="time" id="horaIngreso" class="form-control form-control-sm">
						</div>
						<div class="col-12 col-lg-3 mb-3">
							<label for="horaSalida" class="form-label">Hora de salida</label>
							<input type="time" id="horaSalida" class="form-control form-control-sm">
						</div>
						<div class="col-12 col-lg-3 mb-3">
							<label for="estadoInforme" class="form-label">Estado del informe</label>
							<select id="estadoInforme" class="form-select form-select-sm">
								<option value="0" <?= ($Estado == 0) ? 'selected' : ''; ?>>Pendiente</option>
								<option value="1" <?= ($Estado == 1) ? 'selected' : ''; ?>>En proceso</option>
								<option value="2" <?= ($Estado == 2) ? 'selected' : ''; ?>>Finalizado</option>
							</select>
						</div>
					</div>
					<?= $tablaHTML ?>
				</form>
			</div>
			<div class="card-footer d-flex justify-content-end">
				<button type="button" class="btn btn-primary btn-sm">Guardar informe</button>
			</div>
		</div>
	</div>

	<!-- Modal Agregar Actividad -->
	<div class="modal fade" id="agregarActividadModal" tabindex="-1" aria-labelledby="agregarActividadLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="agregarActividadLabel">Agregar Actividad</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="formAgregarActividad">
						<div class="mb-3">
							<label for="actividadNombre" class="form-label">Nombre de la actividad</label>
							<input type="text" class="form-control" id="actividadNombre">
						</div>
						<div class="mb-3">
							<label for="actividadDiagnostico" class="form-label">Diagnóstico</label>
							<textarea class="form-control" id="actividadDiagnostico"></textarea>
						</div>
						<div class="mb-3">
							<label for="actividadTrabajo" class="form-label">Trabajo</label>
							<textarea class="form-control" id="actividadTrabajo"></textarea>
						</div>
						<div class="mb-3">
							<label for="actividadObservaciones" class="form-label">Observaciones</label>
							<textarea class="form-control" id="actividadObservaciones"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary" onclick="guardarActividad()">Guardar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Editar Actividad -->
	<div class="modal fade" id="editarActividadModal" tabindex="-1" aria-labelledby="editarActividadLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editarActividadLabel">Editar Actividad</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="formEditarActividad">
						<div class="mb-3">
							<label for="editarActividadNombre" class="form-label">Nombre de la actividad</label>
							<input type="text" class="form-control" id="editarActividadNombre">
						</div>
						<div class="mb-3">
							<label for="editarActividadDiagnostico" class="form-label">Diagnóstico</label>
							<textarea class="form-control" id="editarActividadDiagnostico"></textarea>
						</div>
						<div class="mb-3">
							<label for="editarActividadTrabajo" class="form-label">Trabajo</label>
							<textarea class="form-control" id="editarActividadTrabajo"></textarea>
						</div>
						<div class="mb-3">
							<label for="editarActividadObservaciones" class="form-label">Observaciones</label>
							<textarea class="form-control" id="editarActividadObservaciones"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary" onclick="actualizarActividad()">Guardar cambios</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Agregar Imagen -->
	<div class="modal fade" id="agregarImagenModal" tabindex="-1" aria-labelledby="agregarImagenLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="agregarImagenLabel">Agregar Imagen</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="formAgregarImagen" enctype="multipart/form-data">
						<div class="mb-3">
							<label for="imagenDescripcion" class="form-label">Descripción</label>
							<input type="text" class="form-control" id="imagenDescripcion">
						</div>
						<div class="mb-3">
							<label for="imagenArchivo" class="form-label">Archivo de imagen</label>
							<input type="file" class="form-control" id="imagenArchivo">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary" onclick="guardarImagen()">Guardar</button>
				</div>
			</div>
		</div>
	</div>


</body>
<script src="js/actividad.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> 
</html>
