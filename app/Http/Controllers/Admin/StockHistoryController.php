<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\StockHistory\StockHistoryStoreRequest;
use App\Http\Requests\Admin\StockHistory\StockHistoryUpdateRequest;

class StockHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $stockHistories = StockHistory::all();

        return view('stockHistory.index', compact('stockHistories'));
    }

    public function create(Request $request): View
    {
        return view('stockHistory.create');
    }

    public function store(StockHistoryStoreRequest $request): RedirectResponse
    {
        $stockHistory = StockHistory::create($request->validated());

        $request->session()->flash('stockHistory.id', $stockHistory->id);

        return redirect()->route('stockHistory.index');
    }

    public function show(Request $request, StockHistory $stockHistory): View
    {
        return view('stockHistory.show', compact('stockHistory'));
    }

    public function edit(Request $request, StockHistory $stockHistory): View
    {
        return view('stockHistory.edit', compact('stockHistory'));
    }

    public function update(StockHistoryUpdateRequest $request, StockHistory $stockHistory): RedirectResponse
    {
        $stockHistory->update($request->validated());

        $request->session()->flash('stockHistory.id', $stockHistory->id);

        return redirect()->route('stockHistory.index');
    }

    public function destroy(Request $request, StockHistory $stockHistory): RedirectResponse
    {
        $stockHistory->delete();

        return redirect()->route('stockHistory.index');
    }
}
