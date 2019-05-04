@extends('layouts.app')

@section('content')
    <table-component :sortable="{{json_encode(['owner', 'name'])}}" :content="{{$locations->map(function(\App\Models\Location $row): array {
        return [
            'owner' => $row->owner->name,
            'name' => $row->name,
            'description' => $row->description,
            'address' => $row->address,
        ];
    })}}" />
@endsection
