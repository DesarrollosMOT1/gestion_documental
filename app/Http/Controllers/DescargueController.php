<?php

namespace App\Http\Controllers;

use App\Models\Descargue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DescargueRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DescargueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $descargues = Descargue::paginate();

        return view('descargue.index', compact('descargues'))
            ->with('i', ($request->input('page', 1) - 1) * $descargues->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $descargue = new Descargue();

        return view('descargue.create', compact('descargue'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DescargueRequest $request): RedirectResponse
    {
        Descargue::create($request->validated());

        return Redirect::route('descargues.index')
            ->with('success', 'Descargue created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $descargue = Descargue::find($id);

        return view('descargue.show', compact('descargue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $descargue = Descargue::find($id);

        return view('descargue.edit', compact('descargue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DescargueRequest $request, Descargue $descargue): RedirectResponse
    {
        $descargue->update($request->validated());

        return Redirect::route('descargues.index')
            ->with('success', 'Descargue updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Descargue::find($id)->delete();

        return Redirect::route('descargues.index')
            ->with('success', 'Descargue deleted successfully');
    }
}
