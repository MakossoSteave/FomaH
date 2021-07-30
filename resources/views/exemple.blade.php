<div class="control has-icons-left">
      <div class="select">
      <div class="select is-info">
        <select>
          <option selected >Sélectionner une catégorie</option>
          @foreach($categories as $key => $categorie)
           <option value="{{$key}}"> {{$categorie}}</option>
          @endforeach
        </select>
      </div>
      </div>
      <div class="icon is-small is-left">
      <i class="fa fa-certificate " aria-hidden="true" style=color:#0080FF></i>
      </div>
    </div>

    <div class="select is-link">
  <select>
    <option>Select dropdown</option>
    <option>With options</option>
  </select>
</div>
    <!-- <i class="fa fa-certificate " aria-hidden="true" style=color:#0080FF></i> -->
    <!-- fa-lg fa-2x fa-3x fa-4x fa-5x -->
    <!-- <div class="control has-icons-left  select is-info" > -->
    <!-- color:#0080FF bleu -->
    <!-- color:#FF8000 jaune orange -->