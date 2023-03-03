<?php headerWeb('header_web', $data); ?>
<main class="bg-main">
    <div class="container d-flex align-items-center justify-content-center full-height">
        <div class="d-block col-10 rounded px-3 text-white bg-blur">
            <div class="row p-2">
                <div class="col-12 text-center">
                    <span class="form-label ft-b h2 font-logo"><?= NOMBRE_EMPRESA ?></span>
                    <p class="mt-4 font-weight-light" style="font-size: 18px;">Para finalizar con el proceso de registro es necesario que ingreses 3 pregunats y 3 respuestas que solo tú sabes, esto sera usado como medida en la <b>recuperación de contraseña </b></p>
                </div>
                <form action="" id="pregvalid" class="col-12">
                    <input type="hidden" name="stremail" value="<?= $data['url'][0] ?>">
                    <input type="hidden" name="strtoken" value="<?= $data['url'][1] ?>">
                    <div class="form-row col-12 mt-3">
                        <div class="col-12 col-md-6">
                            <label for="">Pregunta 1</label>
                            <input class="form-control text-white" type="text" require name="txtpre1">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="">Respuesta</label>
                            <input class="form-control text-white" type="text" require name="txtre1">
                        </div>
                    </div>
                    <div class="form-row col-12">
                        <div class="col-12 col-md-6">
                            <label for="">Pregunta 2</label>
                            <input class="form-control text-white" type="text" require name="txtpre2">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="">Respuesta</label>
                            <input class="form-control text-white" type="text" require name="txtre2">
                        </div>
                    </div>
                    <div class="form-row col-12">
                        <div class="col-12 col-md-6">
                            <label for="">Pregunta 3</label>
                            <input class="form-control text-white" type="text" require name="txtpre3">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="">Respuesta</label>
                            <input class="form-control text-white" type="text" require name="txtre3">
                        </div>
                    </div>
                    <div class="form-row col-12 mt-5 mb-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-blur float-right">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</main>
<?php footerWeb('footer_web', $data); ?>