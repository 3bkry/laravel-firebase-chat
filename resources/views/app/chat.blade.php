@extends('app.layout')

@section('title', 'Chat | Laravel Chat')

@section('content')
    <div id="app" class="ui main container" style="margin-top:65px;">
        <div class="ui grid">
            <div class="row">
                <div class="three wide column">
                    <div class="ui vertical pointing menu">
                        <h3 class="item ui header">
                            Usuarios:
                        </h3>
                        @foreach($users as $user)
                            @if($user->id == $receptorUser->id)
                                <a href="{{route('chat', [$user->username])}}" class="active item">
                                    {{ $user->name }}
                                </a>
                            @else
                                <a href="{{route('chat', [$user->username])}}" class="item">
                                    {{ $user->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="thirteen wide column">
                    <div class="ui segment" style="padding: 1.5em 1.5em;">
                        <div class="ui comments" style="max-width: 100%;">
                            <h3 class="ui dividing header"><i class="talk outline icon"></i> Conversación con {{ $receptorUser->name }}</h3>
                            <firebase-messages user-id="1" chat-id="500" receptor-name="{{ $receptorUser->name }}"></firebase-messages>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyB2M186j6R30d5t1d0aHgK0aubGB7Kz0vA",
            authDomain: "appchaty-d0dc3.firebaseapp.com",
            databaseURL: "https://appchaty-d0dc3.firebaseio.com",
            projectId: "appchaty-d0dc3",
            storageBucket: "appchaty-d0dc3.appspot.com",
            messagingSenderId: "364372720721",
            appId: "1:364372720721:web:398d5cb09010b4771f4c70",
            measurementId: "G-MM71K3YDJN"
        };
        firebase.initializeApp(config);

        const database = firebase.database();
    </script>
    <script src="{{ asset('js/myapp.js') }}"></script>
@endsection