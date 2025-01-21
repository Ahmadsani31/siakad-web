<?php

namespace App\Http\Resources;

use App\Http\Resources\MataKuliahResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'hari' => $this->hari,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'mata_kuliah' => new MataKuliahResource($this->mata_kuliah),
            'program_studi' => new ProgramStudiResource($this->program_studi),
            'tahun_akademik' => new TahunAkademikResource($this->tahun_akademik),
            'dosen' => new UserResource($this->dosen),
        ];
    }

    public function with($request)
    {
        return [
            "param" => true,
        ];
    }
}
