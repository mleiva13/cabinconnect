<?php include_once 'views/template/header-cliente.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Estado de Reserva</h4>
        <?php if (!empty($_SESSION['reserva'])) { ?>
            <div
                class="alert alert-warning" role="alert"
                <strong>!Aviso!</strong> Tienes una reserva Pendiente
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $data['habitacion']['foto']; ?>" class="img-fluid rounded-top" alt="" />

                    <!-- Hover added -->
                    <div class="table-responsive">
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>Cabaña:</strong>
                            <?php echo $data['habitacion']['estilo'];  ?>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>Descripción:</strong>
                            <?php echo $data['habitacion']['descripcion'];  ?>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>Precio/Noche:</strong>
                            <?php echo $data['habitacion']['precio'];  ?> USD
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>Fecha de Llegada:</strong>
                            <?php echo fechaPerzo($_SESSION['reserva']['f_llegada']);  ?>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>Fecha de Salida:</strong>
                            <?php echo fechaPerzo($_SESSION['reserva']['f_salida']);  ?>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>Capacidad:</strong>
                            <?php echo $data['habitacion']['capacidad'];  ?>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>N° Cabaña:</strong>
                            <?php echo $data['habitacion']['numero'];  ?>
                        </a>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button
                                    class="accordion-button"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne"
                                    aria-expanded="true"
                                    aria-controls="collapseOne">
                                    Pay-Pal
                                </button>
                            </h2>
                            <div
                                id="collapseOne"
                                class="accordion-collapse collapse show"
                                aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div id="paypal-button-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php } else { ?>
            <div
                class="alert alert-warning" role="alert"
                <strong>!Aviso!</strong> No tienes ninguna reserva Pendiente
            </div>
        <?php } ?>
    </div>
</div>


<?php include_once 'views/template/footer-cliente.php'; ?>

<script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENTE_ID; ?>&currency=USD"></script>
<script src="https://sandbox.paypal.com/sdk/js?client-id=<?php echo CLIENTE_ID; ?>"></script>

<script>
    // Render the PayPal button into #paypal-button-container
    paypal.Buttons({

        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay',
            height: 40
        },

        // Call your server to set up the transaction
        createOrder: function(data, actions) {
            return actions.order.create({
                application_context: {
                    return_url: "<?php echo RUTA_PRINCIPAL; ?>principal/reserva/paypal"
                },
                purchase_units: [{
                    amount: {
                        currency_code: "USD",
                        value: "<?php echo $data['total']; ?>"
                    }
                }]
            });
        },

        // Call your server to finalize the transaction
        onApprove: function(data, actions) {
            console.log(data);
            return actions.order.capture().then(function(orderData) {
                registrarReserva(orderData);
            });
        }
    }).render('#paypal-button-container');

    function registrarReserva(datos) {
        const url = base_url + 'reserva/registrarReserva';
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(JSON.stringify(datos));
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                Swal.fire({
                    title: "¡Reserva Registrada!",
                    text: res.msg,
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo RUTA_PRINCIPAL; ?>reserva/mostrarReservas";
                    }
                });
            }
        }
    }
</script>

</body>

</html>