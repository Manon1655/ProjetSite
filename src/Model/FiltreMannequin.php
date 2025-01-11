<?php

namespace App\Model;
use Symfony\Component\Validator\Constraints as Assert;

class FiltreMannequin{

#[Assert\Length(min: 2, minMessage: "Le nom du mannequin doit comporter au moins {{ limit }} caractères.")]

public string $Nom;


}