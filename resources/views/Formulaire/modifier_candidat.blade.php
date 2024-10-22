@extends('layoutsAdmin.app')
@section('contents')

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title" style="text-align: center">Formulaire de modification</h4>
        {{-- <form action="#" method="POST">
          <div class="row">
            <label class="col-sm-3 col-form-label" >Statu du candidat</label>
            <div class="col-md-6">
              <div class="input-group">
                  <select class="custom-select" id="inputGroupSelect04" >
                    @foreach ($statu_select as $statu)
                      <option value="{{ $statu->id }}" style="color: rgb(0, 0, 0)" >{{ $statu->nom }}</option>
                    @endforeach
                  </select>
                  <div class="input-group-append">
                    <a href="#"><button class="btn btn-outline-warning" type="button">Modifier son statu</button></a>
                  </div>
                </div>
              </div>
            </div>
            <br>
          </form> --}}
          <form action="{{ route('candidat.update')}}" method="POST">
          @csrf
        <input type="hidden" name="id" value="{{ $candidat->id }}" />
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nom du Candidat</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nom" value="{{ $candidat->nom }}"/>
                </div>
                <label style="margin-left: 45%">
                  @error('nom')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Specialisation</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="specialisation" value="{{ $candidat->specialisation }}"/>
                </div>
              </div>                  
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 ">Postule pour poste</label>
                    <div class="col-sm-9">
                      <select class="custom-select" name="poste_postule">
                        @foreach ($poste as $postes)
                          <option value={{ $postes->id }}>{{ $postes->nom }}</option>
                        @endforeach
                      </select>
                    </div>
                </div>                          
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Postulé le</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date_postule" value="{{ old('date', $candidat->date_postule) }}" />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Mail</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="email" value="{{ $candidat->email}}"/>
                </div>
                <label style="margin-left: 50%">
                  @error('email')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>                  
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Telephone</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="telephone" value="{{ $candidat->telephone }}"/>
                </div>
                <label style="margin-left: 50%">
                  @error('telephone')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
              </div>
            </div>
          </div>
          <br>
          {{-- <p class="card-description"> Address </p> --}}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Adresse</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="adresse" value="{{ $candidat->adresse}}" />
                </div>
                <label style="margin-left: 50%">
                  @error('adresse')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Genre</label>
                <div class="col-sm-9">
                  <select class="custom-select" name="genre">
                    <option>Homme</option>
                    <option>Femme</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nationalité</label>
                  <div class="col-sm-9">
                      <select class="custom-select" name="nationalite">
                      <option>Malagasy</option>
                      <option>Francais</option>
                      <option>Congolais</option>
                      </select>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Date de naissance</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date_naissance" value="{{ old('date', $candidat->date_naissance) }}" />
                </div>
                <label style="margin-left: 50%">
                  @error('date_naissance')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Diplome et formation</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="formation_diplome">{{$candidat->formation_diplome}}</textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('formation_diplome')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Experience pro</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="experience_pro">{{$candidat->experience_pro}}</textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('experience_pro')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Competence</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="competence">{{$candidat->competence}}</textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('competence')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Qualite</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="qualite">{{$candidat->qualite}}</textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('qualite')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Centre d'interet</label>
                  <div class="col-sm-6">
                    <textarea class="form-control" aria-label="With textarea" name="centre_interet">{{$candidat->centre_interet}}</textarea>
                  </div>
              </div>
            </div>
  
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-12 col-form-label">Langues</label>
                {{-- <label class="col-sm-3 col-form-label">Langues</label> --}}
                @foreach ($liste as $langue)
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="langue[]"  value="{{ $langue->id }}" {{ in_array($langue->id, $candidatLangues) ? 'checked' : '' }}> {{ $langue->name }} </label>
                    </div>
                  </div> 
                @endforeach
                </div>
                <label style="margin-left: 25%">
                  @error('langue')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
            </div>
          </div>
      </div>
    </div>
    <button type="submit" class="btn btn-outline-success btn-lg btn-block">Mettre à jour</button>
  </form>
  </div>
</div>
@endsection