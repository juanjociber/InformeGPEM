<?php
    $titles = ['DATOS GENERALES', 'DATOS DEL EEQUIPO', 'SOLICITUD DEL CLIENTE', 'ACTIVIDADES', 'CONCLUSIONES','RECOMENDACIONES','ANEXOS'];
    $counter = 1;
    foreach($titles as $title) : ?>
        
        <div class="row p-1 mb-2 mt-2">
            <div class="col-12 mb-0 border-bottom bg-light">
                <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $counter . '. ' . htmlspecialchars($title); ?></p>
            </div>
        </div>



        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $counter . '. ' . htmlspecialchars($title); ?></p>
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

        <!-- DATOS DEL EQUIPO -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $counter . '. ' . htmlspecialchars($title); ?></p>
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
          <div class="archivos">
            <?php foreach($archivos as $archivo): ?>
              <div class="contenedor-imagen-equipo">
                <p class="text-center mt-4 mb-1"><?php echo htmlspecialchars($archivo['titulo']); ?></p>
                <img src="/mycloud/gesman/files/<?php echo htmlspecialchars($archivo['nombre']); ?>" class="img-fluid" alt="">
                <p class="text-center"><?php echo htmlspecialchars($archivo['descripcion']); ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
  
        <!-- SOLICITUD DEL CLIENTE-->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $counter . '. ' . htmlspecialchars($title); ?></p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <div class="col-12 mb-2 mt-2">
            <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($informe->actividad); ?></p>          
          </div>
        </div>
  
        <!-- ACTIVIDADES -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $counter . '. ' . htmlspecialchars($title); ?></p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <?php
            echo $tablaHTML;
          ?>
        </div>

        <!-- CONCLUSIONES -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $counter . '. ' . htmlspecialchars($title); ?></p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <?php foreach($actividadesdetalles as $detalle) :?>
            <?php if($detalle->tipo ==='con') :?>
              <div class="d-flex">
                <span class="vineta"></span> 
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($detalle->actividad); echo ' - ' ?></p>
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($detalle->diagnostico); echo ' - ' ?></p>
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($detalle->trabajos); echo ' - ' ?></p>
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($detalle->observaciones); ?></p>
              </div>
            <?php endif; ?>
          <?php endforeach ;?>
        </div>

        <!-- RECOMENDACIONES -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $counter . '. ' . htmlspecialchars($title); ?></p>
          </div>
        </div>
        <div class="row p-1 mb-2 contenedor-datos">
          <?php foreach($actividadesdetalles as $detalle) :?>
            <?php if($detalle->tipo ==='rec') :?>
              <div class="d-flex">
                <span class="vineta"></span> 
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($detalle->actividad); echo ' - ' ?></p>
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($detalle->diagnostico); echo ' - ' ?></p>
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($detalle->trabajos); echo ' - ' ?></p>
                <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($detalle->observaciones); ?></p>
              </div>
            <?php endif; ?>
          <?php endforeach ;?>
        </div>

        <!-- ANEXOS -->
        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo"><?php echo $counter . '. ' . htmlspecialchars($title); ?></p>
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



        <?php $counter++; ?>
    <?php endforeach; ?>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

</body>
</html>

