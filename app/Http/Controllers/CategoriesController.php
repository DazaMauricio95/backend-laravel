<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use App\Models\categories;

class CategoriesController extends Controller
{
    public function __construct() { 
        $this->middleware(['jwt.verify','cors'], ['except' => [ "index", "show" ]]); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->get('page') === "all"){
            $data = categories::where([["active",1]])->get();  
        }
        else{
            $data = categories::where([["active",1]])->paginate(5);  
        }
        $data->map(function ($item) { 
            $countBooks = $item->books()->count();
            $item->countBooks = $countBooks;
            return $item;
        }); 
        $response = array( 
            "status"    => 'success', 
            'code'      => 200, 
            "data"      => $data
        ); 
        return response()->json($response, $response["code"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        try {
            if (isset($request->validator) && $request->validator->fails()) {  
                $data = array( 
                    'status' => 'error', 
                    'message' => 'Los datos proporcionados no son válidos.', 
                    'errors' => $request->validator->messages(), 
                    'code' => 400 
                ); 
            }
            else{
                $categories = new categories();
                $categories->nameCategory = $request->json["nameCategory"];
                $categories->description = $request->json["description"];
                $categories->save();
                $data = array( 
                    "status"        => 'success', 
                    'code'          => 200, 
                    'message'       => "Se ha guardado la categoría.",
                    "data"          => $categories
                );
            } 
        } catch (\Throwable $th) {
            $data = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 );
        }
        return response()->json($data); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, $id)
    {
        try {
            if (isset($request->validator) && $request->validator->fails()) {  
                $data = array( 
                    'status' => 'error', 
                    'message' => 'Los datos proporcionados no son válidos.', 
                    'errors' => $request->validator->messages(), 
                    'code' => 400 
                ); 
            }
            else{
                $update = categories::where([ ["IdCategory",  $id ] ])->update($request->json);
                if($update == 1){
                    $data = array( 
                        "status"        => 'success', 
                        'code'          => 200, 
                        'message'       => "Se ha guardado los cambios en la categoría.",
                        'changes'       =>  $request->json,
                    );
                }
                else{
                    $data = array( 
                        "status"        => 'success', 
                        'code'          => 200, 
                        'message'       => "No hubo cambios en la categoría."
                    );
                }
            } 
        } catch (\Throwable $th) {
            $data = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 );
        }
        return response()->json($data); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        #http://127.0.0.1:8000/api/auth/categories/10
        try {
            $update = categories::where([ ["IdCategory",  $id ] ])->update(["active" => 0]);
            $data = array( 
                "status"        => 'success', 
                'code'          => 200, 
                'message'       => "Se ha eliminado la categoría.",
                "data"          => $update
            );
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $data = array( 'status' => 'error', 'message' => 'Error al eliminar el libro',  'code' => 400 );
        }
        return response()->json($data); 
    }
}
