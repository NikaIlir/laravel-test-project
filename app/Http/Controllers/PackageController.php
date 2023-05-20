<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;

class PackageController extends BaseController
{
    /**
     * Display a listing of the packages.
     */
    public function index(): JsonResponse
    {
        $packages = Package::get()->map(function ($package) {
            $registrationCount = Registration::where('package_id', $package->id)->count();
            $package->is_available = $registrationCount < $package->limit;
            return [
                'uuid' => $package->uuid,
                'name' => $package->name,
                'is_available' => $package->is_available,
            ];
        });

        return $this->success($packages, 'List of packages', 200);
    }
}
