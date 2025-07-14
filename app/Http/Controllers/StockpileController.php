<?php

namespace App\Http\Controllers;

use App\Models\Stockpile;
use App\Http\Requests\StoreStockpileRequest;
use App\Http\Requests\UpdateStockpileRequest;

class StockpileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('weapons.stockpile.index');
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
    public function store(StoreStockpileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stockpile $stockpile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stockpile $stockpile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockpileRequest $request, Stockpile $stockpile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stockpile $stockpile)
    {
        //
    }
}
