@php
    $unitTypes = [
        'transporter' => Koodilab\Models\Unit::TYPE_TRANSPORTER,
    ];
@endphp
<trade :is-enabled="isEnabled && isSelectedTab('trade')"
       :building="building"
       :grid="grid"
       :close="close"
       :mined="mined"
       :planet="planet"
       :data="data"
       store-url="{{ route('api_movement_trade_store', '__grid__') }}"
       :unit-types='@json($unitTypes)' inline-template>
    <div v-if="isEnabled" class="trade">
        @include('partials.transport')
    </div>
</trade>
