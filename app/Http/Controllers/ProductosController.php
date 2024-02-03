<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\proveedores;
use App\Models\Productos;

class ProductosController extends Controller
{
    public function Index(Request $request){
        $token = $request->header('Authorization');

        $proveedores = proveedores::all();

        foreach($proveedores as $proveedor){
            $credenciales = base64_encode($proveedor['correo']. ":" . $proveedor['password']);
 
            $token_esperado = "Basic " . $credenciales;
            if($token === $token_esperado){

                $producto = Productos::join('proveedores', 'productos.id_proveedor', '=', 'proveedores.id')->select('productos.*', 'proveedores.nombre as proveedor')->where('proveedores.id', '=', $proveedor['id'])->get();
                return response()->json([
                    "status" => 200,
                    "total_productos" => count($producto),
                    "detalle" => $producto,
                ]);
            }
        }

        return response()->json([
            "status" => 400,
            "detalle" => "Credenciales no válidas, intente de nuevo",
        ]);
    }

    public function RegistrarProducto(Request $request){
        $token = $request->header('Authorization');

        $proveedores = proveedores::all();

        foreach($proveedores as $proveedor){
            $credenciales = base64_encode($proveedor['correo']. ":" .$proveedor['password']);
            $token_esperado = "Basic " . $credenciales;

            if($token === $token_esperado){

                $datos = array(
                    "nombre" => $request->input('nombre'),
                    "descripcion" => $request->input('descripcion'),
                    "precio" => $request->input('precio'),
                    "marca" => $request->input('marca'),
                    "stock" => $request->input('stock'),
                );

                if($request->hasFile('imagen')){ //true
                    //guardar la imagen
                    $imagen = $request->file('imagen'); //
                    //formateamos el nombre la imagen
                    //Str::slug("computadora-ASUS.svg")
                    $nombre_imagen = Str::slug($request->post('nombre')).".".
                    $imagen->guessExtension();
 
                    //asignamos la ruta donde vamos a guardar la imagen (local)
                    $ruta = public_path("img/");  //public/img
 
                    //copiar la imagen a la ruta
                    copy($imagen->getRealPath(),$ruta.$nombre_imagen);
                    //public/img/computadora-ASUS.png
                }else{
                    $nombre_imagen = null;
                }

                $producto = new Productos();
                $producto->nombre = $datos['nombre'];
                $producto->descripcion = $datos['descripcion'];
                $producto->precio = $datos['precio'];
                $producto->marca = $datos['marca'];
                $producto->stock = $datos['stock'];
                $producto->imagen = $nombre_imagen;
                $producto->id_proveedor = $proveedor['id'];
                $producto->save();

                return response()->json([
                    "status" => 200,
                    "detalle" => 'Se ha registrado exitosamente',
                ]);
            }

        }

        return response()->json([
            "status" => 400,
            "detalle" => "Credenciales no válidas, intente de nuevo",
        ]);
    }

    public function BusquedaNombre($busqueda){
        $producto = Productos::join('proveedores','productos.id_proveedor', '=', 'proveedores.id')->select('productos.nombre', 'productos.descripcion', 'productos.precio', 'productos.imagen', 'proveedores.nombre as proveedor')->where('productos.nombre', 'LIKE', '%' . $busqueda . '%')->get();

        if(count($producto) > 0){
            return response()->json([
                "status" => 200,
                "total_productos" => count($producto),
                "detalle" => $producto,
            ]);
        }

        return response()->json([
            "status" => 400,
            "detalle" => 'Producto no encontrado'
        ]);
        
    }

    public function ObtenerPrecio(){
        $producto = Productos::join('proveedores', 'productos.id_proveedor', '=', 'proveedores.id')->select('productos.*', 'proveedores.nombre as proveedor', 'proveedores.direccion')->where('productos.precio', '>', 100)->get();

        return response()->json([
            "status" => 200,
            "detalle" => $producto,
        ]);
    }

}
