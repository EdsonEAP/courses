@props(['options', 'selected', 'dishId', 'changeMethod'])

<div>
    <select class="rounded-lg" wire:change="{{ $changeMethod }}($event.target.value, {{ $dishId }})">
        @foreach ($options as $id => $name)
        <option value="{{ $id }}" {{ $id == $selected ? 'selected' : '' }}>
        {{ $name }}
        </option>
        @endforeach
    </select>
</div>
