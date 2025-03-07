<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Vouchers';
        $data = Voucher::orderBy('id', 'desc')->get();

        return view('vouchers', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
            'description' => 'required',
            'qty' => 'required',
        ]);

        Voucher::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'description' => $request->description,
            'qty' => $request->qty,
        ]);

        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
            'description' => 'required',
            'qty' => 'required',
        ]);

        Voucher::where('id', $voucher->id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'description' => $request->description,
            'qty' => $request->qty,
        ]);

        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully.');
    }

    // status voucher
    public function status(Request $request, Voucher $voucher)
    {
        $voucher->status = $request->status;
        $voucher->save();

        return redirect()->route('vouchers.index')->with('success', 'Voucher status updated successfully.');
    }
}
