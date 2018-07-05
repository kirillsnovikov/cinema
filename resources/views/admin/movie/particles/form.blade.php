<div class="form-group row">
    <div class="col-6">
        <label for="">Статус</label>
        <select class="form-control" name="published">

            @if (isset($movie->id))

            <option value="0" @if($movie->published == 0) selected="" @endif>Не опубликовано</option>
            <option value="1" @if($movie->published == 1) selected="" @endif>Опубликовано</option>

            @else

            <option value="0">Не опубликовано</option>
            <option value="1">Опубликовано</option>

            @endif

        </select>
    </div>
    <div class="col-6">
        <label for="">Постер</label>
        <input class="form-control-file" type="file" name="image" value="{{$movie->image_name or ''}}"/>
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label for="">Название фильма</label>
        <input class="form-control" type="text" placeholder="Название фильма" name="title" value="{{$movie->title or ''}}" required/>
    </div>
    <div class="col-6">
        <label for="">Название оригинал</label>
        <input class="form-control" type="text" placeholder="Оригинальное название (если есть)" name="title_eng" value="{{$movie->title or ''}}"/>
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label class="col-form-label" for="">KP_raiting</label>
        <input class="form-control" type="text" placeholder="Рейтинг КП" name="kp_raiting" value="{{$movie->kp_raiting or ''}}"/>
    </div>
    <div class="col-6">
        <label class="col-form-label" for="">ImDB_raiting</label>
        <input class="form-control" type="text" placeholder="Рейтинг ImDB" name="imdb_raiting" value="{{$movie->imdb_raiting or ''}}"/>
    </div>
</div>

<div class="form-group row">
    <div class="col-4">
        <label class="col-form-label" for="">Год выпуска</label>
        <input class="form-control" type="text" placeholder="Год" name="year" value="{{$movie->year or ''}}"/>
    </div>
    <div class="col-4">
        <label class="col-form-label" for="">Продолжительность</label>
        <input class="form-control" type="text" placeholder="Минуты" name="duration" value="{{$movie->duration or ''}}"/>
    </div>
    <div class="col-4">
        <label class="col-form-label" for="">ID Кинопоиска</label>
        <input class="form-control" type="text" placeholder="Номер" name="kp_id" value="{{$movie->kp_id or ''}}"/>
    </div>
</div>

<div class="form-group">
    <label for="">Slug</label>
    <input class="form-control" type="text" placeholder="Автоматическая генерация" name="slug" value="{{$movie->slug or ''}}" readonly/>
</div>

<div class="form-group row">
    <div class="col-6">
        <label for="">Жанр</label>
        <select class="form-control" name="genres[]" multiple>

            @include('admin.movie.particles.list')

        </select>
    </div>
    <div class="col-6">
        <label for="">Страна</label>
        <select class="form-control" name="countries[]" multiple>

            @include('admin.movie.particles.list')

        </select>
    </div>
</div>

<div class="form-group">
    <label for="">Краткое описание</label>
    <textarea  class="form-control" name="description_short" id="description_short">{{$movie->description_short or ''}}</textarea>
</div>

<div class="form-group">
    <label for="">Описание</label>
    <textarea  class="form-control" name="description" id="description" rows="7">{{$movie->description or ''}}</textarea>
</div>

<div class="form-group">
    <label for="">Мета заголовок</label>
    <input class="form-control" type="text" placeholder="Мета заголовок" name="meta_title" value="{{$movie->meta_title or ''}}"/>
</div>

<div class="form-group">
    <label for="">Мета описание</label>
    <input class="form-control" type="text" placeholder="Мета описание" name="meta_description" value="{{$movie->meta_description or ''}}"/>
</div>

<div class="form-group">
    <label for="">Ключевые слова</label>
    <input class="form-control" type="text" placeholder="Ключевые слова" name="meta_keyword" value="{{$movie->meta_keyword or ''}}"/>
</div>

<input class="btn btn-primary" type="submit" value="Сохранить"/>