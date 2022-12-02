@extends('layout')
@section('content')

    <body>
        <div class="wrapper bg-white" style="opacity: 75%">
            @if (Session::get('notAllowed'))
                <div class="alert alert-danger">
                    {{ Session::get('notAllowed') }}
                </div>
            @endif
            @if (session('successAdd'))
                <div class="alert alert-success">
                    {{ session('successAdd') }}
                </div>
            @endif
            @if (session('succesUpdate'))
                <div class="alert alert-success">
                    {{ session('succesUpdate') }}
                </div>
            @endif
            @if (Session::get('deleted'))
                <div class="alert alert-warning">
                    {{ session::get('deleted') }}
                </div>
            @endif
            @if (Session::get('done'))
                <div class="alert alert-succes">
                    {{ session::get('done') }}
                </div>
            @endif

            <div class="command d-flex align-items-start justify-content-between">
                <div class="d-flex flex-column">
                    <div class="h5">My Todo's</div>
                    <p class="text-muted text-justify">
                        Here's a list of activities you have to do
                    </p>
                    <br>
                    <span>
                        <a href="/create" class="text-success">Create</a> <a href="">Complated</a>
                    </span>
                </div>
                <div class="info btn ml-md-4 ml-0">
                    <span class="fas fa-info" title="Info"></span>
                </div>
            </div>
            <div class="work border-bottom pt-3">
                <div class="d-flex align-items-center py-2 mt-1">
                    <div>
                        <span class="text-muted fas fa-comment btn"></span>
                    </div>
                    <div class="text-muted">2 todos</div>
                    <button class="ml-auto btn bg-white text-muted fas fa-angle-down" type="button" data-toggle="collapse"
                        data-target="#comments" aria-expanded="false" aria-controls="comments"></button>
                </div>
            </div>
            <div id="comments" class="mt-1">
                {{-- looping data-data dari compact 'todos' agar dapat ditampilkan perbaris datanya --}}
                @foreach ($todos as $todo)
                    <div class="comment d-flex align-items-start justify-content-between">
                        <div class="mr-2">
                            {{-- cek kalau statusnya 1 (complated), maka yang ditampilkan icon biasa yang gak bisa di klik --}}
                            @if ($todo['status'] ==1)
                            <span class="fa-solid fa-bookmark text-ssecondary btn"></span>
                            {{-- kalau statusnya selain dari 1, baru muncul icon checklist yang bisa di click buat update ke complated --}}
                            @else
                            <form action="/complated/{{ $todo['id'] }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="fas fa-circle-check text-primary btn"></button>
                            </form>
                            @endif
                            {{-- <input type="checkbox">
                            <span class="checkmark"></span>
                            </label> --}}
                        </div>
                        <div class="d-flex flex-column w-75">
                            {{-- menampilkan data dinamis/data yang dia ambil dari db pada blade harus menggunakan{{}} --}}
                            {{-- path yang id {id} dikirim data dinamis (data dbr db) makanya disitu pake{{}} --}}
                            <a href="/edit/{{ $todo['id'] }}" class="text-justify">
                            </a> {{ $todo['title'] }}
                            <p>{{ $todo['description'] }}</p>
                            {{-- konsep ternary:: if column status baris ini isinya 1 bakal munculin text 'complated'selain dari itu akan menampilkan teks 'On-proccess' --}}
                            <p class="text-muted">{{ $todo['status'] == 1 ? 'completed' : 'On-proccess' }}
                                <span class="date">{{ \Carbon\Carbon::parse($todo['date'])->format('j F,Y ') }}</span>
                            </p>
                            {{-- Carbon itu package laravel untuk menegelola yang berhubungan dengan date. Tadinya
                          value column date di db kan bentuknya format 2022-11-22 nah kita pengen ubah bentuk formatnya jadi 22 November,2022 --}}
                            <span class="date">
                                @if ($todo['status']== 1)
                                selesai pada : {{ \Carbon\Carbon::parse($todo
                                ['done_time'])->format('j F,Y') }}
                                {{-- kalau statusnya masih 0 (on-progress),yang ditampilkan tanggal dia dibuat (data dari column date yang di isi dari input pilih tanggal dari fitur create) --}}
                                @else
                                target selesai : {{\Carbon\Carbon::parse($todo
                                ['date'])->format('j F,Y') }}
                                @endif
                                </span>
                                <a href="/create" class="text-success">Tambah</a>
                                <a href="">Hapus</a>
                            </span>
                        </div>
                        <div class="ml-auto">
                            {{-- apabila  fitur nya berhubungan dengan modifikasi database, maka harus menggunakan form --}}
                            <form action="{{ route('delete', $todo['id']) }}" method="POST">
                                @method('delete')
                                @csrf
                                <button type="submit" class="fas fa-trash text-danger btn"></button>
                                <div class="ml-md-4 ml-0">
                                    <span class="fas fa-arrow-right btn"></span>
                                </div>
                         </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
