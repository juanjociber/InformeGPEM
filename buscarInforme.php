<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="css/main.css">
    <title>Buscador</title>

    <style>
      ::placeholder{
      color: #cecccc !important;
      font-weight: 200;
      text-transform: uppercase;
    }
    img{
      width: 100%;
    }
    @media(max-width:767px){
      .form-label{
        font-size: 15px;
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
    .btn-control {
      padding: .375rem .75rem;
    }
    .custom-select-arrow {
      top: 75%;
      right: 20px;
    }
    .custom-select-list {
      display: none;
      position: absolute;
      width: 100%;
      background: #fff;
      border: 1px solid #ced4da;
      z-index: 1000;
    }
    .custom-select-item {
      padding: .375rem .75rem;
      cursor: pointer;
    }
    .custom-select-item:hover {
      background-color: #e9ecef;
    }
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
          <p class="m-0 p-0 text-secondary text-uppercase fw-bold">CLIENTE</p>
        </div>
      </div>

      <!-- FILTRO -->
      <div class="row mb-1 border-bottom">
        <div class="col-6 col-lg-6 col-xl-3">
          <label for="informeInput" class="form-label mb-0">Informe</label>
          <input type="text" class="form-control text-secondary text-uppercase fw-bold" id="informeInput">
        </div>
        
        <div class="col-6 col-lg-6 col-xl-3 custom-select-wrapper">
          <label for="equipoInput" class="form-label mb-0">Equipo</label>
          <input type="text" id="equipoInput" class="form-control text-secondary text-uppercase fw-bold" autocomplete="off" placeholder="Ingrese 1 o más caracteres">
          <span class="custom-select-arrow"><i class="bi bi-chevron-down"></i></span>
          <div id="equipoList" class="custom-select-list"></div>
          <div class="fullscreen-spinner" id="spinner" style="display: none;">
            <div class="spinner"></div>
          </div>
        </div>

        <input type="hidden" id="idActivoInput">
        
        <div class="col-6 col-lg-6 col-xl-3">
          <label for="fechaInicialInput" class="form-label mb-0">Fecha inicial</label>
          <input type="date" class="form-control text-secondary text-uppercase fw-bold" id="fechaInicialInput" value=""/>
        </div>
        <div class="col-6 col-lg-6 col-xl-3">
          <label for="fechaFinalInput" class="form-label mb-0">Fecha final</label>
          <input type="date" class="form-control text-secondary text-uppercase fw-bold" id="fechaFinalInput" value=""/>
        </div>
        
        <div class="col-6 col-lg-3 mt-2 mb-2">
          <button type="button" class="btn btn-primary text-uppercase col-12 col-lg-6" onclick="fnBuscarInforme();"><i class="bi bi-search"></i> Buscar</button>
        </div>  
      </div>

      <!-- INFORMES -->
      <div id="contenedor-lista"></div>
    </div>

    <script src="js/buscarInforme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  </body>
</html>
