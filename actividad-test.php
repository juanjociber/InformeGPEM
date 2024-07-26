<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/main.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/main.css">
    <title>Actividad</title>
    <style>
      img{
        width: 100%;
      }
      ::placeholder{
        color: #cecccc !important;
        font-weight: 300;
        font-size:15px;
      }
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
      .form-label{
        color:#212529;
        font-weight:300; 
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
      }
      .grid-imagen{
        padding-top:15px;
        padding-bottom:5px;
      }  
    </style>
  </head>
  <body>
    <!-- START CONTAINER -->
    <div class="container">
      <!-- START CABECERA -->
      <div class="row border-bottom mb-3 fs-5">
          <div class="col-12 fw-bold d-flex justify-content-between">
            <p class="m-0 p-0">CLIENTE</p>
              <input type="text" class="d-none" id="txtIdOt" value="" readonly/>
            <p class="m-0 p-0 text-center text-secondary">GP-INF-1</p>
          </div>
      </div>
      <!-- END CABECERA -->

      <!-- START ENLACES -->
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
      <!-- END ENLACES -->

      <div class="row mb-1 border-bottom">
          <div class="col-6 mb-2">
              <button type="button" class="btn btn-outline-primary form-control text-uppercase" data-bs-toggle="modal" data-bs-target="#actividadModal" data-bs-whatever="@mdo" id="agregarActividad"><i class="bi bi-plus-lg"></i> Agregar</button>
          </div>
      </div>

      <!-- START LISTA DE ACTIVIDADES-->
      <div class="row g-3">
        <div class="col-12 fw-bold d-flex justify-content-between">
          <p class="m-0 p-0 text-center text-secondary text-uppercase listadoActividades">Listado de actividades</p>
        </div>

        <!-- START ACCORDION   -->
        <div class="accordion" id="contenedor-accordion">
          
          <!-- CONTENEDOR DE CADA ITEM-ACCORDION -->
          <div class="accordion-item" id="accordionId-1">
            <h2 class="accordion-header accordion-header--mod" id="accordionHeaderId-1">
              <div class="item-actividad">
                <div class="accordion-button accordion-button--mod" data-bs-toggle="collapse" data-bs-target="#collapseAcordion-1" aria-expanded="false" aria-controls="collapseAcordion-1" id="gpem1">
                  <div class="accordion-actividad col-8 text-uppercase" id="actividadId">ACTIVIDAD 1</div>
                </div>
                <div class="accordion-botones">
                  <i class="bi bi-plus-lg icono icono-agregar" data-id="1" data-bs-toggle="modal" data-bs-target="#actividadModal"></i>
                  <i class="bi bi-pencil-square icono" data-bs-toggle="modal" data-bs-target="#actividadModal"></i>
                  <i class="bi bi-paperclip icono icono-cargar" data-bs-toggle="modal" data-bs-target="#imagenModal"></i>
                  <i class="bi bi-trash3 icono delete-activity" data-id="accordionId-1"></i>
                </div>
              </div>
            </h2>
            <div id="collapseAcordion-1" class="accordion-collapse collapse show" aria-labelledby="accordionHeaderId-1" style="">
              <div class="accordion-body accordion-body--mod">
                <!-- CONTENEDOR-DIAGNÓSTICO-TRABAJO-OBSERVACIÓN -->
                <div class=" row detalles">
                  <div class="detalles-diagnostico col-6">
                    <label for="diagnosticoId" class="form-label mb-0">Diagnóstico</label>
                    <p class="mb-1" id="diagnosticoId">Diagnostico Nro.1</p>
                  </div>
                  <div class="detalles-trabajo col-6">
                    <label for="trabajoId" class="form-label mb-0">Trabajos</label>
                    <p class="mb-1" id="trabajoId">Trabajo Nro.1</p>
                  </div>
                  <div class="detalles-observacion col-12">
                    <label for="observacionId" class="form-label mb-0">Observaciones</label>
                    <p class="mb-1" id="observacionId">Observación N°1</p>
                  </div>
                </div>
                <!-- CONTENEDOR-IMAGENES -->
                <div class="imagenes-actividad">
                  <div class="grid-imagen">
                    <div class="titulo-imagen">
                      <p class="mb-1" id="titulo1Id" style="text-align:center;">Título 1</p>
                    </div>
                    <div class="image-wrapper" style="position: relative; display: inline-block; margin: 10px;">
                      <img src="../img/imagen1.png" id="imagen1Id" class="img-thumbnail">
                      <i class="bi bi-x-circle-fill remove-icon" data-target="imagen1Id" style="position: absolute; top: 5px; right: 5px; cursor: pointer;"></i>
                    </div>
                    <div class="descripcion-imagen">
                      <p class="mb-1" id="descripcion1Id" style="text-align:center;">Descripción 1</p>
                    </div>
                  </div>
                  <div class="grid-imagen">
                    <div class="titulo-imagen">
                      <p class="mb-1" id="titulo2Id" style="text-align:center;">Título 2</p>
                    </div>
                    <div class="image-wrapper" style="position: relative; display: inline-block; margin: 10px;">
                      <img src="../img/imagen2.png" id="imagen2Id" class="img-thumbnail">
                      <i class="bi bi-x-circle-fill remove-icon" data-target="imagen2Id" style="position: absolute; top: 5px; right: 5px; cursor: pointer;"></i>
                    </div>
                    <div class="descripcion-imagen">
                      <p class="mb-1" id="descripcion2Id" style="text-align:center;">Descripción 2</p>
                    </div>
                  </div>
                </div>

                <div class="accordion-item" id="accordionId-2">
                  <h2 class="accordion-header accordion-header--mod" id="accordionHeaderId-2">
                    <div class="item-actividad">
                      <div class="accordion-button accordion-button--mod" data-bs-toggle="collapse" data-bs-target="#collapseAcordion-2" aria-expanded="true" aria-controls="collapseAcordion-2" id="2">
                        <div class="accordion-actividad col-8 text-uppercase">SUBACTIVIDAD 1.1</div>
                      </div>
                      <div class="accordion-botones">
                        <i class="bi bi-plus-lg icono icono-agregar" data-id="2" data-bs-toggle="modal" data-bs-target="#actividadModal"></i>
                        <i class="bi bi-pencil-square icono" data-bs-toggle="modal" data-bs-target="#actividadModal"></i>
                        <i class="bi bi-paperclip icono icono-cargar" data-bs-toggle="modal" data-bs-target="#imagenModal"></i>
                        <i class="bi bi-trash3 icono delete-activity"></i>
                      </div>
                    </div>
                  </h2>
                  <div id="collapseAcordion-2" class="accordion-collapse collapse show" aria-labelledby="accordionHeaderId-2" style="">
                    <div class="accordion-body accordion-body--mod">
                      <!-- CONTENEDOR-DIAGNÓSTICO-TRABAJO-OBSERVACIÓN -->
                      <div class=" row detalles">
                        <div class="detalles-diagnostico col-6">
                          <label for="detalleDiagnosticoId-2" class="form-label mb-0">Diagnóstico</label>
                          <p class="mb-1" id="detalleDiagnosticoId-2">Diagnostico Nro.1.1</p>
                        </div>
                        <div class="detalles-trabajo col-6">
                          <label for="detalleTrabajoId" class="form-label mb-0">Trabajos</label>
                          <p class="mb-1" id="detalleTrabajoId-2">Trabajo Nro.1.1</p>
                        </div>
                        <div class="detalles-observacion col-12">
                          <label for="detalleObservacionId" class="form-label mb-0">Observaciones</label>
                          <p class="mb-1" id="detalleObservacionId-2">Observación N°1.1</p>
                        </div>
                      </div>
                      <!-- CONTENEDOR-IMAGENES -->
                      <div class="imagenes-actividad">
                        <div class="grid-imagen">
                          <div class="titulo-imagen">
                            <p class="mb-1" id="tituloImagenId1-2" style="text-align:center;">Título 1</p>
                          </div>
                          <div class="image-wrapper" style="position: relative; display: inline-block; margin: 10px;">
                            <img src="../img/imagen3.png" id="imagenId1-2" class="img-thumbnail">
                            <i class="bi bi-x-circle-fill remove-icon" style="position: absolute; top: 5px; right: 5px; cursor: pointer;"></i>
                          </div>
                          <div class="descripcion-imagen">
                            <p class="mb-1" id="descripcionImagenId1-2" style="text-align:center;">Descripción 1</p>
                          </div>
                        </div>
                        <div class="grid-imagen">
                          <div class="titulo-imagen">
                            <p class="mb-1" id="tituloImagenId2-2" style="text-align:center;">Título 2</p>
                          </div>
                          <div class="image-wrapper" style="position: relative; display: inline-block; margin: 10px;">
                            <img src="../img/imagen4.png" id="imagenId2-2" class="img-thumbnail">
                            <i class="bi bi-x-circle-fill remove-icon" style="position: absolute; top: 5px; right: 5px; cursor: pointer;"></i>
                          </div>
                          <div class="descripcion-imagen">
                            <p class="mb-1" id="descripcionImagenId2-2" style="text-align:center;">Descripción 2</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <button class="btn btn-primary text-uppercase fw-light" onclick="fnCargaContenidoActividad()">Guardar <i class="bi bi-floppy"></i></button>
          </div>
      </div><!-- FIN ACCORDION -->

      <!-- START MODAL PARA AGREGAR ACTIVIDADES -->
      <div class="modal fade" id="actividadModal" tabindex="-1" aria-labelledby="actividadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title fs-5 text-uppercase" id="actividadModalLabel">Actividad</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- START MODAL-BODY -->
            <div class="modal-body" id='modal-body'>
              <div class="row">
                <div id="campoactividad">
                  <label for="nombreActividadInput" class="form-label mb-0">Nombre de la Actividad</label>
                  <textarea type="text" name="actividad" class="form-control" id="nombreActividadInput" row=3 placeholder="Ingrese el nombre de la actividad."></textarea>
                </div>
                <div id="campoDiagnostico" class="col-md-12 mt-2">
                  <label for="diagnosticoInput" class="form-label mb-0">Diagnóstico</label>
                  <textarea type="text" name="diagnostico" class="form-control" ro=3 id="diagnosticoInput" placeholder="Ingrese el diagnositico."></textarea>
                </div>

                <div id="campoTrabajo" class="col-md-12 mt-2">
                  <label for="trabajosInput" class="form-label mb-0">Trabajos</label>
                  <textarea type="text" name="trabajo" class="form-control" id="trabajosInput" row=3 placeholder="Ingrese el diagnositico."></textarea>
                </div>

                <div id="campoObservacion" class ="col-md-12 mt-2">
                  <label for="observacionesInput" class="form-label mb-0">Observación</label>
                  <textarea type="text" name="observacion" class="form-control" id="observacionesInput" row=3 placeholder="Ingrese el diagnositico."></textarea>
                </div>
                <div id="contenedorGuardarActividad" class="col-6 mt-4">
                  <button id="guardarActividad" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" style="font-weight:200;" onclick="fnGuardarActividad()" >Guardar <i class="bi bi-floppy"></i></button>
                </div>
              </div>
            </div>
            <!-- END MODAL-BODY -->
          </div>
        </div>
      </div>
      <!-- END MODAL -->

      <!-- START MODAL IMAGENES -->
      <div class="modal fade" id="imagenModal" tabindex="-1" aria-labelledby="imagenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title fs-5 text-uppercase" id="imagenModalLabel">Detalles de actividades</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- START MODAL-BODY -->
            <div class="modal-body" id='modal-body-imagen'>
              <div class="row">
                <div id="campoTitulo1" class ="col-md-12 mt-2">
                  <label for="titulo1Input" class="form-label mb-0">Título 1</label>
                  <input name="titulo1" type="text" class="form-control" id="titulo1Input" placeholder="Ingresar título.">
                </div>
                <div id="campoImagen1" class="col-md-12 mt-2">
                  <label for="imagen1Input" class="form-label mb-0">Imagen 1</label>
                  <input name="imagen1" class="form-control" type="file" id="imagen1Input">
                </div>
                <div id="campoDescripcion1" class ="col-md-12 mt-2">
                  <label for="descripcion1Input" class="form-label mb-0">Descripción 1</label>
                  <textarea type="descripcion1"  name="titulo1" class="form-control" row=3 id="descripcion1Input" placeholder="Ingresar título."></textarea>
                </div>
                <div id="campoTitulo2" class ="col-md-12 mt-2">
                  <label for="titulo2Input" class="form-label mb-0">Título 2</label>
                  <input type="text" name="titulo2" class="form-control" id="titulo2Input" placeholder="Ingresar título.">
                </div>
                <div id="campoImagen2" class="col-md-12 mt-2">
                  <label for="imagen2Input" class="form-label mb-0">Imagen 2</label>
                  <input name="imagen2" class="form-control" type="file" id="imagen2Input">
                </div>
                <div id="campoDescripcion2" class ="col-md-12 mt-2">
                  <label for="descripcion2Input" class="form-label mb-0">Descripcion 2</label>
                  <textarea type="text" name="descripcion2" class="form-control" row=3 id="descripcion2Input" placeholder="Ingresar título."></textarea>
                </div>
                <div id="contenedorGuardarActividad" class="col-6 mt-4">
                  <button id="guardarActividad" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" style="font-weight:200;" onclick="fnGuardarDetallesActividad()">Guardar <i class="bi bi-floppy"></i></button>
                </div>
              </div>

            </div>
            <!-- END MODAL-BODY -->
          </div>
        </div>
      </div>

    </div><!--FIN CONTAINER-->

    <script src="js/actividad.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> 
  </body>
</html>