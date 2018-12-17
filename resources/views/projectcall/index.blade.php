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
                <td>État</td>
                <td>Calendrier</td>
                <td>Créateur</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach($projectcalls as $call)
            <tr>
                <td>{{$call->id}}</td>
                <td>{{ \App\Enums\CallType::getKey($call->type) }}</td>
                <td class="text-center">{{$call->year}}</td>
                <td class="text-center">@if ($call->closed) @svg('solid/door-closed') @else @svg('solid/door-open') @endif</td>
                <td>
                    <u>Candidatures :</u> {{$call->application_start_date}} - {{$call->application_end_date}}<br/>
                    <u>Évaluations :</u> {{$call->evaluation_start_date}} - {{$call->evaluation_end_date}}
                </td>
                <td>{{$call->creator->name}}</td>
                <td>
                    <a href="{{ route('projectcall.show',$call->id)}}" class="btn btn-primary d-inline-block">@svg('solid/search')&nbsp;{{ __('actions.show') }}</a>
                    <a href="{{ route('projectcall.edit',$call->id)}}" class="btn btn-warning d-inline-block">@svg('solid/edit')&nbsp;{{ __('actions.edit') }}</a>
                    <a href="{{ route('projectcall.destroy', $call->id)}}" class="btn btn-danger delete-link">@svg('solid/trash')&nbsp;{{ __('actions.delete') }}</a>
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.confirm_delete.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.confirm_delete.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" type="submit">{{ __('actions.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
 
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('.delete-link').click(function(e){
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            $("form#confirmation-form").attr('action', targetUrl);
            $(".modal#confirm-delete").modal();
        });
    });

</script>
@endsection