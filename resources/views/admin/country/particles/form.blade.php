<div class="form-group">
    <label for="">Статус</label>
    <select class="form-control" name="published">

        @if (isset($country->id))

        <option value="0" @if($country->published == 0) selected="" @endif>Не опубликовано</option>
        <option value="1" @if($country->published == 1) selected="" @endif>Опубликовано</option>

        @else

        <option value="0">Не опубликовано</option>
        <option value="1">Опубликовано</option>

        @endif

    </select>
</div>

<div class="form-group">
    <label for="">Название</label>
    <input class="form-control" type="text" placeholder="Страна" name="title" value="{{$country->title or ''}}" required/>
</div>

<div class="form-group">
    <label for="">Slug</label>
    <input class="form-control" type="text" placeholder="Автоматическая генерация" name="slug" value="{{$country->slug or ''}}" readonly/>
</div>

<input class="btn btn-primary" type="submit" value="Сохранить"/>