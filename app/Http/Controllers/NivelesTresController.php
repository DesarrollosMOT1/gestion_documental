<?php

namespace App\Http\Controllers;

use App\Models\NivelesTres;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\NivelesTresRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class NivelesTresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $nivelesTres = NivelesTres::paginate();

        return view('niveles-tres.index', compact('nivelesTres'))
            ->with('i', ($request->input('page', 1) - 1) * $nivelesTres->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $nivelesTre = new NivelesTres();

        return view('niveles-tres.create', compact('nivelesTre'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NivelesTresRequest $request): RedirectResponse
    {
        NivelesTres::create($request->validated());

        return Redirect::route('niveles-tres.index')
            ->with('success', 'NivelesTre created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $nivelesTre = NivelesTres::find($id);

        return view('niveles-tres.show', compact('nivelesTre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $nivelesTre = NivelesTres::find($id);

        return view('niveles-tres.edit', compact('nivelesTre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NivelesTresRequest $request, NivelesTres $nivelesTre): RedirectResponse
    {
        $nivelesTre->update($request->validated());

        return Redirect::route('niveles-tres.index')
            ->with('success', 'NivelesTre updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        NivelesTres::find($id)->delete();

        return Redirect::route('niveles-tres.index')
            ->with('success', 'NivelesTre deleted successfully');
    }
}