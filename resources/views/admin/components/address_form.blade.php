@php
    $address_line_1 = 'address_line_1';
    $address_line_2 = 'address_line_2';
    $suburb = 'suburb';
    $city = 'city';
    $state = 'state';
    $post_code = 'post_code';
    $country = 'country';

    if(isset($field_names)){
        $address_line_1 = $field_names['address_line_1'];
        $address_line_2 = $field_names['address_line_2'];
        $suburb = $field_names['suburb'];
        $city = $field_names['city'];
        $post_code = $field_names['post_code'];
        $country = $field_names['country'];
    }

    if(isset($field_values)){
        $address_line_1_value = old($address_line_1, $field_values[$address_line_1]);
        $address_line_2_value = old($address_line_2, $field_values[$address_line_2]);
        $suburb_value = old($suburb, $field_values[$suburb]);
        $city_value = old($city, $field_values[$city]);
        $post_code_value = old($post_code, $field_values[$post_code]);
        $country_value = old($country, $field_values[$country]);
    }
    else{
        $address_line_1_value = old($address_line_1);
        $address_line_2_value = old($address_line_2);
        $suburb_value = old($suburb);
        $city_value = old($city);
        $post_code_value = old($post_code);
        $country_value = old($country);
    }

@endphp

<div class="row">
    <div class="col-sm-12">
        <div class="input-group mb-4 @error($address_line_1) error @enderror">
            <div class="input-group-prepend">
                <span class="input-group-text text-secondary">
                  <i class="fas fa-map-marker-alt"></i>
                </span>
            </div>
            <input id="{{ $address_line_1 }}" name="{{ $address_line_1 }}" type="text" class="form-control" value="{{ $address_line_1_value }}" placeholder="{{ __('Address Line 1') }}" required>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group @error($address_line_2) error @enderror">
            <input id="{{ $address_line_2 }}" name="{{ $address_line_2 }}"  type="text" class="form-control" value="{{ $address_line_2_value }}" placeholder="{{ __('Address Line 2 (Optional)') }}" >
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group @error($suburb) error @enderror">
            <input id="{{ $suburb }}" name="{{ $suburb }}" type="text" class="form-control" value="{{ $suburb_value }}" placeholder="{{ __('Suburb') }}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group @error($city) error @enderror">
            <input id="{{ $city }}" name="{{ $city }}" type="text" class="form-control" value="{{ $city_value }}" placeholder="{{ __('City') }}" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group @error($post_code) error @enderror">
            <input id="{{ $post_code }}" name="{{ $post_code }}"  type="text" class="form-control" value="{{ $post_code_value }}" placeholder="{{ __('Post Code') }}" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group @error($country) error @enderror">
            <select id="{{ $country }}" name="{{ $country }}" class="form-control js-example-basic-single" required>
                <option value="BD" selected>Bangladesh</option>
            </select>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        !function(e){var s={licenceKey:"RUTWXK97DVCNGAL8436M",defaultCountryCode:"NZ",addressSelector:"#{{ $address_line_1 }}",suburbSelector:"#{{ $suburb }}",citySelector:"#{{ $city }}",stateSelector:"#{{ $state }}",postcodeSelector:"#{{ $post_code }}",countrySelector:"#{{ $country }}",widgetOptions:{AU:{address_params:{gnaf:1}},NZ:{address_params:{}},INT:{address_params:{}}},debugMode:!1};e.addEventListener("DOMContentLoaded",function(){if(e.querySelector(s.addressSelector)){var t=e.createElement("script");t.src="https://api.addressfinder.io/assets/generic/v1/address.js",t.async=!0,t.onload=function(){new Addressfinder.Address.BootHandler(s)},e.body.appendChild(t)}})}(document);
    </script>
@endpush
