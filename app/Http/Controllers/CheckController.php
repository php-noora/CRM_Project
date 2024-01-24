<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckRequest;
use App\Models\Check;
use App\Models\Factor;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function create()
    {
        $orders = Order::all();
        return view('checks.addCheck', ['orders' => $orders]);

    }

    public function index()
    {

        $checks = Factor::all();
        return view('checks.checksData', ['checks' => $checks]);

    }

    public function store(CheckRequest $request)
    {
        Factor::create([
            'order_id' => $request->order_id,
            'total_price'=>$request->total_pay,
            'title' => $request->title,

        ]);
        return redirect()->route('check.index');
    }

    public function edit(string $id)
    {
        $checks = Factor::find($id);
        return view('checks.editCheckMenue', ['check' => $checks]);
    }

    public function update(CheckRequest $request, $id)
    {
        Factor::where('id', $id)->update([
            'title' => $request->title,
        ]);
        return redirect()->route('check.index');
    }

    public function destroy( $id)
    {
        $product = Factor::find($id);
        $product->delete();
        return back();
    }
}
