<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

Class UsuarioRepository extends ServiceEntityRepository{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function findByUsuario($usuario){
    // $clave='123';
return $this->createQueryBuilder('usuario')
->andWhere('usuario.usuario = :vusuario')
//->and('usuario.clave = "123"')
->setParameter('vusuario', $usuario)
//->setParameter('vclave', $clave)
->getQuery()
->execute();
    }
    
}