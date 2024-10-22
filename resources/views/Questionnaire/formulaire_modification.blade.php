@extends('layoutsAdmin.app')
@section('contents')


<form action="{{ route('question.update')}}" method="post">
@csrf
<div class="row">
    
    <input type="hidden" id="data-question-index" name="maxCounter" value="1">
    <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"></h4>
            <div class="row">
              <label class="col-sm-3 col-form-label" >Question pour le poste</label>
              <div class="col-md-6">
                  <div class="input-group">
                      <select class="custom-select" name="poste">
                          @foreach ($postes as $poste)
                              <option value={{ $poste->id }} {{ session('question_poste') == $poste->nom ? 'selected' : '' }} >{{ $poste->nom }}</option>
                          @endforeach 
                      </select>
                  </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card" id="card-container">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-3">Question</label>
                            <div class="col-sm-12">
                                <input type="hidden" value="{{ $questions->id}}" class="form-control" name="id_question"/>
                                <input type="text" value="{{ $questions->question}}" class="form-control" name="question"/>
                            </div>
                        </div>                          
                    </div>
                </div>
                <div id="row-reponse">
                    
                </div>
                @if(session('session_reponse') == false)
                    <button type="button" id="add-reponse"> Ajouter Reponse + </button>
                @endif
                

                @if(session('session_reponse') == true)
                    @foreach ($reponse as $index => $reponses)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 ">Reponse</label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="form-control" name="boucle[{{$index}}]"/>
                                    <input type="text" value="{{ $reponses->reponse }}" class="form-control" name="reponse_{{$index}}"/>
                                    <input type="hidden" value={{$reponses->id}} class="form-control" name="id_reponse_{{$index}}"/>
                                </div>
                            </div>                          
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Note</label>
                                <div class="col-sm-2">
                                    <input type="text" value="{{ $reponses->note }}" class="form-control" name="note_{{$index}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <button type="button" id="add-reponse"> Ajouter Reponse + </button>
                @endif
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-outline-primary btn-lg ">Modifier</button>   
    </div>
</form>
</div>
<script>
    function NewReponse(counter) {
    console.log("Counter value for new response:", counter);
    // Créer un nouvel élément div pour la carte
    var newCard = document.createElement('div');
    newCard.className = 'row mt-3';
    newCard.innerHTML = `  
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-3 ">Reponse</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="new_reponse_${counter}"/>
                    <input type="hidden" class="form-control"/>
                </div>
            </div>                          
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Note</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="new_note_${counter}"/>
                </div>
            </div>
        </div>  
    `;
    counter++;
    
    // Mettre à jour la valeur de l'input hidden
    document.getElementById('data-question-index').value = counter;

        return newCard;
}

// Ajouter un écouteur d'événements pour tous les boutons "Reponse +"
document.addEventListener('click', function(event) {
    if (event.target && event.target.id === 'add-reponse') {

        // Trouver le conteneur #row-reponse dans la carte correspondante
        var parentCardBody = event.target.closest('.card-body');
        // Trouver le numéro de counter de la question dans la carte correspondante
        // const questionCounter = event.target.getAttribute('data-question-index');
        const questionCounter = document.getElementById('data-question-index');

        // Convertir la valeur actuelle en nombre et l'incrémenter de 1
        let currentValue = parseInt(questionCounter.value);

        console.log("value for new response:", currentValue);

    
        const rowReponseContainer = document.getElementById('row-reponse');
        
        // Ajouter la nouvelle section de réponse à ce conteneur
        var newReponseRow = NewReponse(currentValue);
        rowReponseContainer.appendChild(newReponseRow);
    }
});

</script>
@endsection