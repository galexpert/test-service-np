
@extends('layouts.masterb5')

@section('content')



    <div id="app">

        <div class="container">



            @if(isset($cities))
                <cost-delivery-component
                    :cities="{{json_encode($cities)}}"
                    trans1="{{ __('front.global.calculate_shipping_cost') }}"
                    trans2 = "{{ __('front.global.from') }}"
                    trans3 = "{{ __('front.global.to') }}"
                    trans4 = "{{ __('front.global.shipping_cost') }}"
                    trans5 = "{{ __('front.global.calculate_cost') }}"
                    trans6 = "{{ __('front.global.chosen_locality') }}"
                    trans7 = "{{ __('front.global.post_office') }}"
                    trans8 = "{{ __('front.global.parcel_price') }}"
                ></cost-delivery-component>
            @endif
        </div>
    </div>




@endsection


