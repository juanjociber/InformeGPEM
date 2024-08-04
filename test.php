<!-- ITEM ANTECEDENTES -->
<div class="col-12 mt-2" style="border: 0.5px solid #0000005e; padding: 1px 8px 9px 8px; border-radius: 4px;">
    <label class="form-label">Antecedentes <i class="bi bi-plus-lg" onclick="abrirModalAgregar('antecedente')"></i></label>
    <div class="mt-1">
        <?php foreach ($antecedentes as $antecedente) : ?>
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <span class="vineta"></span>
                <p class="mb-0 fw-light text-uppercase" data-tipo="ant" style="text-align: justify;"><?php echo $antecedente['actividad']; ?></p>
            </div>
            <div class="input-grop-icons">
                <span class="input-group-text"><i class="bi bi-pencil-square" onclick="abrirModalEditar(<?php echo $antecedente['id']; ?>, 'antecedente')"></i></span>
                <span class="input-group-text"><i class="bi bi-trash3" onclick="abrirModalEliminar(<?php echo $antecedente['id']; ?>)"></i></span>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>

<!-- ITEM CONCLUSIONES -->
<div class="col-12 mt-2" style="border: 0.5px solid #0000005e; padding: 1px 8px 9px 8px; border-radius: 4px;">
    <label class="form-label">Conclusiones <i class="bi bi-plus-lg" onclick="abrirModalAgregar('conclusion')"></i></label>
    <div class="mt-1">
        <?php foreach ($conclusiones as $conclusion) : ?>
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <span class="vineta"></span>
                <p class="mb-0 fw-light text-uppercase" data-tipo="con" style="text-align: justify;"><?php echo $conclusion['actividad']; ?></p>
            </div>
            <div class="input-grop-icons">
                <span class="input-group-text"><i class="bi bi-pencil-square" onclick="abrirModalEditar(<?php echo $conclusion['id']; ?>, 'conclusion')"></i></span>
                <span class="input-group-text"><i class="bi bi-trash3" onclick="abrirModalEliminar(<?php echo $conclusion['id']; ?>)"></i></span>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>

<!-- ITEM RECOMENDACIONES -->
<div class="col-12 mt-2" style="border: 0.5px solid #0000005e; padding: 1px 8px 9px 8px; border-radius: 4px;">
    <label class="form-label">Recomendaciones <i class="bi bi-plus-lg" onclick="abrirModalAgregar('recomendacion')"></i></label>
    <div class="mt-1">
        <?php foreach ($recomendaciones as $recomendacion) : ?>
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <span class="vineta"></span>
                <p class="mb-0 fw-light text-uppercase" data-tipo="rec" style="text-align: justify;"><?php echo $recomendacion['actividad']; ?></p>
            </div>
            <div class="input-grop-icons">
                <span class="input-group-text"><i class="bi bi-pencil-square" onclick="abrirModalEditar(<?php echo $recomendacion['id']; ?>, 'recomendacion')"></i></span>
                <span class="input-group-text"><i class="bi bi-trash3" onclick="abrirModalEliminar(<?php echo $recomendacion['id']; ?>)"></i></span>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>
