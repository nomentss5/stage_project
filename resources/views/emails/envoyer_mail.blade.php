@extends('layoutsAdmin.app')

<!-- Loader (initialement caché) -->
  <div id="loader" style="display: none;" >
    <div class="spinner"></div>
  </div>

@section('contents')
<div class="row">
  <div class="col-12 grid-margin">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
      <div class="card-body">
        <h4 class="card-title" style="text-align: center">Formulaire reponse pour candidats</h4>
        <form id="myForm" action="{{ route('email.send')}}" method="GET" onsubmit="return confirmSendEmail()">
        <br>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Destinataire </label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="receiver" placeholder="{{ old('receiver') }}" value="{{ isset($candidat) ? $candidat->email : '' }} "/>
                </div>
                <label style="margin-left: 2%">
                    @error('receiver')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </label>
              </div>                  
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Objet</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="subject"/>
                </div>
              </div>                  
            </div>
          </div>
          <div class="row">
            <div class="card-body">
              <h4 class="card-title">Suggestion de message rapide</h4>
              <div class="template-demo">
                  @foreach ($suggestions as $suggestion)
                      <a href={{ route('email.get_suggestion', ['id'=>$suggestion->id]) }}><button type="button" class="btn btn-success btn-rounded btn-fw">{{ $suggestion->nom }}</button></a>
                  @endforeach
                {{-- <a href="#"><button type="button" class="btn btn-success btn-rounded btn-fw">Demande d'entretien</button></a>
                <a href="#"><button type="button" class="btn btn-danger btn-rounded btn-fw">Refuser</button></a>
                <a href="#"><button type="button" class="btn btn-warning btn-rounded btn-fw">Mettre en attente</button></a> --}}
              </div>
            </div>
          </div>
        
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Message</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="message">{{ session('suggestion_message') }}</textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('message')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>

          {{-- exemple de card avec collapse --}}
          {{-- <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample">
                <div class="card-body">
                    This is a collapsable card example using Bootstrap's built in collapse
                    functionality. <strong>Click on the card header</strong> to see the card body
                    collapse and expand!
                </div>
            </div>
          </div> --}}

          
          <button type="submit" class="btn btn-outline-primary btn-lg ">Valider</button>
          <br>
      </div>
    </div>
</form>
  </div>
</div>

{{-- <script>
    function confirmSendEmail() {
        return confirm("Êtes-vous sûr de vouloir envoyer cet e-mail ?");
    }
</script> --}}
<script>
 function confirmSendEmail() {
        let userConfirmed = confirm("Êtes-vous sûr de vouloir envoyer cet e-mail ?");
        
        if (userConfirmed) {
            // Si l'utilisateur confirme, affiche le loader
            showLoader();

            // Ensuite, envoie le formulaire ou effectue l'action souhaitée
            document.getElementById('myForm').submit();
        }else{
          return false;
        }
    }

    // Fonction pour afficher le loader
    function showLoader() {
        document.getElementById('loader').style.display = 'flex';
    }
</script>

@endsection