<div class="container">
    <h2>Laravel 8 Dynamic Dependent Dropdown using Jquery Ajax</h2>
        <div class="form-group">
                <label for="country">Country:</label>
                <select id="country" name="category_id" class="form-control">
                <option value="" selected disabled>Select Country</option>
                @foreach($countries as $key => $country)
                <option value="{{$key}}"> {{$country}}</option>
                @endforeach
                </select>
        </div>

        <div class="form-group">
            <label for="state">State:</label>
            <select name="state" id="state" class="form-control"></select>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <select name="city" id="city" class="form-control"></select>
        </div>

</div>