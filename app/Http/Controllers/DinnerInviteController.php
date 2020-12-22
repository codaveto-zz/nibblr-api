<?php

namespace App\Http\Controllers;

use App\Models\Dinner;
use App\Models\DinnerInvite;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DinnerInviteController extends Controller {
    public function joinDinner( $dinnerId ) {
        $dinner = ( new Dinner )->find( $dinnerId );
        if ( $dinner != null ) {
            $hasStarted = Carbon::parse( $dinner->start_time )->isBefore( Carbon::now() );
            if ( ! $hasStarted ) {
                $numberOfGuests = $dinner->users()->get()->count();
                $roomForMore   = $numberOfGuests < $dinner->max_guests;
                if ( $roomForMore ) {
                    $userId           = auth( 'api' )->user()->id;
                    $alreadyInvited = $dinner->users()->where( 'user_id', $userId )->first() != null;
                    if ( ! $alreadyInvited ) {
                        $invite = ( new DinnerInvite )->create( [
                            'dinner_id' => $dinnerId,
                            'user_id'   => $userId
                        ] );

                        return response( $invite );
                    }

                    return $this->sendErrorMessage( 'You already joined this dinner.' );
                }

                return $this->sendErrorMessage( 'This dinner is already full.' );
            }

            return $this->sendErrorMessage( 'This dinner has already started.' );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
    }

    private function sendErrorMessage( $message ) {
        $code = 409;

        return response( [
            'status'  => 'failed',
            'code'    => $code,
            'message' => $message,
        ], $code );
    }

    public function getAllUsers( $dinnerId ) {
        $dinner = ( new Dinner )->find( $dinnerId );
        if ( $dinner != null ) {
            $users = $dinner->users()->get();

            return response( $users );
        }
        throw new NotFoundHttpException( 'Dinner not found.' );
    }

}
