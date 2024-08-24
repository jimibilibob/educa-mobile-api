<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class StoreLeaveRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->checkBearerToken();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.requesterName' => ['required', 'string', 'max:100'],
            'data.idestudiante' => ['required', 'string', 'max:100'],
            'data.reason' => ['required', 'string', 'max:100'],
            'data.ci' => ['required', 'string', 'max:100'],
            'data.kinship' => ['required', 'string', 'max:100'],
            'data.startDate' => ['required'],
            'data.endDate' => ['required'],
            'data.typeId' => ['required', 'string', 'exists:leave_request_types,id'],
            'data.nombre' => ['required', 'string'],
            'data.idcurso' => ['required', 'string'],
            'data.codestudiante' => ['required', 'string'],
            'data.curso' => ['required', 'string'],
            'data.teachersId' => ['required', 'array', 'min:0'],
            'data.imei' => ['required', 'string']
        ];
    }

    public function attributes()
    {
        return [
            'data.requesterName' => 'nombre solicitante',
            'data.idestudiante' => 'id de estudiante',
            'data.reason' => 'observación',
            'data.ci' => 'carnet de identidad',
            'data.kinship' => 'parentesco',
            'data.startedAt' => 'fecha inicial',
            'data.endedAt' => 'fecha final',
            'data.typeId' => 'tipo de licencia',
            'data.nombre' => 'nombre del estudiante',
            'data.idcurso' => 'id del curso',
            'data.codestudiante' => 'codigo estudiante',
            'data.curso' => 'curso',
            'data.imei' => 'imei'
        ];
    }

    public function checkBearerToken(): bool {
        $parser = new Parser(new JoseEncoder());
        $token = $parser->parse($this->bearerToken());
        $imei = $token->claims()->get('dispositivo')['imei'];
        $reqImei = $this->request->all()['data']['imei'];
        return $imei === $reqImei;
    }
}
