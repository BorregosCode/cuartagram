<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        
        // Modificar el $request
        $request->request->add(['username' => Str::slug( $request->username )]);

        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id, 'min:3', 'max:20','not_in:twitter,editar-perfil'],
            'email' => 'required|email|unique:users,imagen,'.auth()->user()->id,
        ]);

        if($request->image)
        {
            //Obtener informacion de la imagen del request
            $imagen = $request->file('image');
            //Nombrar imagen de con un nombre unico 
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            //aplicar Intervetion a la imagen
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
            //Crear direccion donde se guardara la imagen 
            $imagenPath = public_path('perfiles'). '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Email
            //Guardar Cambios
            $usuario = User::find(auth()->user()->id);

            $usuario->username = $request->username;
            $usuario->email = $request->email ?? auth()->user()->email;

            if($request->oldpassword || $request->password)
            {
                $this->validate($request, [
                    'password' => 'required|confirmed|min:6',
                ]);
     
                if (Hash::check($request->oldpassword, auth()->user()->password)) {
                    $usuario->password = Hash::make($request->password) ?? auth()->user()->password;
                    $usuario->save();
                } else {
                    return back()->with('mensaje', 'La Contraseña Actual no Coincide');
                }
            }
            
            $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;

            $usuario->save();


            //Redireccionar Usuario
            return redirect()->route('posts.index', $usuario->username);
    }
}
