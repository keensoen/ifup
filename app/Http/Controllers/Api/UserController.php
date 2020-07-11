<?php

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    CONST HTTP_OK = Response::HTTP_OK;
    CONST HTTP_CREATED = Response::HTTP_CREATED;
    CONST HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;

   public function signIn(Request $request) {

	    $input = $this->validate($request, [
	        'username' => 'required|exists:users,username',
	        'password' => 'required|min:6',
	    ], [
	        'username.exists' => 'The user credentials were incorrect.',
	    ]);

	    request()->request->add([
	        'grant_type' => 'password',
	        'client_id' => env('PASSWORD_CLIENT_ID'),
	        'client_secret' => env('PASSWORD_CLIENT_SECRET'),
	        'username' => $input['username'],
	        'password' => $input['password'],
	    ]);

	    $response = Route::dispatch(Request::create('/oauth/token', 'POST'));
	    $data = json_decode($response->getContent(), true);
	    if (!$response->isOk()) {
	        return response()->json($data, 401);
	    }
	    return $data;
	}

	public function logout(Request $request) 
	{
		$request->user()->token()->revoke();
	}

    public function login(Request $request){ 

        $credentials = [

            'username' => $request->username, 
            'password' => $request->password

        ];
        if( auth()->attempt($credentials) ){ 

        $user = Auth::user();
        $userData = new UserResource($user); 

        $token['token'] = $this->get_user_token($user,"iFollowUpToken");

        $response = self::HTTP_OK;

        $data = [
            'token' => $token['token'],
            'user' => $userData
        ];
        

        return $this->get_http_response( "success", $data, $response );

        } else { 

        $error = "Unauthorized Access";

        $response = self::HTTP_UNAUTHORIZED;

        return $this->get_http_response( "Error", $error, $response );
        } 

    }

    public function get_user_details_info() 
    { 

        $user = Auth::user(); 
        $response =  self::HTTP_OK;

        return $user ? $this->get_http_response( "success", $user, $response )
                    : $this->get_http_response( "Unauthenticated user", $user, $response );

    } 

    public function get_http_response( string $status = null, $data = null, $response ){

        return response()->json([
        	'status'	=> $status,
        	'data'	=>	$data
        ], $response);
    }

    public function get_user_token( $user, string $token_name = null ) {

        return $user->createToken($token_name)->accessToken; 

    }

}
