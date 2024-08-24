<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'requesterName' => $this->requesterName,
            'idestudiante' => $this->idestudiante,
            'ci' => $this->ci,
            'reason' => $this->reason,
            'kinship' => $this->kinship,
            'endDate' => $this->endDate,
            'startDate' => $this->startDate,
            'typeName' => $this->type->name,
            'typeId' => $this->typeId,
            'nombre' => $this->nombre,
            'idcurso' => $this->idcurso,
            'codestudiante' => $this->cod_estudiante,
            'curso' => $this->curso
        ];
    }
}
