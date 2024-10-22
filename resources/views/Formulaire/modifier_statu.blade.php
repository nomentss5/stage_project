@extends('layoutsAdmin.app')
@section('contents')

<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title" style="text-align: center">Statu du candidat</h5>
            <br>
            <div class="row">
                <label class="col-sm-3 col-form-label" >Nom du candidat</label>
                <div class="col-md-6">
                    <div class="input-group">
                       <input type="text" class="form-control" placeholder="{{ $candidat->nom }}" disabled>
                    </div>
                </div>
            </div>
            <br>
            <form id="Form" action="{{ route('candidat.update_statu')}}" method="POST">
                @csrf
                <input type="hidden" name="id_candidat" value="{{ $candidat->id }}">
                <div class="row">
                    <label class="col-sm-3 col-form-label" >Statu du candidat</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="custom-select" name="selected_statu" >
                            @foreach ($statu_select as $statu)
                                <option value="{{ $statu->id }}" {{ session('statu_candidat') == $statu->nom ? 'selected' : '' }} style="color: rgb(0, 0, 0)" >{{ $statu->nom }}</option>
                            @endforeach 
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-warning" type="button" data-toggle="modal" data-target="#exampleModal">Modifier son statu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
</div>
<br>
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title" style="text-align: center">Historique du candidat.</h5>
            <br>
            <div class="table-responsive">
                <table class="table table-hover">
                <thead>
                    <tr>
                    <th>Date modification</th>
                    <th>Modifé par</th>
                    <th>Avant modification</th>
                    <th>Modification</th>
                    <th></th>
                    {{-- <th>Voir Cv</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historique_statu as $historique)
                    <tr>
                        <td>{{ $historique->date }}</td>
                        <td>{{ $historique->user_name }}</td>
                        <td>{{ $historique->statu_name_avant }}</td>
                        <td>{{ $historique->statu_name_apres }}</td>
                        <td><a href={{ route('statu.delete', ['id' => $historique->id ] ) }}>Supprimer <i class="fas fa-trash" style="color: red"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
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
                    Modifier le status du candidat?
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