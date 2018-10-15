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
        <div class="border border-secondary rounded my-2 px-2">
            <p>Использовать данные из файлов</p>
            <div class="form-check">
                <input class="form-check-input" name="use_proxy" value="socks4" type="radio">
                <label class="form-check-label" for="">Использовать socks4</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="use_proxy" value="socks5" type="radio">
                <label class="form-check-label" for="">Использовать socks5</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="use_proxy" value="https" type="radio">
                <label class="form-check-label" for="">Использовать https</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="use_urls" type="checkbox" checked>
                <label class="form-check-label" for="">Использовать URLs</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="use_user_agent" type="checkbox">
                <label class="form-check-label" for="">Использовать UserAgents</label>
            </div>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="attr" type="checkbox" value="path" checked>
            <label class="form-check-label" for="">Скрытое поле 1(Токен)</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="engine_code_link" type="checkbox" value="path">
            <label class="form-check-label" for="">Attributes Engine</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="engine_model_name" type="checkbox" value="path">
            <label class="form-check-label" for="">Model Name</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="engine_code_name" type="checkbox" value="path" checked>
            <label class="form-check-label" for="">Код двигателя</label>
        </div>
        <!--<label class="col-form-label" for="">ID Кинопоиска</label>
        <div class="row">
            <input class="form-control" type="number" placeholder="От" name="kp_id" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
            <input class="form-control" type="number" placeholder="До" name="kp_id" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
        </div>-->
    </div>
</div>

<input class="btn btn-success" type="submit" value="Начать парсить..."/>
<a href="{{route('admin.parser.autodata.index')}}" class="btn btn-outline-success">Отмена</a>