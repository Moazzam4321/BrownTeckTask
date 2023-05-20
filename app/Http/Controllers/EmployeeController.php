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
            $companies =  Employee::paginate(10);
            return view('show-companies',['data'=>$companies]);
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
            return view('create-company');
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
        try {
            $response = ['error' => 'false' , 'message' => 'Company created successfully'];
            $company_name = data_get($request, 'name', null);
            $company_email = data_get($request, 'email',null);
            $company_website = data_get($request , 'website' , null);
            $company_logo = data_get($request, 'company_logo', null);
            
            if($company_logo !== null) 
            {
                $file_path = CompanyController::save_image($company_logo);
            }
            
            Employee::create_company($company_name,$company_email,$company_website,$file_path);

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
            $company_id = data_get($request , 'actionId' , null);
            $company_data =  Employee::where('id',$company_id)->first();
           
            return view('company-show', ['company' => $company_data]);
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
            $company_id = data_get($request , 'actionId' , null);
            $company_data =  Employee::where('id', $company_id)->first();
            return view('edit-company', ['company' => $company_data]);
        } catch (Exception $e) {
            return response()->json(self::$response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        try{
            $response = ['error'=> true , 'message'=> 'Record not found'];
            $updated_fields = $request->updatedFields;
            $company_id = data_get($request , 'companyId', null);
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
            $company_id = data_get($request , 'actionId' , null);
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
}
