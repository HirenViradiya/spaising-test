<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
{
    protected $employees;
    public function __construct(Employees $employees)
    {
        $this->employees = $employees;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name'          => 'required',
            'last_name'       => 'required',
            'email'         => 'required|email|unique:employees',
            'phone'        => 'required|numeric|unique:employees',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => trans('message.validation.failed'),
                'error' => $validator->errors()->first(),
                'status_code' => "422",
            ];
            return response()->json($response);
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $path = public_path('uploads/images/');
                $file->move($path, $filename);
                // if (!$file->move($path, $filename)) {
                //     $response = [
                //         'status' => false,
                //         'message' => trans('message.validation.image'),
                //         'status_code' => "400",
                //     ];
                //     return response()->json($response);
                // }
            }

            $data  =  $this->employees->saveEmployees($request->all());

            if (($data)) {
                $response = [
                    'status' => true,
                    'message' => trans('message.save.success'),
                    'status_code' => "200",
                ];
                return response()->json($response);
            } else {
                $response = [
                    'status' => false,
                    'message' => trans('message.save.failed'),
                    'status_code' => "500",
                ];
                return response()->json($response);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $employees = $this->employees->showEmployees();
        if ($employees) {
            $response = [
                'status' => true,
                'message' => trans('message.list.success'),
                'data' => $employees,
                'status_code' => "200",
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => true,
                'message' => trans('message.list.empty'),
                'status_code' => "200",
            ];
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Employees::find($id);
        $data->image = $data['image'] ? URL::to('/uploads/images/') . '/' . $data['image'] : "";
        if ($data) {
            $response = [
                'status' => true,
                'message' => trans('message.edit.success'),
                'data' => $data,
                'status_code' => "200",
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => false,
                'message' => trans('message.edit.empty'),
                'status_code' => "200",
            ];
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'          => 'required',
            'last_name'       => 'required',
            'email'         => ['required', 'email', Rule::unique('employees')->ignore($request->id)],
            'phone'        => ['required', 'numeric', Rule::unique('employees')->ignore($request->id)],
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => trans('message.validation.failed'),
                'error' => $validator->errors()->first(),
                'status_code' => "422",
            ];
            return response()->json($response);
        } else {
            if ($request->hasFile('image')) {
                $data = Employees::find($request->id);
                if (is_file(public_path('uploads/images/') . $data->image)) {
                    unlink(public_path('uploads/images/') . $data->image);
                }

                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $path = public_path('uploads/images/');
                $file->move($path, $filename);
                // if (!$file->move($path, $filename)) {
                //     $response = [
                //         'status' => false,
                //         'message' => trans('message.validation.image'),
                //         'status_code' => "400",
                //     ];
                //     return response()->json($response);
                // }
            }

            $data  =  $this->employees->saveEmployees($request->all());

            if (($data)) {
                $response = [
                    'status' => true,
                    'message' => trans('message.update.success'),
                    'status_code' => "200",
                ];
                return response()->json($response);
            } else {
                $response = [
                    'status' => false,
                    'message' => trans('message.update.failed'),
                    'status_code' => "500",
                ];
                return response()->json($response);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Employees::find($id);

        if (is_file(public_path('uploads/images/') . $data->image)) {
            unlink(public_path('uploads/images/') . $data->image);
        }

        if ($data->delete()) {
            $response = [
                'status' => true,
                'message' => trans('message.delete.success'),
                'status_code' => "200",
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => false,
                'message' => trans('message.delete.failed'),
                'status_code' => "500",
            ];
            return response()->json($response);
        }
    }
}
