<label for="">Статус</label>
<select class="form-control" name="published">
	
	@if (isset($article->id))
	
	<option value="0" @if($article->published == 0) selected="" @endif>Не опубликовано</option>
	<option value="1" @if($article->published == 1) selected="" @endif>Опубликовано</option>
	
	@else
	
	<option value="0">Не опубликовано</option>
	<option value="1">Опубликовано</option>
	
	@endif
	
</select>

<label for="">Заголовок</label>
<input class="form-control" type="text" placeholder="Заголовок новости" name="title" value="{{$article->title or ''}}" required/>

<label for="">Slug</label>
<input class="form-control" type="text" placeholder="Автоматическая генерация" name="slug" value="{{$article->slug or ''}}" readonly/>

<label for="">Родительская категория</label>
<select class="form-control" name="categories[]" multiple>
	
	@include('admin.article.particles.list')
	
</select>

<label for="">Файл</label>
<input class="form-control" type="file" name="file" value="{{$article->image or ''}}"/>

<label for="">Краткое описание</label>
<textarea  class="form-control" name="description_short" id="description_short">{{$article->description_short or ''}}</textarea>

<label for="">Описание</label>
<textarea  class="form-control" name="description" id="description" rows="7">{{$article->description or ''}}</textarea>

<label for="">Мета заголовок</label>
<input class="form-control" type="text" placeholder="Мета заголовок" name="meta_title" value="{{$article->meta_title or ''}}"/>

<label for="">Мета описание</label>
<input class="form-control" type="text" placeholder="Мета описание" name="meta_description" value="{{$article->meta_description or ''}}"/>

<label for="">Ключевые слова</label>
<input class="form-control" type="text" placeholder="Ключевые слова" name="meta_keyword" value="{{$article->meta_keyword or ''}}"/>

<input class="btn btn-primary" type="submit" value="Сохранить"/>