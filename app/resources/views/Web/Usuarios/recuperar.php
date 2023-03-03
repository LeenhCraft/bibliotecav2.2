<?php headerWeb('header_web', $data); ?>
<section class="feature_part padding_top">
    <div class="container">
        <div class="alert alert-primary" role="alert">
            Responde a las preguntas de seguridad para recuperar tu contraseña.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="passupd">
                    <div class="form-row px-5 py-3">
                        <input type="hidden" name="stremail" value="<?= $data['url'][0] ?>">
                        <input type="hidden" name="strtoken" value="<?= $data['url'][1] ?>">
                        <?php
                        $num = 1;
                        foreach ($data['preguntas']['data'] as $row) {
                            echo '<div class="form-group col-md-10">';
                            echo '<input type="hidden" name="pregunta' . $num . '" value="' . $row['idpregunta'] . '">';
                            echo '<label for="respuesta' . $num . '">¿' . $row['pregunta'] . '?</label>';
                            echo '<input type="text" class="form-control" id="respuesta' . $num . '" name="respuesta' . $num . '">';
                            echo '</div>';
                            $num++;
                        }
                        ?>
                        <div class="form-group col-4 d-flex align-items-end">
                            <button class="btn btn-outline-success position-relative" type="submit">Validar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>
<?php footerWeb('footer_web', $data); ?>