<?php
class ReservaModel extends Query{
    
    public function __construct() {
        parent::__construct();
    }
    public function getDisponible($f_llegada, $f_salida, $habitacion){
        return $this->selectAll("SELECT * FROM reservas 
        WHERE fecha_ingreso <= '$f_salida'
        AND fecha_salida >= '$f_llegada' AND id_habitacion = $habitacion");
    }
    public function getReservasHabitacion($habitacion)
    {
        return $this->selectAll("SELECT * FROM reservas 
        WHERE id_habitacion = $habitacion");
    }
    //RECUPERAR HABITACIONES
    public function getHabitaciones()
    {
        return $this->selectAll("SELECT * FROM habitaciones WHERE estado = 1");
    }
    //RECUPERAR HABITACION
    public function getHabitacion($id_habitacion)
    {
        return $this->select("SELECT * FROM habitaciones WHERE id = $id_habitacion");
    }
    public function getReservasUsuario($id_usuario)
    {
        $sql = "SELECT r.*, h.estilo 
                FROM reservas r 
                INNER JOIN habitaciones h ON r.id_habitacion = h.id 
                WHERE r.id_usuario = $id_usuario 
                ORDER BY r.fecha_ingreso DESC";
        var_dump($sql);
        return $this->selectAll($sql);
    }

    //REGISTRAR RESERVA
    public function registrarReserva($monto, $cod_reserva, $fecha_ingreso, $fecha_salida, 
    $fecha_reserva, $estado, $metodo, $id_habitacion, $id_usuario){
        $sql = "INSERT INTO reservas (monto, cod_reserva, fecha_ingreso, fecha_salida, 
        fecha_reserva, estado, metodo, id_habitacion, id_usuario) VALUES (?,?,?,?,?,?,?,?,?)";
        $datos = array($monto, $cod_reserva, $fecha_ingreso, $fecha_salida, 
        $fecha_reserva, $estado, $metodo, $id_habitacion, $id_usuario);
        $data = $this->insert($sql, $datos);
        if ($data > 0) {
            $res = $data;
        } else {
            $res = 0;
        }
        return $res;
    }
}
?>