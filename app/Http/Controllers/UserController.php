<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller {

    public function create( Request $request ) {
        $validRequest = $this->isValidCreate( $request );
        $user         = ( new User )->fill( [
            'name'     => $validRequest['name'],
            'email'    => $validRequest['email'],
            'password' => Hash::make( $validRequest['password'] )
        ] );
        $accessToken  = $user->createToken( 'authToken' )->accessToken;
        $user->save();
        return response( [ 'status' => 'success', 'user' => $user, 'access_token' => $accessToken ], 201 );
    }

    private function isValidCreate( Request $request ): array {
        return $request->validate( [
            'name'     => 'required|string',
            'email'    => 'required|string|unique:users,email',
            'password' => 'required|string'
        ] );
    }

    public function login( Request $request ) {
        $validRequest = $this->isValidLogin( $request );
        if ( Auth::attempt( $validRequest ) ) {
            $accessToken = Auth::user()->createToken( 'authToken' )->accessToken;

            return response( [ 'status' => 'success', 'user' => Auth::user(), 'access_token' => $accessToken ] );
        }
        throw new AuthenticationException( 'Invalid login credentials.' );
    }

    private function isValidLogin( Request $request ): array {
        return $request->validate( [
            'email'    => 'required|string',
            'password' => 'required|string'
        ] );
    }

    public function show( $id ) {
        $user = $this->findUser( $id );
        if ( $user != null ) {
            return response( $user );
        }
        throw new NotFoundHttpException( 'User not found.' );
    }

    /**
     * @param $id
     *
     * @return User|User[]|Collection|Model|null
     */
    private function findUser( $id ) {
        return ( new User )->find( $id );
    }

    public function update( Request $request, $id ) {
        $user = $this->findUser( $id );
        if ( $user != null ) {
            $user->update( $request->all() );

            return response( $user );
        }
        throw new NotFoundHttpException( 'User not found.' );
    }
}
