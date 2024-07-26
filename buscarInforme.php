<?php
  

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/main.css">
    <title>Sistema GPEM S.A.C</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
      ::placeholder {
        color: #cecccc !important;
        font-weight: 300;
        /* text-transform: uppercase; */
        font-size: 15px;

      }
      .form-label {
        color: #212529;
        font-weight: 300; 
      }
      @media (max-width: 767px) {
        .form-label {
          font-size: 13px;
        }
      }
      @media (min-width: 768px) {
        .mt--mod {
          margin-top: 17px !important;
        }
      }
      @media (min-width: 992px) {
        .form-label {
          font-size: 15px;
        }
      }
      .form-control {
        border-radius: .25rem;
      }
      .btn-control {
        padding: .375rem .75rem;
      }
      .custom-select-arrow{
        top: 75%;
        right: 20px;
      }

      /* SPINNER */
      .fullscreen-spinner {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); 
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999; 
      }

      .spinner {
        border: 8px solid #f3f3f3; 
        border-top: 8px solid #3498db; 
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 2s linear infinite;
        position: absolute;
        left: 45%;
        top: 50%;
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }

    </style>
  </head>
  <body>
    <!-- CONTENEDOR -->
    <div class="container">
      <!-- CABECERA -->
      <div class="row border-bottom mb-3 fs-5">
        <div class="col-12 fw-bold d-flex justify-content-between">
          <p class="m-0 p-0">CLIENTE</p>
        </div>
      </div>

      <!-- FILTRO -->
      <div class="row mb-1 border-bottom">
        <div class="col-6 col-lg-6 col-xl-3">
          <label for="informeInput" class="form-label mb-0">Informe</label>
          <input type="text" class="form-control" id="informeInput">
        </div>

        <div class="col-6 col-lg-6 col-xl-3 custom-select-wrapper">
          <label for="equipoInput" class="form-label mb-0">Equipo</label>
          <input type="text" id="equipoInput" class="form-control" autocomplete="off" placeholder="Ingrese 1 o más caracteres">
          <span class="custom-select-arrow"><i class="bi bi-chevron-down"></i></span>
          <div id="equipoList" class="custom-select-list"></div>
        </div>

        <div class="col-6 col-lg-6 col-xl-3">
          <label for="fechaInicialInput" class="form-label mb-0">Fecha inicial</label>
          <input type="date" class="form-control" id="fechaInicialInput" value="2024-07-17"/>
        </div>
        <div class="col-6 col-lg-6 col-xl-3">
          <label for="fechaFinalInput" class="form-label mb-0">Fecha final</label>
          <input type="date" class="form-control" id="fechaFinalInput" value="2024-07-17"/>
        </div>
        
        <div class="col-6 col-lg-3 mt-2 mb-2">
          <button type="button" class="btn btn-primary text-uppercase fw-light col-12" onclick="fnBuscarInforme();">Buscar <i class="bi bi-search"></i></button>
        </div>  
      </div>

      <!-- LISTA -->
      <a class="link-colecciones" href="/sisgein/gesman/vistaPreliminar.php" style="text-decoration:none;color: #212529;font-weight: 300;">
        <div class="row">
          <div class="col-8"><span class="fw-bold">00003</span> <span style="font-size: 12px; font-style: italic;">2024-07-17</span></div>
          <div class="col-4 text-end"><span class="badge bg-primary">Proceso</span></div>
          <div class="col-12">ACTIVIDAD 1</div>
        </div>
      </a>
      <hr>
      <!-- <a class="link-colecciones" href="/sisgein/gesman/vistaPreliminar.php" style="text-decoration:none;color: #212529;font-weight: 300;">
        <div class="row">
          <div class="col-8"><span class="fw-bold">00002</span> <span style="font-size: 12px; font-style: italic;">2024-04-17</span></div>
          <div class="col-4 text-end"><span class="badge bg-secondary">Abierto</span></div>
          <div class="col-12">21FLOTA PREVENTIVA DRENADO DE SISTEMA NEUMATICO ARTICULADO - L,M,V</div>
        </div>
      </a>
      <hr>
      <a class="link-colecciones" href="/sisgein/gesman/vistaPreliminar.php" style="text-decoration:none;color: #212529;font-weight: 300;">
        <div class="row">
          <div class="col-8"><span class="fw-bold">00001</span> <span style="font-size: 12px; font-style: italic;">2024-01-02</span></div>
          <div class="col-4 text-end"><span class="badge bg-success">Cerrado</span></div>
          <div class="col-12">21064 CORRECTIVA REVISAR PALANCA DE LUCES</div>
        </div>
      </a> -->
    </div>

    <!-- SPINNER -->
    <div class="fullscreen-spinner" id="spinner" style="display: none;">
      <div class="spinner"></div>
    </div>
    <script src="js/buscarInforme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
  </body>
</html>
