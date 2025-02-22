<trainer :type="{{ Koodilab\Models\Building::TYPE_TRAINER }}"
          :building="building"
          :grid="grid"
          url="{{ route('api_trainer', '__grid__') }}"
          store-url="{{ route('api_trainer_store', ['__grid__', '__unit__']) }}"
          destroy-url="{{ route('api_trainer_destroy', '__grid__') }}" inline-template>
    <div v-if="isEnabled" class="trainer">
        <div class="modal-body separator">
            <div class="tab-content" v-if="data.units.length">
                <div v-for="unit in data.units" class="tab-pane" :class="{active: isSelected(unit)}">
                    @include('partials.unit')
                </div>
            </div>
        </div>
        <div class="modal-body separator">
            <ul class="nav nav-pills">
                <li class="nav-item" v-for="unit in data.units">
                    <a class="nav-link"
                       :class="{active: isSelected(unit)}"
                       href="#"
                       @click.prevent="select(unit)">
                        <span class="item item-sm" :class="unit | item('unit')">
                            @{{ unit.name }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</trainer>
