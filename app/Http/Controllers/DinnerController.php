<?php

namespace App\Http\Controllers;

use App\Models\Dinner;
use App\Models\DinnerInvite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
        $dinners = ( new Dinner )->whereDate( 'start_time', '>', Carbon::now() )->get();
        if ( $dinners->isNotEmpty() ) {
            return response()->json( $dinners );
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
        return response()->json( ( new Dinner )->create( array_merge( $request->all(), [ 'user_id' => $userId ] ) ), 201 );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show( $id ) {
        $dinner = $this->findDinner( $id );
        if ( $dinner != null ) {
            return response()->json( $dinner );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
    }

    /**
     * @param $id
     *
     * @return Dinner|Dinner[]|Collection|Model|null
     */
    private function findDinner( $id ) {
        return ( new Dinner )->find( $id );
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
        $dinner = $this->findDinner( $id );
        if ( $dinner != null ) {
            $dinner->update( $request->all() );

            return response()->json( $dinner );
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
        $dinner = $this->findDinner( $id );
        if ( $dinner != null ) {
            return response()->json( Dinner::destroy( $id ) );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
    }

}
