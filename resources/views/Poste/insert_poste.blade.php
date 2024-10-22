@extends('layoutsAdmin.app')
@section('contents')
<div class="row">
{{-- exemple de card avec collapse --}}
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
          <h4 class="card-title" style="text-align: center">Nouveau poste</h4>
          <form action="#" method="GET">
          <br>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nom de poste</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nom_suggestion" >
                  </div>
                </div>                  
              </div>
            </div>

            <button type="submit" class="btn btn-outline-primary btn-lg " onclick="return validation();">Ajouter</button>
              
        </div>
      </div>
      </form>
</div>

<script>
    function validation() {
        return confirm('Êtes-vous sûr de vouloir continuer?');
    }
</script>

@endsection