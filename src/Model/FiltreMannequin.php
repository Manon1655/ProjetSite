<?php

namespace App\Model;
use App\Entity\Defile;
use Symfony\Component\Validator\Constraints as Assert;

class FiltreMannequin{

#[Assert\Length(min: 2, minMessage: "Le nom du mannequin doit comporter au moins {{ limit }} caractères.")]

public string $Nom;


public Defile $defile;

}