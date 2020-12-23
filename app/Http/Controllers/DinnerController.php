<?php

namespace App\Http\Controllers;

use App\Models\Dinner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DinnerController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return response( Dinner::all() );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store( Request $request ) {
        $validated = $request->validate( [
            'title'       => 'required|string',
            'description' => 'required|string',
            'max_guests'  => 'min:1|integer',
            'start_time'  => 'after:now|date',
            'end_time'    => 'after:start_time|date'
        ] );

        return response( ( new Dinner )->create( $request->all() ) );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show( $id ) {
        return response( ( new Dinner )->find( $id ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function update( Request $request, $id ) {
        $dinner = ( new Dinner )->find( $id );
        $dinner->update( $request->all() );

        return response( $dinner );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy( $id ) {
        return response( Dinner::destroy( $id ) );
    }
}
