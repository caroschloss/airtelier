<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response|View
     */
    public function index()
    {
        $locations = Location::all();
        if (request()->ajax()) {
            return response()->json($locations,200,[],JSON_UNESCAPED_UNICODE);
        }

        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param LocationRequest $request
     * @return Response
     */
    public function store(LocationRequest $request): Response
    {
        Location::create($request->toArray());

        if (request()->ajax()) {
            return response()->json('success', 200);
        }

        return response()->redirectToRoute('locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Location  $location
     * @return Response
     */
    public function show(Location $location): Response
    {
        return view('locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location  $location
     * @return Response
     */
    public function edit(Location $location): Response
    {
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LocationRequest $request
     * @param Location  $location
     * @return Response
     */
    public function update(LocationRequest $request, Location $location): Response
    {
        $location->fill($request->toArray());
        $location->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Location $location
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()->route('locations.index');
    }
}