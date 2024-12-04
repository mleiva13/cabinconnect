<?php
class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index(){
        $data['title'] = 'Login';
        $data['subtitle'] = 'Inicio de Sesion';
        $this->views->getView('principal/login', $data);
    }

    public function verify(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (validarCampos(['usuario', 'clave'])) {
                $usuario = strClean($_POST['usuario']);
                $clave = strClean($_POST['clave']);
                
                // Limitar intentos fallidos
                if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3) {
                    if (time() - $_SESSION['last_attempt'] < 300) { // 5 minutos de espera
                        $res = ['tipo' => 'warning', 'msg' => 'Demasiados intentos fallidos. Por favor, espere 5 minutos'];
                        echo json_encode($res, JSON_UNESCAPED_UNICODE);
                        die();
                    } else {
                        $_SESSION['login_attempts'] = 0;
                    }
                }
                
                //VERIFICAR ACCESO
                $verificar = $this->model->validarAcceso($usuario);
                if (empty($verificar)) {
                    $this->incrementarIntentosFallidos();
                    $res = ['tipo' => 'warning', 'msg' => 'El Usuario no existe...'];
                } else {
                    if (password_verify($clave, $verificar['clave'])) {
                        // Resetear intentos fallidos
                        unset($_SESSION['login_attempts']);
                        unset($_SESSION['last_attempt']);
                        
                        //CREAR SESIONES
                        crearSession([
                            'id_usuario' => $verificar['id'],
                            'usuario' => $verificar['usuario'],
                            'correo' => $verificar['correo'],
                            'nombre' => $verificar['nombre'] . ' ' . $verificar['apellido'],
                            'rol' => $verificar['rol']
                        ]);
                        $res = ['tipo' => 'success', 'msg' => 'Bienvenido...'];
                    } else {
                        $this->incrementarIntentosFallidos();
                        $res = ['tipo' => 'warning', 'msg' => 'Contraseña Incorrecta'];
                    }
                }
                
            } else {
                $res = ['tipo' => 'warning', 'msg' => 'Todos los campos con * son Requeridos'];
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }   
    }

    private function incrementarIntentosFallidos() {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1;
        } else {
            $_SESSION['login_attempts']++;
        }
        $_SESSION['last_attempt'] = time();
    }
}
