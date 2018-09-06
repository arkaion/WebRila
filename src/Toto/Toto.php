<?php
/**
 * Created by PhpStorm.
 * User: thiba
 * Date: 05/09/2018
 * Time: 17:03
 */

namespace App\Toto;


class Toto
{
    private $prenom;
    public function __construct()
    {
        $this->prenom="Jean bernard toto";
    }

    public function getPrenom()
    {
        return $this->prenom;
    }


}