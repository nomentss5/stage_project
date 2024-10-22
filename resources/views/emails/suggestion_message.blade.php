@extends('layoutsAdmin.app')
@section('contents')
<div class="row">
{{-- exemple de card avec collapse --}}
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
          <h4 class="card-title" style="text-align: center">Formulaire pour suggestion</h4>
          <form action="{{ route('suggestion.create')}}" method="GET">
          <br>  
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nom</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nom_suggestion">
                  </div>
                  <label style="margin-left: 2%">
                    @error('nom_suggestion')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
                </div>                  
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Message</label>
                    <div class="col-sm-12">
                      <textarea class="form-control" aria-label="With textarea" name="message"></textarea>
                    </div>
                    <label style="margin-left: 2%">
                      @error('message')
                          <span style="color: red">{{ $message }}</span>
                      @enderror
                    </label>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-outline-primary btn-lg " onclick="return validation();">Ajouter</button>
              
        </div>
      </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title" style="text-align: center">Suggestion existante</h4>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @foreach ($suggestion_message as $suggestion)     
                <div class="d-flex border-bottom border-top py-3 justify-content-between align-items-center">
                    <!-- Partie gauche -->
                    <div class="ps-2" style="margin-right: 30px">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0">{{ $suggestion->nom }}</h5>
                        </div>
                        <br>
                        <p class="m-0 text-black">
                            {{ $suggestion->message }} 
                        </p> 
                    </div>

                    <!-- Partie droite -->
                    <div class="pe-2" style="margin-right: 4cm">
                        <div style="margin-top: 0.2cm; width:max-content">
                            <a href={{ route('suggestion.delete', ['id' => $suggestion->id]) }} onclick="return confirmation();" >
                                <i class="fas fa-trash" style="color: red"></i> Supprimer
                            </a>
                        </div>
                        <div style="margin-top: 0.5cm; width:max-content">
                            <a href={{ route('suggestion.update_form', ['id' => $suggestion->id]) }} > 
                                <i class="fas fa-edit"> </i> Modifier
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function confirmation() {
        return confirm('Êtes-vous sûr de vouloir supprimer ?');
    }

    function validation() {
        return confirm('Êtes-vous sûr de vouloir valider?');
    }
</script>

@endsection