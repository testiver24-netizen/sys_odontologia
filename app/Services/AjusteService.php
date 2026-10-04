<?php

namespace App\Services;

use App\Models\Ajuste;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AjusteService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        
    }
     public function guardar(array $data, ?UploadedFile $logo = null): Ajuste
    {
        $ajuste = Ajuste::first() ?? new Ajuste();

        if ($logo) {
            $this->eliminarLogo($ajuste);
            $data['url_logo'] = $logo->store('logos', 'public');
        } else {
            unset($data['url_logo']);
        }

        $ajuste->fill($data)->save();

        return $ajuste;
    }

    private function eliminarLogo(Ajuste $ajuste): void
    {
        if ($ajuste->url_logo && Storage::disk('public')->exists($ajuste->url_logo)) {
            Storage::disk('public')->delete($ajuste->url_logo);
        }
    }
}
