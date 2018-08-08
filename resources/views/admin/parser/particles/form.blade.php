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
                <input class="form-control" type="number" placeholder="От" name="kp_id" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
            </div>
            <div class="col">
                <input class="form-control" type="number" placeholder="До" name="kp_id" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
            </div>
        </div>
        <!--<label class="col-form-label" for="">ID Кинопоиска</label>
        <div class="row">
            <input class="form-control" type="number" placeholder="От" name="kp_id" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
            <input class="form-control" type="number" placeholder="До" name="kp_id" min="1" step="1" value="{{$movie->kp_id or ''}}"/>
        </div>-->
    </div>
</div>