<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Code;
use App\Dni;
use App\Ruc;
use App\Query;
use App\Ubigeo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Peru\Sunat\RucFactory;
use Peru\Jne\DniFactory;
use Goutte\Client;
use App\Rules\Mac;

class ApiController extends Controller
{
	public function dni(Request $request, $code, $dni) {
		if ($request->user()->state=='0') {
			return response()->json(['status' => 401, 'message' => 'Este usuario esta desactivado.'], 401);
		}

		$code=Code::where('code', $code)->first();
		if (is_null($code)) {
			return response()->json(['status' => 404, "message" => "El código no existe."], 404);
		} elseif ($request->user()->id!=$code->user_id) {
			return response()->json(['status' => 403, "message" => "Este código no le pertenece a este usuario."], 403);
		} elseif ($code->state=='0') {
			return response()->json(['status' => 401, "message" => "Este código ha sido desactivado."], 401);
		} elseif (!is_null($code->limit) && $code->queries>=$code->limit) {
			return response()->json(['status' => 401, "message" => "Se ha alcanzado el límite de consultas."], 401);
		}

		Validator::make(['dni' => $dni, 'mac' => request('mac')], [
			'dni' => 'required|digits:8',
			'mac' => ['required', new Mac()]
		])->validate();

		if (is_null($code->mac)) {
			$code->fill(['mac' => request('mac')])->save();
		} elseif($code->mac!=request('mac')) {
			return response()->json(['status' => 403, "message" => "No tienes permiso para acceder a la información."], 403);
		}

		$dni_exist=Dni::where('dni', $dni)->first();
		if (is_null($dni_exist)) {
			try {
				$dni_factory=new DniFactory();
				$query_factory=$dni_factory->create();
				$person=$query_factory->get($dni);

				if (!is_null($person)) {
					$data=array('dni' => $person->dni, 'name' => $person->nombres, 'first_lastname' => $person->apellidoPaterno, 'second_lastname' => $person->apellidoMaterno, 'code' => $person->codVerifica);
					Dni::create($data);
					$code->fill(['queries' => $code->queries+1])->save();

					$query=Query::where([['type', '1'], ['code_id', $code->id]])->first();
					if (!is_null($query)) {
						$query->fill(['queries' => $query->queries+1])->save();
					}

					$data=array('dni' => $person->dni, 'nombres' => $person->nombres, 'apellidopaterno' => $person->apellidoPaterno, 'apellidomaterno' => $person->apellidoMaterno, 'codverifica' => $person->codVerifica);
					return response()->json(['status' => 200, "data" => $data], 200);
				}
			} catch (Exception $e) {
				Log::error($e->getMessage());
			}

			try {
				$client=new Client();
				$crawler=$client->request('GET', 'https://eldni.com/pe/buscar-por-dni');
				$form=$crawler->selectButton('Buscar nombres')->form();
				$crawler=$client->submit($form, ['dni' => $dni]);

				$data=$crawler->filter("table tbody td")->each(function($dataNodes) {
					return $dataNodes->text();
				});
				if (is_array($data)) {
					$data=array('dni' => $data[0], 'name' => $data[1], 'first_lastname' => $data[2], 'second_lastname' => $data[3]);
					Dni::create($data);
					$code->fill(['queries' => $code->queries+1])->save();

					$query=Query::where([['type', '1'], ['code_id', $code->id]])->first();
					if (!is_null($query)) {
						$query->fill(['queries' => $query->queries+1])->save();
					}

					$data=array('dni' => $data[0], 'nombres' => $data[1], 'apellidopaterno' => $data[2], 'apellidomaterno' => $data[3]);
					return response()->json(['status' => 200, "data" => $data], 200);
				}

			} catch (Exception $e) {
				Log::error($e->getMessage());
			}

			return response()->json(['status' => 404, "message" => "Ha ocurrido un error, intentelo nuevamente."], 404);
		}

		$code->fill(['queries' => $code->queries+1])->save();
		$query=Query::where([['type', '1'], ['code_id', $code->id]])->first();
		if (!is_null($query)) {
			$query->fill(['queries' => $query->queries+1])->save();
		}

		$data=array('dni' => $dni_exist->dni, 'nombres' => $dni_exist->name, 'apellidopaterno' => $dni_exist->first_lastname, 'apellidomaterno' => $dni_exist->second_lastname);
		if (!is_null($dni_exist->code)) {
			$data=array('dni' => $dni_exist->dni, 'nombres' => $dni_exist->name, 'apellidopaterno' => $dni_exist->first_lastname, 'apellidomaterno' => $dni_exist->second_lastname, 'codverifica' => $dni_exist->code);
		}
		return response()->json(['status' => 200, "data" => $data], 200);
	}

	public function ruc(Request $request, $code, $ruc) {
		if ($request->user()->state=='0') {
			return response()->json(['status' => 401, 'message' => 'Este usuario esta desactivado.'], 401);
		}

		$code=Code::where('code', $code)->first();
		if (is_null($code)) {
			return response()->json(['status' => 404, "message" => "El código no existe."], 404);
		} elseif ($request->user()->id!=$code->user_id) {
			return response()->json(['status' => 403, "message" => "Este código no le pertenece a este usuario."], 403);
		} elseif ($code->state=='0') {
			return response()->json(['status' => 401, "message" => "Este código ha sido desactivado."], 401);
		} elseif (!is_null($code->limit) && $code->queries>=$code->limit) {
			return response()->json(['status' => 401, "message" => "Se ha alcanzado el límite de consultas."], 401);
		}

		Validator::make(['ruc' => $ruc, 'mac' => request('mac')], [
			'ruc' => 'required|digits:11',
			'mac' => ['required', new Mac()]
		])->validate();

		if (is_null($code->mac)) {
			$code->fill(['mac' => request('mac')])->save();
		} elseif($code->mac!=request('mac')) {
			return response()->json(['status' => 403, "message" => "No tienes permiso para acceder a la información."], 403);
		}

		$ruc_exist=Ruc::where('ruc', $ruc)->first();
		if (is_null($ruc_exist)) {
			try {
				$ruc_factory=new RucFactory();
				$query_factory=$ruc_factory->create();
				$company=$query_factory->get($ruc);

				if (!is_null($company)) {
					$code->fill(['queries' => $code->queries+1])->save();

					$query=Query::where([['type', '2'], ['code_id', $code->id]])->first();
					if (!is_null($query)) {
						$query->fill(['queries' => $query->queries+1])->save();
					}

					$ubigeo=Ubigeo::where([['department', $company->departamento], ['province', $company->provincia], ['district', $company->distrito]])->first();
					$ubigeo=(!is_null($ubigeo)) ? $ubigeo->code : "";

					$data=array('ruc' => $company->ruc, 'razonsocial' => $company->razonSocial, 'estado' => $company->estado, 'condicion' => $company->condicion, 'direccion' => $company->direccion, 'departamento' => $company->departamento, 'provincia' => $company->provincia, 'distrito' => $company->distrito, 'ubigeo' => $ubigeo);
					return response()->json(['status' => 200, "data" => $data], 200);
				}
			} catch (Exception $e) {
				Log::error($e->getMessage());
			}

			try {
				$client=new Client();
				$crawler=$client->request('GET', 'https://www.wmtechnology.org/Consultar-RUC');
				$form=$crawler->selectButton('Buscar')->form();
				$crawler=$client->submit($form, ['nruc' => $ruc]);

				$data=$crawler->filter("div[class='list-group'] div[class~='list-group-item']")->each(function($dataNodes) {
					return $dataNodes->filter("div[class='col-sm-7']")->text();
				});

				if (is_array($data)) {
					$code->fill(['queries' => $code->queries+1])->save();

					$query=Query::where([['type', '1'], ['code_id', $code->id]])->first();
					if (!is_null($query)) {
						$query->fill(['queries' => $query->queries+1])->save();
					}

					$data=array('ruc' => $ruc, 'razonsocial' => substr($data[0], 14), 'estado' => $data[1], 'condicion' => $data[2], 'direccion' => $data[7], 'departamento' => $data[4], 'provincia' => $data[5], 'distrito' => $data[6], 'ubigeo' => $data[3]);
					return response()->json(['status' => 200, "data" => $data], 200);
				}

			} catch (Exception $e) {
				Log::error($e->getMessage());
			}

			return response()->json(['status' => 404, "message" => "No se encontró al cliente."], 404);
		}

		$ubigeo=Ubigeo::where('code', $ruc_exist->ubigeo)->first();

		$condition=(!is_null($ruc_exist->condition) && !empty($ruc_exist->condition)) ? $ruc_exist->condition : "";
		$department=(!is_null($ubigeo)) ? $ubigeo->department : "";
		$province=(!is_null($ubigeo)) ? $ubigeo->province : "";
		$district=(!is_null($ubigeo)) ? $ubigeo->district : "";
		$ubigeo=(!is_null($ubigeo)) ? $ubigeo->code : "";

		$type_way=(!is_null($ruc_exist->type_way) && !empty($ruc_exist->type_way)) ? $ruc_exist->type_way." " : "";
		$name_way=(!is_null($ruc_exist->name_way) && !empty($ruc_exist->name_way)) ? $ruc_exist->name_way." " : "";
		$number=(!is_null($ruc_exist->number) && !empty($ruc_exist->number)) ? "NRO. ".$ruc_exist->number." " : "";
		$inside=(!is_null($ruc_exist->inside) && !empty($ruc_exist->inside)) ? "INT. ".$ruc_exist->inside." " : "";
		$dpto=(!is_null($ruc_exist->department) && !empty($ruc_exist->department)) ? "DPTO. ".$ruc_exist->department." " : "";
		$zone_code=(!is_null($ruc_exist->zone_code) && !empty($ruc_exist->zone_code)) ? $ruc_exist->zone_code." " : "";
		$type_zone=(!is_null($ruc_exist->type_zone) && !empty($ruc_exist->type_zone)) ? $ruc_exist->type_zone." " : "";
		$block=(!is_null($ruc_exist->block) && !empty($ruc_exist->block)) ? "MZ. ".$ruc_exist->block." " : "";
		$lot=(!is_null($ruc_exist->lot) && !empty($ruc_exist->lot)) ? "LOTE. ".$ruc_exist->lot." " : "";
		$km=(!is_null($ruc_exist->km) && !empty($ruc_exist->km)) ? "KM. ".$ruc_exist->km." " : "";
		if (!is_null($ruc_exist->number) && !empty($ruc_exist->number)) {
			$address=$type_way.$name_way.$number.$inside.$dpto.$zone_code.$type_zone.$block.$lot.$km;
		} else {
			$address=$type_way.$name_way.$block.$lot.$km.$inside.$dpto.$zone_code.$type_zone;
		}

		$spacing=substr($address, -1);
		if ($spacing==" ") {
			$address=substr($address, 0, -1);
		}

		$data=array('ruc' => $ruc_exist->ruc, 'razonsocial' => $ruc_exist->name, 'estado' => $ruc_exist->state, 'condicion' => $condition, 'direccion' => $address, 'departamento' => $department, 'provincia' => $province, 'distrito' => $district, 'ubigeo' => $ubigeo);
		$code->fill(['queries' => $code->queries+1])->save();

		$query=Query::where([['type', '2'], ['code_id', $code->id]])->first();
		if (!is_null($query)) {
			$query->fill(['queries' => $query->queries+1])->save();
		}

		return response()->json(['status' => 200, "data" => $data], 200);
	}
}