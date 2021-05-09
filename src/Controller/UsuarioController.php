<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Usuario;

//use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/users")
 */

class UsuarioController extends AbstractController{

    /**
     * @Route("/alta",name="alta_user")
     */
    public function altaUser(Request $request)  {

       // $nombre  = $request->query->get('alta_user', $request->nombre);
        //$nombre =$request->query->get('nombre');
       // $nombre = $request->query->get("nombre");
        //
        $nombre='seba';
        $nombre = $request->request->get("nombre");
        $apellido = $request->request->get("apellido");
        $mail = $request->request->get("mail");
        $usuario = $request->request->get("usuario");
        $clave = $request->request->get("clave");
        //$email = $paramFetcher->get('email'); 
        
        $em = $this->getDoctrine()->getManager();
        try{
            $usuario =  new Usuario($nombre,$apellido,$mail,$clave,$usuario);
        
            $em->persist($usuario);
            
            $em->flush();       
            

        }catch(\Exception $e){
           var_dump($e);
        }/**/

       
       // $usuarios = $em->getRepository(Usuario::class)->findAll();
        
        
        $roles = ["ADMINISTRADOR", "OPERADOR", "CARGA_USUARIOS"];
        
        
        return $this->render('usuarios/alta_usuario.html.twig',["roles" => $roles, "valor" => 1 ]);



       
    }

      /**
     * @Route("/list",name="list_user")
     */
    public function listaUsuarios(){

        $em = $this->getDoctrine()->getManager();

       $usuario = $em->getRepository(Usuario::class)->findAll(); //Me traigo todos los usuarios
        
        //LISTAR TODOS USUARIO


      //  $usuario = $em->getRepository(Usuario::class)->findByNombre('seba'); //Me traigo al usuario con nombre Carlin
        
        

        return $this->render('usuarios/lista_usuario.html.twig',["users" => $usuario, "usuariologueado" => $usuario[0]]);


        
    }

     /**
     * @Route("/login",name="login_user")
     */
    public function loginUser(Request $request){

        $em = $this->getDoctrine()->getManager();
        $usu = $request->request->get("usuario");
        $cla = $request->request->get("clave");
       // $usuario = $em->getRepository(Usuario::class)->findAll(); //Me traigo todos los usuarios
   try{     
        //LISTAR TODOS USUARIO
        $em = $this->getDoctrine()->getManager();
   
        //$usuario = $em->getRepository(Usuario::class)->findOneBy(["id" => 1]);
        $usuario = $em->getRepository(Usuario::class)->findByUsuario($usu); //Me traigo al usuario con nombre Carlin
      // $em->flush();
        if ($usu==''){
            $logueado='Debe iniciar sesion';
        }else{
            
            $pru=$usuario[0];
            if (isset($pru)  && ($pru->getPassword()==$cla)){
            $logueado=$pru->getNombre();
            }else{
                $logueado='Clave no valido';
            }
         
        }
     }catch (Exception $e) {
            $logueado='ERROR '.$e;
          }
        return $this->render('usuarios/login_usuario.html.twig',["usuariologueado" => $logueado]);


        
    }
}   
?>