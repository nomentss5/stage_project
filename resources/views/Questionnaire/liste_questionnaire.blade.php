@extends('layoutsAdmin.app')
@section('contents')

<div class="row">
  <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">liste Questionnaire</h4>
          <div class="row">
            <label class="col-sm-3 col-form-label" >Pour le poste</label>
            <div class="col-md-6">
              <form action="{{ route('question.tri') }}" method="GET" >
                <div class="input-group">
                    <select class="custom-select" name="poste" onchange="this.form.submit()">
                        <option value="0" {{ session('question_poste') == 'Tout' ? 'selected' : '' }}>Tout</option>
                        @foreach ($postes as $poste)
                            <option value={{ $poste->id }} {{ session('question_poste') == $poste->nom ? 'selected' : '' }} >{{ $poste->nom }}</option>
                        @endforeach 
                    </select>
                </div>
            </div>
            {{-- <div class="col-sm-3">
              <div class="input-group">
                  <button class="btn btn-primary" type="submit" name="button" value="filtre">
                    Voir <i class="fas fa-search fa-sm"></i>
                  </button>
              </div>
            </div>  --}}
          </div>  
        </div>
      </form>
<br>
        <div class="card-body">
          @for($i = 0; $i < count($result); $i++)
            <div class="d-flex border-bottom border-top py-3 justify-content-between align-items-center">
              <!-- Partie gauche -->
              <div class="ps-2" style="margin-right: 30px">
                  <div class="d-flex justify-content-between align-items-center">
                      <h5 class="m-0">{{ $result[$i][0]['question'] }}</h5>
                  </div>
                  <br>
                  @for ($j = 0; $j < count($result[$i]); $j++)

                    @if ($result[$i][$j]['reponse'] != null)
                      <div class="d-flex">
                          <div>
                              <ul>
                                <li>{{ $result[$i][$j]['reponse'] }} ( {{ $result[$i][$j]['note'] }} pt ) </li>
                              </ul>
                          </div>
                      </div>
                    @endif

                  @endfor
              </div>
              {{-- fin partie gauche --}}

              <!-- Partie droite -->
              <div class="pe-2" style="margin-right: 4cm">
                  <div style="margin-top: 0.2cm; width:max-content">
                      <a href={{ route('question.delete', ['id' => $result[$i][0]['id_question'] ] ) }} onclick="return confirmation();" >
                          <i class="fas fa-trash" style="color: red"></i> Supprimer
                      </a>
                  </div>
                  <div style="margin-top: 0.5cm; width:max-content">
                      <a href={{ route('question.formulaire_modification', ['id' => $result[$i][0]['id_question'] ] ) }}> 
                          <i class="fas fa-edit"> </i> Modifier
                      </a>
                  </div>
              </div>
              {{-- fin partie droite --}}
            </div>
          @endfor
        </div>
      </div>
  </div>
</div>
<script>
  
  function confirmation() {
      return confirm('Êtes-vous sûr de vouloir supprimer ?');
  }

</script>
@endsection