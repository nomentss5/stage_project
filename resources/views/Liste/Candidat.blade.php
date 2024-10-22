@extends('layoutsAdmin.app')
@section('contents')

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center" >Liste des Candidats</h4>
                <div class="col-sm-3">
                                   
                  <form action="{{ route('candidat.recherche')}}" method="GET">
                  
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Taper un nom ou specialisation..." name="recherche_texte"
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="button" value="recherche">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                     </div>
                  </div>
                </div> 
                <br> 
                <div class="col-md-12">
                  <div class="form-group row">
                      <div class="col-sm-3">
                        <label>Date postule </label>
                        <select class="custom-select" name="ordre">
                          <option {{ session('selected_order') == 'plus recent' ? 'selected' : '' }}>plus recent</option>
                          <option {{ session('selected_order') == 'plus ancien' ? 'selected' : '' }}>plus ancien</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <label>Statut </label>
                        <select class="custom-select" name="statu">
                          <option>Tout</option>
                          @foreach($statu as $s)
                          <option value="{{ $s->nom }}" {{ session('selected_statu') == $s->nom ? 'selected' : '' }}>{{ $s->nom}} </option>
                          @endforeach
                        </select>
                      </div>
                      {{-- <div class="col-sm-3">
                        <label>Poste postule </label>
                        <select class="custom-select" name="poste_postule">
                          <option {{ session('selected_poste') == 'Tout' ? 'selected' : '' }}>Tout</option>
                          <option {{ session('selected_poste') == 'RH' ? 'selected' : '' }}>RH</option>
                          <option {{ session('selected_poste') == 'Securite' ? 'selected' : '' }}>Securite</option>
                          <option {{ session('selected_poste') == 'Comptabilite' ? 'selected' : '' }}>Comptabilite</option>
                          <option {{ session('selected_poste') == 'Magasinier' ? 'selected' : '' }}>Magasinier</option>
                          <option {{ session('selected_poste') == 'Autres' ? 'selected' : '' }}>Autres</option>
                        </select>
                      </div> --}}

                      <div class="col-sm-3">
                        <label>Poste postule </label>
                        <select class="custom-select" name="poste_postule">
                          <option  {{ session('selected_poste') == 'Tout' ? 'selected' : '' }}> Tout</option>
                          @foreach ($poste as $postes)
                            <option  {{ session('selected_poste') == $postes->nom ? 'selected' : '' }}>{{ $postes->nom }}</option>
                          @endforeach
                          {{-- <option  {{ session('selected_poste') == 'Autres' ? 'selected' : '' }}> Autres</option> --}}
                        </select>
                      </div>

                    
                    <div class="col-sm-3">
                      <br>
                      <div class="input-group" style="margin-left: 30%; margin-top: 8px">
                        {{-- <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2"> --}}
                        {{-- <div class="input-group-append"> --}}
                          <button class="btn btn-primary" type="submit" name="button" value="filtre">
                            Filtrer <i class="fas fa-search fa-sm"></i>
                          </button>
                          {{-- </div>
                            --}}
                      </div>
                    </div>  
                  </div>
                      
                  </form>
                </div>
                <br>
                @if(session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                @endif
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                      <tr >
                        <th>Nom</th>
                        {{-- <th>Specialisation</th> --}}
                        <th>Poste demande</th>
                        <th>Date de postulations</th>
                        <th>Statut</th>
                        
                        {{-- <th>Voir Cv</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($candidats as $candidat)
                          <tr>
                            <td><a href="{{route('candidat.cv', ['id' => $candidat->id]) }}">{{ $candidat->nom }}</a></td>
                            {{-- <td>{{ $candidat->specialisation}}</td> --}}
                            <td>{{ $candidat->poste_postule}}</td>
                            <td>{{ $candidat->date_postule}}</td>
                            <td><label class="badge {{ $candidat->nom_statu == 'En cours' ? 'badge-info' : '' }}
                                  {{ $candidat->nom_statu == 'Embauche' ? 'badge-success' : '' }}
                                  {{ $candidat->nom_statu == 'Debauche' ? 'badge-danger' : '' }}">

                                  <a href={{ route('candidat.formulaire_statu', ['id' => $candidat->id, 'statu' => $candidat->nom_statu] ) }} style="text-decoration: none; color:white">{{ $candidat->nom_statu }}</a>
                                </label>
                            </td>
                            <td><a href={{route('candidat.modifier', ['id' => $candidat->id]) }}><i class="fas fa-edit"></i></a></td>
                            <td><a href={{ route('email.getmail', ['id' => $candidat->id]) }}><i class="fas fa-envelope-square"></i></a></td>
                          </tr>
                      @endforeach
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>
    <div>
      {{ $candidats->links() }}
    </div>
@endsection