@extends('layoutsClient.app')
@section('contents')

<style>

h4{
 color: rgba(0, 0, 0, 0.607);
 text-align: left;
};

</style>
<div class="row">
  <div class="col-12 grid-margin">
    <div class="card-body">
        <form action="{{ route('entretien.save') }}" method="POST">
        @csrf

        @if(session()->has('success'))

        <h5 class="card-title" style="text-align: center">Veuillez remplir correctement cette fiche</h5>        
        <br>
        <div class="row">
            @for($i = 0; $i < count($result); $i++) 
                <div class="col-md-12">
                    <div class="form-group row">
                        <h5 class="col-sm-12">{{ $result[$i][0]['question'] }}</h5>
                        <input type="hidden" name="question[{{ $i }}]" value={{ $result[$i][0]['id_question'] }}>
                        <input type="hidden" name="id_poste" value={{ $result[$i][0]['id_poste'] }}>
                        @for ($j = 0; $j < count($result[$i]); $j++)
                            <div class="col-sm-12">
                                @if ($result[$i][$j]['reponse'] == null)
                                    <textarea class="form-control" aria-label="With textarea" name="reponse[{{ $i }}][{{ $j }}]">{{ old("reponse.$i.$j") }}</textarea>
                                    <label >
                                        @error("reponse.$i.$j")
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </label>
                                @else
                                    <div class="form-group row"> 
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="hidden" name="reponse[{{ $i }}][{{ $j }}]" value="0">
                                                    <input type="checkbox" class="form-check-input" name="reponse[{{ $i }}][{{ $j }}]"  value="{{ $result[$i][$j]['id_reponse'] }}/{{ $result[$i][$j]['reponse'] }}" {{ old("reponse.$i.$j") ? 'checked' : '' }}> {{ $result[$i][$j]['reponse'] }}
                                                </label>
                                                <label>
                                                    @error("reponse.$i.$j")    
                                                    <span style="color: red">{{ $message }}</span>
                                                    @enderror
                                                </label>
                                            </div>
                                        </div> 
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            @endfor

            <button type="submit" class="btn btn-outline-primary btn-lg btn-block">Soummetre </button>
        </div>

        @elseif(session()->has('entretenu'))

        <div class="row justify-content-center align-items-center">
            <div class="dd col-md-10 text-center">
                {{-- <h5 class="card-title" style="text-align: center">Merci pour votre reponse, votre fiche est en cours, nous allons vous rappeler plus tard, verifier votre mail et assurez vous d'etre joignable.</h5> --}}
                <h4 class="card-title" >Merci pour votre intérêt. Votre dossier est en cours de traitement et nous vous contacterons prochainement. Nous vous invitons à vérifier régulièrement votre messagerie et à vous assurer que vous êtes joignable.</h4>
            </div>

        @else

            <h4 class="card-title" style="text-align: center">Veuillez patienter vous allez recevoir bientot les questions...</h4>
        
        @endif

        </form>
    </div>
  </div>
</div>
<script>
  
  function confirmation() {
      return confirm('Êtes-vous sûr de vouloir supprimer ?');
  }

</script>
@endsection