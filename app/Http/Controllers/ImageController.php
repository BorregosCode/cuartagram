<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        //Obtener informacion de la imagen del request
        $imagen = $request->file('file');
        //Nombrar imagen de con un nombre unico 
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
        //aplicar Intervetion a la imagen
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000);
        //Crear direccion donde se guardara la imagen 
        $imagenPath = public_path('uploads'). '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);


        return response()->json(['imagen' => $nombreImagen]);
    }
}