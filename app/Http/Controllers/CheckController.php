<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckRequest;
use App\Models\Check;
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

        $checks = Check::all();
        return view('checks.checksData', ['checks' => $checks]);

    }

    public function store(CheckRequest $request)
    {
        Check::create([
            'order_id' => $request->order_id,
            'name' => $request->title,

        ]);
        return redirect()->route('check.index');
    }

    public function edit(string $id)
    {
        $checks = check::find($id);
        return view('checks.editCheckMenue', ['check' => $checks]);
    }

    public function update(CheckRequest $request, $id)
    {
        check::where('id', $id)->update([
            'title' => $request->title,
        ]);
        return redirect()->route('check.index');
    }

    public function destroy( $id)
    {
        $product = check::find($id);
        $product->delete();
        return back();
    }
}
