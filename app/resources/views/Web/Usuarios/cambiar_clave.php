<?php headerWeb('header_web', $data); ?>
<section class="feature_part padding_top">
    <div class="container mt-5">
        <div class="alert alert-primary" role="alert">
            Por motivos de seguridad le pedimos que primero cambie su contraseña.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="passupd">
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="">Contraseña</label>
                            <input name="txtpas" class="form-control" type="password" onkeyup="validarfuerza(this,'fuerza')" onblur="ocultarbarra('fuerza')" required>
                            <div id="fuerza" class="progress mt-3" style="display: none;">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="">Confirmar Contraseña</label>
                            <input name="txtcpas" class="form-control" type="password" onkeyup="validarfuerza(this,'fuerza2')" onblur="ocultarbarra('fuerza2')" required>
                            <div id="fuerza2" class="progress mt-3" style="display: none;">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="form-group col-4 d-flex align-items-end">
                            <button class="btn btn-outline-success position-relative" type="submit">Guardar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>
<?php footerWeb('footer_web', $data); ?>