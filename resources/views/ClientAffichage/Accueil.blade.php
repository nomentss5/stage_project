@extends('layoutsClient.app')
@section('contents')

<style>

.dd{
    /* border: solid; */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 5%;

}

.dd h2{
    text-align: center;
    color: blue;
    font-family: 'Courier New', Courier, monospace;
}

.dd h5{
    /* text-align: center; */
}

a{
    margin-top: 2%;
}

.butt{
    border-radius: 50px;
}

i{
    font-size: 40px;
}

.fa-angle-double-down {
    color: black; /* Couleur par défaut */
    transition: color 0.3s ease; /* Transition douce */
}

.fa-angle-double-down:hover {
    color: red; /* Couleur au survol */
}

</style>
<div class="row justify-content-center align-items-center">
    <div class="dd col-md-10 text-center">
    <h2>Bienvenue sur notre site d'entretien en ligne</h2>
    <h5>Nous vous invitons de repondre a nos question pour simplifier le processus de recrutement.</h5>
    <h5> Cliquez ici pour commencer votre entretien</h5>

    <h5><i class="fas fa-angle-double-down"></i></h5>
    <a href={{ route('entretien.getListe', ['id_user' => auth()->user()->id ]) }}><button class="butt btn btn-primary">Commencer</button></a>
    </div>
</div>
@endsection