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
            <label class="col-form-label" for="">Socks4</label>
            <div class="col">
                <input class="form-control-file p-2" type="file" name="socks4"/>
            </div>
        </div>
        <div class="form-row">
            <label class="col-form-label" for="">Socks5</label>
            <div class="col">
                <input class="form-control-file p-2" type="file" name="socks5"/>
            </div>
        </div>
        <div class="form-row">
            <label class="col-form-label" for="">Https</label>
            <div class="col">
                <input class="form-control-file p-2" type="file" name="https"/>
            </div>
        </div>
    </div>
</div>

<input class="btn btn-success" type="submit" value="Прочекать..."/>
<a href="{{route('admin.parser.index')}}" class="btn btn-outline-success">Отмена</a>