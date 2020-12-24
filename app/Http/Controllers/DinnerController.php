<?php

namespace App\Http\Controllers;

use App\Models\Dinner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DinnerController extends Controller {
    public function index() {
        $dinners = ( new Dinner )->whereDate( 'start_time', '>', Carbon::now() )->get();
        if ( $dinners->isNotEmpty() ) {
            return response()->json( $dinners );
        }
        throw new NotFoundHttpException( 'No dinners found.' );
    }

    public function store( Request $request ) {
        $validated = $request->validate( [
            'title'       => 'required|string',
            'description' => 'required|string',
            'max_guests'  => 'required|min:1|integer',
            'start_time'  => 'required|after:now|date',
            'end_time'    => 'required|after:start_time|date'
        ] );
        $userId    = auth( 'api' )->user()->id;

        return response()->json( ( new Dinner )->create( array_merge( $validated, [ 'user_id' => $userId ] ) ), 201 );
    }

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

    public function update( Request $request, $id ) {
        $dinner = $this->findDinner( $id );
        if ( $dinner != null ) {
            $dinner->update( $request->all() );

            return response()->json( $dinner );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
    }

    public function destroy( $id ) {
        $dinner = $this->findDinner( $id );
        if ( $dinner != null ) {
            return response()->json( Dinner::destroy( $id ) );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
    }

}
