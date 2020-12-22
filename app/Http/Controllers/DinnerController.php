<?php

namespace App\Http\Controllers;

use App\Models\Dinner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DinnerController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $dinners = Dinner::all();
        if ( $dinners->isNotEmpty() ) {
            return response( Dinner::all() );
        }
        throw new NotFoundHttpException( 'No dinners found.' );
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
        $userId    = auth( 'api' )->user()->id;

        return response( ( new Dinner )->create( array_merge( $request->all(), [ 'user_id' => $userId ] ) ) );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show( $id ) {
        $dinner = ( new Dinner )->find( $id );
        if ( $dinner != null ) {
            return response( $dinner );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
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
        if ( $dinner != null ) {
            $dinner->update( $request->all() );

            return response( $dinner );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy( $id ) {
        $dinner = ( new Dinner )->find( $id );
        if ( $dinner != null ) {
            return response( Dinner::destroy( $id ) );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
    }



}
