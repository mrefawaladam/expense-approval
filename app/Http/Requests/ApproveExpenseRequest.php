<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Models\Expense;
use App\Models\Approver;
use App\Models\ApprovalStage;

class ApproveExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'approver_id' => [
                'required',
                'exists:approvers,id',
                function ($attribute, $value, $fail) {
                    $expense = Expense::find($this->route('id'));
                    if (!$expense) {
                        return $fail('Expense tidak ditemukan.');
                    }

                    $latestApproval = $expense->latestApproval;
                    $approverStage = ApprovalStage::where('approver_id', $value)->first();

                    if (!$approverStage) {
                        return $fail('Approver tidak memiliki tahap approval.');
                    }

                    if ($latestApproval) {
                        $latestStage = ApprovalStage::where('approver_id', $latestApproval->approver_id)->first();
                        if ($latestStage && $approverStage->id <= $latestStage->id) {
                            return $fail('Approver tidak boleh mendahului tahap approval sebelumnya.');
                        }
                    }
                }
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422));
    }
}
