<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\proveedores;

class ProveedoresController extends Controller
{
    // Método para obtener todos los proveedores
    public function ObtenerProveedores(){
        $proveedores = proveedores::all();
        // proveedores::select('nombre')->where('id', '=', 5)->get();

        // Insert -> save()
        // Update -> update()
        // Delete -> delete()

        if(count($proveedores) == 0){
            return  response()->json("No hay registros de proveedores");
        }

        return response()->json($proveedores);
    }

    public function RegistrarProveedores(Request $request){

        $datos = array(
            "nombre" => $request->input('nombre'),
            "direccion" => $request->input('direccion'),
            "telefono" => $request->input('telefono'),
            "correo" => $request->input('correo'),
            "password" => $request->input('password'),
        );

        if(!empty($datos)){
            $proveedor = new proveedores();
            $proveedor->nombre = $datos['nombre'];
            $proveedor->direccion = $datos['direccion'];
            $proveedor->telefono = $datos['telefono'];
            $proveedor->correo = $datos['correo'];
            $password_encriptada = Hash::make($datos['password']);
            $proveedor->password = $password_encriptada;
            $proveedor->save();

            return response()->json([
                "status" => 200,
                "detalle" => "Proveedor registrado exitosamente",
                "credenciales" => array(
                    "correo" => $datos['correo'],
                    "llave_secreta" => $password_encriptada,
                )
            ]);

        } else {
            return response()->json('Necesitas rellenar todos los campos');
        }
    }

    public function GetID($id){
        $proveedor = proveedores::find($id);

        if(empty($proveedor)){
            return response()->json([
                "status" => 400,
                "detalle" => 'ID no encontrado',
            ]);
        }

        return response()->json([
            "status" => 200,
            "detalle" => $proveedor
        ]);
    }

    public function ActualizarProveedores(Request $request, $id){
        $datos = array(
            "nombre" => $request->input('nombre'),
            "direccion" => $request->input('direccion'),
            "telefono" => $request->input('telefono'),
            "correo" => $request->input('correo'),
            "password" => $request->input('password'),
        );

        if(!empty($datos)){
            $proveedor = proveedores::find($id);
            if(empty($proveedor)){
                return response()->json([
                    "status" => 400,
                    "detalle" => 'Proveedor no existe',
                ]);
            }

            $proveedor->nombre = $datos['nombre'];
            $proveedor->direccion = $datos['direccion'];
            $proveedor->telefono = $datos['telefono'];
            $proveedor->correo = $datos['correo'];
            $password_encriptada = Hash::make($datos['password']);
            $proveedor->password = $password_encriptada;
            $proveedor->update();
            
            return response()->json([
                "status" => 200,
                "detalle" => "Proveedor actualizado exitosamente",
            ]);

        } else {
            return response()->json('Necesitas rellenar todos los campos');
        }
    }

    public function EliminarProveedores(Request $request, $id){
        // $datos = array(
        //     "nombre" => $request->input('nombre'),
        //     "direccion" => $request->input('direccion'),
        //     "telefono" => $request->input('telefono'),
        //     "correo" => $request->input('correo'),
        //     "password" => $request->input('password'),
        // );

        if(empty($datos)){
            $proveedor = proveedores::find($id);
            if(empty($proveedor)){
                return response()->json([
                    "status" => 400,
                    "detalle" => 'Proveedor no existe',
                ]);
            }
            $proveedor->delete();
            // proveedores::where('id', '=', $id)->delete();

            // $proveedor->nombre = $datos['nombre'];
            // $proveedor->direccion = $datos['direccion'];
            // $proveedor->telefono = $datos['telefono'];
            // $proveedor->correo = $datos['correo'];
            // $password_encriptada = Hash::make($datos['password']);
            // $proveedor->password = $password_encriptada;

            return response()->json([
                "status" => 200,
                "detalle" => "Proveedor eliminado exitosamente",
            ]);

        } 
    }

    public function LogIn(Request $request){
        {
            $credentials = $request->validate([
                'correo' => 'required|email',
                'password' => 'required',
            ]);

            $proveedor = proveedores::where('correo', '=', $request->correo)->where('password', '=', $request->password)->first();
    
            if ($proveedor) {
                // $user = User::where('correo', $request->email)->first();
                $token = $proveedor->createToken('token-proveedor')->plainTextToken;
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        }
    }
}
