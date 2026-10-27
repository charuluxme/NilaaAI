<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadResumeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow guest uploads, or check auth if needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $maxSizeMB = config('parser.max_resume_size_mb', 5);
        $maxSizeKB = $maxSizeMB * 1024;
        
        return [
            'file' => [
                'required',
                'file',
                "max:{$maxSizeKB}",
                'mimes:pdf,doc,docx',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        $maxSizeMB = config('parser.max_resume_size_mb', 5);
        
        return [
            'file.required' => 'Please upload a resume file.',
            'file.file' => 'The uploaded file is not valid.',
            'file.max' => "The resume file must not exceed {$maxSizeMB}MB.",
            'file.mimes' => 'Only PDF, DOC, and DOCX files are allowed.',
        ];
    }
}
