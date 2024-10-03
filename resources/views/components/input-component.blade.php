<div class="{{ $colClass }}">
    <div class="mb-3">
        <label for="name" class="form-label">{{ $labelText }}</label>
        <input class="form-control" name="{{ $name }}" type="{{ $type }}"
               value="{{ $data == null ? old('name') : $data->name }}" id="{{ $id }}">
    </div>
</div>
