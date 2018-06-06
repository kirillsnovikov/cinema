<label for="">Статус</label>
<select class="form-control" name="published">
	
	@if (isset($category->id))
	
	<option value="0" @if($category->published == 0) selected="" @endif>Не опубликовано</option>
	<option value="1" @if($category->published == 1) selected="" @endif>Опубликовано</option>
	
	@else
	
	<option value="0">Не опубликовано</option>
	<option value="1">Опубликовано</option>
	
	@endif
	
</select>

<label for="">Название</label>
<input class="form-control" type="text" placeholder="Заголовок категории" name="title" value="{{$category->title or ''}}" required/>

<label for="">Slug</label>
<input class="form-control" type="text" placeholder="Автоматическая генерация" name="slug" value="{{$category->slug or ''}}" readonly/>

<label for="">Родительская категория</label>
<select class="form-control" name="parent_id">
	
	<option value="0">Без родительской категории</option>
	
	@include('admin.category.particles.list')
	
</select>

<input class="btn btn-primary" type="submit" value="Сохранить"/>