<?php
class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index(){
        $data['title'] = 'Registro';
        $data['subtitle'] = 'Registrarse Ahora';
        $this->views->getView('principal/registro', $data);
    }

    public function crear()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (validarCampos(['nombre', 'apellido', 'usuario', 'correo', 'clave', 'confirmar', 'chb2'])) {
                $nombre = strClean($_POST['nombre']);
                $apellido = strClean($_POST['apellido']);
                $usuario = strClean($_POST['usuario']);
                $correo = strClean($_POST['correo']);
                $clave = strClean($_POST['clave']);
                $confirmar = strClean($_POST['confirmar']);
                $hash = password_hash($clave, PASSWORD_DEFAULT);
                $rol = 2;
                //Validar contraseña
                if (!validarPassword($clave)) {
                    $res = ['tipo' => 'warning', 'msg' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número'];
                    echo json_encode($res, JSON_UNESCAPED_UNICODE);
                    die();
                }
                
                if($clave == $confirmar){
                    //VERIFICAR UNIQUE
                    $verificarUser = $this->model->validarUnique('usuario', $usuario, 0);
                    if (empty($verificarUser)) {
                        $verificarCorreo = $this->model->validarUnique('correo', $correo, 0);
                        if (empty($verificarCorreo)) {
                            $data = $this->model->registrarse($nombre, $apellido, $usuario, $correo, $hash, $rol);
                            if ($data > 0) {
                                crearSession([
                                    'id_usuario' => $data,
                                    'usuario' => $usuario,
                                    'correo' => $correo,
                                    'nombre' => $nombre . ' ' . $apellido,
                                    'rol' => $rol
                                ]);
                                $res = ['tipo' => 'succes', 'msg' => 'Usuario Registrado'];
                            } else {
                                $res = ['tipo' => 'warning', 'msg' => 'Error al Registrarse'];
                            }      
                        } else {
                            $res = ['tipo' => 'warning', 'msg' => 'El correo ya está Registrado'];
                        }
                        
                    } else {
                        $res = ['tipo' => 'warning', 'msg' => 'El Nombre de Usuario ya está Ocupado'];
                    }
                    
                }else{
                    $res = ['tipo' => 'warning', 'msg' => 'Las contraseñas no coinciden'];
                }
            } else {
                $res = ['tipo' => 'warning','msg' => 'Todos los campos con * son Requeridos'];
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }        
    }
}
