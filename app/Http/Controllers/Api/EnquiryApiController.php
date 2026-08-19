<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnquiryApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'phone' => 'required|string|min:10|max:20',
            'email' => 'nullable|email|max:100',
            'company' => 'nullable|string|max:150',
            'type' => 'nullable|string|in:general,service,product,promotion,amc',
            'service_id' => 'nullable|exists:services,id',
            'product_id' => 'nullable|exists:products,id',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|min:5|max:2000',
            'urgency' => 'nullable|string|in:normal,urgent,emergency',
            'preferred_contact' => 'nullable|string|in:phone,whatsapp,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['status'] = 'pending';
        $data['ip_address'] = $request->ip();

        $enquiry = Enquiry::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Enquiry submitted successfully. A representative will contact you shortly.',
            'ticket_number' => $enquiry->ticket_number,
            'data' => $enquiry,
        ], 201);
    }
}
