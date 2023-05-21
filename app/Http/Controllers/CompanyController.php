<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\DeleteCompanyRequest;
use App\Http\Requests\Company\AddCompanyRequest;
use App\Http\Requests\Company\EditCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

    protected static $response = ['error' => 'true' , 'message' => 'OOps! Something went wrong'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
                return view('show-companies');
            } catch (Exception $e) {
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
    public function store(AddCompanyRequest $request)
    {
        try {
                $response = ['error' => 'false' , 'message' => 'Company created successfully'];
                $company_name = data_get($request, 'name', null);
                $company_email = data_get($request, 'email',null);
                $company_website = data_get($request , 'website' , null);
                $company_logo = data_get($request, 'company_logo', null);
                
                if($company_logo !== null) 
                {
                    $file_path = self::save_image($company_logo);
                }
                
                Company::create_company($company_name,$company_email,$company_website,$file_path);
                SendingMailController::send_mail($company_email);

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
           //dd("ok");
           //dd($request->query('actionId'));
        $company_id = data_get($request , 'actionId' , null);
        $company_data =  Company::where('id',$company_id)->first();
       
        return view('company-show', ['company' => $company_data]);
        } catch (Exception $e) {
            return response()->json(self::$response);
         }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditCompanyRequest $request)
    {
        try{
            $company_id = data_get($request , 'actionId' , null);
            $company_data =  Company::where('id', $company_id)->first();
            return view('edit-company', ['company' => $company_data]);
        } catch (Exception $e) {
            return response()->json(self::$response);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request)
    {
        try{
            $response = ['error'=> true , 'message'=> 'Record not found'];
            $updated_fields = $request->updatedFields;
            $company_id = data_get($request , 'companyId', null);
            $company_data =  Company::where('id',$company_id)->update($updated_fields);
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
    public function destroy(DeleteCompanyRequest $request)
    {
        try{
            $response = ['error' => true , 'message' => 'Record not found'];
            $company_id = data_get($request , 'actionId' , null);
            $company_data =  Company::where('id',$company_id)->first();
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

    public Static function save_image($file_content)
    {
        try{
            $file_name = uniqid() . '.' . $file_content->getClientOriginalExtension();
            Storage::disk('public')->put($file_name, $file_content);
            return Storage::path($file_name);
        } catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => 'File not upload'
            ]);
        }
    }
    public function index1()
    {
        try{
          //  dd("ok");
            $companies = Company::orderBy('id', 'asc')->paginate(10);
               // return $compa
                return response()->json([
                    'error'=> false,
                    'data'=> $companies
                ]);
        } catch (Exception $e){
            return response()->json(self::$response);
        }
    }
}
