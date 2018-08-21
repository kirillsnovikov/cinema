<div class="form-group row">
    <!--<div class="col-4">
        <label class="col-form-label" for="">Год выпуска</label>
        <input class="form-control" type="number" placeholder="Год" name="year" min="1" max="2100" step="1" value="{{$movie->year or ''}}"/>
    </div>
    <div class="col-4">
        <label class="col-form-label" for="">Продолжительность</label>
        <input class="form-control" type="number" placeholder="Минуты" name="duration" min="1" max="2100" step="1" value="{{$movie->duration or ''}}"/>
    </div>-->
    <div class="col-4">
        <div class="form-row">
            <label class="col-form-label" for="">ID Кинопоиска</label>
            <div class="col">
                <input class="form-control" type="number" placeholder="От" name="kp_id_from" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
            </div>
            <div class="col">
                <input class="form-control" type="number" placeholder="До" name="kp_id_to" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
            </div>
        </div>
        <div class="form-row">
            <label for="">Постер</label>
            <input class="form-control-file" type="file" name="image"/>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="name" type="checkbox" checked>
            <label class="form-check-label" for="">Имя</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="name_en" type="checkbox" checked>
            <label class="form-check-label" for="">Имя на Английском</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="tale" type="checkbox" checked>
            <label class="form-check-label" for="">Рост</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="birth_date" type="checkbox" checked>
            <label class="form-check-label" for="">Дата рождения</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="death_date" type="checkbox" checked>
            <label class="form-check-label" for="">Дата смерти</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="birth_place" type="checkbox" checked>
            <label class="form-check-label" for="">Место рождения</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="death_place" type="checkbox" checked>
            <label class="form-check-label" for="">Место смерти</label>
        </div>
        <!--<label class="col-form-label" for="">ID Кинопоиска</label>
        <div class="row">
            <input class="form-control" type="number" placeholder="От" name="kp_id" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
            <input class="form-control" type="number" placeholder="До" name="kp_id" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
        </div>-->
    </div>
</div>

<input class="btn btn-success" type="submit" value="Начать парсить..."/>
<a href="{{route('admin.parser.kinopoisk.index')}}" class="btn btn-outline-success">Отмена</a>