@extends('layouts.app1')
@section('title', 'Customer Information')

@section('content')
    @livewire('customer.view', [
        'customer_id' => $id,
    ])
@endsection
