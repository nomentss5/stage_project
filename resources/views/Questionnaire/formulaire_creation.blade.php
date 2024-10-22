@extends('layoutsAdmin.app')
@section('contents')

<div class="row">
    <div class="col-12 grid-margin" >  
        <form action="{{ route('question.insert')}}" method="POST">
        @csrf

        <input type="hidden" id="maxCounter" name="maxCounter" value="0">

        <div class="card" >
            <div class="card-body">
            <h4 class="card-title">Formulaire pour Questionnaire</h4>
                <div class="row">
                    <label class="col-sm-3 col-form-label" >Pour le poste</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="custom-select" name="poste" >
                                @foreach ($postes as $poste)
                                    <option value={{ $poste->id }} >{{ $poste->nom }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                </div>       
            </div>
        </div>
        <br>
    
        <div class="card" id="card-container">
            {{-- <div class="card-body"> --}}
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-3">Question</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="email"/>
                            </div>
                        </div>                          
                    </div>
                </div> --}}
                <div id="row-reponse">
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 ">Reponse</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email"/>
                                </div>
                            </div>                          
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Note</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="email"/>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            {{-- <button type="button" id="add-reponse"> Reponse + </button> --}}
            {{-- </div> --}}
        </div>
  
        <br>    
        
        <div>
            <button type="button" id="add-card-ouverte"> Question ouverte + </button>
    
            <button type="button" id="add-card-qcm"> Question qcm + </button>
        </div>

        <br>

        <button type="submit" class="btn btn-outline-primary btn-lg ">Soummetre</button>
    </div>
    </form>
</div>

<script>

    let counter = 0; // Compteur pour chaque section de question

    document.getElementById('add-card-ouverte').addEventListener('click', function() {
        counter++;
    // Créer un nouvel élément div pour la carte
    var newCard = document.createElement('div');
    newCard.className = 'card';
    newCard.innerHTML = `
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3">Question Ouverte</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="question_${counter}"/>
                        </div>
                    </div>                          
                </div>
            </div>
        </div>        
    `; 

    console.log("counter question ouvert: ", counter);

    // Mettre à jour la valeur de l'input hidden
    document.getElementById('maxCounter').value = counter;

    // Ajouter la nouvelle carte au conteneur
    document.getElementById('card-container').appendChild(newCard);
});

document.getElementById('add-card-qcm').addEventListener('click', function() {
    counter++;
    // Créer un nouvel élément div pour la carte
    var newCard = document.createElement('div');
    newCard.className = 'card';
    newCard.innerHTML = `
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-3">Question QCM</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="question_${counter}"/>
                        </div>
                    </div>                          
                </div>
            </div>
            <div id="row-reponse-${counter}">
                ${NewReponse(counter).outerHTML}
            </div>
            <button type="button" id="add-reponse" data-question-index="${counter}"> Reponse + </button>
        </div>
    `;
    console.log("counter qcm: ", counter);

    // Mettre à jour la valeur de l'input hidden
    document.getElementById('maxCounter').value = counter;


    // Ajouter la nouvelle carte au conteneur
    document.getElementById('card-container').appendChild(newCard);    

});

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
                    <input type="text" class="form-control" name="reponse_${counter}[]"/>
                </div>
            </div>                          
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Note</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="note_${counter}[]"/>
                </div>
            </div>
        </div>  
    `;
        return newCard;
}

// Ajouter un écouteur d'événements pour tous les boutons "Reponse +"
document.addEventListener('click', function(event) {
    if (event.target && event.target.id === 'add-reponse') {

        // Trouver le conteneur #row-reponse dans la carte correspondante
        var parentCardBody = event.target.closest('.card-body');
        // Trouver le numéro de counter de la question dans la carte correspondante
        const questionCounter = event.target.getAttribute('data-question-index');
    
        const rowReponseContainer = document.getElementById(`row-reponse-${questionCounter}`);
        
        // Ajouter la nouvelle section de réponse à ce conteneur
        var newReponseRow = NewReponse(questionCounter);
        rowReponseContainer.appendChild(newReponseRow);
    }
});

</script>
@endsection