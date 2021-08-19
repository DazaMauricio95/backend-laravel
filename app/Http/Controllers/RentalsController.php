<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RentalsRequest;
use App\Models\rentals;
use App\Models\Books;
use App\Models\User;
class RentalsController extends Controller
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
        // http://127.0.0.1:8000/api/auth/rentails?page=all
        if(request()->get('page') === "all"){
            $data = rentals::get();  
        }
        else{ 
            $data = rentals::paginate(5);  
        }
        $data->map(function ($item) { 
            $book = $item->book()->first();
            $user = $item->user()->first(); 
            $item->nameUser = $user->name." ".$user->lastname;
            $item->nameBook = $book->nameBook;
            $item->author = $book->author;
            $item->publicationDate = $book->publicationDate; 
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
    public function store(RentalsRequest $request)
    {
        // http://127.0.0.1:8000/api/auth/rentails?json={"Fkidbook":"1","name":"Pablo","lastname":"Gonzalez", "rentDate":"2021-08-18", "returnDate":"2021-08-30"}
        try {
            if (isset($request->validator) && $request->validator->fails()) {  
                $response = array( 
                    'status' => 'error', 
                    'message' => 'Los datos proporcionados no son válidos.', 
                    'errors' => $request->validator->messages(), 
                    'code' => 400 
                ); 
            }
            else{

                $User = new User();
                $User->name     = $request->json['name'];
                $User->lastname = $request->json['lastname'];
                $User->email    = "";
                $User->password = "";
                $User->photo    = "";
                $User->role     = "user";
                $User->active   = 0;
                
                if($User->save()){
                    $rentals = new rentals();
                    $rentals->Fkidbook      = $request->json["Fkidbook"];
                    $rentals->Fkiduser      = $User->id;
                    $rentals->rentDate      = $request->json["rentDate"];
                    $rentals->returnDate    = $request->json["returnDate"]; 
                    #Verifico la disponibilidad del libro
                    $bookAvailable = Books::where([['IdBook', $request->json["Fkidbook"]],["statusRent",1]])->exists();
                    if($bookAvailable){ 
                        $rentals->save();
                        $updateBook = Books::where([ ["IdBook",  $request->json["Fkidbook"] ] ])->update(["statusRent" => 0]);
                        $response = array( 
                            "status"        => 'success', 
                            'code'          => 200, 
                            'message'       => "Alquiler guardado.",
                            "data"          => $rentals,
                            "updateBook"    => $updateBook
                        );
                    }
                    else{
                        $response = array( 
                            "status"        => 'success', 
                            'code'          => 400, 
                            'message'       => "El libro ya se encuentra prestado."
                        );
                    } 
                }
                else{
                    $response = array( 
                        "status"        => 'error', 
                        'code'          => 400, 
                        'message'       => "No se pudo agregar el alquiler."
                    );
                } 
            } 
        } catch (\Throwable $th) {
            $response = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 );
        }
        return response()->json($response, $response["code"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // http://127.0.0.1:8000/api/auth/rentails/1
        try {
            $data = rentals::where([["IdRent", $id]])->first(); 
            if($data){
                $book = $data->book()->first();
                $user = $data->user()->first(); 
                $data->nameUser = $user->name." ".$user->lastname;
                $data->nameBook = $book->nameBook;
                $data->author = $book->author;
                $data->publicationDate = $book->publicationDate; 
            } 
            $response = array( 
                "status"        => true, 
                'code'          => 200, 
                'message'       => $data
            );
        } catch (\Throwable $th) {
            //throw $th;
            $response = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 );
        }
        return response()->json($response, $response["code"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RentalsRequest $request, $id)
    {
        // http://127.0.0.1:8000/api/auth/rentails/1?json={"Fkidbook":"1", "Fkiduser":"2", "rentDate":"2021-08-18", "returnDate":"2021-08-20","statusRent":"0"}
        try {
            if (isset($request->validator) && $request->validator->fails()) {  
                $response = array( 
                    'status' => 'error', 
                    'message' => 'Los datos proporcionados no son válidos.', 
                    'errors' => $request->validator->messages(), 
                    'code' => 400 
                ); 
            }
            else{ 
                $updateRent = rentals::where([ ["IdRent", $id ] ])->update($request->json);
                if($updateRent == 1){
                    $message = ""; 
                    if($request->json['statusRent'] == 0){ #Estamos haciendo la devolución
                        rentals::where([ ["IdRent", $id ] ])->update(["returnDate" => date("Y-m-d")]);
                        $updateBook = Books::where([ ["IdBook",  $request->json["Fkidbook"] ] ])->update(["statusRent" => 1]);
                        if($updateBook){
                            $message .= "Se ha devuelto el libro.\n ";
                        }
                    } 
                    $message .= "Cambios guardados en el alquiler";
                    $response = array( 
                        "status"        => 'success', 
                        'code'          => 200,  
                        'message'       => $message
                    );
                }
                else{
                    $response = array( 
                        "status"        => 'success', 
                        'code'          => 200, 
                        'message'       => "No hubo cambios en el alquiler"
                    );
                }
                 
            }
        } catch (\Throwable $th) {
            $response = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 );
        }
        return response()->json($response, $response["code"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
