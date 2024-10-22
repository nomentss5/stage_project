@extends('layoutsAdmin.app')
@section('contents')

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title" style="text-align: center">Parametre E-Mail</h4>
            
        <form id="myForm" action="{{ route('email.parametre_update')}}" method="GET" onsubmit="return confirmer()">
            <br>
                <div class="row">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="col-md-6">
                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mail envoyeur </label>
                        <div class="col-sm-9">
                            <input type="text   " class="form-control" name="mail_username" />
                        </div>
                        <label style="margin-left: 2%">
                            @error('mail_username')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </label>
                        </div>                  
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mot de passe</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password"/>
                            </div>
                            <label style="margin-left: 2%">
                                @error('password')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>                  
                    </div>
                    <p>Nb : veuillez utiliser un mot de passe d'application fournis par service google si authentification en deux etapes est activé pour votre compte</p>
                </div>

                <br>
                <button type="submit" class="btn btn-outline-primary btn-lg ">Changer de parametre </button>

            </div>
        </div>
    </div>
</div>

<script>
    function confirmer() {
        return confirm("Êtes-vous sûr de vouloir modifier ?");
    }
</script>
@endsection