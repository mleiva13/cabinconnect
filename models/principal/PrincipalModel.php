<?php
class PrincipalModel extends Query{
    
    public function __construct() {
        parent::__construct();
    }
    //RECUPERAR SLIDERS
    public function getSliders() {
        return $this->selectAll("SELECT * FROM sliders");
    }
    //RECUPERAR HABITACIONES
    public function getHabitaciones() {
        return $this->selectAll("SELECT * FROM habitaciones WHERE estado = 1");
    }
}
?>