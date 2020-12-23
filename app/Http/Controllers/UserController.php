<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function PHPUnit\Framework\throwException;

class UserController extends Controller {

    public function create( Request $request ) {
        $validRequest = $this->isValidCreate( $request );
        $user         = ( new User )->create( $validRequest );
        $accessToken  = $user->createToken( 'authToken' )->accessToken;
        return response( ['status'=> 'success', 'user' => $user, 'access_token' => $accessToken ] );
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
        throw new AuthenticationException('Invalid login credentials.');
    }

    private function isValidLogin( Request $request ): array {
        return $request->validate( [
            'email'    => 'required|string',
            'password' => 'required|string'
        ] );
    }

    public function show( $id ) {
        $user = ( new User )->find( $id );
        if ( $user != null ) {
        return response( $user );
        }
        throw new NotFoundHttpException('User not found');
    }

    public function update( Request $request, $id ) {
        $user = ( new User )->find( $id );
        if ( $user != null ) {
            $user->update( $request->all() );
            return response( $user );
        }
        throw new NotFoundHttpException('User not found');
    }
}
