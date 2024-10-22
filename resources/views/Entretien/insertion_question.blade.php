@extends('layoutsAdmin.app')
@section('contents')

<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title" style="text-align: center">Gestion Questionnaire pour candidat</h5>
            <br>
            @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
            @endif
            @if(session('fail'))
              <div class="alert alert-danger">
                  {{ session('fail') }}
              </div>
            @endif
            <div class="row">
                <label class="col-sm-3 col-form-label" >Candidat</label>
                <div class="col-md-6">
                    <div class="input-group">
                       <input type="text" class="form-control" placeholder="{{ $user->identifier }}" disabled>
                    </div>
                </div>
            </div>
            <br>
            <form id="Form" action="{{ route('entretien.insert')}}" method="POST">
                @csrf
                <input type="hidden" name="id_user" value="{{ $user->id }}">
                <div class="row">
                    <label class="col-sm-3 col-form-label" >Questionnaire disponible </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="custom-select" name="id_poste_question" >
                            <option value="">Choisir un poste</option>
                            @foreach ($poste as $postes)
                                <option value="{{ $postes->id_poste }}" style="color: rgb(0, 0, 0)" >{{ $postes->poste }}</option>
                            @endforeach 
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <br>

            <button type="submit" class="btn btn-outline-primary btn-lg " data-toggle="modal" data-target="#exampleModal">Envoyer</button>
        </div>
    </div>
</div>
    <!-- Modal pour confirmation -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment envoyer ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success" id="confirmButton">Confirmer</button>
                </div>
            </div>
        </div>
    </div>
<script>
    document.getElementById('confirmButton').addEventListener('click', function() {
        document.getElementById('Form').submit();
    });
</script>
@endsection


{{-- <script>
    function confirmSubmit() {
        return confirm("Êtes-vous sûr de vouloir modifier le statut ?");
    }
</script> --}}