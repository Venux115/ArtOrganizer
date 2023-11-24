<?php

namespace artorganizer\Repository;

use artorganizer\Entity\Usuario;

class UsuarioRepository
{

    function __construct(private \mysqli $bd)
    {
    }

    function add(Usuario $user): bool
    {
        $query = $this->bd->prepare("INSERT INTO `usuarios`(`nome_Usuario`, `Senha`, `Nome_Completo`, `Email`, `Data_nasc`) VALUES (?, ?, ?, ?, ?);");
        $query->bind_param("sssss", $user->getNick(), $user->getSenha(), $user->getNome(), $user->getEmail(), $user->getNasc());
        $result = $query->execute();

        $user->setId($this->bd->insert_id);

        return $result;
    }

    function all(): array
    {
        $query = $this->bd->prepare("SELECT * FROM usuarios;");
        $query->execute();
        $result = $query->get_result();
        $userList = $result->fetch_all(MYSQLI_ASSOC);

        return array_map(
            function ($dados) {
                $usuario = new Usuario($dados['Nome_Usuario'], $dados['Senha'], $dados['Nome_Completo'], $dados['Email'], $dados['Datas_Nasc']);
                $usuario->setId($dados['ID']);

                return $usuario;
            },

            $userList
        );
    }

    function logar(string $email, string $senha)
    {
        
            $query = $this->bd->prepare("SELECT * FROM usuarios WHERE Email = ?;");
            $query->bind_param("s", $email);
            $query->execute();
            $result = $query->get_result();
            $userList = $result->fetch_all(MYSQLI_ASSOC);
    
            $usuarios = array_map(
                function ($dados) {
                    $usuario = new Usuario($dados['Nome_Usuario'], $dados['Nome_Completo'], $dados['Email'], $dados['Data_Nasc']);
                    $usuario->setSenha($dados['Senha']);
                    $usuario->setId($dados['ID']);
    
                    return $usuario;
                },
    
                $userList
            );
            
            

            if (count($usuarios) != 1) {
                return false;
            }

            
            if (password_verify($senha, $usuarios[0]->getSenha())){
                

                return $usuarios[0];
            }else{
                return false;
            }

            
    }

    public function update(Usuario $usuario): bool
        {

            $query = $this->bd->prepare("
                UPDATE artorganizer.usuarios
                SET Nome_Usuario=?, Nome_Completo=?, Email=?, Data_Nasc=?, telefone=?, `img-perfil`=?
                WHERE ID=?;
                ");

            $query->bind_param("ssssssi", $usuario->getNick(), $usuario->getNome(), $usuario->getEmail(), $usuario->getNasc(), $usuario->getFone(), $usuario->getPerfilImg(), $usuario->getId());
            $result = $query->execute();

            return $result;
        }
}