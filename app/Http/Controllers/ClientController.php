<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Traits\UploadFile;

class ClientController extends Controller
{
    use UploadFile;
    // private $columns=['clientname','phone','email','website','city','active','img'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients=client::get();
       return view('clients',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $clientname=request->clientname;
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store()
    // {
    //    $client= new client();
    //    $client->clientname="egypt airfly";
    //    $client->phone="132146";
    //    $client->email="egypt@gmail.com";
    //    $client->website="https//egyptfly.com";
    //     $client->save();
    //     return "inserted successfully";
    // }
    public function create(){
        return view('addclient');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $client = new Client();
        // $client->clientName = $request->clientname;
        // $client->phone =$request->phone;
        // $client->email =$request->email;
        // $client->website =$request->website;
        // $client->save();
        // return 'Data inserted Successfully :))';
        $messages=$this->errMsg();
        $data=$request->validate([
            'clientname'=>'required|max:100|min:5',
            'phone'=>'required',
            'email'=>'required|email:rfc',
            'website'=>'required',
            'city'=>'required|max:30',
            'img'=>'required',
           
        ] ,$messages
        );
        $data['active']=isset($request->active);


        $imgExt = $request->img->getClientOriginalExtension();
        $fileName=time().'.'.$imgExt;
        $path='assets/img';
        $request->img->move($path,$fileName);
        
        $data['img']=$fileName;
        client::create($data);
        return redirect('clients?message="hiiii"');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client=client::findOrFail($id);
        return view('showclient',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client=client::findOrFail($id);
        return view('editclient',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages=$this->errMsg();
        $data=$request->validate([
            'clientname'=>'required|max:100|min:5',
            'phone'=>'required',
            'email'=>'required|email:rfc',
            'website'=>'required',
            'city'=>'required|max:30',
            'img'=>'required',
            
            ]
            ,$messages
        );
            // $data['img']=$request->img;
            // $data['active']=isset($request->active);
            // $data
            // if($request->hasfile('img')){
            //     $destination='assets/img'.$request->img;
            //     if(file::exists($destination)){
            //         file::delete($destination);
            //     }
            // $imgExt = $request->img->getClientOriginalExtension();
            // $fileName=time().'.'.$imgExt;
            // $path='assets/img';
            // $request->img->move($path,$fileName);
            // $data['img']=$fileName;}
            if($request->hasfile('img')){
                $fileName=$this->upload($request->img,'assets/img');
                $data['img']=$fileName;
            }

    //    Client::where('id',$id)->update($request->only($this->columns));
        client::where('id',$id)->update($data);
        return redirect('clients');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       $id=$request->id;
        client::where('id',$id)->delete();
        return redirect('clients');
    }
    // trash
    public function trash()
    { 
      $trashed=client::onlyTrashed()->get();
      return view('trashedclients',compact('trashed'));
    }
    // restore trashed
    public function restore(string $id)
    {
        client::where('id',$id)->restore();
        return redirect('clients');
    }
// forcedelete
    public function forcedelete(Request $request)
    {
       $id=$request->id;
        client::where('id',$id)->forcedelete();
        return redirect('trashedclients');
    }
    public function errMsg(){
        return[
            'clientname.required'=>'the client name is required,please insert the name',
            'clientname.min'=>'the name is short,the name must be more than 5 letters',
        ];
    }
}
