<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;

class OrderApiController extends Controller
{
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $request->validate([
                "email" => 'required|email'

            ]);

            $order = new Order();
            $order->email = $request->email;
            $order->saveOrFail();

            $idOrder = $order->id;

            $products = $request->input('products');
            if (count($products) <= 0) {
                return response()->json(['message' => 'Por favor, ingrese toda la información del producto']);
            }

            for ($i = 0; $i < count($products); $i++) {

                $productoActualizado = Product::find($products[$i]["id"]);

                $producto = new OrderProduct();
                $producto->order_id = $idOrder;
                $producto->product_id = $products[$i]["id"];
                $producto->price = $productoActualizado->price;
                $producto->quantity = $products[$i]["quantity"];

                if ($producto->quantity > $productoActualizado->inventory or $producto->quantity <= 0) {
                    return response()->json(['message' => '¡Error! Compruebe la cantidad ingresada']);
                }
                $producto->save();
                $productoActualizado->inventory -= $producto->quantity;
                $productoActualizado->save();
            }
            DB::commit();

            return response()->json(['message' => '¡Orden ingresada exitosamente!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => '¡Error! Compruebe la información ingresada'], 404);
        }
        return response()->json(['message' => 'Success'], 200);
    }

    public function index()
    {
        $orders = Order::with(['products'])->get();
        return response()->json($orders, 200);
    }

    public function getByEmail($email)
    {
        $orders = Order::with(['products'])
            ->where('email', $email)
            ->first();
        if (empty($orders)) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($orders, 200);
    }
}
