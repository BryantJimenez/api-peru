<?php

namespace App\Http\Controllers\Api;

use App\Mac;
use App\User;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ApiLoginRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class AuthController extends ApiController
{
	public function login(ApiLoginRequest $request) {
		$user=User::where('email', request('email'))->first();
		$credentials=request(['email', 'password']);
		if ($user->state==0) {
			return response()->json(['status' => 403, 'message' => 'Este usuario no tiene permitido ingresar.'], 403);
		} elseif(Auth::attempt($credentials)) {

			$user=$request->user();
			$tokenResult=$user->createToken('Personal Access Token');

			$token=$tokenResult->token;
			if (!is_null(request('remember'))) {
				$token->expires_at=Carbon::now()->addMonth();
			}
			$token->save();

			$code=$request->user()->codes()->with(['macs'])->where('code', request('code'))->first();
			if (!is_null($code) && !is_null($code['macs']) && $code['macs']->where('mac', request('mac'))->count()==0) {
				if ($code->qty_mac>$code['macs']->count()) {
					Mac::create(['mac' => request('mac'), 'code_id' => $code->id]);
				}
			}

			return response()->json(['status' => 200, 'access_token' => $tokenResult->accessToken, 'token_type' => 'Bearer', 'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()]);
		}
		
		return response()->json(['status' => 401, 'message' => 'Las credenciales no coinciden.'], 401);
	}

	public function logout(Request $request) {
		$request->user()->token()->revoke();
		return response()->json(['status' => 200, 'message' => 'La sesión ha sido cerrada exitosamente.'], 200);
	}
}
