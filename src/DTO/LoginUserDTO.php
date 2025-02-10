<?php

namespace App\DTO;

class LoginUserDTO
{

        private string $nick;
        private string $contrasenia;

    /**
     * @param string $nick
     * @param string $contrasenia
     */
    public function __construct(string $nick = '', string $contrasenia = '')
    {
        $this->nick = $nick;
        $this->contrasenia = $contrasenia;
    }


    public function getNick(): string
    {
        return $this->nick;
    }

    public function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    public function getContrasenia(): string
    {
        return $this->contrasenia;
    }

    public function setContrasenia(string $contrasenia): void
    {
        $this->contrasenia = $contrasenia;
    }


}
