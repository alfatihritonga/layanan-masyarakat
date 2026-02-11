<?php

namespace App\Http\Requests;

use App\Rules\MediaFile;
use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'disaster_type_id' => 'required|exists:disaster_types,id',
            'description' => 'required|string|min:10',
            'location_address' => 'required|string|min:10',
            'incident_date' => 'required|date|before_or_equal:now',
            'urgency_level' => 'required|in:low,medium,high,critical',
            'victim_count' => 'nullable|integer|min:0',
            'damage_description' => 'nullable|string',
            'contact_phone' => 'required|string|max:20',
            
            // Attachments validation (max 3 files)
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => ['required', 'file', new MediaFile()],
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
            'attachments.array' => 'Format lampiran tidak valid',
            'attachments.max' => 'Maksimal 3 file yang dapat dilampirkan',
        ];
    }

    public function attributes(): array
    {
        return [
            'disaster_type_id' => 'jenis bencana',
            'description' => 'deskripsi',
            'location_address' => 'alamat lokasi',
            'incident_date' => 'tanggal kejadian',
            'urgency_level' => 'tingkat urgensi',
            'victim_count' => 'jumlah korban',
            'damage_description' => 'deskripsi kerusakan',
            'contact_phone' => 'nomor telepon',
            'attachments' => 'lampiran',
        ];
    }
}