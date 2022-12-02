<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        //
        return view('login');
    }

    public function register()
    {
        //
        return view('register');
    }
           //ambil data dari table todos dengan model Todo
          //all() fungsinya untuk mengambil semua data di table 
         // $todos = Todo::all();
         //kirim data yang sudah di ambil ke file blade /ke file yang menampilkan halaman 
        //kirim melalui compact()
        //isi compact sesuaikan dengan nama variabel 
    public function index(){
        //ambil data dari tabel todos dengan model todo 
        // filter data didatabase .->
        $todos = Todo::where('user_id', '=', Auth::user()->id)->get();
        return view('dashboard', compact('todos'));
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    public function registerAccount(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'username' => 'required|min:4|',
            'name' => 'required|min:4|max:8',
            'email' => 'required|email:dns',
            'password' => 'required|min:4',
        ]);
        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/')->with('success', 'berhasil register, silalhkan login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ],
        [
            'username.exists' => 'username ini belum tersedia',
            'username.required' => 'username harus diisi',
            'password.required' => 'passwoord harus diisi',
        ]
        );
        $user =$request->only('username','password');
        if (Auth::attempt($user)) {
            return redirect('/');
        }else{
            return redirect()->back()->with('error', 'Gagal login, silakan cek dan coba lagi');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
            'title' => 'required|max:8',
            'date' =>'required',
            'description' => 'required|max:15',
        ]);
        //menyimpan data ke database
        //tes koneksi blade dengan conttroler
        //mengirim data ke database table todos dengan model todo 
        //''= nama colum di table db
        //$request-> = value atribute name pada input 
        //kenapa yang dikirim $ data ? karena table pada db todos membutuhkan 6 colum input 
        //salah satunya column 'done_time' yang tipenya nullable,karena nullable jadi gak perlu dikirim ke nilai 
        //
        Todo::create([
            'title' => $request->title,
            'date' =>$request->date,
            'description' =>$request->description,
            'status' => 0,
            'user_id' =>Auth::user()->id,
        ]);
        //kalau berhasil diarahin ke halaman todo awal dengan pemberitahuan
        return redirect('/dashboard')->with('successAdd','berhasil menambahkan data Todo');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //menampilkan halaman input form edit
        //mengambil data satu baris ketika column id pada baris tersebut sama dengan id dari parameter route 
        $todo = Todo::where('id', $id)->first();
        //kirim data yang diambil ke file blade dengan compact
        return view('edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //cari baris data yang punya id yang sama dengan data id yang dikirim ke parameter route
        //kalau uda ketemu, update column-column datanya
        Todo::where('id', $id)->update([
            'title' => $request->title,
            'date' =>$request->date,
            'description' =>$request->description,
            'status' => 0,
            'user_id' =>Auth::user()->id,
            'status' => 0,
        ]);
        //kalaau berhasil,halaman bakal di redirect ulang ke halaman awal dengan todo dengan pesan pemberitahuan 
        return redirect('/todo/')->with('succesupdate', 'Data todo berhasil diperbarui');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //menghapus data di database
        // filter /cari data yang mau dihapus,baru jalankan perintah hapusnya 
        Todo::where('id','=', $id)->delete();
        // kalau ada, balik lagi ke halaman awalnya dengan pemberitahuan 
        return redirect()->back()->with('deleted','Berhasil menghapus data Todo!');
    }


    public function completed()
    {
        return view('dashboard.complated');
    }

    public function updateCompleted($id)
    {
        // cari data yang mau di ubah statusnya jadi 'complated' dan column 'done_time' yang tadinya null, diisi dengan tanggal sekarang (tgl ketika data todo di ubah statusnya)
        // karena status boolean, dan 0 itu untuk kondisi todo on-proggres, jadi 1 nya untuk kondisi todo complated 
        Todo::where('id', '=', $id)->update([
            'status' =>1,
            'done_time' =>\Carbon\Carbon::now(),
        ]);
        // apabila berhasil,akan dikembalikan ke halaman awal dengan pemberitahuan
        return redirect()->back()->with('done', 'Todo telah selsai dikerjakan!');
    }
}