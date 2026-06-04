<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function store(ContactRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $contact = $this->contactService->create($validated);
            
            return $this->success(
                $contact,
                'Your contact message has been sent successfully!',
                201 
            );
        } catch (\Exception $e) {
            Log::error('Client Contact Store Error: ' . $e->getMessage());
            return $this->error(
                'Failed to send contact message.',
                500
            );
        }
    }
}