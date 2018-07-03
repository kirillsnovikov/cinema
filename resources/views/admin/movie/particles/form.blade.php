<div class="form-group">
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

<div class="form-group row">
    <div class="col-6">
        <label for="">Название фильма</label>
        <input class="form-control" type="text" placeholder="Название фильма" name="title" value="{{$movie->title or ''}}" required/>
    </div>
    <div class="col-6">
        <label for="">Название оригинал</label>
        <input class="form-control" type="text" placeholder="Оригинальное название (если есть)" name="title_eng" value="{{$movie->title or ''}}" required/>
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label class="col-form-label" for="">KP_raiting</label>
        <input class="form-control" type="text" placeholder="Рейтинг КП" name="kp_raiting" value="{{$movie->kp_raiting or ''}}" required/>
    </div>
    <div class="col-6">
        <label class="col-form-label" for="">ImDB_raiting</label>
        <input class="form-control" type="text" placeholder="Рейтинг ImDB" name="imdb_raiting" value="{{$movie->imdb_raiting or ''}}" required/>
    </div>
</div>

<div class="form-group">
    <label for="">Slug</label>
    <input class="form-control" type="text" placeholder="Автоматическая генерация" name="slug" value="{{$movie->slug or ''}}" readonly/>
</div>

<div class="form-group">
    <label for="">Жанр</label>
    <select class="form-control" name="genres[]" multiple>

        @include('admin.movie.particles.list')

    </select>
</div>

<label for="">Файл</label>
<input class="form-control" type="file" name="file" value="{{$movie->image or ''}}"/>

<label for="">Краткое описание</label>
<textarea  class="form-control" name="description_short" id="description_short">{{$movie->description_short or ''}}</textarea>

<label for="">Описание</label>
<textarea  class="form-control" name="description" id="description" rows="7">{{$movie->description or ''}}</textarea>

<label for="">Мета заголовок</label>
<input class="form-control" type="text" placeholder="Мета заголовок" name="meta_title" value="{{$movie->meta_title or ''}}"/>

<label for="">Мета описание</label>
<input class="form-control" type="text" placeholder="Мета описание" name="meta_description" value="{{$movie->meta_description or ''}}"/>

<label for="">Ключевые слова</label>
<input class="form-control" type="text" placeholder="Ключевые слова" name="meta_keyword" value="{{$movie->meta_keyword or ''}}"/>

<input class="btn btn-primary" type="submit" value="Сохранить"/>