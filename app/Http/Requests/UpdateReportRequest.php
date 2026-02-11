<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'disaster_type_id' => 'sometimes|required|exists:disaster_types,id',
            'description' => 'sometimes|required|string|min:10',
            'location_address' => 'sometimes|required|string|min:10',
            'incident_date' => 'sometimes|required|date|before_or_equal:now',
            'urgency_level' => 'sometimes|required|in:low,medium,high,critical',
            'victim_count' => 'nullable|integer|min:0',
            'damage_description' => 'nullable|string',
            'contact_phone' => 'sometimes|required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'disaster_type_id.required' => 'Jenis bencana wajib dipilih',
            'disaster_type_id.exists' => 'Jenis bencana tidak valid',
            'description.required' => 'Deskripsi kejadian wajib diisi',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'location_address.required' => 'Alamat lokasi wajib diisi',
            'location_address.min' => 'Alamat minimal 10 karakter',
            'incident_date.required' => 'Tanggal kejadian wajib diisi',
            'incident_date.date' => 'Format tanggal tidak valid',
            'incident_date.before_or_equal' => 'Tanggal kejadian tidak boleh di masa depan',
            'urgency_level.required' => 'Tingkat urgensi wajib dipilih',
            'urgency_level.in' => 'Tingkat urgensi tidak valid',
            'victim_count.integer' => 'Jumlah korban harus berupa angka',
            'victim_count.min' => 'Jumlah korban tidak boleh negatif',
            'contact_phone.required' => 'Nomor telepon wajib diisi',
            'contact_phone.max' => 'Nomor telepon maksimal 20 karakter',
        ];
    }
}