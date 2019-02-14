@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.application.edit') }}</h2>
<h3 class="text-center">{{
    __('vocabulary.calltype_short.'.$application->projectcall->typeLabel) }} :
    {{$application->projectcall->year}}
</h3>
<h4 class="text-center">{{$application->projectcall->title}}</h4>
<p><u>{{ str_plural(__('fields.projectcall.application_period')) }} :</u> {{
    \Carbon\Carbon::parse($application->projectcall->application_start_date)->format(__('locale.date_format'))
    }}&nbsp;-&nbsp;{{
    \Carbon\Carbon::parse($application->projectcall->application_end_date)->format(__('locale.date_format')) }}
    <br />
    <u>{{ str_plural(__('fields.projectcall.evaluation_period')) }} :</u> {{
    \Carbon\Carbon::parse($application->projectcall->evaluation_start_date)->format(__('locale.date_format'))
    }}&nbsp;-&nbsp;{{
    \Carbon\Carbon::parse($application->projectcall->evaluation_end_date)->format(__('locale.date_format')) }}
</p>

<form method="POST" action="{{ route('application.update', $application->id) }}" id="application_form" enctype="multipart/form-data">
    @csrf @method("PUT")
    {{-- SECTION 1 : Infos Générales --}}
    <h2 class="text-center font-weight-bold border border-secondary rounded" id="form-section-1">{{
        __('fields.application.form.section_1') }}</h2>
    @include('forms.textinput', [
    'name' => 'title',
    'label' => __('fields.application.title.'.$application->projectcall->typeLabel),
    'value' => old('title', $application->title)
    ])

    @include('forms.textinput', [
    'name' => 'acronym',
    'label' => __('fields.application.acronym'),
    'value' => old('acronym', $application->acronym)
    ])

    @include('forms.subform', [
    'name' => 'carrier_id',
    'label' => __('fields.application.carrier.'.$application->projectcall->typeLabel),
    'value' => old('carrier', $application->carrier),
    'fields' => [
    [
    'type' => 'textinput',
    'name' => 'carrier_last_name',
    'label' => __('fields.last_name'),
    'valueField' => 'last_name'
    ],
    [
    'type' => 'textinput',
    'name' => 'carrier_first_name',
    'label' => __('fields.first_name'),
    'valueField' => 'first_name'
    ],
    [
    'type' => 'textinput',
    'name' => 'carrier_status',
    'label' => __('fields.carrier.status'),
    'valueField' => 'status'
    ],
    [
    'type' => 'textinput',
    'name' => 'carrier_email',
    'label' => __('fields.email'),
    'valueField' => 'email'
    ],
    [
    'type' => 'textinput',
    'name' => 'carrier_phone',
    'label' => __('fields.phone'),
    'valueField' => 'phone'
    ]
    ]
    ])
    @foreach(range(1,\App\Setting::get('max_number_of_laboratories')) as $index => $iteration)
    @include('forms.selectorother', [
    'name' => 'laboratory_id_'.$iteration,
    'label' => __('fields.application.laboratory_'.($iteration == 1 ? 1 : 'n'), ['index' => $iteration]),
    'allowedValues' => $laboratories,
    'allowNone' => true,
    'displayField' => 'name',
    'valueField' => 'id',
    'value' => old('laboratory_'.$iteration, count($application->laboratories) >= $iteration ?
    $application->laboratories[$index]->id : 'none'),
    'fields' => [
    [
    'type' => 'textinput',
    'name' => 'laboratory_name_'.$iteration,
    'label' => __('fields.name'),
    'valueField' => 'name'
    ],
    [
    'type' => 'textinput',
    'name' => 'laboratory_unit_code_'.$iteration,
    'label' => __('fields.laboratory.unit_code'),
    'valueField' => 'unit_code'
    ],
    [
    'type' => 'textinput',
    'name' => 'laboratory_director_email_'.$iteration,
    'label' => __('fields.laboratory.director_email'),
    'valueField' => 'director_email'
    ],
    [
    'type' => 'textinput',
    'name' => 'laboratory_regency_'.$iteration,
    'label' => __('fields.laboratory.regency'),
    'valueField' => 'regency'
    ],
    [
    'type' => 'textinput',
    'name' => 'laboratory_contact_name_'.$iteration,
    'label' => __('fields.laboratory.contact_name'),
    'valueField' => 'contact_name'
    ]
    ]
    ])
    @endforeach
    @if($application->projectcall->type != \App\Enums\CallType::Workshop)
    {{-- Not workshop --}}
    @include('forms.textinput', [
    'name' => 'duration',
    'label' => __('fields.application.duration'),
    'value' => old('duration', $application->duration)
    ])
    @else
    {{-- Workshop --}}
    @include('forms.multipleinput', [
    'name' => 'target_date',
    'input' => [
        'type' => 'date'
    ],
    'type' =>'textinput',
    'label' => __('fields.application.target_date'),
    'value' => old('target_date', $application->target_date ?? []),
    'maximum_count' => \App\Setting::get('max_number_of_target_dates')
    ])
    @endif

    @include('forms.select', [
    'name' => 'study_fields',
    'label' => __('fields.application.study_fields'),
    'help' => __('fields.application.study_fields_help', ['max' => \App\Setting::get('max_number_of_study_fields')]),
    'allowedValues' => $study_fields,
    'allowNone' => true,
    'allowNew' => true,
    'multiple' => true,
    'maximum_count' => \App\Setting::get('max_number_of_study_fields'),
    'displayField' => 'name',
    'valueField' => 'id',
    'value' => old('study_fields', $application->studyFields->pluck('id')->all()),
    ])

    @if($application->projectcall->type == \App\Enums\CallType::Workshop)
    @include('forms.textarea', [
    'name' => 'theme',
    'label' => __('fields.application.theme'),
    'value' => old('theme', $application->theme)
    ])
    @endif

    @include('forms.textarea', [
    'name' => 'summary_fr',
    'label' => __('fields.application.summary_fr'),
    'value' => old('summary_fr', $application->summary_fr)
    ])
    @include('forms.textarea', [
    'name' => 'summary_en',
    'label' => __('fields.application.summary_en'),
    'value' => old('summary_en', $application->summary_en)
    ])

    @foreach(range(1,\App\Setting::get('max_number_of_keywords')) as $index => $iteration)
    @include('forms.textinput', [
    'name' => 'keyword_'.$iteration,
    'label' => __('fields.application.keyword_n', ['index' => $iteration]),
    'value' => old('keyword_'.$iteration, (count(is_array($application->keywords) ? $application->keywords :
    json_decode($application->keywords)) >= $iteration ?
    $application->keywords[$index] : '')),
    ])
    @endforeach

    {{-- SECTION 2 : Présentation scientifique --}}
    <h2 class="text-center font-weight-bold border border-secondary rounded" id="form-section-2">
        {{ __('fields.application.form.section_2.'.$application->projectcall->typeLabel) }}
    </h2>
    @include('forms.textarea', [
    'name' => 'short_description',
    'label' => __('fields.application.short_description.'.$application->projectcall->typeLabel),
    'value' => old('short_description', $application->short_description),
    'help' => __('fields.application.short_description_help')
    ])

    {{-- SECTION 3 : Budget --}}
    <h2 class="text-center font-weight-bold border border-secondary rounded" id="form-section-3">
        {{ __('fields.application.form.section_3.'.$application->projectcall->typeLabel) }}
    </h2>
    @include('forms.textinput', [
    'name' => 'amount_requested',
    'label' => __('fields.application.amount_requested'),
    'value' => old('amount_requested', $application->amount_requested),
    'type' => 'money',
    'help' => __('fields.application.amount_requested_help')
    ])
    @include('forms.textinput', [
    'name' => 'other_fundings',
    'label' => __('fields.application.other_fundings'),
    'value' => old('other_fundings', $application->other_fundings),
    'type' => 'money',
    'help' => __('fields.application.other_fundings_help')
    ])
    @include('forms.textinput', [
    'name' => 'total_expected_income',
    'label' => __('fields.application.total_expected_income'),
    'value' => old('total_expected_income', $application->total_expected_income),
    'type' => 'money',
    ])
    @include('forms.textinput', [
    'name' => 'total_expected_outcome',
    'label' => __('fields.application.total_expected_outcome'),
    'value' => old('total_expected_outcome', $application->total_expected_outcome),
    'type' => 'money',
    ])

    {{-- SECTION 4 : Fichiers --}}
    <h2 class="text-center font-weight-bold border border-secondary rounded" id="form-section-4">
        {{ __('fields.application.form.section_4') }}
    </h2>
    @foreach(["application"=>"Candidature", "financial"=>"Financier"] as $key => $value)
    @include('forms.filedownload', [
    'text' =>
    __('fields.application.template.prefix.'.$key).__('fields.application.template.suffix.'.$application->projectcall->typeLabel),
    'link' => route('download.template', [
    'form' => $value,
    'type' => $application->projectcall->typeLabel,
    'year' => $application->projectcall->year]),
    ])
    @endforeach

    @include('forms.fileupload', [
    'name' => 'application_form',
    'label' => __('fields.application.template.prefix.application'),
    'value' => $application->files->where('order', 1),
    'multiple' => false,
    'help' => true,
    'accept' => '.xls,.xlsx,.doc,.docx,.pdf'
    ])
    @include('forms.fileupload', [
    'name' => 'financial_form',
    'label' => __('fields.application.template.prefix.financial'),
    'value' => $application->files->where('order', 2),
    'multiple' => false,
    'help' => true,
    'accept' => '.xls,.xlsx'
    ])
    @include('forms.fileupload', [
    'name' => 'other_attachments',
    'label' => __('fields.application.other_attachments'),
    'value' => $application->files->whereNotIn('order', [1,2]),
    'multiple' => true,
    'help' => true,
    'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.zip,.rar,.tar'
    ])

    <hr />
    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3">
            <a href="{{ route('home') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
            <button type="submit" name="save" class="btn btn-primary">@svg('solid/save') {{ __('actions.save') }}</button>
            <a href="{{ route('application.submit', ['id' => $application->id]) }}" class="btn btn-success submission-link">@svg('solid/check')
                {{ __('actions.application.submit') }}</a>
        </div>
    </div>
</form>

<div class="modal fade" id="confirm-submission" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.application.confirm_submission.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.application.confirm_submission.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('PUT')
                    <button class="btn btn-danger" type="submit">{{ __('actions.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="error-submission" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('fields.error') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.application.confirm_submission.error_unsaved') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    var form_old;
    $(document).ready(function () {
        form_old = $("form#application_form").serialize();

        $('.submission-link').click(function (e) {
            e.preventDefault();
            var form_dirty = $("form#application_form").serialize();
            if (form_old === form_dirty) {
                var targetUrl = jQuery(this).attr('href');
                $("form#confirmation-form").attr('action', targetUrl);
                $(".modal#confirm-submission").modal();
            } else {
                $('.modal#error-submission').modal();
            }
        });
    });

</script>
@endpush
