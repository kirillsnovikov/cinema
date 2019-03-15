<div class="form-group">
    <label for="">Статус</label>
    <select class="form-control" name="published">

        @if (isset($type->id))

        <option value="0" @if($type->published == 0) selected="" @endif>Не опубликовано</option>
        <option value="1" @if($type->published == 1) selected="" @endif>Опубликовано</option>

        @else

        <option value="0">Не опубликовано</option>
        <option value="1">Опубликовано</option>

        @endif

    </select>
</div>

<div class="form-group">
    <label for="">Название</label>
    <input class="form-control" type="text" placeholder="Заголовок жанра" name="title" value="{{$type->title or ''}}" required/>
</div>

<div class="form-group">
    <label for="">Slug</label>
    <input class="form-control" type="text" name="slug"
        @isset($type->slug)
            placeholder="Slug"
            value="{{$type->slug or 'err'}}"
            readonly
        @endisset
        placeholder="Slug"
        value="{{$type->slug or ''}}"
    />
</div>      

<div class="form-group">
    <label for="">Жанры</label>
    <select class="form-control" name="genres[]" multiple>

        <!--<option value="0">Без родительской категории</option>-->

        @include('admin.type.particles.genres')

    </select>
</div>

<input class="btn btn-primary" type="submit" value="Сохранить"/>
<a href="{{route('admin.type.index')}}" class="btn btn-outline-primary">Отмена</a>