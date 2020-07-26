<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frase as Frases;

class FrasesController extends Controller
{
    public function sentenceToday() {
        return  Frases::fraseDelDia();
    }
}
