@extends('app.layout')

@section('title', 'Chat | Laravel Chat')

@section('content')
    <div id="app" class="ui main container" style="margin-top:65px;">
        <div class="ui grid">
            <div class="row">

                <div class="thirteen wide column">
                    <div class="ui segment" style="padding: 1.5em 1.5em;">
                        <div class="ui comments" style="max-width: 100%;">
                            <h3 class="ui dividing header"><i class="talk outline icon"></i> Conversación con {{ $chat_id }}</h3>
                            <firebase-messages user-id="{{ $user_id }}" chat-id="{{ $chat_id }}" receptor-name="{{ $chat_id }}"></firebase-messages>
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
          apiKey: "{{ env('FIREBASE_APIKEY') }}",
          authDomain: "{{ env('FIREBASE_AUTHDOMAIN') }}",
          databaseURL: "{{ env('FIREBASE_DATABASEURL') }}",
          projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
          storageBucket: "{{ env('FIREBASE_STORAGEBUCKET') }}",
          messagingSenderId: "{{ env('FIREBASE_MESSAGINGSENDER_ID') }}"
        };
        firebase.initializeApp(config);

        const database = firebase.database();
    </script>
    <script src="{{ asset('js/myapp.js') }}"></script>
@endsection