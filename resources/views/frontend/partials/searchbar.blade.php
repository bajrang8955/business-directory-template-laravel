
<!-- Searchbar -->


<form action="{{ URL::to('search') }}" method="get">

<div id="searchbar">
  <div class="row">
    <div class="col-md-3 form-group"><input type="text" class="form-control" name="keyword" placeholder="Keyword" title="Keyword" value="{{ Input::get('keyword') }}"></div>
    <div class="col-md-2 form-group">
      <select class="form-control selectpicker" name="categories[]" title="Category" multiple>
        @foreach($main_categories as $cat)
        <optgroup label="{{$cat->name}}">
          @foreach($cat->children as $child)
            @if( is_array(Input::get('categories')) && in_array($child->id, Input::get('categories')))
              <option value="{{$child->id}}" selected>{{$child->name}}</option>
            @else
              <option value="{{$child->id}}">{{$child->name}}</option>
            @endif
          @endforeach
        </optgroup>
        @endforeach
      </select>
    </div>
    <div class="col-md-3 form-group">
        <input name="lat" type="hidden" value="{{ Input::get('lat') }}">
        <input name="lng" type="hidden" value="{{ Input::get('lng') }}">
        <input name="formatted_address" type="hidden" value="{{ Input::get('formatted_address') }}">
        <input id="placesearch" name="address" type="text" class="form-control" placeholder="City/ Suburb" title="City or Suburb" autocomplete="off" value="{{ Input::get('address') }}">
    </div>
    <div class="col-md-2 form-group">
      <select class="form-control selectpicker" name="radius" data-mobile="true" title="Radius">
        <option value="10" {{ (Input::get('radius') == "10")? "selected" : ""  }}>+ 10 km</option>
        <option value="20" {{ (Input::get('radius') == "20" or empty(Input::get('radius')))? "selected" : ""  }}>+ 20 km</option>
        <option value="30" {{ (Input::get('radius') == "30")? "selected" : ""  }}>+ 30 km</option>
        <option value="40" {{ (Input::get('radius') == "40")? "selected" : ""  }}>+ 40 km</option>
        <option value="60" {{ (Input::get('radius') == "60")? "selected" : ""  }}>+ 60 km</option>
        <option value="80" {{ (Input::get('radius') == "80")? "selected" : ""  }}>+ 80 km</option>
        <option value="100" {{ (Input::get('radius') == "100")? "selected" : ""  }}>+ 100 km</option>
      </select>

    </div>
    <div class="col-md-2 form-group">
      <button type="submit" id="btn-search" class="form-control btn btn-purple" title="Submit Search" data-loading-text="<i class='fa fa-spinner'></i> Search">Search</button>
    </div>
  </div>
</div>

</form>


@section('scripts')

{!! HTML::script('js/jquery.geocomplete.min.js') !!}

<script>

  function initSearch(){
    $("#placesearch").geocomplete({ details: "#searchbar" });
  }
  

  $( "#btn-search" ).click(function() {
      var $this = $(this);
      $this.button('loading');
      setTimeout(function() {
          $this.button('reset');
      }, 15000);
  });

</script>

@parent
@stop

