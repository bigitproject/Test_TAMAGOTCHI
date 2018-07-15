@if($animals)

    @foreach($animals as $item)

        <div class="animal" data-idanimal="{{ $item->animal_type_id }}">

            <div class="row">
                <div class="col-2">
                    <div class="animal-img">
                        <img src="img/{{ $item->animal_type_id }}.jpg" class="rounded-circle" alt="...">
                    </div>
                </div>
                <div class="col-2">
                    <p  class="title hunger-title">
                        ГОЛОД
                    </p>
                    <p  class="title total" data-idhungeranimal="{{ $item->animal_type_id }}">
                        100
                    </p>
                    <button class="btn btn-primary mb-2 hunger" data-idanimal="{{ $item->animal_type_id }}">Накормить</button>
                </div>

                <div class="col-2">
                    <p  class="title hunger-title">
                        СОН
                    </p>
                    <p  class="title total" data-idsleepanimal="{{ $item->animal_type_id }}">
                        100
                    </p>
                    <button class="btn btn-primary mb-2 sleep" data-idanimal="{{ $item->animal_type_id }}">Приспать</button>
                </div>
                <div class="col-2">
                    <p  class="title hunger-title">
                        ЗАБОТА
                    </p>
                    <p  class="title total" data-idcareanimal="{{ $item->animal_type_id }}">
                        100
                    </p>
                    <button class="btn btn-primary mb-2 care" data-idanimal="{{ $item->animal_type_id }}">Позаботиться</button>
                </div>
                <div class="col-2">
                    <p  class="title hunger-title">
                        ВЕСЕЛЬЕ
                    </p>
                    <p  class="title total">
                        :)))
                    </p>
                    <button class="btn btn-primary mb-2 joy" data-idanimal="{{ $item->animal_type_id }}">Повеселить</button>
                </div>

            </div>

        </div>

    @endforeach

@endif