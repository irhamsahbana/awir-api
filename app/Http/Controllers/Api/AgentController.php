<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Libs\RefNoGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    use RefNoGenerator;

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $refNo = $this->generateRefNo('people', 4, 'AG/', $this->getPostfix());

        $fields = [
            'company_id' => $request->company_id,
            'branch_id' => $request->branch_id,
            'ref_no' => $refNo,
            'name' => $request->name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,        // check request type
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'gender_id' => $request->gender_id,
            'national_id' => $request->national_id,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'nationality_id' => $request->nationality_id,
            'phone' => $request->phone,
            'wa' => $request->wa,
            'email' => $request->email,
            'education_id' => $request->education_id,
            'profession' => $request->profession,
            'marital_status_id' => $request->marital_status_id,
            'account_name' => $request->account_name,
            'bank_id' => $request->bank_id,
            'account_number' => $request->account_number,
            'emergency_name' => $request->emergency_name,
            'emergency_address' => $request->emergency_address,
            'emergency_home_phone' => $request->emergency_home_phone,
            'emergency_phone' => $request->emergency_phone,
            'work_experiences' => $request->work_experiences,
            'notes' => $request->notes,
        ];

        $rules = [
            'ref_no' => ['required', 'string', 'max:255', 'unique:people'],
            'name' => ['required', 'string', 'max:255'],
            'father_name' => ['required', 'string', 'max:255'],
            'mother_name' => ['required', 'string', 'max:255'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', Rule::date('Y-m-d')],
            'gender_id' => [
                'required',
                'uuid',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('group_by', 'genders');
                })
            ],
            'national_id' => [
                'required',
                'uuid',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('group_by', 'nationalities');
                })
            ],
            'address' => ['required', 'string', 'max:255'],
            'city_id' => [
                'required',
                'uuid',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('group_by', 'cities');
                })
            ],
            'nationality_id' => [
                'required',
                'uuid',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('group_by', 'nationalities');
                })
            ],
            'phone' => ['required', 'string', 'max:15'],
            'wa' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            'education_id' => [
                'required',
                'uuid',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('group_by', 'educations');
                })
            ],
            'profession' => ['required', 'string', 'max:255'],
            'marital_status_id' => [
                'required',
                'uuid',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('group_by', 'marital_statuses');
                })
            ],
            'account_name' => ['required', 'string', 'max:255'],
            'bank_id' => [
                'required',
                'uuid',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('group_by', 'banks');
                })
            ],
            'account_number' => ['required', 'string', 'max:25'],
            'emergency_name' => ['required', 'string', 'max:255'],
            'emergency_address' => ['required', 'string', 'max:255'],
            'emergency_home_phone' => ['required', 'string', 'max:15'],
            'emergency_phone' => ['required', 'string', 'max:15'],
            'work_experiences' => ['array'],
            'work_experiences.*.company_name' => ['required', 'string', 'max:255'],
            'work_experiences.*.role' => ['required', 'string', 'max:255'],
            'work_experiences.*.start_date' => ['required', Rule::date('Y-m-d')],
            'work_experiences.*.end_date' => ['nullable', Rule::date('Y-m-d')],
            'notes' => ['nullable', 'string', 'max:255'],

        ];

        $validator = Validator::make($fields, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
