@extends('layouts.app') 
@section('content')
<div class="row justify-content-center">
    <h2>{{ __('links.projectcalls') }}</h2>
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <td>ID</td>
                <td>Type</td>
                <td>Année</td>
                <td>Période de candidature</td>
                <td>Période d'évaluation</td>
                <td>Créateur</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach($projectcalls as $call)
            <tr>
                <td>{{$call->id}}</td>
                <td>{{ \App\Enums\CallType::getKey($call->type) }}</td>
                <td>{{$call->year}}</td>
                <td>{{$call->application_start_date}} - {{$call->application_end_date}}</td>
                <td>{{$call->evaluation_start_date}} - {{$call->evaluation_end_date}}</td>
                <td>{{$call->creator->name}}</td>
                <td>
                    <a href="{{ route('projectcall.edit',$call->id)}}" class="btn btn-primary d-inline-block">Edit</a>
                    <form action="{{ route('projectcall.destroy', $call->id)}}" method="post">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-12">
        <a href="{{ route('projectcall.create')}}" class="btn btn-primary">Create</a>
    </div>
</div>
@endsection