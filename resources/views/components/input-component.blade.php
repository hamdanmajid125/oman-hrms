<div class="{{ $colClass }}">
    <div class="mb-3">
        <label for="name" class="form-label">{{ $labelText }} {!! $required ? '<span class="text-danger">*</span>' : '' !!}</label>
        <input class="form-control" name="{{ $name }}" type="{{ $type }}" {{ $required ? 'required' : '' }}
               value="{{ $value }}" id="{{ $id }}"> 
    </div>
</div>
