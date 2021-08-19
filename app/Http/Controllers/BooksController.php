<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BooksRequest;
use App\Models\Books;
class BooksController extends Controller
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
        // http://127.0.0.1:8000/api/auth/books?page=1
        if(request()->get('page') === "all"){
            $data = Books::where([["active",1]])->get();  
        }
        else{
            $data = Books::where([["active",1]])->paginate(10);  
        } 
        $data->map(function ($item) {
            $category  =  $item->categories()->first(); 
            $creator = $item->creator()->first(); 
            $item->nameCategory = $category->nameCategory;
            $item->description  = $category->description; 
            $item->nameCreator = $creator->name." ".$creator->lastname;
            $rentals = $item->rentals()->where([["statusRent",1]])->first();
            $nameUser = "";
            if($rentals){ 
                $user = $rentals->user()->first(); 
                $nameUser = $user->name." ".$user->lastname;
            } 
            $item->nameUser = $nameUser;
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
    public function store(BooksRequest $request)
    {
        #http://127.0.0.1:8000/api/auth/books?json={"nameBook":"test", "author":"test", "publicationDate":"2021-08-17", "Fkidcategory":"1","Fkidcreador":"1"}
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
                $Books = new Books();
                $Books->nameBook = $request->json["nameBook"];
                $Books->author = $request->json["author"];
                $Books->publicationDate = $request->json["publicationDate"];
                $Books->Fkidcategory = $request->json["Fkidcategory"];
                $Books->Fkidcreador = $request->json["Fkidcreador"]; 
                $Books->Save();
                $data = array( 
                    "status"        => 'success', 
                    'code'          => 200, 
                    'message'       => "Se ha guardado el libro.",
                    "data"          => $Books
                );
            } 
        } catch (\Throwable $th) {
            //throw $th;
            $data = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 );
        }
        return response()->json($data, $data["code"]);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // http://127.0.0.1:8000/api/auth/books/1
        try {
            $data = Books::where([["IdBook", $id],["active",1]])->first(); 
            $category  =  $data->categories()->first(); 
            $creator = $data->creator()->first(); 
            $data->nameCategory = $category->nameCategory;
            $data->description  = $category->description; 
            $data->nameCreator = $creator->name." ".$creator->lastname;
            $data = array( 
                "status"        => 'success', 
                'code'          => 200, 
                'message'       => "Se ha obtenido la información del libro",
                'data'          => $data
            );
        } catch (\Throwable $th) {
            //throw $th;
            $data = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 );
        }
        return response()->json($data, $data["code"]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BooksRequest $request, $id)
    {
        // http://127.0.0.1:8000/api/auth/books/5?json={"nameBook":"El libro de la selva", "author":"Mauricio Daza", "publicationDate":"2021-08-17", "Fkidcategory":"1"}
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
                $update = Books::where([ ["IdBook",  $id ] ])->update($request->json);
                if($update == 1){
                    $data = array( 
                        "status"        => 'success', 
                        'code'          => 200, 
                        'message'       => "Se ha guardado los cambios en el libro.",
                        'data'          =>  $request->json,
                    );
                }
                else{
                    
                    $data = array( 
                        "status"        => 'success', 
                        'code'          => 200, 
                        'message'       => "No hubo cambios en el libro.",
                        // 'data'          => 
                    );
                }
                 
            } 
        } catch (\Throwable $th) {
            //throw $th;
            $data = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 );
        }
        return response()->json($data, $data["code"]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        #http://127.0.0.1:8000/api/auth/books/5
        try {
            $bookAvailable = Books::where([['IdBook', $id],["statusRent",1]])->exists(); 
            if(!$bookAvailable){ 
                // $book = Books::where([['IdBook', $id]])->first();
                $data = array( 
                    "status"        => 'error', 
                    'code'          => 400, 
                    'message'       => "El libro se encuentra alquilado, no puede eliminarlo." 
                );
            }
            else{
                $update = Books::where([ ["IdBook",  $id ] ])->update(["active" => 0]);
                $data = array( 
                    "status"        => 'success', 
                    'code'          => 200, 
                    'message'       => "Se ha eliminado el libro.",
                    "data"          => $update
                );
            }
             
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            $data = array( 'status' => 'error', 'message' => 'Error al eliminar el libro',  'code' => 400 );
        }
        return response()->json($data, $data["code"]); 
    }
}
