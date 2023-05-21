<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\AddEmployeeRequest;
use App\Http\Requests\Employee\DeleteEmployeeRequest;
use App\Http\Requests\Employee\EditEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected static $response = ['error' => 'true' , 'message' => 'OOps! Something went wrong'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('show-employess');
        } catch (Exception $e){
            return response()->json(self::$response);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('add-employee');
        }
    catch (Exception $e) {
        return response()->json(self::$response);
    }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddEmployeeRequest $request)
    {
        //
       // dd("ök");
        try {
           // dd($request);
            $response = ['error' => 'false' , 'message' => 'Employee created successfully'];
            $company_id = data_get($request, 'company_id', null);
            $employee_email = data_get($request, 'email',null);
            $employee_phone = data_get($request , 'Phone' , null);
            $employee_first_name = data_get($request, 'first_name', null);
            $employee_last_name = data_get($request, 'last_name', null);
            
            Employee::create_employee($employee_first_name,$employee_last_name,$company_id,$employee_email,$employee_phone);

            return response()->json($response);
    } catch (Exception $e) {
        return response()->json(self::$response);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try{
           // dd("ok");
            $company_id = data_get($request , 'actionId' , null);
            $company_data =  Employee::where('id',$company_id)->first();
           
            return view('employee-show', ['employee' => $company_data]);
            } catch (Exception $e) {
                return response()->json(self::$response);
            }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditEmployeeRequest $request)
    {
        
        try{
            $employee_id = data_get($request , 'actionId' , null);
            $employee_data =  Employee::where('id', $employee_id)->first();
            return view('edit-employee', ['employee' => $employee_data]);
        } catch (Exception $e) {
            return response()->json(self::$response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request)
    {
        dd("ok");
        try{
            $response = ['error'=> true , 'message'=> 'Record not found'];
            $updated_fields = $request->updatedFields;
            $company_id = data_get($request , 'employeeId', null);
            $company_data =  Employee::where('id',$company_id)->update($updated_fields);
            if($company_data) {
                $response = ['error'=> false , 'message'=> 'Company updated succesfully'];
            }
            return $response;
        } catch (Exception $e) {
            return response()->json(self::$response);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteEmployeeRequest $request)
    {
        try{
            $response = ['error' => true , 'message' => 'Record not found'];
            $company_id = data_get($request , 'employee_id' , null);
            $company_data =  Employee::where('id',$company_id)->first();
            if($company_data) 
            {
                $company_data->delete();
                $response = ['error' => false , 'message' => 'Company deleted successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            return response()->json(self::$response);
        }
    }

    public function index1()
    {
        try{
            $companies = Employee::orderBy('id', 'asc')->paginate(10);
                return response()->json([
                    'error'=> false,
                    'data'=> $companies
                ]);
        } catch (Exception $e){
            return response()->json(self::$response);
        }
    }
}

