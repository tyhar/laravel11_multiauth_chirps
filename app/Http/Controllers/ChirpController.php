<?php

namespace App\Http\Controllers;


use App\Models\Chirp;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Gate;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //fetching the chirp records with latest order or descending order and then passed into Index.vue with inertia return
        return inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->latest()->get(),
        ]);
        // 'Chirps/Index' refer to location of 'Index.vue' start inside js/Pages folder
        // ::with method used to load the relation property or attribute of related model in this case id and name attribute of 'user' model
        // 'chirps' is the key that being passed into the .vue alongside with value that has been assigned.
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
    public function store(Request $request): RedirectResponse
    {
        //
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
        
        $request->user()->chirps()->create($validated);

        //from inertia
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);
 
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
}
