<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    protected ContactService $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }
    public function index(): JsonResponse
    {
        $contacts = $this->contactService->getAdminContacts();
        return $this->success($contacts, 'Retrieved contact list successfully.');
    }
    public function markAsRead($id): JsonResponse
    {
        $contact = $this->contactService->markAsRead($id);
        return $this->success($contact, 'Contact message marked as read.');
    }
    public function destroy($id): JsonResponse
    {
        $this->contactService->delete($id); 
        return $this->success(null, 'Contact message deleted successfully.');
    }
}