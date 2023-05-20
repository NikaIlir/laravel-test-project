<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Registration;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class RegistrationController extends BaseController
{
    /**
     * Store a newly created registration in storage.
     */
    public function store(Package $package): ?JsonResponse
    {
        try {
            $registration = Registration::firstOrNew([
                'user_id' => auth()->user()->id,
                'package_id' => $package->id
            ]);

            if ($registration->exists) {
                return $this->error('You have already been registered');
            }

            if (Registration::where('package_id', $package->id)->count() >= $package->limit) {
                return $this->error('Limit is reached');
            }

            $registration->fill(['registered_at' => now()]);
            $registration->save();

            return $this->success(
                ['uuid' => $registration->uuid],
                'Successfully registered',
                201
            );
        } catch (ModelNotFoundException $e) {
            return $this->error('No such package exists.');
        }
    }
}
