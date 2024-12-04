<?php include_once 'views/template/header-cliente.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Mis Reservas</h4>

        <?php if (!empty($data['reservas'])) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tipo Cabaña</th>
                            <th>Fecha Llegada</th>
                            <th>Fecha Salida</th>
                            <th>ID de Reserva</th>
                            <th>Estado</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['reservas'] as $reserva) { ?>
                            <tr>
                                <td><?php echo $reserva['estilo']; ?></td>
                                <td><?php echo fechaPerzo($reserva['fecha_ingreso']); ?></td>
                                <td><span><?php echo fechaPerzo($reserva['fecha_salida']); ?></span></td>
                                <td><?php echo $reserva['cod_reserva']; ?></td>
                                <td><?php echo $reserva['estado']; ?></td>
                                <td><?php echo $reserva['monto']; ?> USD</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning" role="alert">
                No tienes reservas registradas
            </div>
        <?php } ?>
    </div>
</div>

<?php include_once 'views/template/footer-cliente.php'; ?>