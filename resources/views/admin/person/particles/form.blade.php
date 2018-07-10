<div class="form-group row">
    <div class="col">
        <input class="form-control mb-3" type="text" placeholder="Имя" name="firstname" value="{{$person->firstname or ''}}" required/>
        <input class="form-control mb-3" type="text" placeholder="Фамилия" name="lastname" value="{{$person->lastname or ''}}" />
        <input class="form-control mb-3" type="text" placeholder="Фамильная приставка" name="lastneme_prefix" value="{{$person->lastneme_prefix or ''}}" />
        <input class="form-control mb-3" type="text" placeholder="Среднее(второе) имя" name="middlename" value="{{$person->middlename or ''}}" />
        <input class="form-control mb-3" type="text" placeholder="Третье имя" name="middlename_second" value="{{$person->middlename_second or ''}}" />
        <input class="form-control mb-3" type="text" placeholder="Четвертое имя" name="middlename_third" value="{{$person->middlename_third or ''}}" />
        <input class="form-control mb-3" type="text" placeholder="Пятое имя" name="middlename_fourth" value="{{$person->middlename_fourth or ''}}" />
    </div>
    <div class="col">
        <select class="form-control mb-3" name="published">

            @if (isset($person->id))

            <option value="0" @if($person->published == 0) selected="" @endif>Не опубликовано</option>
            <option value="1" @if($person->published == 1) selected="" @endif>Опубликовано</option>

            @else

            <option value="0">Не опубликовано</option>
            <option value="1">Опубликовано</option>

            @endif

        </select>
        <input class="form-control-file form-control-lg" type="file" name="image" value="{{$person->image_name or ''}}"/>

        <div class="row mb-3">
            <label class="col-form-label col-4" for="">Дата рождения</label>
            <div class="col">
                <input class="form-control" type="date" name="date_birth" value="{{$person->date_birth or ''}}"/>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-form-label col-4" for="">Дата смерти</label>
            <div class="col">
                <input class="form-control" type="date" name="date_death" value="{{$person->date_death or ''}}"/>
            </div>
        </div>

        <input class="form-control mb-3" type="number" placeholder="Рост" name="tall" min="0.1" max="3" step="0.01" value="{{$person->tall or ''}}"/>
        <select class="form-control mb-3" name="sex">

            @if (isset($person->id))

            <option value="0" @if($person->sex == 0) selected="" @endif>Мужской</option>
            <option value="1" @if($person->sex == 1) selected="" @endif>Женский</option>

            @else

            <option value="0">Мужской</option>
            <option value="1">Женский</option>

            @endif

        </select>
        <input class="form-control mb-3" type="number" placeholder="Кинопоиск ID" name="kp_id" min="1" step="1" value="{{$person->kp_id or ''}}" required/>
    </div>
</div>

<div class="form-group">
    <label for="">Slug</label>
    <input class="form-control" type="text" placeholder="Автоматическая генерация" name="slug" value="{{$person->slug or ''}}" readonly/>
</div>

<div class="form-group row">
    <div class="col-6">
        <label for="">Профессия</label>
        <select class="form-control" name="professions[]" multiple>

            @include('admin.person.particles.professions')

        </select>
    </div>
    <!--    <div class="col-6">
            <label for="">Страна</label>
            <select class="form-control" name="countries[]" multiple>
    
                
    
            </select>
        </div>-->
</div>

<div class="form-group">
    <label for="">Краткое описание</label>
    <textarea  class="form-control" name="description_short" id="description_short">{{$person->description_short or ''}}</textarea>
</div>

<div class="form-group">
    <label for="">Описание</label>
    <textarea  class="form-control" name="description" id="description" rows="7">{{$person->description or ''}}</textarea>
</div>

<div class="form-group">
    <label for="">Мета заголовок</label>
    <input class="form-control" type="text" placeholder="Мета заголовок" name="meta_title" value="{{$person->meta_title or ''}}"/>
</div>

<div class="form-group">
    <label for="">Мета описание</label>
    <input class="form-control" type="text" placeholder="Мета описание" name="meta_description" value="{{$person->meta_description or ''}}"/>
</div>

<div class="form-group">
    <label for="">Ключевые слова</label>
    <input class="form-control" type="text" placeholder="Ключевые слова" name="meta_keyword" value="{{$person->meta_keyword or ''}}"/>
</div>

<input class="btn btn-primary" type="submit" value="Сохранить"/>